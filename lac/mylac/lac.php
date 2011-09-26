#!/usr/bin/php
<?php
/**
 * Lyte's Audio Converter
 *
 * @author David Schoen <neerolyte@gmail.com>
 */
// pear lib
require_once 'Console/Getopt.php';
// LAC
require_once dirname(__FILE__).'/lac_include/init.php';

$short_options = '';
$long_options = array(
	'source=',
	'dest=',
);
$cli_help = 'Usage: '.$argv[0].'

Options:
	--source=<source directory>
		where to search for files
		
	--dest=<destination directory>
		where to create files
';

$lac = new LAC;
$con = new Console_Getopt;
$args = $con->readPHPArgv();
$options = $con->getopt($args, $short_options, $long_options);

if (PEAR::isError($options)) {
	fwrite(STDERR, $cli_help);
	exit(1);
} else {
	foreach ($options[0] as $opt) {
		switch($opt[0]) {
		case '--source':
			//$source = $opt[1];
			$lac->setConfig('source', $opt[1]);
			break;
			
		case '--dest':
			//$dest = $opt[1];
			$lac->setConfig('dest', $opt[1]);
			break;
			
		default:
			fwrite(STDERR, $cli_help);
			exit(1);
		}
	}
}

// test all required arguments here
if (!$lac->checkConfig()) {
	fwrite(STDERR, $cli_help);
	exit(1);
}

$lac->run();

// eof
