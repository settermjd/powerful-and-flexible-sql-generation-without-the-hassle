<?php

return [
    'sqlite' => new Zend\Db\Adapter\Adapter([
        'driver' => 'Pdo_Sqlite',
        'database' => 'db/database.sqlite'
    ]),
    'mysql' => new Zend\Db\Adapter\Adapter([
        'driver' => 'Pdo_Mysql',
        'database' => 'Chinook',
        'host' => '192.168.33.99',
        'port' => '3306',
        'username' => 'user',
        'password' => 'password',
        'charset' => 'utf8'
    ]),
    'postgresql' => new Zend\Db\Adapter\Adapter([
        'driver' => 'Pdo_Pgsql',
        'database' => 'Chinook',
        'host' => '127.0.0.1',
        'port' => '5432',
        'username' => 'user',
        'password' => 'password',
        'charset' => 'utf8'
    ])
];
