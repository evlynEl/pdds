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
            $columns = ['categoryID', 'categoryName', 'description', 'picture'];
            break;
        case 'customers':
            $columns = ['customerID', 'companyName', 'contactName', 'contactTitle', 'address', 'city', 'region', 'postalCode', 'country', 'phone', 'fax'];
            break;
        case 'employees':
            $columns = ['employeeID', 'lastName', 'firstName', 'title', 'titleOfCourtesy', 'birthDate', 'address', 'city', 'region', 'postalCode', 'country', 'homePhone', 'extension', 'photo', 'notes', 'reportsTo', 'photoPath'];
            break;
        case 'employee_territories':
            $columns = ['employeeID', 'territoryID'];
            break;
        case 'order_details':
            $columns = ['orderID', 'productID', 'unitPrice', 'quantity', 'discount'];
            break;
        case 'orders':
            $columns = ['orderID', 'customerID', 'employeeID', 'orderDate', 'requiredDate', 'shippedDate', 'shipVia', 'freight', 'shipName', 'shipAddress', 'shipCity', 'shipRegion', 'shipPostalCode', 'shipCountry'];
            break;
        case 'products':
            $columns = ['productID', 'productName', 'supplierID', 'categoryID', 'quantityPerUnit', 'unitPrice', 'unitsInStock', 'unitsOnOrder', 'reorderLevel', 'discontinued'];
            break;
        case 'regions':
            $columns = ['regionID', 'regionDescription'];
            break;
        case 'shippers':
            $columns = ['shipperID', 'companyName', 'phone'];
            break;
        case 'suppliers':
            $columns = ['supplierID', 'companyName', 'contactName', 'contactTitle', 'address', 'city', 'region', 'postalCode', 'country', 'phone', 'fax'];
            break;
        case 'territories':
            $columns = ['territoryID', 'territoryDescription', 'regionID'];
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
        $headers = fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
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
