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
     * Get the question of the alternative.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
