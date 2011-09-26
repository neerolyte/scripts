<?php
/**
 * Lyte's Audio Converter
 *
 * @author David Schoen <neerolyte@gmail.com>
 */
define('LAC_ROOT', dirname(__FILE__));

function __autoload($class_name) {
	require_once LAC_ROOT.'/'.$class_name.'.php';
}
