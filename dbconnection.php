<?php
require_once 'settings.php';

$connection = mysqli_connect($host, $user, $password, $database);
if(!$connection){
    echo "Error" . mysqli_connect_error();
    exit;
  }
session_start();