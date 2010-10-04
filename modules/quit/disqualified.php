
return function($message) {
	global $operators;
	
	$search = search_multi($message->getNick(), $operators);
	
	if ($search !== FALSE) {
		unset($operators[$search]);
	}
}
?>
