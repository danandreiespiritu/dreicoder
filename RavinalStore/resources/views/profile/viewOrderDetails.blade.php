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
                <div id="user-menu" class="absolute right-0 mt-2 w-48 opacity-0 invisible transition-opacity duration-300 ease-in-out z-50 bg-white divide-y divide-gray-100 rounded-md shadow-lg">
                    <div class="px-4 py-3 bg-gray-800 text-white">
                        <a class="text-sm" href="{{ route('profile.edit') }}">{{ ucwords(Auth::user()->name) }}</a>
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
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="bg-white border-b border-gray-200">
        <div class="max-w-[1200px] mx-auto flex items-center px-4 py-3 gap-4 justify-between">
            <div class="flex items-center gap-2">
                <a href="/" class="text-[#183B4E] font-bold text-3xl border-r border-black pr-4">Ravinal Store</a>
                <span class="text-[#183B4E] font-semibold text-lg">Edit Profile</span>
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
    <main class="max-w-[1200px] mx-auto px-4 py-6 flex flex-col md:flex-row gap-6">
        <!-- Sidebar -->
        <aside class="w-full md:w-60 bg-white rounded-md p-4 text-sm text-gray-800">
            <div class="flex items-center space-x-3 mb-4">
                <img alt="User avatar" class="rounded-full" height="40" src="{{ asset(Auth::user()->image) }}" width="40"/>
                <div>
                    <p class="font-semibold text-sm text-gray-800">
                        {{ ucwords(Auth::user()->name) }}
                    </p>
                    <button class="text-xs text-gray-500 hover:underline flex items-center space-x-1">
                        <i class="fas fa-pencil-alt text-xs"></i>
                        <a href="{{ url('profile') }}">Edit Profile</a>
                    </button>
                </div>
            </div>
            <nav class="space-y-2">
                <div class="relative">
                    <button 
                        class="flex items-center w-full px-4 py-2 rounded-md font-semibold text-[#27548A] hover:bg-[#f3f6fa] transition focus:outline-none focus:ring-2 focus:ring-[#27548A] gap-2"
                        id="account-dropdown-button"
                        type="button"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        <i class="fas fa-user-circle text-lg"></i>
                        <span>My Account</span>
                        <i class="fas fa-chevron-down text-xs ml-auto"></i>
                    </button>
                  <div id="account-dropdown-menu" class="absolute left-0 mt-2 w-52 bg-white border border-gray-200 rounded-lg shadow-lg opacity-0 invisible transition-opacity duration-300 ease-in-out z-50 overflow-hidden">
                        <a class="flex items-center gap-2 px-5 py-3 text-sm font-medium text-[#27548A] bg-gray-50 hover:bg-[#f3f6fa] transition" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user-circle"></i> Profile
                        </a>
                        <a class="flex items-center gap-2 px-5 py-3 text-sm font-medium text-gray-700 hover:text-[#27548A] hover:bg-[#f3f6fa] transition" href="{{ route('profile.addAddress') }}">
                            <i class="fas fa-map-marker-alt"></i> Address
                        </a>
                        <a class="flex items-center gap-2 px-5 py-3 text-sm font-medium text-gray-700 hover:text-[#27548A] hover:bg-[#f3f6fa] transition" href="{{ route('profile.trackorder') }}">
                            <i class="fas fa-truck"></i> Track Order
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 w-full px-5 py-3 text-left text-sm font-medium text-red-600 hover:bg-red-50 transition">
                                <i class="fas fa-sign-out-alt"></i> Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        </aside>
        <!-- Profile content -->
        <section class="flex-grow bg-white rounded-xl p-8 text-gray-800 shadow-lg" id="order-history">
            @if(isset($order))
            <h2 class="text-3xl font-extrabold mb-8 text-[#183B4E] tracking-tight border-b-4 border-[#27548A] pb-2">Order Details</h2>
            <div class="mb-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Order Status & Payment -->
                    <div class="bg-gradient-to-br from-[#e3ecfa] to-[#f8fafc] rounded-2xl p-6 border border-[#d1e3fa] shadow-lg flex flex-col gap-6">
                        <div class="flex items-center gap-3">
                            <span class="font-semibold text-[#27548A]">Status:</span>
                            <span class="px-4 py-1 rounded-full text-sm font-bold shadow {{ 
                                $transaction->status == 'completed' ? 'bg-green-100 text-green-700 border border-green-300' : 
                                ($transaction->status == 'cancelled' ? 'bg-red-100 text-red-700 border border-red-300' : 
                                'bg-yellow-100 text-yellow-700 border border-yellow-300') 
                            }}">
                                <i class="fas {{ 
                                    $transaction->status == 'completed' ? 'fa-check-circle' : 
                                    ($transaction->status == 'cancelled' ? 'fa-times-circle' : 'fa-hourglass-half') 
                                }} mr-1"></i>
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="font-semibold text-[#27548A]">Payment:</span>
                            <span class="flex items-center gap-2 text-gray-700">
                                @if($transaction->mode === 'Cash on delivery')
                                    <i class="fas fa-money-bill-wave text-green-500"></i> Cash on Delivery
                                @elseif($transaction->mode === 'gcash')
                                    <i class="fab fa-cc-visa text-blue-500"></i> GCash
                                @else
                                    <i class="fas fa-wallet text-gray-500"></i> {{ ucfirst($transaction->mode) }}
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="font-semibold text-[#27548A]">Order Date:</span>
                            <span class="text-gray-700">{{ $order->created_at->format('F d, Y h:i A') }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="font-semibold text-[#27548A]">Order ID:</span>
                            <span class="text-gray-700">#{{ $order->id }}</span>
                        </div>
                    </div>
                    <!-- Shipping & Buyer Info -->
                    <div class="bg-gradient-to-br from-[#f8fafc] to-[#e3ecfa] rounded-2xl p-6 border border-[#d1e3fa] shadow-lg flex flex-col gap-6">
                        <div>
                            <h4 class="font-semibold text-[#27548A] mb-2 flex items-center gap-2">
                                <i class="fas fa-shipping-fast"></i> Shipping Address
                            </h4>
                            <address class="not-italic text-gray-700 mb-2 leading-relaxed text-sm">
                                {{ $order->address }},
                                {{ $order->city }},
                                {{ $order->state }},
                                {{ $order->zip }},
                                {{ $order->country }}
                            </address>
                        </div>
                        <div>
                            <h4 class="font-semibold text-[#27548A] mb-2 flex items-center gap-2">
                                <i class="fas fa-user"></i> Buyer Info
                            </h4>
                            <div class="text-gray-700 text-sm mb-1">
                                <span class="font-semibold">Name:</span>
                                <span>{{ $order->buyer_name ?? $order->user->name ?? Auth::user()->name }}</span>
                            </div>
                            <div class="text-gray-700 text-sm">
                                <span class="font-semibold">Contact:</span>
                                <span>{{ $order->contact ?? $order->user->email ?? Auth::user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="text-xl font-bold mb-4 text-[#27548A]">Items</h3>
            <div class="overflow-x-auto rounded-lg shadow">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="bg-[#f3f6fa] text-[#27548A] uppercase text-xs tracking-wider">
                            <th class="py-3 px-5 border-b text-left">Product</th>
                            <th class="py-3 px-5 border-b text-right">Price</th>
                            <th class="py-3 px-5 border-b text-center">Quantity</th>
                            <th class="py-3 px-5 border-b text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $orderItem)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-5 border-b flex items-center gap-3">
                                @if($orderItem->product)
                                    <img src="{{ asset('storage/' . $orderItem->product->Image) }}" alt="{{ $orderItem->product->ProductName }}" class="w-12 h-12 object-cover rounded-md">
                                    <span class="font-medium text-gray-800">{{ $orderItem->product->ProductName }}</span>
                                @else
                                    <span class="text-red-500">Product not found</span>
                                @endif
                            </td>
                            <td class="py-3 px-5 border-b text-right text-gray-700">₱{{ number_format($orderItem->price, 2) }}</td>
                            <td class="py-3 px-5 border-b text-center text-gray-700">{{ $orderItem->quantity }}</td>
                            <td class="py-3 px-5 border-b text-right text-gray-800 font-semibold">₱{{ number_format($orderItem->price * $orderItem->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end mt-8">
                <div class="w-full md:w-1/3 bg-gradient-to-br from-[#f3f6fa] to-white rounded-xl p-6 border border-[#e5e7eb] shadow">
                    <div class="flex justify-between mb-3 text-gray-700">
                        <span class="font-semibold">Subtotal:</span>
                        <span>₱{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-xl text-[#27548A] border-t border-gray-200 pt-3">
                        <span>Total:</span>
                        <span>₱{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            @if($transaction->status !== 'completed')
                <form action="{{ route('profile.cancel', $order->id) }}" method="POST" class="mt-8 flex justify-end">
                    @csrf
                    @method('PUT')
                    <button
                        type="button"
                        class="bg-gradient-to-r from-red-500 to-red-700 hover:from-red-600 hover:to-red-800 text-white font-bold px-8 py-3 rounded-lg shadow-lg transition-all duration-200 {{ $transaction->status === 'cancelled' ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}"
                        @if($transaction->status !== 'cancelled')
                        onclick="document.getElementById('cancelModal').classList.remove('hidden')"
                        @endif
                        @if($transaction->status === 'cancelled')
                        disabled
                        @endif
                    >
                        {{ $transaction->status === 'cancelled' ? 'Order Cancelled' : 'Cancel Order' }}
                    </button>

                    <!-- Confirmation Modal -->
                    @if($transaction->status !== 'cancelled')
                    <div id="cancelModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50 hidden">
                        <div class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-md border-2 border-red-200">
                            <h3 class="text-xl font-bold mb-4 text-red-700 flex items-center gap-2"><i class="fas fa-exclamation-triangle"></i> Cancel Order</h3>
                            <p class="mb-8 text-gray-600">Are you sure you want to cancel this order? <span class="font-semibold text-red-600">This action cannot be undone.</span></p>
                            <div class="flex justify-end gap-3">
                                <button
                                    type="button"
                                    class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-semibold transition"
                                    onclick="document.getElementById('cancelModal').classList.add('hidden')"
                                >
                                    No, Keep Order
                                </button>
                                <button
                                    type="submit"
                                    class="px-5 py-2 rounded-lg bg-gradient-to-r from-red-500 to-red-700 text-white hover:from-red-600 hover:to-red-800 font-bold transition"
                                >
                                    Yes, Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                </form>
            @endif

            @else
            <div class="text-center text-gray-400 py-16">
                <i class="fas fa-box-open text-6xl mb-6"></i>
                <p class="text-lg font-semibold">No order details found.</p>
            </div>
            @endif
        </section>
    </main>
    <script>
        const accountDropdownButton = document.getElementById('account-dropdown-button');
        const accountDropdownMenu = document.getElementById('account-dropdown-menu');
        const purchaseDropdownButton = document.getElementById('purchase-dropdown-button');
        const purchaseDropdownMenu = document.getElementById('purchase-dropdown-menu');

        accountDropdownButton.addEventListener('click', () => {
            accountDropdownMenu.classList.toggle('opacity-100');
            accountDropdownMenu.classList.toggle('visible');
            accountDropdownMenu.classList.toggle('opacity-0');
            accountDropdownMenu.classList.toggle('invisible');
        });

        purchaseDropdownButton.addEventListener('click', () => {
            purchaseDropdownMenu.classList.toggle('opacity-100');
            purchaseDropdownMenu.classList.toggle('visible');
            purchaseDropdownMenu.classList.toggle('opacity-0');
            purchaseDropdownMenu.classList.toggle('invisible');
        });
        document.addEventListener('click', (event) => {
        if (!accountDropdownMenu.contains(event.target) && !accountDropdownButton.contains(event.target)) {
            accountDropdownMenu.classList.add('opacity-0', 'invisible');
            accountDropdownMenu.classList.remove('opacity-100', 'visible');
        }
        if (!purchaseDropdownMenu.contains(event.target) && !purchaseDropdownButton.contains(event.target)) {
            purchaseDropdownMenu.classList.add('opacity-0', 'invisible');
            purchaseDropdownMenu.classList.remove('opacity-100', 'visible');
        }
        });
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
