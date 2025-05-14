<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_divisi',
        'id_atasan',
    ];

    public function atasan()
    {
        return $this->belongsTo(User::class, 'id_atasan');
    }
}
