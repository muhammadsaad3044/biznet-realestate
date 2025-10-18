<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterQuestions extends Model
{
    use HasFactory;
    
    
    protected $table = 'register_questions';
    
    protected $fillable = ['user_type', 'question'];
    
    
    public function options(){
        return $this->hasMany(RegisterQuestionsOptions::class, 'question_id');
    }
    

    
}
