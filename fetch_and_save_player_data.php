<html>
  <head>
    <title>fantasyleaguecricket</title>
  </head>
  <body>

<?php

function extract_and_save_players_data($conn, $teams, $matchid){
	foreach($teams as $team){
		$players=$team["players"];
		$team_name=$team["name"];
		foreach($players as $player){
			$pid=$player["pid"];
			$name=$player["name"];
			if(! record_exists("pid", $pid, $conn, "players")){
				insert_new_player_record($conn, $pid, $name);
			}
		}
	}
}

function insert_new_player_record($conn, $pid, $name){
	$query="insert into players(pid, playername) values('$pid', '$name');";
	execute_query($conn,  $query);
}

?>
</body>
</html>
