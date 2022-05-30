<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$scripts = realpath($_SERVER['DOCUMENT_ROOT'] . '/../jwrr_scripts');
require_once "$scripts/jwrr_require.php";
jwrr_session_resume();
$html = custom_homepage();
echo $html;

