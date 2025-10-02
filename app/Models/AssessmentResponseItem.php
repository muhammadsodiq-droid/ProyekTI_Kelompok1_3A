<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentResponseItem extends Model
{
    protected $table = 'assessment_response_items';
    public $timestamps = false;

    protected $fillable = [
        'response_id',
        'item_id',
        'value_numeric',
        'value_letter',
        'value_bool',
        'value_text',
    ];

    public function response()
    {
        return $this->belongsTo(AssessmentResponse::class, 'response_id');
    }

    public function item()
    {
        return $this->belongsTo(AssessmentFormItem::class, 'item_id');
    }
}
