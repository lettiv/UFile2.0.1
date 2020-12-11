<?php
header('Access-Control-Allow-Origin: *');
ini_set('safe_mode', '1');
ini_set('display_errors', 0);
error_reporting(0);
session_start();

$room_id = htmlspecialchars($_GET['room_id']);
$room_hash = htmlspecialchars($_GET['room_hash']);
$content = htmlspecialchars($_POST['content']);

if(($room_id != NULL) AND ($room_hash != NULL) AND ($content != NULL)) {

	insert_message($room_id, $room_hash, $content);

}

function insert_message($room_id, $room_hash, $content) {
	
	$date = date('Y-m-d H:i:s');
	
	//Import SQL
	require $_SERVER['DOCUMENT_ROOT']."/sql/sql.php";
	
	//Check if room exists
	$sth = $db->prepare("SELECT id FROM room WHERE id = :room_id AND roomkey = :room_hash");
	$sth->bindParam(":room_id", $room_id, PDO::PARAM_INT);
	$sth->bindParam(":room_hash", $room_hash, PDO::PARAM_STR);
	$sth->execute();

	$row = $sth->fetch(PDO::FETCH_OBJ);
	
	$room_id = $row->id;


	$myuserid = $_SESSION['myuserid'];

	//Check if user exists
	$sth = $db->prepare("SELECT id FROM user WHERE id = :myuserid AND banned = 0");
	$sth->bindParam(":myuserid", $myuserid, PDO::PARAM_INT);
	$sth->execute();

	$row = $sth->fetch(PDO::FETCH_OBJ);
	
	$user_check = $row->id;
	
	
	
	
	if(($room_id != NULL) AND ($user_check != NULL) AND ($content != NULL)) {
			
		//Chat Commands
		
			require $_SERVER['DOCUMENT_ROOT']."/php/function/chat/check_commands.php";
			
			
			$check = check_commands($room_id, $content);
			
			if($check == NULL) {
			
				$query = "INSERT INTO chat (room_id, userid, content, date) VALUES(:room_id, :myuserid, :content, :date)";
				$sth = $db->prepare($query);
				$sth->bindParam(":room_id", $room_id, PDO::PARAM_INT);
				$sth->bindParam(":myuserid", $myuserid, PDO::PARAM_INT);
				$sth->bindParam(":content", $content, PDO::PARAM_STR);
				$sth->bindParam(":date", $date, PDO::PARAM_STR);
				$sth->execute();
				
				echo 'message was sent';
		
			}
	}
		

}