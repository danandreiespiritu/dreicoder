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
            <div class="flex flex-col items-center justify-center min-h-[70vh]">
                <div class="w-full max-w-md bg-white p-4 sm:p-6 md:p-8 rounded-lg shadow-lg">
                    <form method="POST" action="{{ route('admin.category.store') }}" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold mb-4 text-gray-800 text-center">Add Category</h1>

                        <div>
                            <label for="productCategory" class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                            <input type="text" name="productCategory" id="productCategory" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base transition">
                        </div>
                        <div>
                            <label for="Description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <input type="text" name="Description" id="Description" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base transition">
                        </div>
                        <button type="submit"
                            class="w-full bg-indigo-600 text-white py-2 sm:py-3 rounded-lg font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-300 text-sm sm:text-base">
                            Submit
                        </button>

                        @if(session('success'))
                            <div class="bg-green-500 text-white p-3 rounded-lg mt-2 text-center text-sm">
                                {{ session('success') }}
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </main>
    </div>
 </body>
</html>