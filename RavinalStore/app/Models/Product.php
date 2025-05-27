<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\ProductBrand;
use App\Models\ProductCategory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['ProductName', 'Price', 'Description', 'brand_id', 'category_id', 'Image', 'stock']; 
    protected $casts = [
        'created_at' => 'datetime',
    ];
    
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
    public function brand()
    {
        return $this->belongsTo(ProductBrand::class, 'brand_id');
    }
    public $timestamps = false; // Disable timestamps
}

