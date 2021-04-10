<html>
<head>

	</head>
<body leftmargin="0" topmargin="0">
<?
$i=7;

$arr1[1]='t1';
$arr1[2]='t2';
$arr1[3]='t3';
$arr1[4]='t4';
$arr1[5]='t5';
$arr1[6]='t6';
//$arr1[7]='t7';

$arr2[1]='t1';
$arr2[2]='t2';
$arr2[3]='t3';
$arr2[4]='t4';
$arr2[5]='t5';
$arr2[6]='t6';
//$arr2[7]='t7';

$today=date("j m");

echo $today;
/*
echo "count is ". $i ;
if ($i%2 >0) {
	// add one element to both arrays
	$arr1[$i+1]='bye';
	$arr2[$i+1]='bye';
	$i++;
}

echo " NOW count is ". $i ;
$j=1;

//echo "now count is ". $j;
//foreach($arr2 as $team){
//	echo "fromarray2 " . $team . "</br>";
//
}
*/
$totalRows=$i;
$reverseCnt=$totalRows;
$days=14;

echo "tota rows " . $totalRows . "revers is " . $reverseCnt ." </br>";

for ($cnt=1; $cnt<=$days ;$cnt++ ) {
  $reverseCnt=$totalRows;
  for ($cnt2=1 ; $cnt2<=$totalRows/2; $cnt2++) {
         echo $arr1[$cnt2] ." vs " . $arr2[$reverseCnt] ." at " . $cnt ."</br>"  ;
				 /* very important ipmmatchnum needs to be set to the actual ipm match number when this
				 prog is going to be executed for this league ; which means the start of the number could be diff for each league */
				// $sql3= "insert into leaguedraw(leaguename, iplmatchnum, ourmatchnum, team1name, team2name)
				 	//			values('$leaguename',$cnt,$cnt,'$arr1[$cnt2]', '$arr2[$reverseCnt]' )" ;
					//echo $sql3;
					//if(! sqlsrv_query($conn,$sql3) )
					//	{
					//		die('error sql3');
					//	}
//					$result = sqlsrv_query($conn,$sql3) ;
         $reverseCnt--;
  }
  echo "\n";
	/*reshuffle array1 */
  $tmp= $arr1[1];
  $tmp2= $arr2[1];
  for ($reshuffle=1; $reshuffle<=$totalRows ; $reshuffle++){
    $arr1[$reshuffle] = $arr1[$reshuffle+1];
    $arr2[$reshuffle] = $arr2[$reshuffle+1];
  }
  $arr1[$totalRows] =$tmp;
  $arr2[$totalRows] =$tmp2;
}
sqlsrv_close($conn);
*/
?>
