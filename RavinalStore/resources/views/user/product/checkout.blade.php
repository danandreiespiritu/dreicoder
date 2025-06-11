<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <title>Checkout</title>
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
<body class="bg-[#fafafa] text-[#222222] max-w-screen overflow-x-hidden">
    <!-- Header Section -->
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

    <!-- Header with logo and search -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-[1200px] mx-auto flex items-center px-4 py-4 gap-4 justify-between">
            <div class="flex items-center gap-3 shrink-0">
                <a href="/" class="text-[#27548A] font-bold text-2xl sm:text-3xl select-none border-r border-gray-300 pr-4">Ravinal Store</a>
                <span class="text-[#27548A] font-semibold text-lg sm:text-xl select-none">Checkout Cart</span>
            </div>
        </div>
    </header>

    <!-- Main content -->
    <main class="max-w-[900px] mx-auto px-2 sm:px-4 py-6">
        <div class="bg-[#f5f7fa] border border-[#e3e8ee] rounded-lg shadow-sm p-4 sm:p-8">
            <!-- Products Ordered -->
            <div class="flex justify-between items-center text-xs sm:text-base text-[#1a3557] mb-4 border-b border-[#e3e8ee] pb-2">
                <div class="font-semibold">Products Ordered</div>
                <div class="flex gap-8 sm:gap-16 text-right w-2/3 justify-end">
                    <div class="w-24">Unit Price</div>
                    <div class="w-20">Quantity</div>
                    <div class="w-28 font-semibold">Item Subtotal</div>
                </div>
            </div>

            <!-- Loop through Cart Items -->
            @foreach($cartItems as $item)
                @if($item->product)
                    <div class="flex items-center gap-4 sm:gap-8 text-xs sm:text-base text-[#1a3557] mb-4 border-b border-[#e3e8ee] last:border-b-0 pb-4 last:pb-0">
                        <div class="flex items-center gap-3 flex-1 min-w-[180px]">
                            <img 
                                alt="{{ $item->product->ProductName }}" 
                                class="w-14 h-14 sm:w-20 sm:h-20 object-cover rounded border border-[#e3e8ee] bg-white"
                                src="{{ asset('storage/' . $item->product->Image) }}"
                            />
                            <div>
                                <div class="truncate font-semibold text-sm sm:text-base">
                                    {{ $item->product->ProductName }}
                                </div>
                                <div class="text-[#7b8ca7] text-xs">
                                    {{ $item->product->ProductCategory }}
                                </div>
                            </div>
                        </div>
                        <div class="w-24 text-right font-medium">
                            ₱{{ number_format($item->product->Price, 2) }}
                        </div>
                        <div class="w-20 text-center font-semibold">
                            {{ $item->quantity }}
                        </div>
                        <div class="w-28 text-right font-bold text-[#27548A]">
                            ₱{{ number_format($item->quantity * $item->product->Price, 2) }}
                        </div>
                    </div>
                @endif
            @endforeach

            <!-- Order Total -->
            <div class="flex justify-between items-center text-sm sm:text-base text-[#1a3557] mt-6 font-semibold">
                <span>Order Total: ({{ count($cartItems) }} item{{ count($cartItems) > 1 ? 's' : '' }})</span>
                <span class="text-[#27548A] text-lg sm:text-xl font-bold">
                    ₱{{ number_format($cartItems->sum(function($item) { 
                        return $item->product ? $item->quantity * $item->product->Price : 0; 
                    }), 2) }}
                </span>
            </div>

            <!-- Place Order Form -->
            <form method="POST" action="{{ route('cart.place.an.order') }}" class="mt-8 space-y-6">
                @csrf

                <!-- Address Section -->
                <div class="border border-[#e3e8ee] rounded-md p-4 bg-white">
                    <div class="flex items-center gap-2 text-[#27548A] font-semibold text-base mb-2">
                        <i class="fas fa-map-marker-alt text-sm"></i>
                        <span>Delivery Address</span>
                    </div>
                    @if(Auth::user()->address)
                        <div class="flex flex-wrap items-center gap-2 text-xs sm:text-base mb-2">
                            <span class="font-semibold">
                                {{ ucwords(Auth::user()->name) }} {{ Auth::user()->phone }}
                            </span>
                            <span class="text-[#7b8ca7]">
                                {{ Auth::user()->address->address }}, {{ Auth::user()->address->city }}, {{ Auth::user()->address->state }}, {{ Auth::user()->address->zip }}, {{ Auth::user()->address->country }}
                            </span>
                            @if(Auth::user()->address->isdefault == '1')
                                <span class="border border-[#27548A] text-[#27548A] text-[10px] font-semibold rounded px-1 py-[1px] select-text">
                                    Default
                                </span>
                            @endif
                            <a class="text-[#27548A] font-semibold text-xs sm:text-sm hover:underline" href="#">
                                Change
                            </a>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4 text-sm hidden">
                            <input type="text" name="name" value="{{ $address->name }}" placeholder="Full Name" class="border border-[#e3e8ee] px-3 py-2 rounded" required>
                            <input type="text" name="phone" value="{{ $address->phone }}" placeholder="Phone Number" class="border border-[#e3e8ee] px-3 py-2 rounded" required>
                            <input type="text" name="zip" value="{{ $address->zip }}" placeholder="ZIP Code" class="border border-[#e3e8ee] px-3 py-2 rounded" required>
                            <input type="text" name="state" value="{{ $address->state }}" placeholder="State" class="border border-[#e3e8ee] px-3 py-2 rounded" required>
                            <input type="text" name="city" value="{{ $address->city }}" placeholder="City" class="border border-[#e3e8ee] px-3 py-2 rounded" required>
                            <input type="text" name="country" value="{{ $address->country }}" placeholder="Country" class="border border-[#e3e8ee] px-3 py-2 rounded" required>
                            <input type="text" name="address" value="{{ $address->address }}" placeholder="Full Address" class="border border-[#e3e8ee] px-3 py-2 rounded col-span-1 sm:col-span-2" required>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4 text-sm">
                            <input type="text" name="name" placeholder="Full Name" class="border border-[#e3e8ee] px-3 py-2 rounded" required>
                            <input type="text" name="phone" placeholder="Phone Number" class="border border-[#e3e8ee] px-3 py-2 rounded" required>
                            <input type="text" name="zip" placeholder="ZIP Code" class="border border-[#e3e8ee] px-3 py-2 rounded" required>
                            <input type="text" name="state" placeholder="State" class="border border-[#e3e8ee] px-3 py-2 rounded" required>
                            <input type="text" name="city" placeholder="City" class="border border-[#e3e8ee] px-3 py-2 rounded" required>
                            <input type="text" name="country" placeholder="Country" class="border border-[#e3e8ee] px-3 py-2 rounded" required>
                            <input type="text" name="address" placeholder="Full Address" class="border border-[#e3e8ee] px-3 py-2 rounded col-span-1 sm:col-span-2" required>
                        </div>
                    @endif
                </div>

                <!-- Payment Method -->
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label for="mode" class="font-semibold text-sm text-[#1a3557]">Payment Mode</label>
                        <select name="mode" id="mode" class="border border-[#e3e8ee] px-3 py-2 rounded">
                            <option value="Cash on delivery">Cash on Delivery</option>
                            <option value="gcash">GCash</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#27548A] hover:bg-[#1a3557] transition text-white py-2 px-4 rounded font-semibold text-base shadow">
                    Place Order
                </button>
            </form>
        </div>
    </main>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');
        let menuOpen = false;

        if (userMenuButton && userMenu) {
            userMenuButton.addEventListener('click', function (e) {
                e.stopPropagation();
                menuOpen = !menuOpen;
                if (menuOpen) {
                    userMenu.classList.remove('opacity-0', 'invisible');
                    userMenu.classList.add('opacity-100', 'visible');
                } else {
                    userMenu.classList.add('opacity-0', 'invisible');
                    userMenu.classList.remove('opacity-100', 'visible');
                }
            });

            document.addEventListener('click', function (e) {
                if (menuOpen && !userMenu.contains(e.target) && e.target !== userMenuButton) {
                    userMenu.classList.add('opacity-0', 'invisible');
                    userMenu.classList.remove('opacity-100', 'visible');
                    menuOpen = false;
                }
            });
        }
    });
</script>
</body>
</html>
