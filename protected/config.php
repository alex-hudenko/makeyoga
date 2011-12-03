<?php

define('APP_DEBUG', true);
define('APP_DB_HOST', 'localhost');
define('APP_DB_USER', 'root');
define('APP_DB_PASSWORD', 'pass');
define('APP_DB_NAME', 'yl_making');

require_once 'lib/vendor/DbSimple/Generic.php';
require_once 'lib/vendor/DbSimple/Mysql.php';

require_once 'lib/helpers/DirectoryParser.php';

require_once 'lib/models/DbConnection.php';
require_once 'lib/models/Model.php';
require_once 'lib/models/Page.php';
require_once 'lib/models/PageVersion.php';

?>
