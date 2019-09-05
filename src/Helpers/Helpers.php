<?php

namespace App\Helpers;

use Carbon\Carbon;
 
class Helpers {
    
    /**
     * Return time plus another time in some type time
     *
     * @return Carbon
     */
    public function handlePlusTime($time, $type_time, $timePlus)
    {
        switch ($type_time) {
            case config('quiz.type_time.MINUTES.id'):
                return $created_at->copy()->addMinutes($timePlus);
            case config('quiz.type_time.HOURS.id'):
                return $created_at->copy()->addHours($timePlus);
            case config('quiz.type_time.DAYS.id'):
                return $created_at->copy()->addDays($timePlus);
            case config('quiz.type_time.MONTHS.id'):
                return $created_at->copy()->addMonths($timePlus);
            case config('quiz.type_time.YEARS.id'):
                return $created_at->copy()->addYears($timePlus);
        }
    }
    
    public function handleTypeTime($time, $type_time) 
    {
        switch ($type_time) {
            case config('quiz.type_time.MINUTES.id'):
                return Carbon::now()->addMinutes($timePlus);
            case config('quiz.type_time.HOURS.id'):
                return Carbon::now()->addHours($timePlus);
            case config('quiz.type_time.DAYS.id'):
                return Carbon::now()->addDays($timePlus);
            case config('quiz.type_time.MONTHS.id'):
                return Carbon::now()->addMonths($timePlus);
            case config('quiz.type_time.YEARS.id'):
                return Carbon::now()->addYears($timePlus);
        }
    }
}