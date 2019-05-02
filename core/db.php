<?php 

/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password)  id7556151_root 12345 id7556151_example*/
// define('DB_SERVER', 'localhost');
// define('DB_USERNAME', 'root');
// define('DB_PASSWORD', '');
// define('DB_NAME', 'coop');

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'coop';
 
/* Attempt to connect to MySQL database */
$db = new mysqli($server, $username, $password, $database);
 
// Check connection
if($db === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}

?>