<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogsImages extends Model
{
    use HasFactory;

    public function blogs(){
        return $this->hasOne(Blogs::class, 'id');
    }
}
