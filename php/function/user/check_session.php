<?php
header('Access-Control-Allow-Origin: *');

session_start();

$getCheck = htmlspecialchars($_GET['get']);


$my_hash = $_COOKIE["session"];
$myuserid = $_SESSION["myuserid"];







	if($getCheck == 'true') {
		
		
		$result = check_session($getCheck);
		echo $result;
		
	}



function check_session($getCheck) {

	
	
	
	//Import SQL
	require  $_SERVER['DOCUMENT_ROOT']."/sql/sql.php";
	
	
	$my_hash = $_COOKIE["session"];
	$myuserid = $_SESSION["myuserid"];
	
	
		if($my_hash != NULL) {
	
			//Check Hash Session

			$sth = $db->prepare("SELECT userid, session_hash FROM user_session WHERE session_hash = :session_hash ORDER BY id DESC");
			$sth->bindParam(":session_hash", $my_hash, PDO::PARAM_STR);
			$sth->execute();

			$row = $sth->fetch(PDO::FETCH_OBJ);

			$checked_hash = $row->session_hash;
			$checked_hash_userid = $row->userid;
		
		}
		
		
		//Check Userid Session

		if($myuserid == NULL) {
			
			if($checked_hash_userid != NULL) {
				
				//Check if banned
				$sth = $db->prepare("SELECT id FROM user WHERE id = :userid AND banned = 0");
				$sth->bindParam(":userid", $checked_hash_userid, PDO::PARAM_INT);
				$sth->execute();

				$row = $sth->fetch(PDO::FETCH_OBJ);

				$checked_userid = $row->id;
				
				if($checked_userid != NULL) {
					
					$_SESSION['myuserid'] = $checked_userid;

				}
			}
			
			
		}
		else
		{
			
			//Check if banned
			$sth = $db->prepare("SELECT id FROM user WHERE id = :userid AND banned = 0");
			$sth->bindParam(":userid", $checked_hash_userid, PDO::PARAM_INT);
			$sth->execute();

			$row = $sth->fetch(PDO::FETCH_OBJ);

			$checked_userid = $row->id;
			
		}


	
	
	$date = date('Y-m-d H:i:s');
	
	if($checked_hash != NULL) {


			
			if($checked_userid != NULL) {
			
				$query = "UPDATE user_session SET date = :date WHERE session_hash = :session_hash ORDER BY id DESC;";
				$sth = $db->prepare($query);
				$sth->bindParam(":date", $date, PDO::PARAM_STR);
				$sth->bindParam(":session_hash", $checked_hash, PDO::PARAM_STR);
				$sth->execute();

				$session_status = 'true';
			
			}
			else
			{
				
				$_SESSION['myuserid'] = NULL;
				setcookie("session", "", time() - 3600);
				$session_status = 'false';
				
			}


		
	}
	else
	{
		
		$_SESSION['myuserid'] = NULL;
		setcookie("session", "", time() - 3600);
		$session_status = 'false';
		
	}
		
		
	if($getCheck == 'true') {
		
		$change = array('session_status' => $session_status);
		return json_encode($change);
		
	}
	else
	{
		
		$change = array('session_status' => $session_status);
		return $change;
		
	}

}