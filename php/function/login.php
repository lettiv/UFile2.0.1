<?php
header('Access-Control-Allow-Origin: *');
ini_set('safe_mode', '1');
ini_set('display_errors', 0);
error_reporting(0);
session_start();

$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);

//$username = htmlspecialchars($_GET['username']);
//$password = htmlspecialchars($_GET['password']);



$room_hash = htmlspecialchars($_POST['room_hash']);

if(($username != NULL) AND ($password != NULL)) {

	$check = login_register($username, $password);
	
	
	if($check == "true") {
		
		if($room_hash != NULL) {
			

			echo 'room';
			
		}
		else
		{
		
			echo 'success';

		}
		
	}
	
	if($check == 'registered') {
	
		echo 'You are now registered!';
		
	}


	if($check == 'user_exists') {
	
		echo 'This username is not available / your password is wrong! ';
		
	}

	if($check == 'password_short') {
	
		echo 'Password too short - minimum length is 5 characters!';
		
	}

	if($check == 'spam') {
	
		echo 'Spam protection - please wait a few seconds!';
		
	}
	
	
}
else
{
	echo 'null';
}


function login_register($username, $password) {
	//Import SQL
	require $_SERVER['DOCUMENT_ROOT']."/sql/sql.php";

	$date = date('Y-m-d H:i:s');
	$IP = $_SERVER['REMOTE_ADDR'];
	
	$salt = "ichverschluessledich";
	$username = str_replace(' ', '', $username);
	$hash_password = hash_hmac ("sha512", $password , $salt);
	$hash_session = hash_hmac ("sha512", $salt , $date);


	if(($username != NULL) AND ($hash_password != NULL)) {

		//Check if user exists with this combination
		$sth = $db->prepare("SELECT id FROM login_log WHERE ip = :ip AND date >= NOW() - INTERVAL 30 SECOND");
		$sth->bindParam(":ip", $IP, PDO::PARAM_STR);
		$sth->execute();
		
		$count = $sth->rowCount();
		
		if($count > 5) {
			
			return "spam";
			exit;
			
		}

		//Check if user exists with this combination
		$sth = $db->prepare("SELECT id FROM user WHERE username = :username AND pass = :pass");
		$sth->bindParam(":username", $username, PDO::PARAM_STR);
		$sth->bindParam(":pass", $hash_password, PDO::PARAM_STR);
		$sth->execute();
					
		$row = $sth->fetch(PDO::FETCH_OBJ);
		
		$myuserid = $row->id;


		
		
		if($myuserid != NULL) {
			
			$query = "INSERT INTO login_log (userid, date, ip, successfully) VALUES(:userid, :date, :ip, 1)";
			$sth = $db->prepare($query);
			$sth->bindParam(":userid", $myuserid, PDO::PARAM_INT);
			$sth->bindParam(":date", $date, PDO::PARAM_STR);
			$sth->bindParam(":ip", $IP, PDO::PARAM_STR);
			$sth->execute();

			$query = "INSERT INTO user_session (userid, session_hash, create_date, date) VALUES(:userid, :hash, :create_date, :date)";
			$sth = $db->prepare($query);
			$sth->bindParam(":userid", $myuserid, PDO::PARAM_INT);
			$sth->bindParam(":hash", $hash_session, PDO::PARAM_STR);
			$sth->bindParam(":create_date", $date, PDO::PARAM_STR);
			$sth->bindParam(":date", $date, PDO::PARAM_STR);
			$sth->execute();
		
			$_SESSION["myuserid"] = $myuserid;
			
			$cookie_name = "session";
			$cookie_value = $hash_session;
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day * 30 days

			return "true";

			
		}
		else
		{
			
			//Check if username exists
			$sth = $db->prepare("SELECT id FROM user WHERE username = :username");
			$sth->bindParam(":username", $username, PDO::PARAM_STR);
			$sth->execute();
						
			$row = $sth->fetch(PDO::FETCH_OBJ);
			
			$myuserid = $row->id;
			
			if($myuserid != NULL) {
				
				$query = "INSERT INTO login_log (userid, date, ip, successfully) VALUES(:userid, :date, :ip, 0)";
				$sth = $db->prepare($query);
				$sth->bindParam(":userid", $myuserid, PDO::PARAM_INT);
				$sth->bindParam(":date", $date, PDO::PARAM_STR);
				$sth->bindParam(":ip", $IP, PDO::PARAM_STR);
				$sth->execute();
			
				return "user_exists";
				
			}
			else
			{
				
				
				
				if(strlen($password) < 5) {
				
					return "password_short";
					exit;
				}
				
				
				//Create new User
				$query = "INSERT INTO user (username, pass, create_date, ip) VALUES(:username, :pass, :create_date, :ip)";
				$sth = $db->prepare($query);
				$sth->bindParam(":username", $username, PDO::PARAM_STR);
				$sth->bindParam(":pass", $hash_password, PDO::PARAM_STR);
				$sth->bindParam(":create_date", $date, PDO::PARAM_STR);
				$sth->bindParam(":ip", $IP, PDO::PARAM_STR);
				$sth->execute();
				
				//Get Userid
				$sth = $db->prepare("SELECT id FROM user WHERE username = :username AND pass = :pass");
				$sth->bindParam(":username", $username, PDO::PARAM_STR);
				$sth->bindParam(":pass", $hash_password, PDO::PARAM_STR);
				$sth->execute();
							
				$row = $sth->fetch(PDO::FETCH_OBJ);
				
				$myuserid = $row->id;
				
				if($myuserid != NULL) {
					
					$query = "INSERT INTO login_log (userid, date, ip, successfully) VALUES(:userid, :date, :ip, 1)";
					$sth = $db->prepare($query);
					$sth->bindParam(":userid", $myuserid, PDO::PARAM_INT);
					$sth->bindParam(":date", $date, PDO::PARAM_STR);
					$sth->bindParam(":ip", $IP, PDO::PARAM_STR);
					$sth->execute();

					$query = "INSERT INTO user_session (userid, session_hash, create_date) VALUES(:userid, :hash, :date)";
					$sth = $db->prepare($query);
					$sth->bindParam(":userid", $myuserid, PDO::PARAM_INT);
					$sth->bindParam(":hash", $hash_session, PDO::PARAM_STR);
					$sth->bindParam(":date", $date, PDO::PARAM_STR);
					$sth->execute();
				
					$_SESSION["myuserid"] = $myuserid;
					
					$cookie_name = "session";
					$cookie_value = $hash_session;
					setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day * 30 days

					return "true";
					exit;
				}
				
			}
		}
		
		
	}
}
?>