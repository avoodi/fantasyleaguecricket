<?
//gets called when someone posts msg on wallPost

session_start();
$owneremail=$_SESSION['username']; //on login page we have user name field which is actually email entered at registration time
$leaguename=$_SESSION['leaguename'];
$pass=$_SESSION['pass'];
$teamname=$_SESSION['teamname'];
$teamownername=$_SESSION['teamownername'];
$iplday=$_SESSION['iplday'];
$post=$_POST['wallPost'];

$servername = "localhost:3306";
$dbusername = "fanta_avad";
$dbpassword = "FLeague@2018";
$dbname="fantas10_avad";
// Create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword,$dbname);
// Check connection
if ($conn == false) {
	echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
}

date_default_timezone_set('Asia/Kolkata');
$currtime=date('Y-m-d H:i:s');
$myrandnum=mt_rand(1,1000000);
$sql="insert into leaguewall (leaguename, teamname, post, posttime,postnum) values('$leaguename','$teamname','$post','$currtime',$myrandnum)";
//echo $sql;
if(! mysqli_query($conn,$sql) )
  {
    die('something went wrong - please press back button of browser');
  }
  echo '<script type="text/javascript">
             window.location = "./teamLandingPg.php"
        </script>';


?>
