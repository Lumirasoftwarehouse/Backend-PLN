<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPhase extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'laporan',
        'lampiran',
        'id_user',
        'id_phase',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
