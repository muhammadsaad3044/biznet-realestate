<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductNeighborhoodCommentSection extends Model
{
    use HasFactory;
    
    protected $table = 'product_neighborhood_comment_sections';

    public function products(){
        return $this->belongsTo(products::class, 'id');
    }
}
