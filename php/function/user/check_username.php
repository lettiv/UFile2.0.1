<?php
session_start();

function check_username($userid) {
	//Import SQL
	require  $_SERVER['DOCUMENT_ROOT']."/sql/sql.php";
	
	$sth = $db->prepare("SELECT username FROM user WHERE id = :userid");
	$sth->bindParam(":userid", $userid, PDO::PARAM_INT);
	$sth->execute();

	$row = $sth->fetch(PDO::FETCH_OBJ);
		
		
	if($row->username == NULL) {
	
		return 'N/A';
		
	}
	else
	{
		
		return $row->username;
		
	}

}