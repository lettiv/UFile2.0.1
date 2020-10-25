<?php
if($security_check != 1) {
	//header('Location: https://react2gether.com');
}
else
{
	//Check Room URL
	require $_SERVER['DOCUMENT_ROOT']."/php/function/room/check_room_url.php";

	$get_url = get_room_url($room_hash, $room_id);
	
	$check_url = $url.''.$get_url;
	
	$actual_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	if($actual_url != $check_url) {
	
	
		if($get_url != NULL) {
			
			echo '<meta http-equiv="refresh" content="0; URL='.$url.''.$get_url.'">';
			exit;
			
		}
		else
		{
			echo '<meta http-equiv="refresh" content="0; URL='.$url.'">';
			exit;
		}
	}

	//Check Room Locked
	require $_SERVER['DOCUMENT_ROOT']."/php/function/room/check_room_locked.php";
	$check_permissions = get_room_locked($room_id, $get);

	//Check User Premium
	require $_SERVER['DOCUMENT_ROOT']."/php/function/user/check_premium.php";
	$check_premium = check_premium($myuserid, $get);



	if($check_permissions == 0) {
		
		echo "<script>alert('The Room is locked!');</script>";
		echo '<meta http-equiv="refresh" content="0; URL='.$url.'">';
		exit;
		
	}
	
	$sth = $db->prepare("SELECT seconds FROM room_sync WHERE room_id = :room_id AND host = 1");
	$sth->bindParam(":room_id", $room_id, PDO::PARAM_INT);
	$sth->execute();

	$row = $sth->fetch(PDO::FETCH_OBJ);
	
	$seconds = $row->seconds;
?>





	<!--Room Stuff-->
	
		<!--Infobox -->
		<div id="invitebox" class="invitebox" hidden>
			<div class="invitebox_close" onclick="$('.invitebox').hide();"></div>
			
			<h2><?php echo get_content('invite_box_title', $client_lang); ?></h2>
		
			<input type="text" id="invite_link" class="invite_link" value="<?php echo $actual_url; ?>" onclick="$( '#invite_link' ).select();">
		</div>
		
		<div id="infobox_help" class="infobox" hidden>
			<div class="infobox_close" onclick="close_infobox('help')"></div>
			
			<h1><?php echo get_content('infobox_title', $client_lang); ?></h1>
			<h2>Help:</h2>
			Um den Player mit der Leertaste steuern zu können, muss die Maus zuvor auf den Pause/Play Button geklickt haben
			<div class="info_wrapper" style="float: left;width: 100%;">
				<p class="infobox_text_title"><?php echo get_content('command_host', $client_lang); ?></p>
				<p class="infobox_text"><?php echo get_content('command_host_description', $client_lang); ?></p>
			</div>
			
			<div class="info_wrapper" style="float: left;width: 100%;">
				<p class="infobox_text_title"><?php echo get_content('command_ban', $client_lang); ?></p>
				<p class="infobox_text"><?php echo get_content('command_ban_description', $client_lang); ?></p>
			</div>
		</div>

		<div id="infobox_commands" class="infobox" hidden>
			<div class="infobox_close" onclick="close_infobox('commands')"></div>
			
			<h1><?php echo get_content('infobox_title', $client_lang); ?></h1>
			<h2>Commands:</h2>
			<!--
			<div class="info_wrapper" style="float: left;width: 100%;">
				<p class="infobox_text_title"><?php echo get_content('command_host', $client_lang); ?></p>
				<p class="infobox_text"><?php echo get_content('command_host_description', $client_lang); ?></p>
			</div>
			-->
			<div class="info_wrapper" style="float: left;width: 100%;">
				<p class="infobox_text_title"><?php echo get_content('command_ban', $client_lang); ?></p>
				<p class="infobox_text"><?php echo get_content('command_ban_description', $client_lang); ?></p>
			</div>
				
			<div class="info_wrapper">
				<p class="infobox_text_title"><?php echo get_content('command_unban', $client_lang); ?></p>
				<p class="infobox_text"><?php echo get_content('command_unban_description', $client_lang); ?></p>
			</div>
			
			<div class="info_wrapper">
				<p class="infobox_text_title"><?php echo get_content('command_mod', $client_lang); ?></p>
				<p class="infobox_text"><?php echo get_content('command_mod_description', $client_lang); ?></p>
			</div>

			<div class="info_wrapper">
				<p class="infobox_text_title"><?php echo get_content('command_unmod', $client_lang); ?></p>
				<p class="infobox_text"><?php echo get_content('command_unmod_description', $client_lang); ?></p>
			</div>
		</div>

		<!-- Infobox End -->

		<!-- Room Settings -->
		<div id="room_settings" class="infobox" hidden>
			<div class="infobox_close" onclick="$('#room_settings').hide();"></div>
			
			<h1><?php echo get_content('room_settings_title', $client_lang); ?></h1>
			<!--<h2>Room:</h2>-->
			<hr>
			<div class="info_wrapper" style="float: left;width: 100%;">
				<p class="infobox_text_title"><?php echo get_content('room_name_change', $client_lang); ?></p>
				<p class="infobox_text" style="width:100%;"><input type="text" value="" placeholder="DerLippo's Raum" style="width:100%;"></p>
			</div>

			<div class="info_wrapper" style="float: left;width: 100%;">
				<p class="infobox_text_title"><?php echo get_content('room_url_change', $client_lang); ?></p>
				<p class="infobox_text" style="width:100%;"><input type="text" value="" placeholder="https://de.react2gether.com/room/DerLippo/192" style="width:100%;"></p>
			</div>
		</div>
		<!-- Room Settings END -->
	
	
	
	<div id="room_head">
		<a href="<?php echo $url; ?>">
			<img class="small_logo" src="<?php echo $url; ?>images/logo/mediumsmall.png" alt="React2Gether">
		</a>

		<audio id="badConnectionAudio" hidden>
		  <source src="<?php echo $url; ?>/js/sound/BadConnection.mp3" type="audio/mpeg">
		  Your browser does not support the audio element.
		</audio>

		<audio id="SelectMessageAudio" hidden>
		  <source src="<?php echo $url; ?>/js/sound/SelectMessageAudio.mp3" type="audio/mpeg">
		  Your browser does not support the audio element.
		</audio>
	
		<input id="ytvideoinput" type="text" placeholder="Example: https://www.youtube.com/watch?v=McRNSFGwqtY" style="display:none;">
			</div>
	
	<div id="room_body">
		<div id="player_background" class="transparent_bg">
			<div id="player" onmouseover="focusPlayer(1);" onclick="focusPlayer(1);">
				<center>
				
<style>
.slider {
  -webkit-appearance: none;
  width: 100%;
  height: 0px;
  border-radius: 5px;
  background: #d3d3d3;
  outline: none;
  opacity: 0.7;
  -webkit-transition: .2s;
  transition: opacity .2s;
}

.slider:hover {
  opacity: 1;
}

.slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 15px;
  height: 15px;
  border-radius: 50%;
  background: #4CAF50;
  cursor: pointer;
}

.slider::-moz-range-thumb {
  width: 15px;
  height: 15px;
  border-radius: 50%;
  background: #4CAF50;
  cursor: pointer;
}

.volume_slider {
float: left;
position: relative;
max-width: 70px;
height: 5px;
bottom: 34px;
}

#myRange {
cursor:pointer;
position: relative;
bottom: 45px;
height: 8px;
float: left;	
}
</style>	
				
				
					<div id="video-container" class="video-container">
						<div id="ytplayer"></div>
					</div>
					<div id="player_buttons_wrapper" style="background:transparent !important;">
						  <input type="range" min="0" max="<?php echo $seconds; ?>" step="1" value="0.01" class="slider video_slider video_control" id="myRange">

							<div class="player_button video_control" style="float: left;z-index: 100;background: transparent !important;width: 0.5vw;height: 35px;"></div>
							
							<i class="fas fa-play video_play_button player_button video_control" onclick="updateVideoState(1);"></i>
							<i class="fas fa-pause video_pause_button player_button video_control" style="display:none;" onclick="updateVideoState(2);"></i> 
							
							<input type="range" min="0" max="100" step="1" value="100" class="slider volume_slider video_control" id="myVolume">
							
							<span class="player_button player_seconds video_control"><span class="player_current_seconds"></span> / <span class="player_max_seconds"></span></span>
							
							<!--
							<div class="player_button player_state_log" style="width:50%;margin-left:20%;font-size:18px;height:24px;opcaity:0;background:transparent !important;" onclick="$('#player_state_log').fadeTo('slow', 0);"></div>
							-->
							
							<div class="player_button video_control" style="float: right;z-index: 100;background: transparent !important;width: 0.1vw;height: 35px;" onclick="openFullscreen()"></div>
							<i class="fas fa-compress-arrows-alt video_nofullscreen_button player_button video_control" onclick="closeFullscreen()" style="float: right; z-index: 1000; display: none;" aria-hidden="true"></i>
							<i class="fas fa-compress video_fullscreen_button player_button video_control" onclick="openFullscreen()" style="float: right; z-index: 1000; display: none;" aria-hidden="true"></i>

							<div class="player_settings-dropdown" style="display:none !important;">
								<button class="player_button player_settings-dropbtn video_control">
									<i class="fas fa-cog"></i>
								</button>
								<div class="player_settings-dropdown-content video_control">
									<a href="#" onclick="setPlaybackRate(0.25);">0.25</a>
									<a href="#" onclick="setPlaybackRate(0.5);">0.5</a>
									<a href="#" onclick="setPlaybackRate(0.75);">0.75</a>
									<a href="#" onclick="setPlaybackRate(1);">1</a>
									<a href="#" onclick="setPlaybackRate(1.25);">1.25</a>
									<a href="#" onclick="setPlaybackRate(1.5);">1.5</a>
									<a href="#" onclick="setPlaybackRate(1.75);">1.75</a>
									<a href="#" onclick="setPlaybackRate(2);">2</a>
								</div>
							</div>


						<script>
						var slider = document.getElementById("myRange");

						slider.oninput = function() {
							var player_seconds = this.value;
							
							if(player_seconds != null) {
								player.seekTo(player_seconds, true);
							}
						}
						//////////////////////////////////////////////////////
						var slider = document.getElementById("myVolume");

						slider.oninput = function() {
							var player_volume = this.value;
							
							if(player_volume != null) {
								player.setVolume(player_volume);
							}
						}
						</script>
					</div>
				</center>
				<span id="player_seconds_counter" hidden></span>
				<span id="player_async_counter" hidden>0</span>
				<span id="player_refresh_counter" hidden>0</span>
			</div>
			
			<div id="control_buttons" class="transparent_bg">
				<div id="room_smartphone_info" class="system_message yellow_message" hidden>We do not yet fully support smartphones!</div>
				<div id="ping">Loading...</div>
				<div id="control_buttons_one" class="transparent_bg">
					<div class="control_button_wrapper transparent_bg" style="float:left;">
						<form action="<?php echo $url; ?>" method="get">
							<button><i class="fas fa-arrow-alt-circle-left"></i> <?php echo get_content('to_lobby_button', $client_lang); ?></button>
						</form>
					</div>
					<div class="control_button_wrapper transparent_bg">
						<button title="Sync" id="sync_button" class="transparent_bg" onclick="checkPlayerSync('ManuallySyncA');">
						<?php
								if($check_premium['active'] == 1) {
						?>
							<i class="fas fa-cogs" onclick="$('#room_settings').show();" aria-hidden="true" style="font-size: 26px;color: gray;"></i>
						<?php
								}
						?>
						</button>
									
					</div>
					<div class="control_button_wrapper transparent_bg" style="float:right;">
						<button id="room_locked" class="red_button" onclick="lock_unlock_room(0)" style="display:none;"><b><?php echo get_content('room_locked_button', $client_lang); ?> </b> <i class="fas fa-lock" style="margin-left:2px;"></i></button>
						<button id="room_unlocked" class="green_button" onclick="lock_unlock_room(1)"><?php echo get_content('room_locked_button', $client_lang); ?> </b> <i class="fas fa-lock-open" style="margin-left:2px;"></i></button>
					</div>
				</div>
				 
				
				<div id="control_buttons_two" class="transparent_bg">


					<!--
					<div class="control_button_wrapper transparent_bg">
						<form action="<?php echo $url; ?>logout" method="get">
							<button><?php echo get_content('logout_button', $client_lang); ?></button>
						</form>
					</div>
					-->
				</div>
				
				<div id="control_buttons_three" class="transparent_bg">
					<div class="control_button_wrapper transparent_bg" style="float:right;">
						<button class="green_button" onclick="$('.invitebox').show();"><?php echo get_content('invite_button', $client_lang); ?></button>
					</div>
				</div>
			</div>
			
			<div class="transparent_bg" style="float: left;margin-top: 1vh;width: 100%;min-height:10px;"></div>
		</div>
		
		
		<div id="room_content_wrapper" class="transparent_bg" onmouseover="focusPlayer(0);" onclick="focusPlayer(0);">
			
			<div id="playlist" class="transparent_bg">
			
					<div id="playlist_input_wrapper" class="transparent_bg">
						<input id="playlist_input" type="text" placeholder="<?php echo get_content('playlist_input_placeholder', $client_lang); ?>">
					</div>
					
					<div id="playlist_content">
						
					</div>
					
					<ul id="user_list" class="transparent_bg">
					
						
					
					</ul>
			
			</div>
			
			<div id="chat" class="transparent_bg">
			
				<div id="chat_content"></div>
				
				<div id="chat_input_wrapper" class="transparent_bg">
					<input id="chat_input" type="text" placeholder="<?php echo get_content('input_chat_placeholder', $client_lang); ?>">
				</div>
				
			
			</div>

		</div>
	</div>

	<div id="js"></div>
	<!-- Javascript Stuff -->

	<?php require $_SERVER['DOCUMENT_ROOT']."/js/youtube_insert_video_js.php"; ?>
	<?php require $_SERVER['DOCUMENT_ROOT']."/js/youtube_insert_playlist_video_js.php"; ?>
	<?php require $_SERVER['DOCUMENT_ROOT']."/js/room_chat_js.php"; ?>
	<?php require $_SERVER['DOCUMENT_ROOT']."/js/room_js.php"; ?>
	<?php require $_SERVER['DOCUMENT_ROOT']."/js/youtube_player_js.php"; ?>



<script>
	/* START JS SCRIPTS */
	Check_my_ping_Select_room_users();
	
	
	function check_room_lock(){

		lock_unlock_room();
		
		setTimeout(check_room_lock, 2500);
		
	}

		check_room_lock();

	function check_ban_unban_room(){

		ban_unban_room();
		
		setTimeout(check_ban_unban_room, 5000);
		
	}
	
		check_ban_unban_room();	
</script>
<?php
	function isMobileDevice() {
		return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
	}

	if(isMobileDevice()){

		echo '<script>
		$("#room_smartphone_info").fadeIn();
		$("#room_smartphone_info").html("We do not yet fully support smartphones.");
		</script>';

	}
	else {
		//echo "It is desktop or computer device";
	}


}
?>