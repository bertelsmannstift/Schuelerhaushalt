<?php

require_once("./typo3conf/ext/sk_etracker/etracker.inc.php");

if (!is_object($this))	die("Not called from cObj!");

$globalTracker = $conf["global."];

if($globalTracker['ssl'] == 1) $ssl = true;
else $ssl = false;

$content = '';
$pagename = '';

//Seitentitle als Seitennamen setzen
if($globalTracker['rootpage'] != $this->data['uid']) {
	if($this->data['title']) {
		$pagename = $this->data['title'];
	}
}

//Wenn ein Prefix gesetzt ist
if($globalTracker['prefix']) {
	$pagename = $globalTracker['prefix']. ":" .$pagename;	
}

//Wenn ein Securitycode vorhanden
if($globalTracker['securitycode'])
	$content = getCode($globalTracker['securitycode'], false, $ssl, $pagename, $globalTracker['area']);
?>