<?

?>
<html>
<head>
</head>
<body>
  <h4> Did we have 2 matches yesterday ? if yes, pl check if scoreupdate script has been updated</h4>
<table align="center"  width=80%>
  <Form name="frmreg" method="post" action="scoreupdate.php">
    <tr>
        <td align="right" width="28%">LeagueName :</td>
        <td width="70%"><input type="text" name="leaguename" value="" size="30"></td>
    </tr>
    <tr>
      <td align="right" width="28%">MatchId :</td>
      <td width="70%"><input type="text" name="matchid" value="" size="30"></td>
    </tr>
    <tr>
      <td align="right" width="28%">IPL day :</td>
      <td width="70%"><input type="text" name="iplday" value="" size="30"></td>
    </tr>
    <tr>
      <td align="right" width="28%">Is this First time update :</td>
      <td width="70%"><input type="text" name="firstrun" value="" size="5"></td>
    </tr>

    <tr>
      	<td align="center"  valign="top" bgcolor="#CCCCCC"> <input type="submit" value="Submit" name="submit"></td>
  	</tr>
  	</Form>
  </table>
</body>
</html>
