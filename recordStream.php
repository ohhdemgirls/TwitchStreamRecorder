<?php
	$channel = $_REQUEST['channel'];
	$folder = "/your/folder/";

	exec("pidof /usr/bin/python", $out);

	$rec = false;
	foreach ($out as $proc) {
		exec("ps -fp ".$proc, $out2);
		if (preg_match("!$channel!", $out2[1])) {
			$rec = true;
		}
	}

	if (!$rec) {
		if (checkAvailable($channel, 0)) {
			echo "Channel online ... ";
			record($channel, 1);
			echo "Recording";
		}
		else {
			echo "Channel offline";
		}
	}
	else echo "Already recording";	

	function checkAvailable($channel, $debug) {
		$req = "https://api.twitch.tv/kraken/streams?channel=";
		$req .= $channel;
		if ($debug) echo "Waiting response <br>";
		$json = file_get_contents($req);
		if ($json) {
			$data = json_decode($json,true);

			foreach ($data["streams"] as $item) {
				if ($debug) echo "Viewers: ".$item['viewers']."<br>";
				return ($item['viewers'] > 0);
			}
		}
		else {
			if ($debug) echo "Error getting data";
		}
	}

	function record($channel, $debug) {
		$cmd = "livestreamer twitch.tv/" . $channel . " best -o ". $folder . date('dmHis', time()) . $channel . ".avi";
		exec("($cmd) >/dev/null 2>/dev/null &");
		if ($debug) echo $cmd;
	}
?>