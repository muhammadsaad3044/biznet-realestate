<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalkToAgent extends Model
{
    use HasFactory;

    public function products(){
        return $this->belongsTo(product::class, 'p_id');
    }

}
