<?php
//error_reporting(0);
include 'inc/system.php';
include 'vendor/autoload.php';
include 'apexApi.php';
include 'apexDb.php';
include 'inc/phpQuery.php';

if (empty($_GET['platform']) OR empty($_GET['nick'])) {
	header('Location: /');
}

if (isset($_GET['platform']) && isset($_GET['nick']) && !isset($_GET['update']) && !empty($_GET['platform'] && !empty($_GET['nick']))) {
	$searchNick = rawurldecode(trim(htmlspecialchars($_GET['nick'])));
	$platformSearch = htmlspecialchars($_GET['platform']);
	if ($platformSearch == 'pc' OR $platformSearch == 'xbox' OR $platformSearch == 'ps4') {
	// }elseif ($platformSearch === 'pc' OR $platformSearch === 'x1' OR $platformSearch === 'ps4') {
	// 	header('Location: /profile/'.rawurlencode(strtoupper($_GET['platform'])).'/'.rawurlencode($_GET['nick']));
		if ($platformSearch == 'pc') {
			$platform = 'PC';
		}elseif ($platformSearch == 'xbox') {
			$platform = 'X1';
		}elseif ($platformSearch == 'ps4') {
			$platform = 'PS4';
		}
	}else{
		header('Location: /');
	}

	$searchPlayer = R::findOne('players','nick_name = ? and platform = ?',array($searchNick,$platform));

	$arrStatsTitle = [
		'kills',
		'damage',
		'games_played',
		'headshots',
		'revives',
		'top_3',
		'wins_full_squad',
		'finishers',
		'pistol_kills',
		'shotgun_kills',
		'smg_kills',
		'ar_kills',
		'lmg_kills',
		'sniper_kills',
		'health_drone_healing',
		'revive_shield_damage_blocked',
		'kill_leader_kills',
		'winning_kills',
		'drop_call',
		'encore_executions_escaped',
		'decoys_created',
		'bamboozles',
		'nox_gassed_enemies_killed',
		'eye_enemies_scanned'
	];

	if ($searchPlayer) {
		$title = $searchPlayer->nick_name.' статистика';
		//echo '<pre>',print_r($searchPlayer),'</pre>';
		$getUserLegends = R::findOne('legends_players','uid = ?',array($searchPlayer->uid));
		$getUserAllLegends = unserialize($getUserLegends->all_legends);

		$killsCount = 0+@$getUserLegends->lifeline_kills+@$getUserLegends->bangalore_kills+@$getUserLegends->bloodhound_kills+@$getUserLegends->gibraltar_kills+@$getUserLegends->caustic_kills+@$getUserLegends->mirage_kills+@$getUserLegends->pathfinder_kills+@$getUserLegends->wraith_kills+@$getUserLegends->octane_kills;

		$damageCount = 0+@$getUserLegends->lifeline_damage+@$getUserLegends->bangalore_damage+@$getUserLegends->bloodhound_damage+@$getUserLegends->gibraltar_damage+@$getUserLegends->caustic_damage+@$getUserLegends->mirage_damage+@$getUserLegends->pathfinder_damage+@$getUserLegends->wraith_damage+@$getUserLegends->octane_damage;

		$matchCount = 0+@$getUserLegends->lifeline_games_played+@$getUserLegends->bangalore_games_played+@$getUserLegends->bloodhound_games_played+@$getUserLegends->gibraltar_games_played+@$getUserLegends->caustic_games_played+@$getUserLegends->mirage_games_played+@$getUserLegends->pathfinder_games_played+@$getUserLegends->wraith_games_played+@$getUserLegends->octane_games_played;

		$placeInratingKills = R::findOne('leaderbord','top_kills = ?',[$searchPlayer->uid]);
		$placeInratingLvl = R::findOne('leaderbord','top_lvl = ?',[$searchPlayer->uid]);
		$placeInratingDamage = R::findOne('leaderbord','top_damage = ?',[$searchPlayer->uid]);
		$placeInratingMatch = R::findOne('leaderbord','top_games = ?',[$searchPlayer->uid]);

	}else{
		$apexApi = new apexApi();

		$getPlayer = $apexApi->getUserStat($searchNick,$platform);

		if ($getPlayer != 'Player not found') {
			$title = $searchNick.' статистика';
			$apexDb = new apexDb();
			$apexDb->updateData($getPlayer);
			header('Location: /profile/'.rawurlencode($_GET['platform']).'/'.rawurlencode($_GET['nick']));
		}else{
			$error = true;
		}
	}

	if (isset($_GET['match']) && !empty($_GET['match'])) {
		$offsetPages = (int)htmlspecialchars($_GET['match'])*20;
		$getPlayerMatch = R::findAll('match_players','uid = ? ORDER BY id DESC LIMIT ?',array($searchPlayer->uid,$offsetPages));
		$allCount = R::count('match_players','uid = ? ORDER BY id',array($searchPlayer->uid));
	}else{
		$getPlayerMatch = R::findAll('match_players', 'uid = ? ORDER BY id DESC LIMIT 20',array($searchPlayer->uid));
		$allCount = R::count('match_players','uid = ? ORDER BY id',array($searchPlayer->uid));
	}

}

if (isset($_GET['platform']) && isset($_GET['nick']) && isset($_GET['update']) && !empty($_GET['platform'] && !empty($_GET['nick']))) {
	$searchNick = rawurldecode(trim(htmlspecialchars($_GET['nick'])));
	$platformSearch = htmlspecialchars($_GET['platform']);

	if ($platformSearch == 'pc' OR $platformSearch == 'xbox' OR $platformSearch == 'ps4') {
		if ($platformSearch == 'pc') {
			$platform = 'PC';
		}elseif ($platformSearch == 'xbox') {
			$platform = 'X1';
		}elseif ($platformSearch == 'ps4') {
			$platform = 'PS4';
		}
	}

	$getIdByNick = R::findOne('players','nick_name = ?',array($searchNick));

	$apexApi = new apexApi();

	$getPlayer = $apexApi->getUserStat((int)$getIdByNick->uid,$platform);

	if ($getPlayer != 'Player not found') {
		$apexDb = new apexDb();
		$apexDb->updateLegends($getPlayer);
		header('Location: /profile/'.rawurlencode($_GET['platform']).'/'.rawurlencode($_GET['nick']));
	}else{
		$error = true;
	}

	header('Location: /profile/'.$_GET['platform'].'/'.$_GET['nick']);
}

include 'inc/header.php';

if (!$error) {

	$bsd = $searchPlayer->nick_name;

	?>

	<div class="leaderPageBack w-100"></div>
	<div class="player-background">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="playerTitle">
						<div class="playerInfo w-100">
							<div class="avatar 
							<?if($searchPlayer->online == 1){
								if ($searchPlayer->in_game == 'true') {
									echo 'inMatch';
								}else{
									echo 'online';
								}
							}
								?>
							">
								<img src="<?=$searchPlayer->avatar?>" width="100px" height="100px" alt="">
							</div>
							<div class="nickName">
								<?=$searchPlayer->nick_name?> 
								<?
								if ($searchPlayer->platform == 'PC') {
									echo '<i class="fab fa-windows"></i>';
								}elseif ($searchPlayer->platform == 'X1') {
									echo '<i class="fab fa-xbox"></i>';
								}elseif ($searchPlayer->platform == 'PS4') {
									echo '<i class="fab fa-playstation"></i>';
								}else{
									echo "undefine platform";
								}
								?>
							</div>

							<?if($searchPlayer->online == 1){?>
								<div class="status">
									<?
									if ($searchPlayer->in_game == 'true') {
										echo '<span class="inGame">В матче - Каньон Кингс</span>';
									}else{
										echo '<span class="online">В лобби</span>';
									}
									?>
								</div>
								<?}?>

								<div class="update">
									<a href="<?=rawurlencode($bsd)?>/update"><i class="fas fa-sync-alt"></i> Обновить статистику</a>
								</div>

								<div class="stats">
									<div class="stat">
										<span class="name">Уровень</span>
										<span class="value"><?=$searchPlayer->lvl;?></span>
										<span class="topPlace"><?=$placeInratingLvl = $placeInratingLvl?"#$placeInratingLvl->id":"-"?></span>
									</div>
									<div class="stat">
										<span class="name">Убийств</span>
										<span class="value"><?=$killsCount==0?'-':number_format($killsCount)?></span>
										<span class="topPlace"><?=$placeInratingKills = $placeInratingKills?"#$placeInratingKills->id":"-"?></span>
									</div>
									<div class="stat">
										<span class="name">Нанесено Урона</span>
										<span class="value"><?=$damageCount==0?'-':number_format($damageCount)?></span>
										<span class="topPlace"><?=$placeInratingDamage = $placeInratingDamage?"#$placeInratingDamage->id":"-"?></span>
									</div>
									<div class="stat">
										<span class="name">Матчей</span>
										<span class="value"><?=$matchCount==0?'-':number_format($matchCount)?></span>
										<span class="topPlace"><?=$placeInratingMatch = $placeInratingMatch?"#$placeInratingMatch->id":"-"?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="info-block clearfix h-100 w-100">
						<i class="fas fa-info-circle h-100"></i>
						Нет вашей легенды? Из-за ограничений игры мы можем получать только те данные которые установлены на вашем банере. Для того что-бы отобразить статистику на сайте установите её на баннер и нажмите на ссылку "Обновить статистику" возле вашего ника. Или подождите пока статистика обновится автоматически. Статистика обновляется каждые 2 минуты.
					</div>
				</div>

				<div class="col-12">

					<div class="legend selected-legend">
						<div class="title w-100">
							<?=legName($getUserLegends->legend_selected)?> - Выбран
						</div>
						<div class="playerStat w-100 h-100">
							<div class="stats w-100 h-100">
								<div class="lImg"><img src="/images/legends/<?=$getUserLegends->legend_selected?>.png" class="legendImg" alt=""></div>

								<div class="legStatList w-100">
									<ul class="legStats">
										<?
										foreach ($arrStatsTitle as $stat) {
											$val = $getUserLegends->legend_selected.'_'.$stat;
											if (!empty($getUserLegends->$val)) {
												?>
												<li>
													<span class="val"><?=number_format($getUserLegends->$val)?></span>
													<span class="name"><?=statsName($stat)?></span>
												</li>
												<?
											}
										}
										?>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<?
					if ($getUserAllLegends) {
						foreach($getUserAllLegends as $legends) {
							if ($legends != $getUserLegends->legend_selected && $legends != '') {
								?>
								<div class="legend">
									<div class="title w-100">
										<?=legName($legends)?>
									</div>
									<div class="playerStat w-100 h-100">
										<div class="stats w-100 h-100">
											<div class="lImg"><img src="/images/legends/<?=$legends?>.png" class="legendImg" alt=""></div>

											<div class="legStatList w-100">
												<ul class="legStats">
													<?
													foreach ($arrStatsTitle as $stat) {
														$val = $legends.'_'.$stat;
														//echo $val.'</br>';
														if (isset($getUserLegends->$val)) {?>
															<li>
																<span class="val"><?=number_format($getUserLegends->$val)?></span>
																<span class="name"><?=statsName($stat)?></span>
															</li>
															<?
														}
													}
													?>
												</ul>
											</div>
										</div>
									</div>
								</div>
								<?}
							}
						}?>
						<div class="match">
							<div class="title">
								Матчи
							</div>
							<?if($getPlayerMatch) {
								foreach ($getPlayerMatch as $match) {?>
							<div class="matchInfo">
								<div class="match w-100">
									<div class="timeInfo">
										<div class="timeago">
											<?=get_time_ago($match->time)?>
										</div>
										<div class="time">
											<?=date("H:i",$match->time)?>
										</div>
									</div>
									<div class="character">
										<div class="legendMatch">
											<?=legName($match->legend_match)?>
										</div>
										<div class="name">
											Персонаж
										</div>
									</div>
									<div class="matchStat">
										<div class="value">
											<?=$match->kills != NULL?$match->kills:'0'?>
										</div>
										<div class="name">
											Убийств
										</div>
									</div>
									<div class="matchStat" style="width: 10%;">
										<div class="value">
											<?=$match->damages != NULL?$match->damages:'0'?>
										</div>
										<div class="name">
											Урона
										</div>
									</div>
									<div class="matchStat">
										<div class="value">
											<?=$match->match_count != NULL?$match->match_count:'0'?>
										</div>
										<div class="name">
											Матчей
										</div>
									</div>
								</div>
							</div>
							<?}
							if ((int)($allCount-count($getPlayerMatch)) > 0) {?>
							<div class="showMore">
								<a id="showMore" href="">Показать еще</a>
							</div>
						<?}}else{?>
								<div class="matchInfo">
									<div style="display: flex; justify-content: center; width: 100%;">С момента первого просмотра профиля вы еще не играли в Apex. Сыграйте пару матчей и они появятся тут.</div>
								</div>
							<?}?>
						</div>
					</div>
				</div>
			</div>

			<?
		}else{?>
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="info-block error mt-50 clearfix w-100">
							<i class="fas fa-info-circle h-100"></i>
							К сожалению мы не смогли найти ваш профиль на платформе - <?=$platformSearch?>. Проверьте правильность написания ника и выбранную платформу, затем попытайтесь снова.
						</div>
					</div>
				</div>
			</div>
			<?}

			include 'inc/footer.php';
			?>