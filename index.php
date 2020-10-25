<?php
/* ini_set('safe_mode', '1');
ini_set('display_errors', 0);
error_reporting(0); */
session_start();
$url = "http://".$_SERVER['HTTP_HOST'];


include $_SERVER['DOCUMENT_ROOT']."/sql/sql.php";

$my_hash = $_COOKIE["session"];

if($my_hash != NULL) {

	
	//Check Session
	include $_SERVER['DOCUMENT_ROOT']."/php/function/user/check_session.php";

	$session_status = check_session('false');
	$session_status = $session_status['session_status'];

}


	$myuserid = htmlspecialchars($_SESSION["myuserid"]);
	
	if(($myuserid == NULL) AND ($session_status == 'true')) {
	
		echo '<meta http-equiv="refresh" content="0; URL=https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'].'">';
		exit;
		
	}

	
$client_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

require $_SERVER['DOCUMENT_ROOT']."/php/function/system/select_content.php";

$subdomain_lang = substr_count($_SERVER['HTTP_HOST'], '.') > 1 ? substr($_SERVER['HTTP_HOST'], 0, strpos($_SERVER['HTTP_HOST'], '.')) : '';
  

/*
//Goto Language Domain (subdomain)
if($subdomain_lang == NULL) {

	if($client_lang == 'de') {
		$lang_url = 'de.'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		echo '<meta http-equiv="refresh" content="0; URL=https://'.$lang_url.'">';
	}
	else
	{
		$lang_url = 'en.'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		echo '<meta http-equiv="refresh" content="0; URL=https://'.$lang_url.'">';
	}
	exit;
}
*/


if($subdomain_lang == 'de') {

	$cookie_name = "language";
	$cookie_value = 'de';
	setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day * 30 days	

	$client_lang = $subdomain_lang;
}

if($subdomain_lang == 'en') {

	$cookie_name = "language";
	$cookie_value = 'en';
	setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day * 30 days	
		
	$client_lang = $subdomain_lang;
}

?>
<!DOCTYPE html>
<html lang="<?php echo $client_lang; ?>">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, user-scalable=no" name="viewport">

	<!--CSS-->
	<link rel="stylesheet" href="<?php echo $url; ?>/css/style.css">
	
	<!--Jquery-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	
	<!--Fonts-->
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">  
	<script src="https://kit.fontawesome.com/0190bf401f.js" crossorigin="anonymous"></script>
	
	<!--Bootstrap-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>
<body>
    <div id="app" class="transparent_bg">


<?php
		//Page System
		
		//Get Navigation
		//Check if user is logged in
		if($myuserid != NULL) {
			require_once "inc/navigation/navigation_logged_in.php";	
		}


		//Check which page is requested
		$request_page = htmlspecialchars($_GET['page']);
		$security_check = 1;

		if($request_page == 'privacy') {
			
			require $_SERVER['DOCUMENT_ROOT']."/pages/privacy.php";
			$require_check = 1;
		}
		elseif($request_page == 'dashboard') {
			
			//Check if user is logged in
			if($myuserid != NULL) {
			
				require $_SERVER['DOCUMENT_ROOT']."/pages/dashboard.php";
				$require_check = 1;
			}
			else
			{
				$request_page = NULL; //Goto Main Page (INDEX)
			}
		}elseif($request_page == 'old_login') {
			
			//Check if user is logged in
			if($myuserid == NULL) {
			
				require $_SERVER['DOCUMENT_ROOT']."/pages/old_login.php";
				$require_check = 1;
			}
			else
			{
				$request_page = NULL; //Goto Main Page (INDEX)
			}
		}
		
	
		if($request_page == NULL) {
				
			$security_check = 1;
			require "pages/index.php";
			$require_check = 1;

		}

		//if no page found to require send 404 not found
		if($require_check == NULL) {
				
			require "404.php";

		}

		
?>
    </div>
</body>
</html>
