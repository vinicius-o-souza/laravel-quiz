<?php

namespace PandoApps\Quiz\Services;

use Illuminate\Support\Facades\Redis;
use PandoApps\Quiz\Helpers\Helpers;

class ExecutionTimeService
{
    
    /**
     * Return if can execute again the questionnaire
     *
     * @var Questionnaire $questionnaire
     * @var $modelId
     * @return boolean
     */
    public function canExecutionAgain(Questionnaire $questionnaire, $modelId) 
    {
        $executionsModel = $questionnaire->executables()->where('executable_id', $modelId)->orderBy('pivot_created_at', 'desc')->get();
        
        if (!$executionsModel->isEmpty() && isset($questionnaire->type_waiting_time)) {
            $lastExecution = $executionsModel->first();
            $createAtPlusWaitingTime = Helpers::handlePlusTime($lastExecution->pivot->created_at, $questionnaire->type_waiting_time, $questionnaire->waiting_time);
            if ($createAtPlusWaitingTime > now()) {
                flash('Você não pode responder o questionário novamente. Volte novamente dia '. $createAtPlusWaitingTime->format('d/m/Y') .'!')->error();

                return false;
            }
        }
        return true;
    }
    
    /**
     * Set the values of the timer of questionnaire in redis cache
     *
     * @var Questionnaire $questionnaire
     * @var $modelId
     * @return void
     */
    public function startRedisCache($questionnaire, $modelId) 
    {
        $ttl = 60*60;
        $redisKey = 'timer:'. $questionnaire->id .':' . $modelId;
        if(Redis::get($redisKey)) {
            $redisValue = Redis::get($redisKey);
        } else {
            $redisValue = Helpers::handleTypeTime($questionnaire->waiting_time, $questionnaire->type_waiting_time);
        }
        Redis::set($redisKey, $ttl, $redisValue);           
    }
}
