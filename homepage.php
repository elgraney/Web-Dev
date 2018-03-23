<?php
session_start();
if (!isset($_SESSION['appuser'])) {
    header("Location: login.php");
    die();
}
require 'utils/connection.php';
$sql = "SELECT name, Quantity FROM stock";
$result = $conn->query($sql);
$display = $result;

$conn->close();
?>




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
              <input type="text" id="search" placeholder="Search" onkeyup="myFunction()"/>

              <button type="submit" onclick="PLACEHOLDER"  id="new_entry">Add new entry</button>
              <div id="display"></div>
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
          <?php foreach($display as $row): ?>
            <li class = "item">
              <div class = "row">
                <div class = "left_column"><?php echo $row["name"] ?></div>
                <div class = "right_column"><?php echo $row["Quantity"] ?></div>
              </div>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <script>


        function myFunction() {

          var name = document.getElementById("search");
          name.value = name.value.toUpperCase();

          if (name == "") {

           $("#display").html("");

         }

         else {

           $.ajax({type: "POST",url: "utils/ajax.php", data: {search: name},
               success: function(html) {
                   $("#display").html(html).show();
               }

           });
         }
       }
        </script>


    </body>
</html>
