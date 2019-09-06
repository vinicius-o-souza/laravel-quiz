<?php

namespace PandoApps\Quiz\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use PandoApps\Quiz\Helpers\Helpers;
use PandoApps\Quiz\Models\Questionnaire;

class ExecutionTimeService
{
    
    /**
     * Return if can execute again the questionnaire
     *
     * @var Questionnaire $questionnaire
     * @var $modelId
     * @var $executionsModel
     * @return boolean
     */
    public function canExecutionAgain(Questionnaire $questionnaire, $modelId, $executionsModel) 
    {   
        if (!$executionsModel->isEmpty() && isset($questionnaire->type_waiting_time)) {
            $lastExecution = $executionsModel->first();
            $createAtPlusWaitingTime = Helpers::timePlusTypeTime($lastExecution->pivot->created_at, $questionnaire->waiting_time, $questionnaire->type_waiting_time);
            if ($createAtPlusWaitingTime > now()) {
                flash('Você não pode responder o questionário novamente. Volte novamente dia '. $createAtPlusWaitingTime->format('d/m/Y') .'!')->error();

                return false;
            }
        }
        return true;
    }
    
    /**
     * Get the key of questionnaire and modelId redis cache
     *
     * @var Questionnaire $questionnaire
     * @var $modelId
     * @return void
     */
    public function getRedisCache($questionnaire, $modelId) 
    {
        $redisKey = 'timer:'. $questionnaire->id .':' . $modelId;
        return Redis::get($redisKey);
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
        $ttl = $this->ttl($questionnaire->execution_time, $questionnaire->type_execution_time);
        $redisKey = 'timer:'. $questionnaire->id .':' . $modelId;
        $redisValue = Helpers::timePlusTypeTime(Carbon::now(), $questionnaire->execution_time, $questionnaire->type_execution_time);
        Redis::setEx($redisKey, $ttl, $redisValue);
        return Redis::get($redisKey);
    }
    
    private function ttl($time, $typeTime)
    {
        switch ($typeTime) {
            case config('quiz.type_time.MINUTES.id'):
                return $time * 60;
            case config('quiz.type_time.HOURS.id'):
                return $time * 3600;
            case config('quiz.type_time.DAYS.id'):
                return $time * 86400;
            return 9999999;
        }
    }
}
