<?php
header('Access-Control-Allow-Origin: *');
ini_set('safe_mode', '1');
ini_set('display_errors', 0);
error_reporting(0); 
session_start();

$getCheck = htmlspecialchars($_GET['get']);
$userid = htmlspecialchars($_GET['userid']);

if($userid != NULL) {

	if($getCheck == 'true') {
		
		$result = check_premium($userid, $getCheck);
		echo $result;
		
	}
	else
	{
		
		$getCheck = 'false';
		
		$result = check_premium($userid, $getCheck);
		echo $result;
		
	}
}


function check_premium($userid, $getCheck) {
	//Import SQL
	require  $_SERVER['DOCUMENT_ROOT']."/sql/sql.php";
	
	$sth = $db->prepare("SELECT create_date, active FROM user_premium WHERE userid = :userid");
	$sth->bindParam(":userid", $userid, PDO::PARAM_INT);
	$sth->execute();

	$row = $sth->fetch(PDO::FETCH_OBJ);
		
	$create_date = $row->create_date;
	$active = $row->active;
		
	if($active == 1) {

		//$premium_icon = '<i title="Premium" class="fas fa-star premium_color_icon"></i>';
		$premium_icon = '<span title="Premium" class="premium_icon">⭐</span>';
		
	}
	else
	{

		$premium_icon = NULL;
		
	}
		
	if($getCheck == 'true') {
		
		$change = array('create_date' => $create_date, 'active' => $active, 'icon' => $premium_icon);
		return json_encode($change);
		
	}
	else
	{
		
		$change = array('create_date' => $create_date, 'active' => $active, 'icon' => $premium_icon);
		return $change;
		
	}

}