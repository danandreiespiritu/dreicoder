<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        
        $Items = Cart::instance('cart')->content();
        
        $products = Product::all();

        $cartItems = CartItem::where('user_id', Auth::id())
            ->whereHas('product')
            ->with('product')
            ->get();

        // Prepare checkout data and map it for the session
        $checkoutData = $cartItems->map(function ($item) {
            return [
                'productName' => $item->product->ProductName,
                'price' => $item->product->Price,
                'quantity' => $item->quantity,
                'subtotal' => $item->product->Price * $item->quantity,
            ];
        });

        // Store the checkout data in the session
        session(['checkout_data' => $checkoutData]);
        // Pass necessary data to the view
        return view('user.product.userCart', compact('cartItems', 'products', 'Items', 'checkoutData'));
    }


   public function add(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $item = CartItem::firstOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $productId],
            ['quantity' => 0]
        );

        $item->quantity += $request->input('quantity');
        $item->save();

        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }

    public function remove($id)
    {
        $item = CartItem::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $item->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    public function update(Request $request, $id)
    {
        $item = CartItem::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $product = $item->product;

        if ($request->input('action') === 'increase') {
            if ($item->quantity < $product->stock) {
                $item->quantity += 1;
            } else {
                return redirect()->route('cart.index')->with('error', 'Cannot add more than available stock.');
            }
        } elseif ($request->input('action') === 'decrease') {
            $item->quantity = max(1, $item->quantity - 1);
        }

        $item->save();

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }

    public function deleteSelected(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|string',
        ]);

        $ids = array_filter(explode(',', $request->input('selected_items')));
        if (empty($ids)) {
            return redirect()->back()->with('error', 'No items selected for deletion.');
        }

        CartItem::whereIn('id', $ids)->where('user_id', auth()->id())->delete();
        
        return redirect()->back()->with('success', 'Selected items deleted successfully.');
    }

    public function checkoutView()
    {   
        $cartItems = CartItem::where('user_id', Auth::id())
            ->whereHas('product')
            ->with('product')
            ->get();

        $address = Address::where('user_id', Auth::id())->where('isdefault', true)->first();
        Cart::instance('cart')->destroy();
        return view('user.product.checkout', compact('cartItems', 'address'));
    }

    public function place_an_order(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to be logged in to place an order.');
        }

        $user_id = Auth::id();

        $address = Address::where('user_id', $user_id)->where('isdefault', true)->first();

        if (!$address) {
            $request->validate([
                'name' => 'required',
                'phone' => 'required',
                'zip' => 'required',
                'state' => 'required',
                'city' => 'required',
                'address' => 'required',
                'country' => 'required',
            ]);

            $address = new Address();
            $address->user_id = $user_id;
            $address->name = $request->name;
            $address->phone = $request->phone;
            $address->zip = $request->zip;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->country = $request->country;
            $address->address = $request->address;
            $address->isdefault = true;
            $address->save();
        }

        $this->setAmountforCheckout();
        
        // Retrieving session data for checkout
        $checkout_data = session('checkout_data', []);

        // Calculating totals based on session data
        $subtotal = 0;
        foreach ($checkout_data as $item) {
            $subtotal += $item['subtotal'];
        }
        $tax = $subtotal * 0.12; // Assuming tax is 12%
        $total = $subtotal + $tax;

        $order = new Order();
        $order->user_id = $user_id;
        $order->subtotal = $subtotal;
        $order->tax = $tax;
        $order->total = $total;
        $order->name = $address->name;
        $order->phone = $address->phone;
        $order->address = $address->address;
        $order->city = $address->city;
        $order->state = $address->state;
        $order->zip = $address->zip;
        $order->country = $address->country ?? '';
        $order->type = $address->type ?? '';
        $order->save();

        foreach ($checkout_data as $item) {
            $product = Product::where('ProductName', $item['productName'])->first();
            if ($product) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $product->id;
                $orderItem->price = $product->Price;
                $orderItem->quantity = $item['quantity'];
                $orderItem->options = json_encode($item['options'] ?? []);
                $orderItem->rstatus = 'pending';
                $orderItem->save();

                // Update product stock
                $product->stock = max(0, $product->stock - $item['quantity']);
                $product->save();
            }
        }

        // Validating transaction mode
        $request->validate([
            'mode' => 'required|in:Cash on delivery,gcash',
        ]);

        // Saving the transaction
        $transaction = new Transaction();
        $transaction->user_id = $user_id;
        $transaction->order_id = $order->id;
        $transaction->mode = $request->mode;
        $transaction->status = "pending";
        $transaction->save();

        CartItem::where('user_id', Auth::id())->delete();
        // Redirecting to confirmation page
        return redirect()->route('user.product.order_confirmation', compact('order'))->with('success', 'Order placed successfully.');
    }


    public function setAmountforCheckout(): bool
    {   
        if (!Cart::instance('cart')->content()->count() > 0) {
            Session::forget('checkout');
            return false;
        }

        $subtotal = 0;
        foreach (Cart::instance('cart')->content() as $item) {
            $subtotal += $item->price * $item->qty;
        }

        $tax = $subtotal * 0.10;
        $total = $subtotal + $tax;

        Session::put('checkout', [
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
        ]);

        return true;
    }

    public function order_confirmation()
    {
        $order = Order::where('user_id', Auth::id())->latest()->first();
        $transaction = Transaction::where('user_id', Auth::id())->latest()->first();
        
        $orderItem = OrderItem::with('product')->where('order_id', $order->id)->get();
        
        return view('user.product.order_confirmation', compact('order', 'transaction', 'orderItem'));
    }

}
