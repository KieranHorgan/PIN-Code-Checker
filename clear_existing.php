<?php
include('config.php');
$table = "existing_pin_codes";
$file = "existing_data/sql.txt";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$query  = "";
$query .= "DROP TABLE {$table};";
$query .= "CREATE TABLE {$table} ( pin CHAR(4) PRIMARY KEY, counter INTEGER );";

$myfile = fopen($file, "r");
$query .= fread($myfile,filesize($file));

if ($conn->multi_query($query) === TRUE) {
    echo "Table cleared successfully";
} else {
    echo "Error creating table: " . $conn->error;
}


$conn->close();
?>
