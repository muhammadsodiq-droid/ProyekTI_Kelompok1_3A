<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentFormItem extends Model
{
    protected $table = 'assessment_form_items';
    public $timestamps = false;

    protected $fillable = [
        'form_id',
        'label',
        'type',
        'weight',
        'required',
        'sort_order',
    ];

    public function form()
    {
        return $this->belongsTo(AssessmentForm::class, 'form_id');
    }
}
