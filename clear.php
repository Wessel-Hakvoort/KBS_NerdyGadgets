<?php
//clear php
session_start();
$_SESSION = array();
session_destroy();

// etc.
header('Location: index.php');
exit();