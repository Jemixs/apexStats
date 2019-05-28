<?php
include 'inc/system.php';

$getNews = R::findOne('news','id  = ?',array($_GET['id']));

if (!$getNews) {
	header('Location: /');
}

$title = $getNews->title.' - новости';
$desc = $getNews->title;

$getSidebarNews = R::findAll('news', 'visible = 1 ORDER BY id LIMIT 3');
$getData = explode(' ', $getNews['date_created']);

if ($getNews->visible == 1 OR $getNews->visible == 0 && $authorization) {
	# code...
}else{
	header('Location: /');
}

include 'inc/header.php';
?>

<div class="leaderPageBack w-100"></div>
<div class="container pt-20">
	<div class="row">
		<div class="col-12 col-lg-9 col-xl-9 col-md-12 col-sm-12">
			<div class="newsPage w-100">
				<div class="titleImg w-100" style="background-image: url(<?=$getNews['img']?>);"></div>
				<?
				if ($authorization) {
					?>
					<div class="mod-block">
						<a href="/edit-post/hideToogle/<?=$getNews->id?>" title="<?=$hide = $getNews->visible==1?'Скрыть':'Отобразить'?>"><?=$iconType = $getNews->visible==1?'<i class="fas fa-eye-slash"></i>':'<i class="fas fa-eye"></i>'?></a>
						<a href="/edit-post/edit/<?=$getNews->id?>" title="Редактироввать"><i class="fas fa-edit"></i></a>
						<a href="/edit-post/remove/<?=$getNews->id?>" title="Удалить"><i class="far fa-trash-alt"></i></a>
					</div>
					<?}
					?>
				<div class="title">
					<span><?=$getNews['title']?></span>
				</div>
				<div class="datePost">
					<?=monts(date("F",$getNews['date_created']))?>
					<?=date("d, Y G:i",$getNews['date_created']);?>
				</div>
				<div class="newsText">
					<?=htmlspecialchars_decode($getNews['content'])?>
				</div>
			</div>
		</div>

		<div class="col-12 col-lg-3 col-xl-3 col-md-12 col-sm-12">
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

		<?
		include 'inc/footer.php';
		?>