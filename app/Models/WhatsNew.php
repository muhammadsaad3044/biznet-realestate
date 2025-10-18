<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsNew extends Model
{
    use HasFactory;

    public function images(){
        return $this->hasMany(WhatsNewImages::class, 'whats_new_id');
    }
}
