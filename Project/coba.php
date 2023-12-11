<!DOCTYPE html>
<html>

<body>

    <?php
include 'config.php';
$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

if (isset($_POST["import"])) {
  if (isset($_FILES["csvFile"]) && $_FILES["csvFile"]["error"] == UPLOAD_ERR_OK) {
      // echo $_FILES["csvFile"]["name"];
      $file = fopen($_FILES["csvFile"]["tmp_name"], "r");

      // kalo yg dibuka customers
      if ($_FILES["csvFile"]["name"] == "customers.csv"){
        while (($line = fgetcsv($file)) !== FALSE) {
          if($line[0] != "customerID"){
            $sql = "INSERT INTO `customers` (`customerID`, `companyName`, `contactName`, `contactTitle`, `address`, `city`, `region`, `postalCode`, `country`, `phone`, `fax`) 
            VALUES ('".$line[0]."', '".$line[1]."', '".$line[2]."', '".$line[3]."', '".$line[4]."', '".$line[5]."', '".$line[6]."', '".$line[7]."', '".$line[8]."' , '".$line[9]."' , '".$line[10]."')";
            $query = mysqli_query($conn, $sql);
          }
        }
        fclose($file);
      }

      // kalo yg dibuka suppliers
      if ($_FILES["csvFile"]["name"] == "suppliers.csv"){
        while (($line = fgetcsv($file)) !== FALSE) {
          if($line[0] != "supplierID"){
            $sql = "INSERT INTO `suppliers` (`supplierID`, `companyName`, `contactName`, `contactTitle`, `address`, `city`, `region`, `postalCode`, `country`, `phone`, `fax`) 
            VALUES ('".$line[0]."', '".$line[1]."', '".$line[2]."', '".$line[3]."', '".$line[4]."', '".$line[5]."', '".$line[6]."', '".$line[7]."', '".$line[8]."' , '".$line[9]."' , '".$line[10]."')";
            $query = mysqli_query($conn, $sql);
          }
        }
        fclose($file);
      }
      
      // kalo yg dibuka shippers
      if ($_FILES["csvFile"]["name"] == "shippers.csv"){
        while (($line = fgetcsv($file)) !== FALSE) {
          if($line[0] != "shipperID"){
            $sql = "INSERT INTO `shippers` (`shipperID`, `companyName`, `phone`) 
            VALUES ('".$line[0]."', '".$line[1]."', '".$line[2]."')";
            $query = mysqli_query($conn, $sql);
          }
        }
        fclose($file);
      }
      
      // kalo yg dibuka products
      if ($_FILES["csvFile"]["name"] == "products.csv"){
        while (($line = fgetcsv($file)) !== FALSE) {
          if($line[0] != "productID"){
            $sql = "INSERT INTO `products` (`productID`, `productName`, `supplierID`, `categoryID`, `quantityPerUnit`, `unitPrice`, `unitsInStock`, `unitsOnOrder`, `reorderLevel`, `discontinued`) 
            VALUES ('".$line[0]."', '".$line[1]."', '".$line[2]."', '".$line[3]."', '".$line[4]."', '".$line[5]."', '".$line[6]."', '".$line[7]."', '".$line[8]."' , '".$line[9]."')";
            $query = mysqli_query($conn, $sql);
          }
        }
        fclose($file);
      }
      
      // kalo yg dibuka orders
      if ($_FILES["csvFile"]["name"] == "orders.csv"){
        while (($line = fgetcsv($file)) !== FALSE) {
          if($line[0] != "orderID"){
            $sql = "INSERT INTO `orders` (`orderID`, `customerID`, `employeeID`, `orderDate`, `requiredDate`, `shippedDate`, `shipVia`, `freight`, `shipName`, `shipAddress`, `shipCity`, `shipRegion`, `shipPostalCode`, `shipCountry`) 
            VALUES ('".$line[0]."', '".$line[1]."', '".$line[2]."', '".$line[3]."', '".$line[4]."', '".$line[5]."', '".$line[6]."', '".$line[7]."', '".$line[8]."' , '".$line[9]."', '".$line[10]."', '".$line[11]."', '".$line[12]."', '".$line[13]."')";
            $query = mysqli_query($conn, $sql);
          }
        }
        fclose($file);
      }

  }
}

?>

</body>

</html>