
<?php
require_once('./config/connection.php');

require_once('./config/autoloader.php');

//create session
require_once('./config/session.php');
Session::init();

require_once('./config/routes.php');
