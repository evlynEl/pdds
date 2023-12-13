<?php
include 'config.php';

require 'autoload.php';

$client = new MongoDB\Client();
$mongo = $client->Eve->northwind;

function insertToMySQL($data, $table)
{
    global $mysqli;

    switch ($table) {
        case 'categories':
            $columns = ['`categoryID` int(1) DEFAULT NULL', '`categoryName` varchar(14) DEFAULT NULL', '`description` varchar(58) DEFAULT NULL', '`picture` varchar(256) DEFAULT NULL'];
            break;
        case 'customers':
            $columns = ['`customerID` varchar(5) DEFAULT NULL', '`companyName` varchar(36) DEFAULT NULL', '`contactName` varchar(23) DEFAULT NULL', '`contactTitle` varchar(30) DEFAULT NULL', '`address` varchar(46) DEFAULT NULL', '`city` varchar(25) DEFAULT NULL', '`region` varchar(14) DEFAULT NULL', '`postalCode` varchar(8) DEFAULT NULL', '`country` varchar(11) DEFAULT NULL', '`phone` varchar(14) DEFAULT NULL', '`fax` varchar(17) DEFAULT NULL'];
            break;
        case 'employees':
            $columns = ['`employeeID` int(1) DEFAULT NULL', '`lastName` varchar(9) DEFAULT NULL', '`firstName` varchar(8) DEFAULT NULL', '`title` varchar(24) DEFAULT NULL', '`titleOfCourtesy` varchar(4) DEFAULT NULL', '`birthDate` varchar(23) DEFAULT NULL', '`hireDate` varchar(23) DEFAULT NULL', '`address` varchar(29) DEFAULT NULL', '`city` varchar(8) DEFAULT NULL', '`region` varchar(2) DEFAULT NULL', '`postalCode` varchar(7) DEFAULT NULL', '`country` varchar(3) DEFAULT NULL', '`homePhone` varchar(14) DEFAULT NULL', '`extension` int(4) DEFAULT NULL', '`photo` varchar(256) DEFAULT NULL', '`notes` varchar(256) DEFAULT NULL', '`reportsTo` varchar(1) DEFAULT NULL', '`photoPath` varchar(38) DEFAULT NULL'];
            break;
        case 'employee_territories':
            $columns = ['`employeeID` int(1) DEFAULT NULL', '`territoryID` varchar(5) DEFAULT NULL'];
            break;
        case 'order_details':
            $columns = ['`orderID` int(5) DEFAULT NULL', '`productID` int(2) DEFAULT NULL', '`unitPrice` decimal(5,2) DEFAULT NULL', '`quantity` int(3) DEFAULT NULL', '`discount` decimal(3,2) DEFAULT NULL'];
            break;
        case 'orders':
            $columns = ['`orderID` int(5) DEFAULT NULL', '`customerID` varchar(5) DEFAULT NULL', '`employeeID` int(1) DEFAULT NULL', '`orderDate` varchar(23) DEFAULT NULL', '`requiredDate` varchar(23) DEFAULT NULL', '`shippedDate` varchar(23) DEFAULT NULL', '`shipVia` int(1) DEFAULT NULL', '`freight` decimal(6,2) DEFAULT NULL', '`shipName` varchar(34) DEFAULT NULL', '`shipAddress` varchar(46) DEFAULT NULL', '`shipCity` varchar(25) DEFAULT NULL', '`shipRegion` varchar(14) DEFAULT NULL', '`shipPostalCode` varchar(8) DEFAULT NULL', '`shipCountry` varchar(11) DEFAULT NULL'];
            break;
        case 'products':
            $columns = ['`productID` int(2) DEFAULT NULL', '`productName` varchar(32) DEFAULT NULL', '`supplierID` int(2) DEFAULT NULL', '`categoryID` int(1) DEFAULT NULL', '`quantityPerUnit` varchar(20) DEFAULT NULL', '`unitPrice` decimal(5,2) DEFAULT NULL', '`unitsInStock` int(3) DEFAULT NULL', '`unitsOnOrder` int(3) DEFAULT NULL', '`reorderLevel` int(2) DEFAULT NULL', '`discontinued` int(1) DEFAULT NULL'];
            break;
        case 'regions':
            $columns = ['`regionID` int(1) DEFAULT NULL', '`regionDescription` varchar(8) DEFAULT NULL'];
            break;
        case 'shippers':
            $columns = ['`shipperID` int(1) DEFAULT NULL', '`companyName` varchar(16) DEFAULT NULL', '`phone` varchar(14) DEFAULT NULL'];
            break;
        case 'suppliers':
            $columns = ['`supplierID` int(2) DEFAULT NULL', '`companyName` varchar(38) DEFAULT NULL', '`contactName` varchar(26) DEFAULT NULL', '`contactTitle` varchar(28) DEFAULT NULL', '`address` varchar(45) DEFAULT NULL', '`city` varchar(38) DEFAULT NULL', '`region` varchar(10) DEFAULT NULL', '`postalCode` varchar(8) DEFAULT NULL', '`country` varchar(11) DEFAULT NULL', '`phone` varchar(14) DEFAULT NULL', '`fax` varchar(15) DEFAULT NULL', '`homePage` varchar(90) DEFAULT NULL'];
            break;
        case 'territories':
            $columns = ['`territoryID` varchar(5) DEFAULT NULL', '`territoryDescription` varchar(15) DEFAULT NULL', '`regionID` int(1) DEFAULT NULL'];
            break;
        default:
            return;
    }

    // Preparing the statement
    $sql_insert = "INSERT INTO $table (" . implode(', ', $columns) . ") VALUES (" . rtrim(str_repeat('?, ', count($columns)), ', ') . ")";
    $stmt = $mysqli->prepare($sql_insert);

    // Binding parameters
    $params = array_values($data);
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);

    // Debugging: Echo the SQL query
    echo "Debug SQL Query: $sql_insert<br>";

    // Executing the statement
    $stmt->execute();

    // Closing the statement
    $stmt->close();
    echo "Data berhasil diinsert ke tabel $table.<br>";
}

function insertToMongoDB($data, $collection)
{
    global $mongo;

    $bulk = new MongoDB\Driver\BulkWrite;

    switch ($collection) {
        case 'product_lookup':
            $productLookupData = [
                "products" => [
                    "productID" => $data["productID"],
                    "productName" => $data["productName"]
                ],
                "suppliers" => [
                    "supplierID" => $data["supplierID"],
                    "companyName" => $data["companyName"],
                    "contactName" => $data["contactName"],
                    "contactTitle" => $data["contactTitle"],
                    "address" => $data["address"],
                    "city" => $data["city"],
                    "region" => $data["region"],
                    "postalCode" => $data["postalCode"],
                    "country" => $data["country"],
                    "phone" => $data["phone"],
                    "fax" => $data["fax"],
                    "homePage" => $data["homePage"]
                ],
                "categories" => [
                    "categoryID" => $data["categoryID"],
                    "categoryName" => $data["categoryName"],
                    "description" => $data["description"],
                    "picture" => $data["picture"]
                ],
                "products" => [
                    "quantityPerUnit" => $data["quantityPerUnit"],
                    "unitPrice" => $data["unitPrice"],
                    "unitsInStock" => $data["unitsInStock"],
                    "unitsOnOrder" => $data["unitsOnOrder"],
                    "reorderLevel" => $data["reorderLevel"],
                    "discontinued" => $data["discontinued"]
                ]
            ];
            $bulk->insert($productLookupData);
            break;

        case 'employee_lookup':
            $employeeLookupData = [
                "employee_territories" => [
                    "employeeID" => $data["employeeID"],
                    "territoryID" => $data["territoryID"]
                ],
                "territories" => [
                    "territoryDescription" => $data["territoryDescription"]
                ],
                "regions" =>[
                    "regionID" => $data["regionID"],
                    "regionDescription" => $data["regionDescription"]
                ],
                "employees" => [
                    "lastName" => $data["lastName"],
                    "firstName" => $data["firstName"],
                    "title" => $data["title"],
                    "titleOfCourtesy" => $data["titleOfCourtesy"],
                    "birthDate" => $data["birthDate"],
                    "hireDate" => $data["hireDate"],
                    "address" => $data["address"],
                    "city" => $data["city"],
                    "region" => $data["region"],
                    "postalCode" => $data["postalCode"],
                    "country" => $data["country"],
                    "homePhone" => $data["homePhone"],
                    "extension" => $data["extension"],
                    "photo" => $data["photo"],
                    "notes" => $data["notes"],
                    "reportsTo" => $data["reportsTo"],
                    "photoPath" => $data["photoPath"]
                ],
            ];
            $bulk->insert($employeeLookupData);
            break;

        case 'customer_lookup':
            $customerLookupData = [
                "customers" => [
                    "customerID" => $data["customerID"],
                    "companyName" => $data["companyName"],
                    "contactName" => $data["contactName"],
                    "contactTitle" => $data["contactTitle"],
                    "address" => $data["address"],
                    "city" => $data["city"],
                    "region" => $data["region"],
                    "postalCode" => $data["postalCode"],
                    "country" => $data["country"],
                    "phone" => $data["phone"],
                    "fax" => $data["fax"]
                ],
            ];
            $bulk->insert($customerLookupData);
            break;

        case 'fact_orders':
            $factOrdersData = [
                "order_details" => [
                    "orderID" => $data["orderID"],
                    "productID" => $data["productID"],
                    "unitPrice" => $data["unitPrice"],
                    "quantity" => $data["quantity"],
                    "discount" => $data["discount"]
                ],
                "orders" => [
                    "customerID" => $data["customerID"],
                    "employeeID" => $data["employeeID"],
                    "orderDate" => $data["orderDate"],
                    "requiredDate" => $data["requiredDate"],
                    "shippedDate" => $data["shippedDate"]
                ],
                "shippers" => [
                    "shipperID" => $data["shipperID"],
                    "companyName" => $data["companyName"],
                    "phone" => $data["phone"]
                ],
                "ship_info" => [
                    "freight" => $data["freight"],
                    "shipName" => $data["shipName"],
                    "shipAddress" => $data["shipAddress"],
                    "shipCity" => $data["shipCity"],
                    "shipRegion" => $data["shipRegion"],
                    "shipPostalCode" => $data["shipPostalCode"],
                    "shipCountry" => $data["shipCountry"]
                ]
            ];
            $bulk->insert($factOrdersData);
            break;

        default:
            return;
    }

    $mongo->executeBulkWrite("Eve.northwind.$collection", $bulk);

    echo "Data berhasil diinsert ke koleksi $collection (MongoDB).<br>";
}

if (isset($_POST["import"])) {
    if (isset($_FILES["csvFile"]) && $_FILES["csvFile"]["error"] == UPLOAD_ERR_OK) {
        $file = fopen($_FILES["csvFile"]["tmp_name"], "r");
        $headers = fgetcsv($file, 10000, ",");

        while (($row = fgetcsv($file, 10000, ",")) !== false) {
            $data = array_combine($headers, $row);

            insertToMySQL($data, 'categories');
            insertToMySQL($data, 'customers');
            insertToMySQL($data, 'employees');
            insertToMySQL($data, 'employee_territories');
            insertToMySQL($data, 'order_details');
            insertToMySQL($data, 'orders');
            insertToMySQL($data, 'products');
            insertToMySQL($data, 'regions');
            insertToMySQL($data, 'shippers');
            insertToMySQL($data, 'suppliers');
            insertToMySQL($data, 'territories');

            insertToMongoDB($data, 'product_lookup');
            insertToMongoDB($data, 'employee_lookup');
            insertToMongoDB($data, 'customer_lookup');
            insertToMongoDB($data, 'fact_orders');
        }

        fclose($file);
        echo "Import data berhasil!";
    } else {
        echo "Upload file CSV gagal.";
    }
}
?>
