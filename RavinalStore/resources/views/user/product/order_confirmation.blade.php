<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <title>Shopping Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('storage/images/ravinallogo.jpg') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-[#fafafa] text-[#222222]">
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
                <div class="flex items-center">
                    <div class="flex items-center ms-3">
                        <div class="relative">
                            <button type="button" id="user-menu-button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300">
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full" src="{{ asset(Auth::user()->image) }}" alt="user photo">
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
            </div>
        </div>
    </div>
    <!-- Header with logo and search -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-[1200px] mx-auto flex items-center px-4 py-4 gap-4 justify-between">
            <div class="flex items-center gap-3 shrink-0">
                <a href="/" class="text-[#27548A] font-bold text-2xl sm:text-3xl select-none border-r border-gray-300 pr-4">Ravinal Store</a>
                <span class="text-[#27548A] font-semibold text-lg sm:text-xl select-none">Order Confirmation</span>
            </div>
        </div>
    </header>
    <!-- Main content -->
    <main class="max-w-[900px] mx-auto px-4 py-8">
        <!-- Delivery Address -->
        <div class="border border-[#3B82F6] bg-[#F0F6FF] rounded-lg mx-0 sm:mx-0 mt-4 p-5 shadow-sm">
            <div class="flex items-center gap-2 text-[#2563EB] font-semibold text-base mb-2">
                <i class="fas fa-map-marker-alt"></i>
                <span>Delivery Address</span>
            </div>
            @if(Auth::user()->address)
                <div class="flex flex-wrap items-center gap-2 text-sm">
                    <span class="font-semibold text-[#222]">
                        {{ ucwords(Auth::user()->name) }} <span class="text-[#2563EB]">{{ Auth::user()->phone }}</span>
                    </span>
                    <span class="text-gray-700">
                        {{ Auth::user()->address->address }}, {{ Auth::user()->address->city }}, {{ Auth::user()->address->state }}, {{ Auth::user()->address->zip }}, {{ Auth::user()->address->country }}
                    </span>
                    @if(Auth::user()->address->isdefault == '1')
                        <span class="border border-[#2563EB] text-[#2563EB] text-xs font-semibold rounded px-2 py-0.5 select-text bg-white">
                            Default
                        </span>
                    @endif
                    <a class="text-[#2563EB] font-semibold text-sm hover:underline ml-auto" href="#">
                        Change
                    </a>
                </div>
            @else
                <div class="flex flex-wrap items-center gap-2 text-sm">
                    <span class="text-gray-600">
                        No address found. Please add your address.
                    </span>
                    <a class="bg-[#2563EB] text-white font-semibold text-sm px-4 py-2 rounded hover:bg-[#1D4ED8]" href="#">
                        Add Address
                    </a>
                </div>
            @endif
        </div>
        <!-- Order Confirmation Section -->
        <section class="container mx-auto mt-8 p-8 bg-white shadow-lg rounded-xl border border-[#3B82F6]">
            <h2 class="text-3xl font-extrabold text-center mb-6 text-[#2563EB] tracking-tight">Order Received</h2>
            <div class="order-complete text-center mb-8">
                <div class="order-complete__message mb-4">
                    <svg class="mx-auto mb-2" width="80" height="80" viewBox="0 0 80 80" fill="none">
                        <circle cx="40" cy="40" r="40" fill="#2563EB" />
                        <path d="M52.9743 35.7612C52.9743 35.3426 52.8069 34.9241 52.5056 34.6228L50.2288 32.346C49.9275 32.0446 49.5089 31.8772 49.0904 31.8772C48.6719 31.8772 48.2533 32.0446 47.952 32.346L36.9699 43.3449L32.048 38.4062C31.7467 38.1049 31.3281 37.9375 30.9096 37.9375C30.4911 37.9375 30.0725 38.1049 29.7712 38.4062L27.4944 40.683C27.1931 40.9844 27.0257 41.4029 27.0257 41.8214C27.0257 42.24 27.1931 42.6585 27.4944 42.9598L33.5547 49.0201L35.8315 51.2969C36.1328 51.5982 36.5513 51.7656 36.9699 51.7656C37.3884 51.7656 37.8069 51.5982 38.1083 51.2969L40.385 49.0201L52.5056 36.8996C52.8069 36.5982 52.9743 36.1797 52.9743 35.7612Z" fill="white" />
                    </svg>
                    <h3 class="text-xl font-bold text-[#222]">Your order is completed!</h3>
                    <p class="text-gray-600">Thank you. Your order has been received.</p>
                </div>
                <div class="order-info grid grid-cols-1 sm:grid-cols-2 gap-4 justify-center max-w-lg mx-auto mb-6">
                    @if(isset($order))
                        <div class="order-info__item bg-[#F0F6FF] rounded-lg px-4 py-3 text-left">
                            <label class="font-medium text-[#2563EB]">Order Number:</label>
                            <span class="block text-[#222]">{{ $order->id }}</span>
                        </div>
                        <div class="order-info__item bg-[#F0F6FF] rounded-lg px-4 py-3 text-left">
                            <label class="font-medium text-[#2563EB]">Date:</label>
                            <span class="block text-[#222]">{{ $order->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="order-info__item bg-[#F0F6FF] rounded-lg px-4 py-3 text-left">
                            <label class="font-medium text-[#2563EB]">Total:</label>
                            <span class="block text-[#222]">&#8369;{{ number_format($order->total, 2) }}</span>
                        </div>
                        @if(isset($transaction))
                            <div class="order-info__item bg-[#F0F6FF] rounded-lg px-4 py-3 text-left">
                                <label class="font-medium text-[#2563EB]">Payment Method:</label>
                                <span class="block text-[#222]">{{ $transaction->mode }}</span>
                            </div>
                        @endif
                    @else
                        <p class="col-span-2 text-center text-gray-500">No order information available.</p>
                    @endif
                </div>
                <div class="mt-8">
                    <a href="{{ url('user/products') }}"
                        class="inline-block text-lg font-bold text-white bg-[#2563EB] hover:bg-[#1D4ED8] rounded-lg py-4 px-10 shadow transition">
                        Shop again!
                    </a>
                </div>
            </div>
        </section>
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
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');

        userMenuButton.addEventListener('click', () => {
            const isVisible = userMenu.classList.contains('opacity-100');
            if (isVisible) {
                userMenu.classList.remove('opacity-100', 'visible');
                userMenu.classList.add('opacity-0', 'invisible');
            } else {
                userMenu.classList.remove('opacity-0', 'invisible');
                userMenu.classList.add('opacity-100', 'visible');
            }
        });

        document.addEventListener('click', (event) => {
            if (!userMenu.contains(event.target) && !userMenuButton.contains(event.target)) {
                userMenu.classList.remove('opacity-100', 'visible');
                userMenu.classList.add('opacity-0', 'invisible');
            }
        });
    </script>
</body>
</html>