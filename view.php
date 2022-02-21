<?php
include('config.php');
$table = "open_day_pin_codes";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$query  = "SELECT * FROM {$table} WHERE counter > 0 ORDER BY counter DESC, pin ASC;";
$result = $conn->query($query);

echo "<table>"; // start a table tag in the HTML
echo "<tr><th>PIN</th><th>Count</th></tr>";
while($row = $result->fetch_assoc()){   //Creates a loop to loop through results
echo "<tr><td>" . $row['pin'] . "</td><td>" . $row['counter'] . "</td></tr>";  //$row['index'] the index here is a field name
}

echo "</table>"; //Close the table in HTML

$conn->close();
?>
