<?php
function extract_and_save_batting_data($conn, $batting_data, $man_of_the_match_id, $match_uniq_id){
	echo "<br>batting data<br>";
	foreach($batting_data as $batting){
		$match_title=$batting["title"];
		$scores = $batting["scores"];
		foreach($scores as $score){
			$batting_runs_scored=$score["R"];
			$batting_sixes_hit=$score["6s"];
			$batting_fours_hit=$score["4s"];
			$batting_balls_played=$score["B"];
			$pid=$score["pid"];
			$is_man_of_the_match = $man_of_the_match_id === $pid ? 1 : 0;
			$query = "INSERT INTO player_batting_data(pid,runs_scored,fours_hit,sixes_hit,balls_played,matchid) values('$pid','$batting_runs_scored','$batting_fours_hit','$batting_sixes_hit','$batting_balls_played','$match_uniq_id');";
			$stmt = execute_query($conn, $query);
			insert_new_player_match_record($conn, $pid, $match_uniq_id, $is_man_of_the_match);
		}
	}
	echo "<br>batting data added successfully";
}

function insert_new_player_match_record($conn, $pid, $match_uniq_id, $is_man_of_the_match){
	$query = "INSERT INTO player_matches(pid, matchid, mom) values('$pid','$match_uniq_id',$is_man_of_the_match);";
	echo "<br>".$query."<br>";
	if(! does_record_exists($pid, $match_uniq_id, $conn)){
		$stmt = execute_query($conn, $query);
	}

}

function does_record_exists($pid,$matchid, $conn){
	$select_query = "select pid from player_matches where pid='$pid' and matchid='$matchid';";
	$result = execute_query($conn, $select_query);
	return result_has_rows($result);
}
?>
