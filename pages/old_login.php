<?php
if($security_check != 1) {

	//Blank Page

}
else
{
?>
			<div id="create_login" style="width:500px;">
				
				<p><?php echo get_content('login_form_title', $client_lang); ?></p>
				
				<p id="login_message_error" class="system_message red_message" style="display:none;"></p>
				<p id="login_message_success" class="system_message green_message" style="display:none;"></p>
				
				<form onsubmit="event.preventDefault(); login();">
					<input type="hidden" name="room_hash" id="login_room_hash" value="<?php echo $room_hash; ?>">
					<input type="hidden" name="room_id" id="login_room_id" value="<?php echo $room_id; ?>">
					<input type="text" name="username" id="login_username" required placeholder="Username">
					<input type="password" name="password" id="login_password" required placeholder="Password">
					
					<!--<script src="https://www.google.com/recaptcha/api.js?render=6Lf6JssUAAAAAKrjXqWq0JoGkaOFT9033W0R9LmW"></script>-->
					<script>
					/*
					//Google Captcha
					grecaptcha.ready(function() {
						grecaptcha.execute('_reCAPTCHA_site_key_', {action: 'homepage'}).then(function(token) {
						   
						   $( "#login_button" ).show();
						   $( "#register_button" ).show();
						   
						});
					});*/
					</script>

					
					<center><input type="submit" id="login_button" class="green_button" value="<?php echo get_content('login_button', $client_lang); ?>" style="float:left;" onclick="login()">
					<input type="submit" id="register_button" value="<?php echo get_content('register_button', $client_lang); ?>" style="float:right;" onclick="login()"></center>

				</form>
			</div>

<script>
function login() {

	var room_hash = document.getElementById("login_room_hash").value;
	var room_id = document.getElementById("login_room_id").value;
	var username = document.getElementById("login_username").value;
	var password = document.getElementById("login_password").value;
	

	
	if((username == null) || (password == null)) {
		
		//$( "#login_button" ).show();
		//$( "#register_button" ).show();
		
	}
	else
	{
		$.ajax(
			{
			url: '<?php echo $url; ?>/php/function/login.php',
			type: 'post',
			dataType:'text',
			data: {username: username, password: password},
			success: function(result){
				
				console.log(result);
				
				
				if(result == "success") {
					
					window.location.replace('<?php echo $url; ?>/page/dashboard');

				}else if(result == "registered") {
					
					$('#login_message_success').html('You are now registered!');
					$( "#login_message_success" ).fadeIn();
					window.location.replace('<?php echo $url; ?>/page/dashboard');
					

		
				}else if(result != 'null'){
					
				
					$('#login_message_error').html(result);
					$( "#login_message_error" ).fadeIn();
				
				
				}
				else if(result == null) {
				
					window.location.replace('<?php echo $url; ?>');
					
				}
				
				$( "#login_button" ).show();
				$( "#register_button" ).show();
			}
		})
	}
}
</script>

<?php
function isMobileDevice() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

if(isMobileDevice()){
/* 
	echo '<script>
	$("#login_message_error").fadeIn();
	$("#login_message_error").html("Sorry but we do not support smartphones yet.");
	$("#login_button").hide();
	$("#register_button").hide();
	</script>';
 */
}
else {
    //echo "It is desktop or computer device";
}
?>


<?php
}
?>	