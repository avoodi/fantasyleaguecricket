<?
//echo " in teamlogin page";
include "dbConnect.php";
global $conn;

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
<html>

<head>
<title>Register Teams</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body leftmargin="0" topmargin="0" onLoad="foc();" >

<table width="950" border="0" cellspacing="0" cellpadding="0" align="Center" bgcolor="#FFFFFF">
	<tr>
		<td >
			<table width="98%" border="0" cellspacing="0" cellpadding="0" align="Center">
				<tr>
					<td align="left" height="130"></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
<table width="50%" border="0" cellpadding="2" cellspacing="1" align="center" bordercolordark="#FFFFFF"
bordercolorlight="CCCCCC" class="pagenav">
	<Form name="frmreg" method="post" action="teamregister.php">
	<tr>
    	<td align="center" colspan="2" valign="top" bgcolor="#CCCCCC"><strong>Register Teams</strong></td>
	</tr>
	<tr>
    	<td align="right" >Team Name :</td>
			<td ><input type="text" name="teamname" value="" size="30">
			<font color="#000000" face="Verdana, Geneva, sans-serif" size="-2"> Some nice name for your team</td>

	</tr>
	<tr>
    	<td align="right">Owner Name :</td>
    	<td><input type="text" name="OwnerName" value="" size="30">
			<font color="#000000" face="Verdana, Geneva, sans-serif" size="-2"> Your name please</td>

	</tr>
	<tr>
    	<td align="right">Login id:</td>
    	<td><input type="text" name="OwnerEmail" value="" size="30">
				<font color="#000000" face="Verdana, Geneva, sans-serif" size="-2">Could be email</td>
	</tr>
	<tr>
    	<td align="right">Password :</td>
    	<td><input type="Password" name="Pass" value="" size="30" maxlength="8">
    	<font color="#000000" face="Verdana, Geneva, sans-serif" size="-2"> max 8 chars</font>
        </td>
	</tr>

	<tr>
    	<td align="right" colspan="2">
    	<table width="100%" bgcolor="#99CC66" border="1" cellpadding="2" cellspacing="1"
				align="center" bordercolordark="#FFFFFF" bordercolorlight="CCCCCC" class="pagenav">
			<tr>
			<td colspan="2" width="50%"> Want to join existing league?</td>
			<td colspan="2" width="50%"> Want to create a new league ? </td>
			</tr>
			<tr>
			<td> <input type="radio" name="ExistingLeague" onClick="EnableDisControl(this);" ></td>
			<td><!--<%If LFlag="True" Then%><font color="#FF0000"><b>*</b></font><%End if%>-->
				<select name="selLeagueName">
				<option>--Select League--</option>
				<?
				foreach($arr1 as $lname) {
				?>
				<option value="<?= $lname ?>"><?= $lname ?></option>
				<?
				}
				?>
				</select>
			</td>
			<td> LeagueName </td>
			 <td> <input type="text" name="leaguename" value="" size="30" onClick="DisSel(this);"></td>
			</tr>
		</table></td>
	</tr>

	<tr>
    	<td align="center" colspan="2" valign="top" bgcolor="#CCCCCC"><input type="button" value="Cancel"
				name="Cancel" onClick="Refreshpage();"> <input type="submit" value="Submit" name="submit">

    	</td>
	</tr>
	</Form>
</table>
</tr>
</table>
<div align="center">
<table width=950>
	<tr align="center">
		<td><p>Every new team needs to register ..
<p></td>
	</tr>
	<tr align="center">
		<td>* Join the league that is created by a person known to you:) if you join a league 'uninvited', the league creator can kick you out .. </td>
	</tr >
	<tr align="center">
		<td>* if you are creating a new league just enter all the details , give your league a name and then pass on that league name to your friends/family/colleagues who you want to be part of your league</td>
	</tr>
	<tr align="center">
		<td>* Login id : can be anything that you will use to login next time, giving email is better as important information about league can be communicated, we assure you of 0 spam emails</td>
	</tr>

</table>
</div>

</body>
</html>
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
	location.href="teamlogin.php";
}
//-->
</script>
