<?php
function extract_and_save_bowling_data($conn, $bowling_data, $man_of_the_match_id, $match_uniq_id){
	echo "<br>bowling data<br>";
	foreach($bowling_data as $bowling){
		$match_title=$bowling["title"];
		$scores = $bowling["scores"];
		foreach($scores as $score){
			$wickets_taken=$score["W"];
			$runs_conceded=$score["R"];
			$maiden_balled=$score["M"];
			$overs_balled=$score["O"];
			$pid = $score["pid"];
			$is_man_of_the_match = $man_of_the_match_id === $pid ? 1 : 0;
			$query = "INSERT INTO PLAYER_BOWLING_DATA(pid, runs_given, wickets_taken, overs_bowled, maiden_overs, matchid) values('$pid','$runs_conceded','$wickets_taken','$overs_balled','$maiden_balled','$match_uniq_id');";
			echo "<br>".$query."<br>";
			$stmt = execute_query($conn, $query);
			insert_player_matches_record($conn, $pid, $match_uniq_id, $is_man_of_the_match);
		}
	}
	echo "<br>bowling data added successfully";
}

function insert_player_matches_record($conn, $pid, $match_uniq_id, $is_man_of_the_match){
	$query = "INSERT INTO PLAYER_MATCHES(pid, matchid, mom) values('$pid','$match_uniq_id',$is_man_of_the_match);";
	echo "<br>".$query."<br>";
	if(! record_already_exists($pid,$match_uniq_id, $conn)){
		$stmt = execute_query($conn, $query);
	}
}

function record_already_exists($pid,$match_uniq_id, $conn){
	$select_query = "select pid from player_matches where pid='$pid' and matchid='$match_uniq_id';";
	$result = execute_query($conn, $select_query);
	return result_has_rows($result);
}
?>
