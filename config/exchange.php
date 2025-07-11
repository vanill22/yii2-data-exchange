<?php

use app\exchanges\category\CategoryDeltaImport;
use app\exchanges\category\CategoryFullImport;
use app\exchanges\orders\OrderExport;
use app\exchanges\orders\OrderImport;
use app\exchanges\products\ProductDeltaImport;
use app\exchanges\products\ProductFullImport;

return [
    'exchanges' => [
        'productFullImport' => [
            'class' => ProductFullImport::class,
            'schedule' => '0 1 * * *', // каждый день в 01:00
        ],
        'productDeltaImport' => [
            'class' => ProductDeltaImport::class,
            'schedule' => '*/10 * * * *', // каждые 10 минут
        ],
        'categoryFullImport' => [
            'class' => CategoryFullImport::class,
            'schedule' => '0 1 * * *',
        ],
        'categoryDeltaImport' => [
            'class' => CategoryDeltaImport::class,
            'schedule' => '*/10 * * * *',
        ],
        'orderImport' => [
            'class' => OrderImport::class,
            'schedule' => '*/5 * * * *',
        ],
        'orderExport' => [
            'class' => OrderExport::class,
            'schedule' => '*/5 * * * *',
        ],
    ],
];