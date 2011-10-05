<?php

$tries = 0;
$ret = 1;
$out = '';
while ($ret != 0 && $tries <= 10) {
	exec(dirname(__FILE__).'/get_adsl_info', $out, $ret);
}

if ($ret != 0) {
	throw new Exception("Failed to get stats from modem");
}

$stats = array();
foreach ($out as $line) {
	$stats['epoch'] = time();
	$stats['time'] = date('Y-m-d H:i:s');

	if (preg_match('%Channel: (.*), Upstream rate = (.*) Kbps, Downstream rate = (.*) Kbps%', $line, $match)) {
		$stats['channel'] = $match[1];
		$stats['rate_up'] = $match[2];
		$stats['rate_down'] = $match[3];
	}

	if (preg_match('%Link State\s*:\s*(.*)%', $line, $match)) {
		$stats['link_state'] = $match[1];
	}

	if (preg_match('%DSL Line Up Count\s*:\s*(.*)%', $line, $match)) {
		$stats['dsl_up_count'] = $match[1];
	}

	if (preg_match('%DSL Line Up Time\s*:\s*(.*)%', $line, $match)) {
		$stats['dsl_up_time'] = $match[1];
	}

	if (preg_match('%System Up Time\s*:\s*(.*)%', $line, $match)) {
		$stats['up_time'] = $match[1];
	}

	if (preg_match('%Status\s*:\s(.*)%', $line, $match)) {
		$stats['status'] = $match[1];
	}
}

$cols = array(
	'epoch', 'time',
	'status', 'channel', 'rate_up', 'rate_down',
	'link_state', 'dsl_up_count', 'dsl_up_time',
	'up_time',
);

$log_file = dirname(__FILE__).'/adsl_stats.csv';
if (!file_exists($log_file)) {
	$fp = fopen($log_file, 'w');
	fputcsv($fp, $cols);
} else {
	$fp = fopen($log_file, 'a');
}

$log_array = array();
foreach ($cols as $col) {
	$log_array []= $stats[$col];
}

fputcsv($fp, $log_array);

fclose($fp);
