<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOverviewAbouthomeSectionIcons extends Model
{
    use HasFactory;
    
    protected $table = 'product_overview_about_home_section_icons';

    public function products(){
        return $this->belongsTo(products::class, 'id');
    }
}
