<?php

require_once('vendor/autoload.php');

use Zend\Db\Adapter\Driver\Pdo\Result;
use Zend\Db\Adapter\Driver\StatementInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\StreamOutput;

/**
 * @var \Zend\Db\Adapter\Driver\Pdo\Result $results
 * @var \Zend\Db\Adapter\Driver\StatementInterface $statement
 */
function renderResults(Result $results, StatementInterface $statement = null)
{
    $headers = [];
    $queryInformation = null;
    $outputData = null;

    $resultContents = null;
    if ($statement) {
        $queryInformation = SqlFormatter::format($statement->getSql());
        if ($statement->getParameterContainer()->count()) {

            $queryInformation .= createTable(
                array_keys($statement->getParameterContainer()->getNamedArray()),
                [array_values($statement->getParameterContainer()->getNamedArray())]
            );
        }
    }

    if ($results->count()) {
        foreach ($results as $result) {
            $headers = array_keys($result);
            $outputData[] = $result;
        }
    }

    // Results
    if ($outputData) {
        $resultContents = createTable([$headers], $outputData);
    }

    // Wrapper Table
    $table = new Table(new ConsoleOutput());
    $table->setHeaders([
        ['Query Results','Generated SQL']
    ])->setRows([
        [$resultContents, $queryInformation]
    ])->render();
}

function createTable($headers, $rowData)
{
    $handle = fopen('php://memory', 'w+');
    $table = new Table(new StreamOutput($handle));
    $table->setHeaders([$headers]);
    $table->setRows($rowData);
    $table->setStyle('borderless');
    $table->render();
    rewind($handle);
    $output = stream_get_contents($handle);
    fclose($handle);

    return $output;
}
