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
                    <button class="flex items-center space-x-2 font-semibold text-gray-800 focus:outline-none" id="account-dropdown-button">
                        <i class="fas fa-user text-blue-500"></i>
                        <span>My Account</span>
                        <i class="fas fa-chevron-down text-gray-500"></i>
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
        <section class="flex-grow bg-white rounded-lg p-8 text-sm text-gray-800 shadow-md" id="order-history">
            <h2 class="text-2xl font-semibold mb-8 text-[#27548A] border-b-2 border-[#27548A] pb-2">Order History</h2>
            @if(isset($orders) && count($orders) > 0)
            <div class="overflow-x-auto rounded-lg shadow">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead class="bg-[#f3f6fa]">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-[#27548A] uppercase tracking-wider">Order #</th>
                            <th class="px-6 py-3 text-left font-semibold text-[#27548A] uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left font-semibold text-[#27548A] uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left font-semibold text-[#27548A] uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left font-semibold text-[#27548A] uppercase tracking-wider">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr class="border-t hover:bg-[#f9fafb] transition">
                            <td class="px-6 py-4 font-medium text-gray-700">{{ $order->id ?? $order->id }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $order->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $orderTransaction = $transactions->where('order_id', $order->id)->first();
                                @endphp
                                @if ($orderTransaction)
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if ($orderTransaction->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif ($orderTransaction->status == 'completed') bg-green-100 text-green-800
                                        @elseif ($orderTransaction->status == 'cancelled') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif
                                    ">
                                        {{ ucfirst($orderTransaction->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-700">₱{{ number_format($order->total, 2) }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('profile.viewOrderDetails', $order->id) }}" class="text-[#27548A] hover:underline font-semibold">View Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-gray-500 text-center py-12 text-lg">
                You have no orders yet.
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
