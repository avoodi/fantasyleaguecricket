<!DOCTYPE html>
<?
include "dbConnect.php";
global $conn;

// Check connection

if ($conn == false) {
	echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
}

$sql="select leaguename from league_mst  where biddingstatus ='NotApplicable'";

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
<link href="../NewUI/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="../NewUI/css/component.css" rel="stylesheet" type="text/css" media="all" />
<link href="../NewUI/css/style_grid.css" rel="stylesheet" type="text/css" media="all" />
<link href="../NewUI/css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- font-awesome-icons -->
<link href="../NewUI/css/font-awesome.css" rel="stylesheet">
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
														<form name="frmreg" method="post" action="DQteamregister.php" >
															<input type="text" name="uname" placeholder="User Name" required="">
															<input type="password" name="userpassword" placeholder="Your password" required="">

																	<!--input type="password" name="password" placeholder="Confirm Password" required=""-->
																<label > Want to join existing group? </label>
																<div class="form-group">
																	<div class="checkbox block col-sm-1 control-label" style="padding-right:0px; padding-left:0px;">
																		<label><input type="checkbox" name="ExistingGroup" onClick="EnableDisControl(this);"></label>
																	</div>
																	<div class="col-sm-11" style="padding-right:0px; padding-left:0px;" >
																		<select name="selGroupName"  class="form-control1" >
																			<option value="">Select Group</option>
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
																<label > OR Want to create a new Group ? </label>
																<input type="text" name="groupname" placeholder="Group Name" value="" onClick="DisSel(this);">
																<input type="password" name="grouppwd" placeholder="Group Password" required="">

																<div class="tp">
																	<div class="row">
																		<div class="col-md-6 ">
																			<button type="button" class="btn btn-primary pull-right" onClick="Refreshpage();">cancel</button>
																		</div>
																		<div class="col-md-6">
																			<button type="submit" class="btn btn-success pull-left" onclick="validate();">Sign Up</button>
																		</div>

																	</div>
																</div>

														</form>
													</div>

													<p style="font-size: 12px;">

															* Join the Group that is created by a person known to you:) if you join a group 'uninvited', you might get kicked out ..<br>
															* if you are creating a new Group just enter all the details , give your group a name and then pass the group name and group password to your friends/family/colleagues who you want to be part of your group<br>
													</p>

												</div>
										</div>
						    </div>
						</div>
							<!-- /login -->


<!-- js -->
          <script type="text/javascript" src="../NewUI/js/jquery-2.1.4.min.js"></script>
		  <script src="../NewUI/js/modernizr.custom.js"></script>
		   <script src="../NewUI/js/classie.js"></script>
<!-- //js -->


<script src="../NewUI/js/jquery.nicescroll.js"></script>
<script src="../NewUI/js/scripts.js"></script>

<script type="text/javascript" src="../NewUI/js/bootstrap-3.1.1.min.js"></script>

<script language="JavaScript" type="text/JavaScript">
<!--
//function EnableDisControl(theField)
//{
//  if(theField.name == "ExistingGroup")
//  {
//  	if(theField.checked == true)
//  	{
//            document.frmreg.selGroupName.disabled = false;
//  	 		document.frmreg.groupname.disabled = true;
//
//     }
//  }
//}

function EnableDisControl(theField)
{
	if(theField.checked == true)
	{
			document.frmreg.selGroupName.disabled = false;
			document.frmreg.groupname.disabled = true;
	}
	if(theField.checked == false)
	{
			document.frmreg.selGroupName.disabled = false;
			document.frmreg.groupname.disabled = true;
	}
}

function DisSel(theField)
{
  if(theField.name == "groupname")
  {
  		document.frmreg.selGroupName.disabled = true;
  	 	document.frmreg.ExistingGroup.disabled = true;
  }
}
function Refreshpage()
{
	location.href="DQteamlogin.php";
}
function validate()
{		alert('HI The selectbox contains 0 items');
let optionsLength = document.getElementById("selGroupName").length;
alert("The Length is : "+optionsLength);
if(optionsLength == 0){
//if(document.frmreg.selGroupName.options.length == 0){
		alert('The selectbox contains 0 items');
	}
}
//-->
</script>

</body>
</html>
