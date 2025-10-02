<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentForm extends Model
{
    protected $table = 'assessment_forms';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];
}
