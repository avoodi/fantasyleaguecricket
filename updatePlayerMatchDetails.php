<html>
  <head>
    <title>Hello</title>
  </head>
  <body>

<?php

require_once 'connect_db_forcricapi.php';
//require_once 'testconn.php';
require_once 'testconn.php';
require_once 'save_fielding_data.php';
require_once 'save_bowling_data.php';
require_once 'save_batting_data.php';
require_once 'fetch_and_save_player_data.php';


function run($match_uniq_id){
	$conn = connect_db();
	$match_summary_base_url = "http://cricapi.com/api/fantasySummary?&apikey=wEjKd5SIYLgDkKGUlW3LjXk66hE3";
	$match_summary_api_url = $match_summary_base_url."&unique_id=".$match_uniq_id;
	echo $match_summary_api_url."</br>";
	$cricketMatchDetails = file_get_contents($match_summary_api_url);
	$cricketMatchDetailsJson = json_decode($cricketMatchDetails, true);
	$data = $cricketMatchDetailsJson["data"];
	$fielding_data = $data["fielding"];
	$bowling_data = $data["bowling"];
	$batting_data = $data["batting"];
	$man_of_the_match_id = $data["man-of-the-match"]["pid"];

	$teams_and_players = $data["team"];
  echo "decode done "."</br>";
	extract_and_save_players_data($conn, $teams_and_players, $match_uniq_id);
	echo "player records inserted.";
	extract_and_save_fielding_data($conn, $fielding_data, $man_of_the_match_id, $match_uniq_id);
	extract_and_save_bowling_data($conn, $bowling_data, $man_of_the_match_id, $match_uniq_id);
	extract_and_save_batting_data($conn, $batting_data, $man_of_the_match_id, $match_uniq_id);

}

?>
</body>
</html>
