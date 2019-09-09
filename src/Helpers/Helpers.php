<?php

namespace PandoApps\Quiz\Helpers;

use Carbon\Carbon;

class Helpers
{
    
    /**
     * Return time plus another time in some type time
     *
     * @return Carbon
     */
    public static function timePlusTypeTime($time, $timePlus, $type_time)
    {
        switch ($type_time) {
            case config('quiz.type_time.MINUTES.id'):
                return $time->copy()->addMinutes($timePlus);
            case config('quiz.type_time.HOURS.id'):
                return $time->copy()->addHours($timePlus);
            case config('quiz.type_time.DAYS.id'):
                return $time->copy()->addDays($timePlus);
            case config('quiz.type_time.MONTHS.id'):
                return $time->copy()->addMonths($timePlus);
            case config('quiz.type_time.YEARS.id'):
                return $time->copy()->addYears($timePlus);
        }
    }
}
