<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\User;

class CategoryController extends Controller
{
    public function adminAddCategory()
    {
        return view('admin.category.addCategory');
    }
    public function adminStoreCategory(Request $request)
    {
        $request->validate([
            'productCategory' => 'required|string|max:255',
            'Description' => 'nullable|string|max:1000',
        ]);

        ProductCategory::create([
            'productCategory' => $request->input('productCategory'),
            'Description' => $request->input('Description'),
        ]);

        return redirect()->route('admin.category.addCategory')->with('success', 'Category added successfully.');
    }

    public function adminCategoryList() {
        $categoryId = $request->input('category_id');

        $products = Product::with('category')
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->get();

        $categories = ProductCategory::all();

        return view('admin.product.adminViewProduct', compact('products', 'categories'));
    }
    public function userCategoryList(Request $request) {
        $categoryId = $request->input('category');
    
        $products = Product::with('category')
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->get();
    
        $categories = ProductCategory::all();
    
        return view('user.product.userViewProduct', compact('products', 'categories'));
    }
}
