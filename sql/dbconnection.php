<?php

require_once 'settings.php';

$connection = mysqli_connect($host, $user, $password, $database);
if(!$connection){
  http_response_code(500);
}
