<?
	session_start();
		include "dbConnect.php";
		global $conn;

		$uname=$_SESSION['uname'];
		$pwd=$_SESSION['pwd'];
		$groupname=$_SESSION['groupname'];
		//$grouppwd=$_SESSION['grouppwd'];
	//	echo " in landing pg ". $groupname ." and " . $uname . "\n";
		// Check connection
		if ($conn == false) {
			echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
		}
		// select from leaguedraw all matches only for this team
		$count=0;
		$sql="select question, qId, qPoints from DQMaster where groupname='$groupname'";
		//echo $sql ;
		$result = mysqli_query($conn,$sql) ;
		while( $row = mysqli_fetch_array( $result ) )
		{
			$question[$count]=$row[0];
			$qId[$count]=$row[1];
			$qPoints[$count]=$row[2];
			$count++;
		}
		mysqli_free_result($result);

		date_default_timezone_set('Asia/Kolkata');
		$today=date("z"); //if we put draws before the tournament actual start date(testing) then we need to add that many days to this count
		$startofIPL = 98; // ipl started on 9th apr so 99th day of the year
		$iplday = ($today-$startofIPL)+1;
		$currentHr=date('H');
		//echo $iplday;
		 $teams=[];
		 $team2=[];
		$matches=0;
		$teamCount=0;
		$sql= "select team1,team2, matchstr from iplschedule where iplday=$iplday";
 //echo $sql;
		$result = mysqli_query($conn,$sql) ;
		while( $row = mysqli_fetch_array( $result ) )
		{
			$teams[$teamCount]=$row[0];
			$teamCount++;
			$teams[$teamCount]=$row[1];
			$teamCount++;
			$matchstr[$matches]=$row[2];
			$matches++;
		}
		mysqli_free_result($result);

		$canSubmit='Y';
		if (($matches==1 && $currentHr >=20 ) OR ($matches==2 && $currentHr >=16)) { // ondays when ony 1 match is played 8pm is start,so check with 20
			$canSubmit='N';
		}

		$sql= "select sum(score) from DQanswersdetails where groupname='$groupname' and username='$uname' ";
		$result = mysqli_query($conn,$sql) ;
		while( $row = mysqli_fetch_array( $result ) )
		{
			$myScore=$row[0];
		}
		mysqli_free_result($result);

		$i=1;
		$alreadyAnswered='N';
		$sql="select  result from DQanswersdetails where groupname='$groupname' and username='$uname' and iplday=$iplday" ;
		$result=mysqli_query($conn,$sql) ;
		while ($row=mysqli_fetch_array( $result ) )
		{
			$myCurrentAnswers[$i]=$row[0];
			$alreadyAnswered='Y';
			$i++;
		}
		mysqli_free_result($result);

		$i=1;
		$otherqId=array();
		$sql="select qId, result from DQanswersdetails where groupname='$groupname' and iplday=$iplday and username not in ('$uname')" ;
		$result=mysqli_query($conn,$sql) ;
		while ($row=mysqli_fetch_array( $result ) )
		{
			$otherqId[$i]=$row[0];
			if(array_key_exists($row[0],$otherAnswers)) {
					$otherAnswers[$row[0]]=$otherAnswers[$row[0]].";".$row[1];
			}
			else {
				$otherAnswers[$row[0]]=$row[1];
			}
			$i++;
		}


		$playercount=0;
		$playerTeam1=[];
		$playerTeam2=[];
		$playerTeam3=[];
		$playerTeam4=[];
		$allPlayersMatch1=[];
		$allPlayersMatch2=[];
		$allPlayersCountMach1=0;
		$allPlayersCountMach2=0;

		$sql="select playername from playermst where iplteam='$teams[0]'";
	//	echo $sql;
		$result = mysqli_query($conn,$sql) ;
		while( $row = mysqli_fetch_array( $result ) )
		{
			$playerTeam1[$playercount]=$row[0];
			$playercount++;
			$allPlayersMatch1[$allPlayersCountMach1]=$row[0];
//			echo " player num is " . $allPlayersCountMach1 . " is ". $allPlayersMatch1[$allPlayersCountMach1]. "<br>";
			$allPlayersCountMach1++;
		}
		mysqli_free_result($result);

		$playercount=0;
		$sql="select playername from playermst where iplteam='$teams[1]'";
	//	echo $sql;
		$result = mysqli_query($conn,$sql) ;
		while( $row = mysqli_fetch_array( $result ) )
		{
			$playerTeam2[$playercount]=$row[0];
			$playercount++;
			$allPlayersMatch1[$allPlayersCountMach1]=$row[0];
//			echo " player num is " . $allPlayersCountMach1 . " is ". $allPlayersMatch1[$allPlayersCountMach1]. "<br>";
			$allPlayersCountMach1++;
		}
		mysqli_free_result($result);

		if ($matches==2) {
				$playercount=0;
				$sql="select playername from playermst where iplteam='$teams[2]'";
		//		echo $sql;
				$result = mysqli_query($conn,$sql) ;
				while( $row = mysqli_fetch_array( $result ) )
				{
					$playerTeam3[$playercount]=$row[0];
					$playercount++;
					$allPlayersMatch2[$allPlayersCountMach2]=$row[0];
//					echo " player num is " . $allPlayersCountMach2 . " is ". $allPlayersMatch2[$allPlayersCountMach2]. "<br>";
					$allPlayersCountMach2++;
				}
				mysqli_free_result($result);

				$playercount=0;
				$sql="select playername from playermst where iplteam='$teams[3]'";
//				echo $sql;
				$result = mysqli_query($conn,$sql) ;
				while( $row = mysqli_fetch_array( $result ) )
				{
					$playerTeam4[$playercount]=$row[0];
					$playercount++;
					$allPlayersMatch2[$allPlayersCountMach2]=$row[0];
//					echo " player num is " . $allPlayersCountMach2 . " is ". $allPlayersMatch2[$allPlayersCountMach2]. "<br>";
					$allPlayersCountMach2++;
				}
				mysqli_free_result($result);
	}

?>

<html>

<head>
	<title>Daily Question</title>
	<link rel="icon" href="assets/dist/img/favicon.ico" type="image/ico" sizes="16x16">
	<link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/dist/css/style.css" rel="stylesheet">
	<link href="assets/dist/css/colors.css" rel="stylesheet">
</head>

<body class="bg-fantasy">
		<!-- Navigation -->
		<?php include 'DQnavbar.php';?>

		<div class="container bg-white p-3 pt-1 ">
	<!-- Section -->
	<div class="row">
		<div class="col-lg-12 col-12 mb-1">
			<h5 class="w-100 text-center text-danger text-uppercase">Your Daily Questions Home Page</h5>
		</div>

		<div class="col-lg-3 col-3 mb-4">
			<div class="card h-100 bg-danger">
				<h6 class="card-header text-white display">Welcome</h6>
				<div class="card-footer text-right">
				<span class="badge bg-white">
					<? echo $uname; ?></span>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-3 mb-4">
			<div class="card h-100 bg-warning">
				<h6 class="card-header text-white display">Your Group Name</h6>
				<div class="card-footer text-right">
				<span class="badge bg-white">
					<? echo $groupname; ?></span>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-3 mb-4">
			<div class="card h-100 bg-primary">
				<h6 class="card-header text-white display">Your Total Score</h6>
				<div class="card-footer text-right">
					<span class="badge bg-white">
					<?echo $myScore; ?></span>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-3 mb-4">
			<div class="card h-100 bg-success">
				<div class="card-footer text-right">
					<h6 class="card-header text-white display">Todays First Match</h6>
					<span class="badge bg-white">
						<? echo $teams[0] ; ?> vs
						<?echo $teams[1] ;?>
					</span>
				</div>

				<? if ($teams[2]) { ?>
					<div class="card-footer text-right">
					<h6 class="card-header text-white display">Todays Second Match</h6>
													<span class="badge bg-white"><? if ($teams[2]) {echo $teams[2] ;} ?> vs <? if ($teams[2]) {echo $teams[3] ;}?></span>
										<? } ?>
					</div>
			</div>
		</div>
	</div>
		<!-- /.row -->

		<div class="row">
			<div class="col-lg-12 col-12 mb-1 text-center">
				<button type="button" class="btn btn-xs btn-success " onClick="Javascript:window.location.href = 'DQpointstable.php';">Leaderboard for your group</button>
			</div>
		</div>

		<div class="row p-3 mb-2 text-center">
			<form name='getanswers' method='POST' action='DQSaveAnswers.php/' onsubmit="valid()">
				<h5 class="w-100 text-danger text-capitalize">Here are todays questions</h5>
				<table id="table" class="table table-sm table-light table-bordered border-danger text-center">
					<thead class="bg-fantasy text-danger" style="font-size:small">
						<tr>
							<th>Question</th>
							<th>Your Answer</th>
							<th>Points if you get it right</th>
							<th>Look What others think</th>
						</tr>
					</thead>

					<tbody>
						<tr>
									<td >
										<?echo $question[0] ;?>
									</td>
									<td ><select name="myAnswer[]" id="myAnswer[]"> <option value="">--- Select ---</option>
										<? for($temp=0; $temp<2; $temp++) { ?>
										<option value="<? echo $teams[$temp]; ?>"<? if($teams[$temp]==$myCurrentAnswers[1]){ echo "selected"; } ?>>
																					<?echo $teams[$temp];?>
										 </option>
									 <? } ?>
								 </select>
									<td >
										<?echo $qPoints[0] ;?>
									</td>
									<td > <!-- need to check this 4/10 should this be $i+1 or just 0+1?  -->
										<?echo $otherAnswers[$i+1]; ?>
									</td>
									<td> <input type="hidden" name="qId[]" value="<?echo $qId[0];?>"> </td>
									<td> <input type="hidden" name="question[]" value="<?echo $question[0];?>"> </td>
						</tr>
						<tr>
									<td >
										<?echo $question[1] ;?>
									</td>
									<td><select name="myAnswer[]"  id="myAnswer[]"> <option value="">---Select---</option>
										<? for ($temp=0; $temp<=$allPlayersCountMach1; $temp++) { ?>
												<option value="<? echo $allPlayersMatch1[$temp]; ?>"<? if($allPlayersMatch1[$temp]==$myCurrentAnswers[2]){echo "selected";}?>>
															<?echo $allPlayersMatch1[$temp];?>
												</option>
										<? } ?>
									</select>
									<td >
											<?echo $qPoints[1] ;?>
									</td>
									<td > <!-- need to check this 4/10 should this be $i+1 or just 0+1?  -->
											<?echo $otherAnswers[$i+1]; ?>
									</td>
									<td> <input type="hidden" name="qId[]" value="<?echo $qId[1];?>"> </td>
									<td> <input type="hidden" name="question[]" value="<?echo $question[1];?>"> </td>
							</tr>
							<tr>
								<td >
									<?echo $question[2] ;?>
								</td>
								<td >
								<input type="text" name="myAnswer[]" class=" form-control" id="myAnswer[]" value="<?echo $myCurrentAnswers[3];?>"> </td>
								<td >
									<?echo $qPoints[2] ;?>
								</td>
								<td ><!-- need to check this 4/10 should this be $i+1 or just 0+1?  -->
									<?echo $otherAnswers[$i+1]; ?>
								</td>
								<td> <input type="hidden" name="qId[]" value="<?echo $qId[2];?>"> </td>
								<td> <input type="hidden" name="question[]" value="<?echo $question[2];?>"> </td>
							</tr>


						<? if ($matches >=2) {  ?>
						<tr>
							<td align="CENTER" bgcolor="ff22hh" colspan="3">Second Match (ignore if there is only 1 match today)</td>
						</tr>
						<tr>
									<td >
										<?echo $question[3] ;?>
									</td>
									<td ><select name="myAnswer[]" id="myAnswer[]"> <option value="">--- Select ---</option>
										<? for($temp=2; $temp<4; $temp++) { ?>
										<option value="<? echo $teams[$temp]; ?>"<? if($teams[$temp]==$myCurrentAnswers[4]){ echo "selected"; } ?>>
																					<?echo $teams[$temp];?>
										 </option>
									 <? } ?>
								 </select>
									<td >
										<?echo $qPoints[3] ;?>
									</td>
									<td > <!-- need to check this 4/10 should this be $i+1 or just 0+1?  -->
										<?echo $otherAnswers[$i+1]; ?>
									</td>
									<td> <input type="hidden" name="qId[]" value="<?echo $qId[3];?>"> </td>
									<td> <input type="hidden" name="question[]" value="<?echo $question[3];?>"> </td>
						</tr>
						<tr>
									<td >
										<?echo $question[4] ;?>
									</td>
									<td><select name="myAnswer[]"  id="myAnswer[]"> <option value="">---Select---</option>
										<? for ($temp=0; $temp<=$allPlayersCountMach2; $temp++) { ?>
												<option value="<? echo $allPlayersMatch2[$temp]; ?>"<? if($allPlayersMatch2[$temp]==$myCurrentAnswers[5]){echo "selected";}?>>
															<?echo $allPlayersMatch2[$temp];?>
												</option>
										<? } ?>
									</select>
									<td >
											<?echo $qPoints[4] ;?>
									</td>
									<td > <!-- need to check this 4/10 should this be $i+1 or just 0+1?  -->
											<?echo $otherAnswers[$i+1]; ?>
									</td>
									<td> <input type="hidden" name="qId[]" value="<?echo $qId[4];?>"> </td>
									<td> <input type="hidden" name="question[]" value="<?echo $question[4];?>"> </td>
							</tr>
							<tr>
								<td >
									<?echo $question[5] ;?>
								</td>
								<td >
								<input type="text" name="myAnswer[]" class=" form-control" id="myAnswer[]" value="<?echo $myCurrentAnswers[6];?>"> </td>
								<td >
									<?echo $qPoints[5] ;?>
								</td>
								<td ><!-- need to check this 4/10 should this be $i+1 or just 0+1?  -->
									<?echo $otherAnswers[$i+1]; ?>
								</td>
								<td> <input type="hidden" name="qId[]" value="<?echo $qId[5];?>"> </td>
								<td> <input type="hidden" name="question[]" value="<?echo $question[5];?>"> </td>
							</tr>
						<?} ?>

						<tr>
							<? if ($canSubmit=='Y') { ?>
								<td colspan="4" class="text-right">
									<input type="reset" class="btn btn-sm btn-light" value="Reset" name="B2">
									<input type="submit" class="btn btn-sm btn-success" value="Submit" name="B1">
								</td>
							<? } ?>
						</tr>
					</tbody>

				</table>
			</form>
		</div>


		</div>
		<!-- Footer -->
		<?php include 'footer.php'; ?>
		<!-- js -->

		<script type="text/javascript">
			$(document).ready(function() {
				$('#table').basictable();

				$('#table-breakpoint').basictable({
					breakpoint: 768
				});

				$('#table-swap-axis').basictable({
					swapAxis: true
				});

				$('#table-force-off').basictable({
					forceResponsive: false
				});

				$('#table-no-resize').basictable({
					noResize: true
				});

				$('#table-two-axis').basictable();

				$('#table-max-height').basictable({
					tableWrapper: true
				});
			});
		</script>
		<!-- Bootstrap core JavaScript -->
		<script src="assets/dist/js/jquery/jquery.min.js"></script>
		<script src="assets/dist/js/bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>
<script language="javascript">
	function valid() {
		var x = document.getanswers.myAnswer[1].value;
		var y = document.getanswers.myAnswer[2].value;
		var z = document.getanswers.myAnswer[3].value;
		var alertstring = " ur first answer " + x + "second is " + y + "third is " + z;
		alert(alertstring);

	}
</script>
