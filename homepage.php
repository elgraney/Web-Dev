<?php
session_start();
if (!isset($_SESSION['appuser'])) {
    header("Location: login.php");
    die();
}
require 'utils/connection.php';
$sql = "SELECT name, Quantity FROM stock";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo " - Name: " . $row["name"]. " " . $row["Quantity"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>
?>

<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="CSS/mainstyle.css">
    <head>
        <title>Home</title>
    </head>
    <body>
      <div id = 'logout'>
        <?php
          echo $_SESSION['appuser'];
        ?>
        <a class = "button" href = "logout.php">Logout</a>
      </div>
      <h1>Video Games Stock</h1>

      <div class = "container">
          <div id = "search_pannel">
            <div id = "input">
              <input id ="search" data-list = ".search_list" type = "search" placeholder='search'>

              <button type="submit" onclick="PLACEHOLDER"  id="new_entry">Add new entry</button>

          </div>
        </div>
      </div>


      <div class = 'container'>
        <ul class = "display_list">
          <li class = 'item'>
            <b>
              <div class = "row">
                <div class = "left_column">Name</div>
                <div class = "right_column">Quantity</div>
              </div>
            </b>
          </li>
        </ul>

        <ul class = "display_list">
          <?php foreach($result as $row): ?>
            <li class = "item">
              <div class = "row">
                <div class = "left_column"><?php echo $row["name"] ?></div>
                <div class = "right_column"><?php echo $row["Quantity"] ?></div>
              </div>
            </li>
            <?php endforeach; ?>

            <li class = "item">
              <div class = "row">
                <div class = "left_column">Placeholder name</div>
                <div class = "right_column">Placeholder qty</div>
              </div>
            </li>
            <li class = "item">
              <div class = "row">
                <div class = "left_column">Placeholder name 2</div>
                <div class = "right_column">Placeholder qty 2</div>
              </div>
            </li>
          </ul>
        </div>
    </body>
</html>
