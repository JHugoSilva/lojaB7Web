<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'config.php';
require 'vendor/autoload.php';

$core = new Core\Core();
$core->run();