<footer class="bg-white shadow-inner mt-auto">
    <div class="container mx-auto px-4 py-6">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <div class="text-center md:text-left">
                <p class="text-gray-600">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </p>
            </div>
            <div class="flex space-x-6">
                <a href="https://www.facebook.com" class="text-gray-400 hover:text-gray-500">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://www.twitter.com" class="text-gray-400 hover:text-gray-500">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://www.linkedin.com" class="text-gray-400 hover:text-gray-500">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="https://www.instagram.com" class="text-gray-400 hover:text-gray-500">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>
    </div>
</footer>