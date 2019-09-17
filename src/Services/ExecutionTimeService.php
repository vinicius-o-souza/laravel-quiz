<?php

namespace PandoApps\Quiz\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use PandoApps\Quiz\Helpers\Helpers;
use PandoApps\Quiz\Models\Executable;
use PandoApps\Quiz\Models\Questionnaire;

class ExecutionTimeService
{

    /**
     * Get the key of questionnaire and modelId redis cache
     *
     * @var Questionnaire
     * @var
     * @return void
     */
    public function handleIfHasExecutableNotAnswered($questionnaire, $modelId)
    {
        $executable = Executable::whereNull('answered')->where('questionnaire_id', $questionnaire->id)
                                ->where('executable_id', $modelId)
                                ->where('executable_type', config('quiz.models.executable'))->first();
        $timer = Helpers::timePlusTypeTime(Carbon::now(), $questionnaire->execution_time, $questionnaire->type_execution_time);
        if (!empty($executable) && $timer < Carbon::now()) {
            $executable->update(['answered' => false]);
        }
    }
        
    /**
     * Get the key of questionnaire and modelId redis cache
     *
     * @var Questionnaire
     * @var
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
     * @var Questionnaire
     * @var
     * @return void
     */
    public function startRedisCache($questionnaire, $modelId)
    {
        $ttl = $this->ttl($questionnaire->execution_time, $questionnaire->type_execution_time);
        $redisKey = 'timer:'. $questionnaire->id .':' . $modelId;
        if (Redis::get($redisKey)) {
            return Redis::get($redisKey);
        }
        $redisValue = Helpers::timePlusTypeTime(Carbon::now(), $questionnaire->execution_time, $questionnaire->type_execution_time);
        Redis::setEx($redisKey, $ttl, $redisValue);
        return Redis::get($redisKey);
    }
    
    /**
     * Delete the redis key of questionnaire
     *
     * @var Questionnaire
     * @var
     * @return void
     */
    public function deleteRedisKey($questionnaire, $modelId)
    {
        $redisKey = 'timer:'. $questionnaire->id .':' . $modelId;
        if (Redis::get($redisKey)) {
            Redis::del($redisKey);    
        }
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
