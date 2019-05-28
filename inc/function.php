<?php

function monts($mon) {
	$arrMon = [
		'January'=>'Января',
		'February'=>'Февраль',
		'March'=>'Март',
		'April'=>'Апрель',
		'May'=>'Май',
		'June'=>'Июнь',
		'July'=>'Июль',
		'August'=>'Август',
		'September'=>'Сентябрь',
		'October'=>'Октябрь',
		'November'=>'Ноябрь',
		'December'=>'Декабрь',
	];

	return $arrMon[$mon];
}

function legName($name) {
	$arrName = [
		'bangalore'=>'Бангалор',
		'bloodhound'=>'Бладхаунд',
		'gibraltar'=>'Гибралтар',
		'caustic'=>'Каустик',
		'lifeline'=>'Лайфлайн',
		'mirage'=>'Мираж',
		'pathfinder'=>'Патфайндер',
		'wraith'=>'Рэйф',
		'octane'=>'Октейн'
	];

	return $arrName[$name];
}

function statsName($name) {
	$arrName = [
		'kills'=>'Убийств',
		'games_played'=>'Матчей сыграно',
		'lmg_kills'=>'Убийств с пулемета',
		'damage'=>'Урона',
		'headshots'=>'Попаданий в голову',
		'winning_kills'=>'Победных убийств',
		'kill_leader_kills'=>'Убийств в роли лидера',
		'pistol_kills'=>'Убийств с пистолетов',
		'shotgun_kills'=>'Убийств с дробовиков',
		'ar_kills'=>'Убийств с винтовок',
		'wins_full_squad'=>'Побед с полным отрядом',
		'sniper_kills'=>'Cнайперских убийств',
		'revives' => 'Поднял союзников',
		'finishers' => 'Добил противников',
		'health_drone_healing' => 'Лечение дрона',
		'revive_shield_damage_blocked' => 'Щит спасатель заблокировал урона',
		'drop_call' => 'Вызвано припасов',
		'encore_executions_escaped' => 'Сорвано казней',
		'decoys_created' => 'Создано приманок',
		'bamboozles' => 'Розыгрыши',
		'top_3' => 'Дошел до ТОП 3',
		'eye_enemies_scanned' => 'Врагов просканированно',
		'smg_kills' => 'Убийств с ПП',
		'nox_gassed_enemies_killed' => 'Убито газом NOX'
	];

	if (array_key_exists($name, $arrName)) {
		return $arrName[$name];
	}else{
		return $name;
	}
}


function debug($data) {
	echo '<pre>',print_r($data,true),'</pre>';
}

function get_time_ago( $time )
{
    $time_difference = time() - $time;

    if( $time_difference < 1 ) { return 'менее 1 секунды назад'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'год',
                30 * 24 * 60 * 60       =>  'месяц',
                24 * 60 * 60            =>  'день',
                60 * 60                 =>  'час',
                60                      =>  'минута',
                1                       =>  'секунд'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;
        if( $d >= 1 )
        {
        	$t = round( $d );
        	if ($str == 'час' && $t>1 && $t<5) {
        		$str='часа';
        	}elseif ($str == 'час' && $t>4) {
        		$str = 'часов';
        	}elseif ($str == 'минута' && $t>1 && $t<5) {
        		$str = 'минуты';
        	}elseif ($str == 'минута' && $t>4) {
        		$str = 'минут';
        	}elseif ($str == 'день' && $t>1 && $t<5) {
        		$str = 'дня';
        	}elseif ($str == 'день' && $t>4) {
        		$str = 'дней';
        	}elseif ($str == 'месяц' && $t>1) {
        		$str = 'месяца';
        	}elseif ($str == 'месяц' && $t>4) {
        		$str = 'месяцей';
        	}

            return $t.' '.$str.' назад';
        }
    }
}