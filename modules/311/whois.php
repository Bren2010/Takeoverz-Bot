
return function($message) {
	global $reqCommand;
	
	$command = substr($reqCommand, 0, strlen("whois_check:"));

	if ($command == "whois_check:") {
		
		$parameters = $message->getParameters();
		
		$hostmask = $parameters[1] . "!" . $parameters[2] . "@" . $parameters[3];
		$time = substr($reqCommand, strlen("whois_check:"));
		
		$fh = fopen("records.txt", "w");
		fwrite($fh, $hostmask . "\n" . $time);
		fclose($fh);
		
		global $channel;
		
		cmd_send("TOPIC " . $channel . " :New Record set by " . $parameters[1] . " with a time of " . $time . " seconds!");
		cmd_send("NOTICE " . $parameters[1] . " :Contratulations!  You win with a time of " . $time . " seconds! :D");
		
		$reqCommand = "";
	}
}
?>
