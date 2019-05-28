<?php
include 'inc/system.php';

$getAllNews = R::findAll('news','ORDER BY id DESC LIMIT 10');

if (isset($_GET['ref'])) {
	header('Location: /');
}

$getLeaderBord = R::findAll('leaderbord_pc','ORDER BY id LIMIT 10');



if (isset($_POST) && !empty($_POST['searchPlayer'])) {
	//echo '<pre>',print_r($_POST),'</pre>';

	$platform = htmlspecialchars($_POST['platform']);
	$nick = trim(htmlspecialchars($_POST['nick']));

	header('Location: /profile/'.rawurlencode($platform).'/'.rawurlencode($nick));
}

if (isset($_GET['discord'])) {
	header('Location: '.DISCORD_LINK);
}

include 'inc/header.php';
?>
<div class="container">
	<div class="row">
		<div class="col-1 text-left"><p class="newsTitle">Новости</p></div>
		<?
		if ($authorization) {
			?>
			<div class="col-11 text-right">
				<a href="/edit-post/new" class="newPost-button"><i class="fas fa-marker"></i> Создать статью</a>
			</div>
			<?
		}
		?>

		<div class="w-100"></div>
		<div class="col-12 col-md-12 col-lg-8 col-sm-12 col-xs-8">
			<div class="newsBlock">
				<?if ($getAllNews) {?>
					<ul>
						<?foreach ($getAllNews as $news) {
							if ($news->visible == 1 OR $news->visible == 0 && $authorization) {
							?>
							<li <?=$styleVisible = $news->visible==0?'style="border: 1px solid red; opacity: 0.5;"':''?>>
								<a class="item" href="news/<?=$news->id?>/">
									<div class="newsItem">
										<div class="backImg" style="background-image: url(<?=$news['img']?>);"></div>
										<span class="news-title"><?=$news['title']?></span>
										<span class="news-date">
											<?=monts(date("F",$news['date_created']))?>
											<?=date("d, Y G:i",$news['date_created']);?>
											<?
											if ($authorization) {
												?>
												<div class="mod-block">
													<a href="/edit-post/hideToogle/<?=$news->id?>" title="<?=$hide = $news->visible==1?'Скрыть':'Отобразить'?>"><?=$iconType = $news->visible==1?'<i class="fas fa-eye-slash"></i>':'<i class="fas fa-eye"></i>'?></a>
													<a href="/edit-post/edit/<?=$news->id?>" title="Редактироввать"><i class="fas fa-edit"></i></a>
													<a href="/edit-post/remove/<?=$news->id?>" title="Удалить"><i class="far fa-trash-alt"></i></a>
												</div>
												<?}
												?>
											</span>
											<span class="news-desc">
												<p><?=$news['description']?></p>
											</span>
										</div>
									</a>
								</li>
							<?
						}
						}?>
					</ul>
						<?}?>
			</div>
		</div>
		<div class="col-12 col-md-8 col-lg-4 col-sm-12 col-xs-4 mx-auto">
			<div class="mini-leaderBord donation">
				<p class="title">ПОЖЕРТВОВАНИЯ <i class="fas fa-donate"></i></p>
				<div class="desc">
					<span>Цель:</span> на развитие и продвижение сайта. 
				</div>

				<div class="progress"><div class="bar" style="width: 7%;">60/</div>1000 RUB</div>

				<div class="text-center" style="padding: 5px 0 10px 0">
					<a href="https://www.donationalerts.com/r/jemixs" class="newPost-button"><i class="fas fa-ruble-sign"></i> ПОЖЕРТВОВАТЬ</a>
				</div>
			</div>

			<div class="mini-leaderBord" style="margin-top: 30px">
				<p class="title">ТОП ИГРОКОВ <i class="fab fa-windows"></i></p>
				<table width="100%" style="table-layout: fixed;">
					<tbody>
						<tr>
							<th width="15%" style="text-align: center;">#</th>
							<th width="40%">Ник</th>
							<th class="text-center">Убийств</th>
							<th class="text-center">Матчей</th>
						</tr>
						<?
						foreach ($getLeaderBord as $lider) {
							$getInfoPlayer = R::findOne('players', 'uid = ?',[$lider->top_kills]);

							$getPlayerLegendStat = R::findOne('legends_players','uid = ?',[$lider->top_kills]);

							$param1 = @(int)$getPlayerLegendStat['lifeline_kills']+@(int)$getPlayerLegendStat['wraith_kills']+@(int)$getPlayerLegendStat['bangalore_kills']+@(int)$getPlayerLegendStat['bloodhound_kills']+@(int)$getPlayerLegendStat['mirage_kills']+@(int)$getPlayerLegendStat['pathfinder_kills']+@(int)$getPlayerLegendStat['gibraltar_kills']+@(int)$getPlayerLegendStat['caustic_kills']+@(int)$getPlayerLegendStat['octane_kills'];

							$param2 = @(int)$getPlayerLegendStat['lifeline_games_played']+@(int)$getPlayerLegendStat['wraith_games_played']+@(int)$getPlayerLegendStat['bangalore_games_played']+@(int)$getPlayerLegendStat['bloodhound_games_played']+@(int)$getPlayerLegendStat['mirage_games_played']+@(int)$getPlayerLegendStat['pathfinder_games_played']+@(int)$getPlayerLegendStat['gibraltar_games_played']+@(int)$getPlayerLegendStat['caustic_games_played']+@(int)$getPlayerLegendStat['octane_games_played'];
							?>
							<tr>
								<td class="place"><?=$lider->id?></td>
								<td class="nick"><a href="/profile/pc/<?=rawurlencode($getInfoPlayer->nick_name)?>"><?=$getInfoPlayer->nick_name?></a></td>
								<td class="rating"><?=number_format($param1)?></td>
								<td class="wins"><?=$kills = $param2 == 0?'-':$param2;?></td>
							</tr>
							<?}?>
						</tbody>
					</table>
					<a class="moreLeader h-100" href="/leaderbord">Ещё <i class="fas fa-chevron-down"></i></a>
				</div>
		</div>
		</div>
	</div>
	<?
	include 'inc/footer.php';
	?>