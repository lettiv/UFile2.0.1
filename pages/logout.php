<?php
session_start();


//Destroy Cookie

if (isset($_COOKIE['session'])) {
    unset($_COOKIE['session']);
    setcookie('session', '', time() - 3600, '/'); // empty value and old timestamp
}

//Destroy Session
if(isset($_SESSION['myuserid']))
{
   unset($_SESSION['myuserid']);
}


$url = "http://".$_SERVER['HTTP_HOST']."/";

?>
<meta http-equiv="refresh" content="0; URL=<?php echo $url; ?>">