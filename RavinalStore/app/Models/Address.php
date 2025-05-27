<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;

class Address extends Model
{
    protected $fillable = [
        'id','user_id', 'name', 'phone', 'address', 'city', 'state', 'zip', 'country', 'isdefault'
    ];
    protected $table = 'address';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    
}
