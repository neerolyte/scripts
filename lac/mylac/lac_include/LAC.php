<?php
/**
 * Lyte's Audio Converter
 *
 * @author David Schoen <neerolyte@gmail.com>
 */
class LAC {
	/**
	 * Array of config
	 */
	private $_config = array(
		'format' => 'mp3',
	);

	/**
	 * Set some value in LAC's config
	 */
	public function setConfig($key, $val) {
		// ensure dest and source are full paths
		if (in_array($key, array('dest', 'source'))) {
			$val = realpath($val);
		}
		$this->_config[$key] = $val;
	}

	/**
	 * Check important config that we shouldn't run without
	 *
	 * @return false on error
	 */
	public function checkConfig() {
		return isset($this->_config['source']) && is_dir($this->_config['source'])
			&& isset($this->_config['dest']) && is_dir($this->_config['dest']);
	} // end checkConfig()

	/**
	 * Get a piece of config
	 * Use this method just in case the config storage changes later in life
	 */
	public function getConfig($key) {
		return $this->_config[$key];
	} // getConfig()

	/**
	 * Convert everything in source to format under dest
	 */
	public function run() {
		$this->_convertDir($this->getConfig('source'));
	} // run()

	/**
	 * Convert a single directory
	 */
	private function _convertDir($dir) {
		if (!is_dir($dir)) {
			throw new Exception("Can't convert directory that's not a directory: $dir");
		}
		$d = dir($dir);
		while (false !== ($entry = $d->read())) {
			if ($entry == '.' || $entry == '..') continue;
			$path = "$dir/$entry";
			if (is_dir($path)) {
				$this->_convertDir($path);
			} else if (is_file($path)) {
				$this->_convertFile($path);
			} else {
				echo "WARNING: Not sure what to do with $path\n";
			}
		}
	} // convertDir()

	/**
	 * Convert a single file
	 */
	private function _convertFile($source) {
		if (!is_file($source)) {
			throw new Exception("Can't convert file that's not a file: $source");
		}
		echo "Would now convert $source\n";

		$dest = $this->getConfig('dest').'/'.substr($source, strlen($this->getConfig('source')) + 1);
		echo "to $dest\n";
	} // _convertFile()
}

// eof
