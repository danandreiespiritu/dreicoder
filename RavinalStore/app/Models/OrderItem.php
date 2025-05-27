<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id', 'order_id', 'price'
        ,'quantity', 'options', 'rstatus'
    ];
    
    protected $casts = [
    'options' => 'array',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }   
    
    public function review()
    {
        return $this->hasOne(Review::class,'order_item_id');
    }
}
