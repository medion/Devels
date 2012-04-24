<?php

/*
$mysql_host = 'localhost';
$mysql_user = 'root';
$mysql_pass = '';

$mysql_db = 'devels';

if (!mysql_connect($mysql_host, $mysql_user, $mysql_pass)||!mysql_select_db($mysql_db)) {
    die(mysql_error());
}
mysql_query("SET CHARACTER SET 'utf8'");
 */
define (SQLCHARSET, 'utf8');

$host = 'localhost';
$dbname = 'devels';
$user = 'root';
$pass = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $db->query ( 'SET character_set_connection = ' . SQLCHARSET . ';' );  
    $db->query ( 'SET character_set_client = ' . SQLCHARSET . ';' );  
    $db->query ( 'SET character_set_results = ' . SQLCHARSET . ';' );
}
catch(PDOException $e) {
    echo $e->getMessage();
}

?>