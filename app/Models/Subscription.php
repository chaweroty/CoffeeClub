<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $table = 'subscriptions'; 
    protected $fillable = ['preferences', 'start_date', 'cart_product_id', 'payment_method_id'];

    public function cartProduct()
    {
        return $this->belongsTo(CartProduct::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}