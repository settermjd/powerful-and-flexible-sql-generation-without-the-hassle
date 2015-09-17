<?php

require_once('vendor/autoload.php');
require_once('output-results.php');

use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Sql;

$adapter = require_once('adapter.php');
$queryValues = [
    ':invoiceMin' => 1,
    ':invoiceMax' => 20,
    ':countryOne' => 'USA',
    ':countryTwo' => 'Germany'
];

/** @var \Zend\Db\Adapter\Driver\StatementInterface $statement */
$sql = new Sql($adapter['sqlite']);

$countryPredicate = new Predicate();
$countryPredicate->equalTo('c.Country', 'USA')->or->equalTo('c.Country', 'Germany');

$invoicePredicate = new Predicate();
$invoicePredicate->between('i.Total', $queryValues[':invoiceMin'], $queryValues[':invoiceMax']);

$predicate = new Predicate();
//$predicate->addPredicate($invoicePredicate)->addPredicate($countryPredicate);
$predicate->addPredicates([
    $invoicePredicate
]);
$predicate->andPredicate($countryPredicate);

/** @var Zend\Db\Sql\Select $select */
$select = $sql->select();
$select->from(['c' => 'Customer'])
    ->columns(['FirstName', 'LastName', 'Email', 'Country'])
    ->join(['i' => 'Invoice'], 'i.CustomerId = c.CustomerId', ['InvoiceId', 'InvoiceDate', 'Total'])
    ->where($predicate)
    ->order('c.Country DESC, i.Total DESC, c.LastName')
    ->limit(30)
    ->offset(1);

/** @var \Zend\Db\Adapter\Driver\Pdo\Result $results */
$statement = $sql->prepareStatementForSqlObject($select);
$results = $statement->execute();
print "results: " . $results->count();

renderResults($results, $statement);
