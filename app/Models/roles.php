<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class roles extends Model
{
    use HasFactory;

    public function users(){
        return $this->hasMany(User::class, 'id');
    }
    
    public function permissions(){
        return $this->hasMany(permissions::class, 'role_id');
    }
    
}
