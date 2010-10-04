
return function($message) {
	global $operators;
	
	$parameters = $message->getParameters();
	
	$where = $parameters[0];
	$modes = $parameters[1];

	unset($parameters[0]);
	unset($parameters[1]);

	$operator = substr($modes, 0, 1);
	$modeArray = str_split(substr($modes, 1));

	$preText = "";

	foreach ($parameters as $person) {
		$currMode = current($modeArray);
		
		$cleanNick = trim($person);
				
		if ($currMode == "o") {
			if ($operator == "+") {
				$search = search_multi($cleanNick, $operators);
				
				global $nick;
				
				if ($search == FALSE && $cleanNick != $nick) {
					array_push($operators, array('nick' => $cleanNick, 'time' => time()));
				}
			} elseif ($operator == "-") {
				$search = search_multi($cleanNick, $operators);
				
				if ($search !== FALSE) {
					$check = check_score(time() - $operators[$search]['time']);
					
					if ($check == TRUE) {
						global $reqCommand;
						$reqCommand = "whois_check:" . (time() - $operators[$search]['time']);

						cmd_send("WHOIS " . $operators[$search]['nick']);
					} else {
						$seconds = time() - $operators[$search]['time'];
						
						cmd_send("NOTICE " . $operators[$search]['nick'] . " :Sorry, but you lose! :_(  Your time was: " . $seconds . " seconds.");
					}
					
					unset($operators[$search]);
				}
			}
		}
		
		next($modeArray);
	}
}
?>
