<?php

require_once('vendor/autoload.php');

use Zend\Db\Sql\Sql;

$adapter = require_once('adapter.php');

/** @var \Zend\Db\Adapter\Adapter $adapter ['sqlite'] */
$sql = new Sql($adapter['sqlite']);
$insert = $sql->insert();
$insert->into('Customer')
    ->columns(['FirstName', 'LastName', 'Email', 'Country'])
    ->values([
        'FirstName' => 'Matthew',
        'LastName' => 'Setter',
        'Email' => 'matthew@matthewsetter.com',
        'Country' => 'Australia'
    ]);

$statement = $sql->prepareStatementForSqlObject($insert);

$results = $statement->execute();

echo SqlFormatter::format($statement->getSql());
