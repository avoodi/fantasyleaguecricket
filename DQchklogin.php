#!/usr/bin/php
<?
include "dbConnect.php";
global $conn;
        session_start();
        $_SESSION['uname']=$_POST['uname'];
        $_SESSION['pwd']=$_POST['pass'];
        $_SESSION['groupname']=$_POST['groupname'];
        $_SESSION['grouppwd']=$_POST['grouppwd'];

    $uname=$_SESSION['uname'];
    $pwd=$_SESSION['pwd'];
    $groupname=$_SESSION['groupname'];
    $grouppwd=$_SESSION['grouppwd'];

    $isPresent=0;
//echo $uname . " " .$pwd . " " .$groupname. " ". $grouppwd."</br>";

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql="SELECT teamname  FROM leagueteamsdetails WHERE leaguename= '$groupname' and teamname='$uname' and team_password='$pwd' ANd teamowneremail='$grouppwd' ";
//echo $sql ;

$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
//  echo " here in fetch" ;
  $uname=$row[0];
  $isPresent=1;
}

if ($isPresent ==1) {

  date_default_timezone_set('Asia/Kolkata');
  $today=date("z"); //if we put draws before the tournament actual start date(testing) then we need to add that many days to this count
  $startofIPL = 81; // ipl started on 23rd mar  so 82nd day of the year
  $iplday = ($today-$startofIPL)+1;
  $endofIPL =125; // the ipl league matches end on 5th may2018 which is 125th day
  $daysforOurLeague=$endofIPL-$today;
  //echo "and diff is ". $startofOurLeague . "and " . $daysforOurLeague ." </br>";

  $iplmatchnum=$startofOurLeague;
  $_SESSION['iplday']=$iplday;

  echo '<script type="text/javascript">
             window.location = "./DQLandingPg.php"
        </script>';
}

if ($isPresent ==0){
  echo "something  is wrong, either username, password or leaguename "; // need to fix this
  echo '<script language=javascript">';
  echo  'alert("sorry username or password or leaguename is not correct")';
  echo ' window.location = "./DailyQLogin.php" ';
  echo ' </script>';
}
mysqli_free_result($result);

?>
