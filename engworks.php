<?php
include 'inc/system.php';
?>

<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" lang="ru">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>ApexStats - <?=$title?:'Apex Legends статистика'?></title>
	<meta name="description" content="<?=$desc = $desc?$desc:'Проверьте свою детальную статистику и рейтинг лидеров для ПК, Xbox и Playstation'?>">
	<meta name="keywordws" content="apex, apex stats, апекс статистика, статистика, арех, арех статистика, стата apex, apex legends stats, apex legends статистика, карта apex, apex legends map, apex legends карта">
	<link rel="icon" type="image/png" href="/favicon.png">
	<meta property="og:title" content="ApexStats - <?=$title?:'Apex Legends статистика'?>" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="https://apexstats.ru" />
	<meta property="og:image" content="https://mini.s-shot.ru/1920x1200/JPEG/1920/Z100/?https://apexstats.ru/mini.s-shot.jpg" />
	<meta property="og:locale" content="ru_RU">
	<meta property="og:description " content="<?=$desc = $desc?$desc:'Проверьте свою детальную статистику и рейтинг лидеров для ПК, Xbox и Playstation'?>">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="/css/nice-select.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	<link rel="stylesheet" href="/css/jquery.growl.css">
	<link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>
<body>
	<div class="engWork">
		<div class="back" style="background-image: url(./images/background2.jpg);"></div>
		<div class="container h-100">
			<div class="row h-100">
				<div class="col-12 h-100">
					<div class="engCenter">
						<div class="content">
							<div class="logo">
								<img src="images/logo_text.png" alt="">
							</div>
							<div class="text">
								На сайте проводятся технические работы. 
							</div>
							<div class="discBlock w-100">
								<a href="" class="discordButton"><i class="fab fa-discord"></i> Посети наш Discord</a>
							</div>

							<div class="copyright">
								© ApexStats 2019. Все права защищены. Apex Legends это зарегистрированная торговая марка EA.
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="spinner w-100 h-100"><p>Загрузка</p><div class="back w-100 h-100"> </div><div class="loader"></div></div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="/js/jquery.growl.js"></script>
	<script src="/js/jquery.nice-select.min.js"></script>
	<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
	<script src="/js/main.js"></script>
</body>
</html>