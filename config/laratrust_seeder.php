<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'super_admin' => [
            'users' => 'c,r,u,d',
            'categories' => 'c,r,u,d',
            'delegates'=>'c,r,u,d',
            'stores' => 'c,r,u,d',
            'offers' => 'c,r,u,d',
            'ads' => 'c,r,u,d',
            'complaints' => 'r,d',
        ],
        'admin' => [
            'users' => 'r,u',
            'categories' => 'c,r,u,d',
            'delegates'=>'c,r,u,d',
            'stores' => 'c,r,u,d',
            'offers' => 'c,r,u,d',
            'ads' => 'c,r,u,d',
            'complaints' => 'r,d',
        ],
        'support' => [
            'stores' => 'c,r,u',
            'delegates'=>'c,r,u',
            // 'supports' => 'c,r,u,d',
        ],
        'auditor' => [
            // 'reports' => 'c,r,u,d',
        ],
        'delegate' => [],
        'store' => [],
        'client' => [],

    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
