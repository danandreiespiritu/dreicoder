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
        <main class="flex-1 overflow-auto bg-gray-100">
            <div class="max-w-7xl mx-auto px-2 sm:px-4">
                <div class="bg-white shadow-md rounded-lg p-4 sm:p-6 mt-4 sm:mt-6">
                    <!-- Search & Filter -->
                    <div class="mb-6">
                        <form action="{{ url('admin/product/search') }}" method="POST" class="flex flex-col gap-4 sm:flex-row sm:items-end bg-gray-50 p-4 rounded-lg shadow-sm">
                            @csrf
                            <div class="w-full sm:flex-1">
                                <label for="product_Name" class="block text-sm font-semibold text-gray-700 mb-2">Search Product</label>
                                <input
                                    type="text"
                                    name="search"
                                    id="product_Name"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter product name"
                                >
                            </div>
                            <div class="w-full sm:w-1/3">
                                <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Select Category</label>
                                <select name="category" id="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                                    <option value="all" {{ (old('category', $category ?? '') == 'all') ? 'selected' : '' }}>All Categories</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ (old('category', $category ?? '') == $cat->id) ? 'selected' : '' }}>
                                            {{ $cat->productCategory }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-full sm:w-auto">
                                <button
                                    type="submit"
                                    class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-300"
                                >
                                    Search
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- Product List Header -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2">
                        <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">Product List</h2>
                        <a href="{{ url('admin/product/add') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-300 text-sm font-medium flex items-center gap-2">
                            <i class="fas fa-plus"></i>
                            <span class="hidden xs:inline">Add Product</span>
                        </a>
                    </div>
                    <hr class="bg-gray-300 border-0 h-px my-4">
                    <!-- Product Cards Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 auto-rows-fr">
                        @if($products && $products->count())
                            @foreach($products as $product)
                            <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform transform hover:scale-[1.02] hover:shadow-xl flex flex-col border border-gray-100">
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $product->Image) }}" alt="{{ $product->ProductName }}" class="w-full h-40 sm:h-48 object-cover rounded-t-lg">
                                    @foreach ($categories as $category)
                                        @if($category->id == $product->category_id)
                                        <div class="absolute top-0 left-0 bg-indigo-600 text-white text-xs font-semibold px-2 py-1 rounded-br-lg">Category: {{ $category->productCategory }}</div>
                                        @endif
                                    @endforeach
                                    @if($product->created_at >= \Carbon\Carbon::now()->subDays(7))
                                    <div class="absolute top-2 right-2 bg-green-500 text-white text-xs font-semibold px-2 py-1 rounded">New</div>
                                    @endif
                                </div>
                                <div class="p-4 flex flex-col flex-grow">
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-1 truncate">{{ $product->ProductName }}</h3>
                                    <p class="text-green-600 font-bold text-lg sm:text-xl mb-2">₱{{ number_format($product->Price, 2) }}</p>
                                    <p class="text-gray-500 text-xs mb-3">Stock: <span class="font-semibold text-gray-700">{{ $product->stock }}</span></p>
                                    <div class="flex flex-col sm:flex-row gap-2 mt-auto">
                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.product.editProduct', $product->id) }}"
                                        class="flex-1 flex items-center justify-center h-10 px-4 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                            <i class="fas fa-edit mr-2"></i> Edit
                                        </a>
                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.product.delete', ['id' => $product->id]) }}" method="POST" class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this product?')"
                                                    class="flex w-full h-10 items-center justify-center px-4 bg-red-500 text-white text-sm font-medium rounded-md hover:bg-red-600 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-400">
                                                <i class="fas fa-trash-alt mr-2"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="bg-white p-4 rounded-lg shadow-md col-span-full text-center">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Product Found</h3>
                                <p class="text-gray-600">Please check back later or add a new product.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
