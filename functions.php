<?php
function cmd_send($command) {
	global $socket;
	$code = fputs($socket, $command."\n\r");
	return $code;
}

function search_multi($value, $array) {
	$return = FALSE;
	
	foreach (array_keys($array) as $part) {
		if ($array[$part]['nick'] == $value) {
			$return = $part;
		}
	}
	
	return $return;
}

function check_score($time) {
	$file = file_get_contents("records.txt");
	$array = explode("\n", $file);
	
	if ($time > $array[1]) {
		return TRUE;
	} else {
		return FALSE;
	}
}
?>
