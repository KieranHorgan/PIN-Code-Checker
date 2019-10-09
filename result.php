<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->

  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css?v=6">

  <meta name="theme-color" content="#fafafa">
</head>

<body>
  <!-- Add your site or application content here -->

  <button><a href="./">Go back</a></button>

  <pre>
<?php
$servername = "localhost";
$username = "";
$password = "";
$dbname = "test";
$existing_table = "existing_pin_codes";
$open_day_table = "open_day_pin_codes";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_pin = $_POST['pin_code'];
if (strlen($user_pin) != 4)
    throw new Exception("Pin code must be exactly 4 digits long");

for ($i = 0; $i < 4; $i++)
    if ($user_pin[$i] < '0' || $user_pin[$i] > '9')
        throw new Exception("Pin code must contain only digits 0-9");

$query = "UPDATE {$open_day_table} SET counter = counter+1 WHERE pin = {$user_pin};";
$conn->query($query);

echo "You entered ";
echo $user_pin;
echo "\n\n";

$existing_total = $conn->query("SELECT SUM(counter) AS total FROM {$existing_table};")->fetch_assoc()["total"];
$existing_current = $conn->query("SELECT counter FROM {$existing_table} WHERE pin = {$user_pin};")->fetch_assoc()["counter"];
$open_day_total = $conn->query("SELECT SUM(counter) AS total FROM {$open_day_table};")->fetch_assoc()["total"];
$open_day_current = $conn->query("SELECT counter FROM {$open_day_table} WHERE pin = {$user_pin};")->fetch_assoc()["counter"];

echo $existing_current;
echo " out of ";
echo $existing_total;
echo ".\nThat's ";
echo round($existing_current / $existing_total * 100000) / 1000;
echo "%";
echo ".\nThat's also about 1 in ";
$one_in = round($existing_total / $existing_current);
if ($one_in >= 1000) {
    $one_in = round($existing_total / $existing_current / 100) * 100;
}
if ($one_in >= 10000) {
    $one_in = round($existing_total / $existing_current / 1000) * 1000;
}
echo $one_in;
echo " pin codes.\n\n";

echo $open_day_current;
echo " out of ";
echo $open_day_total;
echo ".\nThat's ";
echo round($open_day_current / $open_day_total * 100000) / 1000;
echo "%\n\n";

?>
  </pre>
  <script src="js/vendor/modernizr-3.7.1.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.4.1.min.js"><\/script>')</script>
  <script src="js/plugins.js"></script>
  <script src="js/main.js"></script>

  <script src="https://www.google-analytics.com/analytics.js" async></script>
</body>

</html>
