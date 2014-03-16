TwitchStreamRecorder
====================

A short PHP script to record twitch streams with livestreamer automatically

Installation 
============

You need to have livestreamer installed, go here for installation instructions http://livestreamer.tanuki.se/en/latest/install.html

You also need to modify the $folder var to the folder you want to save the recordings, make sure writing permissions are enabled.

To automate the recording add something like the following to your crontab or similar:

*/5 * * * * curl http://127.0.0.1/recordStream.php?channel=gerarddp

This will check every 5 minutes if the stream is up and start recording