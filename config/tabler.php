<?php

// config for bytemorphic/Tabler

return [
    /*
    |--------------------------------------------------------------------------
    | Default Styles
    |--------------------------------------------------------------------------
    |
    | These are the default styles that will be used when generating tables
    | and exports.
    |
    */
    'styles' => [
        'table' => [
            'class' => 'min-w-full divide-y divide-gray-200',
        ],
        'thead' => [
            'class' => 'bg-gray-50',
        ],
        'th' => [
            'class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider',
        ],
        'tbody' => [
            'class' => 'bg-white divide-y divide-gray-200',
        ],
        'tr' => [
            'class' => '',
        ],
        'td' => [
            'class' => 'px-6 py-4 whitespace-nowrap',
        ],
        'pagination' => [
            'class' => 'bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Export Drivers
    |--------------------------------------------------------------------------
    |
    | Configure the export drivers available for your tables.
    |
    */
    'exports' => [
        'xlsx' => [
            'driver' => 'excel',
            'extension' => 'xlsx',
            'contentType' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ],
        'csv' => [
            'driver' => 'excel',
            'extension' => 'csv',
            'contentType' => 'text/csv',
        ],
        'pdf' => [
            'driver' => 'dompdf',
            'extension' => 'pdf',
            'contentType' => 'application/pdf',
        ],
    ],
];
