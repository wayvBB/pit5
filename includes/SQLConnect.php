<?php

//IF MYSQLI---------------------

// Connection String
//$con = mysqli_connect("localhost", "root", "", "pit5_db"); 
// Host name, Username, Password, Database name

// Test connection to database
/*if (!$con) {
    die('Could not connect: ' . mysql_error()); // If not connected
} else {
    echo "<br><br>Status: Connected to phpmyadmin"; // If connected
}*/

//USING PDO---------------------

$dbname = "pit5_db";
$username = "root";
$password = "";
$host = "localhost"; 

try {
    // Establish the PDO connection using the declared parameters
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "<br><br>Status: Connected to phpmyadmin"; // If connected
} catch (PDOException $e) {
    die('Could not connect: ' . $e->getMessage()); // If connection fails
}


// $db = mysqli_select_db("newbies_db"); // Select a specific database
// if(!$db){
//     die('<br>No Database: ' . mysql_error()); // If not connected
// } else {
//     echo "<br>Connected to Database.";
// }

// $db = mysql_select_db("datashop", $con);
// if(!$db){
//     echo "database does not exist";
// } else {
//     echo "Connected to database";
// }

// $query = mysql_query("Select * from tbl_products") or die(mysql_error());

// while ($row = mysql_fetch_array($query)) {
//     echo $row['PID'];
// }
?>
