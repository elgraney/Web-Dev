<?php
session_start();
if (!isset($_SESSION['appuser'])) {
  //return to login page and end session if session has no appuser
    header("Location: login.php");
    die();
}
require 'utils/connection.php';
//get all rows of the database
$preparedStatement =$dbConnection->prepare('SELECT id, name, quantity FROM stock');
$preparedStatement->execute();
//save as an array for use in page
$display = $preparedStatement;

//for debugging
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);
?>


<html>
    <link rel="stylesheet" type="text/css" href="CSS/homepage_style.css">
    <link rel="stylesheet" type="text/css" href="CSS/modal1.css">
    <link rel="stylesheet" type="text/css" href="CSS/barchart.css">

    <head>
        <title>Home</title>

    </head>

    <body>
      <!-- Container for the logout options in the top right -->
      <div id = 'logout'><b>
        <?php
        //shows the logged in account next to the logout button
           echo  $_SESSION['appuser'];
        ?>
        </b><a class = "button" href = "logout.php">Logout</a>
      </div>

      <div id = "new_account">Create New Account</div>

      <!-- Modal that appears when Create New Account is clicked -->
      <div id="myModal2" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>

            <!-- Contains form for inputting a new username and password, which is passed to createUser() -->
            <form action="javascript:createUser()" id = 'modal_form2'>

              <h2>Enter New Account Details</h2>
              <hr>

              <label for="title"><b>Username</b></label>
              <input type="text" placeholder="Enter Username" name="title" id='username' required>
              <br><br>

              <label for="psw"><b>Password</b></label>
              <input type="password" placeholder="Enter Password" name="psw" class = 'password' id='password' required>

              <label for="psw-repeat"><b>Repeat Password</b></label>
              <input type="password" placeholder="Repeat Password" name="psw-repeat" class = 'password' id = 'repeatPassword' required>

              <!-- Where errors are added -->
              <div id = 'responseDiv'></div>
              <hr>

              <br><center>
              <button type="submit" class="blue_button">Create</button>
              </center>

          </form>
          </div>
        </div>

        <br>
        <h1>Video Games Stock</h1>

        <!-- Sets up hovering 'Hide Graphic' button under the main heading -->
        <div >
          <center>
            <a id='toggleGraphicBtn' class = 'blue_button' href = "javascript:void(0)" onclick="toggleGraphic()" >Hide Graphic</a>
          </center>
        </div>
        <br>
        <!-- Placeholder div that will be used as a parent for all elements of the D3 bargraph -->
        <div id = 'graph' class = 'container'>
        </div>

        <!-- Container for searchbar and new entry button -->
        <div class = "container">
          <!-- subsection for searchbar  -->
          <div id = "search_pannel">
            <div id = "input">
              <input type="text" id="search" placeholder="Search" onkeyup="liveSearch()"/>

              <button type="submit" class = 'blue_button' id="new_entry">Add New Entry</button>

              <!-- Modal that appears when 'Add new entry' button is pressed -->
              <div id="myModal1" class="modal">
                <div class="modal-content">
                  <span class="close">&times;</span>
                  <!-- Inputs title and quantity then calls createEntry() when the button is pressed -->
                    <form action="javascript:createEntry()" id ='modal_form1'>

                      <h2>Enter New Video Game Details</h2>
                      <p>NOTE: Please do not create a new entry if the game already exists</p>
                      <hr>

                      <label for="title"><b>Title</b></label>
                      <input type="text" placeholder="Enter the game's title" name="title" id='title' required>
                      <br><br>

                      <label for="startQty"><b>Initial Quantity</b></label>
                      <input type="number" name="startQty" class= "quantity" min = '0' value= '1' id ='new_quantity' required>
                      <hr>

                      <br><center>
                      <button type="submit" class="blue_button">Create</button>
                      </center>
                  </form>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
      <!-- Container for main table of games and quantities -->
      <div class = 'container'>
        <!-- List for the titles of the 2 columns -->
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

        <!-- List of actual games and quantities -->
        <ul class = "display_list", id = 'table'>
          <!-- Creates a list item for every item in the $display array which contains all rows of the stock table -->
          <?php foreach($display as $row): ?>
            <li class = "item" id="list_item", style>
              <div class = "row">
                <!-- id is needed in multiple places so that each list item element has a unique id somewhere -->
                <?php
                $id =  $row["id"];
                ?>

                <div class = "left_column"><?php echo $row["name"] ?>
                  <!-- adds link text that calls deleteEntry on click next to name-->
                <a href='javascript:void(0)' onclick="deleteEntry(<?php echo $id ?>)">(delete)</a>
                </div>

                <!-- Has form for quantity, so that it can be changed in the table view -->
                <div class = "right_column">
                  <form  onchange = "changeButtonColour(this)">
                    <!-- initial value for the form is the quantity from the database -->
                    <!-- The submit button must be pressed for changes to be saved to the database.
                    The button is highlighted if the form has been changed and not submitted for ease of use
                    -->
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
        //called when a character is typed in searchbar
        function liveSearch() {
          //get values and elements that need to be used/changed

          var input = document.getElementById("search");
          var filter = input.value.toUpperCase();
          var ul = document.getElementById('table');
          var lis = ul.getElementsByTagName("li");

          //go through every game
          for (var i = 0; i<lis.length; i++)
          {
              //get name (also gets delete tag and html for it, but this is removed with .split)
              var name = lis[i].getElementsByClassName('left_column');
              //checks if search string matches this name
              if(name[0].innerHTML.split('<')[0].toUpperCase().indexOf(filter) > -1){
                //don't change display
                lis[i].style.display = "";
              }
              else{
                //hide this list element
                lis[i].style.display = "none";
              }
            }
         }



        function updateQuantity(id, tag){
          //get quantity from input, pass it tpp updateQuantity.php with ajax

          var quantity = document.getElementById(id).value;
          var xhttp = new XMLHttpRequest();

          //when the request is complete, update the graphic with the changes
          xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              updateGraphic();
            }
          }
          //send id and quantity to updateQuantity.php
          xhttp.open("GET", "utils/updateQuantity.php?id="+id+"&qty="+quantity, true);
          xhttp.send();

          //reset the style of the button
          var button = tag;
          button.style.backgroundColor = '';
          button.style.borderColor = "";
          button.style.color = '';
      }



        function changeButtonColour(tag){
          //changes the color of the button to blue

          var button = tag.getElementsByTagName("input")[1];
          button.style.backgroundColor = '#2196F3';
          button.style.borderColor = "blue";
          button.style.color = 'white';
        }



        function createEntry(){
          //uses ajax to pass name and quantity for a new game to insertEntry.php

          var name = document.getElementById('title').value;
          var quantity = document.getElementById('new_quantity').value;
          var form = document.getElementById('modal_form1');
          var xhttp = new XMLHttpRequest();

          //when the new item has been added to the database:
          xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              //the new id is returned
              var id = xhttp.responseText;
              //reset the modal form fields and hide it
              var modal = document.getElementById('myModal1');
              modal.style.display = "none";
              form.reset();

              //Using Dom to create a new list item to represent the new new_entry
              //the html for a new item is recreated in JS
              //This must be done because we are avoiding reloading the page, but want to show the new item

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
              div2.innerHTML = name+' ';
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

              //graphic must be updated to show the new entry
              updateGraphic();
            }
          };
          //send name and quantity to insertEntry.php with ajax GET
          xhttp.open("GET", "utils/insertEntry.php?name="+name+"&qty="+quantity, true);
          xhttp.send();
        }



        function createUser(){
          //Use Ajax to call createUser.php, passing new user data securely

          var username = document.getElementById('username').value;
          var password = document.getElementById('password').value;
          var repeatPassword = document.getElementById('repeatPassword').value;
          var responseDiv = document.getElementById('responseDiv');

          //reset the error message (in case there was a previous failed attempt)
          responseDiv.innerHTML = "";

          var form2 = document.getElementById('modal_form2');
          var xhttp = new XMLHttpRequest();

          //on successful call...
          xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              //response will only ever be an error message
              var response = xhttp.responseText;
              if (response){
                //display the error
                responseDiv.innerHTML = response;
              }
              else{
                //reset the form, close the modal
                var modal2 = document.getElementById('myModal2');
                modal2.style.display = "none";
                form2.reset();
            }
            }
          };
          //using post to send important data securely
          xhttp.open("POST", "utils/createUser.php", true);
          xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhttp.send("username="+username+"&psw="+password + "&psw-repeat="+repeatPassword);
        }



        function deleteEntry(id){
          //send ajax request with id to deleteEntry.php and remove the list item from the html

          var xhttp = new XMLHttpRequest();
          //sending ajax request
          xhttp.open("GET", "utils/deleteEntry.php?id="+id, true);
          xhttp.send();
          //getting the container for this list item
          var element = document.getElementById(id).parentNode.parentNode.parentNode.parentNode;
          //remove every child element of this container element
          while (element.firstChild) {
              element.removeChild(element.firstChild);
            }
          //remove the container element itself
          element.remove();
          //update graphic to show changes
          updateGraphic();
        }
        </script>




        <script>
        //script for the modal1:
        var modal1 = document.getElementById('myModal1');
        var btn = document.getElementById("new_entry");
        var span1 = document.getElementsByClassName("close")[1];
        var form1 = document.getElementById('modal_form1');

        //when the new entry button is clicked, display modal
        btn.onclick = function() {
          modal1.style.display = "block";
        }
        //when the close button is clicked (on the modal), hide modal
        span1.onclick = function() {
          modal1.style.display = "none";
          form1.reset();
        }
        //when the background is clicked, hide modal
        window.onclick = function(event) {
          if (event.target == modal1) {
            modal1.style.display = "none";
            form1.reset();
          }
        }
        </script>


        <script>
        //script for the modal2:
        var modal2 = document.getElementById('myModal2');
        var trigger = document.getElementById("new_account");
        var span2 = document.getElementsByClassName("close")[0];
        var form2 = document.getElementById("modal_form2");

        //when the new account button is clicked, display modal
        trigger.onclick = function() {
          modal2.style.display = "block";
        }

        //when the close button is clicked (on the modal), hide modal
        span2.onclick = function() {
          modal2.style.display = "none";
        form2.reset();
        }

        //when the background is clicked, hide modal
        window.onclick = function(event) {
          if (event.target == modal2) {
            modal2.style.display = "none";
            form2.reset();
          }
        }
        </script>

        //import d3 script
        <script src="http://d3js.org/d3.v3.min.js"></script>
        <script>
        function updateGraphic(){
          //clear any previously added elements so that parent element has no children
          //this avoids the graph being duplicated each update
          var parent = document.getElementById('graph');
          //remove every child element
          while (parent.firstChild) {
              parent.removeChild(parent.firstChild);
          }

          //initialise data, which will hold all games names and quantities
          var data = [];

          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              //response in form of array, that must be parsed
              var response = JSON.parse( xhttp.responseText);
              //if the ajax request returned anything
              if (response){

                //separate the combined names and qtys array into 2 arrays
                //Because there is a qty for every name, the split will be at the halfway point every time
                var names = response.splice(0, response.length / 2);
                var qtys = response;

                //set up the data variable with all needed values in a convenient format
                for (i = 0; i < names.length; i++){
                  var newData = {
                  "name": names[i],
                  "value": parseInt(qtys[i])};

                  data.push(newData);
                }
                //variable margin defines area around the graph for labels
                var margin = {
                  top: 15,
                  right: 50,
                  bottom: 15,
                  left: 120
                };

                //Set up display elements for a horizontal bar graph using D3

                //set up responsive dimensions of graphic display area
                var width =  document.getElementById("graph").clientWidth;
                var height = 60 * data.length;

                var svg = d3.select("#graph").append("svg")
                  .attr("preserveAspectRatio", "xMinYMin meet")
                  .attr("viewBox", "0 0 "+width+" "+height)
                  .attr("height", height )
                  .append("g")
                  .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

                var x = d3.scale.linear().range([0, width - margin.left -margin.right]).domain([0, d3.max(data, function (d) {
                      return d.value;
                })]);

                var y = d3.scale.ordinal().rangeRoundBands([height, 0], .1).domain(data.map(function (d) {
                      return d.name;
                }));

                var yAxis = d3.svg.axis().scale(y).orient("left");

                var gy = svg.append("g").attr("class", "y axis").call(yAxis);

                var bars = svg.selectAll(".bar").data(data).enter().append("g");


                //append rectangles
                bars.append("rect").attr("class", "bar").attr("y", function (d) {
                  return y(d.name);
                }).attr("height", y.rangeBand()).attr("x", 0).attr("width", function (d) {
                  return x(d.value);
                });


                //add a value label to the right of each bar
                bars.append("text").attr("class", "label").attr("y", function (d) {
                  return y(d.name) + y.rangeBand() / 2 + 4;
                }).attr("x", function (d) {
                  return x(d.value) +5;
                }).text(function (d) {
                  return d.value;
                });
            }
            else{
              //if the ajax request doesn't return anything
              alert('No items returned from database');
            }
          }
        };
        //ajax request to get all items from the stock tab
        xhttp.open("GET", "utils/selectAll.php", false);
        xhttp.send();
      }


      function toggleGraphic(){
        //If the graphic is hidden, show it; if shown, hide it

        var graph = document.getElementById('graph');
        var btn = document.getElementById('toggleGraphicBtn')
        //if hidden
        if (graph.style.display != 'none'){
            //refresh the graphic incase there has been changes
            updateGraphic();
            graph.style.display = "none";
            btn.innerHTML = 'Show Graphic'

        }
        //if shown
        else{
            graph.style.display = "";
            btn.innerHTML = 'Hide Graphic'
        }
      }

      //script to setup and then hide graphic when the page is loaded
      updateGraphic();
      toggleGraphic();
      </script>
