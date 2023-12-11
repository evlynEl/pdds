<!DOCTYPE html>
<html>
<body>

<?php
include 'config.php';
$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

$file = fopen('data/customers.csv', 'r');
while (($line = fgetcsv($file)) !== FALSE) {
  $sql = "INSERT INTO `customers` (`customerID`, `companyName`, `contactName`, `contactTitle`, `address`, `city`, `region`, `postalCode`, `country`, `phone`, `fax`) 
      VALUES ('".$line[0]."', '".$line[1]."', '".$line[2]."', '".$line[3]."', '".$line[4]."', '".$line[5]."', '".$line[6]."', '".$line[7]."', '".$line[8]."' , '".$line[9]."' , '".$line[10]."')";
      $query = mysqli_query($conn, $sql);
}
fclose($file);
?>

</body>
</html>