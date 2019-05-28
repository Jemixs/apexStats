<?php
require 'rb-mysql.php';
require 'conf.php';
require 'function.php';

R::setup('mysql:host=localhost;dbname=apex', 'root', '');
if ( !R::testConnection() ) {
	exit('Dont finds stream! Please check connection.');
}

if (in_array($_SERVER['REMOTE_ADDR'], $arrAutorIp)) {
	$authorization = true;
}else{
	$authorization = false;
}


if (ENG_WORKS == 1 && !$authorization) {
	header('Location: /works');
}elseif (ENG_WORKS == 0 && $_SERVER['REQUEST_URI'] == '/works') {
	header('Location: /');
}