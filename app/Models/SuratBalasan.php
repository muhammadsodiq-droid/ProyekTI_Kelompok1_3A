<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratBalasan extends Model
{
    protected $table = 'surat_balasan';
    public $timestamps = false;

    protected $fillable = [
        'mahasiswa_id',
        'mitra_id',
        'mitra_nama_custom',
        'file_path',
        'status_validasi',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }
}
