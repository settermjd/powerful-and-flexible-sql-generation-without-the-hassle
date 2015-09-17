<?php

require_once('vendor/autoload.php');

use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Sql;

$adapter = require_once('adapter.php');

/** @var \Zend\Db\Adapter\Adapter $adapter ['sqlite'] */
$sql = new Sql($adapter['sqlite']);

$wherePredicate = new Predicate();
$wherePredicate->equalTo('Email', 'matthew@matthewsetter.com')
    ->equalTo('LastName', 'Setter')
    ->isNotNull('FirstName');

$update = $sql->update();
$update->table('Customer')
    ->set([
        'FirstName' => 'Matthew',
        'LastName' => 'Setter',
        'Email' => 'matthew@maltblue.com',
        'Country' => 'Australia'
    ])
    ->where($wherePredicate);

$statement = $sql->prepareStatementForSqlObject($update);

$results = $statement->execute();

echo SqlFormatter::format($statement->getSql());
