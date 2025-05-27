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
    <style>
        @keyframes buttonClick {
            0% {
                transform: scale(1);
                background-color: #2563eb;
            }
            50% {
                transform: scale(1.1);
                background-color: #1d4ed8;
            }
            100% {
                transform: scale(1);
                background-color: #2563eb;
            }
        }

        .add-to-cart-btn {
            animation-duration: 0.5s;
            animation-timing-function: ease;
        }

        .add-to-cart-btn.animated {
            animation-name: buttonClick;
        }

        .cart-animation {
            animation: moveToCart 0.5s ease-out forwards;
        }

        @keyframes moveToCart {
            0% {
                transform: scale(1) translateY(0);
            }
            50% {
                transform: scale(1.2) translateY(-30px);
            }
            100% {
                transform: scale(0) translateY(-50px);
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Top Bar -->
    <div class="bg-[#27548A] text-white text-xs sm:text-sm flex justify-center">
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
            <div class="relative">
                <button type="button" id="user-menu-button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-8 h-8 rounded-full" src="{{ asset(Auth::user()->image) }}" alt="User photo">
                </button>
                <div id="user-menu" class="absolute right-0 mt-2 w-48 opacity-0 invisible transition-opacity duration-300 ease-in-out z-50 bg-white rounded-md shadow-lg overflow-hidden">
                    <div class="px-4 py-3 bg-[#27548A] text-white">
                        <span class="block text-sm font-semibold">{{ ucwords(Auth::user()->name) }}</span>
                        <span class="block text-xs text-gray-200">{{ Auth::user()->email }}</span>
                    </div>
                    <ul class="py-1">
                        <li>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">Settings</a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 transition">
                                    Log Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-[1200px] mx-auto flex items-center px-4 py-4 gap-4 justify-between">
            <div class="flex items-center gap-3 shrink-0">
                <a href="/" class="text-[#27548A] font-bold text-2xl sm:text-3xl select-none border-r border-gray-300 pr-4">Ravinal Store</a>
                <span class="text-[#27548A] font-semibold text-lg sm:text-xl select-none">Shopping List</span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="p-2 sm:p-4 min-h-screen">
        <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-lg p-2 sm:p-6 md:p-8">
            <!-- Header Row -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-4 sm:mb-6 gap-2 sm:gap-4">
                <h2 class="text-xl sm:text-2xl font-bold text-[#27548A] tracking-tight">Products</h2>
                <a href="{{ route('cart.index') }}" class="flex items-center gap-2 text-[#27548A] hover:text-blue-700 transition" id="cart-icon">
                    <img src="{{ asset('storage/images/cart.png') }}" alt="Cart" class="w-6 h-6 sm:w-7 sm:h-7">
                    <span class="text-sm sm:text-base font-semibold">Cart</span>
                </a>
            </div>
            <!-- Search & Filter -->
            <div class="mb-6 sm:mb-8">
                <form action="{{ route('user.product.search') }}" method="GET" class="flex flex-col md:flex-row md:items-end gap-3 sm:gap-4 bg-gray-50 p-4 sm:p-6 rounded-xl shadow">
                    @csrf
                    <div class="w-full md:flex-1">
                        <label for="product_Name" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-2">Search Product</label>
                        <input
                            type="text"
                            name="search"
                            id="product_Name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm"
                            placeholder="Enter product name"
                        >
                    </div>
                    <div class="w-full md:w-1/3">
                        <label for="category" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1 sm:mb-2">Select Category</label>
                        <select name="category" id="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition text-sm" onchange="this.form.submit()">
                            <option value="all" {{ (old('category', $category ?? '') == 'all') ? 'selected' : '' }}>All Categories</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ (old('category', $category ?? '') == $cat->id) ? 'selected' : '' }}>
                                    {{ $cat->productCategory }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full md:w-auto">
                        <button
                            type="submit"
                            class="w-full md:w-auto px-6 py-2 bg-[#27548A] text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-sm"
                        >
                            Search
                        </button>
                    </div>
                </form>
            </div>
            <!-- Product Grid -->
            <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 mt-6 sm:mt-8">
                @if($products && $products->count())
                    @foreach($products as $product)
                        <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition overflow-hidden flex flex-col">
                            <div class="relative">
                                <img src="{{ asset('storage/' . $product->Image) }}" alt="{{ $product->ProductName }}" class="w-full h-40 sm:h-48 object-cover rounded-t-xl">
                                @if($product->stock == 0)
                                    <span class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded-full font-semibold">Out of Stock</span>
                                @endif
                            </div>
                            <div class="p-3 sm:p-5 flex flex-col flex-1">
                                <h3 class="text-base sm:text-lg font-bold text-[#27548A] mb-1 truncate">{{ $product->ProductName }}</h3>
                                <p class="text-green-600 font-semibold text-base sm:text-lg mb-2">₱{{ number_format($product->Price, 2) }}</p>
                                <div class="mb-2 text-gray-600 text-xs sm:text-sm">
                                    <span class="font-medium">Description:</span>
                                    <span id="short-description-{{ $product->id }}">{{ Str::limit($product->Description, 30) }}</span>
                                    <span id="full-description-{{ $product->id }}" style="display: none;">{{ $product->Description }}</span>
                                    <button type="button" class="text-blue-600 hover:underline ml-1 text-xs" onclick="toggleDescription({{ $product->id }})" id="toggle-button-{{ $product->id }}">See More</button>
                                </div>
                                <p class="text-gray-500 text-xs mb-3 sm:mb-4">Stock: <span class="font-semibold">{{ $product->stock }}</span></p>
                                <form action="{{ route('cart.add', ['id' => $product->id]) }}" method="POST" class="mt-auto" onsubmit="animateCart(event, this)">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button
                                        type="submit"
                                        class="w-full px-4 py-2 rounded-lg add-to-cart-btn font-semibold text-sm sm:text-base transition
                                            {{ $product->stock == 0 ? 'bg-gray-300 text-gray-500 cursor-not-allowed grayscale' : 'bg-[#27548A] text-white hover:bg-blue-700' }}"
                                        {{ $product->stock == 0 ? 'disabled' : '' }}
                                    >
                                        {{ $product->stock == 0 ? 'Out of Stock' : 'Add To Cart' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-full text-center text-gray-500 text-base sm:text-lg py-12 sm:py-16">No products found.</div>
                @endif
            </div>
        </div>
    </main>
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
        function toggleDescription(productId) {
            const shortDescription = document.getElementById(`short-description-${productId}`);
            const fullDescription = document.getElementById(`full-description-${productId}`);
            const toggleButton = document.getElementById(`toggle-button-${productId}`);
            if (shortDescription.style.display === 'none') {
                shortDescription.style.display = 'inline';
                fullDescription.style.display = 'none';
                toggleButton.textContent = 'See More';
            } else {
                shortDescription.style.display = 'none';
                fullDescription.style.display = 'inline';
                toggleButton.textContent = 'See Less';
            }
        }
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
                userMenu.classList.add ('opacity-0', 'invisible');
                userMenu.classList.remove('opacity-100', 'visible');
            }
        });
        function animateCart(event, form) {
            event.preventDefault();
            const cartIcon = document.getElementById('cart-icon');
            const addToCartButton = form.querySelector('.add-to-cart-btn');
            
            addToCartButton.classList.add('animated');
            setTimeout(() => addToCartButton.classList.remove('animated'), 500);

            const cartImage = cartIcon.querySelector('img');
            cartImage.classList.add('cart-animation');
            setTimeout(() => cartImage.classList.remove('cart-animation'), 500);
            
            form.submit();
        }
    </script>
</body>
</html>