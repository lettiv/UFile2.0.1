<?php
header('Access-Control-Allow-Origin: *');

session_start();

$postId = htmlspecialchars($_GET['get']);
$postUserId = htmlspecialchars($_GET['get']);



function SelectPost($postId, $postUserId) {

	//Import SQL
	require  $_SERVER['DOCUMENT_ROOT']."/sql/sql.php";
	
	
	if(($postId == NULL) AND ($postUserId == NULL)){

		//Select all Posts

		$sth = $db->prepare("SELECT id, userid, create_date FROM post WHERE deleted = 0 ORDER BY id DESC");
		$sth->execute();

		$row = $sth->fetch(PDO::FETCH_OBJ);

		$post_id = $row->id;
		$post_userid = $row->userid;
		$post_date = $row->create_date;
	
	
		//Check Text/Content for Post
		$sth = $db->prepare("SELECT text, create_date FROM post_text WHERE post_id = :post_id AND deleted = 0");
		$sth->bindParam(":post_id", $post_id, PDO::PARAM_STR);
		$sth->execute();
		
		$row = $sth->fetch(PDO::FETCH_OBJ);
		
		$post_text = $row->text


		//Check Images for Post
/* 		$sth = $db->prepare("SELECT img, create_date FROM post_image WHERE post_id = :post_id AND deleted = 0");
		$sth->bindParam(":post_id", $post_id, PDO::PARAM_STR);
		$sth->execute();
		
		$row = $sth->fetch(PDO::FETCH_OBJ);
		
		$post_img = $row->img */
	
	
	}
		



			
			if($checked_userid != NULL) {
			
				$query = "UPDATE user_session SET date = :date WHERE session_hash = :session_hash ORDER BY id DESC;";
				$sth = $db->prepare($query);
				$sth->bindParam(":date", $date, PDO::PARAM_STR);
				$sth->bindParam(":session_hash", $checked_hash, PDO::PARAM_STR);
				$sth->execute();

				$session_status = 'true';
			
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