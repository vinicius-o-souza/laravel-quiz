<?php

namespace PandoApps\Quiz\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'answers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'question_id',
        'executable_id',
        'score',
        'alternative_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                           => 'integer',
        'description'                  => 'string',
        'score'                        => 'float',
        'executable_id'                 => 'integer',
        'alternative_id'               => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'description' => 'required',
        'executable_id' => 'required'
    ];

    /**
     * Get the question of the answer.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the alternative of the answer.
     */
    public function alternative()
    {
        return $this->belongsTo(Alternative::class);
    }

    /**
     * Get the execution of the answer.
     */
    public function executable()
    {
        return $this->belongsTo(Executable::class);
    }
}
