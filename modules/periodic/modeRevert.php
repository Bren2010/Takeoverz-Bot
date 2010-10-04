
return function($message) {
	global $channel;
	
	cmd_send("MODE " . $channel);
}
?>
