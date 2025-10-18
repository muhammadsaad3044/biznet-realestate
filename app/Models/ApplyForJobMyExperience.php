<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplyForJobMyExperience extends Model
{
    use HasFactory;

    public function applyforjob(){
        return $this->belongsTo(ApplyForJob::class);
    }
    
}
