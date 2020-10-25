<?php
if($security_check != 1) {
	//header('Location: https://react2gether.com');
}
else
{
	
	//echo '<meta http-equiv="refresh" content="1; URL=https://' . $_SERVER['HTTP_HOST'] .'/maintenance">';
	//exit;
	
?>
		<div id="login_register">
			<section>
				<div id="login_register_welcome">
					<div id="login_register_welcome_text">
						<h1>Hello,<br>Friend!</h1>
						<h2>Zukunft, Gegenwart, Vergangenheit<br> gestaltet in ein</h2>
					</div>
				</div>
			</section>
			<section>
				<div id="login_register_action">
					<div id="login_register_form_wrapper">
						<h2 id="login_register_form_title">Wir freuen uns, dich wiederzusehen.</h2>
						<div class="login_register_input_wrapper">
							<span class="login_register_input_title">Benutzername</span>
							<input class="login_register_input" type="text" name="username" placeholder="Type your username" value="Monkey Pussy">
						</div>

						<div class="login_register_input_wrapper login_register_input_wrapper_preview">
							<span class="login_register_input_title login_register_input_title_preview">Passwort</span>
							<input class="login_register_input login_register_input_preview" type="password" name="password" value="" disabled>
						</div>
					</div>
				</div>
			</section>
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