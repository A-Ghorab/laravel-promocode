<?php

return [
    'models' => [
        'promocodes' => [
            'model' => \AGhorab\LaravelPromocode\Models\Promocode::class,
            'table_name' => 'promocodes',
            'bound_to_user_id_foreign_id' => 'bounded_to_user_id',
            'id' => 'id',
        ],

        'users' => [
            'model' => \App\Models\User::class,
            'table_name' => 'users',
            'id' => 'id',
        ],

        'promocode_usage_table' => [
            'model' => \AGhorab\LaravelPromocode\Models\PromocodeUsage::class,
            'table_name' => 'promocode_usage',
            'promocode_foreign_id' => 'promocode_id',
            'user_id_foreign_id' => 'user_id',
        ],
    ],
];
