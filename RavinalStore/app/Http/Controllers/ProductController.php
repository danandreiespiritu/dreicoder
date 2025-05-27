<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use App\Models\ProductBrand;

class ProductController extends Controller
{
    public function adminEditProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = ProductCategory::all();
        return view('admin.product.edit', compact('product', 'categories'));
    }
    public function userViewProduct()
    {
        $categories = ProductCategory::all();
        $products = Product::with('category')->get();
    
        return view('user.product.userViewProduct', compact('products', 'categories'));
    }
    public function userViewFeaturedProducts($id)
    {
        // For example, get related or featured products
        $product = Product::findOrFail($id);
        $products = Product::where('category_id', $product->category_id)
                        ->where('id', '!=', $product->id)
                        ->take(8)
                        ->get();

        $categories = ProductCategory::all();
        return view('user.product.userViewProduct', compact('products', 'categories', 'product'));
    }


    public function userSearchProduct(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        $categories = ProductCategory::all();

        $products = Product::with('category')
            ->when($search, function ($query) use ($search) {
                $query->where('ProductName', 'LIKE', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('ProductCategory', 'LIKE', "%{$search}%");
                    });
            })
            ->when($category && $category !== 'all', function ($query) use ($category) {
                $query->where('category_id', $category);
            })
            ->get();

        return view('user.product.userViewProduct', compact('products', 'categories', 'category'));
    }
    public function adminAddProduct()
    {   
        $ProductBrand = ProductBrand::all();
        $categories = ProductCategory::all();
        return view('admin.product.add', compact('categories', 'ProductBrand'));
    }
    public function adminViewProduct(Request $request)
    {
        $categoryId = $request->input('category_id');

        $products = Product::with('category')
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->get();

        $categories = ProductCategory::all();

        return view('admin.product.adminViewProduct', compact('products', 'categories', 'categoryId'));
    }
   
    public function userViewProductByCategory($categoryId)
    {
        $categories = ProductCategory::all();
        $products = Product::with('category')
            ->where('category_id', $categoryId)
            ->get();
        return view('user.product.userViewProduct', compact('products', 'categories'));
    }
    public function adminSearchProduct(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        $categories = ProductCategory::all();

        $products = Product::with('category')
            ->when($search, function ($query) use ($search) {
                $query->where('ProductName', 'LIKE', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('ProductCategory', 'LIKE', "%{$search}%");
                    });
            })
            ->when($category && $category !== 'all', function ($query) use ($category) {
                $query->where('category_id', $category);
            })
            ->get();

        return view('admin.product.adminViewProduct', compact('products', 'categories', 'category'));
    }
    

    public function adminDeleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }
    
    public function Search(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        $categories = ProductCategory::all();

        $products = Product::with('category')
            ->when($search, function ($query) use ($search) {
                $query->where('ProductName', 'LIKE', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('ProductCategory', 'LIKE', "%{$search}%");
                    });
            })
            ->when($category && $category !== 'all', function ($query) use ($category) {
                $query->where('category_id', $category);
            })
            ->get();

        return view('user.product.userViewProduct', compact('products', 'categories', 'category'));
    }
    public function adminStoreProduct(Request $request)
    {
        $request->validate([
            'ProductName' => 'required|string|max:255',
            'Price' => 'required|numeric|min:0',
            'Description' => 'required|string',
            'category_id' => 'required|exists:product_categories,id',
            'productBrandID' => 'required|exists:product_brands,id',
            'Image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('Image')) {
            $image = $request->file('Image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images', $imageName, 'public');

            Product::create([
                'ProductName' => $request->ProductName,
                'Price' => $request->Price,
                'Description' => $request->Description,
                'brand_id' => $request->productBrandID,
                'category_id' => $request->category_id,
                'Image' => $imagePath,
                'stock' => $request->stock,
            ]);            

            return redirect()->back()->with('success', 'Product added successfully!');
        }

        return redirect()->back()->with('error', 'Image upload failed!');
    }
}
