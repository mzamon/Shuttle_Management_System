<?php
/**
 * Logout Handler
 */

session_name('NBK_SHUTTLE_SESSION');
session_start();

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../src/models/Auth.php';

$auth = new Auth();
$auth->logout();

header('Location: login.php');
exit;

?>
