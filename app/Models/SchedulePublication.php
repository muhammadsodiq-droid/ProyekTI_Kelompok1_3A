<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchedulePublication extends Model
{
    protected $table = 'schedule_publications';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'subtitle',
        'kind',
        'file_path',
        'external_url',
        'visibility',
        'is_active',
        'published_at',
        'created_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
