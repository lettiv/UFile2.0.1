<?php

	//Import SQL
	require  $_SERVER['DOCUMENT_ROOT']."/sql/sql.php";

//Select all Posts

		$sth = $db->prepare("SELECT id, userid, create_date FROM post WHERE deleted = 0 ORDER BY id DESC");
		$sth->execute();

		while($row = $sth->fetch(PDO::FETCH_OBJ)) {

			$post_id = $row->id;
			$post_userid = $row->userid;
			$post_date = $row->create_date;

		
		
			//Check Text/Content for Post
			$stha = $db->prepare("SELECT text, create_date FROM post_text WHERE post_id = :post_id AND deleted = 0");
			$stha->bindParam(":post_id", $post_id, PDO::PARAM_STR);
			$stha->execute();
			
			$rowa = $stha->fetch(PDO::FETCH_OBJ);
			
			$post_text = $rowa->text;
			



			//$PostArray = array('post_id' => $post_id, 'post_userid' => $post_userid, 'post_date' => $post_date, 'post_text' => $post_text);
			$PostArray = array($post_id, $post_userid, $post_date, $post_text);
			
			$array = array($PostArray);
			
			$post_id = NULL;
			$post_userid = NULL;
			$post_date = NULL;
			$post_text = NULL;
		}


		var_dump($array);
		
		
/* 		for($i = 0;$i < count($PostArray);$i ++) {
		 
			echo 'Post ID'. $PostArray['post_id'].'<br>';
			echo 'post userid'. $PostArray['post_userid'].'<br>';
			echo 'Post Date'. $PostArray['post_date'].'<br>';
			echo 'Post Text'. $PostArray['post_text'].'<br><br><br>';
			
		} */
		
		
		
?>