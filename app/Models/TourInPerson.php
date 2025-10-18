<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourInPerson extends Model
{
    use HasFactory;

    protected $table= 'tour_in_person';


    public function user(){
        return $this->hasMany(User::class, 'id');
    }
}
