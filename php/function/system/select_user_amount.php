<?php
header('Access-Control-Allow-Origin: *');
ini_set('safe_mode', '1');
ini_set('display_errors', 0);
error_reporting(0);
session_start();


function select_user_amount() {
	
	//Import SQL
	require $_SERVER['DOCUMENT_ROOT']."/sql/sql.php";
	
	$sth = $db->prepare("SELECT id FROM user");
	$sth->execute();

	$amount = $sth->rowCount();
	
	return $amount;

}