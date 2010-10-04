
return function ($message) {
	global $operators;
	
	$search = search_multi($message->getNick(), $operators);
	
	if ($search !== FALSE) {
		$parameters = $message->getParameters();
		
		$operators[$search]['nick'] = trim($parameters[0]);
	}
}
?>
