<?php

require_once('vendor/autoload.php');

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;
use PluralSight\Course\Entity\Employee;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\ObjectProperty as Hydrator;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Predicate\Expression;

$adapter = require_once('adapter.php');
$queryValues = [
    ':invoiceMin' => 1,
    ':invoiceMax' => 20,
    ':customerCountry' => 'USA'
];

/** @var \Zend\Db\Adapter\Driver\StatementInterface $statement */
/*$statement = $adapter['sqlite']->createStatement(
    //"SELECT FirstName, LastName, Email, Country FROM Customer"
    "SELECT c.FirstName, c.LastName, c.Email, c.Country, i.InvoiceId, i.InvoiceDate, i.Total
    FROM Customer c
    INNER JOIN Invoice i ON (i.CustomerId = c.CustomerId)
    WHERE (i.Total BETWEEN :invoiceMin and :invoiceMax)
    AND c.Country = :customerCountry
    LIMIT 20", $queryValues
);*/

$sqliteFullNameExpression = new Expression(
    'c.FirstName || " " || c.LastName'
);

$whereLastNameExpression = new Expression('lower(LastName) IN (?)', ['stevens','brooks','harris']);

$sql = new Sql($adapter['sqlite']);
/** @var Zend\Db\Sql\Select $select */
$select = $sql->select();
$select->from(['c' => 'Customer'])
    ->columns(['FirstName', 'LastName', 'Customer Full Name' => $sqliteFullNameExpression, 'Email', 'Country'])
    ->join(['i' => 'Invoice'], 'i.CustomerId = c.CustomerId', ['InvoiceId', 'InvoiceDate', 'Total']);

$predicate = new Predicate();
$predicate->between('i.Total', $queryValues[':invoiceMin'], $queryValues[':invoiceMax'])
    ->equalTo('c.Country', $queryValues[':customerCountry']);

$predicate2 = new Predicate();
$predicate2->between('i.Total', $queryValues[':invoiceMin'], $queryValues[':invoiceMax'])
    ->equalTo('c.Country', 'Chile');

$select->where($predicate);

$select2 = $sql->select();
$select2 = $select2->from(['c' => 'Customer'])
    ->columns(['FirstName', 'LastName', 'Customer Full Name' => $sqliteFullNameExpression, 'Email', 'Country'])
    ->join(['i' => 'Invoice'], 'i.CustomerId = c.CustomerId', ['InvoiceId', 'InvoiceDate', 'Total']);
$select2->where($predicate2);

$select->limit(20)
    ->order(["Total DESC", "LastName ASC"]);

$select2->combine($select);

$statement = $sql->prepareStatementForSqlObject($select2);

echo SqlFormatter::format($statement->getSql()); exit;


/** @var \Zend\Db\Adapter\Driver\Pdo\Result $results */
$results = $statement->execute();

if ($results->count()) {
    foreach ($results as $result) {
        $headers = array_keys($result);
        $outputData[] = $result;
    }
}

if ($outputData) {
    $table = new Table(new ConsoleOutput());
    $table->setHeaders([
        $headers
    ]);
    $table->setRows($outputData);
    $table->render();
}


echo SqlFormatter::format($statement->getSql());