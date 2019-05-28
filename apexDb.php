<?php

class apexDb
{
    public function __construct()
    {

        R::ext('xdispense', function ($table_name) {
            return R::getRedBean()->dispense($table_name);
        });
    }

    /**
     * @param $userInfo
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateData($userInfo)
    {
        if ($userInfo != 'Player not found') {
            $checkPlayer = R::findOne('players','uid = ?',array($userInfo['userInfo']['uid']));
            $newApexApi = new apexApi();

            if ($checkPlayer) {
                $checkPlayer->avatar = $newApexApi->getAvatar($userInfo['userInfo']['nick'],$userInfo['userInfo']['hardware']);
                $checkPlayer->nickName = $userInfo['userInfo']['nick'];
                $checkPlayer->lvl = $userInfo['userInfo']['level'];
                $checkPlayer->online = $userInfo['userInfo']['online'];
                $checkPlayer->in_game = $userInfo['userInfo']['inMatch'];
                $checkPlayer->last_update = time();

                $upPlayer = R::store($checkPlayer);
            }else{
                $player = R::dispense( 'players' );
                $player->uid = $userInfo['userInfo']['uid'];
                $player->avatar = $newApexApi->getAvatar($userInfo['userInfo']['nick'],$userInfo['userInfo']['hardware']);
                $player->nickName = $userInfo['userInfo']['nick'];
                $player->lvl = $userInfo['userInfo']['level'];
                $player->platform = $userInfo['userInfo']['hardware'];
                $player->online = $userInfo['userInfo']['online'];
                $player->in_game = $userInfo['userInfo']['inMatch'];
                $player->last_update = time();

                $upPlayer = R::store($player);
            }

            $getPlayerLegends = R::findOne('legends_players','uid = ?',array($userInfo['userInfo']['uid']));

            if (!$getPlayerLegends) {
                $makeLegend = R::xdispense( 'legends_players' );
                $makeLegend->uid = $userInfo['userInfo']['uid'];
                $makeLegend->legend_selected = $userInfo['userInfo']['legendSelected']['name'];

                if ($userInfo['userInfo']['hardware'] == 'PC') {
                    $platform = 'pc';
                }elseif($userInfo['userInfo']['hardware'] == 'X1') {
                    $platform = 'xbl';
                }elseif($userInfo['userInfo']['hardware'] == 'PS4') {
                    $platform = 'psn';
                }
                $newApexApi = new apexApi();
                $getTRNstat = $newApexApi->checkTRN($userInfo['userInfo']['nick'],$platform);

                $legendsArr = [];
                foreach ($getTRNstat as $legendName => $arrStat) {
                    $legendsArr[] = $legendName;
                    foreach ($arrStat as $legSta) {
                        if (!stristr($legSta['name'],'per_match')) {
                            $legName = $legSta['name'];
                            if ($makeLegend->$legName < $legSta['value']) {
                                $makeLegend->$legName = $legSta['value'];
                            }
                        }
                    }
                }

                $makeLegend->all_legends = serialize($legendsArr);
                $makeLegend->updated = 1;
                $upPlayerLegend = R::store($makeLegend);
            }else{
                $getLegendsList = unserialize($getPlayerLegends->all_legends);
                
                if (in_array($userInfo['userInfo']['legendSelected']['name'],$getLegendsList) == 0) {
                    $newArrLegends = array_push($getLegendsList,$userInfo['userInfo']['legendSelected']['name']);
                    $getPlayerLegends->all_legends = serialize($getLegendsList);
                }

                $getPlayerLegends->legend_selected = $userInfo['userInfo']['legendSelected']['name'];

                foreach ($userInfo['userInfo']['legendSelected']['stats'] as $legend) {
                    if ($legend['name'] != 'empty' && $legend['name'] != 'undefined' ) {
                        $legend_stat = $userInfo['userInfo']['legendSelected']['name'].'_'.$legend['name'];
                        $getPlayerLegends->$legend_stat = $legend['value'];
                    }
                }

                $upPlayerLegend = R::store($getPlayerLegends);
            }

        }
    }

    /**
     * @param $userInfo
     */
    public function updateLegends($userInfo) {
        $checkPlayer = R::findOne('players','uid = ?',array($userInfo['userInfo']['uid']));

        if ($checkPlayer) {
            $checkPlayer->nickName = $userInfo['userInfo']['nick'];
            $checkPlayer->lvl = $userInfo['userInfo']['level'];
            $checkPlayer->online = $userInfo['userInfo']['online'];
            $checkPlayer->in_game = $userInfo['userInfo']['inMatch'];
            $checkPlayer->last_update = time();
            $checkPlayer->updated = 0;

            $upPlayer = R::store($checkPlayer);
        }

        $getPlayerLegends = R::findOne('legends_players','uid = ?',array($userInfo['userInfo']['uid']));

        if ($getPlayerLegends && $getPlayerLegends->updated == 1) {
            $getLegendsList = unserialize($getPlayerLegends->all_legends);

            if (in_array($userInfo['userInfo']['legendSelected']['name'],$getLegendsList) == 0) {
                $newArrLegends = array_push($getLegendsList,$userInfo['userInfo']['legendSelected']['name']);
                $getPlayerLegends->all_legends = serialize($getLegendsList);
            }

            $getPlayerLegends->legend_selected = $userInfo['userInfo']['legendSelected']['name'];

            foreach ($userInfo['userInfo']['legendSelected']['stats'] as $legend) {
                if ($legend['name'] != 'empty' && $legend['name'] != 'undefined' ) {
                    $legend_stat = $userInfo['userInfo']['legendSelected']['name'].'_'.$legend['name'];

                    $legKills = $userInfo['userInfo']['legendSelected']['name'].'_kills';
                    if ($legend_stat == ($userInfo['userInfo']['legendSelected']['name'].'_kills') && $legend['value'] > $getPlayerLegends[$legKills]){

                        $legKillsVal = $legend['value']-(int)$getPlayerLegends[$legKills];
                    }

                    $legDmg = $userInfo['userInfo']['legendSelected']['name'].'_damage';
                    if ($legend_stat == ($userInfo['userInfo']['legendSelected']['name'].'_damage') && $legend['value'] > $getPlayerLegends[$legDmg]){

                        $legDmgVal = $legend['value']-(int)($getPlayerLegends[$legDmg]);
                    }

                    $legPlayed = $userInfo['userInfo']['legendSelected']['name'].'_games_played';
                    if ($legend_stat == ($userInfo['userInfo']['legendSelected']['name'].'_games_played') && $legend['value'] > $getPlayerLegends[$legPlayed]){

                        $legPlayedVal = $legend['value']-(int)($getPlayerLegends[$legPlayed]);
                    }

                    $getPlayerLegends->$legend_stat = $legend['value'];
                }
            }

            if ($legKillsVal > 0 OR $legDmgVal > 0 OR $legPlayedVal > 0) {
                $matchPlyaer = R::xdispense( 'match_players' );
                $matchPlyaer->uid = $userInfo['userInfo']['uid'];
                $matchPlyaer->legend_match = $userInfo['userInfo']['legendSelected']['name'];
                $matchPlyaer->kills = $legKillsVal;
                $matchPlyaer->damages = $legDmgVal;
                $matchPlyaer->match_count = $legPlayedVal;
                $matchPlyaer->time = time();

                $saveMatch = R::store($matchPlyaer);
            }

            $upPlayerLegend = R::store($getPlayerLegends);
        }elseif ($getPlayerLegends && $getPlayerLegends->updated == 0) {
            $getLegendsList = unserialize($getPlayerLegends->all_legends);

            $getPlayerLegends->legend_selected = $userInfo['userInfo']['legendSelected']['name'];

            $newApexApi = new apexApi();
            if ($userInfo['userInfo']['hardware'] == 'PC') {
                $platform = 'pc';
            }elseif($userInfo['userInfo']['hardware'] == 'X1') {
                $platform = 'xbl';
            }elseif($userInfo['userInfo']['hardware'] == 'PS4') {
                $platform = 'psn';
            }
            $getTRNstat = $newApexApi->checkTRN($userInfo['userInfo']['nick'],$platform);

            $legendsArr = [];
            foreach ($getTRNstat as $legendName => $arrStat) {
                $legendsArr[] = $legendName;
                if (!empty($getPlayerLegends)) {
                    $newArrLegends = array_push($getLegendsList,$legendsArr);
                    $getPlayerLegends->all_legends = serialize($legendsArr);
                }
                   foreach ($arrStat as $legSta) {
                       if (!stristr($legSta['name'],'per_match')) {
                          $legName = $legSta['name'];
                          if ($getPlayerLegends->$legName < $legSta['value']) {
                              $getPlayerLegends->$legName = $legSta['value'];
                          }
                      }
                   }
            }

            if (empty($getLegendsList)) {
                $getPlayerLegends->all_legends = serialize($legendsArr);
            }
            $getPlayerLegends->updated = 1;
            $upPlayerLegends = R::store($getPlayerLegends);
        }
    }
}