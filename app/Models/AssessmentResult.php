<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentResult extends Model
{
    protected $table = 'assessment_results';
    public $timestamps = false;

    protected $fillable = [
        'form_id',
        'mahasiswa_user_id',
        'total_percent',
        'letter_grade',
        'gpa_point',
        'decided_at',
        'decided_by',
    ];

    public function form()
    {
        return $this->belongsTo(AssessmentForm::class, 'form_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_user_id');
    }

    public function decidedBy()
    {
        return $this->belongsTo(User::class, 'decided_by');
    }
}
