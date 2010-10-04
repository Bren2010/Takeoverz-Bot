
return function($message) {
		global $operators;
		
		$parameters = $message->getParameters();
		$users = explode(" ", trim($parameters[3]));
		
		foreach ($users as $user) {
			$op_search = strpos($user, "@");
			
			if ($op_search !== FALSE) {
				$cleanNick = preg_replace("/[^a-zA-Z0-9\s]/", "", $user);
				
				global $nick;
				
				if ($cleanNick != $nick) {
					array_push($operators, array('nick' => trim($cleanNick), 'time' => time()));
				}
			}
		}
}
?>
