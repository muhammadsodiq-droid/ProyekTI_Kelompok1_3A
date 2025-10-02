<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentResponse extends Model
{
    protected $table = 'assessment_responses';
    public $timestamps = false;

    protected $fillable = [
        'form_id',
        'mahasiswa_user_id',
        'dosen_user_id',
        'is_final',
        'submitted_at',
    ];

    public function form()
    {
        return $this->belongsTo(AssessmentForm::class, 'form_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_user_id');
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_user_id');
    }
}
