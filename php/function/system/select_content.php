<?php
header('Access-Control-Allow-Origin: *');
ini_set('safe_mode', '1');
ini_set('display_errors', 0);
error_reporting(0);
session_start();


function get_content($name, $lang) {
	
	
	$name = htmlspecialchars($name);
	$lang = htmlspecialchars($lang);
	
	if(($name != NULL) AND ($lang != NULL)) {
	
		$date = date('Y-m-d H:i:s');
		
		//Import SQL
		require $_SERVER['DOCUMENT_ROOT']."/sql/sql.php";
		
		if($lang == 'de') {
		
			$lang = 'de';
			
		}
		else
		{

			$lang = 'en';
		
		}
		
		//Select content by language
		$sth = $db->prepare("SELECT content FROM content WHERE name = :name AND lang = :lang AND deleted = 0");
		$sth->bindParam(":name", $name, PDO::PARAM_STR);
		$sth->bindParam(":lang", $lang, PDO::PARAM_STR);
		$sth->execute();

		$row = $sth->fetch(PDO::FETCH_OBJ);
		
		if($row->content == NULL) {
			
			//Select content by default
			$sth = $db->prepare("SELECT content FROM content WHERE name = :name AND lang = '' AND deleted = 0");
			$sth->bindParam(":name", $name, PDO::PARAM_STR);
			$sth->execute();

			$row = $sth->fetch(PDO::FETCH_OBJ);
			
		}
		
		
		
		if($row->content != NULL) {

			$content = nl2br($row->content);
			
			//$content = utf8_encode($content);//PDO actually sql.php
		}
		else
		{
		
			$content = 'N/A';
		
		}
		
		
		return $content;
		
	}

}