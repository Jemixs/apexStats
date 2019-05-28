<?php
include 'inc/system.php';
?>
<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>ApexStats - Карта игрового мира Apex.</title>
	<link rel="icon" type="image/png" href="/favicon.png">
	<meta name="description" content="Проверьте свою детальную статистику и рейтинг лидеров для ПК, Xbox и Playstation">
	<meta name="keywordws" content="apex, apex stats, апекс статистика, статистика, арех, арех статистика, стата apex, apex legends stats, apex legends статистика, карта apex, apex legends map, apex legends карта">
	<meta property="og:title" content="ApexStats - <?=$title?:'Apex Legends статистика'?>" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="https://apexstats.ru" />
	<meta property="og:image" content="https://mini.s-shot.ru/1920x1200/JPEG/1920/Z100/?https://apexstats.ru/mini.s-shot.jpg" />
	<meta property="og:locale" content="ru_RU">
	<meta property="og:description " content="Проверьте свою детальную статистику и рейтинг лидеров для ПК, Xbox и Playstation">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link type="text/css" rel="stylesheet" href="/css/leaflet/leaflet.css" />
	<link type="text/css" rel="stylesheet" href="/css/leaflet/style.css?1111120" />
	<link type="text/css" rel="stylesheet" href="/css/leaflet/leaflet.draw.css" />
	<link rel="stylesheet" href="/css/style.css?1111120">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
</head>
<body>
	<div class="page-header" style="position: absolute; z-index: 9999; width: 100%;">
		<div class="container">
			<div class="row">
				<div class="col-6 col-xl-6 col-lg-6 col-md-8 d-md-block d-sm-none d-none">
					<div class="menu">
						<a href="/">
							<div class="logo">
								<img src="/images/logo.png" alt="">
							</div>
						</a>

						<ul class="h-100">
							<li><a href="/">ГЛАВНАЯ</a></li>
							<li><a href="/leaderbord">ТОП ИГРОКОВ</a></li>
							<li><a href="/maps">КАРТА</a></li>
							<li><a href="/discord">DISCORD</a></li>
						</ul>
					</div>
				</div>
				<div class="col-3 col-xl-3 col-lg-3 col-md-4 d-md-block d-sm-none d-none">
					<div class="headerSearch h-100 w-100">
						<input class="text-field " type="text" id="headerNick" placeholder="Никнейм">
						<div class="platform">
							<i class="fab fa-windows" id="pc"></i>
							<i class="fab fa-xbox" id="xbox"></i>
							<i class="fab fa-playstation" id="ps4"></i>
						</div>
						<button class="send-form" id="searchPlayer"><i class="fas fa-search" id="searchPlayer"></i></button>
					</div>
				</div>
				<div class="col-3 col-lg-3 col-xl-3 d-lg-block d-md-none d-sm-none d-none">
					<div class="discBlock h-100">
						<a href="/discord" class="discordButton"><i class="fab fa-discord"></i> <span>Посети наш Discord</span></a>
					</div>
				</div>

				<div class="col-12 d-sm-block d-md-none">
					<div class="mobi-header">
						<a href="/">
							<div class="logo">
								<img src="/images/logo.png" alt="">
							</div>
						</a>

						<div class="openMenu text-right" id="xsHeaderOpen">
							<i class="fas fa-bars"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="xsHeader">
		<a class="closeWindow" id="xsHeaderClose" href="">
			<span class="closeIco"></span> <span class="labeClose">Закрыть</span>
		</a>

		<ul class="ulMenu">
			<li><a href="/">ГЛАВНАЯ</a></li>
			<li><a href="/leaderbord">ТОП ИГРОКОВ</a></li>
			<li><a href="/maps">КАРТА</a></li>
			<li><a href="/discord">DISCORD</a></li>
		</ul>

		<div class="headerSearch">
			<input class="text-field" type="text" id="xsheaderNick" placeholder="Никнейм">
			<div class="platform">
				<i class="fab fa-windows" id="pc"></i>
				<i class="fab fa-xbox" id="xbox"></i>
				<i class="fab fa-playstation" id="ps4"></i>
			</div>
			<button class="send-form" id="xssearchPlayer"><i class="fas fa-search" id="xssearchPlayer"></i></button>
		</div>

		<div class="discBlock w-100">
			<a href="/discord" class="discordButton"><i class="fab fa-discord"></i> Посети наш Discord</a>
		</div>
	</div>

	<div class="hideSidebar" id="hideSidebarMap" data-target="active"><a href=""><div class="nav-icon"><div></div></div> <span>Скрыть панель</span></a></div>
	<div class="mapSidebar h-100">
		<div class="logo w-100"><img src="/images/logo-game.png" alt=""></div>
		<div class="menu">
			<ul>
				<li><a href="" class="cheked" id="textmarkers"><i class="fab fa-accusoft"></i> Названия локаций</a></li>
				<li><a href="" class="cheked" id="resp"><img src="/images/respawn-point.png" width="30px" alt=""> Точки возрождения</a></li>
				<li><a href="" class="cheked" id="scaner"><img src="/images/scaner-point.png" width="30px" alt=""> Сканеры зоны </a></li>
				<li><a href="" class="cheked" id="tierThree"><i class="fas fa-trophy"></i> Зона эпического лута</a></li>
				<li><a href="" class="cheked" id="tierTwo"><i class="fas fa-user-astronaut" style="font-size: 22px;"></i> Зона редкого лута</a></li>
				<li><a href="" class="cheked" id="tierOne"><i class="fas fa-tshirt"></i> Зона обычного лута</a></li>
			</ul>
		</div>
		<div class="showAll"><a href="" id="showAll" data-target="active"><i class="fas fa-eye"></i> Скрыть все</a></div>
		<div class="barFoot">
			<p>© ApexStats.ru 2019. All rights reserved. Apex Legends is a registered trademark of EA.</p>
		</div>
	</div>
	<div id="map"></div>


	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- Leaflet -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.4/leaflet.js"></script>
	<!-- Leaflet Plugin -->
	<script src="/js/leaflet/leaflet.draw.js"></script>
	<!-- Fullscren Control -->
	<script src="/js/leaflet/FullScreen.js" charset="utf-8"></script>
	<!-- JS -->
	<script src="js/leaflet/markers.min.js?1111120" type="text/javascript"></script>
	<script src="js/leaflet/functions.min.js?1111120" type="text/javascript"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="/js/main.min.js?1111120"></script>
	<script src="/js/jquery.nice-select.min.js"></script>
</body>
</html>
