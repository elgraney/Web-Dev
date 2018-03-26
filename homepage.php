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
            <li class = "item" id="list_item", style>
              <div class = "row">
                <?php
                $id =  $row["id"];
                ?>
                <div class = "left_column"><?php echo $row["name"] ?>
                <a href='javascript:void(0)' onclick="deleteEntry(<?php echo $id ?>)">(delete)</a>
                </div>
                <div class = "right_column">
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
          var form = document.getElementById('modal_form');
          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              var id = xhttp.responseText;
              var modal = document.getElementById('myModal');
              modal.style.display = "none";
              form.reset();
              alert(id);
              //RETURN AND USE ID


              //Using Dom to create a new list item to represent the new new_entry
              //This must be done because we are avoiding reloading the page
              alert('ready');
              var parent = document.getElementById('table');

              var li = document.createElement('li');
              li.setAttribute('class' ,'item');
              li.setAttribute('id' , 'item_list');
              parent.appendChild(li);

              var div1 = document.createElement('div');
              div1.setAttribute('class' ,'row');
              li.appendChild(div1);

              var div2 = document.createElement('div');
              div2.setAttribute('class' ,'left_column');
              div2.innerHTML = name;
              div1.appendChild(div2);

              var a = document.createElement('a');
              a.setAttribute('href', 'javascript:void(0)');
              a.setAttribute('onClick', 'deleteEntry('+id+')');
              a.innerHTML = '(delete)';
              div2.appendChild(a);

              var div3 =  document.createElement('div');
              div3.setAttribute('class' ,'right_column');
              div1.appendChild(div3);

              var form1 =  document.createElement('form');
              form1.setAttribute('onChange' ,'changeButtonColour(this)');
              div3.appendChild(form1);

              var input1 = document.createElement('input');
              input1.setAttribute('class', 'quantity');
              input1.setAttribute('id', id);
              input1.setAttribute('type','number');
              input1.setAttribute('name','quantity');
              input1.setAttribute('min','0');
              input1.setAttribute('value', quantity);
              form1.appendChild(input1);

              var input2 = document.createElement('input');
              input2.setAttribute('type','button');
              input2.setAttribute('onClick','updateQuantity('+id+')');
              input2.setAttribute('value', 'submit');
              form1.appendChild(input2);


              alert('full pass');

            }
          };

          xhttp.open("GET", "utils/insertEntry.php?name="+name+"&qty="+quantity, true);
          xhttp.send();
        }


        function deleteEntry(id){
          var xhttp = new XMLHttpRequest();
          xhttp.open("GET", "utils/deleteEntry.php?id="+id, true);
          xhttp.send();
          var element = document.getElementById(id).parentNode.parentNode.parentNode.parentNode;
          while (element.firstChild) {
              element.removeChild(element.firstChild);
            }
          element.remove();
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
