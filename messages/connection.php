<?php

$enable_nma = 1;
$enable_ortc = 0;
$messages_host = 'nasberrypi';

$mysql_host = 'localhost';
$mysql_dbn = 'router';
$mysql_dbn_users = 'router';
$mysql_user = 'root';
$mysql_pw = '';
require '/etc/mysql/conf.php';

$mysql_failed_inserts = "/var/www/messagelogs/".$mysql_dbn . "_" . date('Ymd', time()) . ".sql";

$conn = @mysql_connect($mysql_host, $mysql_user, $mysql_pw) ;//or die("Unable to connect to MySQL");
@mysql_select_db($mysql_dbn, $conn) ;//or die("Could not select examples");

?>