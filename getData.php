<?php
// getData.php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'autoload.php';
// Assuming you have already established a MongoDB connection

$databaseName = "northwind";
$factOrdersCollection = "fact_orders";
$employeeLookupCollection = "employee_lookup";

// Connection to MongoDB
$mongo = new MongoDB\Driver\Manager("mongodb://localhost:27017");

// Aggregation pipeline for fact_orders
$pipeline = [
    [
        '$project' => [
            'employeeID' => 1,
            'sales' => [
                '$multiply' => [
                    '$unitPrice',
                    '$quantity',
                    ['$subtract' => [1, '$discount']]
                ]
            ]
        ]
    ],
    [
        '$group' => [
            '_id' => '$employeeID',
            'totalSales' => ['$sum' => '$sales']
        ]
    ],
    [
        '$sort' => ['totalSales' => -1]
    ],
    [
        '$limit' => 5
    ]
];

// Execute the aggregation on fact_orders
$cursor = $mongo->executeCommand($databaseName, new MongoDB\Driver\Command([
    'aggregate' => $factOrdersCollection,
    'pipeline' => $pipeline,
    'cursor' => new stdClass,
]));

// Fetch all results from the cursor and store it in an array
$aggregationResults = $cursor->toArray();
// Extract employee IDs from the result
$employeeIds = [];
foreach ($aggregationResults as $result) {
    $employeeIds[] = $result->_id;
}

// Query employee_lookup for documents with matching employee IDs
$filter = ['employeeID' => ['$in' => $employeeIds]];
$query = new MongoDB\Driver\Query($filter);
$employeeCursor = $mongo->executeQuery("$databaseName.$employeeLookupCollection", $query);

// Display results for employees
$resultArray = [];
foreach ($employeeCursor as $employee) {
    // Find the corresponding totalSales from the pipeline result based on employeeID
    $totalSales = 0; // Default value if not found
    foreach ($aggregationResults as $result) {
        if ($result->_id == $employee->employeeID) {
            $totalSales = $result->totalSales;
            break;
        }
    }

    $resultArray[] = [
        'employeeID' => $employee->employeeID,
        'lastName' => $employee->lastName,
        'totalSales' => $totalSales,
    ];
}
// Sort the resultArray by totalSales in descending order
usort($resultArray, function ($a, $b) {
    return $b['totalSales'] - $a['totalSales'];
});

// Fetch data for top customers using the second PHP code
include 'getTopCustomers.php'; // Include the second PHP code

// Include association rule mining code
include 'associationRuleMining.php';


echo json_encode([
    'employees' => $resultArray,
    'customers' => $customersArray, // Pass the customers data
    'associationRule' => $associationRuleResults, // Pass the association rule mining result
]);
?>
