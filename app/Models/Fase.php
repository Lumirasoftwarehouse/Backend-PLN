<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fase extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_fase',
        'deskripsi',
        'lampiran',
        'status',
        'id_user',
        'id_project',
    ];
}
