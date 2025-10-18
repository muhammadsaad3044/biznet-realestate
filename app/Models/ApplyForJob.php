<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplyForJob extends Model
{
    use HasFactory;

    public function myinfo(){
        return $this->hasMany(ApplyForJobMyInfo::class, 'appy_for_job_id');
    }


    public function myexperience(){
        return $this->hasMany(ApplyForJobMyExperience::class, 'appy_for_job_id');
    }



    public function application_questions(){
        return $this->hasMany(ApplyForJobApplicationQuestions::class, 'appy_for_job_id');
    }
}
