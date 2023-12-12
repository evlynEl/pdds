<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <?php
  include 'config.php';
  $conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

  if (isset($_POST["import"])) {
    if (isset($_FILES["csvFile"]) && $_FILES["csvFile"]["error"] == UPLOAD_ERR_OK) {
      $name = $_FILES["csvFile"]["name"];
      $file = fopen($_FILES["csvFile"]["tmp_name"], "r");

      // kalo yg dibuka categories
      if ($_FILES["csvFile"]["name"] == "categories.csv"){
        while (($line = fgetcsv($file)) !== FALSE) {
          if($line[0] != "categoryID"){
            $sql = "INSERT INTO `categories` (`categoryID`, `categoryName`, `description`, `picture`) 
            VALUES ('".$line[0]."', '".$line[1]."', '".$line[2]."', '".$line[3]."')";
            $query = mysqli_query($conn, $sql);
          }
        }
        fclose($file);
      }

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

      // kalo yg dibuka employees
      if ($_FILES["csvFile"]["name"] == "employees.csv"){
        while (($line = fgetcsv($file)) !== FALSE) {
          if($line[0] != "employeeID"){
            $sql = "INSERT INTO `employees` (`employeeID`, `lastName`, `firstName`, `title`, `titleOfCourtesy`, `birthDate`, `hireDate`, `address`, `city`, `region`, `postalCode`, `country`, `homePhone`, `extension`, `photo`, `notes`, `reportsTo`, `photoPath`) 
            VALUES ('".$line[0]."', '".$line[1]."', '".$line[2]."', '".$line[3]."', '".$line[4]."', '".$line[5]."', '".$line[6]."', '".$line[7]."', '".$line[8]."' , '".$line[9]."' , '".$line[10]."', '".$line[11]."' , '".$line[12]."', '".$line[13]."' , '".$line[14]."', '".$line[15]."' , '".$line[16]."', '".$line[17]."' )";
            $query = mysqli_query($conn, $sql);
          }
        }
        fclose($file);
      }

      // kalo yg dibuka employees-territories
      if ($_FILES["csvFile"]["name"] == "employee-territories.csv"){
        while (($line = fgetcsv($file)) !== FALSE) {
          if($line[0] != "employeeID"){
            $sql = "INSERT INTO `employee_territories` (`employeeID`, `territoryID`) 
            VALUES ('".$line[0]."', '".$line[1]."')";
            $query = mysqli_query($conn, $sql);
          }
        }
          fclose($file);
      }

      // kalo yg dibuka order-details
      if ($_FILES["csvFile"]["name"] == "order-details.csv"){
        while (($line = fgetcsv($file)) !== FALSE) {
          if($line[0] != "orderID"){
            $sql = "INSERT INTO `order_details` (`orderID`, `productID`, `unitPrice`, `quantity`, `discount`) 
            VALUES ('".$line[0]."', '".$line[1]."', '".$line[2]."', '".$line[3]."', '".$line[4]."')";
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

      // kalo yg dibuka regions
      if ($_FILES["csvFile"]["name"] == "regions.csv"){
        while (($line = fgetcsv($file)) !== FALSE) {
          if($line[0] != "regionID"){
            $sql = "INSERT INTO `regions` (`regionID`, `regionDescription`) 
            VALUES ('".$line[0]."', '".$line[1]."')";
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

      // kalo yg dibuka territories
      if ($_FILES["csvFile"]["name"] == "territories.csv"){
        while (($line = fgetcsv($file)) !== FALSE) {
          if($line[0] != "territoryID"){
            $sql = "INSERT INTO `territories` (`territoryID`, `territoryDescription`, `regionID`) 
            VALUES ('".$line[0]."', '".$line[1]."', '".$line[2]."')";
            $query = mysqli_query($conn, $sql);
          }
        }
        fclose($file);
      }
    }
  }
  echo "<center><h1>" .$name. " telah berhasil di import!</center></h1>";
  echo "<center><button onclick=window.history.back()>Kembali</button></center>";
  echo "</br>";
  
  $script = __DIR__ . DIRECTORY_SEPARATOR . "cobacoba.py";
  $result = shell_exec("python $script");
  echo "PHP got the result - $result";


  ?>
  
</body>
</html>




