<?php
session_start();
if (!isset($_SESSION['appuser'])) {
    header("Location: login.php");
    die();
}
require 'utils/connection.php';
$preparedStatement =$dbConnection->prepare('SELECT id, name, quantity FROM stock');
$preparedStatement->execute();

$display = $preparedStatement;

ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);


?>


<html>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="CSS/homepage_style.css">
    <link rel="stylesheet" type="text/css" href="CSS/modal1.css">
    <link rel="stylesheet" type="text/css" href="CSS/barchart.css">

    <head>
        <title>Home</title>

    </head>

    <body>
      <div id = 'logout'><b>
        <?php
           echo  $_SESSION['appuser'];
        ?>
      </b><a class = "button" href = "logout.php">Logout</a>
      </div>
      <div id = "new_account">Create New account</div>

      <div id="myModal2" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
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

              <div id = 'responseDiv'></div>
              <hr>
              <div class="clearfix">
                <br><center>
                <button type="submit" class="blue_button">Create</button>
              </center>
              </div>
          </form>
          </div>
        </div>






        <br>
      <h1>Video Games Stock</h1>

    </div class= 'row'><center>
    <a class = 'blue_button' href = "d3.php">See Graphic</a>
  </center><div>
    <br>
    <div id = 'graph' class = 'container'>
    </div>

      <div class = "container">
          <div id = "search_pannel">
            <div id = "input">
              <input type="text" id="search" placeholder="Search" onkeyup="liveSearch()"/>

              <button type="submit" class = 'blue_button' id="new_entry">Add new entry</button>


              <div id="myModal1" class="modal">
                <div class="modal-content">
                  <span class="close">&times;</span>
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

        </div
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
          var form = document.getElementById('modal_form1');
          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              var id = xhttp.responseText;
              var modal = document.getElementById('myModal1');
              modal.style.display = "none";
              form.reset();

              //Using Dom to create a new list item to represent the new new_entry
              //This must be done because we are avoiding reloading the page

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


            }
          };

          xhttp.open("GET", "utils/insertEntry.php?name="+name+"&qty="+quantity, true);
          xhttp.send();
        }

        function createUser(){
          var username = document.getElementById('username').value;
          var password = document.getElementById('password').value;
          var repeatPassword = document.getElementById('repeatPassword').value;
          var responseDiv = document.getElementById('responseDiv');

          responseDiv.innerHTML = "";

          var form2 = document.getElementById('modal_form2');
          var xhttp = new XMLHttpRequest();

          xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              var response = xhttp.responseText;
              if (response){

                responseDiv.innerHTML = response;


              }
              else{

                var modal2 = document.getElementById('myModal2');
                modal2.style.display = "none";
                form2.reset();
            }

            }
          };

          xhttp.open("GET", "utils/createUser.php?username="+username+"&psw="+password + "&psw-repeat="+repeatPassword, true);
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
        var modal1 = document.getElementById('myModal1');
        var btn = document.getElementById("new_entry");
        var span1 = document.getElementsByClassName("close")[1];
        var form1 = document.getElementById('modal_form1');

        btn.onclick = function() {
          modal1.style.display = "block";
        }

        span1.onclick = function() {
          modal1.style.display = "none";
          form1.reset();
        }

        window.onclick = function(event) {
          if (event.target == modal1) {
            modal1.style.display = "none";
            form1.reset();
          }
        }
        </script>


        <script>

        var modal2 = document.getElementById('myModal2');
        var trigger = document.getElementById("new_account");
        var span2 = document.getElementsByClassName("close")[0];
        var form2 = document.getElementById("modal_form2");

        trigger.onclick = function() {
          modal2.style.display = "block";

        }

        span2.onclick = function() {
          modal2.style.display = "none";
        form2.reset();
        }

        window.onclick = function(event) {
          if (event.target == modal2) {
            modal2.style.display = "none";
            form2.reset();
          }
        }
        </script>


        <script src="http://d3js.org/d3.v3.min.js"></script>
        <script>

        var data = [{
                "name": "Apples",
                "value": 20,
        },
            {
                "name": "Bananas",
                "value": 12,
        },
            {
                "name": "Grapes",
                "value": 19,
        },
            {
                "name": "Lemons",
                "value": 5,
        },
            {
                "name": "Limes",
                "value": 16,
        },
            {
                "name": "Oranges",
                "value": 25,
        },
            {
                "name": "Pears",
                "value": 20,
        }];

        alert('hi');
        var margin = {
                    top: 15,
                    right: 50,
                    bottom: 15,
                    left: 120
                };

        var width =  document.getElementById("graph").clientWidth ,
            height = 80 * data.length;

        var svg = d3.select("#graph").append("svg")
            .attr("preserveAspectRatio", "xMinYMin meet")
            .attr("viewBox", "0 0 "+width+" "+height)
            .attr("height", height )
            .append("g")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")");


          var x = d3.scale.linear()
            .range([0, width - margin.left -margin.right])
            .domain([0, d3.max(data, function (d) {
                return d.value;
            })]);

        var y = d3.scale.ordinal()
            .rangeRoundBands([height, 0], .1)
            .domain(data.map(function (d) {
                return d.name;
            }));

          var yAxis = d3.svg.axis().scale(y).orient("left");

        var gy = svg.append("g")
        .attr("class", "y axis")
        .call(yAxis)

        var bars = svg.selectAll(".bar")
        .data(data)
        .enter()
        .append("g")


//append rects
        bars.append("rect")
        .attr("class", "bar")
        .attr("y", function (d) {
        return y(d.name);
      })
      .attr("height", y.rangeBand())
      .attr("x", 0)
      .attr("width", function (d) {
        return x(d.value);
    });


    //add a value label to the right of each bar
      bars.append("text")
      .attr("class", "label")
      //y position of the label is halfway down the bar
      .attr("y", function (d) {
        return y(d.name) + y.rangeBand() / 2 + 4;
      })
      //x position is 6 pixels to the left of the bar
      .attr("x", function (d) {
        return x(d.value) - 30;
      })
      .text(function (d) {
        return d.value;

      });
      alert('pass4');


      function getData(){
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {

          if (this.readyState == 4 && this.status == 200) {

            //return dictionary
            var response = xhttp.responseText;
            if (response){
            }
            else{

          }

          }
        };

        xhttp.open("GET", "utils/selectAll.php", true);
        xhttp.send();
      }
        </script>
