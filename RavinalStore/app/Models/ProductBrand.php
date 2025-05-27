<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductBrand extends Model
{
    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }

    protected $fillable = [
        'productBrandName',
    ];
}
