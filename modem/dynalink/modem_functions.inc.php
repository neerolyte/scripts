<?php
function get_line_rates() {
	$rates = array();

	$page = get_modem_page('/infodsl.html');
	if (preg_match('%var downALR = \'([0-9]*)\';%', $page, $match)) {
		$rates['downa'] = $match[1];
	}
	if (preg_match('%var upALR = \'([0-9]*)\';%', $page, $match)) {
		$rates['upa'] = $match[1];
	}
	if (preg_match('%var downrate = \'([0-9]*)\';%', $page, $match)) {
		$rates['down'] = $match[1];
	}
	if (preg_match('%var uprate = \'([0-9]*)\';%', $page, $match)) {
		$rates['up'] = $match[1];
	}

	return $rates;
}

function get_modem_page($page) {
	$config = require(dirname(__FILE__).'/config.php');

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $config['url'].$page);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERPWD, $config['user'].':'.$config['pass']);

	$res = curl_exec($ch);

	$error = curl_error($ch);
	$errno = curl_errno($ch);

	curl_close($ch);

	return $res;
}
