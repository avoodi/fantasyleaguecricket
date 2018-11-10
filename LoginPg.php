<!--  default login page -->
<html>
<head>
<link rel="stylesheet" type="text/css" href="dat.css">
<script language="javascript">
	function foc()
	{
	document.frmlogin.username.focus();
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
body {
	background-color: #CCF;
}
</style>
</head>
<body leftmargin="0" topmargin="0" onLoad="foc();" ><br/><br/>
<table width="950" border="0" cellspacing="0" cellpadding="0" align="Center" >
	<tr>
		<td >
			<table width="98%" border="0" cellspacing="0" cellpadding="0" align="Center">
				<tr>
					<td align="center" height="190">
					<span style="font-size: 25pt;color:#FFFFFF">Welcome to the Fantasy Cricket league </span><b>
<span style="font-size: 25pt;color:#FFFFFF">Welcome to the Fantasy Cricket league </span><b>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="Top">
		<div align="center">
		  <table border="1" cellpadding="2" cellspacing="0" width="35%"  bgcolor="#3399CC" bordercolordark="#CCCCCC" bordercolorlight="#FFFFCC" id="table5">
			<form name="frmlogin" action="chkLogin.php?action=check" style="margin:0px;" method="post" onSubmit="return validLogin();">
					<tr><td colspan="2" align="center" class="header">
					<font color="#FFFFFF">Login</font></td></tr>
					<tr>
						<td align="right"><font color="#FFFFFF"><strong>Login</strong></font>&nbsp;:</td>
						<td ><input type="text" name="username" id="username" style=" font-size:10px; width:150px;" value=""></td>
					</tr>
					<tr>
						<td  align="right"><font color="#FFFFFF"><strong>Password</strong></font>&nbsp;:</td>
						<td ><input type="password" name="pass" id="pass" style="font-size:10px; width:150px;" value=""></td>
					</tr>
					<tr>
						<td  align="right"><font color="#FFFFFF"><strong>League Name</strong></font>&nbsp;:</td>
						<td ><input type="text" name="leaguename" id="leaguename" style="font-size:10px; width:150px;" value=""></td>
					</tr>

					<tr>

						<th colspan="2" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" src="Submit" value="submit" alt="Submit">
						<font color="#FFFFFF" face="Verdana, Geneva, sans-serif" size="-1">&nbsp;&nbsp;&nbsp;&nbsp;
						New User ? <a href="teamlogin.php">Register</font></a></th>
					</tr>
			</form>
		  </table>
		</div>
		</td>
			</tr>
		</table>
		<table>
		</table>
		<div align="center">
		<table width=950>
			<tr align="center">
				<td><p>Enjoy IPL even more; Create a league of your own , play with your friends, family, office colleagues...
  <p></td>
			</tr>
			<tr align="center">
				<td>Simple steps</td>
			</tr >
			<tr align="center">
				<td>* someone creates a league</td>
			</tr>
			<tr align="center">
				<td>* Friends/family/colleague join that league</td>
			</tr>
			<tr align="center">
				<td>* League decide to for bidding process(optional, but lot of fun) to acquire players/form teams OR go for ‘random allocation’ of players
</td>
			</tr>
			<tr align="center">
				<td>* The league creator puts up the draw(schedule of league matches) </td>
			</tr>
			<tr align="center">
				<td>* Teams select players, captain based on actual IPL match (based on league draw - can be done in one go for all future matches)</td>
			</tr>
			<tr align="center">
				<td align="center">* Every team has one-one match with some other league everyday, earns points based on how players performed in actual ill match
			</td>
			</tr>
			<tr align="center">
				<td>* Winner/looser, league standing gets decided based on total points
			</td>
			</tr>
			<tr align="center">
				<td>* Buy, sell players if required
			</td>
			</tr >

		</table>
</div>
</body>
</html>

<script language="javascript">
	function validLogin()
	{
		if ((document.frmlogin.username.value == "")||(document.frmlogin.username.value == "username"))
		{
			alert ('Please enter your username');
			document.frmlogin.username.focus();
			return false;
		}
		if ((document.frmlogin.pass.value == "")||(document.frmlogin.pass.value == "password"))
		{
			alert ('Please enter your password');
			document.frmlogin.pass.focus();
			return false;
		}
		return true;
	}

</script>
<!-- Ends default login page -->
