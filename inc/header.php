<?php
/**
 * Created by PhpStorm.
 * User: jEMIXS
 * Date: 05.03.2019
 * Time: 20:51
 */
?>
<!doctype html>
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
    <?if ($_SERVER['REQUEST_URI'] == '/') {?>
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-12">
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
                            </ul>
                        </div>
                        <div class="mobi-header d-sm-block d-md-none">
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
                    <div class="col-xl-6 offset-xl-3 col-lg-8 offset-lg-2">
                        <p class="aboutTitle text-center">ApexStats - статистика с любых устройств</p>
                        <div class="searchIndex">
                            <form method="POST" style="display: flex; width: 100%;">
                                <input type="text" class="name"  id="headerNick" name="nick" placeholder="Ник игрока" required>
                                <select class="platform-select" name="platform">
                                    <option value="pc">PC</option>
                                    <option value="xbox">XBOX</option>
                                    <option value="ps4">PSN</option>
                                </select>
                                <input type="submit" name="searchPlayer" class="search" value="НАЙТИ">
                            </form>
                        </div>

                        <div class="discBlock w-100">
                            <a href="/discord" class="discordButton"><i class="fab fa-discord"></i> Посети наш Discord</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <?}else {?>
           <div class="page-header">
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
        <?}?>
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
