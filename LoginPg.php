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
                <strong><em>Fantasy League Cricket </em></strong>
            </h1>
            <p><strong class="text-success">
                  Create your own league, with your own rules, play with your own friends,family, office colleagues .. play your own IPL
            <!--p><strong class="text-success">Create your own league, invite friends, play your own IPL
            !-->
        </strong></p>
          <!--  <p class="m-0">
                <strong class="text-secondary">
                    <em> Enjoy IPL even more; Create your own league ,
                        with your own rules, play with your friends, family, office colleagues...
                    </em>

                </strong>
            </p>
          !-->
            <form name="frmlogin" class="form-signin bg-primary" action="chklogin.php?action=check" method="post" onSubmit="return validLogin();">
                <h1 class="h3 mb-3 font-weight-normal text-center text-white">
                    <strong class="text-uppercase">Log In</strong>
                </h1>
                <input type="text" name="username" class="form-control mb-2" placeholder="Login/E-mail" required="">
                <input type="password" name="pass" class="form-control mb-2" placeholder="Password" required="">
                <input type="text" name="leaguename" class="form-control mb-2" placeholder="League name" required="">
                <div class="text-center">
                    <input type="submit" class="btn btn-success w-100" value="SIGN IN">
                </div>
                <p class="mb-0 mt-3 text-white"> <u>Don't have an account?</u>
                <a href="teamlogin.php" class="text-danger"> <strong> Register </strong></a></p>
            </form>

        </div>
        <div class="col-12 col-lg-6 col-xl-6">
            <div class="row m-0">
                <div class="flex steps rounded bg-primary">
                    <h5 class="text-white"> <strong> <u> Simple steps - </u></strong> </h5>
                    <ul class="steps-font text-white">
                        <li>(Someone) creates a league</li>
                        <li>Friends/family/colleague join that league</li>
                        <li> To acquire players, League decides to go for bidding process(optional, but lot of fun) OR can opt for ‘random allocation’ of players to every team in your league</li>
                        <li>The league creator puts up the draw(schedule of league matches), all of this with just click of button</li>
                        <li>With above steps league is on its way; after that Teams select players,captain based on actual IPL match (can be done in one go for all future matches)</li>
                        <li>Every team has one-one match with some other team everyday, earns points based on how players performed in actual IPL match</li>
                        <li>Winner/looser, league standing gets decided based on total points</li>
                        <li>Buy, sell players if required - Try it its lot of fun</li>
                        <li>Check this <a href="https://youtu.be/FfUGnFRNtR0" class="text-danger" target="_blank"><strong>video </strong></a> to know more or read this<a href="https://medium.com/@avoodi/owning-an-ipl-team-virtually-9b239801e9bb" class="text-danger" target="_blank"> <strong>blog</strong> </a> to know more</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</body>

</html>
