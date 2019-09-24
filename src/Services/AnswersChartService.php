<?php

namespace PandoApps\Quiz\Services;

use DB;
use Ghunti\HighchartsPHP\HighchartJsExpr;
use Ghunti\HighchartsPHP\Highchart;

class AnswersChartService
{
    public function getChart(ChartService $chartService, $question) 
    {    
        $data = DB::table('alternatives')
                        ->select(
                            'alternatives.description as name',
                            DB::raw('count(answers.alternative_id) as y')
                        )
                        ->leftJoin('answers', 'answers.alternative_id', '=', 'alternatives.id')
                        ->where('alternatives.question_id', $question->id)
                        ->orderBy('name')
                        ->groupBy('name', 'is_correct')
                        ->get()->toArray();

        $total = 0;
        foreach($data as $value) {
            $total += $value->y;
        }
        foreach($data as $value) {
            if($total)
                $value->y = ($value->y * 100 / $total);
        }
        
        $series[] = [
            'name'          => 'Respostas',
            'colorByPoint'  => true,
            'data'          => $data
        ];

        $chartArray = [
            'chart-title'      => '',
            'series'           => $series
        ];

        $chart_data = $chartService->getPieChart($chartArray);
        return [
            'chart' => $chartService->renderChart($chart_data),
            'count' => $total
        ];
    }
}
