<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\Transaction;
class AdminController extends Controller
{
    public function index()
    {
        $dates = \App\Models\Order::select(\DB::raw('DATE(created_at) as date'), \DB::raw('SUM(total) as total'))
            ->groupBy(\DB::raw('DATE(created_at)'))
            ->orderBy('date', 'desc')
            ->take(30)
            ->get();

        $previousDayRevenue = $dates->get(1)->total ?? 0;
        $currentDayRevenue = $dates->get(0)->total ?? 0;

        $percentageChange = 0;
        if ($previousDayRevenue > 0) {
            $percentageChange = (($currentDayRevenue - $previousDayRevenue) / $previousDayRevenue) * 100;
        }

        return view('admin.index', compact('dates', 'percentageChange'));
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.product.viewUser')->with('success', 'User deleted successfully');
    }

    public function editProductView($id)
    {
        $product = Product::findOrFail($id);
        $categories = ProductCategory::all();
        $ProductBrand = ProductBrand::all();
        return view('admin.product.editProduct', compact('product', 'categories', 'ProductBrand'));
    }

    public function editProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'ProductName' => 'required|string|max:255',
            'Price' => 'required|numeric|min:0',
            'Description' => 'required|string',
            'category_id' => 'required|exists:product_categories,id',
            'productBrandID' => 'required|exists:product_brands,id',
            'stock' => 'required|integer|min:0',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('Image')) {
            $imagePath = $request->file('Image')->store('products', 'public');
            $validated['Image'] = $imagePath;
        }

        $product->update($validated);

        return redirect()->route('admin.product.adminViewProduct', $id)->with('success', 'Product updated successfully');
    }

    public function orders()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(12);
        return view('admin.product.orders', compact('orders'));
    }
    
    public function search(Request $request)
    {
        $keyword = $request->input('q');

        if ($keyword) {
            $orders = Order::with('orderItems.product')
                ->whereHas('orderItems.product', function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%{$keyword}%");
                })
                ->get();
        } else {
            $orders = Order::with('orderItems.product')->get();
        }

        return view('admin.product.orders', compact('orders', 'keyword'));
    }

    public function viewOrder($id)
    {
    $order = Order::with('orderItems.product')->findOrFail($id);
    $orders = Order::with('orderItems.product')->get();
    $orderItems = OrderItem::where('order_id', $id)->get();
    $uniqueItems = collect();
    foreach ($orders as $orderLoop) {
        foreach ($orderLoop->orderItems as $item) {
            if (!$uniqueItems->contains('product_id', $item->product_id)) {
                $uniqueItems->push($item);
            }
        }
    }
    $Transaction = Transaction::find($id);
    // Pass to the view
    return view('admin.product.transaction', compact('order', 'orders', 'uniqueItems', 'orderItems', 'Transaction'));
}

    public function order_details($order_id) {
        $order = Order::find($order_id);

        $orderItems = OrderItem::where('order_id', $order_id)->orderBy('id')->paginate(12);
        $transaction = Transaction::where('order_id', $order_id)->first();
        return view('admin.product.transaction', compact('order', 'orderItems', 'transaction'));
    }
     public function complete(Order $order)
    {
        $transaction = Transaction::where('order_id', $order->id)->first();
        if ($transaction) {
            $transaction->status = 'completed';
            $transaction->save();
        }
        $order->delivery_date = now();
        $order->save();

        return redirect()->route('admin.product.orders')->with('success', 'Order marked as completed.');
    }

    public function cancel(Order $order)
    {
        $transaction = Transaction::where('order_id', $order->id)->first();
        if ($transaction) {
            $transaction->status = 'cancelled';
            $transaction->save();
        }
        $order->cancellation_date = now();
        $order->save();

        return redirect()->route('admin.product.orders')->with('success', 'Order has been cancelled.');
    }
}
