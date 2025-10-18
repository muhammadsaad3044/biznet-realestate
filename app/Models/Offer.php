<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;



   protected $fillable = ['product_id', 'offer_price', 'user_id'];

    public function product()
    {
        return $this->belongsTo(product::class);
    }
}
