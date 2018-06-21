<?php
ob_start();


if(!isset($_SESSION)){
    session_start();
}


$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'crudapp';

$connection = mysqli_connect($host, $user, $pass, $db_name);

if(!$connection){
    die("CONNECTION TO DB FAILED. " . mysqli_error($connection));
}


?>