#!/usr/bin/php
<?php
require_once 'modem_functions.inc.php';

$rates = get_line_rates();

// if down rate can be improved by more than 6k
// and current down rate below 10k
// and achievable down rate is above 10k
// we want to reboot
if ($rates['downa'] - $rates['down'] > 6144
	&& $rates['down'] < 10240
	&& $rates['downa'] > 10240
	) {
	echo "Time to reboot...\n";
	echo "Downa: ".$rates['downa']."\n";
	echo "Down: ".$rates['down']."\n";
	echo "Upa: ".$rates['upa']."\n";
	echo "Up: ".$rates['up']."\n";
	exit(0);
} else {
	//echo "Good enough\n";
}

exit(1);
