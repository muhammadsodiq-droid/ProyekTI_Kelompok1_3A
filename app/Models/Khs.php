<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Khs extends Model
{
    protected $table = 'khs';
    
    protected $fillable = [
        'mahasiswa_id',
        'file_path',
        'status_validasi',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }
}
