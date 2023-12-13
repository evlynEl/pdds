<?php
// getTopCustomers.php
require_once 'autoload.php';
// Connect to MongoDB (assuming you have already established a MongoDB connection)
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->northwind; // Use "northwind" as the database name

// Aggregation pipeline to get top 5 customers with the most purchases
$pipeline = [
    [
        '$group' => [
            '_id' => '$customerID',
            'totalPurchases' => ['$sum' => '$quantity']
        ]
    ],
    [
        '$sort' => ['totalPurchases' => -1]
    ],
    [
        '$limit' => 5
    ]
];

// Execute the aggregation pipeline
$cursor = $database->fact_orders->aggregate($pipeline);

// Convert the cursor to an array
$aggregationResults = iterator_to_array($cursor);

// Extract customer IDs from the aggregation result
$customerIds = array_column($aggregationResults, '_id');

// Find customers in the customer_lookup collection based on customer IDs
$customersCursor = $database->customer_lookup->find(['customerID' => ['$in' => $customerIds]]);

// Output customer details
$customersArray = [];
foreach ($customersCursor as $customer) {
    $customerId = $customer['customerID'];
    $companyName = $customer['companyName'];
    $contactName = $customer['contactName'];

    // Find the corresponding totalPurchases from the aggregation result based on customerID
    $totalPurchases = 0; // Default value if not found
    foreach ($aggregationResults as $document) {
        if ($document['_id'] == $customerId) {
            $totalPurchases = $document['totalPurchases'];
            break;
        }
    }

    // Store customer details in an array
    $customersArray[] = [
        'customerID' => $customerId,
        'companyName' => $companyName,
        'contactName' => $contactName,
        'totalPurchases' => $totalPurchases,
        // Add more fields as needed
    ];
}
?>
