<?php
if($security_check != 1) {

	//Blank Page

}
else
{
require $_SERVER['DOCUMENT_ROOT']."/php/function/user/check_username.php";
?>
<style>
.main-timeline{ position: relative; }
.main-timeline:before,
.main-timeline:after{
    content: "";
    display: block;
    width: 100%;
    clear: both;
}
.main-timeline:before{
    content: "";
    width: 100%;
    height: 5px;
    background: #fff;
    margin: auto 0;
    position: absolute;
    top: 50%;
    left: 0;
}
.main-timeline .timeline{
    float: left;
    margin-left: 3%;
    position: relative;
}
.main-timeline .year{
    display: inline-block;
    width: 30px;
    height: 30px;
	display: grid;
	align-items: center;
    background: blue;
    border-radius:100%;
    border: 3px solid #fff;
    text-align: center;
    position: relative;
}
.main-timeline .year span{
    display: block;
    font-size: 20px;
    font-weight: bold;
    color: #fff;
}
</style>

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
		<div class="col-md-12">
			<div class="main-timeline">
				<div class="timeline">
					<span class="year">
						<span>3</span>
					</span>
				</div>
				<div class="timeline">
					<span class="year">
						<span>4</span>
					</span>
				</div>
				<div class="timeline">
					<span class="year">
						<span>5</span>
					</span>
				</div>
				<div class="timeline">
					<span class="year">
						<span>6</span>
					</span>
				</div>
				<div class="timeline">
					<span class="year">
						<span>7</span>
					</span>
				</div>
				<div class="timeline">
					<span class="year">
						<span>8</span>
					</span>
				</div>
				<div class="timeline">
					<span class="year">
						<span>9</span>
					</span>
				</div>
				<div class="timeline">
					<span class="year">
						<span>10</span>
					</span>
				</div>
				<div class="timeline">
					<span class="year">
						<span>11</span>
					</span>
				</div>
				<div class="timeline">
					<span class="year">
						<span>12</span>
					</span>
				</div>
				<div class="timeline">
					<span class="year">
						<span>13</span>
					</span>
				</div>

			</div>
		</div>
	</div>
</div>

<?php
}
?>
