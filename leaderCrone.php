<?php
include 'inc/system.php';

R::ext('xdispense', function ($table_name) {
	return R::getRedBean()->dispense($table_name);
});

$getTopKills = R::getAll('SELECT lifeline_kills, wraith_kills, bangalore_kills, bloodhound_kills, mirage_kills, pathfinder_kills, gibraltar_kills, caustic_kills, octane_kills, uid FROM legends_players');

$getTopDamage = R::getAll('SELECT lifeline_damage, wraith_damage, bangalore_damage, bloodhound_damage, mirage_damage, pathfinder_damage, gibraltar_damage, caustic_damage, octane_damage, uid FROM legends_players');

$getTopHead = R::getAll('SELECT lifeline_headshots, wraith_headshots, bangalore_headshots, bloodhound_headshots, mirage_headshots, pathfinder_headshots, gibraltar_headshots, caustic_headshots, octane_headshots, uid FROM legends_players');

$getTopMatch = R::getAll('SELECT lifeline_games_played, wraith_games_played, bangalore_games_played, bloodhound_games_played, mirage_games_played, pathfinder_games_played, gibraltar_games_played, caustic_games_played, octane_games_played, uid FROM legends_players');

$getLvl = R::getAll('SELECT lvl,uid FROM players ORDER BY lvl DESC');

/*
$type - kills, damage, headshots, games_played
*/
function getTop($arrTop,$type='kills') {
	if ($arrTop) {
		$arrTopType = [];

		$i=0;
		foreach ($arrTop as $key) {
			$sumType = (int)$key['lifeline_'.$type]+(int)$key['wraith_'.$type]+(int)$key['bangalore_'.$type]+(int)$key['bloodhound_'.$type]+(int)$key['mirage_'.$type]+(int)$key['pathfinder_'.$type]+(int)$key['gibraltar_'.$type]+(int)$key['caustic_'.$type]+(int)$key['octane_'.$type];

			if ($sumType > 0) {
				$i++;
				$arrTopType[$sumType]['uid'] = $key['uid'];
			}
		}
		if (!empty($arrTopType)) {
			krsort($arrTopType);

			$finalArrData = [];

			foreach ($arrTopType as $key => $value) {
				$finalArrData[]['uid'] = $value['uid'];
			}

			return $finalArrData;
		}else{
			return 'Error: Invalid type';
		}
	}else{
		return 'Error: Data not found or clear';
	}
}

// debug(getTop($getTopKills));
// debug(getTop($getTopDamage,'damage'));
// debug(getTop($getTopHead,'headshots'));
// debug($getLvl);

$topKills = getTop($getTopKills);
$topDmg = getTop($getTopDamage,'damage');
$topHead = getTop($getTopHead,'headshots');
$topMatch = getTop($getTopMatch,'games_played');

// debug($topKills);

R::wipe( 'leaderbord' );
$i=0;
while ($i <= 999) {
	$leaderbord = R::dispense( 'leaderbord' );
	$leaderbord->top_kills = (int)$topKills[$i]['uid'];
	$leaderbord->top_damage = (int)$topDmg[$i]['uid'];
	$leaderbord->top_headshot = (int)$topHead[$i]['uid'];
	$leaderbord->top_lvl = (int)$getLvl[$i]['uid'];
	$leaderbord->top_games = (int)$topMatch[$i]['uid'];

	if (!isset($topKills[$i]['uid']) && !isset($topDmg[$i]['uid']) && !isset($topHead[$i]['uid']) && !isset($getLvl[$i]['uid']) && !isset($topMatch[$i]['uid'])) {
		break;
	}else{
		$ids = R::store( $leaderbord );
	}
	$i++;
}


/*
$platform = PC, X1, PS4
*/
function generatePlTop($platform='PC') {
	if ($platform === 'PC') {
		$platformTable = 'leaderbord_pc';
	}elseif ($platform === 'X1') {
		$platformTable = 'leaderbord_xbox';
	}elseif ($platform === 'PS4') {
		$platformTable = 'leaderbord_psn';
	}

	$getAllbord = R::findAll('leaderbord');

	$pcKills = [];
	$pcDamage = [];
	$pcHead = [];
	$pcLvl = [];
	$pcGame = [];

	foreach ($getAllbord as $player) {
		$platformPlKills = R::findOne('players', 'uid = ?',[$player->top_kills]);
		$platformPlDmg = R::findOne('players', 'uid = ?',[$player->top_damage]);
		$platformPlHead = R::findOne('players', 'uid = ?',[$player->top_headshot]);
		$platformPlLvl = R::findOne('players', 'uid = ?',[$player->top_lvl]);
		$platformPlGames = R::findOne('players', 'uid = ?',[$player->top_games]);


		if ($platformPlKills->platform == $platform) {
			$pcKills[] = $platformPlKills->uid;
		}
		if ($platformPlDmg->platform == $platform) {
			$pcDamage[] = $platformPlDmg->uid;
		}
		if ($platformPlHead->platform == $platform) {
			$pcHead[] = $platformPlHead->uid;
		}
		if ($platformPlLvl->platform == $platform) {
			$pcLvl[] = $platformPlLvl->uid;
		}
		if ($platformPlGames->platform == $platform) {
			$pcGame[] = $platformPlGames->uid;
		}
	}

	$ss=0;
	while ($ss <= 1000) {
		$leaderbord = R::xdispense($platformTable);
		$leaderbord->top_kills = (int)$pcKills[$ss];
		$leaderbord->top_damage = (int)$pcDamage[$ss];
		$leaderbord->top_headshot = (int)$pcHead[$ss];
		$leaderbord->top_lvl = (int)$pcLvl[$ss];
		$leaderbord->top_games = (int)$pcGame[$ss];

		if (!isset($pcKills[$ss]) && !isset($pcDamage[$ss]) && !isset($pcHead[$ss]) && !isset($pcLvl[$ss]) && !isset($pcGame[$ss])) {
			break;
		}else{
			$ids = R::store( $leaderbord );
		}
		$ss++;
	}
}

R::wipe( 'leaderbord_pc' );
R::wipe( 'leaderbord_xbox' );
R::wipe( 'leaderbord_psn' );
generatePlTop();
generatePlTop('X1');
generatePlTop('PS4');