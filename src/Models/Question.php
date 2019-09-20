<?php

namespace PandoApps\Quiz\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'questions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_active',
        'description',
        'hint',
        'is_required',
        'question_type_id',
        'questionnaire_id',
        'weight'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                => 'integer',
        'descripton'        => 'string',
        'hint'              => 'string',
        'is_required'       => 'boolean',
        'is_active'         => 'boolean',
        'weight'            => 'float',
        'question_type_id'  => 'integer',
        'questionnaire_id'  => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'description' => 'required',
        'weight' => 'required',
        'question_type_id' => 'required'
    ];

    /**
     * Get the questionnaires of the question.
     */
    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }

    /**
     * Get the question_type of the question.
     */
    public function questionType()
    {
        return $this->belongsTo(QuestionType::class);
    }

    /**
     * Get the alternatives for the question.
     */
    public function alternatives()
    {
        return $this->hasMany(Alternative::class);
    }

    /**
     * Get the answers for the question.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    
    /**
     * Return if question is closed type
     */
    public function isClosed() {
        return $this->question_type_id == config('quiz.question_types.CLOSED.id');
    }
}
