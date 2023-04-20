<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';  

    public function users(){
        return $this->belongsToMany(User::class, 'user_project', 'project_id');
    }

    


}
