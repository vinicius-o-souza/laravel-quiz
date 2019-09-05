<?php

namespace PandoApps\Quiz\Services;

class DataTablesDefaults
{
    public static function getParameters($params = [])
    {
        $defaults =  [
            'language' => [
                'paginate' => [
                    'next'       => \Lang::get('pandoapps::datatable.next'),
                    'previous'   => \Lang::get('pandoapps::datatable.previous')
                ],
                'buttons' => [
                    'print'      => \Lang::get('pandoapps::datatable.print'),
                    'reload'     => \Lang::get('pandoapps::datatable.reload'),
                    'csv'        => \Lang::get('pandoapps::datatable.csv'),
                    'colvis'     => \Lang::get('pandoapps::datatable.colvis'),
                    'pageLength' => \Lang::get('pandoapps::datatable.page_length')
                ],
                'search'         => \Lang::get('pandoapps::datatable.search'),
                'emptyTable'     => \Lang::get('pandoapps::datatable.empty_table'),
                'info'           => \Lang::get('pandoapps::datatable.info'),
                'infoEmpty'      => \Lang::get('pandoapps::datatable.info_empty'),
                'infoFiltered'   => \Lang::get('pandoapps::datatable.info_filtered'),
                'loadingRecords' => \Lang::get('pandoapps::datatable.loading_records'),
                'processing'     => \Lang::get('pandoapps::datatable.processing'),
                'zeroRecords'    => \Lang::get('pandoapps::datatable.zero_records')
            ],
            'dom' => 'Bfrtip',
            'order' => [
                [0, 'asc']
            ],
            'pageLength' => 25,
            'buttons' => [
                'print',
                'reload',
                'csv',
                'colvis',
                'pageLength'
            ]
        ];

        foreach ($params as $key => $value) {
            $defaults[$key] = $value;
        }

        return $defaults;
    }
}
