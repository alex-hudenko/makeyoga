<?php

class DirectoryParser {

	public $structure = array();

	private $_titleIndex = array();
	private $_path;

	public function __construct($path) {
		if (is_dir($path) && is_readable($path)) {
		    $this->_path = $path;
			$this->structure = $this->_process($this->_path, 0);
		}
	}

	private function _process($path = '.', $level = 0, $titlePath = array()) {
		// Directories and files to ignore when listing output.
		$ignore = array('.', '..', '.DS_Store', '.svn', '.git');
		$files = array();

		// Open the directory to the handle $dh
		$dh = opendir($path);

		// Loop through the directory
		while (false !== ($file = readdir($dh))) {
			// Check that this file is not to be ignored
			if (!in_array($file, $ignore)) {

			}
		}
		// Close the directory handle
		closedir($dh);
		// sort docs

		return $files;
	}

}
