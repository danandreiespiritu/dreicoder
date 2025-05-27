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
    <!-- Dashboard Content -->
    <main class="flex-grow container mx-auto px-2 sm:px-4 py-8">
        <div class="bg-white shadow-lg rounded-xl p-4 sm:p-8 max-w-2xl md:max-w-3xl lg:max-w-4xl mx-auto">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800 text-center mb-6 sm:mb-8">Add Product</h1>
            <form method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label for="ProductName" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1">Product Name</label>
                        <input type="text" name="ProductName" id="ProductName" required
                            class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm" placeholder="Enter product name">
                    </div>
                    <div>
                        <label for="Price" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1">Product Price</label>
                        <input type="number" name="Price" id="Price" required min="0"
                            class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm" placeholder="Enter price">
                    </div>
                </div>
                <div>
                    <label for="Description" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1">Product Description</label>
                    <textarea name="Description" id="Description" rows="3" required
                        class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm resize-none" placeholder="Describe your product"></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label for="productBrandID" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1">Select Brand</label>
                        <select name="productBrandID" id="productBrandID"
                            class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                            @foreach ($ProductBrand as $b)
                                <option value="{{ $b->id }}" {{ (old('ProductBrand', $b->id ?? '') == $b->id) ? 'selected' : '' }}>
                                    {{ $b->productBrandName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="category_id" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1">Product Category</label>
                        <select name="category_id" id="category_id" required
                            class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ (old('category_id', $category->id ?? '') == $category->id) ? 'selected' : '' }}>
                                    {{ $category->productCategory }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label for="Image" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1">Product Image</label>
                        <input 
                            type="file" 
                            name="Image" 
                            id="Image" 
                            required
                            class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition"
                        />
                    </div>
                    <div>
                        <label for="stock" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1">Stock</label>
                        <input 
                            type="number" 
                            name="stock" 
                            id="stock" 
                            required 
                            min="0"
                            class="w-full px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
                            placeholder="Enter stock quantity"
                        />
                    </div>
                </div>
                <div>
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg font-semibold text-base transition duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm">
                        Submit
                    </button>
                </div>
                @if(session('success'))
                    <div class="bg-green-100 text-green-800 font-medium text-center py-3 rounded mt-4 text-sm">
                        {{ session('success') }}
                    </div>
                @endif
            </form>
        </div>
    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</html>


        

