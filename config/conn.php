<?php
$conn = mysqli_connect("localhost","root","","pharmacy_db");
if(!$conn){
  echo "ther is error".mysqli_connect_error();
}

?>