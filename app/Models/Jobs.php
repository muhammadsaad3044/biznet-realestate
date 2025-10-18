<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    use HasFactory;

    public function job_location(){
        return $this->hasMany(Joblocation::class, 'job_id');
    }
    
    
    public function careers(){
        return $this->hasMany(Careers::class, 'job_id');
    }
    
    public function fvt_jobs(){
        return $this->hasMany(FvtJob::class, 'job_id');
    }

}
