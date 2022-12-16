<?php

include __DIR__ .'/model/loginAction.php';
include __DIR__ .'/dump.php';

session_start();
Login::logout();
header('Location: login.php');
exit;

?>