
return function($message) {
	global $operators;
	
	$search = search_multi($message->getNick(), $operators);
	
	if ($search !== FALSE) {
		cmd_send("NOTICE " . $message->getNick() . " :You have been disqualified for leaving the channel.");
		unset($operators[$search]);
	}
}
?>
