<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_Category extends Model
{
    use HasFactory;
    protected $table = 'sub_categories';
    
    protected $fillable = [
        'cat_id',
        'sub_title',
        ];
        
    protected $casts = [
        'cat_id' => 'integer',
        'sub_title' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
        
    public function category(){
        return $this->belongsTo(Category::class);
    }
        
    
}
