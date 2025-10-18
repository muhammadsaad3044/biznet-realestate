<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productImage extends Model
{
    use HasFactory;
    protected $table = 'product_images';
    
    protected $filable = [
        'pd_id',
        'image',
        ];

    public function products(){
        return $this->belongsTo(product::class, 'id');
    }
    
}
