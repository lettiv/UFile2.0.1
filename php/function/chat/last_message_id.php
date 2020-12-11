<?php
header('Access-Control-Allow-Origin: *');
ini_set('safe_mode', '1');
ini_set('display_errors', 0);
error_reporting(0);
session_start();

$room_id = htmlspecialchars($_GET['room_id']);
$room_hash = htmlspecialchars($_GET['room_hash']);
$last_content_id = htmlspecialchars($_GET["last_content_id"]);

if(($room_id != NULL) AND ($room_hash != NULL)) {


	//Import SQL
	require $_SERVER['DOCUMENT_ROOT']."/sql/sql.php";
	
	//Check if room exists
	$sth = $db->prepare("SELECT id, owner FROM room WHERE id = :room_id AND roomkey = :room_hash");
	$sth->bindParam(":room_id", $room_id, PDO::PARAM_INT);
	$sth->bindParam(":room_hash", $room_hash, PDO::PARAM_STR);
	$sth->execute();

	$row = $sth->fetch(PDO::FETCH_OBJ);
	
	$room_check = $row->id;

	$room_owner = $row->owner;

	$myuserid = $_SESSION['myuserid'];

	//Check if user exists
	$sth = $db->prepare("SELECT id FROM user WHERE id = :myuserid AND banned = 0");
	$sth->bindParam(":myuserid", $myuserid, PDO::PARAM_INT);
	$sth->execute();

	$row = $sth->fetch(PDO::FETCH_OBJ);
	
	$user_check = $row->id;
	
	
	if(($room_check != NULL) AND ($user_check != NULL)) {
	
			$sth = $db->prepare("SELECT id FROM chat WHERE room_id = :room_id ORDER BY id DESC LIMIT 1");
			$sth->bindParam(':room_id', $room_id, PDO::PARAM_INT);
			$sth->execute();

			$row = $sth->fetch(PDO::FETCH_OBJ);

			$message_id = $row->id;
			
			echo $message_id;
		
	}
}