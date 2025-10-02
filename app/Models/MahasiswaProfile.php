<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MahasiswaProfile extends Model
{
    protected $table = 'mahasiswa_profiles';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nim',
        'prodi',
        'semester',
        'whatsapp',
        'gender',
        'ipk',
        'cek_min_semester',
        'cek_ipk_nilaisks',
        'cek_valid_biodata',
        'dospem_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dospem()
    {
        return $this->belongsTo(User::class, 'dospem_id');
    }
}
