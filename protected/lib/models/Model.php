<?php
/**
 * User: alex
 * Date: 11/30/11
 * Time: 9:20 PM
 *
 */

class Model {
	protected $db;

	public function __construct() {
		$this->db = DbConnection::getInstance();
	}

}
