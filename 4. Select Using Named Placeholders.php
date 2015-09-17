<?php

require_once('vendor/autoload.php');
require_once('output-results.php');

$adapter = require_once('adapter.php');
$queryValues = [
    ':invoiceMin' => 1,
    ':invoiceMax' => 20,
    ':countryOne' => 'USA',
    ':countryTwo' => 'Germany'
];

/** @var \Zend\Db\Adapter\Driver\StatementInterface $statement */
$statement = $adapter['sqlite']->createStatement(
    "SELECT c.FirstName, c.LastName, c.Email, c.Country,
        i.InvoiceId, i.InvoiceDate, i.Total
    FROM Customer c
    INNER JOIN Invoice I ON (i.CustomerId = c.CustomerId)
    WHERE (i.Total BETWEEN :invoiceMin AND :invoiceMax)
    AND (c.Country = :countryOne OR c.Country = :countryTwo)
    ORDER BY i.Total DESC
    LIMIT 1, 30",
    $queryValues
);

/** @var \Zend\Db\Adapter\Driver\Pdo\Result $results */
$results = $statement->execute();

renderResults($results, $statement);
