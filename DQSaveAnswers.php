<?
include "dbConnect.php";
global $conn;

//echo " answer1 ".$_POST['myAnswer'][1];
//echo " answer2 ".$_POST['myAnswer'][2];
//echo " answer3 ".$_POST['myAnswer'][3];

//print_r($_POST['myAnswers']);

session_start();
$uname=$_SESSION['uname'];
$pwd=$_SESSION['pwd'];
$groupname=$_SESSION['groupname'];
$grouppwd=$_SESSION['grouppwd'];

//print_r($_POST);

//echo " and qid is ";
//print_r($qId);
$answers = array();
$qId = array();
$question = array();

$answers=$_POST['myAnswer'];
$question=$_POST['question'];
$qId=$_POST['qId'];
$size=sizeof($answers);
//echo " size is ".$size;
//foreach($answers as $key=>$v){
//  echo "for each answer ".$v;
//}
//echo "id are ";
//print_r($qId);
//echo "answers are ";
//print_r($answers);
//echo " and questions are ".print_r($question);


//$answer1=$_POST['myAnswer1'];
//$answer2=$_POST['myAnswer2'];
//$answer3=$_POST['myAnswer3'];
//echo " answers ". $answer1." and ".$answer2. " and ".$answer3;

$recordExists='N';

date_default_timezone_set('Asia/Kolkata');
$today=date("z"); //if we put draws before the tournament actual start date(testing) then we need to add that many days to this count
$startofIPL = 81; // ipl started on 23rd mar  so 82nd day of the year
$iplday = ($today-$startofIPL)+1;
//echo "in save " .$iplday;

$sql="select result,qId from DQanswersdetails where groupname='$groupname' and iplday='$iplday' and username='$uname'";
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
$recordExists='Y';
}

mysqli_free_result($result);
$counter=0;

if($recordExists=='Y') {
  for ($counter=0; $counter<sizeof($answers); $counter++) {
  $sqlUpdt="update DQanswersdetails set result='$answers[$counter]', iplday=$iplday where username='$uname' and groupname='$groupname' and qId=$qId[$counter] and iplday=$iplday";
//  echo $sqlUpdt;
  if(!mysqli_query($conn,$sqlUpdt) )
    {
      die('error sqlupdate');
    }
  }
}

if($recordExists=='N'){
  for ($counter=0; $counter<sizeof($answers); $counter++) {
    $sql="insert into DQanswersdetails (qId,username,groupname,result,iplday) values($qId[$counter],'$uname','$groupname','$answers[$counter]',$iplday)";
    //echo $sql;
    if(!mysqli_query($conn,$sql) )
      {
        die('error sqlins');
      }
  //  echo "anwer #".$counter.": ".$answers[$counter]."<br />";
  }
}
echo '<script type="text/javascript">
     window.alert("your changes have been saved");
           window.location.href = "/DQLandingPg.php";
        </script>';

?>
