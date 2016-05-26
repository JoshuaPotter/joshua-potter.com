<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'Appearly$';
$conn = mysql_connect($dbhost, $dbuser, $dbpass);

mysql_select_db('yetichat_lore', $conn);