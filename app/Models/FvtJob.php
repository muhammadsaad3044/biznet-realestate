<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FvtJob extends Model
{
    use HasFactory;

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }


    public function jobs(){
        return $this->belongsTo(Jobs::class, 'job_id');
    }
}
