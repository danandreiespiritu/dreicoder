<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class CartItem extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    protected $fillable = ['user_id', 'product_id', 'quantity'];
    protected $table = 'cart_items';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
