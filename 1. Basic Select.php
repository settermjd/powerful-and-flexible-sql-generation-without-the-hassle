<?php

require_once('vendor/autoload.php');
require_once('output-results.php');

$adapter = require_once('adapter.php');

/** @var \Zend\Db\Adapter\Driver\StatementInterface $statement */
$statement = $adapter['sqlite']->createStatement(
    "SELECT FirstName, LastName, Email, Country FROM Customer"
);

/** @var \Zend\Db\Adapter\Driver\Pdo\Result $results */
$results = $statement->execute();

renderResults($results, $statement);
