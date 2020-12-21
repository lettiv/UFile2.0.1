<?php
if($security_check != 1) {

	//Blank Page

}
else
{
require $_SERVER['DOCUMENT_ROOT']."/php/function/user/check_username.php";
?>
<div class="container col-11" style="margin-top:10px;">
    <div class="row">
		<div class="container col-1">
			<button type="submit">Back</button>
		</div>
		<div class="container col-2">
			<h2>Classline</h2>
		</div>
		<div class="container col-8">
			<div class="row">
				
			</div>
		</div>	
    </div>
	<div class="row">
	Test
	</div>
</div>

<?php
}
?>	
	