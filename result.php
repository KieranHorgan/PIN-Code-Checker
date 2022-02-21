<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Place favicon.ico in the root directory -->

  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css?v=0.9">

  <meta name="theme-color" content="#fafafa">
</head>

<body>
  <!-- Add your site or application content here -->

<main>
  <section id="three-container">

<?php
include('config.php');
$existing_table = "existing_pin_codes";
$open_day_table = "open_day_pin_codes";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_pin = $_POST['pin_code'];
$user_pin = trim($user_pin);
$user_pin = stripslashes($user_pin);
$user_pin = htmlspecialchars($user_pin);

if (strlen($user_pin) != 4)
    throw new Exception("Pin code must be exactly 4 digits long");

for ($i = 0; $i < 4; $i++)
    if ($user_pin[$i] < '0' || $user_pin[$i] > '9')
        throw new Exception("Pin code must contain only digits 0-9");

$query = "UPDATE {$open_day_table} SET counter = counter+1 WHERE pin = {$user_pin};";
$conn->query($query);

$existing_total = $conn->query("SELECT SUM(counter) AS total FROM {$existing_table};")->fetch_assoc()["total"];
$existing_current = $conn->query("SELECT counter FROM {$existing_table} WHERE pin = {$user_pin};")->fetch_assoc()["counter"];
$existing_position = $conn->query("SELECT COUNT(*)  AS position from {$existing_table} WHERE {$existing_table}.counter > {$existing_current};")->fetch_assoc()["position"]+1;
$open_day_total = $conn->query("SELECT SUM(counter) AS total FROM {$open_day_table};")->fetch_assoc()["total"];
$open_day_current = $conn->query("SELECT counter FROM {$open_day_table} WHERE pin = {$user_pin};")->fetch_assoc()["counter"];
$open_day_position = $conn->query("SELECT COUNT(*)  AS position from {$open_day_table} WHERE {$open_day_table}.counter > {$open_day_current};")->fetch_assoc()["position"]+1;

echo "<section>";
echo "<h2>How common is your PIN?</h2>";
echo "<h3>There are <strong>10000</strong> possible PINs.";
echo "</h3>";
echo "<h3>";
echo "Your PIN is ranked <strong>{$existing_position}</strong>.";
echo "</h3>";
echo "<p>";
echo "About <strong>1 in ";
$one_in = round($existing_total / $existing_current);
if ($one_in >= 1000) {
    $one_in = round($existing_total / $existing_current / 100) * 100;
}
if ($one_in >= 10000) {
    $one_in = round($existing_total / $existing_current / 1000) * 1000;
}
echo $one_in;
echo "</strong> people use this PIN";
echo ".</p>";
echo "<p>This is how common your PIN is compared to<br>a sample of almost 6 million people's PINs!</p>";
echo "</section>";

echo "<section>";
echo "<h2>How does it compare?</h2>";
echo "<p>Your PIN has been entered <strong>{$open_day_current}</strong> time(s) today.";
echo "<p><strong>{$open_day_total}</strong> PINs have been entered today.";
echo "<h3>";
echo "Your PIN is ranked <strong>{$open_day_position}</strong> out of today's PINs.";
echo "</h3>";
echo "<p>";
echo "About <strong>1 in ";
$one_in = round($open_day_total / $open_day_current);
if ($one_in >= 1000) {
    $one_in = round($open_day_total / $open_day_current / 100) * 100;
}
if ($one_in >= 10000) {
    $one_in = round($open_day_total / $open_day_current / 1000) * 1000;
}
echo $one_in;
echo "</strong> people entered this PIN today";
echo ".</p>";
echo "</section>";

?>
    <div>
        <h3>Try on a phone or tablet?</h3>
        <img src="img/qr_code.png" style="width: 95%; max-width: 25rem"/>
    </div>

    <button id="return-button" onclick="location.href = './';">
      <h3>Try Another PIN?</h3>
      <p><small>You will be redirected<br>in <span id="counter">300</span> second(s).</small></p>
      <script type="text/javascript">
      function countdown() {
          var i = document.getElementById('counter');
          if (parseInt(i.innerHTML)<=0) {
              location.href = './';
          }
      if (parseInt(i.innerHTML)!=0) {
          i.innerHTML = parseInt(i.innerHTML)-1;
      }
      }
      setInterval(function(){ countdown(); },1000);
      </script>
    </button>
  </section>
</main>
<aside>
  <h2>Interested in more?</h2>
  <div>
    <section>
      <h3>Most Common PINs</h3>
      <table class="blog" width="200">
      <thead><tr><th></th><th>PIN</th><th>Freq</th></tr></thead>
      <tbody><tr><td align="center">#1</td><td align="center">1234</td><td align="right">10.713%</td></tr>
      <tr><td align="center">#2</td><td align="center">1111</td><td align="right">6.016%</td></tr>
      <tr><td align="center">#3</td><td align="center">0000</td><td align="right">1.881%</td></tr>
      <tr><td align="center">#4</td><td align="center">1212</td><td align="right">1.197%</td></tr>
      <tr><td align="center">#5</td><td align="center">7777</td><td align="right">0.745%</td></tr>
      <tr><td align="center">#6</td><td align="center">1004</td><td align="right">0.616%</td></tr>
      <tr><td align="center">#7</td><td align="center">2000</td><td align="right">0.613%</td></tr>
      <tr><td align="center">#8</td><td align="center">4444</td><td align="right">0.526%</td></tr>
      <tr><td align="center">#9</td><td align="center">2222</td><td align="right">0.516%</td></tr>
      <tr><td align="center">#10</td><td align="center">6969</td><td align="right">0.512%</td></tr>
      <tr><td align="center">#11</td><td align="center">9999</td><td align="right">0.451%</td></tr>
      <tr><td align="center">#12</td><td align="center">3333</td><td align="right">0.419%</td></tr>
      <tr><td align="center">#13</td><td align="center">5555</td><td align="right">0.395%</td></tr>
      <tr><td align="center">#14</td><td align="center">6666</td><td align="right">0.391%</td></tr>
      <tr><td align="center">#15</td><td align="center">1122</td><td align="right">0.366%</td></tr>
      <tr><td align="center">#16</td><td align="center">1313</td><td align="right">0.304%</td></tr>
      <tr><td align="center">#17</td><td align="center">8888</td><td align="right">0.303%</td></tr>
      <tr><td align="center">#18</td><td align="center">4321</td><td align="right">0.293%</td></tr>
      <tr><td align="center">#19</td><td align="center">2001</td><td align="right">0.290%</td></tr>
      <tr><td align="center">#20</td><td align="center">1010</td><td align="right">0.285%</td></tr>
      </tbody></table>
    </section>
    <section>
      <h3>Least Common PINs</h3>
      <table class="blog" width="250">
      <thead><tr><th></th><th>PIN</th><th>Freq</th></tr></thead>
      <tbody>
      <tr><td align="center">#9981</td><td align="center">9047</td><td align="right">0.001161%</td></tr>
      <tr><td align="center">#9982</td><td align="center">8438</td><td align="right">0.001161%</td></tr>
      <tr><td align="center">#9983</td><td align="center">0439</td><td align="right">0.001161%</td></tr>
      <tr><td align="center">#9984</td><td align="center">9539</td><td align="right">0.001161%</td></tr>
      <tr><td align="center">#9985</td><td align="center">8196</td><td align="right">0.001131%</td></tr>
      <tr><td align="center">#9986</td><td align="center">7063</td><td align="right">0.001131%</td></tr>
      <tr><td align="center">#9987</td><td align="center">6093</td><td align="right">0.001131%</td></tr>
      <tr><td align="center">#9988</td><td align="center">6827</td><td align="right">0.001101%</td></tr>
      <tr><td align="center">#9989</td><td align="center">7394</td><td align="right">0.001101%</td></tr>
      <tr><td align="center">#9990</td><td align="center">0859</td><td align="right">0.001072%</td></tr>
      <tr><td align="center">#9991</td><td align="center">8957</td><td align="right">0.001042%</td></tr>
      <tr><td align="center">#9992</td><td align="center">9480</td><td align="right">0.001042%</td></tr>
      <tr><td align="center">#9993</td><td align="center">6793</td><td align="right">0.001012%</td></tr>
      <tr><td align="center">#9994</td><td align="center">8398</td><td align="right">0.000982%</td></tr>
      <tr><td align="center">#9995</td><td align="center">0738</td><td align="right">0.000982%</td></tr>
      <tr><td align="center">#9996</td><td align="center">7637</td><td align="right">0.000953%</td></tr>
      <tr><td align="center">#9997</td><td align="center">6835</td><td align="right">0.000953%</td></tr>
      <tr><td align="center">#9998</td><td align="center">9629</td><td align="right">0.000953%</td></tr>
      <tr><td align="center">#9999</td><td align="center">8093</td><td align="right">0.000893%</td></tr>
      <tr><td align="center">#10000</td><td align="center">8068</td><td align="right">0.000744%</td></tr>
      </tbody></table>
    </section>
  <section>
    <h3>Credits</h3>
    <p>
      The sample data used was taken from<br>
      a study by <a href="https://www.datagenetics.com/blog/september32012/" target="_blank">DataGenetics</a>.</p>
    </p>
  </section>
  </div>
</aside>

  <script src="js/vendor/modernizr-3.7.1.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.4.1.min.js"><\/script>')</script>
  <script src="js/plugins.js"></script>
  <script src="js/main.js"></script>

  <script src="https://www.google-analytics.com/analytics.js" async></script>
</body>

</html>
