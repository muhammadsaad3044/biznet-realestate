<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joblocation extends Model
{
    use HasFactory;

    public function jobs(){
        return $this->belongsTo(Jobs::class, 'id');
    }

}
