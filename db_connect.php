<?php

$servername = 'localhost';
$username = 'jakewpdd_jschwei';
$dbname = 'jakewpdd_db';
$dbpass = 'ARr4426R';
$table = 'testTable';

// Create connection
$conn = mysqli_connect($servername, $username, $dbpass, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>