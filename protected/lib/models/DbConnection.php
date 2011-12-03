<?php
/**
 * User: alex
 * Date: 11/30/11
 * Time: 9:41 PM
 *
 */

class DbConnection
{
	static private $_db;

	static public function getInstance()
	{
		if (!self::$_db) {
			self::$_db = DbSimple_Generic::connect("mysql://" . APP_DB_USER . ":" . APP_DB_PASSWORD . "@" . APP_DB_HOST . "/" . APP_DB_NAME . "");
			self::$_db->setIdentPrefix('');
			self::$_db->setErrorHandler('databaseErrorHandler');
		}
		return self::$_db;
	}
}

function databaseErrorHandler($message, $info)
{

	if (!error_reporting()) return;
	echo "SQL Error: $message\n";
	print_r($info);
	echo "\n";
	exit();
}
