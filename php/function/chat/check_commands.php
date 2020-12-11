<?php
header('Access-Control-Allow-Origin: *');
ini_set('safe_mode', '1');
ini_set('display_errors', 0);
error_reporting(0);
session_start();


function check_commands($room_id, $content) {
	
	
	$room_id = htmlspecialchars($room_id);
	$content = htmlspecialchars($content);
	
	$date = date('Y-m-d H:i:s');
	
	//Import SQL
	require $_SERVER['DOCUMENT_ROOT']."/sql/sql.php";
	
	//Select owner
	$sth = $db->prepare("SELECT owner FROM room WHERE id = :room_id");
	$sth->bindParam(":room_id", $room_id, PDO::PARAM_INT);
	$sth->execute();

	$row = $sth->fetch(PDO::FETCH_OBJ);
	
	$owner = $row->owner;


	$myuserid = $_SESSION['myuserid'];

	//Check if user exists
	$sth = $db->prepare("SELECT id FROM user WHERE id = :myuserid AND banned = 0");
	$sth->bindParam(":myuserid", $myuserid, PDO::PARAM_INT);
	$sth->execute();

	$row = $sth->fetch(PDO::FETCH_OBJ);
	
	$myuserid = $row->id;
	
	
	if(($room_id != NULL) AND ($myuserid != NULL) AND ($content != NULL)) {
			
		//if($myuserid == $owner) {
			
			//Chat Commands
			
			$content_explode = explode(" ", $content);
			
			//HOST = PING HOST
			if($content_explode[0] == '/host') {
				
					
				$sth = $db->prepare("SELECT id FROM user WHERE username = :username");
				$sth->bindParam(":username", $content_explode[1], PDO::PARAM_STR);
				$sth->execute();

				$row = $sth->fetch(PDO::FETCH_OBJ);
				
				$new_room_host_userid = $row->id;
				
				if($new_room_host_userid != NULL) {

					//Get id from owner
					$sth = $db->prepare("SELECT owner FROM room WHERE id = :room_id");
					$sth->bindParam(":room_id", $room_id, PDO::PARAM_INT);
					$sth->execute();

					$row = $sth->fetch(PDO::FETCH_OBJ);
					
					$owner_userid = $row->owner;


					//Get id from host
					$sth = $db->prepare("SELECT userid FROM room_sync WHERE room_id = :room_id AND host = 1");
					$sth->bindParam(":room_id", $room_id, PDO::PARAM_INT);
					$sth->execute();

					$row = $sth->fetch(PDO::FETCH_OBJ);
					
					$host_userid = $row->userid;

					//Check if I got the permissions to give someone else the host
					if(($owner_userid == $myuserid) OR ($host_userid == $myuserid)) {

						//Set me to 0
						$query = "UPDATE room_sync SET host = 0 WHERE room_id = :room_id AND userid = :userid ORDER BY id DESC;";
						$sth = $db->prepare($query);
						$sth->bindParam(":room_id", $room_id, PDO::PARAM_INT);
						$sth->bindParam(":userid", $myuserid, PDO::PARAM_INT);
						$sth->execute();

						//Set new host to 1
						$query = "UPDATE room_sync SET host = 1 WHERE room_id = :room_id AND userid = :userid ORDER BY id DESC;";
						$sth = $db->prepare($query);
						$sth->bindParam(":room_id", $room_id, PDO::PARAM_INT);
						$sth->bindParam(":userid", $new_room_host_userid, PDO::PARAM_INT);
						$sth->execute();
						
					}
					

				}
			
				return true;
				
			}


			if($content_explode[0] == '/help') {
				
					
				$sth = $db->prepare("SELECT id FROM user WHERE id = :userid");
				$sth->bindParam(":userid", $myuserid, PDO::PARAM_STR);
				$sth->execute();

				$row = $sth->fetch(PDO::FETCH_OBJ);
				
				$userid = $row->id;
				
				if($userid != NULL) {

					$query = "UPDATE room_sync SET infobox_help = 0 WHERE room_id = :room_id AND userid = :userid;";
					$sth = $db->prepare($query);
					$sth->bindParam(":room_id", $room_id, PDO::PARAM_INT);
					$sth->bindParam(":userid", $userid, PDO::PARAM_INT);
					$sth->execute();

				}
			
				return true;
				
			}

			if($content_explode[0] == '/commands') {
				
					
				$sth = $db->prepare("SELECT id FROM user WHERE id = :userid");
				$sth->bindParam(":userid", $myuserid, PDO::PARAM_STR);
				$sth->execute();

				$row = $sth->fetch(PDO::FETCH_OBJ);
				
				$userid = $row->id;
				
				if($userid != NULL) {

					$query = "UPDATE room_sync SET infobox_commands = 0 WHERE room_id = :room_id AND userid = :userid;";
					$sth = $db->prepare($query);
					$sth->bindParam(":room_id", $room_id, PDO::PARAM_INT);
					$sth->bindParam(":userid", $userid, PDO::PARAM_INT);
					$sth->execute();

				}
			
				return true;
				
			}

			if($content_explode[0] == '/ban') {
				
					
				$sth = $db->prepare("SELECT id FROM user WHERE username = :username");
				$sth->bindParam(":username", $content_explode[1], PDO::PARAM_STR);
				$sth->execute();

				$row = $sth->fetch(PDO::FETCH_OBJ);
				
				$userid = $row->id;
				
				if($userid != NULL) {

					
					//Check Permissions
					require $_SERVER['DOCUMENT_ROOT']."/php/function/room/check_permissions.php";
					$check_get = 'false';

					$permissions = check_permissions($room_id, $check_get);
					
					if($permissions == 1) {

						$query = "INSERT INTO room_ban (room_id, userid, create_date) VALUES(:room_id, :userid, :date)";
						$sth = $db->prepare($query);
						$sth->bindParam(":room_id", $room_id, PDO::PARAM_INT);
						$sth->bindParam(":userid", $userid, PDO::PARAM_INT);
						$sth->bindParam(":date", $date, PDO::PARAM_STR);
						$sth->execute();
					}
				}
			
				return true;
				
			}

			if($content_explode[0] == '/unban') {
				
					
				$sth = $db->prepare("SELECT id FROM user WHERE username = :username");
				$sth->bindParam(":username", $content_explode[1], PDO::PARAM_STR);
				$sth->execute();

				$row = $sth->fetch(PDO::FETCH_OBJ);
				
				$userid = $row->id;
				
				if($userid != NULL) {
					
					//Check Permissions
					require $_SERVER['DOCUMENT_ROOT']."/php/function/room/check_permissions.php";
					$check_get = 'false';

					$permissions = check_permissions($room_id, $check_get);
					
					if($permissions == 1) {
						$query = "UPDATE room_ban SET deleted = 1 WHERE room_id = :room_id AND userid = :userid;";
						$sth = $db->prepare($query);
						$sth->bindParam(":room_id", $room_id, PDO::PARAM_INT);
						$sth->bindParam(":userid", $userid, PDO::PARAM_INT);
						$sth->execute();
					}
				}
			
				return true;
				
			}


			if($content_explode[0] == '/mod') {
				
					
				$sth = $db->prepare("SELECT id FROM user WHERE username = :username");
				$sth->bindParam(":username", $content_explode[1], PDO::PARAM_STR);
				$sth->execute();

				$row = $sth->fetch(PDO::FETCH_OBJ);
				
				$userid = $row->id;
				
				if($userid != NULL) {

					
					//Check Permissions
					require $_SERVER['DOCUMENT_ROOT']."/php/function/room/check_permissions.php";
					$check_get = 'false';

					$permissions = check_permissions($room_id, $check_get);
					
					if($permissions == 1) {

						$query = "UPDATE room_sync SET moderator = 1 WHERE room_id = :room_id AND userid = :userid ORDER BY id DESC;";
						$sth = $db->prepare($query);
						$sth->bindParam(":room_id", $room_id, PDO::PARAM_INT);
						$sth->bindParam(":userid", $userid, PDO::PARAM_INT);
						$sth->execute();
					}
				}
			
				return true;
				
			}

			if($content_explode[0] == '/unmod') {
				
					
				$sth = $db->prepare("SELECT id FROM user WHERE username = :username");
				$sth->bindParam(":username", $content_explode[1], PDO::PARAM_STR);
				$sth->execute();

				$row = $sth->fetch(PDO::FETCH_OBJ);
				
				$userid = $row->id;
				
				if($userid != NULL) {

					
					//Check Permissions
					require $_SERVER['DOCUMENT_ROOT']."/php/function/room/check_permissions.php";
					$check_get = 'false';

					$permissions = check_permissions($room_id, $check_get);
					
					if($permissions == 1) {

						$query = "UPDATE room_sync SET moderator = 0 WHERE room_id = :room_id AND userid = :userid ORDER BY id DESC;";
						$sth = $db->prepare($query);
						$sth->bindParam(":room_id", $room_id, PDO::PARAM_INT);
						$sth->bindParam(":userid", $userid, PDO::PARAM_INT);
						$sth->execute();
					}
				}
			
				return true;
				
			}
		
		//}
	}
		

}