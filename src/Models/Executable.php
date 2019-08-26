<?php

namespace PandoApps\Quiz\Models;

use Illuminate\Database\Eloquent\Model;

class Executable extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'executables';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'executable_id',
        'executable_type',
        'questionnaire_id',
        'score'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'          => 'integer',
        'name'        => 'string',
        'description' => 'string',
        'score'       => 'float'
    ];

    /**
     * Get the questionnaire of the alternative.
     */
    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }

}
