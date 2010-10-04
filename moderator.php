 <?php
/*
Title: Cluck MSN Bot
Developer: Brendan Mc. (Bren2010)
Purpose: Moo on MSN.
Version: 1.0
*/
/*************** CONFIGURATION ***************/
$config = parse_ini_file("config.ini", TRUE);

$nick = $config['nickserv']['nick'];
$registered = $config['nickserv']['registered'];
$password = $config['nickserv']['password'];

$bot = $config['nickserv']['bot'];

$modeLock = str_split($config['nickserv']['modeLock'], 1);

$server = $config['server']['server'];
$port = $config['server']['port'];
$channel = $config['server']['channel'];

// System Settings
$daemon = $config['system']['daemon']; // Run the bot as a daemon.

/******************* CODE ********************/
error_reporting(0);

if ($daemon == TRUE) {
	if(pcntl_fork()) die(); // This turns the bot into a daemon.
}

set_time_limit(0); // So PHP never times out

require_once("functions.php");
require_once("modules.php");
require_once("ircMsg.php");

$modules = new modules();

$operators = array();
$reqCommand = "";

$updateInterval = 30;
$nextUpdate = time() + $updateInterval;

$socket = fsockopen($server, $port);
cmd_send("USER " . $nick . " " . $nick . " " . $nick . " : " . $nick); // Register user data.
cmd_send("NICK " . $nick); // Change nick.
			
cmd_send("JOIN " . $channel); // Join default channel.

while (1) {
	while (!feof($socket)) {
		$data = fgets($socket);
		
		$pingCheck = substr($data, 0, strlen("PING :"));
		
		if ($pingCheck == "PING :") {
			$pong = substr($data, strlen("PING :"));
			cmd_send("PONG :" . $pong);
		} else {
			$message = new ircMsg($data);
			
			$command = strtolower($message->getCommand());
			
			$modules->hook($command, $message);
		}
		
		$time = time();
		
		if ($time >= $nextUpdate) {
			$modules->hook("periodic", NULL);
			
			$nextUpdate = $time + $updateInterval;
		}
	}
}
?>
