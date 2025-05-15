<?php
require_once 'config.php';

return
    [
        'paths' => [
            'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
            'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
        ],
        'environments' => [
            'default_migration_table' => 'phinxlog',
            'default_environment' => ENV,
            'production' => [
                'adapter' => 'mysql',
                'host' => DB_SERVER,
                'name' => DB_NAME,
                'user' => DB_USER,
                'pass' => DB_PASSWORD,
                'port' => '3306',
                'charset' => 'utf8',
            ],
            'development' => [
                'adapter' => 'mysql',
                'host' => DB_SERVER,
                'name' => DB_NAME,
                'user' => DB_USER,
                'pass' => DB_PASSWORD,
                'port' => '3306',
                'charset' => 'utf8',
            ],
            'testing' => [
                'adapter' => 'mysql',
                'host' => DB_SERVER,
                'name' => DB_SERVER,
                'user' => DB_NAME,
                'pass' => DB_PASSWORD,
                'port' => '3306',
                'charset' => 'utf8',
            ]
        ],
        'version_order' => 'creation'
    ];
