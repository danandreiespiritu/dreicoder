<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <title>Shopping Cart</title>
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
    </div>
    <!-- Header with logo and search -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-[1200px] mx-auto flex items-center px-4 py-4 gap-4 justify-between">
            <div class="flex items-center gap-3 shrink-0">
                <a href="/" class="text-[#27548A] font-bold text-2xl sm:text-3xl select-none border-r border-gray-300 pr-4">Ravinal Store</a>
                <span class="text-[#27548A] font-semibold text-lg sm:text-xl select-none">Shopping Cart</span>
            </div>
        </div>
    </header>
    <!-- Main content -->
    <main class="max-w-[1200px] mx-auto px-4 py-6">
        @if($cartItems->isEmpty())
            <div class="text-center py-16">
                <p class="text-gray-500 mb-6 text-lg">Your cart is currently empty.</p>
                <a href="{{ url('user/products') }}" class="inline-block bg-[#2563eb] text-white px-8 py-2 rounded-full text-base font-semibold shadow hover:bg-[#1d4ed8] transition-colors">
                    Go Shopping Now
                </a>
            </div>
            <div class="mt-14">
                <h2 class="text-xl font-semibold mb-6 text-gray-800">You May Also Like</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($products->shuffle()->take(4) as $product)
                    <div class="border border-gray-200 rounded-lg p-4 bg-white shadow hover:shadow-md transition">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-2">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-full text-left" {{ $product->stock < 1 ? 'disabled' : '' }}>
                                <img 
                                    src="{{ asset('storage/' . $product->Image) }}" 
                                    alt="{{ $product->ProductName }}" 
                                    class="w-full h-32 object-cover mb-3 rounded-md {{ $product->stock < 1 ? 'grayscale opacity-60' : '' }}">
                                <h3 class="text-base font-semibold text-gray-800 mb-1 truncate">{{ $product->ProductName }}</h3>
                                <p class="text-[#2563eb] font-bold mb-1">₱{{ number_format($product->Price, 2) }}</p>
                                <p class="text-xs text-gray-500 mb-2 line-clamp-2">{{ $product->Description }}</p>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500">Available: {{ $product->stock }}</span>
                                    @if($product->stock < 1)
                                        <span class="ml-2 text-xs text-red-500 font-semibold">Out of Stock</span>
                                    @endif
                                </div>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
            <footer class="mt-16"></footer>
        @else
            @csrf
            <h2 class="text-2xl font-semibold mb-6 text-gray-800">Your Cart</h2>
            <div class="hidden md:grid grid-cols-[40px_1fr_110px_110px_120px_90px] items-center bg-gray-100 border border-gray-200 rounded-t-lg text-xs text-gray-700 font-medium select-none">
                <div class="pl-4">
                    <input aria-label="Select all products" type="checkbox" id="select-all" class="accent-[#2563eb]"/>
                </div>
                <div class="font-semibold">Product</div>
                <div class="text-center font-semibold">Price</div>
                <div class="text-center font-semibold">Quantity</div>
                <div class="text-center font-semibold">Total Price</div>
                <div class="text-center pr-4 font-semibold">Actions</div>
            </div>
            <!-- Mobile header -->
            <div class="md:hidden flex items-center justify-between bg-gray-100 border border-gray-200 rounded-t-lg px-3 py-2 text-xs font-medium text-gray-700 mb-2">
                <span>Product</span>
                <span>Actions</span>
            </div>
            @foreach($cartItems as $item)
                @if($item->product)
                    <div class="grid md:grid-cols-[40px_1fr_110px_110px_120px_90px] grid-cols-1 items-center px-3 md:px-4 py-3 text-xs text-gray-700 border-b border-gray-100 bg-white">
                        <div class="hidden md:block">
                            <input aria-label="Select product" type="checkbox" name="selected_items[]" value="{{ $item->id }}" class="item-checkbox accent-[#2563eb]" />
                        </div>
                        <div class="flex gap-3 items-center">
                            <img alt="{{ $item->product->ProductName }}" class="flex-shrink-0 w-14 h-14 object-cover rounded" src="{{ asset('storage/' . $item->product->Image) }}"/>
                            <div class="leading-tight">
                                <div class="line-clamp-2 max-w-[180px] font-semibold text-gray-800">{{ $item->product->ProductName }}</div>
                                <div class="md:hidden mt-1 text-[#2563eb] font-bold">₱{{ number_format($item->product->Price, 2) }}</div>
                                <div class="md:hidden mt-1 text-xs text-gray-500">Qty: {{ $item->quantity }}</div>
                                <div class="md:hidden mt-1 text-xs text-gray-500">Total: <span class="text-[#2563eb] font-semibold">₱{{ number_format($item->quantity * $item->product->Price, 2) }}</span></div>
                            </div>
                        </div>
                        <div class="text-center font-semibold hidden md:block">₱{{ number_format($item->product->Price, 2) }}</div>
                        <div class="flex items-center justify-center gap-1 hidden md:flex">
                            <form method="POST" action="{{ route('cart.update', $item->id) }}" class="inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="action" value="decrease" class="border border-gray-300 rounded-l px-2 py-0.5 text-sm text-gray-600 hover:bg-gray-100">−</button>
                                <input aria-label="Quantity" class="w-8 text-center border-t border-b border-gray-300 text-xs focus:outline-none" readonly type="text" value="{{ $item->quantity }}"/>
                                <button type="submit" name="action" value="increase" class="border border-gray-300 rounded-r px-2 py-0.5 text-sm text-gray-600 hover:bg-gray-100">+</button>
                            </form>
                        </div>
                        <div class="text-center font-semibold text-[#2563eb] hidden md:block">
                            ₱{{ number_format($item->quantity * $item->product->Price, 2) }}
                        </div>
                        <div class="text-center text-xs text-[#2563eb] cursor-pointer select-none flex justify-end">
                            <form method="POST" action="{{ route('cart.remove', $item->id) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </div>
                        <!-- Mobile quantity controls -->
                        <div class="md:hidden mt-2 flex items-center gap-2">
                            <form method="POST" action="{{ route('cart.update', $item->id) }}" class="flex items-center gap-1">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="action" value="decrease" class="border border-gray-300 rounded-l px-2 py-0.5 text-sm text-gray-600 hover:bg-gray-100">−</button>
                                <input aria-label="Quantity" class="w-8 text-center border-t border-b border-gray-300 text-xs focus:outline-none" readonly type="text" value="{{ $item->quantity }}"/>
                                <button type="submit" name="action" value="increase" class="border border-gray-300 rounded-r px-2 py-0.5 text-sm text-gray-600 hover:bg-gray-100">+</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="px-4 py-3 text-xs text-red-600 flex justify-between items-center bg-red-50 border border-red-200 rounded">
                        This product is no longer available.
                        <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Remove</button>
                        </form>
                    </div>
                @endif
            @endforeach

            <div class="mt-6 bg-white border border-gray-200 rounded-lg flex flex-wrap items-center gap-3 px-4 py-4 text-xs text-gray-700 select-none shadow">
                <div class="flex items-center gap-2">
                    <input aria-label="Select all items" type="checkbox" id="select-all-bottom" class="accent-[#2563eb]"/>
                    <span>Select All</span>
                    <form id="delete-selected-form" method="POST" action="{{ route('cart.delete.selected') }}">
                        @csrf
                        <input type="hidden" name="selected_items" id="selected-items" value=""/>
                        <button type="button" class="hover:underline text-red-600 font-semibold" onclick="deleteSelectedItems()">Delete</button>
                    </form>
                </div>
                <div class="flex-grow"></div>
                <form action="{{ route('user.product.checkout') }}" method="get" id="checkout">
                    <div class="flex items-center gap-2 whitespace-nowrap">
                        <span class="hidden sm:inline">Total ({{ count($cartItems) }} item{{ count($cartItems) > 1 ? 's' : '' }}):</span>
                        @foreach (session('checkout_data', []) as $item)
                            <input type="hidden" name="product_names[]" value="{{ $item['productName'] }}">
                            <input type="hidden" name="prices[]" value="{{ $item['price'] }}">
                            <input type="hidden" name="quantities[]" value="{{ $item['quantity'] }}">
                            <input type="hidden" name="subtotals[]" value="{{ $item['subtotal'] }}">
                        @endforeach
                        <span class="text-[#2563eb] font-bold text-lg">₱{{ number_format($cartItems->sum(function($item) { return $item->quantity * $item->product->Price; }), 2) }}</span>
                        <button aria-label="Check Out" type="submit" class="bg-[#2563eb] text-white px-8 py-2 rounded-full text-base font-semibold shadow hover:bg-[#1d4ed8] transition-colors">Check Out</button>
                    </div>
                </form>
            </div>
        @endif
    </main>
    <script>
        const selectAllTop = document.getElementById('select-all');
        const selectAllBottom = document.getElementById('select-all-bottom');
        const checkboxes = document.querySelectorAll('.item-checkbox');

        function toggleCheckboxes(checked) {
            checkboxes.forEach(cb => cb.checked = checked);
        }

        selectAllTop?.addEventListener('change', e => {
            toggleCheckboxes(e.target.checked);
            if (selectAllBottom) selectAllBottom.checked = e.target.checked;
        });

        selectAllBottom?.addEventListener('change', e => {
            toggleCheckboxes(e.target.checked);
            if (selectAllTop) selectAllTop.checked = e.target.checked;
        });

        function deleteSelectedItems() {
            const selectedIds = Array.from(checkboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);
            document.getElementById('selected-items').value = selectedIds.join(',');
            if (selectedIds.length > 0) {
                document.getElementById('delete-selected-form').submit();
            } else {
                alert('Please select at least one item to delete.');
            }
        }

        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');

        userMenuButton.addEventListener('click', () => {
            const isVisible = userMenu.classList.contains('opacity-100');
            if (isVisible) {
                userMenu.classList.remove('opacity-100', 'visible');
                userMenu.classList.add('opacity-0', 'invisible');
            } else {
                userMenu.classList.remove('opacity-0', 'invisible');
                userMenu.classList.add('opacity-100', 'visible');
            }
        });

        document.addEventListener('click', (event) => {
            if (!userMenu.contains(event.target) && !userMenuButton.contains(event.target)) {
                userMenu.classList.remove('opacity-100', 'visible');
                userMenu.classList.add('opacity-0', 'invisible');
            }
        });
    </script>
</body>
</html>