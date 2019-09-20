<?php

namespace PandoApps\Quiz\Services;

use DB;
use PandoApps\Quiz\Models\Answer;
use PandoApps\Quiz\Models\Executable;
use PandoApps\Quiz\Services\AnswersChartService;
use PandoApps\Quiz\Services\ChartService;

class StatisticsService
{
    public function getSummary(AnswersChartService $answersChartService, ChartService $chartService, $questionnaire) 
    {    
        $executablesSummary = [];
        foreach ($questionnaire->questions as $question) {
            $executablesSummary[$question->id] = [];
            if($question->isClosed()) {
                $executablesSummary[$question->id] = $answersChartService->getChart($chartService, $question);
            } else {
                $answers = Answer::where('question_id', $question->id)->get();
                $executablesSummary[$question->id]['answers'] = $answers;
                $executablesSummary[$question->id]['count'] = $answers->count();
            }
        }
        return $executablesSummary;
    }
    
    public function getIndividual(AnswersChartService $answersChartService, $questionnaire, $modelId)
    {
        $executablesIndividual = Executable::where('questionnaire_id', $questionnaire->id)
                                            ->whereHas('answers')
                                            ->orderBy('created_at', 'ASC');        
        if ($modelId) {
            $executablesIndividual->where('executable_id', $modelId);
        }
        $executablesIndividual = $executablesIndividual->paginate(1);
        
        return $executablesIndividual;
    }
}
