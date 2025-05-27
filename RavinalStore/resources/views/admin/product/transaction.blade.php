<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Order Details - Admin</title>
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

        <!-- Content -->
    <main class="p-4 md:p-8 space-y-6 overflow-auto">
        <div class="bg-white shadow rounded-lg p-4 md:p-8">
            <h2 class="text-xl md:text-2xl font-semibold mb-4">Order Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="flex justify-between items-center">
                    <span class="font-medium text-gray-600">Order ID:</span>
                    <span class="text-gray-900">{{ $order->id }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="font-medium text-gray-600">Customer Name:</span>
                    <span class="text-gray-900">{{ $order->user->name ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="font-medium text-gray-600">Total Amount:</span>
                    <span class="text-gray-900">₱{{ number_format($order->total, 2) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="font-medium text-gray-600">Status:</span>
                    <span class="text-gray-900">{{ $order->status }}</span>
                </div>
            </div>
            <h3 class="text-lg md:text-xl font-semibold mt-6 mb-4">Shipping Address</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="flex justify-between items-center">
                    <span class="font-medium text-gray-600">Address:</span>
                    <span class="text-gray-900 text-right">{{ $order->address }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="font-medium text-gray-600">City:</span>
                    <span class="text-gray-900">{{ $order->city }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="font-medium text-gray-600">State:</span>
                    <span class="text-gray-900">{{ $order->state }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="font-medium text-gray-600">Zip Code:</span>
                    <span class="text-gray-900">{{ $order->zip }}</span>
                </div>
                <div class="flex justify-between items-center md:col-span-2">
                    <span class="font-medium text-gray-600">Country:</span>
                    <span class="text-gray-900">{{ $order->country }}</span>
                </div>
            </div>

            <h3 class="text-lg md:text-xl font-semibold mt-6 mb-4">Products</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 text-left rounded-lg overflow-hidden">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-2 px-3 md:px-4 border-b text-xs md:text-sm">Product Name</th>
                            <th class="py-2 px-3 md:px-4 border-b text-xs md:text-sm">Quantity</th>
                            <th class="py-2 px-3 md:px-4 border-b text-xs md:text-sm">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $orderItem)
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-3 md:px-4 border-b text-xs md:text-sm">{{ $orderItem->product->ProductName ?? 'N/A' }}</td>
                                <td class="py-2 px-3 md:px-4 border-b text-xs md:text-sm">{{ $orderItem->quantity }}</td>
                                <td class="py-2 px-3 md:px-4 border-b text-xs md:text-sm">₱{{ number_format($orderItem->price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <h3 class="text-lg md:text-xl font-semibold mt-6 mb-4">Status</h3>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 mb-6">
                <span class="font-medium text-gray-600">Current Status:</span>
                @php
                    $status = strtolower($Transaction->status);
                    $color = $status === 'completed' ? 'text-green-600' : ($status === 'cancelled' ? 'text-red-600' : 'text-gray-600');
                @endphp
                <span class="{{ $color }} font-semibold text-base">{{ $Transaction->status }}</span>
            </div>

            <h3 class="text-lg md:text-xl font-semibold mt-6 mb-4">Transaction Actions</h3>
            <div class="flex flex-col sm:flex-row gap-3 mt-2">
                <form method="POST" action="{{ route('admin.order.complete', $order->id) }}">
                    @csrf
                    <button type="submit" class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded transition">
                        Mark as Completed
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.order.cancel', $order->id) }}">
                    @csrf
                    <button type="submit" class="w-full sm:w-auto bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded transition">
                        Cancel Order
                    </button>
                </form>
            </div>
        </div>
    </main>
    </div>
</body>
</html>
