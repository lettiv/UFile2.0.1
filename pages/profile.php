<?php
if($security_check != 1) {

	//Blank Page

}
else
{
require $_SERVER['DOCUMENT_ROOT']."/php/function/user/check_username.php";
?>
<div class="container col-11">
    <div class="row">
        <div class="col-3 bg-white">
            <center style="padding-top:30px;">
              <img alt="img" heigt="125" width="125" style="border-radius:100%;" src="https://dummyimage.com/125x125/7b4eca/fff.png&text=MP">
              <h2><?php echo check_username($myuserid); ?></h2>
              <h4>Lorem Ipsum</h4>
            </center>
            <ul style="list-style:none;font-size:22px;margin-top:3vh;">
              <li style="padding-top:10px;"><a href="#" style="color:#000 !important;"><i class="fas fa-columns" style="margin-right:15px;"></i>Dashboard</a></li>
              <li style="padding-top:10px;"><a href="#" style="color:#000 !important;"><i class="far fa-check-circle" style="margin-right:15px;"></i>Erfolge</a></li>
              <li style="padding-top:10px;"><a href="#" style="color:#000 !important;"><i class="far fa-file-alt" style="margin-right:15px;"></i>Zertifikat</a></li>
              <li style="padding-top:10px;"><a href="#" style="color:#000 !important;"><i class="far fa-folder" style="margin-right:15px;"></i>Dokumente</a></li>
            </ul>
        </div>
		<div class="col-3 bg-white">
			<div class="col-1">
				<div>
					<p>View</p>
				</div>
			</div>
			<div class="col-1">
				<div>
					<img alt="img" heigt="25" width="25" style="border-radius:100%;" src="https://www.flaticon.com/svg/static/icons/svg/833/833472.svg">
				</div>
    	<!--<div class="col-9">
          <div class="row" style="background:#fe7f2e;height:300px;">
              <div class="col-12">
                <div style="margin-left:3%; width:30%;color:white;margin-top:3vh;margin-bottom:3vh;">
                <h1>Hi Monkey Pussy!</h1>
                <h6>Have a nice day!</h6>
          </div>
          <div class="col-12">
                <div style="background:white;border-radius:5px;float:left;width:30%;margin-left:2%;padding:20px;min-height:250px;">
                  <p style="font-size:20px;">Dein Status</p>
                  <h2 style="color:#fe7f2e;">Studium</h2>

                  <p style="margin-top:20px;font-size:20px;">Nächste Stufe</p>
                  <h2 style="color:#8840c5;">Master</h2>
                </div>

                <div style="background:white;border-radius:5px;float:left;width:30%;margin-left:2%;padding:20px;min-height:250px;text-align:center;">
                  <p style="font-size:20px;">Bereits eingetragen</p>
                  <p style="font-size:58px;color:#fe7f2e;">11</p>

                  <p>Du hast deine letzte Datei<br> vor <span style="color:#8840c5;">4 Tagen</span> hochgeladen</p>
                </div>

                <div style="background:white;border-radius:5px;float:left;width:30%;margin-left:2%;padding:20px;min-height:250px;text-align:center;">
                  <p style="font-size:20px;">Glückwunsch!</p>
                  <p style="font-size:45px;color:#8840c5;">10 <span style="color:#000;font-size:18px;text-align:right;">gelesen</span></p>

                  <p style="font-size:45px;color:#8840c5;">5 <span style="color:#000;font-size:18px;text-align:right;">Kommentare</span></p>
                </div>

              </div>
          </div>

	  -->

          <!-- First Row -->
          <div class="row" style="padding-top:5vh;margin:auto;width:100%;">
              <!--Box Start -->
              <div class="col-md-6">
                <div class="col-md-12" style="background:#fff;border-radius:5px;padding:20px;min-height:250px;">
                  <b>Bereiche auswählen</b>
                  <hr>
                  <table style="text-align:left;">

                    <tr>
                      <td><img alt="img" heigt="50" width="50" style="border-radius:10%;" src="https://dummyimage.com/125x125/7b4eca/fff.png&text=AU"></td>
                      <td style="padding-left:5%;">Ausbildung<br><small>Prozess in 22% - letztes Update vor 2 Tagen</small></td>
                    </tr>
                    <tr>
                      <td><img alt="img" heigt="50" width="50" style="border-radius:10%;" src="https://dummyimage.com/125x125/fe7f2e/fff.png&text=FI"></td>
                      <td style="padding-left:5%;">Finanzen<br><small>Prozess in 45% - letztes Update vor 12 Tagen</small></td>
                    </tr>
                    <tr>
                      <td><img alt="img" heigt="50" width="50" style="border-radius:10%;" src="https://dummyimage.com/125x125/7b4eca/fff.png&text=SL"></td>
                      <td style="padding-left:5%;">Soziales Leben<br><small>Prozess in 62% - letztes Update vor 5 Tagen</small></td>
                    </tr>

                  </table>
                </div>
              </div>
              <!--Box End -->

            <div class="col-md-6">
              <div class="col-md-12" style="background:#fff;border-radius:5px;padding:20px;min-height:250px;">
                <b>Bereiche lesen</b>
                <hr>
                <table style="text-align:left;">

                  <tr>
                    <td><img alt="img" heigt="50" width="50" style="border-radius:10%;" src="https://dummyimage.com/125x125/fe7f2e/fff.png&text=AU"></td>
                    <td style="padding-left:5%;">Ausbildung<br><small>Prozess in 22% - letztes Update vor 2 Tagen</small></td>
                  </tr>
                  <tr>
                    <td><img alt="img" heigt="50" width="50" style="border-radius:10%;" src="https://dummyimage.com/125x125/7b4eca/fff.png&text=FI"></td>
                    <td style="padding-left:5%;">Finanzen<br><small>Prozess in 45% - letztes Update vor 12 Tagen</small></td>
                  </tr>
                  <tr>
                    <td><img alt="img" heigt="50" width="50" style="border-radius:10%;" src="https://dummyimage.com/125x125/fe7f2e/fff.png&text=SL"></td>
                    <td style="padding-left:5%;">Soziales Leben<br><small>Prozess in 62% - letztes Update vor 5 Tagen</small></td>
                  </tr>

                </table>
              </div>
            </div>

              <!--Placeholder
              <div class="col-md-1"></div>-->
          </div>
          <!-- First Row END -->

          <!-- Second Row -->
          <div class="row" style="padding-top:5vh;margin:auto;width:100%;">
              <!--Box Start -->
              <div class="col-md-5">
                <div class="col-12" style="background:#fff;border-radius:5px;padding:20px;min-height:250px;">
                  <b>Todo-List</b>
                  <hr>
                  <ul style="list-style:none;padding:0px;">
                    <li style="margin-top:6px;"><input type="checkbox" style="margin-left:5px;margin-right:5px;outline:3px solid #fe7f2e;"> Lorem ipsum dolor sit amet</li>
                    <li style="margin-top:6px;"><input type="checkbox" style="margin-left:5px;margin-right:5px;outline:3px solid #fe7f2e;"> Lorem ipsum dolor sit amet</li>
                    <li style="margin-top:6px;"><input type="checkbox" style="margin-left:5px;margin-right:5px;outline:3px solid #fe7f2e;"> Lorem ipsum dolor sit amet consete</li>
                    <li style="margin-top:6px;"><input type="checkbox" style="margin-left:5px;margin-right:5px;outline:3px solid #fe7f2e;"> Lorem ipsum dolor sit amet consete scing elitr, sed diam nonumy eirmod</li>
                  </ul>
                </div>
              </div>
              <!--Box End -->

              <!--Box Start -->
              <div class="col-md-7">
                <div class="col-12" style="background:#fff;border-radius:5px;padding:20px;min-height:250px;">
                  <b>Kommentare</b>
                  <hr>
                  <table style="text-align:left;">
                    <tr>
                      <td><img alt="img" heigt="50" width="50" style="border-radius:100%;" src="https://dummyimage.com/125x125/d9d9d9/fff.png&text="></td>
                      <td style="padding-left:5%;">Bunny Chichi<br><small>Lorem ipsum dolor sit amet, consetetur sadip scing elitr, sed diam nonumy eirmod</small></td>
                    </tr>
                    <tr>
                      <td><img alt="img" heigt="50" width="50" style="border-radius:100%;" src="https://dummyimage.com/125x125/d9d9d9/fff.png&text="></td>
                      <td style="padding-left:5%;">Cookie Lyly<br><small>Lorem ipsum dolor sit amet, consetetur sadip scing</small></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>

            <!--Placeholder-->
            <div class="col-md-1"></div>
          </div>
          <!-- Second Row END -->
        </div>
    </div>
</div>

<?php
}
?>
