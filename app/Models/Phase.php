<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    use HasFactory;

    protected $fillable = [
        "phase", 
        "start_date", 
        "end_date", 
        "start_time",
        "end_time",
        "repeat",
        "notes",
        "id_project"
    ];
}
