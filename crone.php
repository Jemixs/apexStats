<?php
require_once 'vendor/autoload.php';
require 'inc/system.php';
require 'apexapi.php';
require 'apexDb.php';
require 'inc/phpquery.php';

$apexApi = new apexApi();
$apexDb = new apexDb();



$getAllPlayers = R::findAll('players', '('.time().' - last_update) > 150 LIMIT 100');

echo 'Start: '.date('H:i:s',time()).'</br>';
$i=0;
foreach ($getAllPlayers as $player) {
    $times = time() - $player['last_update'];
        echo 'id: '.$i.' '.$player->nick_name.' '.'</br>';
        $getPlayer = $apexApi->getUserStat((int)$player->uid,$player->platform);
        $apexDb->updateLegends($getPlayer);
        $i++;
}
echo 'End: '.date('H:i:s',time());