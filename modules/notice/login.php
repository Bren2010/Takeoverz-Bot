return function($message) {
	global $registered;
	
	$params = $message->getParameters();
	$text = trim($params[1]);
	
	if ($registered == TRUE && $message->getNick() == "NickServ" && $text == "If you do not change within one minute, I will change your nick.") {
		global $password;
		cmd_send("PRIVMSG NickServ :IDENTIFY " . $password);
	}
	
	return true;
}
?>
