<?php
use OzdemirBurak\JsonCsv\File\Csv;
require 'autoload.php';

if (isset($_POST["import"])) {
    $csv_filename = $_FILES["csvFile"]["name"];
    $csv = new Csv($csv_filename);
    echo 'Loaded CSV file: ' . $csv_filename . '<br>';

    // Convert CSV to JSON then JSON to Array.
    $array = json_decode($csv->convert(), true);

    $mongo_location = 'mongodb://localhost:27017';
    $mongo = new MongoDB\Driver\Manager($mongo_location);
    echo 'Connected to ' . $mongo_location . '<br>';

    $mongo_bulk_write = new MongoDB\Driver\BulkWrite();
    foreach ($array as $doc) {
    // MongoDB ObjectID will be automatically generated.
    $mongo_bulk_write->insert($doc);
    }
    // 'schooldb' is database and 'student' is collection.
    $mongo->executeBulkWrite('Northwind.$csv_filename', $mongo_bulk_write);
    echo 'Populated MongoDB database';
}


?>