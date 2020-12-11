<?php
$db_servername="sql315.your-server.de";
$db_user="ufile_login";
$db_pass="WtPTDp4zMMbTx7rw";
$db_name="ufile_db";

try {
    $db = new PDO("mysql:host=" . $db_servername . ";dbname=" . $db_name, $db_user, $db_pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed please try again in a few minutes.';
}
?>