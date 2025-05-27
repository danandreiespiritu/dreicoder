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
        <aside x-show="sidebarOpen" class="bg-white w-56 min-h-screen flex flex-col border-r border-gray-200" x-transition>
        <!-- Header -->
        <header class="flex items-center justify-center py-6 border-b border-gray-200">
            <a href="{{ url('admin/dashboard') }}" class="text-lg font-bold">Ravinal Store</a>
        </header>

        <!-- Navigation -->
        <nav class="flex flex-col px-4 py-6 space-y-2 text-sm font-medium text-gray-700">
            <div class="text-gray-400 text-[10px] font-normal mb-1">MAIN HOME</div>

            <!-- Dashboard Link -->
            <a href="{{ url('admin/dashboard') }}" class="flex items-center gap-2 py-2 px-2 rounded hover:bg-gray-100 font-semibold">
                <i class="fas fa-th-large text-base"></i>
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
            @endphp

            @foreach ($dropdowns as $label => $items)
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center justify-between w-full py-2 px-2 rounded hover:bg-gray-100">
                    <div class="flex items-center gap-2 font-semibold">
                        <i class="fas fa-box-open text-base"></i>
                        {{ $label }}
                    </div>
                    <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas text-xs text-gray-500"></i>
                </button>
                <div x-show="open" @click.away="open = false" x-transition class="mt-1 bg-white rounded shadow border border-gray-200">
                    @foreach ($items as [$text, $link])
                    <a href="{{ url($link) }}" class="block px-4 py-2 text-sm hover:bg-gray-100">{{ $text }}</a>
                    @endforeach
                </div>
            </div>
            @endforeach

            <!-- Order -->
            <a href="{{ url('admin/product/orders') }}" class="flex items-center gap-2 py-2 px-2 rounded hover:bg-gray-100 font-semibold">
                <i class="fas fa-shopping-cart text-base"></i>
                Order
            </a>

            <!-- User -->
            <a href="{{ url('admin/product/viewUser') }}" class="flex items-center gap-2 py-2 px-2 rounded hover:bg-gray-100 font-semibold">
                <i class="fas fa-user text-base"></i>
                User
            </a>

            <!-- Settings -->
            <button type="button" class="flex items-center gap-2 py-2 px-2 rounded hover:bg-gray-100 font-semibold">
                <i class="fas fa-cog text-base"></i>
                Settings
            </button>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-2 py-2 px-2 rounded hover:bg-gray-100 font-semibold w-full">
                    <i class="fas fa-sign-out-alt text-base"></i>
                    Logout
                </button>
            </form>
        </nav>
    </aside>
    <!-- Main content -->
    <div class="flex-1 flex flex-col">
    <!-- Top bar -->
    <header class="flex items-center justify-between bg-white px-6 py-3 border-b border-gray-200">
            <div class="flex items-center gap-4">
                <button class="text-gray-500 hover:text-gray-700" @click="sidebarOpen = !sidebarOpen">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h1 class="text-lg font-semibold">Edit Product</h1>
            </div>
        <div class="flex items-center gap-6 ml-6">
            <div class="flex items-center gap-3 cursor-pointer select-none">
                <img alt="" class="w-8 h-8 rounded-full object-cover" height="32" src="{{ asset(Auth::user()->image) }}" width="32"/>
                <div class="text-right">
                    <div class="text-sm font-semibold text-gray-900 leading-none">
                    {{ ucwords(Auth::user()->name ?? 'Guest') }}
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Dashboard Content -->
    <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-12 flex items-start justify-center">
        <div class="bg-gray-50 shadow-md rounded-lg p-8 w-full max-w-3xl border border-gray-200">
            <h1 class="text-3xl font-semibold text-gray-900 text-center mb-6">Edit Product</h1>
            <form action="{{ route('admin.product.editProduct', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="ProductName" class="block text-sm font-medium text-gray-800 mb-1">Product Name</label>
                        <input type="text" name="ProductName" id="ProductName" value="{{ old('ProductName', $product->ProductName) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" />
                    </div>
                    <div>
                        <label for="Price" class="block text-sm font-medium text-gray-800 mb-1">Product Price</label>
                        <input type="number" name="Price" id="Price" value="{{ old('Price', $product->Price) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" />
                    </div>
                </div>

                <div>
                    <label for="Description" class="block text-sm font-medium text-gray-800 mb-1">Product Description</label>
                    <textarea name="Description" id="Description" rows="4" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">{{ old('Description', $product->Description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="productBrandID" class="block text-sm font-medium text-gray-800 mb-1">Select Brand</label>
                        <select name="productBrandID" id="productBrandID" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            @foreach ($ProductBrand as $b)
                                <option value="{{ $b->id }}" {{ old('productBrandID', $product->productBrandID) == $b->id ? 'selected' : '' }}>
                                    {{ $b->productBrandName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-800 mb-1">Product Category</label>
                        <select name="category_id" id="category_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->productCategory }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="flex flex-col justify-end">
                            <label for="Image" class="block text-sm font-medium text-gray-700 mb-1">Product Image</label>
                            <input 
                                type="file" 
                                name="Image" 
                                id="Image" 
                                class="w-full h-12 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition"
                            />
                        </div>
                        <div class="flex flex-col justify-end">
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                            <input 
                                type="number" 
                                name="stock" 
                                id="stock" 
                                value="{{ old('stock', $product->stock) }}"
                                min="0"
                                class="w-full h-12 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            />
                        </div>
                    </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Save Changes
                </button>

                @if(session('success'))
                    <div class="bg-green-100 text-green-800 font-medium text-center py-3 rounded mt-6">
                        {{ session('success') }}
                    </div>
                @endif
            </form>
        </div>
    </main>

    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</html>