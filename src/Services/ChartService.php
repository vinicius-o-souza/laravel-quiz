<?php

namespace PandoApps\Quiz\Services;

use Ghunti\HighchartsPHP\HighchartJsExpr;
use Ghunti\HighchartsPHP\Highchart;

class ChartService
{

    private $possible_options = ['title', 'subtitle', 'plotOptions', 'credits', 'xAxis', 'yAxis', 'zAxis', 'legend', 'series', 'tooltip'];


    public function renderChart($chart_data) {
        // uniq id fot the chart
        $id = uniqid();

        // create a highchart instance
        $chart = new Highchart();

        $chart_render = [
            'renderTo' => 'container-' . $id,
        ];

        $chart_options = array_merge($chart_render, $chart_data['chart_options']);
        $chart->chart = $chart_options;

        // set the chart options and its values
        foreach ($this->possible_options as $value) {
            if (isset($chart_data[$value])) {
                $chart->$value = $chart_data[$value];
            }
        }

        return [
            'chart_id' => $id,
            'chart_data' => $chart->render(),
        ];
    }

    /**
     * Generates a pie chart.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPieChart($params)
    {
        return [
            'chart_options' => [
                'type' => 'pie'
            ],
            'title' => [
                'text' => $params['chart-title']
            ],
            'tooltip' => [
                'pointFormat'  => '<span style="font-size:12px;"><b>{series.name}:</b> {point.y:,.2f}%</span>'
            ],
            'plotOptions' => [
                'pie' => [
                    'allowPointSelect' => true,
                    'cursor' => 'pointer',
                    'dataLabels' => [
                        'enabled'=> false
                    ],
                    'showInLegend'=> true
                ]
            ],
            'series' => $params['series']
        ];
    }

    /**
     * Generates a column chart which has values on Y axis.
     *
     * @return \Illuminate\Http\Response
     */
    public function getColumnChart($params)
    {
        return [
            'chart_options' => [
                'type' => 'column'
            ],
            'plotOptions' => [
                'column' => [
                    'depth' => 10,
                    'dataLabels' => [
                        'allowOverlap' => true,
                        'enabled' => true,
                        'useHTML' => true,
                        'crop' => false,
                        'overflow' => 'allow',
                        'formatter' => new HighchartJsExpr("function() {
                            var height = (this.point.shapeArgs.height/2)+12;
                            return '<div style=\"position:relative; top:30px; font-size:13px; color:#000000; font-weight:bold; text-align:center;\">'+Highcharts.numberFormat(this.point.y,1)+'%</div><br/><div style=\"position:relative; top:'+height+'px; font-size:13px; color:#FFFFFF; font-weight:bold; text-align:center; transform:rotate(270deg);\">'+Highcharts.numberFormat(this.point.total,0)+'</div>';
                        }")
                    ]
                ]
            ],
            'title' => [
                'text' => $params['chart-title'],
            ],
            'xAxis' => [
                'lineColor' => '#000000',
                'lineWidth' => '1',
                'startOnTick' => false,
                'endOnTick' => false,
                'categories' => $params['x-axis-categories']
            ],
            'yAxis' => [
                'maxPadding' => 0,
                'min' => 0,
                'lineColor' => '#000000',
                'lineWidth' => '1',
                'title' => [
                    'text' => ''
                ],
                'labels' => [
                    'formatter' => new HighchartJsExpr("function() {
                        return '' + Highcharts.numberFormat(this.value,0) + '%';
                    }")
                ]
            ],
            'legend' => [
                'layout'        => 'horizontal',
                'align'         => 'center',
                'verticalAlign' => 'bottom',
                'borderWidth'   => 2
            ],
            'series' => $params['series'],
            'tooltip' => [
                'enabled' => false,
                'shared' => false
            ]
        ];
    }
}
