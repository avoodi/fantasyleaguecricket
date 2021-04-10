#!/usr/bin/php
<?
require_once "userFunction.php";
global $conn;
        session_start();
        $_SESSION['username']=$_POST['username'];
        $_SESSION['pwd']=$_POST['pass'];
    $username=$_SESSION['username'];
    $pwd=$_SESSION['pwd'];
    $isPresent=0;
    $leaguename_array=[];

    $isUserCorrect=findUserExists($username);
        echo "done check";

    $isUserPwdCorrect=isUserIdPwdCorrect($username);
            echo "done check";

    $leaguename_array=allLeaguesForUser($username);
        foreach ($leaguename_array as $value) { echo $value;  }

    $_SESSION['yourleaguename']=$leaguename_array;

    if ($isUserCorrect== "User Does Not Exist"){
      echo "Looks like user name is incorrect "; // need to fix this
      echo '<script language=javascript">';
      echo  'alert("Looks like you entered incorrect username")';
      echo ' window.location = "./LoginPg.php" ';
      echo ' </script>';
    }
    if ($isUserPwdCorrect== "Userid and pwd combination Not matching. Pl Retry / contact us"){
      echo "Looks like user id and password is incorrect "; // need to fix this
      echo '<script language=javascript">';
      echo  'alert("Looks like you entered incorrect username and password combination, pl retry / contact us")';
      echo ' window.location = "./LoginPg.php" ';
      echo ' </script>';
    }


  date_default_timezone_set('Asia/Kolkata');
  $today=date("z");
  $startofIPL = 99; // ipl started on 9th apr so 96th day of the year
  $iplday = ($today-$startofIPL)+1;
  $_SESSION['iplday']=$iplday;
  // call the dummy page here
  echo '<script type="text/javascript">
             window.location = "./DummyteamLandingPg.php"
        </script>';
}


?>
