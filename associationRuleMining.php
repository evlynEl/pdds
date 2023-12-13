<?php
// associationRuleMining.php
require_once 'autoload.php';
use MongoDB\Client;

// MongoDB connection
$mongoClient = new Client("mongodb://localhost:27017");
$collection = $mongoClient->northwind->fact_orders;

// Transactions array
$transactions = [];

// Find all orders
$cursor = $collection->find();

// Process orders and build transactions array
foreach ($cursor as $document) {
    $orderID = $document['orderID'];
    $productID = $document['productID'];

    // Add the product to the transaction array
    $transactions[$orderID][] = $productID;
}

// Output arrays of transactions containing products
// echo "Arrays of Transactions:\n";
// foreach ($transactions as $transactionID => $products) {
//     echo "[ " . implode(', ', $products) . " ], \n";
// }
// Find product pairs and count occurrences
$productPairsCount = [];

foreach ($transactions as $products) {
    $numProducts = count($products);

    // Generate pairs of products
    for ($i = 0; $i < $numProducts - 1; $i++) {
        for ($j = $i + 1; $j < $numProducts; $j++) {
            $productPair = [$products[$i], $products[$j]];
            sort($productPair); // Sort the pair to handle unordered products as the same pair

            // Count occurrences of each product pair
            $productPairsCount[implode(',', $productPair)] = isset($productPairsCount[implode(',', $productPair)]) ? $productPairsCount[implode(',', $productPair)] + 1 : 1;
        }
    }
}

// Get the top N most frequently bought together product pairs
$topCount = 5; // Adjust this value based on your requirement
arsort($productPairsCount);
$topProductPairs = array_slice($productPairsCount, 0, $topCount, true);

// echo "Top $topCount Most Frequently Bought Together Product Pairs:\n";
// foreach ($topProductPairs as $productPair => $count) {
//     echo "$productPair: $count times\n";
// }
// Fetch product names from the 'product_lookup' collection
$productLookupCollection = $mongoClient->northwind->product_lookup;
// Initialize an array to store the results
$associationRuleResults = [];

// Extract product IDs from the top product pairs and store results
foreach ($topProductPairs as $productPair => $count) {
    list($productID1, $productID2) = explode(',', $productPair);

    // Convert product IDs to integers
    $productID1 = (int) $productID1;
    $productID2 = (int) $productID2;

    // Query the product_lookup collection
    $product1 = $productLookupCollection->findOne(['productID' => $productID1]);
    $product2 = $productLookupCollection->findOne(['productID' => $productID2]);

    // Fetch product names
    $productName1 = $product1 ? $product1['productName'] : 'Unknown';
    $productName2 = $product2 ? $product2['productName'] : 'Unknown';
    //echo "($productName1, $productName2): $count times\n";
    // Store the result in the array
    $associationRuleResults[] = [
        'product1' => $productName1,
        'product2' => $productName2,
        'count' => $count,
    ];
}


?>