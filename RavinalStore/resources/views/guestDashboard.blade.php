<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('storage/images/ravinallogo.jpg') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet"/>
</head>
<body class="bg-gray-100">
    <!-- Top Bar -->
    <div class="bg-[#27548A] text-white text-xs sm:text-sm flex flex-col sm:flex-row justify-center">
        <div class="max-w-[1200px] w-full flex flex-wrap items-center gap-2 px-4 py-1 sm:py-2">
            <nav class="flex flex-wrap items-center gap-3 text-white text-xs sm:text-sm">
                <a class="hover:underline font-semibold px-2 py-1 rounded hover:bg-[#183B4E] transition" href="{{ url('/') }}">
                    <i class="fas fa-home mr-1"></i>Home
                </a>
                <span class="hidden sm:inline">|</span>
                <a class="hover:underline font-semibold px-2 py-1 rounded hover:bg-[#183B4E] transition" href="{{ url('user/products') }}">
                    <i class="fas fa-box-open mr-1"></i>Products
                </a>
                <span class="hidden sm:inline">|</span>
                <a class="hover:underline font-semibold px-2 py-1 rounded hover:bg-[#183B4E] transition" href="#">
                    <i class="fas fa-envelope mr-1"></i>Contact Us
                </a>
                <span class="hidden sm:inline">|</span>
                <span class="flex items-center gap-1 ml-2">
                    <span class="hidden sm:inline">Follow us:</span>
                    <a aria-label="Facebook" class="hover:text-blue-300 px-1" href="#">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a aria-label="Instagram" class="hover:text-pink-300 px-1" href="#">
                        <i class="fab fa-instagram"></i>
                    </a>
                </span>
            </nav>
            <div class="flex-grow"></div>
            @auth
            <div class="relative">
                <button type="button" id="user-menu-button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-8 h-8 rounded-full" src="{{ asset(Auth::user()->image) }}" alt="User photo">
                </button>
                <div id="user-menu" class="absolute right-0 mt-2 w-48 opacity-0 invisible transition-opacity duration-300 ease-in-out z-50 bg-white divide-y divide-gray-100 rounded-md shadow-lg">
                    <div class="px-4 py-3 bg-gray-800 text-white">
                       <p class="text-sm">{{ ucwords(Auth::user()->name) }}</p>
                    </div>
                    <ul class="py-1 bg-gray-800 text-white">
                        <li>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-700">Settings</a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="block">
                               @csrf
                                <button type="submit" class="w-full px-4 py-2 text-left text-sm hover:bg-gray-700">
                                   Log Out
                               </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <div class="flex gap-2">
                    <a href="{{ route('login') }}" class="text-sm text-white hover:underline">Login</a>
                    <span>|</span>
                    <a href="{{ route('register') }}" class="text-sm text-white hover:underline">Register</a>
                </div>
            @endauth
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="bg-white border-b border-gray-200">
        <div class="max-w-[1200px] mx-auto flex items-center px-4 py-3 gap-4 justify-between">
            <div class="flex items-center gap-2">
                <a href="/" class="text-[#183B4E] font-bold text-3xl border-r border-black pr-4">Ravinal Store</a>
                <span class="text-[#183B4E] font-semibold text-lg">Home</span>
            </div>
            <form class="flex-grow max-w-[600px]" method="GET" action="{{ route('products.search') }}">
                <label class="sr-only" for="search">Search</label>
                <div class="flex">
                    <input
                        class="border border-gray-300 rounded-l-md px-3 py-2 w-full text-sm focus:outline-none focus:ring-2 focus:ring-[#0F2138] focus:border-[#0F2138]"
                        id="search" name="search" placeholder="Search products..." type="text" value="{{ request('search') }}"/>
                    <button aria-label="Search" class="bg-[#27548A] text-white px-4 py-2 rounded-r-md hover:bg-[#0F2138] transition-colors ml-2" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <div class="flex justify-between items-center">
                <a href="{{ route('cart.index') }}" class="flex items-center text-gray-700 hover:text-gray-900">
                    <img src="{{ asset('storage/images/cart.png') }}" alt="Cart" class="w-6 h-6 mr-2">
                    <span class="text-sm font-medium">Cart</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="p-4 flex flex-col items-center">
        <!-- Banner -->
        <div class="relative w-full max-w-7xl h-72 md:h-96 rounded-lg shadow-lg overflow-hidden mb-6">
            <img src="{{ asset('storage/images/banner.jpg') }}" alt="Banner" class="absolute inset-0 w-full h-full object-cover opacity-80">
            <div class="relative z-10 flex flex-col justify-center items-start h-full px-8 bg-gradient-to-r from-[#27548A]/80 via-[#27548A]/60 to-transparent">
                <h1 class="text-3xl md:text-4xl font-bold mb-2 text-white drop-shadow">Welcome to Ravinal Store!</h1>
                <p class="text-base md:text-lg mb-4 text-white drop-shadow">Discover the best products at unbeatable prices. Shop now and enjoy exclusive offers!</p>
                <a href="{{ url('user/products') }}" class="bg-white text-[#27548A] px-6 py-2 rounded-md font-semibold hover:bg-[#0F2138] hover:text-white transition-colors shadow">
                    Shop Now
                </a>
            </div>
        </div>

        <!-- Categories Section -->
        <section class="w-full max-w-7xl bg-white mt-2 rounded-lg shadow px-6 py-6">
            <h2 class="text-xl font-semibold text-[#27548A] mb-5 tracking-wide text-center">Categories</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-7">
                @if($categories && $categories->count())
                    @foreach($categories as $category)
                        @php
                            $product = $products->where('category_id', $category->id)->first();
                        @endphp
                        @if($product)
                            <a href="{{ route('user.product.viewByCategory', ['categoryId' => $category->id]) }}" class="group bg-gray-50 rounded-xl shadow hover:shadow-lg transition-all duration-200 overflow-hidden flex flex-col items-center border border-gray-100 hover:border-[#27548A]">
                                <div class="w-full h-40 bg-gray-200 flex items-center justify-center overflow-hidden">
                                    <img src="{{ asset('storage/' . $product->Image) }}" alt="{{ $category->productCategory }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-200">
                                </div>
                                <div class="py-4 px-2 w-full text-center">
                                    <h3 class="text-base font-semibold text-[#183B4E] group-hover:text-[#27548A] transition-colors">{{ $category->productCategory }}</h3>
                                </div>
                            </a>
                        @endif
                    @endforeach
                @else
                    <div class="col-span-full text-center text-gray-400 py-8">No categories found.</div>
                @endif
            </div>
            <div class="mt-6 text-center">
                <a href="{{ url('user/product/userViewProduct') }}" class="text-[#27548A] hover:underline">View All Products</a>
            </div>
        </section>
        <!-- Products Section -->
        <div class="mt-6 w-full max-w-7xl bg-white rounded-lg shadow px-6 py-6">
            <h2 class="text-xl font-semibold text-[#27548A] mb-5 tracking-wide text-center">Featured Products</h2>
            @if($products && $products->count())
            <div class="relative">
                <div id="product-carousel" class="overflow-hidden">
                <div class="flex transition-transform duration-500" style="will-change: transform;">
                    @foreach($products->take(8) as $product)
                    <div class="min-w-full sm:min-w-[50%] md:min-w-[33.333%] lg:min-w-[25%] px-2 carousel-item">
                        <a href="{{ url('user/products/featured/' . $product->id) }}" class="group block bg-gray-50 rounded-xl shadow hover:shadow-lg transition-all duration-200 overflow-hidden border border-gray-100 hover:border-[#27548A]">
                            <div class="w-full h-40 bg-gray-200 flex items-center justify-center overflow-hidden">
                                <img src="{{ asset('storage/' . $product->Image) }}" alt="{{ $product->ProductName }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-200">
                            </div>
                            <div class="py-4 px-2 text-center">
                                <h3 class="text-base font-semibold text-[#183B4E] group-hover:text-[#27548A] transition-colors">{{ $product->ProductName }}</h3>
                                <p class="text-sm text-gray-600 mt-1">&#8369;{{ number_format($product->Price, 2) }}</p>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                </div>
                <!-- Carousel Controls -->
                <button id="carousel-prev" class="absolute left-0 top-1/2 -translate-y-1/2 bg-white border rounded-full shadow p-2 hover:bg-gray-100 z-10">
                <i class="fas fa-chevron-left"></i> 
                </button>
                <button id="carousel-next" class="absolute right-0 top-1/2 -translate-y-1/2 bg-white border rounded-full shadow p-2 hover:bg-gray-100 z-10">
                <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            @else
            <div class="col-span-full text-center text-gray-400 py-8">No products found.</div>
            @endif
        </div>
    </main>
        <!-- Footer -->
        <footer class="w-full bg-[#27548A] text-white mt-10 rounded-none shadow-none px-0 py-8">
            <div class="max-w-full w-full px-6 md:px-16 flex flex-col md:flex-row justify-between items-start md:items-center gap-8 md:gap-12 mx-auto">
                <!-- Brand & Description -->
                <div class="mb-6 md:mb-0 flex-1 min-w-[220px]">
                    <a href="/" class="flex items-center gap-2 text-2xl font-extrabold text-white tracking-wide">
                        <img src="{{ asset('storage/images/ravinallogo.jpg') }}" alt="Ravinal Store Logo" class="w-10 h-10 rounded-full shadow-lg border-2 border-white">
                        Ravinal Store
                    </a>
                    <p class="text-sm mt-3 text-gray-200 leading-relaxed max-w-xs">
                        Your trusted shop for quality products at great prices. Experience seamless shopping with us!
                    </p>
                </div>
                <!-- Links & Contact -->
                <div class="flex flex-wrap gap-8 md:gap-12 flex-1 justify-between">
                    <!-- Quick Links -->
                    <div>
                        <h4 class="font-semibold mb-3 text-white tracking-wide">Quick Links</h4>
                        <ul class="space-y-2 text-sm">
                            <li>
                                <a href="{{ url('/') }}" class="hover:underline hover:text-blue-200 transition-colors flex items-center gap-2">
                                    <i class="fas fa-home"></i> Home
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('user/products') }}" class="hover:underline hover:text-blue-200 transition-colors flex items-center gap-2">
                                    <i class="fas fa-box-open"></i> Products
                                </a>
                            </li>
                            <li>
                                <a href="#" class="hover:underline hover:text-blue-200 transition-colors flex items-center gap-2">
                                    <i class="fas fa-envelope"></i> Contact Us
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Contact Info -->
                    <div>
                        <h4 class="font-semibold mb-3 text-white tracking-wide">Contact</h4>
                        <ul class="space-y-2 text-sm">
                            <li class="flex items-center gap-2">
                                <span class="inline-block w-5 text-center text-lg text-blue-200"><i class="fas fa-envelope"></i></span>
                                <a href="mailto:danandreiespiritu@gmail.com" class="hover:underline hover:text-blue-200 break-all transition-colors">
                                    danandreiespiritu@gmail.com
                                </a>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="inline-block w-5 text-center text-lg text-blue-200"><i class="fas fa-phone"></i></span>
                                <a href="tel:+639169571105" class="hover:underline hover:text-blue-200 transition-colors">+63 916 957 1105</a>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="inline-block w-5 text-center text-lg text-blue-200"><i class="fas fa-map-marker-alt"></i></span>
                                <span class="text-gray-200">Adduru St. Smart, Gonzaga, Cagayan, PH</span>
                            </li>
                        </ul>
                    </div>
                    <!-- Social Media -->
                    <div>
                        <h4 class="font-semibold mb-3 text-white tracking-wide">Follow Us</h4>
                        <div class="flex gap-4 mt-1">
                            <a href="#" aria-label="Facebook" class="hover:text-blue-400 text-2xl transition-colors">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" aria-label="Instagram" class="hover:text-pink-400 text-2xl transition-colors">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-t border-white/20 mt-10 pt-4 text-center text-xs text-gray-200 tracking-wide w-full">
                &copy; {{ date('Y') }} <span class="font-semibold">Ravinal Store</span>. All rights reserved.
            </div>
        </footer>
    <script>
            document.addEventListener('DOMContentLoaded', function () {
            const carousel = document.querySelector('#product-carousel > .flex');
            const items = document.querySelectorAll('.carousel-item');
            const prevBtn = document.getElementById('carousel-prev');
            const nextBtn = document.getElementById('carousel-next');
            let current = 0;
            let visible = 1;
            if(window.innerWidth >= 1024) visible = 4;
            else if(window.innerWidth >= 768) visible = 3;
            else if(window.innerWidth >= 640) visible = 2;

            function updateCarousel() {
                const width = items[0].offsetWidth;
                carousel.style.transform = `translateX(-${current * width}px)`;
            }

            prevBtn.addEventListener('click', function () {
                if (current > 0) {
                current--;
                updateCarousel();
                }
            });

            nextBtn.addEventListener('click', function () {
                if (current < items.length - visible) {
                current++;
                updateCarousel();
                }
            });

            window.addEventListener('resize', function () {
                if(window.innerWidth >= 1024) visible = 4;
                else if(window.innerWidth >= 768) visible = 3;
                else if(window.innerWidth >= 640) visible = 2;
                else visible = 1;
                if(current > items.length - visible) current = items.length - visible;
                if(current < 0) current = 0;
                updateCarousel();
            });

            updateCarousel();
            });
        </script>
    </main>
    <script>
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');

        userMenuButton.addEventListener('click', () => {
            userMenu.classList.toggle('opacity-100');
            userMenu.classList.toggle('visible');
            userMenu.classList.toggle('opacity-0');
            userMenu.classList.toggle('invisible');
        });

        document.addEventListener('click', (event) => {
            if (!userMenu.contains(event.target) && !userMenuButton.contains(event.target)) {
                userMenu.classList.add('opacity-0', 'invisible');
                userMenu.classList.remove('opacity-100', 'visible');
            }
        });
    </script>
</body>
</html>