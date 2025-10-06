<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'price',
        'description',
        'stock',
        'image',
        'user_id',
        'category_id'
    ];
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }
    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

     protected static function booted()
    {
        static::creating(function ($product) {
            $product->slug = Str::slug($product->title);
        });
    }
}
