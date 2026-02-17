<?php
// Auth controller.
// Handles login session values and basic role checks.
// Keeps access rules in one place so pages stay consistent.

class AuthController {

    // Toggle this to false for local dev environments that do not have HTTPS.
    // In production, keep this true.
    const FORCE_HTTPS = true;

    // Strong defaults for session cookies.
    // Note: "secure" cookies will only be set over HTTPS.
    private static function configureSessionCookieParams() {
        $isHttps = self::isHttpsRequest();

        // PHP 7.3+ supports array options.
        if (PHP_VERSION_ID >= 70300) {
            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'secure' => $isHttps,
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
        }
    }

    // Start session only once.
    public static function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            self::configureSessionCookieParams();
            session_start();
        }
    }

    // Detect HTTPS even when behind a proxy / load balancer.
    public static function isHttpsRequest() {
        if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') return true;
        if (!empty($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443) return true;

        // Common reverse-proxy header.
        if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') {
            return true;
        }

        return false;
    }

    // Redirect HTTP -> HTTPS (secure pages only).
    public static function enforceHttps() {
        if (!self::FORCE_HTTPS) return;
        if (self::isHttpsRequest()) {
            // Add HSTS (only meaningful over HTTPS)
            header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
            return;
        }

        // Build redirect URL.
        $host = $_SERVER['HTTP_HOST'] ?? '';
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        if ($host === '') return;

        header('Location: https://' . $host . $uri, true, 302);
        exit;
    }

    // Hash a password using PHP's recommended algorithm.
    public static function hashPassword($plainTextPassword) {
        return password_hash((string)$plainTextPassword, PASSWORD_DEFAULT);
    }

    // Verify password against a stored hash.
    public static function verifyPassword($plainTextPassword, $storedHash) {
        if ($storedHash === null || $storedHash === '') return false;
        return password_verify((string)$plainTextPassword, (string)$storedHash);
    }

    // Support legacy plaintext passwords and upgrade them to a hash after a successful login.
    // $upgradeCallback should accept ($userIdNumber, $newHash) and return true/false.
    public static function verifyPasswordAndUpgradeIfNeeded($plainTextPassword, $storedValue, $userIdNumber, $upgradeCallback) {

        // Normal path: hashed password.
        if (self::verifyPassword($plainTextPassword, $storedValue)) {

            // If the algorithm changes in the future, upgrade the hash.
            if (password_needs_rehash($storedValue, PASSWORD_DEFAULT)) {
                $newHash = self::hashPassword($plainTextPassword);
                if (is_callable($upgradeCallback)) {
                    $upgradeCallback((int)$userIdNumber, $newHash);
                }
            }
            return true;
        }

        // Legacy fallback: plaintext stored in DB.
        if ((string)$storedValue === (string)$plainTextPassword) {
            $newHash = self::hashPassword($plainTextPassword);
            if (is_callable($upgradeCallback)) {
                $upgradeCallback((int)$userIdNumber, $newHash);
            }
            return true;
        }

        return false;
    }

    // Is anyone logged in.
    public static function isLoggedIn() {
        return isset($_SESSION["role"]) && isset($_SESSION["user_id"]);
    }

    // Return current role or empty string.
    public static function getRole() {
        if (!isset($_SESSION["role"])) return "";
        return (string)$_SESSION["role"];
    }

    // Return display name for header.
    public static function getDisplayName() {
        if (!isset($_SESSION["display_name"])) return "";
        return (string)$_SESSION["display_name"];
    }

    // Clear session and bounce to home.
    public static function logoutAndRedirect($redirectUrl) {
        self::startSession();

        $_SESSION = array();

        // Clear session cookie if it exists.
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), "", time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
        header("Location: " . $redirectUrl);
        exit;
    }

    // Basic role rules based on file name.
    // Admin pages: admin_*.php
    // Tech pages: technician_*.php
    // Customer pages: customer_*.php
    public static function enforcePageAccess($pageFileName, $homeHref, $viewPrefix) {

        self::startSession();

        // Public pages anyone can see.
        $publicPages = array(
            "index.php",
            "login.php",
            "register.php",
            "sitemap.php",
            "logout.php",
            "access_denied.php"
        );

        // Login/register should always be HTTPS even though they are public.
        if ($pageFileName === 'login.php' || $pageFileName === 'register.php') {
            self::enforceHttps();
        }

        if (in_array($pageFileName, $publicPages)) return;

        // Protected pages should always be HTTPS.
        self::enforceHttps();

        // If it's a protected page and user isn't logged in, send to login.
        if (!self::isLoggedIn()) {
            header("Location: " . $viewPrefix . "login.php");
            exit;
        }

        $role = self::getRole();

        // Extra page rules for pages that do not follow a prefix name.
        if ($pageFileName === "complaint_create.php") {
            if ($role !== "customer") {
                header("Location: " . $viewPrefix . "access_denied.php");
                exit;
            }
        }

        if ($pageFileName === "complaint_list.php") {
            if ($role !== "admin" && $role !== "tech") {
                header("Location: " . $viewPrefix . "access_denied.php");
                exit;
            }
        }

        // Admin pages.
        if (strpos($pageFileName, "admin_") === 0) {
            if ($role !== "admin") {
                header("Location: " . $viewPrefix . "access_denied.php");
                exit;
            }
        }

        // Technician pages.
        if (strpos($pageFileName, "technician_") === 0) {
            if ($role !== "tech" && $role !== "admin") {
                header("Location: " . $viewPrefix . "access_denied.php");
                exit;
            }
        }

        // Customer pages.
        if (strpos($pageFileName, "customer_") === 0) {
            if ($role !== "customer") {
                header("Location: " . $viewPrefix . "access_denied.php");
                exit;
            }
        }
    }

    // Convenience: enforce access rules for the current executing PHP file.
    // Useful for pages that process POST before including header.php.
    public static function enforceCurrentPageAccess() {
        self::startSession();

        $inViewFolder = (strpos($_SERVER["PHP_SELF"], "/view/") !== false);
        $viewPrefix = $inViewFolder ? "" : "view/";
        $pageFileName = basename($_SERVER["PHP_SELF"]);

        self::enforcePageAccess($pageFileName, "", $viewPrefix);
    }
}
?>