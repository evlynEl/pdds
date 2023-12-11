<?php

$dbHost     = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName     = "pdds";

$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

// $cat = 'SELECT * FROM categories';
// $stmt = mysqli_prepare($conn, $cat);
// mysqli_stmt_execute($stmt);
// $result = mysqli_stmt_get_result($stmt);

// $cust = 'SELECT * FROM customers';
// $stmt = mysqli_prepare($conn, $cust );
// mysqli_stmt_execute($stmt);
// $result_cust = mysqli_stmt_get_result($stmt);

// $emp = 'SELECT * FROM employees';
// $stmt = mysqli_prepare($conn, $emp );
// mysqli_stmt_execute($stmt);
// $result_emp = mysqli_stmt_get_result($stmt);

// $emp_ter = 'SELECT * FROM employee_territorries';
// $stmt = mysqli_prepare($conn, $emp_ter );
// mysqli_stmt_execute($stmt);
// $result_emp_ter = mysqli_stmt_get_result($stmt);

// $ord_detail = 'SELECT * FROM order_details';
// $stmt = mysqli_prepare($conn, $ord_detail );
// mysqli_stmt_execute($stmt);
// $result_ord_detail = mysqli_stmt_get_result($stmt);

// $ord = 'SELECT * FROM orders';
// $stmt = mysqli_prepare($conn, $ord );
// mysqli_stmt_execute($stmt);
// $result_ord = mysqli_stmt_get_result($stmt);

// $products = 'SELECT * FROM products';
// $stmt = mysqli_prepare($conn, $product );
// mysqli_stmt_execute($stmt);
// $result_products = mysqli_stmt_get_result($stmt);

// $regions = 'SELECT * FROM regions';
// $stmt = mysqli_prepare($conn, $regions );
// mysqli_stmt_execute($stmt);
// $result_regions = mysqli_stmt_get_result($stmt);

// $shippers = 'SELECT * FROM shippers';
// $stmt = mysqli_prepare($conn, $shippers );
// mysqli_stmt_execute($stmt);
// $result_shippers = mysqli_stmt_get_result($stmt);

// $suppliers = 'SELECT * FROM suppliers';
// $stmt = mysqli_prepare($conn, $suppliers );
// mysqli_stmt_execute($stmt);
// $result_suppliers = mysqli_stmt_get_result($stmt);

// $territories = 'SELECT * FROM territories';
// $stmt = mysqli_prepare($conn, $territories );
// mysqli_stmt_execute($stmt);
// $result_territories = mysqli_stmt_get_result($stmt);

// Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }