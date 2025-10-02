<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';
    public $timestamps = false;

    protected $fillable = [
        'actor_user_id',
        'mahasiswa_id',
        'type',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_user_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }
}
