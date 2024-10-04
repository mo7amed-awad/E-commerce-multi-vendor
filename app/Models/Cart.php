<?php

namespace App\Models;

use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory;
    public $incrementing=false;
    protected $guarded=[];

    protected static function booted()
    {
        static::observe(CartObserver::class);
        static::addGlobalScope('cookie_id',function(Builder $builder){
            $builder->where('cookie_id','=',Cart::getCookieId());
        });
        // static::creating(function(Cart $cart){
        //     $cart->id=Str::uuid();
        // });
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name'=>'Anonymous'
        ]);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function getCookieId()
    {
        $cookie_id=Cookie::get('cart_id');
        if(!$cookie_id){
            $cookie_id=Str::uuid();
            Cookie::queue('cart_id',30*24*60);
        }
        return $cookie_id;
    }
}
