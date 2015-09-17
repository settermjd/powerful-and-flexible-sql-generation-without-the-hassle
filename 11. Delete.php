<?php

require_once('vendor/autoload.php');

use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Sql;

$adapter = require_once('adapter.php');

/** @var \Zend\Db\Adapter\Adapter $adapter ['sqlite'] */
$sql = new Sql($adapter['sqlite']);

$wherePredicate = new Predicate();
$wherePredicate->equalTo('Email', 'matthew@maltblue.com')
    ->equalTo('LastName', 'Setter')
    ->isNotNull('FirstName');

$delete = $sql->delete();
$delete->from('Customer')
    ->where($wherePredicate);

$statement = $sql->prepareStatementForSqlObject($delete);

$results = $statement->execute();

echo SqlFormatter::format($statement->getSql());
