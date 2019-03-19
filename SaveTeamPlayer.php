<?
// we just need to insert the selected players in selected players table ; by first deleted what was inserted for
// that team , league , iplday
session_start();
$leaguename=$_SESSION['leaguename'];
$teamname=$_SESSION['teamname'];
$iplday=$_POST[iplday];
$selectedcount=0;
//echo "ipl day is ".$iplday;
//$selectedplayers=$_POST['chkSelGroup'];
include "dbConnect.php";
global $conn;

// Create connection
//$conn = mysqli_connect($servername, $dbusername, $dbpassword,$dbname);
// Check connection
if ($conn == false) {
  echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
}

if(!empty($_POST)) {
   if(count($_POST['chkSelGroup']) > 0 && !empty($_POST['chkSelGroup'][0])) {
       foreach($_POST['chkSelGroup'] as $key => $checked) {
          $id = $_POST['chkSelGroup'][$key];
  //        echo "id is ".$id." and key ".$key ."</br>";
          $pid[$selectedcount]=$id;
            $sql1="select playername from playermst where pid=$pid[$selectedcount]";
            $result = mysqli_query($conn,$sql1) ;
            while( $row = mysqli_fetch_array( $result ) )
            {
             $playername[$selectedcount]=$row[0];
            }
            mysqli_free_result($result);

          $selectedcount++;
          // rest of the data and processings
       }
   }
}
//echo $selectedplayers;
if(isset($_POST['iscaptain']))
{
echo "You have selected :<b> ".$_POST['iscaptain']."</br>";
$captainPID=$_POST['iscaptain'];
}

$sql="select count(*) from selectedplayers where leaguename='$leaguename' and ownerteam='$teamname' and iplday=$iplday" ;
//echo $sql ."</br>";
$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
 $count=$row[0];
}
mysqli_free_result($result);

if($count >0 ) {
  // we will need to delete the existing rows
//echo " in delete ";
  $sqldel="delete from selectedplayers where leaguename='$leaguename' and ownerteam='$teamname' and iplday=$iplday" ;
  if(! mysqli_query($conn,$sqldel) )
    {
      die('error sqldel');
    }
}

//$countofselected=  count($selectedplayers);
if($selectedcount >0) {
//echo "selected is ".$selectedcount ." </br>";
  for ($i=0; $i<$selectedcount; $i++) {
  //    echo " in loop ".$pid[$i] . "and ".$captainPID."</br>";
      if($pid[$i]==$captainPID){
        $sqlins="insert into selectedplayers (pid,playername,leaguename,ownerteam,iplday,leaguematchnum,iscaptain) values ($pid[$i],'','$leaguename','$teamname',$iplday,1,'Y')";
      }
      else {
        $sqlins="insert into selectedplayers (pid,playername,leaguename,ownerteam,iplday,leaguematchnum,iscaptain) values ($pid[$i],'','$leaguename','$teamname',$iplday,1,'N')";
      }
//echo $sqlins."</br>";
    if(! mysqli_query($conn,$sqlins) )
      {
        die('error sqlins');
      }

  }
}
echo '<script type="text/javascript">
           window.location = "./teamLandingPg.php"
      </script>';
?>
