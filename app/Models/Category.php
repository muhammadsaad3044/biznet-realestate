<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    

    public function getcategoryname(){
        
        return $this->belongsTo(Category::class);
        
    }
    
    public function sub_categories(){
        
        return $this->hasMany(Sub_Category::class, 'cat_id');
        
    }
    
    
    public function products(){
        
        return $this->belongsTo(product::class, 'cat_id');
        
    }
}
