<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; // Import the HasRoles trait

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles; // Include HasRoles here

    protected $fillable = [
        'image',
        'name',
        'email',
        'usertype',
        'phone',
        'address_id',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
    public function address()
    {
        return $this->hasOne(Address::class)->where('isdefault', '1');
    }

    public function defaultAddress()
    {
        return $this->hasOne(Address::class)->where('isdefault', true);
    }
}
