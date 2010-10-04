
return function($message) {
	global $modeLock;
	global $channel;
	
	$parameters = $message->getParameters();
	$preModes = $parameters[2];
	$modes = str_split(trim(substr($preModes, 1)), 1);
	
	// Remove extra values
	foreach ($modes as $mode) {
		$search = array_search($mode, $modeLock, true);
		
		if ($search === FALSE) {
			cmd_send("MODE " . $channel . " -" . $mode);
		}
	}
	
	// Add missing values
	foreach ($modeLock as $rightMode) {
		$search = array_search($rightMode, $modes, true);
		
		if ($search === FALSE) {
			cmd_send("MODE " . $channel . " +" . $rightMode);
		}
	}
}
?>
