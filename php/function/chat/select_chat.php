<?php
header('Access-Control-Allow-Origin: *');
ini_set('safe_mode', '1');
ini_set('display_errors', 0);
error_reporting(0);
session_start();

$room_id = htmlspecialchars($_GET['room_id']);
$room_hash = htmlspecialchars($_GET['room_hash']);
$last_content_id = htmlspecialchars($_GET["last_content_id"]);

if(($room_id != NULL) AND ($room_hash != NULL)) {


	//Import SQL
	require $_SERVER['DOCUMENT_ROOT']."/sql/sql.php";
	
	require $_SERVER['DOCUMENT_ROOT']."/php/function/user/check_premium.php";
	
	//Check if room exists
	$sth = $db->prepare("SELECT id, owner FROM room WHERE id = :room_id AND roomkey = :room_hash");
	$sth->bindParam(":room_id", $room_id, PDO::PARAM_INT);
	$sth->bindParam(":room_hash", $room_hash, PDO::PARAM_STR);
	$sth->execute();

	$row = $sth->fetch(PDO::FETCH_OBJ);
	
	$room_check = $row->id;

	$room_owner = $row->owner;

	$myuserid = $_SESSION['myuserid'];

	//Check if user exists
	$sth = $db->prepare("SELECT id FROM user WHERE id = :myuserid AND banned = 0");
	$sth->bindParam(":myuserid", $myuserid, PDO::PARAM_INT);
	$sth->execute();

	$row = $sth->fetch(PDO::FETCH_OBJ);
	
	$user_check = $row->id;
	
	
	if(($room_check != NULL) AND ($user_check != NULL)) {
	
		//Get users in room
		$count = 0;
		
		if($last_content_id != NULL) {
		
			$sth = $db->prepare("SELECT id, userid, content, date FROM chat WHERE id > :last_content_id AND id != :last_content_id AND room_id = :room_id ORDER BY id");
			$sth->bindParam(":room_id", $room_id, PDO::PARAM_INT);
			$sth->bindParam(":last_content_id", $last_content_id, PDO::PARAM_INT);
		}
		else
		{
		
			$sth = $db->prepare("SELECT id, userid, content, date FROM chat WHERE room_id = :room_id ORDER BY id");
			
		}
		
		$sth->bindParam(":room_id", $room_id, PDO::PARAM_INT);
		$sth->execute();
						
						
						
		while($row = $sth->fetch(PDO::FETCH_OBJ)) {
			

			//Change Date
			$timestamp = strtotime($row->date);
			$date = date("d.m.Y H:i", $timestamp);
			$userid = $row->userid;


			$url = '@(http(s)?)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
			$message_content = preg_replace($url, '<a href="http$2://$4" target="_blank" title="$0">$0</a>', $row->content);
			
			$stha = $db->prepare("SELECT id, username FROM user WHERE id = :userid");
			$stha->bindParam(":userid", $userid, PDO::PARAM_INT);
			$stha->execute();

			$rowa = $stha->fetch(PDO::FETCH_OBJ);
			
			
			$username = $rowa->username;
			
			
			//Check Premium User
			$check_get = 'false';
			$informations = check_premium($userid, $check_get);

			$premium_active = $informations['active'];
			$premium_icon = $informations['icon'];
			
			if($premium_active == 1) {
				
				$premium_css_color = 'premium_color';
			
			}
			else
			{
			
				$premium_css_color = NULL;
				
			}
			
			
			//check any role and add icon / color
			if($userid == $room_owner) {
			
				$username = '<b title="Host" style="font-weight:normal !important;">👑</b><b class="'.$premium_css_color.'">'.$username.'</b>';
				
			}
			elseif($moderator == 1) {
			
			
				$username = '🎤<b class="'.$premium_css_color.'">'.$username.'</b>';
			
			
			}
			elseif($premium_active == 1) {
				
				$username = $premium_icon.'<b class="'.$premium_css_color.'">'.$username.'</b>';
				
			}
?>
			
			<div class="chat_message_container">
				<div hidden class="msgid" id="<?php echo $row->id; ?>"><?php echo $row->id; ?></div>
				<?php echo $username.' <small class="chat_message_date">'.$date.'</small><br><span class="chat_message">'.$message_content.'</span>'; ?>
			</div>
			
<?php
			$count++;
		}
		
		if($count == 0) {
			
			echo '<span><i>There is no message...</i></span>';
			
		}
		
	}
}