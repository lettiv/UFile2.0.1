<?php
header('Access-Control-Allow-Origin: *');
ini_set('safe_mode', '1');
ini_set('display_errors', 0);
error_reporting(0);
session_start();

$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);
$email = htmlspecialchars($_POST['email']);
$action = htmlspecialchars($_POST['action']);

/* $username = htmlspecialchars($_GET['username']);
$password = htmlspecialchars($_GET['password']);
$action = htmlspecialchars($_GET['action']); */


$array = array(
    "action" => $action,
    "username" => $username,
    "email" => $email,
    "password" => $password,
);

if($array != NULL) {

	$check = login_register($array);
	
	
	if($check == "true") {
		
		echo 'success';

	}
	
	if($check == 'registered') {
	
		echo 'You are now registered!';
		
	}

	if($check == 'user_exists') {
	
		echo 'user_exists';
		
	}

	if($check == 'user_available') {
	
		echo 'user_available';
		
	}

	if($check == 'username_short') {
	
		echo 'username_short';
		
	}

	if($check == 'email_exists') {
	
		echo 'email_exists';
		
	}

	if($check == 'email_available') {
	
		echo 'email_available';
		
	}

	if($check == 'password_short') {
	
		echo 'password_short';
		
	}

	if($check == 'password_wrong') {
	
		echo 'password_wrong';
		
	}

	if($check == 'spam') {
	
		echo 'Spam protection - please wait a few seconds!';
		
	}
}
else
{
	echo 'null';
}


function login_register($array) {
	//Import SQL
	require $_SERVER['DOCUMENT_ROOT']."/sql/sql.php";

	$date = date('Y-m-d H:i:s');
	$IP = $_SERVER['REMOTE_ADDR'];
	
	$salt = "ichverschluessledich";
	$action = $array['action'];//Means what we check now (username, password etc.)

	if($array['username'] != NULL) {
		$username = str_replace(' ', '', $array['username']);
	}
	if($array['email'] != NULL) {
		$email = str_replace(' ', '', $array['email']);
	}
	if($array['password'] != NULL) {
		$password = $array['password'];
		$hash_password = hash_hmac ("sha512", $array['password'] , $salt);	
	}
	
	$hash_session = hash_hmac ("sha512", $salt , $date);


	if(($action == 'username') AND ($username != NULL)) {
		
		//Check if user exists with this combination
		$sth = $db->prepare("SELECT id FROM user WHERE username = :username");
		$sth->bindParam(":username", $username, PDO::PARAM_STR);
		$sth->execute();
		
		$count = $sth->rowCount();
	
		if($count > 0) {
			return 'user_exists';
		}
		else
		{
			return 'user_available';
		}
		exit;
	}


	if(($action == 'email') AND ($email != NULL)) {
		
		//Check if email is available
		$sth = $db->prepare("SELECT id FROM user_email WHERE email = :email");
		$sth->bindParam(":email", $email, PDO::PARAM_STR);
		$sth->execute();
		
		$count = $sth->rowCount();
		
		if($count > 0) {
			return 'email_exists';
		}
		else
		{
			return 'email_available';
		}
		exit;
	}


	//Login
	if(($action == 'login') AND ($username != NULL) AND ($hash_password != NULL)) {

		//Check if user login spam
		$sth = $db->prepare("SELECT id FROM login_log WHERE ip = :ip AND date >= NOW() - INTERVAL 30 SECOND");
		$sth->bindParam(":ip", $IP, PDO::PARAM_STR);
		$sth->execute();
		
		$count = $sth->rowCount();
		
		if($count > 5) {
			
			return "spam";
			exit;
			
		}

		//Check if username exists
		$sth = $db->prepare("SELECT id FROM user WHERE username = :username");
		$sth->bindParam(":username", $username, PDO::PARAM_STR);
		$sth->execute();
					
		$row = $sth->fetch(PDO::FETCH_OBJ);
		
		$myuserid = $row->id;

		//Check if user exists with userid and password
		$sth = $db->prepare("SELECT id FROM user_pass WHERE userid = :myuserid AND pass = :pass");
		$sth->bindParam(":myuserid", $myuserid, PDO::PARAM_INT);
		$sth->bindParam(":pass", $hash_password, PDO::PARAM_STR);
		$sth->execute();
					
		$row = $sth->fetch(PDO::FETCH_OBJ);
		
		$user_check = $row->id;

		if($user_check != NULL) {
			
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
			return "password_wrong";
		}
	}
	
	
	//Register
	if(($action == 'register') AND ($username != NULL) AND ($email != NULL) AND ($hash_password != NULL)) {
		
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
			
			//Check if email exists
			$sth = $db->prepare("SELECT id FROM user_email WHERE email = :email");
			$sth->bindParam(":email", $email, PDO::PARAM_STR);
			$sth->execute();
						
			$row = $sth->fetch(PDO::FETCH_OBJ);
			
			$check_email = $row->id;
			
			if($check_email != NULL) {
				
				return "email_exists";
				exit;
			}
			
			if(strlen($username) < 3) {
			
				return "username_short";
				exit;
			}

			if(strlen($password) < 5) {
			
				return "password_short";
				exit;
			}
			
			//Create new User
			$query = "INSERT INTO user (username, create_date, ip) VALUES(:username, :create_date, :ip)";
			$sth = $db->prepare($query);
			$sth->bindParam(":username", $username, PDO::PARAM_STR);
			$sth->bindParam(":create_date", $date, PDO::PARAM_STR);
			$sth->bindParam(":ip", $IP, PDO::PARAM_STR);
			$sth->execute();
			
			//Get Userid
			$sth = $db->prepare("SELECT id FROM user WHERE username = :username");
			$sth->bindParam(":username", $username, PDO::PARAM_STR);
			$sth->execute();
						
			$row = $sth->fetch(PDO::FETCH_OBJ);
			
			$myuserid = $row->id;
			
			if($myuserid != NULL) {
				
				//Create new email
				$query = "INSERT INTO user_email (userid, email, create_date) VALUES(:myuserid, :email, :create_date)";
				$sth = $db->prepare($query);
				$sth->bindParam(":myuserid", $myuserid, PDO::PARAM_INT);
				$sth->bindParam(":email", $email, PDO::PARAM_STR);
				$sth->bindParam(":create_date", $date, PDO::PARAM_STR);
				$sth->execute();

				//Create new password
				$query = "INSERT INTO user_pass (userid, pass, create_date) VALUES(:myuserid, :pass, :create_date)";
				$sth = $db->prepare($query);
				$sth->bindParam(":myuserid", $myuserid, PDO::PARAM_INT);
				$sth->bindParam(":pass", $hash_password, PDO::PARAM_STR);
				$sth->bindParam(":create_date", $date, PDO::PARAM_STR);
				$sth->execute();

				//Create login entry
				$query = "INSERT INTO login_log (userid, date, ip, successfully) VALUES(:userid, :date, :ip, 1)";
				$sth = $db->prepare($query);
				$sth->bindParam(":userid", $myuserid, PDO::PARAM_INT);
				$sth->bindParam(":date", $date, PDO::PARAM_STR);
				$sth->bindParam(":ip", $IP, PDO::PARAM_STR);
				$sth->execute();

				//Create user session
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
?>