<?php
$servername = "mysql.netsoc.co";
$username = "kieran";
$password = "wFyzRAAAWI0";
$dbname = "kieran_pin_codes";
$table = "open_day_pin_codes";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$query  = "";
// $query .= "DROP TABLE {$table};";
$query .= "CREATE TABLE {$table} ( pin CHAR(4) PRIMARY KEY, counter INTEGER );";
$query .= "INSERT INTO {$table} VALUES ";

for($a = "0"; $a <= "9"; $a++)
    for($b = "0"; $b <= "9"; $b++)
        for($c = "0"; $c <= "9"; $c++)
            for($d = "0"; $d <= "9"; $d++) {
                $query .= "(\"{$a}{$b}{$c}{$d}\", 0)";
				if($a != "9" ||
				   $b != "9" ||
				   $c != "9" ||
				   $d != "9") {
					$query .= ", ";
			    }
			}
$query .= ";";

if ($conn->multi_query($query) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}


$conn->close();
?>
