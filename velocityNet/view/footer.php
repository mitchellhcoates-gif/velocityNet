</main>

    <!-- Footer -->
    <footer class="border-t border-stone-800/50 mt-16 bg-[#0d0f0a]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="md:col-span-1">
                    <a href="<?php echo $homeHref; ?>" class="font-serif text-xl text-[#f5f3eb]">Complaints.</a>
                    <p class="mt-3 text-sm text-stone-500">
                        Customer support 
                    </p>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="text-sm font-medium text-stone-300 mb-4">Product</h4>
                    <ul class="space-y-2">
                        <li>
                            <a href="<?php echo $viewPrefix; ?>complaint_create.php" class="text-sm text-stone-500 hover:text-stone-300 transition-colors">
                                Submit Ticket
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $viewPrefix; ?>complaint_list.php" class="text-sm text-stone-500 hover:text-stone-300 transition-colors">
                                Track Status
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Resources -->
                <div>
                    <h4 class="text-sm font-medium text-stone-300 mb-4">Resources</h4>
                    <ul class="space-y-2">
                        <li>
                            <a href="<?php echo $viewPrefix; ?>sitemap.php" class="text-sm text-stone-500 hover:text-stone-300 transition-colors">
                                Site Map
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-sm text-stone-500 hover:text-stone-300 transition-colors">
                                Help Center
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Account -->
                <div>
                    <h4 class="text-sm font-medium text-stone-300 mb-4">Account</h4>
                    <ul class="space-y-2">
                        <li>
                            <a href="<?php echo $viewPrefix; ?>login.php" class="text-sm text-stone-500 hover:text-stone-300 transition-colors">
                                Log in
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $viewPrefix; ?>register.php" class="text-sm text-stone-500 hover:text-stone-300 transition-colors">
                                Sign up
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="mt-12 pt-8 border-t border-stone-800/50">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <p class="text-sm text-stone-500">
                        &copy; 2026 Horace Vial, Mitchell Coates, Amber Lawson
                    </p>
                    <div class="flex items-center gap-6">
                        <a href="#" class="text-sm text-stone-500 hover:text-stone-300 transition-colors">
                            Privacy
                        </a>
                        <a href="#" class="text-sm text-stone-500 hover:text-stone-300 transition-colors">
                            Terms
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>