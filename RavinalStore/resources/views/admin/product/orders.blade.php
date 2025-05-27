<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('storage/images/ravinallogo.jpg') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body x-data="{ sidebarOpen: true }" class="bg-[#f0f5f8] min-h-screen flex">
    <!-- Sidebar -->
     <aside x-show="sidebarOpen" class="bg-gradient-to-b from-blue-50 to-white w-64 min-h-screen flex flex-col border-r border-blue-100 shadow-lg z-20" x-transition>
        <!-- Header -->
        <header class="flex items-center justify-center py-8 border-b border-blue-100">
            <a href="{{ url('admin/dashboard') }}" class="flex items-center gap-2 text-2xl font-extrabold text-blue-700 tracking-wide">
                <img src="{{ asset('storage/images/ravinallogo.jpg') }}" alt="Logo" class="w-8 h-8 rounded-full shadow">
                Ravinal Store
            </a>
        </header>

        <!-- Navigation -->
        <nav class="flex flex-col px-6 py-8 space-y-4 text-base font-medium text-blue-900">
            <div class="text-blue-400 text-xs font-semibold mb-2 tracking-widest">MAIN HOME</div>

            <!-- Dashboard Link -->
            <a href="{{ url('admin/dashboard') }}" class="flex items-center gap-3 py-2 px-3 rounded-lg hover:bg-blue-100 transition font-semibold {{ request()->is('admin/dashboard') ? 'bg-blue-100' : '' }}">
                <i class="fas fa-th-large text-lg"></i>
                Dashboard
            </a>

            <!-- Dropdown Item Component -->
            @php
                $dropdowns = [
                    'Products' => [
                        ['Add Products', 'admin/product/add'],
                        ['View Products', 'admin/product/adminViewProduct'],
                    ],
                    'Brand' => [
                        ['Add Brand', 'admin/brand/addBrand'],
                        ['View Brand', '#'],
                    ],
                    'Category' => [
                        ['Add Category', 'admin/category/addCategory'],
                        ['View Category', '#'],
                    ]
                ];
                $dropdownIcons = [
                    'Products' => 'fa-box-open',
                    'Brand' => 'fa-tags',
                    'Category' => 'fa-list-alt'
                ];
            @endphp

            @foreach ($dropdowns as $label => $items)
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center justify-between w-full py-2 px-3 rounded-lg hover:bg-blue-100 transition font-semibold focus:outline-none">
                    <div class="flex items-center gap-3">
                        <i class="fas {{ $dropdownIcons[$label] ?? 'fa-box-open' }} text-lg"></i>
                        {{ $label }}
                    </div>
                    <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs text-blue-400"></i>
                </button>
                <div x-show="open" @click.away="open = false" x-transition class="mt-2 bg-white rounded-lg shadow-lg border border-blue-100 overflow-hidden">
                    @foreach ($items as [$text, $link])
                    <a href="{{ url($link) }}" class="block px-6 py-2 text-sm hover:bg-blue-50 text-blue-800 transition">{{ $text }}</a>
                    @endforeach
                </div>
            </div>
            @endforeach

            <!-- Order -->
            <a href="{{ url('admin/product/orders') }}" class="flex items-center gap-3 py-2 px-3 rounded-lg hover:bg-blue-100 transition font-semibold">
                <i class="fas fa-shopping-cart text-lg"></i>
                Order
            </a>

            <!-- User -->
            <a href="{{ url('admin/product/viewUser') }}" class="flex items-center gap-3 py-2 px-3 rounded-lg hover:bg-blue-100 transition font-semibold">
                <i class="fas fa-user text-lg"></i>
                User
            </a>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 py-2 px-3 rounded-lg hover:bg-red-100 text-red-600 font-semibold w-full transition">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                    Logout
                </button>
            </form>
        </nav>
    </aside>
    <!-- Main content -->
    <div class="flex-1 flex flex-col min-h-screen">
        <!-- Top bar -->
        <header class="flex items-center justify-between bg-white px-8 py-4 border-b border-blue-100 shadow-sm sticky top-0 z-10">
            <div class="flex items-center gap-6">
                <button class="text-blue-600 hover:text-blue-800 focus:outline-none" @click="sidebarOpen = !sidebarOpen">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
                <h1 class="text-2xl font-bold text-blue-800 tracking-tight">Dashboard</h1>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-3 cursor-pointer select-none">
                    <img alt="User" class="w-10 h-10 rounded-full object-cover border-2 border-blue-200 shadow" height="40" src="{{ asset(Auth::user()->image) }}" width="40"/>
                    <div class="text-right">
                        <div class="text-base font-semibold text-blue-900 leading-none">
                            {{ ucwords(Auth::user()->name ?? 'Guest') }}
                        </div>
                        <div class="text-xs text-blue-400">Admin</div>
                    </div>
                </div>
            </div>
        </header>
   <!-- Dashboard content -->
        <main class="p-4 sm:p-6 space-y-6 overflow-auto">
            <div class="main-content-inner">
                <div class="main-content-wrap">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-5 mb-6">
                        <h3 class="text-lg font-semibold">Orders</h3>
                        <ul class="breadcrumbs flex items-center flex-wrap gap-2 text-sm text-gray-600">
                            <li>
                                <a href="{{ url('admin/dashboard') }}" class="hover:text-blue-500">Dashboard</a>
                            </li>
                            <li>
                                <i class="fas fa-chevron-right text-xs"></i>
                            </li>
                            <li>Orders</li>
                        </ul>
                    </div>

                    <div class="bg-white p-3 sm:p-4 rounded shadow">
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 sm:gap-4 flex-wrap">
                            <div class="flex-grow">
                                <form action="{{ route('orders.search') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                                    <input 
                                        type="text" 
                                        name="q" 
                                        value="{{ request('q') }}" 
                                        placeholder="Search here..." 
                                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500" 
                                    >
                                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 flex-shrink-0">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        @if(isset($keyword))
                            <p class="mt-4 text-sm text-gray-500">Showing results for "<strong>{{ $keyword }}</strong>"</p>
                        @endif

                        <!-- Responsive Table -->
                        <div class="overflow-x-auto mt-4">
                            <table class="min-w-full bg-white border border-gray-200 text-sm">
                                <thead class="hidden md:table-header-group">
                                    <tr class="bg-gray-100 text-gray-600">
                                        <th class="px-4 py-2 border">OrderNo</th>
                                        <th class="px-4 py-2 border text-center">Name</th>
                                        <th class="px-4 py-2 border text-center">Phone</th>
                                        <th class="px-4 py-2 border text-center">Subtotal</th>
                                        <th class="px-4 py-2 border text-center">Tax</th>
                                        <th class="px-4 py-2 border text-center">Total</th>
                                        <th class="px-4 py-2 border text-center">Status</th>
                                        <th class="px-4 py-2 border text-center">Order Date</th>
                                        <th class="px-4 py-2 border text-center">Total Items</th>
                                        <th class="px-4 py-2 border text-center">Delivered On</th>
                                        <th class="px-4 py-2 border"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                        <tr class="md:table-row flex flex-col md:flex-row md:items-center border-b md:border-0 mb-4 md:mb-0 bg-white md:bg-transparent shadow md:shadow-none rounded md:rounded-none">
                                            <td class="px-4 py-2 border md:text-center flex md:table-cell justify-between md:justify-center">
                                                <span class="font-semibold md:hidden">OrderNo:</span>
                                                {{ $order->id }}
                                            </td>
                                            <td class="px-4 py-2 border md:text-center flex md:table-cell justify-between md:justify-center">
                                                <span class="font-semibold md:hidden">Name:</span>
                                                {{ $order->name }}
                                            </td>
                                            <td class="px-4 py-2 border md:text-center flex md:table-cell justify-between md:justify-center">
                                                <span class="font-semibold md:hidden">Phone:</span>
                                                {{ $order->phone }}
                                            </td>
                                            <td class="px-4 py-2 border md:text-center flex md:table-cell justify-between md:justify-center">
                                                <span class="font-semibold md:hidden">Subtotal:</span>
                                                ${{ number_format($order->subtotal, 2) }}
                                            </td>
                                            <td class="px-4 py-2 border md:text-center flex md:table-cell justify-between md:justify-center">
                                                <span class="font-semibold md:hidden">Tax:</span>
                                                ${{ number_format($order->tax, 2) }}
                                            </td>
                                            <td class="px-4 py-2 border md:text-center flex md:table-cell justify-between md:justify-center">
                                                <span class="font-semibold md:hidden">Total:</span>
                                                ${{ number_format($order->total, 2) }}
                                            </td>
                                            <td class="px-4 py-2 border md:text-center flex md:table-cell justify-between md:justify-center">
                                                <span class="font-semibold md:hidden">Status:</span>
                                                {{ $order->status }}
                                            </td>
                                            <td class="px-4 py-2 border md:text-center flex md:table-cell justify-between md:justify-center">
                                                <span class="font-semibold md:hidden">Order Date:</span>
                                                {{ $order->created_at }}
                                            </td>
                                            <td class="px-4 py-2 border md:text-center flex md:table-cell justify-between md:justify-center">
                                                <span class="font-semibold md:hidden">Total Items:</span>
                                                @if($order->orderItems && $order->orderItems->count())
                                                    {{ $order->orderItems->sum('quantity') }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 border md:text-center flex md:table-cell justify-between md:justify-center">
                                                <span class="font-semibold md:hidden">Delivered On:</span>
                                                {{ $order->delivery_date ?? 'N/A' }}
                                            </td>
                                            <td class="px-4 py-2 border md:text-center flex md:table-cell justify-between md:justify-center">
                                                <a href="{{ url('admin/product/transaction/' . $order->id) }}" class="text-blue-500 hover:underline">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center p-4 text-gray-500">No orders found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="border-t mt-6"></div>

                    <div class="flex items-center justify-between flex-wrap gap-4 mt-4">
                        <!-- Pagination or additional controls can go here -->
                    </div>
                </div>
            </div>
        </main>
 </body>
</html>


