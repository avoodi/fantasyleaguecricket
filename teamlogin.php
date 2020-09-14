<?
//echo " in teamlogin page";
include "dbConnect.php";
global $conn;

if ($conn == false) {
	echo "Sorry, site is temporarily experiencing database connectivity issues; should be sorted soon, please check again in some time";
}

$sql="select leaguename from league_mst";

$result = mysqli_query($conn,$sql) ;
while( $row = mysqli_fetch_array( $result ) )
{
	$arr1[$i]=$row[0];
	$i=$i+1;
}

?>
<html>

<head>
	<title>Register Teams</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
          .form-register {
            width: 100%;
            max-width: 60%;
            padding: 10px 20px 40px 20px;
            margin:8% auto ;
            border-radius: 15px;
        }
        .steps{
            margin: 5% 10% auto;
            padding: 2%;
            width: 80%;
        }
        .steps-font li{
            font-size:16px;
        }
    </style>
</head>

<body onLoad="foc();" >
    <div class="row m-0">
    <div class="col-12 col-lg-6 col-xl-6">
            <div class="row m-0">
                <div class="row m-0 text-center">
                    <h1 class="mt-5 text-danger w-100"> 
                        <small> Welcome to</small> <br> 
                        <strong><em>Fantasy League Cricket </em></strong>
                    </h1>
                    <p class="w-100"><strong class="text-success">Create your own league, invite friends, play your own IPL</strong></p>
                    <p class="m-0">
                        <strong class="text-secondary">
                            <em> Enjoy IPL even more; Create your own league , 
                                with your own rules, play with your friends, family, office colleagues...
                            </em>
                        </strong>
                    </p>
                </div>
                <div class="flex steps rounded bg-primary">
                    <h5 class="text-white"> <strong> <u> Every new team needs to register - </u></strong> </h5>
                    <ul class="steps-font text-white">
                        <li>Join the league that is created by a person known to you:) if you join a league 'uninvited', the league creator can kick you out .. </li>
                        <li>if you are creating a new league just enter all the details , give your league a name and then pass on that league name to your friends/family/colleagues who you want to be part of your league</li>
                        <li>Login id : can be anything that you will use to login next time, giving email is better as important information about league can be communicated, we assure you of 0 spam emails</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-6">
            <Form name="frmreg" class="form-register bg-primary" method="post" action="teamregister.php">
                <h1 class="h3 mb-3 font-weight-normal text-center text-white">
                    <strong class="text-uppercase">Register</strong>
                </h1>
                <input type="text" name="teamname" class="form-control mt-2" placeholder="Team name" value="" size="30">
                <input type="text" name="OwnerName" class="form-control mt-2" placeholder="Owner name" value="" size="30">
                <input type="text" name="OwnerEmail" class="form-control mt-2" placeholder="Email" value="" size="30">
                <input type="Password" name="Pass" class="form-control mt-2" placeholder="Password" value="" size="30" maxlength="8">
                <hr class="border border-white">

                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="existingLeague" name="existingLeagueCheck" onClick="EnableDisControl(this);" >
                        <label class="form-check-label text-white" for="existingLeague">
                            Want to create a new league ?
                        </label>
                    </div>
                    <input type="text" name="leaguename" class="form-control mt-2" placeholder="League name" maxlength="30" value="" size="30">
                </div>
                
                <label for="" class="w-100 text-white">Want to join existing league?</label>
                <select class="form-control custom-select" name="selLeagueName">
                    <option>Select league</option>
                    <?
                    foreach($arr1 as $lname) {
                    ?>
                    <option value="<?= $lname ?>"><?= $lname ?></option>
                    <?
                    }
                    ?>
                </select>
                <div class="row text-center mt-3">
                    <div class="col-6 col-lg-6 col-xl-6 ">
                        <input type="button" value="Cancel" class="btn btn-danger w-100" name="Cancel" onClick="Refreshpage();"> 
                    </div>
                    <div class="col-6 col-lg-6 col-xl-6 ">
                        <input type="submit" value="Submit" class="btn btn-success w-100" name="submit">    
                    </div>
                    
                    
                </div>
            </Form>
        </div>
       
    </div>
</body>
</html>
<script language="JavaScript" type="text/JavaScript">
	function EnableDisControl(theField)
	{
		if(theField.checked == true)
		{
				document.frmreg.selLeagueName.disabled = true;
				document.frmreg.leaguename.disabled = false;
		}
        if(theField.checked == false){
            document.frmreg.selLeagueName.disabled = false;
            document.frmreg.leaguename.disabled = true;
        }
	}

    function foc() {
        document.frmreg.existingLeagueCheck.checked =true;
        document.frmreg.selLeagueName.disabled = true;
    }

	function DisSel(theField)
	{

	if(theField.name == "leaguename")
	{
			document.frmreg.selLeagueName.disabled = true;
			document.frmreg.ExistingLeague.disabled = true;
	}
	}
	function Refreshpage()
	{
		location.href="teamlogin.php";
	}
</script>
