<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;


    public function images(){
        return $this->hasMany(productImage::class, 'pd_id');
    }
    
    
    public function overview_sales(){
        return $this->hasMany(ProductOverviewSalesSection::class, 'p_id');
    }
    
    
    
    public function overview_home_tags(){
        return $this->hasMany(ProductOverviewAbouthomeSectiontags::class, 'pd_id');
    }
    
    
    public function overview_home_icons(){
        return $this->hasMany(ProductOverviewAbouthomeSectionIcons::class, 'p_id');
    }
    
    public function overview_comments(){
        return $this->hasMany(ProductNeighborhoodCommentSection::class, 'p_id');
    }
    
    
    public function categories(){
        return $this->hasOne(Category::class, 'id', 'cat_id');
    }
    
    public function talk_to_agent(){
        return $this->hasMany(TalkToAgent::class, 'p_id');
    }
    
    
        
    public function apartmentsbtcity(){
        return $this->belongsTo(AppartmentByCity::class, 'id');
    }
    
    
    public function homebycity(){
        return $this->belongsTo(HomeByCity::class, 'id');
    }
    
    
    
    public function rentbycity(){
        return $this->belongsTo(RentByCity::class, 'id');
    }
    
     public function offers()
    {
        return $this->hasMany(Offer::class);
    }
    

}
