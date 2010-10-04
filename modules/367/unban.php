
return function($message) {
	global $bot;
	
	$parameters = $message->getParameters();
	
	if ($parameters[3] != $bot) {
		global $channel;
		
		cmd_send("MODE " . $channel . " -b " . $parameters[2]);
	}
}
?>
