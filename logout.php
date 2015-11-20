<?php
require_once 'core/init.php';
$user->logout();
Redirect::to('/');
?>