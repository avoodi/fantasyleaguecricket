<?php

function extract_and_save_fielding_data($conn, $fielding_data, $man_of_the_match_id, $match_uniq_id){
	echo "<br> fielding data <br>";
	foreach($fielding_data as $fielding){
		$match_title=$fielding["title"];
		$scores = $fielding["scores"];
		foreach($scores as $score){
			$runouts=$score["runout"];
			$catches_taken=$score["catch"];
			$pid=$score["pid"];
			$is_man_of_the_match = $man_of_the_match_id === $pid ? 1 : 0;
			$query = "INSERT INTO player_fielding_data(pid,runouts,catches_taken,matchid) values('$pid','$runouts','$catches_taken','$match_uniq_id');";
			echo "<br>".$query."<br>";
			$stmt = execute_query($conn, $query);
			insert_new_player_matches_record($conn, $pid, $match_uniq_id, $is_man_of_the_match);
		}
	}
	echo "<br>fielding data added successfully";
}

function insert_new_player_matches_record($conn, $pid, $match_uniq_id, $is_man_of_the_match){
	$query = "INSERT INTO player_matches(pid, matchid, mom) values('$pid','$match_uniq_id',$is_man_of_the_match);";
	echo "<br>".$query."<br>";
	if(! is_record_exists($pid,$match_uniq_id, $conn)){
		$stmt = execute_query($conn, $query);
	}
}

function is_record_exists($pid,$match_uniq_id, $conn){
	$select_query = "select pid from player_matches where pid='$pid' and matchid='$match_uniq_id';";
	$result = execute_query($conn, $select_query);
	return result_has_rows($result);
}
?>
