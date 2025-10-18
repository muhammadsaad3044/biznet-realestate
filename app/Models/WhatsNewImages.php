<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsNewImages extends Model
{
    use HasFactory;

    public function whatsnew(){
        return $this->hasMany(WhatsNew::class, 'id');
    }

}
