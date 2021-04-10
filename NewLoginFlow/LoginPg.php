<!DOCTYPE html>
<html>

<head>
    <title>Log In</title>

    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .form-signin {
            width: 100%;
            max-width: 60%;
            padding: 10px 20px 40px 20px;
            margin:2% auto ;
            border-radius: 15px;
        }
        .steps{
            margin: 15% 10% auto;
            padding: 2%;
            width: 80%;
        }
        .steps-font li{
            font-size:16px;
        }
    </style>
</head>

<body class="">
    <div class="row m-0">
        <div class="col-12 col-lg-6 col-xl-6 text-center">
            <h1 class="mt-5 text-danger">
                <small> Welcome to</small> <br>
                <strong><em>Fantasy League Cricket - NEW </em></strong>
            </h1>
            <p><strong class="text-success">
                  Create your own league, with your own rules, play with your own friends,family, office colleagues .. play your own IPL
        </strong></p>
                    <form name="frmlogin" class="form-signin bg-primary" action="LoginPg.php" method="post" >
                <h1 class="h3 mb-3 font-weight-normal text-center text-white">
                    <strong class="text-uppercase">Log In</strong>
                </h1>
                <input type="text" name="username" class="form-control mb-2" placeholder="Login/E-mail" required="">
                <input type="password" name="pass" class="form-control mb-2" placeholder="Password" required="">
                <div class="text-center">
                    <input type="submit" name="signin" class="btn btn-success w-100" value="SIGN IN">
                </div>
                <p class="mb-0 mt-3 text-white"> <u>Don't have an account?</u>
                <a href="teamlogin.php" class="text-danger"> <strong> Register </strong></a></p>
            </form>
            <p class="mb-0 mt-3 text-white"> <u>your leagues</u>
            <? foreach ($leaguename_array as $yourleaguename) { ?>
                          <a href="teamLandingPg.php?leaguename=<? echo $yourleaguename ?>" class="text-danger"> <strong> <? echo $yourleaguename ?> </strong></a></p>
            <? }?>
        </div>
      </div>
</body>

</html>
<?
require_once "../userFunction.php";
echo "calling fun" ;
$username=$_POST['username'];
$pwd=$_POST['password'];
$leaguename_array=[];
      if(array_key_exists('signin', $_POST)) {
        $retmsg=findUserExists($username);
        echo "done check";
        $leaguename_array=allLeaguesForUser($username);
        foreach ($leaguename_array as $value) {
          echo $value;
        }
      }

//      function signin() { echo "This is signin that is selected";}

?>
