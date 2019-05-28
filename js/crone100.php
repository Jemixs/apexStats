<?php
require '../inc/rb-mysql.php';
require_once '../vendor/autoload.php';
require '../apexapi.php';
require '../apexdb.php';
include '../inc/phpQuery.php';

R::setup('mysql:host=apexstat.mysql.tools;dbname=apexstat_db', 'apexstat_db', 'Qx8577cV');
if ( !R::testConnection() ) {
	exit('Dont finds stream! Please check connection.');
}

$apexApi = new apexApi();
$apexDb = new apexDb();



$getAllPlayers = R::findAll('players','id > 1100 and id < 1201');

echo 'Start: '.date('H:i:s',time()).'</br>';
$i=0;

foreach ($getAllPlayers as $player) {
	$times = time() - $player['last_update'];
	if ($times > 150) {
		echo 'id: '.$i.' '.$player->nick_name.' '.'</br>';
		$getPlayer = $apexApi->getUserStat((int)$player->uid,$player->platform);
		$apexDb->updateLegends($getPlayer);
		$i++;
	}
}

echo 'End: '.date('H:i:s',time());