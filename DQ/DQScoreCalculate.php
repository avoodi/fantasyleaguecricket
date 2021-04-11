<?

include "dbConnect.php";
global $conn;

date_default_timezone_set('Asia/Kolkata');
$today=date("z"); //if we put draws before the tournament actual start date(testing) then we need to add that many days to this count
$startofIPL = 98; // ipl started on 23rd mar  so 263rd day of the year ; sep 19th 2020
$iplday = ($today-$startofIPL)+1;

$groupCount=0;
$sql="select distinct(groupname) from DQMaster ";
echo $sql ;
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
  $groupnameArray[$groupCount]=$row[0];
  $groupCount++;
}
mysqli_free_result($result);

$count=0;
$sql="select qId, qPoints, groupname from DQMaster ";
echo $sql ;
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
  $qIdDQMaster[$count]=$row[0].$row[2];
  $qPointsDQMaster[$count]=$row[1];
  $groupnameDQMaster[$count]=$row[2];
  $count++;
}
mysqli_free_result($result);


$count=0;
$sql="select qId, iplday, answer from DQanswerMaster where iplday=$iplday-1"; // This is assuming we will run this the NEXT day of matches
echo $sql."</br>";
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
  $answerMqId[$count]=$row[0];
  $answermaster[$count]=$row[2];
  $count++;
}
mysqli_free_result($result);


for($count=0; $count<$groupCount; $count++) {
  $sql="select qId, username, result, ifnull(score,0) from DQanswersdetails where groupname='$groupnameArray[$count]' and iplday=$iplday-1";
  echo $sql."</br>";
  $ansCount=0;
  $result = mysqli_query($conn,$sql) ;
  while( $row = mysqli_fetch_array( $result ) )
  {
    $answerDqId[$ansCount]=$row[0];
    $uname[$ansCount]=$row[1];
    $youranswer[$ansCount]=$row[2];
    $score[$ansCount]=$row[3];
    $key=array_search($answerDqId[$ansCount],$answerMqId);
    $keypoints=array_search($answerDqId[$ansCount].$groupnameArray[$count],$qIdDQMaster);
    echo "the key is ". $key . " and the key point is ". $keypoints ."</br>";
    echo "the actual answer is ". $answermaster[$key] . "and your answer is ". $youranswer[$ansCount] ."and poins for this ans are ".$qPointsDQMaster[$keypoints]."</br>";

        if ( $answermaster[$key]==$youranswer[$ansCount] )
         {
           echo " you got the answer right so you get ".$qPointsDQMaster[$keypoints]." points </br>";
           $sqlUpdt="update DQanswersdetails set score=$qPointsDQMaster[$keypoints] where groupname='$groupnameArray[$count]' and iplday=$iplday-1 and qId=$answerDqId[$ansCount] and username='$uname[$ansCount]' ";
         }
        else {
          #the ans is not matching exactly, but for the sixer question we should check closest match and give points accordingly
          if($ansCount==2 || $ansCount==5){
            if(($youranswer[$ansCount] == $answermaster[$key]+1) ||($youranswer[$ansCount] == $answermaster[$key]-1) {
              #full points even for +/- 1
              echo " you got the answer +/-1 right so you get ".$qPointsDQMaster[$keypoints]." points </br>";
              $sqlUpdt="update DQanswersdetails set score=$qPointsDQMaster[$keypoints] where groupname='$groupnameArray[$count]' and iplday=$iplday-1 and qId=$answerDqId[$ansCount] and username='$uname[$ansCount]' ";
            }
            elseif(($youranswer[$ansCount] == $answermaster[$key]+2) ||($youranswer[$ansCount] == $answermaster[$key]-2) {
              #half points even for +/- 2
              echo " you got the answer +/-2 right so you get ".$qPointsDQMaster[$keypoints]/2." points </br>";
              $sqlUpdt="update DQanswersdetails set score=$qPointsDQMaster[$keypoints]/2 where groupname='$groupnameArray[$count]' and iplday=$iplday-1 and qId=$answerDqId[$ansCount] and username='$uname[$ansCount]' ";
            }
            else {
              $sqlUpdt="update DQanswersdetails set score=0 where groupname='$groupnameArray[$count]' and iplday=$iplday-1 and qId=$answerDqId[$ansCount] and username='$uname[$ansCount]' ";
              echo " your answer is incorrect </br>";
            }
          }
          else {
          $sqlUpdt="update DQanswersdetails set score=0 where groupname='$groupnameArray[$count]' and iplday=$iplday-1 and qId=$answerDqId[$ansCount] and username='$uname[$ansCount]' ";
          echo " your answer is incorrect </br>";
          }
        }

    echo $sqlUpdt ."</br>";
    if(!mysqli_query($conn,$sqlUpdt) )
      {
        die('error sqlupdate');
      }
    $ansCount++;
  }

}

?>
