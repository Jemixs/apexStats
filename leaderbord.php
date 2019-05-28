<?php
include 'inc/system.php';
require 'vendor/autoload.php';

$title = 'ТОП игроков';

$getSidebarNews = R::findAll('news', 'visible = 1 ORDER BY id LIMIT 3');

if (!empty($_GET['platform'])) {
	$sortPlatform = htmlspecialchars($_GET['platform']);

	if ($sortPlatform == 'pc') {
		$platform = 5;
		$typeTable = 'leaderbord_pc';
	}elseif ($sortPlatform == 'xbox') {
		$platform = 1;
		$typeTable = 'leaderbord_xbox';
	}elseif ($sortPlatform == 'ps4') {
		$platform = 2;
		$typeTable = 'leaderbord_psn';
	}else{
		$platform = 0;
		$typeTable = 'leaderbord';
	}
}else{
	$typeTable = 'leaderbord';
}

$countLeader = R::count($typeTable,'top_kills > 0');

if (isset($_GET['sort']) && !empty($_GET['sort'])) {
	$sortBy = htmlspecialchars($_GET['sort']);

	switch ($sortBy) {
		case 'kill':
			$selectSort = 'top_kills';
			$th1 = 'Убийств';
			$th2 = 'Матчей';

			$param = 'kills';
		break;

		case 'match':
			$selectSort = 'top_games';
			$th1 = 'Матчей';
			$th2 = 'Уровень';

			$param = 'match';
			$countLeader = R::count($typeTable,'top_games > 0');
		break;

		case 'damage':
			$selectSort = 'top_damage';
			$th1 = 'Урона';
			$th2 = 'Матчей';

			$param = 'damages';
			$countLeader = R::count($typeTable,'top_damage > 0');
		break;

		case 'level':
			$selectSort = 'top_lvl';
			$th1 = 'Уровень';
			$th2 = 'Матчей';

			$param = 'levels';
			$countLeader = R::count($typeTable,'top_lvl > 0');
		break;

		case 'head':
			$selectSort = 'top_headshot';
			$th1 = 'Хедшотов';
			$th2 = 'Матчей';

			$param = 'headshots';
			$countLeader = R::count($typeTable,'top_headshot > 0');
		break;
	}
}else{
	$sortBy = 'kill';
	$selectSort = 'top_kills';
	$th1 = 'Убийств';
	$th2 = 'Матчей';

	$param = 'kills';
}

$usersOnPage = 100;
$total = intval(($countLeader - 1) / $usersOnPage) + 1; 

if (!empty($_GET['page'])) {
	$page = $_GET['page']; 
	$page = intval($page);

	if(empty($page) or $page < 0) $page = 1; 
	if($page > $total) $page = $total; 

	$start = $page * $usersOnPage - $usersOnPage; 
}else{
	header('Location: /leaderbord/all/1');
}

if ($page != 1)
	$prevPage = "<a href=\"/leaderbord/$sortPlatform/".($page-1)."/".$sortBy."\">".($page-1)."</a>";
if ($page != $total) 
	$nextPage = "<a href=\"/leaderbord/$sortPlatform/".($page+1)."/".$sortBy."\">".($page+1)."</a>";
if ($page == 1 && ($page+2) <= $total) 
	$nexNxPage = "<a href=\"/leaderbord/$sortPlatform/".($page+2)."/".$sortBy."\">".($page+2)."</a>";
if ($page == $total && ($page-2) > 0) 
	$prevNxPage = "<a href=\"/leaderbord/$sortPlatform/".($page-2)."/".$sortBy."\">".($page-2)."</a>";


$selectPage = "<a href=\"/leaderbord/$sortPlatform/$page/$sortBy\" class=\"select\">".($page)."</a>";

$getLeaderBord = R::findAll($typeTable,' ORDER BY id LIMIT '.$start.','.$usersOnPage);

include 'inc/header.php';
?>

<div class="leaderPageBack w-100"></div>
<div class="leaderbord h-100">
	<div class="container">
		<div class="row">
			<div class="col-12 col-xl-9 col-lg-9 col-md-12 col-sm-12">
				<div class="tableBord">
					<div class="top w-100">
						<div class="title w-100">
							ТОП Игроков
						</div>
						<div class="settings w-100 clearfix">
							<div class="platform">
								<select name="slct" id="slct">
									<option value="all" id="selAll">Платформа</option>
									<option value="pc" id="selPc">PC</option>
									<option value="xbox" id="selXbox">XBOX</option>
									<option value="ps4" id="selPs4">PS4</option>
								</select>
							</div>
							<div class="sort">
								<select name="slct" id="sortSelc">
									<option value="kill">Отсортировать по:</option>
									<option value="kill">Убийствам</option>
									<option value="damage">Урону</option>
									<option value="head">Выстрелам в голову</option>
									<option value="match">Матчам</option>
									<option value="level">Уровню</option>
								</select>
							</div>
						</div>
					</div>

					<div class="pagesList">
						<a href="/leaderbord/<?=$sortPlatform?>/1/<?=$sortBy?>" class="firstPage">ПЕРВАЯ</a>
						<?=$prevNxPage?>
						<?=$prevPage?>
						<?=$selectPage?>
						<?=$nextPage?>
						<?=$nexNxPage?>
						<a href="/leaderbord/<?=$sortPlatform?>/<?=$total?>/<?=$sortBy?>" class="lastPage">ПОСЛЕДНЯЯ</a>
					</div>

					<div class="tableList">
						<table width="100%" style="table-layout: fixed;">
							<tbody>
								<tr>
									<th width="15%">Место</th>
									<th width="40%" class="player">Игрок</th>
									<th class="text-center kills"><?=$th1?></th>
									<th class="text-center match"><?=$th2?></th>
								</tr>
								<?foreach ($getLeaderBord as $player){
									if ($player->$selectSort == 0)
										continue;

									$getPlayerInfo = R::findOne('players','uid = ?',[$player->$selectSort]);

									$avatar = $getPlayerInfo?$getPlayerInfo->avatar:'https://secure.download.dm.origin.com/production/avatar/prod/1/599/416x416.JPEG';
									
									$getPlayerLegendStat = R::findOne('legends_players','uid = ?',[$player->$selectSort]);

									switch ($param) {
										case 'kills':
										$param1 = @(int)$getPlayerLegendStat['lifeline_kills']+@(int)$getPlayerLegendStat['wraith_kills']+@(int)$getPlayerLegendStat['bangalore_kills']+@(int)$getPlayerLegendStat['bloodhound_kills']+@(int)$getPlayerLegendStat['mirage_kills']+@(int)$getPlayerLegendStat['pathfinder_kills']+@(int)$getPlayerLegendStat['gibraltar_kills']+@(int)$getPlayerLegendStat['caustic_kills']+@(int)$getPlayerLegendStat['octane_kills'];

										$param2 = @(int)$getPlayerLegendStat['lifeline_games_played']+@(int)$getPlayerLegendStat['wraith_games_played']+@(int)$getPlayerLegendStat['bangalore_games_played']+@(int)$getPlayerLegendStat['bloodhound_games_played']+@(int)$getPlayerLegendStat['mirage_games_played']+@(int)$getPlayerLegendStat['pathfinder_games_played']+@(int)$getPlayerLegendStat['gibraltar_games_played']+@(int)$getPlayerLegendStat['caustic_games_played']+@(int)$getPlayerLegendStat['octane_games_played'];
										break;

										case 'match':
										$param1 = @(int)$getPlayerLegendStat['lifeline_games_played']+@(int)$getPlayerLegendStat['wraith_games_played']+@(int)$getPlayerLegendStat['bangalore_games_played']+@(int)$getPlayerLegendStat['bloodhound_games_played']+@(int)$getPlayerLegendStat['mirage_games_played']+@(int)$getPlayerLegendStat['pathfinder_games_played']+@(int)$getPlayerLegendStat['gibraltar_games_played']+@(int)$getPlayerLegendStat['caustic_games_played']+@(int)$getPlayerLegendStat['octane_games_played'];

										$param2 = (int)$getPlayerInfo->lvl;
										break;

										case 'damages':
										$param1 = @(int)$getPlayerLegendStat['lifeline_damage']+@(int)$getPlayerLegendStat['bangalore_damage']+@(int)$getPlayerLegendStat['bloodhound_damage']+@(int)$getPlayerLegendStat['gibraltar_damage']+@(int)$getPlayerLegendStat['caustic_damage']+@(int)$getPlayerLegendStat['mirage_damage']+@(int)$getPlayerLegendStat['pathfinder_damage']+@(int)$getPlayerLegendStat['wraith_damage']+@(int)$getPlayerLegendStat['octane_damage'];

										$param2 = @(int)$getPlayerLegendStat['lifeline_games_played']+@(int)$getPlayerLegendStat['wraith_games_played']+@(int)$getPlayerLegendStat['bangalore_games_played']+@(int)$getPlayerLegendStat['bloodhound_games_played']+@(int)$getPlayerLegendStat['mirage_games_played']+@(int)$getPlayerLegendStat['pathfinder_games_played']+@(int)$getPlayerLegendStat['gibraltar_games_played']+@(int)$getPlayerLegendStat['caustic_games_played']+@(int)$getPlayerLegendStat['octane_games_played'];
										break;

										case 'levels':
										$param1 = (int)$getPlayerInfo->lvl;
										
										$param2 = @(int)$getPlayerLegendStat['lifeline_games_played']+@(int)$getPlayerLegendStat['wraith_games_played']+@(int)$getPlayerLegendStat['bangalore_games_played']+@(int)$getPlayerLegendStat['bloodhound_games_played']+@(int)$getPlayerLegendStat['mirage_games_played']+@(int)$getPlayerLegendStat['pathfinder_games_played']+@(int)$getPlayerLegendStat['gibraltar_games_played']+@(int)$getPlayerLegendStat['caustic_games_played']+@(int)$getPlayerLegendStat['octane_games_played'];
										break;

										case 'headshots':
										$param1 = @(int)$getPlayerLegendStat['lifeline_headshots']+@(int)$getPlayerLegendStat['wraith_headshots']+@(int)$getPlayerLegendStat['bangalore_headshots']+@(int)$getPlayerLegendStat['bloodhound_headshots']+@(int)$getPlayerLegendStat['mirage_headshots']+@(int)$getPlayerLegendStat['pathfinder_headshots']+@(int)$getPlayerLegendStat['gibraltar_headshots']+@(int)$getPlayerLegendStat['caustic_headshots']+@(int)$getPlayerLegendStat['octane_headshots'];

										$param2 = @(int)$getPlayerLegendStat['lifeline_games_played']+@(int)$getPlayerLegendStat['wraith_games_played']+@(int)$getPlayerLegendStat['bangalore_games_played']+@(int)$getPlayerLegendStat['bloodhound_games_played']+@(int)$getPlayerLegendStat['mirage_games_played']+@(int)$getPlayerLegendStat['pathfinder_games_played']+@(int)$getPlayerLegendStat['gibraltar_games_played']+@(int)$getPlayerLegendStat['caustic_games_played']+@(int)$getPlayerLegendStat['octane_games_played'];
										break;
									}

									?>
									<tr>
										<td class="place">#<?=$player['id']?></td>
										<!-- <?
										if ($getPlayerInfo->platform == 'PC') {
											$platformPlayer = 'pc';
										}elseif ($getPlayerInfo->platform == 'X1') {
											$platformPlayer = 'xbox';
										}elseif ($getPlayerInfo->platform == 'PS4') {
											$platformPlayer = 'ps4';
										}else{
											echo "undefine platform";
										}
										?> -->
										<td class="nick"><a href="/profile/<?=$platformPlayer?>/<?=$getPlayerInfo->nick_name?>" id="playerLeadbord"><img src="<?=$avatar?>" alt=""> <?=$getPlayerInfo->nick_name?></a> 

											<?
											if ($getPlayerInfo->platform == 'PC') {
												echo '<i class="fab fa-windows"></i>';
											}elseif ($getPlayerInfo->platform == 'X1') {
												echo '<i class="fab fa-xbox"></i>';
											}elseif ($getPlayerInfo->platform == 'PS4') {
												echo '<i class="fab fa-playstation"></i>';
											}else{
												echo "undefine platform";
											}
											?>
										</td>
										<td class="kills" style="text-align: center;"><?=number_format($param1)?></td>
										<td class="wins"><?=$sumMatch = $param2 != 0?number_format($param2):'-'?></td>
									</tr>
									<?}?>
								</tbody>
							</table>
						</div>
						<div class="pagesList">
							<a href="/leaderbord/<?=$sortPlatform?>/1/<?=$sortBy?>" class="firstPage">ПЕРВАЯ</a>
							<?=$prevNxPage?>
							<?=$prevPage?>
							<?=$selectPage?>
							<?=$nextPage?>
							<?=$nexNxPage?>
							<a href="/leaderbord/<?=$sortPlatform?>/<?=$total?>/<?=$sortBy?>" class="lastPage">ПОСЛЕДНЯЯ</a>
						</div>
					</div>
				</div>

				<div class="col-12 col-xl-3 col-lg-3 col-md-12 col-sm-12">
					<div class="sidebarNews">
						<div class="title">Новости</div>
						<? if ($getSidebarNews) {
							foreach($getSidebarNews as $sideNews) {?>
								<div class="newsItem">
									<a href="/news/<?=$sideNews->id?>/">
										<div class="backImg w-100 h-100" style="background-image: url(<?=$sideNews['img']?>);"></div>
										<div class="newsTitle">
											<span><?=$sideNews['title']?></span>
										</div>
									</a>
								</div>
								<?}}?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?
			include 'inc/footer.php';
			?>
			<script>
				$(document).ready(function() {
					$('#slct').niceSelect();
					$('#sortSelc').niceSelect();
				});
			</script>