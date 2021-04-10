<!DOCTYPE html>
<html>

<head>
    <title>Log In</title>

    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

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
                <strong><em>Fantasy League Cricket - Daily Predictions Game </em></strong>
            </h1>
            <p><strong class="text-success">
                  Play with your own friends,family,office colleagues, see who is better at predictions in your social group ..
        </strong></p>
            <form name="frmlogin" class="form-signin bg-primary" action="DQchklogin.php?action=check" method="post" onSubmit="return validLogin();">
                <h1 class="h3 mb-3 font-weight-normal text-center text-white">
                    <strong class="text-uppercase">Log In</strong>
                </h1>
                <input type="text" name="username" class="form-control mb-2" placeholder="Login/E-mail" required="">
                <input type="password" name="pass" class="form-control mb-2" placeholder="Password" required="">
                <input type="text" name="groupname" class="form-control mb-2" placeholder="Group name" required="">
                <div class="text-center">
                    <input type="submit" class="btn btn-success w-100" value="SIGN IN">
                </div>
                <p class="mb-0 mt-3 text-white"> <u>Don't have an account?</u>
                <a href="DQteamlogin.php" class="text-danger"> <strong> Register </strong></a></p>
            </form>

        </div>
        <div class="col-12 col-lg-6 col-xl-6">
            <div class="row m-0">
                <div class="flex steps rounded bg-primary">
                    <h5 class="text-white"> <strong> <u> Simple steps - </u></strong> </h5>
                    <ul class="steps-font text-white">
                        <li>(Someone) creates a Group</li>
                        <li> Friends/family/colleague join that Group</li>
                        <li> Everyday before match starts , 3 questions are to be answered </li>
                        <li> Points are earned for each correct answer and leaderboard shows where you are compared to other members in the group</li>
                        <li> Try and top the leaderboard , simple..</li>
                        <li> People who dont start on day one start with lowest average points  </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</body>

</html>
