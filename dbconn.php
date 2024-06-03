<?php
date_default_timezone_set('Asia/Jakarta');

$server   = "localhost";
$user     = "root";
$pass     = "";
$database = "ppdb";

$conn = mysqli_connect($server, $user, $pass, $database);
if (!$conn) die('Database Error');
