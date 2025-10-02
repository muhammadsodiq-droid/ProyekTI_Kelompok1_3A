<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPkl extends Model
{
    protected $table = 'laporan_pkl';
    public $timestamps = false;

    protected $fillable = [
        'mahasiswa_id',
        'file_path',
        'status_validasi',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }
}
