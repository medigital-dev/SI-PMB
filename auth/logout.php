<?php
session_start();
require_once '../config.php';

$_SESSION = [];
session_unset();
session_destroy();

setcookie('id', '', time() - 3600);
setcookie('key', '', time() - 3600);

header("Location: " . base_url('auth/login.php'));
exit;
