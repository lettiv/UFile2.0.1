<?php
header('Access-Control-Allow-Origin: *');
ini_set('safe_mode', '1');
ini_set('display_errors', 0);
error_reporting(0);
session_start();

$myuserid = htmlspecialchars($_SESSION["myuserid"]);

if($myuserid == NULL) {
	echo 'Please login!';
	exit;
}


//Creaty Entry START
$language = htmlspecialchars($_POST['language']);
$name = htmlspecialchars($_POST['name']);
$action = htmlspecialchars($_POST['action']);

if(($language != NULL) AND ($name != NULL) AND ($action == 'create')) {

	//Import SQL
	require $_SERVER['DOCUMENT_ROOT']."/sql/sql.php";

	//Check if this content_name already exists
	$sth = $db->prepare("SELECT name FROM content WHERE name = :name");
	$sth->bindParam(":name", $name, PDO::PARAM_STR);
	$sth->execute();
	
	$row = $sth->fetch(PDO::FETCH_OBJ);
		
	if($row->name == NULL) {

		$query = "INSERT INTO content (userid, name, lang) VALUES(:myuserid, :name, :lang)";
		$sth = $db->prepare($query);
		$sth->bindParam(":myuserid", $myuserid, PDO::PARAM_INT);
		$sth->bindParam(":name", $name, PDO::PARAM_STR);
		$sth->bindParam(":lang", $language, PDO::PARAM_STR);
		$sth->execute();
		
	}
	else
	{
	
		echo "This Name does already exists!";
		
	}
	
	echo 'success';
	exit;
}
//Create Entry END

//Delete All with this name (content_name) START
$language_name = htmlspecialchars($_POST['language_name']);
$delete_check = htmlspecialchars($_POST['delete_check']);

if(($language_name != NULL) AND ($delete_check == 1)) {

	//Import SQL
	require $_SERVER['DOCUMENT_ROOT']."/sql/sql.php";

	//Check if content with this name exists
	$sth = $db->prepare("SELECT name FROM content WHERE name = :language_name");
	$sth->bindParam(":language_name", $language_name, PDO::PARAM_STR);
	$sth->execute();
	
	$row = $sth->fetch(PDO::FETCH_OBJ);
	
	
	if($row->name != NULL) {

		$query = "UPDATE content SET deleted = 1 WHERE name = :language_name;";
		$sth = $db->prepare($query);
		$sth->bindParam(":language_name", $language_name, PDO::PARAM_STR);
		$sth->execute();
	
	}
	
	echo 'success';
	exit;
}
//Delete All with this name (content_name) END

//Delete translating stuff START
$id = htmlspecialchars($_POST['id']);
$delete_language = htmlspecialchars($_POST['delete_language']);

if(($id != NULL) AND ($delete_language == 1)) {

	//Import SQL
	require $_SERVER['DOCUMENT_ROOT']."/sql/sql.php";

	//Check if content with this id exists
	$sth = $db->prepare("SELECT id FROM content WHERE id = :id");
	$sth->bindParam(":id", $id, PDO::PARAM_INT);
	$sth->execute();
	
	$row = $sth->fetch(PDO::FETCH_OBJ);
	
	if($row->id != NULL) {

		$query = "UPDATE content SET deleted = 1 WHERE id = :id;";
		$sth = $db->prepare($query);
		$sth->bindParam(":id", $id, PDO::PARAM_INT);
		$sth->execute();
	
	}
	
	echo 'success';
	exit;
}
//Delete translating stuff END

//Save translating stuff START
$textarea_content = htmlspecialchars($_POST['textarea_content']);
$content_name = htmlspecialchars($_POST['content_name']);
$to_lang = htmlspecialchars($_POST['to_lang']);


if(($textarea_content != NULL) AND ($content_name != NULL) AND ($to_lang != NULL)) {
	
	//Import SQL
	require $_SERVER['DOCUMENT_ROOT']."/sql/sql.php";

	//Check if content with this content_name exists
	$sth = $db->prepare("SELECT name FROM content WHERE name = :content_name AND lang = :lang AND deleted = 0");
	$sth->bindParam(":content_name", $content_name, PDO::PARAM_STR);
	$sth->bindParam(":lang", $to_lang, PDO::PARAM_STR);
	$sth->execute();
	
	$row = $sth->fetch(PDO::FETCH_OBJ);
	
	$content_name_check = $row->name;
	
	if($content_name_check != NULL) {
		
		$query = "UPDATE content SET userid = :userid, content = :content WHERE name = :content_name AND lang = :lang AND deleted = 0;";
		$sth = $db->prepare($query);
		$sth->bindParam(":userid", $myuserid, PDO::PARAM_INT);
		$sth->bindParam(":content", $textarea_content, PDO::PARAM_STR);
		$sth->bindParam(":content_name", $content_name, PDO::PARAM_STR);
		$sth->bindParam(":lang", $to_lang, PDO::PARAM_STR);
		$sth->execute();
		
		echo 'success';
	}
	else
	{
	
		$query = "INSERT INTO content (userid, content, name, lang) VALUES(:myuserid, :content, :name, :lang)";
		$sth = $db->prepare($query);
		$sth->bindParam(":myuserid", $myuserid, PDO::PARAM_INT);
		$sth->bindParam(":content", $textarea_content, PDO::PARAM_STR);
		$sth->bindParam(":name", $content_name, PDO::PARAM_STR);
		$sth->bindParam(":lang", $to_lang, PDO::PARAM_STR);
		$sth->execute();
		
		echo 'success';
	}


	
	exit;	
}
//Save translating stuff END
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Table V02</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
<?php
$from_language = htmlspecialchars($_POST['from_language']);
$to_language = htmlspecialchars($_POST['to_language']);

if(($from_language != NULL) AND ($to_language != NULL)) {
	
	$url = "http://".$_SERVER['HTTP_HOST']."/translate/?from=".$from_language."&to=".$to_language;
	
	echo '<meta http-equiv="refresh" content="0; URL='.$url.'">';
}

$from_language = htmlspecialchars($_GET['from']);
$to_language = htmlspecialchars($_GET['to_']);
?>
	
	
	<div class="limiter">
		<div class="container-table100">
			<div class="wrap-table100">
					<div class="table">

						<form action="" method="post">
						Translate from:<br>
						<select name="from_language">
							<option value="" selected>Select Language</option>
							<option value="de">German</option>
							<option value="en">English</option>
						</select>
						<br>
						to:<br>
						<select name="to_language">
							<option value="" selected>Select Language</option>
							<option value="de">German</option>
							<option value="en">English</option>
						</select>
							<input type="submit" style="padding:5px;border-radius:3px;" value="Submit" />
						</form>

						<br><br>
						
						<input hidden type="text" id="create_entry_language" value="<?php echo $from_language; ?>">
						<input type="text" id="create_entry_name" placeholder="Name for Var">
						<input type="submit" class="create_entry" style="padding:5px;border-radius:3px;" value="Create Entry" onclick="create_entry()">

						<br><br>

						<div class="row header">
							<div class="cell">
								Name
							</div>
							<div class="cell">
								Language
							</div>
							<div class="cell">
								Original
							</div>
							<div class="cell">
								Translated to
							</div>
							<div class="cell">
								
							</div>
						</div>
<?php
	//Import SQL
	require $_SERVER['DOCUMENT_ROOT']."/sql/sql.php";
	
		
		$from_language = htmlspecialchars($_GET['from']);
		$to_language = htmlspecialchars($_GET['to']);
		
		//Select content by language (From)
		$sth = $db->prepare("SELECT id, content, name FROM content WHERE lang = :lang AND deleted = 0 ORDER BY content");
		$sth->bindParam(":lang", $from_language, PDO::PARAM_STR);
		$sth->execute();

		while($row = $sth->fetch(PDO::FETCH_OBJ)) {
		
			$from_id = $row->id;
			$from_content = $row->content;
			$language_name = $row->name;
			
			//Select content by language and name (To)
			$stha = $db->prepare("SELECT id, content FROM content WHERE name = :name AND lang = :lang AND deleted = 0");
			$stha->bindParam(":name", $language_name, PDO::PARAM_STR);
			$stha->bindParam(":lang", $to_language, PDO::PARAM_STR);
			$stha->execute();
			
			$rowa = $stha->fetch(PDO::FETCH_OBJ);
			
			$to_id = $rowa->id;
			$to_content = $rowa->content;
			
			if($from_content != NULL) {

				$from_content = nl2br($from_content);
			
			}
			
			if($to_content != NULL) {

				$to_content = nl2br($to_content);
			
			}
			
			if($from_id != NULL) {
?>

				<div id="row_id_<?php echo $to_id; ?>" class="row row_content_<?php echo $language_name; ?>">
					<div class="cell">
						<?php echo $language_name; ?>
					</div>
					<div class="cell">
						<?php echo '<span style="text-transform: uppercase;"><b>'.$from_language.'</b></span> to <span style="text-transform: uppercase;"><b>'.$to_language.'</b></span>'; ?>
					</div>
					<div class="cell">
						<?php echo $from_content; ?>
					</div>
					<div class="cell" style="padding:10px;">
						<textarea id="textarea_<?php echo $language_name; ?>"><?php echo $to_content; ?></textarea>
					</div>
					<div class="cell">
						<input hidden type="input" id="content_name_<?php echo $language_name; ?>" value="<?php echo $language_name; ?>">
						<input hidden type="input" id="to_language" value="<?php echo $to_language; ?>">
						<input type="submit" class="save_button" style="padding:5px;border-radius:3px;" name="save" value="Save" onclick="save_language_content('<?php echo $language_name; ?>')">
						<br>
						<input type="submit" class="delete_button" style="padding:5px;border-radius:3px;" name="delete" value="Delete" onclick="delete_language_content(<?php echo $to_id; ?>)">
						<br>
						<input type="submit" class="delete_button_all" style="padding:5px;border-radius:3px;" name="delete" value="Delete All" onclick="delete_language_content_all('<?php echo $language_name; ?>')">
					</div>
				</div>
<?php
			}
			
			$language_name = NULL;
			$from_content = NULL;
			$to_content = NULL;

		}
?>
<script>
//Save translating stuff START
function save_language_content(language_name) {

	var textarea_content = document.getElementById("textarea_"+language_name).value;
	var content_name = document.getElementById("content_name_"+language_name).value;
	var to_language = document.getElementById("to_language").value;

	
	if((textarea_content == null) || (to_language == null) || (content_name == null)) {
		
		alert('Error!');
		alert('Content:' + textarea_content);
		alert('Content Name:' + content_name);
		
	}
	else
	{
		$( ".save_button" ).hide();
		
		$.ajax(
			{
			url: '<?php echo $url; ?>',
			type: 'post',
			dataType:'text',
			data: {textarea_content: textarea_content, content_name: content_name, to_lang: to_language},
			success: function(result){
				
				console.log(result);
				
				if(result == "success") {
					
					alert('Success!');

				}else if(result == 'null'){

					alert('Error!');
					
				}
			}
		})
		
		$(".save_button").show();
	}
}
//Save translating stuff END

//Delete translating stuff START
function delete_language_content(id) {
	
	$(".delete_button").hide();
	
	$.ajax(
		{
		url: '<?php echo $url; ?>',
		type: 'post',
		dataType:'text',
		data: {id: id, delete_language: 1},
		success: function(result){
			
			console.log(result);

			if(result == "success") {
				
				$("#row_id_"+id).hide(); //Hide Row because its deleted and we dont refreshed this page

			}else if(result == 'null'){

				alert('Error!');

			}
		}
	})
	
	$(".delete_button").show();
	
}
//Delete translating stuff END

//Delete All with this name (content_name) START
function delete_language_content_all(language_name) {
	
	$(".delete_button_all").hide();
	
	$.ajax(
		{
		url: '<?php echo $url; ?>',
		type: 'post',
		dataType:'text',
		data: {language_name: language_name, delete_check: 1},
		success: function(result){
			
			console.log(result);

			if(result == "success") {
				
				$(".row_content_"+language_name).hide(); //Hide Row because its deleted and we dont refreshed this page

			}else if(result == 'null'){

				alert('Error!');

			}
		}
	})
	
	$(".delete_button_all").show();
	
}
//Delete All with this name (content_name) END

//Create Entry START
function create_entry() {
	
	$(".create_entry").hide();
	
	var name = document.getElementById("create_entry_name").value;
	var language = document.getElementById("create_entry_language").value;
	
	$.ajax(
		{
		url: '<?php echo $url; ?>',
		type: 'post',
		dataType:'text',
		data: {language: language, name: name, action: 'create'},
		success: function(result){
			
			console.log(result);

			if(result == "success") {
				
				alert('Refresh this Page (F5)');

			}else if(result == 'null'){

				alert('Error!');

			}
		}
	})
	
	$(".create_entry").show();
	
}
//Create Entry END
</script>
		
					</div>
			</div>
		</div>
	</div>


	

<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>