<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOverviewAbouthomeSectiontags extends Model
{
    use HasFactory;
    
    protected $table = 'product_overview_about_home_section_tags';
    
    public function products(){
        return $this->belongsTo(products::class, 'id');
    }
    
}
