<!--#include file="_includes/connection.asp" -->
<%
dim iflag 
iflag = 0

team1 = trim(request("t1"))
team2 = trim(request("t2"))
wcmatchnum=trim(request("t3"))

leaguename = session("leaguename")
teamowner = session("Userid")
		
set rsKeyRec = server.CreateObject("ADODB.RECORDSET")	
ipasswd = request("pass")
iuserid = request("username")


szSql= "select pm.playername, nvl(pm.odibatavg,0) odibatavg, lar.ccaptainyn, pm.oditotalmatches, (pm.oditotalwickets/decode(pm.oditotalmatches,0,1,pm.oditotalmatches))odiwkts, (pm.oditotalcatches/decode(pm.oditotalmatches,0,1,pm.oditotalmatches)) odicatches,  (pm.oditotal4/decode(pm.oditotalmatches,0,1,pm.oditotalmatches)) odi4, (pm.oditotal6/decode(pm.oditotalmatches,0,1,pm.oditotalmatches)) odi6 ,  pm.oditotalmom, pm.iplteam, lar.inplaying11 from playermst pm, leagueauctionresults lar where lar.leaguename='"&leaguename&"' and nvl(lar.ownerteam,'') ='"&team1&"' and lar.playername=pm.playername "
		

'response.End()
set rsKeyRec2 = server.CreateObject("ADODB.RECORDSET")	
szSql2= " select pm.playername, nvl(pm.odibatavg,0) odibatavg, lar.ccaptainyn, pm.oditotalmatches,  (pm.oditotalwickets/decode(pm.oditotalmatches,0,1,pm.oditotalmatches))odiwkts, (pm.oditotalcatches/decode(pm.oditotalmatches,0,1,pm.oditotalmatches)) odicatches,   (pm.oditotal4/decode(pm.oditotalmatches,0,1,pm.oditotalmatches)) odi4, (pm.oditotal6/decode(pm.oditotalmatches,0,1,pm.oditotalmatches)) odi6 ,   pm.oditotalmom, pm.iplteam, lar.inplaying11 from playermst pm, leagueauctionresults lar where lar.leaguename='"&leaguename&"' and nvl(lar.ownerteam,'') ='"&team2&"' and lar.playername=pm.playername "


set rsKeyRec3=server.CreateObject("ADODB.RECORDSET")
szSql3="select team1, team2 from wcschedule w where w.matchnum="&wcmatchnum&" " 
rsKeyRec3.Open szSql3, con
wcTeam1=rsKeyRec3("team1")
wcTeam2=rsKeyRec3("team2")
rsKeyRec3.close

response.Write(szSelSql)

set rsKeyRec4=server.CreateObject("ADODB.RECORDSET")
szSql4="select l.leaguename, l.runpoints, l.catchpoints, l.wicketpoints, l.sixerpoints, l.boundrypoints  from leaguerules l where l.leaguename='"&leaguename&"' "
rsKeyRec4.Open szSql4, con

response.Write(szSelSql)

runpoints=rsKeyRec4("runpoints")
catchpoints=rsKeyRec4("catchpoints")
wicketpoints=rsKeyRec4("wicketpoints")
sixerpoints=rsKeyRec4("sixerpoints")
boundrypoints=rsKeyRec4("boundrypoints")

rsKeyRec4.close

%>
<link rel="stylesheet" type="text/css" href="dat.css"> 
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Team Player Details</title>
</head>
<body style="margin:0px;" background="images/top_bg.gif">

<style type="text/css">
<!--
.boldtable, .boldtable TD, .boldtable TR
{
font-family:Comic Sans MS, cursive;
font-size:8pt;
color:white;
background-color:navy;
}
-->
</style>
<table width="950" border="0" cellspacing="0" cellpadding="0" align="Center" bgcolor="#FFFFFF">
	<tr>
		<td style="background: url('images/TOPHEAD.gif') repeat-x;">	
			<table width="98%" border="0" cellspacing="0" cellpadding="0" align="Center">				
				<tr>
					<td align="left" height="130"><marquee scrollamount="03"> 
					<span style="font-size: 15pt;color:#FFFFFF">Welcome to the Indus Internal</span><b><font size="5" color="#FFFFFF"> Fantasy</font></b><span style="font-size: 15pt;color:#FFFFFF;"> 
					Cricket league </span></marquee></td>
				</tr>				
			</table>
		</td>
	</tr>
	<tr>
		<table width="950" align="center">
			<tr>
				<td width="40%" align="left"><a href="teambiddetails.asp"><b>Main Team Page</b></a></td>
			</tr>
		</table>

	</tr>
    <tr>
		<table border="0" cellpadding="0" class="text" cellspacing="0" width="80%" align="center" bordercolordark="#FFFFFF" bordercolorlight="#FFFFCC">
			<tr>
            	<td align="center" valign="top"><font size="+2" color="#FFFFFF" face="Comic Sans MS, cursive"> &quot;Head On&quot; match up Between team1 vs team2 </font>
                </td>
            </tr>
		</table>
	</tr>
    <tr>
    	<table width="600" border="1" align="center" class="boldtable">
  			<tr>
    			<td colspan="2"><font size="-1" color="#FFFFFF" face="Comic Sans MS, cursive">Following matchup is based on average performances in ODI's</font></td>
    		</tr>
  			<tr>
    			<td align="center" >Team: <%=team1%> And <%=wcTeam1%></td>
    			<td align="center" >Team: <%=team2%>And <%=wcTeam2%></td>
  			</tr>
  			<tr>
    			<td>
                	<table width="400" border="0">
      					<tr bgcolor="#CCCC00">
        					<th>Player</th>
        					<th>Score</th>
        					<th>Wickets</th>
        					<th>4's</th>
        					<th>6's</th>
        					<th>Catches</th>
        					
        					<th>Points</th>
        					<th>&nbsp;</th>
        					<th>&nbsp;</th>
      					</tr>
                        
						<%
							rsKeyRec.Open szSql,con
								I = 1
								Points=0
							Do while not rsKeyRec.eof
							playersTeam=rsKeyRec("iplteam")
							'response.write(trim(rsKeyRec("odibatavg")) * Trim(runpoints))
							'response.end()

							if (wcTeam1=playersTeam or wcTeam2=playersTeam) and rsKeyRec("inplaying11")="Y" then
								If rsKeyRec("ccaptainyn")="Y" then
									Points = 2* (Trim(rsKeyRec("odibatavg")) * Trim(runpoints)) + (Trim(rsKeyRec("odiwkts")) * Trim(wicketpoints)) + (Trim(rsKeyRec("odi4")) * trim(boundrypoints))+ (Trim(rsKeyRec("odi6")) * trim(sixerpoints)) + (Trim(rsKeyRec("odicatches")) * trim(catchpoints))
								else
									Points = (trim(rsKeyRec("odibatavg")) * trim(runpoints)) + (trim(rsKeyRec("odiwkts")) * trim(wicketpoints)) + (trim(rsKeyRec("odi4")) * trim(boundrypoints))+ (trim(rsKeyRec("odi6")) * trim(sixerpoints)) + (trim(rsKeyRec("odicatches")) * trim(catchpoints))
								end if
								
								TotalPoints=TotalPoints+Points
								
							end if



if IsNumeric(rsKeyRec("odi4"))= False Then
	rsodi4 = 0
End If
if IsNumeric(rsKeyRec("odi6"))= False Then
	rsodi6 = 0
End If
if IsNumeric(rsKeyRec("odicatches"))= False Then
	odicatches = 0
End if
if IsNumeric(rsKeyRec("odiwkts"))= False Then
	odiwkts = 0
End if

						%>


      					<tr>
        					<td><%=rsKeyRec("playername")%> <%if rsKeyRec("ccaptainyn")="Y" then%>***<%end if%></td>
        					<td align="center"><%=Trim(rsKeyRec("odibatavg")) * trim(runpoints)%></td>
        					<td align="center"><%=odiwkts * trim(wicketpoints)%></td>
        					<td align="center"><%=rsodi4 * trim(boundrypoints) %></td>
        					<td align="center"><%=rsodi6 * trim(sixerpoints)%></td>
        					<td align="center"><%=odicatches * trim(catchpoints)%></td>                         
        					<td align="center"><%=trim(Points)%></td>        					
        					<td align="center">&nbsp;</td>
        					<td align="center">&nbsp;</td>
      					</tr>
                        
						<%
							rsKeyRec.Movenext
							I = I + 1
							Points=0
							Loop
						%>
      					<tr>
        					<td>Total Points</td>
        					<td>&nbsp;</td>
        					<td>&nbsp;</td>
        					<td>&nbsp;</td>
        					<td>&nbsp;</td>
        					<td>&nbsp;</td>
        					<td>&nbsp;</td>
        					<td>&nbsp;</td>
        					<td>&nbsp;</td>
        					<td><%=TotalPoints%></td>
      					</tr>
    				</table>
                </td>
    			<td>
                	<table width="400" border="0">
      					<tr>
        					<th>Player</th>
                            <th>Score</th>
                            <th>Wickets</th>
                            <th>4's</th>
                            <th>6's</th>
                            <th>Catches</th>
                           
                            <th>Point</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                          </tr>
                          
                          <%
							rsKeyRec2.Open szSql2,con
								I = 1
								Points=0
								TotalPoints=0
							Do while not rsKeyRec2.eof
							playersTeam=rsKeyRec2("iplteam")

							if IsNumeric(rsKeyRec2("odi4"))= False Then
								xrsodi4 = 0
							End If
							if IsNumeric(rsKeyRec2("odi6"))= False Then
								xrsodi6 = 0
							End If
							if IsNumeric(rsKeyRec2("odicatches"))= False Then
								xodicatches = 0
							End if
							if IsNumeric(rsKeyRec2("odiwkts"))= False Then
								xodiwkts = 0
							End if

							if (wcTeam1 = playersTeam or wcTeam2 = playersTeam) and rsKeyRec2("inplaying11")="Y" then
								If trim(rsKeyRec2("ccaptainyn")) <> "Y" then
									Points = (trim(rsKeyRec2("odibatavg")) * trim(runpoints)) + (trim(rsKeyRec2("odiwkts")) * trim(wicketpoints)) + (trim(rsKeyRec2("odi4")) * trim(boundrypoints))+ (trim(rsKeyRec2("odi6")) * trim(sixerpoints)) + (trim(rsKeyRec2("odicatches")) * trim(catchpoints))									
								else
									Points = 2* (trim(rsKeyRec2("odibatavg")) * trim(runpoints)) + (trim(xodiwkts) * trim(wicketpoints)) + (trim(xrsodi4) * trim(boundrypoints))+ (trim(xrsodi6) * trim(sixerpoints)) + (trim(xodicatches) * trim(catchpoints))									
								end if

								TotalPoints=TotalPoints+Points
							end If
						
				   %>
                          <tr>
                            <td><%=rsKeyRec2("playername")%> <%if rsKeyRec2("ccaptainyn")="Y" then%>***<%end if%></td>
        					<td align="center"><%=trim(rsKeyRec2("odibatavg")) * trim(runpoints)%></td>
        					<td align="center"><%=xodiwkts * trim(wicketpoints)%></td>
        					<td align="center"><%=xrsodi4 * trim(boundrypoints) %></td>
        					<td align="center"><%=xrsodi6 * trim(sixerpoints)%></td>
        					<td align="center"><%=xodicatches * trim(catchpoints)%></td>                         
        					<td align="center"><%=trim(Points)%></td>      					
        					<td>&nbsp;</td>
        					<td>&nbsp;</td>
                          </tr>
                          
						  <%
							rsKeyRec2.Movenext
							I = I + 1
							Points=0
							Loop
						  %>
                          
                          <tr>
                            <td>Total Points</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><%=TotalPoints%></td>
                          </tr>
    				</table>
                 </td>
  			</tr>
		</table>
		<table width="950" align="center" class="header2">			
			<tr>
				<td align="left" height="30">Please note: this page is WIP :) </td>
			</tr>
				<tr>
					<td style="background: url('images/TOPHEAD.gif') repeat-x;">	
						<table width="98%" border="0" cellspacing="0" cellpadding="0" align="Center">				
							<tr>
								<td align="left" height="30"></td>
							</tr>				
						</table>
					</td>
				</tr>
				<tr><td align="Right" class="text">&copy 2011 All Rights Reserved.</td></tr>			
			</table>	
</tr>
</table>



</body>
</html>
