<?php

namespace PandoApps\Quiz\Models;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'questionnaires';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_active',
        'name',
        'answer_once',
        'parent_id',
        'parent_type',
        'waiting_time',
        'type_waiting_time',
        'execution_time',
        'type_execution_time'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                    => 'integer',
        'name'                  => 'string',
        'answer_once'           => 'boolean',
        'waiting_time'          => 'integer',
        'type_waiting_time'     => 'integer',
        'execution_time'        => 'integer',
        'type_execution_time'   => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];


    /**
     * Get the questions for the questionnaire.
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get the polymorfic model for the questionnaire.
     */
    public function executables()
    {
        return $this->morphedByMany(config('quiz.models.executable'), 'executable')->withPivot('score');
    }
    
    /**
     * Return type time
     *
     * @var int
     * @return string
     */
    public function handleTypeTime($typeTime)
    {
        switch ($typeTime) {
            case config('quiz.type_time.MINUTES.id'):
                return config('quiz.type_time.MINUTES.name');
            case config('quiz.type_time.HOURS.id'):
                return config('quiz.type_time.HOURS.name');
            case config('quiz.type_time.DAYS.id'):
                return config('quiz.type_time.DAYS.name');
            case config('quiz.type_time.MONTHS.id'):
                return config('quiz.type_time.MONTHS.name');
            case config('quiz.type_time.YEARS.id'):
                return config('quiz.type_time.YEARS.name');
        }
    }
}
