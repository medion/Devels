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


$host = 'localhost';
$dbname = 'devels';
$user = 'root';
$pass = '';



try {
    $db = new PDO("mysql:host=$host;charset=utf8;dbname=$dbname", $user, $pass);
    echo 'connect complite';
}
catch(PDOException $e) {
    echo $e->getMessage();
}

?>