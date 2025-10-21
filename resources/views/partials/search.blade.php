
<section class="bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-lg shadow-md p-6 -mt-16 relative z-10 max-w-5xl mx-auto">
            <form action="" method="GET">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input 
                            type="text" 
                            name="search" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors duration-200"
                            placeholder="Search jobs by title, company, or keywords..."
                            value="{{ request('search') }}"
                        >
                    </div>
                    <div class="md:w-32">
                        <button 
                            type="submit" 
                            class="w-full bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition-colors duration-200 flex items-center justify-center"
                        >
                            <i class="fas fa-search mr-2"></i>
                            Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>