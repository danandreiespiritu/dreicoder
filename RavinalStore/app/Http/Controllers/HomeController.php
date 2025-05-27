<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductCategory;


class HomeController extends Controller
{
    public function userDashboard() {
        $categories = ProductCategory::all();
        $products = Product::with('category')->get();
    
        return view('user.product.userDashboard', compact('products', 'categories'));
    }
    public function viewUser() {
        $users = User::all();
        return view('admin.product.viewUser', compact('users'));
    }
    public function guestShop(Request $request)
    {
        $categoryId = $request->input('category_id');

        $products = Product::with('category')
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->get();

        $categories = ProductCategory::all();

        return view('guest.guestShop', compact('products', 'categories'));
    }
    public function guestDashboard() {
        $categories = ProductCategory::all();
        $products = Product::with('category')->get();
    
        return view('guestDashboard', compact('products', 'categories'));
    }
    public function userViewProduct() {
        $products = Product::all();
        return view('user.product.userViewProduct', compact('products'));
    }
}
