<?php
session_start();
if (!isset($_SESSION['appuser'])) {
    header("Location: login.php");
    die();
}
require 'utils/connection.php';
$sql = "SELECT id, name, quantity FROM stock";
$result = $conn->query($sql);
$display = $result;

ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);


$conn->close();
?>


<html>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="CSS/homepage_style.css">
    <link rel="stylesheet" type="text/css" href="CSS/modal.css">

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
              <input type="text" id="search" placeholder="Search" onkeyup="liveSearch()"/>

              <button type="submit" class = 'blue_button' id="new_entry">Add new entry</button>


              <div id="myModal" class="modal">
                <div class="modal-content">
                  <span class="close">&times;</span>
                    <form action="javascript:createEntry()" id ='modal_form'>

                      <h2>Enter New Video Game Details</h2>
                      <p>NOTE: Please do not create a new entry if the game already exists</p>
                      <hr>
                      <label for="title"><b>Title</b></label>
                      <input type="text" placeholder="Enter the game's title" name="title" id='title' required>
                      <br><br>
                      <label for="startQty"><b>Initial Quantity</b></label>
                      <input type="number" name="startQty" class= "quantity" min = '0' value= '1' id ='new_quantity' required>
                      <hr>
                      <div class="clearfix">
                        <br><center>
                        <button type="submit" class="blue_button">Create</button>
                      </center>
                      </div>
                  </form>
                  </div>
                </div>

              </div>
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

        <ul class = "display_list", id = 'table'>
          <?php foreach($display as $row): ?>
            <li class = "item" id= "list_item", style>
              <div class = "row">
                <div class = "left_column"><?php echo $row["name"] ?></div>
                <div class = "right_column">
                  <?php
                  $id =  $row["id"];
                  ?>
                  <form  onchange = "changeButtonColour(this)">
                    <input class="quantity" id = <?php echo $id ?> type="number" name="quantity" min="0" value="<?php echo $row['quantity']; ?>">
                    <input type="button" onClick="updateQuantity(<?php echo $id ?>, this)" value="Submit">
                  </form>

                </div>
              </div>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <script>
        function liveSearch() {

          var input = document.getElementById("search");

            var filter = input.value.toUpperCase();
            var ul = document.getElementById('table');
            var lis = ul.getElementsByTagName("li");
            for (var i = 0; i<lis.length; i++)
            {
              var name = lis[i].getElementsByClassName('left_column');
              if(name[0].innerHTML.toUpperCase().indexOf(filter) > -1){
                  lis[i].style.display = "";
              }
              else{
                lis[i].style.display = "none";
              }
            }
         }

        function updateQuantity(id, tag){

          var quantity = document.getElementById(id).value;

          var xhttp = new XMLHttpRequest();

          xhttp.open("GET", "utils/updateQuantity.php?id="+id+"&qty="+quantity, true);
          xhttp.send();

          var button = tag;

          button.style.backgroundColor = '';
          button.style.borderColor = "";
          button.style.color = '';
        }

        function changeButtonColour(tag){
          var button = tag.getElementsByTagName("input")[1];
          button.style.backgroundColor = '#2196F3';
          button.style.borderColor = "blue";
          button.style.color = 'white';
        }

        function createEntry(){
          var name = document.getElementById('title').value;
          var quantity = document.getElementById('new_quantity').value;

          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              var modal = document.getElementById('myModal');
              modal.style.display = "none";
              alert("pass");
            }
          };

          xhttp.open("GET", "utils/insertEntry.php?name="+name+"&qty="+quantity, true);
          xhttp.send();

        }
        </script>




        <script>
        var modal = document.getElementById('myModal');
        var btn = document.getElementById("new_entry");
        var span = document.getElementsByClassName("close")[0];
        var form = document.getElementById('modal_form');

        btn.onclick = function() {
          modal.style.display = "block";
        }

        span.onclick = function() {
          modal.style.display = "none";
          form.reset();
        }

        window.onclick = function(event) {
          if (event.target == modal) {
            modal.style.display = "none";
            form.reset();
          }
        }
        </script>

    </body>
</html>
