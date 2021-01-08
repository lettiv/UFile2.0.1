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
						<div class="system_message red_message" style="display:none;"></div>
						<h2 id="login_register_form_title"><?php echo get_content('login_register_title', $client_lang); ?></h2>
						<div class="login_register_input_wrapper">
							<span class="login_register_input_title"><?php echo get_content('login_register_username_title', $client_lang); ?></span>
							<input id="username_input" class="login_register_input" type="text" placeholder="<?php echo get_content('login_register_username_placeholder', $client_lang); ?>" value="" onkeyup="login_register('username');">
						</div>
						
						<div id="email_wrapper" class="login_register_input_wrapper" style="display:none;">
							<span id="email_title" class="login_register_input_title" style="display:none;"><?php echo get_content('login_register_email_title', $client_lang); ?></span>
							<input id="email_input" class="login_register_input" type="email" placeholder="<?php echo get_content('login_register_email_placeholder', $client_lang); ?>" value="" onkeyup="login_register('email');" style="display:none;">
						</div>

						<div id="password_wrapper" class="login_register_input_wrapper login_register_input_wrapper_preview">
							<span id="password_title" class="login_register_input_title login_register_input_title_preview"><?php echo get_content('login_register_password_title', $client_lang); ?></span>
							<input id="password_input" class="login_register_input login_register_input_preview" type="password" value="" onkeyup="login_register('password');" disabled>
						</div>
						
							<p id="login_register_agb" style="display:none;">Lorem ipsum dolor sit amet consete scing elitr, sed diam nonumy eirmod</p>
						<center>
							<button id="login_button" class="login_register_button" onclick="login_register('login')" style="display:none;"><i class="fas fa-arrow-circle-right"></i></button>
							<button id="register_button" class="login_register_button" onclick="login_register('register')" style="display:none;"><i class="fas fa-arrow-circle-right"></i></button>
						</center>
						
					</div>
				</div>
			</section>
		</div>

		
		
<script>
function login_register(action) {

	var username = document.getElementById("username_input").value;
	var email = document.getElementById("email_input").value;
	var password = document.getElementById("password_input").value;

	if(username == '') {
	
		//Hide E-Mail
		$('#email_wrapper').fadeOut(250);
		$('#email_title').fadeOut(250);
		$('#email_input').fadeOut(250);
		$('#email_input').val('');
		
		//Hide Password
		$("#password_wrapper").addClass("login_register_input_wrapper_preview");
		$("#password_title").addClass("login_register_input_title_preview");
		$("#password_input").addClass("login_register_input_preview");
		$('#password_input').attr("disabled", true);
		$('#password_input').val('');
	
	}
	else
	{
		


		if(email != '') {
			//Show Register Button 
			$('#login_register_agb').fadeIn(250);
			$('#login_button').fadeOut(250);
			$('#register_button').fadeIn(250);
		}
		else
		{
			
			if(password != '') {
				//Show Login Button
				$('#login_register_agb').fadeIn(250);
				$('#register_button').fadeOut(250);
				$('#login_button').fadeIn(250);
			}
			else
			{
				//Show nothing
				$('#login_register_agb').fadeOut(250);
				$('#login_button').fadeOut(250);
				$('#register_button').fadeOut(250);
			}
			
		}
		
		
		$.ajax(
			{
			url: '<?php echo $url; ?>/php/function/signup/signup.php',
			type: 'post',
			dataType:'text',
			async: false,
			data: {username: username, email: email, password: password, action: action},
			success: function(result){
				
				console.log('result:' + result);
				
				if(result == "user_exists") {
					
					//Hide E-Mail for login
					$('#email_wrapper').fadeOut(250);
					$('#email_title').fadeOut(250);
					$('#email_input').fadeOut(250);
					$('#email_input').val('');
					
					//Show Password
					$("#password_wrapper").removeClass("login_register_input_wrapper_preview");
					$("#password_title").removeClass("login_register_input_title_preview");
					$("#password_input").removeClass("login_register_input_preview");
					$('#password_input').prop("disabled", false);
					

				}else if(result == "username_short") {
					
					//Hide E-Mail
					$('#email_wrapper').fadeOut(250);
					$('#email_title').fadeOut(250);
					$('#email_input').fadeOut(250);
					$('#email_input').val('');
					
					//Hide Password and Show Preview
					$("#password_wrapper").addClass("login_register_input_wrapper_preview");
					$("#password_title").addClass("login_register_input_title_preview");
					$("#password_input").addClass("login_register_input_preview");
					$('#password_input').attr("disabled", true);	
					$('#password_input').val('');
					
					//Show Error
					$('.system_message').html('Dein Nutzername ist zu kurz!');
					$('.system_message').hide().fadeIn(250);
					

				}else if(result == "user_available") {
					
					//Show E-Mail for register
					$('#email_wrapper').fadeIn(500);
					$('#email_title').fadeIn(500);
					$('#email_input').fadeIn(500);
					
					//Hide Password and Show Preview
					$("#password_wrapper").addClass("login_register_input_wrapper_preview");
					$("#password_title").addClass("login_register_input_title_preview");
					$("#password_input").addClass("login_register_input_preview");
					$('#password_input').attr("disabled", true);	
					$('#password_input').val('');
					
					
					
				}else if(result == "email_exists") {
	
					//Hide Password and Show Preview
					$("#password_wrapper").addClass("login_register_input_wrapper_preview");
					$("#password_title").addClass("login_register_input_title_preview");
					$("#password_input").addClass("login_register_input_preview");
					$('#password_input').attr("disabled", true);	
					$('#password_input').val('');
					
					//Show Error
					$('.system_message').html('Diese E-Mail Adresse existiert bereits!');
					$('.system_message').hide().fadeIn(250);
					
					$('#login_button').fadeOut(250);
					$('#register_button').fadeOut(250);
						
				}else if(result == "email_available") {

					//Show Password
					$("#password_wrapper").removeClass("login_register_input_wrapper_preview");
					$("#password_title").removeClass("login_register_input_title_preview");
					$("#password_input").removeClass("login_register_input_preview");
					$('#password_input').prop("disabled", false);
					
					//Hide Error
					$('.system_message').hide().fadeOut(250);
					
				}else if(result == "password_short") {
	
					//Show Error
					$('.system_message').html('Dein Passwort ist zu kurz!');
					$('.system_message').hide().fadeIn(250);
						
				}else if(result == "password_wrong") {

					//Show Error
					$('.system_message').html('Dein Passwort ist falsch!');
					$('.system_message').hide().fadeIn(250);
					
				}else if(result == 'success') {
					
					window.location.replace('<?php echo $url; ?>/page/dashboard');
					
				}
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