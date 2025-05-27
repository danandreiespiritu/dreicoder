<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>
   Dashboard
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link rel="icon" type="image/png" href="{{ asset('storage/images/ravinallogo.jpg') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&amp;display=swap" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
<main class="p-6 space-y-8 overflow-auto bg-[#f8fafc]">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Orders -->
        <div class="bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl p-5 shadow flex items-center gap-4 border border-blue-200">
            <div class="bg-blue-600 text-white rounded-full p-3 shadow">
                <i class="far fa-calendar-check text-2xl"></i>
            </div>
            <div>
                <div class="text-xs text-blue-700 font-semibold uppercase tracking-wide">Total Orders</div>
                <div class="font-bold text-2xl text-blue-900">{{ \App\Models\Order::count() }}</div>
            </div>
        </div>
        <!-- Delivered Orders -->
        <div class="bg-gradient-to-br from-green-100 to-green-50 rounded-xl p-5 shadow flex items-center gap-4 border border-green-200">
            <div class="bg-green-600 text-white rounded-full p-3 shadow">
                <i class="fas fa-truck text-2xl"></i>
            </div>
            <div>
                <div class="text-xs text-green-700 font-semibold uppercase tracking-wide">Delivered Orders</div>
                <div class="font-bold text-2xl text-green-900">{{ \App\Models\Transaction::where('status', 'completed')->count() }}</div>
            </div>
        </div>
        <!-- Total Amount -->
        <div class="bg-gradient-to-br from-yellow-100 to-yellow-50 rounded-xl p-5 shadow flex items-center gap-4 border border-yellow-200">
            <div class="bg-yellow-500 text-white rounded-full p-3 shadow">
                <i class="fas fa-dollar-sign text-2xl"></i>
            </div>
            <div>
                <div class="text-xs text-yellow-700 font-semibold uppercase tracking-wide">Total Amount</div>
                <div class="font-bold text-2xl text-yellow-900">₱{{ number_format(\App\Models\Order::sum('total'), 2) }}</div>
            </div>
        </div>
        <!-- Delivered Orders Amount -->
        <div class="bg-gradient-to-br from-purple-100 to-purple-50 rounded-xl p-5 shadow flex items-center gap-4 border border-purple-200">
            <div class="bg-purple-600 text-white rounded-full p-3 shadow">
                <i class="fas fa-hand-holding-usd text-2xl"></i>
            </div>
            <div>
                <div class="text-xs text-purple-700 font-semibold uppercase tracking-wide">Delivered Orders Amount</div>
                <div class="font-bold text-2xl text-purple-900">
                    ₱{{ number_format(\App\Models\Order::whereHas('transaction', function($q) { $q->where('status', 'completed'); })->sum('total'), 2) }}
                </div>
            </div>
        </div>
        <!-- Pending Orders -->
        <div class="bg-gradient-to-br from-orange-100 to-orange-50 rounded-xl p-5 shadow flex items-center gap-4 border border-orange-200">
            <div class="bg-orange-500 text-white rounded-full p-3 shadow">
                <i class="fas fa-hourglass-half text-2xl"></i>
            </div>
            <div>
                <div class="text-xs text-orange-700 font-semibold uppercase tracking-wide">Pending Orders</div>
                <div class="font-bold text-2xl text-orange-900">{{ \App\Models\Transaction::where('status', 'pending')->count() }}</div>
            </div>
        </div>
        <!-- Cancelled Orders -->
        <div class="bg-gradient-to-br from-red-100 to-red-50 rounded-xl p-5 shadow flex items-center gap-4 border border-red-200">
            <div class="bg-red-500 text-white rounded-full p-3 shadow">
                <i class="fas fa-times-circle text-2xl"></i>
            </div>
            <div>
                <div class="text-xs text-red-700 font-semibold uppercase tracking-wide">Cancelled Orders</div>
                <div class="font-bold text-2xl text-red-900">{{ \App\Models\Transaction::where('status', 'cancelled')->count() }}</div>
            </div>
        </div>
        <!-- Pending Orders Amount -->
        <div class="bg-gradient-to-br from-cyan-100 to-cyan-50 rounded-xl p-5 shadow flex items-center gap-4 border border-cyan-200">
            <div class="bg-cyan-500 text-white rounded-full p-3 shadow">
                <i class="fas fa-coins text-2xl"></i>
            </div>
            <div>
                <div class="text-xs text-cyan-700 font-semibold uppercase tracking-wide">Pending Orders Amount</div>
                <div class="font-bold text-2xl text-cyan-900">
                    ₱{{ number_format(\App\Models\Order::whereHas('transaction', function($q) { $q->where('status', 'pending'); })->sum('total'), 2) }}
                </div>
            </div>
        </div>
        <!-- Cancelled Orders Amount -->
        <div class="bg-gradient-to-br from-gray-100 to-gray-50 rounded-xl p-5 shadow flex items-center gap-4 border border-gray-200">
            <div class="bg-gray-500 text-white rounded-full p-3 shadow">
                <i class="fas fa-ban text-2xl"></i>
            </div>
            <div>
                <div class="text-xs text-gray-700 font-semibold uppercase tracking-wide">Cancelled Orders Amount</div>
                <div class="font-bold text-2xl text-gray-900">
                    ₱{{ number_format(\App\Models\Order::whereHas('transaction', function($q) { $q->where('status', 'cancelled'); })->sum('total'), 2) }}
                </div>
            </div>
        </div>
    </div>
    <!-- Earnings Revenue Section -->
    <section class="bg-white rounded-2xl p-8 shadow max-w-5xl w-full mx-auto border border-gray-100">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
            <h2 class="font-bold text-gray-900 text-xl flex items-center gap-2">
                <i class="fas fa-chart-line text-blue-600"></i>
                Earnings Revenue
            </h2>
            <button aria-label="More options" class="text-gray-400 hover:text-gray-600 self-end md:self-auto">
                <i class="fas fa-ellipsis-h"></i>
            </button>
        </div>
        <div class="flex flex-wrap items-center gap-8 text-xs text-gray-500 mb-6 select-none">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-blue-600 inline-block"></span>
                Revenue
            </div>
            <div class="font-bold text-gray-900 text-lg flex items-center gap-2">
                ₱{{ number_format(\App\Models\Order::whereHas('transaction', function($q) { $q->where('status', 'completed'); })->sum('total'), 2) }}
                <i class="fas fa-arrow-up text-green-500 text-xs"></i>
                <span class="text-green-500 text-xs font-semibold">
                    {{ number_format($percentageChange, 2) }}%
                </span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-gray-300 inline-block"></span>
                Order Subtotal
            </div>
            <div class="font-bold text-gray-900 text-lg flex items-center gap-2">
                ₱{{ number_format(\App\Models\Order::whereHas('transaction', function($q) { $q->where('status', 'completed'); })->sum('subtotal'), 2) }}
                <i class="fas fa-arrow-up text-green-500 text-xs"></i>
                <span class="text-green-500 text-xs font-semibold">
                    {{ number_format($percentageChange, 2) }}%
                </span>
            </div>
        </div>
        <div class="mt-6">
            <canvas id="revenueChart" height="80"></canvas>
        </div>
    </section>
</main>
  </div>
 </body>
  <script>
      const revenueData = @json($dates);
      const labels = revenueData.map(item => item.date);
      const data = revenueData.map(item => item.total);

      const ctx = document.getElementById('revenueChart').getContext('2d');
      const revenueChart = new Chart(ctx, {
          type: 'line',
          data: {
              labels: labels,
              datasets: [{
                  label: 'Revenue',
                  data: data,
                  borderColor: 'rgb(75, 192, 192)',
                  fill: false,
                  tension: 0.1
              }]
          },
          options: {
              responsive: true,
              scales: {
                  y: {
                      beginAtZero: true
                  }
              }
          }
      });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</html>