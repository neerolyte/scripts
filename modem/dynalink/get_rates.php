#!/usr/bin/php
<?php

require_once 'modem_functions.inc.php';

var_dump(get_line_rates());
//reboot();


#function reboot() {
#	$page = get_modem_page('/resetrouter.html');
#	if (preg_match('%var randomNum = \'([0-9]*)\';%', $page, $match)) {
#		$randomNum = $match[1];
#	} else {
#		throw new Exception('Failed to get randomNum for rebooting modem');
#	}
#
#	$page = get_modem_page('/rebootinfo.cgi?checkNum='.$randomNum.'&quickSetup=0');
#	var_dump($page);
#}

