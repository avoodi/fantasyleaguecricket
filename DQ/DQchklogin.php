#!/usr/bin/php
<?
  session_start();
  include "dbConnect.php";
  global $conn;

        $_SESSION['uname']=$_POST['username'];
        $_SESSION['pwd']=$_POST['pass'];
        $_SESSION['groupname']=$_POST['groupname'];
        $_SESSION['grouppwd']=$_POST['grouppwd'];

    $uname=$_SESSION['uname'];
    $pwd=$_SESSION['pwd'];
    $groupname=$_SESSION['groupname'];
    $grouppwd=$_SESSION['grouppwd'];

    $isPresent=0;
    //echo "in chck login " . $uname . " " .$pwd . " " .$groupname. "</br>";

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql="SELECT teamname  FROM leagueteamsdetails WHERE leaguename= '$groupname' and teamname='$uname' and team_password='$pwd' ANd teamowneremail='$grouppwd' ";
//removing group password
//$sql="SELECT teamname  FROM leagueteamsdetails WHERE leaguename= '$groupname' and teamname='$uname' and team_password='$pwd' ";

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
  $startofIPL = 98; // ipl started on 9th apr  so 99th day of the year
  $iplday = ($today-$startofIPL)+1;
  $endofIPL =143; // the ipl league matches end on may 23rd 2021 which is 143rd  day
  $daysforOurLeague=$endofIPL-$today;
  //echo "and diff is ". $startofOurLeague . "and " . $daysforOurLeague ." </br>";

  $iplmatchnum=$startofOurLeague;
  $_SESSION['iplday']=$iplday;
//  echo "before calling landing session vars are  " . $_SESSION['uname'] . " " .$_SESSION['pwd'] . " " .$_SESSION['groupname']."</br>";

  echo '<script type="text/javascript">
             window.location = "./DQLandingPg-New.php"
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
