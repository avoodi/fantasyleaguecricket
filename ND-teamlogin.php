<!DOCTYPE html>
<?
//echo " in teamlogin page";
include "dbConnect.php";
global $conn;


// Create connection
//$conn = mysqli_connect($servername, $dbusername, $dbpassword,$dbname);

// Check connection

if ($conn == false) {
	echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
}

$sql="select leaguename from league_mst";

$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$arr1[$i]=$row[0];
	$i=$i+1;
}

?>
<html lang="zxx">
<head>
<title>signup</title>
<!-- custom-theme -->
<link href="NewUI/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="NewUI/css/component.css" rel="stylesheet" type="text/css" media="all" />
<link href="NewUI/css/style_grid.css" rel="stylesheet" type="text/css" media="all" />
<link href="NewUI/css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- font-awesome-icons -->
<link href="NewUI/css/font-awesome.css" rel="stylesheet">
<!-- //font-awesome-icons -->
</head>
<body>
			<!-- /pages_agile_info_w3l -->

						<div class="pages_agile_info_w3l">
							<!-- /login -->
							   <div class="over_lay_agile_pages_w3ls two">
								<div class="registration">

												<div class="signin-form profile">
													<h2>Register</h2>
													<div class="login-form">
														<form name="frmreg" method="post" action="teamregister.php" >
															<input type="text" name="teamname" placeholder="Team Name" required="">
															<input type="text" name="OwnerName" placeholder="Team Owner Name" required="">

																<input type="text" name="OwnerEmail" placeholder="LoginId/E-mail" required="">

																<input type="password" name="Pass" placeholder="Password" required="">
																	<!--input type="password" name="password" placeholder="Confirm Password" required=""-->
																<label > Want to join existing league? </label>
																<div class="form-group">
																	<div class="radio block col-sm-1 control-label" style="padding-right:0px; padding-left:0px;">
																		<label><input type="radio" name="ExistingLeague" onClick="EnableDisControl(this);"></label>
																	</div>
																	<div class="col-sm-11" style="padding-right:0px; padding-left:0px;" >
																		<select name="selLeagueName"  class="form-control1" >
																			<option value="">Select League</option>
																			<?
																			foreach($arr1 as $lname) {
																			?>
																			<option value="<?= $lname ?>"><?= $lname ?></option>
																			<?
																			}
																			?>
																		</select>
																	</div>
																</div>
																<label > Want to create a new league ? </label>
																<input type="text" name="leaguename" placeholder="League Name" value="" onClick="DisSel(this);">
																<div class="tp">
																	<div class="row">
																		<div class="col-md-6 ">
																			<button type="button" class="btn btn-primary pull-right">cancel</button>
																		</div>
																		<div class="col-md-6">
																			<button type="submit" class="btn btn-success pull-left">Sign Up</button>
																		</div>

																	</div>
																</div>

														<!--	<div class="tp">
																<input type="submit" value="SIGN Up">
															</div> -->
														</form>
													</div>

													<p style="font-size: 12px;">
															Give your team a name and register  ..<br>

															* Join the league that is created by a person known to you:) if you join a league 'uninvited', the league creator can kick you out ..<br>
															* if you are creating a new league just enter all the details , give your league a name and then pass on that league name to your friends/family/colleagues who you want to be part of your league<br>
															* Login id : can be anything that you will use to login next time, giving email is better as important information about league can be communicated, we assure you of 0 spam emails<br>
													</p>

												</div>
										</div>
						    </div>
						</div>
							<!-- /login -->


<!-- js -->
          <script type="text/javascript" src="NewUI/js/jquery-2.1.4.min.js"></script>
		  <script src="NewUI/js/modernizr.custom.js"></script>
		   <script src="NewUI/js/classie.js"></script>
<!-- //js -->


<script src="NewUI/js/jquery.nicescroll.js"></script>
<script src="NewUI/js/scripts.js"></script>

<script type="text/javascript" src="NewUI/js/bootstrap-3.1.1.min.js"></script>

<script language="JavaScript" type="text/JavaScript">
<!--
function EnableDisControl(theField)
{
  if(theField.name == "ExistingLeague")
  {
  	if(theField.checked == true)
  	{
            document.frmreg.selLeagueName.disabled = false;
  	 		document.frmreg.leaguename.disabled = true;

     }
  }

}

function DisSel(theField)
{

  if(theField.name == "leaguename")
  {
  		document.frmreg.selLeagueName.disabled = true;
  	 	document.frmreg.ExistingLeague.disabled = true;
  }
}
function Refreshpage()
{
	location.href="ND-teamlogin.php";
}
//-->
</script>

</body>
</html>
