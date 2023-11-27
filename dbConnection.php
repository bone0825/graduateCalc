<?php
  $servername = "localhost";
  $username = "root";
  $password = "123qwe!@";
  $database = "graduate_calc";

  //connection
  $connection = new mysqli($servername, $username, $password, $database);

  //check conn
  if ($connection->connect_error){
    die("connection failed:" . $connection->connect_error);
  }
  ?>