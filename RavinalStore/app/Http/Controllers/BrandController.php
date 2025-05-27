<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductBrand;

class BrandController extends Controller
{
    public function adminAddBrand()
    {
        return view('admin.brand.addBrand');
    }

    public function adminStoreBrand(Request $request)
    {
        $request->validate([
            'productBrandName' => 'required|string|max:255',
            'Description' => 'nullable|string|max:1000',
        ]);
        
        ProductBrand::create([
            'productBrandName' => $request->input('productBrandName'),
            'Description' => $request->input('Description'),
        ]);

        return redirect()->route('admin.brand.addBrand')->with('success', 'Brand added successfully.');
    }
}
