<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['client', 'project', 'status', 'schedule', 'dueDate'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_projects', 'projectId', 'userId');
    }
}
