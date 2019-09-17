<?php

namespace PandoApps\Quiz\Models;

use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alternatives';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'question_id',
        'value',
        'is_correct'
    ];
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'          => 'integer',
        'description' => 'string',
        'value'       => 'float',
        'is_correct'  => 'boolean'
    ];
    
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'description'       => 'required',
        'value'             => 'required|min:0|max:10',
    ];

    /**
     * Get the question of the alternative.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
