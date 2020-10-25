<?php
if($security_check != 1) {
	//header('Location: https://react2gether.com');
}
else
{
?>
		<?php require $_SERVER['DOCUMENT_ROOT']."/php/function/check_username.php"; ?>
		<a href="<?php echo $url; ?>">
			<img class="small_logo" src="<?php echo $url; ?>images/logo/mediumsmall.png" alt="React2Gether">
		</a>
		
			<div class="lobby_wrapper">
			<!--
				<div class="lobby_box" style="background:transparent !important;border: none;">
					<div style="float:left;width:100%;background:transparent;">
						
					</div>
				</div>
			-->
				<div class="lobby_box_wrapper">
					<div class="lobby_box" style="float:none;">
						<div id="default" style="float:left;width:100%;background:transparent;">
							<i class="fa fa-gear settings_icon" onclick="$('#defaultX').hide(); $('#settingsX').show();" style="color:transparent;"></i>
							<div style="position: inherit;float: left;width: 100%;text-align:center;background:transparent;">
								<h2 style="color:white;margin-top:5px;">Hi <?php echo check_username($myuserid); ?>!</h1>
								<br>
								<div class="lobby_box_button_wrapper">
										
									<div class="pulse_button_wrapper">
									  <input class="pulse_button green_button" onclick="window.location.href = '<?php echo $url; ?>/php/function/create_room.php'" value="<?php echo get_content('create_room_button', $client_lang); ?>">
									</div>
								
									<!--<input type="submit" value="<?php echo get_content('create_room_button', $client_lang); ?>" class="green_button" style="width: 100%;font-weight: bold;font-size: 18px;" onclick="window.location.href = '<?php echo $url; ?>/php/function/create_room.php'">
									-->
									<input type="submit" value="<?php echo get_content('room_list_button', $client_lang); ?>" class="orange_button" style="width:48%;" onclick="$('#room_list_wrapper').show();">
									<input type="submit" value="<?php echo get_content('logout_button', $client_lang); ?>" style="width:48%;margin-left:2%;" onclick="window.location.href = '<?php echo $url; ?>/logout'">
								</div>
							</div>
						</div>
						<div id="settings" style="float:left;width:100%;background:transparent;" hidden>
							<i class="fas fa-times settings_icon" onclick="$('#settings').hide(); $('#default').show();"></i>
							<div style="position: inherit;float: left;width: 100%;text-align:center;background:transparent;">
								<h2 style="color:white;margin-top:0px;">Wie synchron soll dein Video sein? (Sekunden)</h1>
								<center>
									<input type="number" min="0.2" max="2.0" value="0.5" step="0.1">
								</center>
							</div>
						</div>
					</div><div class="lobby_box" style="overflow-y: scroll;width:100%;max-height:100vh;">
						<div style="float:left;width:100%;background:transparent;">
							<h2 style="color:#fefefe;margin-top: 50px;text-align:left;margin-left:10px;"><?php echo get_content('my_rooms_title', $client_lang); ?></h2>
							<div id="get_my_rooms">
							
							</div>
						</div>
					</div>
				</div>
				<!--
				<div class="lobby_box" style="background:transparent !important;border: none;">
					<div style="float:left;width:100%;background:transparent;">
					</div>
				</div>
				-->
				<div id="room_list_wrapper">
					<i class="fas fa-times settings_icon" style="position: absolute;right: 1%;" onclick="$('#room_list_wrapper').hide();"></i>
					
					<div id="get_room">
					
					</div>
				
				</div>
				<!-- Javascript Stuff -->
				<div id="js"></div>
				<script>
				function getMyRoomList() {

					$("#get_my_rooms").load("<?php echo $url; ?>/php/function/lobby/select_my_room_list.php");	
					
					setTimeout(getMyRoomList, 2500);
				}

				getMyRoomList();
				</script>

				<script>
				function getRoomList() {

					$("#get_room").load("<?php echo $url; ?>/php/function/lobby/select_room_list.php");	
					
					setTimeout(getRoomList, 2500);
				}

				getRoomList();
				</script>
				
				<script>
				function delete_room(room_id) {
					
					if(room_id != null) {

						$("#js").load("<?php echo $url; ?>/php/function/room/delete_room.php?room_id=" + room_id); 
						$('#my_room_id_'+ room_id).hide();
					}
				}
				</script>
			
			
			</div>

			<div id="top_videos_wrapper" class="transparent_bg">
				<h1 id="top_videos_title"><?php echo get_content('top_videos_title', $client_lang); ?></h1>
				<div id="top_videos" class="transparent_bg">
				
					<?php require $_SERVER['DOCUMENT_ROOT']."/php/function/select_top_videos.php"; ?>
				
				</div>
				<center><small><a href="<?php echo $url; ?>page/archive/">Archive</a></small></center>
				<br>
			</div>
			
<script>
function check_session(){	
	$.get("<?php echo $url; ?>php/function/user/check_session.php?get=true", function(data){
		var duce = jQuery.parseJSON(data);
		var session_status = duce.session_status;
			if(session_status != 'true') {
				window.location.replace("<?php echo $url; ?>logout");
			}
	});
	setTimeout(check_session, 5000);
}
check_session();
</script>
<?php
}
?>