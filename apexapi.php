<?php

use GuzzleHttp\Exception\ClientException;

/**
 * Class apexApi
 */
class apexApi
{
    const XBOX_TOKEN = '0k0g8og080s88owg8gk40s08oogs8kc0ow0';
    const PSN_TOKEN = 'b5b8dc41-71c4-4346-8ab4-62f27dcbd6b2';

    const ORIGIN_MAIL = 'damags11@yandex.ru';
    const ORIGIN_PASS = 'Worldoftanks1';

    private $client;

    /**
     * @param $nickName
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getXboxUserData($nickName)
    {
        $guzzle = new GuzzleHttp\Client();
        $getUserArr = $guzzle->request('GET', 'https://xbl.io/api/v2/friends/search?gt=' . $nickName, [
            'headers' => [
                'Accept' => 'application/json',
                'X-Authorization' => self::XBOX_TOKEN,
                'Accept-Language' => 'en-US, en'
            ]
        ]);

        $retArr = [
            'xuid' => json_decode($getUserArr->getBody(), true)['profileUsers'][0]['id'],
            'avatarUrl' => json_decode($getUserArr->getBody(), true)['profileUsers'][0]['settings'][0]['value']
        ];

        if (isset(json_decode($getUserArr->getBody(), true)['code'])) {
            return ['error' => true];
        } else {
            return $retArr;
        }
    }

    /**
     * @param $nickName
     * @return array
     * @throws Exception
     */
    public function getPs4UserData($nickName)
    {
        try {
            $psClient = new PlayStation\Client();
            $psClient->login(self::PSN_TOKEN);

            $retArr = [
                'psnuid' => $psClient->user($nickName)->psnuid(),
                'avatarUrl' => $psClient->user($nickName)->avatarUrl()
            ];

            return $retArr;
        } catch (ClientException $e) {
            return ['error' => true];
        }
    }

    /**
     * @param $value - if value `string` = search by nick, if `int` = search by uid
     * @param string $platform
     * @return array|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserStat($value,$platform = 'PC') {
        if ($platform == 'PC') {
            if (is_string($value)) {
                $clientOrigin = new ApexLegends\Client();
                $clientOrigin->login(self::ORIGIN_MAIL,self::ORIGIN_PASS);
                $user = $clientOrigin->users($value)[0];

                if (!empty($user)) {
                    $stats = json_decode("{".$user->stats($platform)."}",true);

                    if ($stats['userInfo']['name'] == '')
                        return 'Player not found';//Player found but he dont have apex legends.

                    return self::decryptCdata($stats);
                }else{
                    return 'Player not found';
                }
            }else{
                $guzzle = new GuzzleHttp\Client();
                $getUserArr = $guzzle->request('GET', 'https://r5-pc.stryder.respawn.com/user.php?qt=user-getinfo&getinfo=1&hardware='.$platform.'&uid='.$value.'&language=english&timezoneOffset=1&ugc=1&rep=1', [
                    'headers' => [
                        'User-Agent' => 'Respawn HTTPS/1.0'
                    ]
                ]);

                $stats = json_decode("{".$getUserArr->getBody()->getContents()."}",true);

                if ($stats['userInfo']['name'] == '')
                    return 'Player not found';//Player found but he dont have apex legends.

                return self::decryptCdata($stats);
            }
        }elseif ($platform == 'X1') {
            if (is_string($value)) {
                $xuid = self::getXboxUserData($value)['xuid'];
                if (!empty($xuid)) {
                    $guzzle = new GuzzleHttp\Client();
                    $getUserArr = $guzzle->request('GET', 'https://r5-x1.stryder.respawn.com/user.php?qt=user-getinfo&getinfo=1&hardware='.$platform.'&uid='.$xuid.'&language=english&timezoneOffset=1&ugc=1&rep=1', [
                        'headers' => [
                            'User-Agent' => 'Respawn HTTPS/1.0'
                        ]
                    ]);

                    $stats = json_decode("{".$getUserArr->getBody()->getContents()."}",true);

                    if ($stats['userInfo']['name'] == '')
                        return 'Player not found';//Player found but he dont have apex legends.

                }else{
                    return 'Player not found';
                }
            }else{
                $guzzle = new GuzzleHttp\Client();
                $getUserArr = $guzzle->request('GET', 'https://r5-x1.stryder.respawn.com/user.php?qt=user-getinfo&getinfo=1&hardware='.$platform.'&uid='.$value.'&language=english&timezoneOffset=1&ugc=1&rep=1', [
                    'headers' => [
                        'User-Agent' => 'Respawn HTTPS/1.0'
                    ]
                ]);

                $stats = json_decode("{".$getUserArr->getBody()->getContents()."}",true);

                if ($stats['userInfo']['name'] == '')
                    return 'Player not found';//Player found but he dont have apex legends.
            }

            return self::decryptCdata($stats);
        }elseif ($platform == 'PS4') {
            if (is_string($value)) {
                $psuid = self::getPs4UserData($value)['psnuid'];

                if (!empty($psuid)) {
                    $guzzle = new GuzzleHttp\Client();
                    $getUserArr = $guzzle->request('GET', 'https://r5-ps4.stryder.respawn.com/user.php?qt=user-getinfo&getinfo=1&hardware='.$platform.'&uid='.$psuid.'&language=english&timezoneOffset=1&ugc=1&rep=1', [
                        'headers' => [
                            'User-Agent' => 'Respawn HTTPS/1.0'
                        ]
                    ]);

                    $stats = json_decode("{".$getUserArr->getBody()->getContents()."}",true);

                    if ($stats['userInfo']['name'] == '')
                        return 'Player not found';//Player found but he dont have apex legends.

                    return self::decryptCdata($stats);
                }else{
                    return 'Player not found';
                }
            }else{
                $guzzle = new GuzzleHttp\Client();
                $getUserArr = $guzzle->request('GET', 'https://r5-ps4.stryder.respawn.com/user.php?qt=user-getinfo&getinfo=1&hardware='.$platform.'&uid='.$value.'&language=english&timezoneOffset=1&ugc=1&rep=1', [
                    'headers' => [
                        'User-Agent' => 'Respawn HTTPS/1.0'
                    ]
                ]);

                $stats = json_decode("{".$getUserArr->getBody()->getContents()."}",true);

                if ($stats['userInfo']['name'] == '')
                    return 'Player not found';//Player found but he dont have apex legends.

                return self::decryptCdata($stats);
            }
        }
    }

    /**
     * @param $cdata
     * @return array
     */
    private function decryptCdata($cdata) {
        $legendArr = array('1111853120'=>'caustic','1409694078'=>'lifeline','1464849662'=>'pathfinder','182221730'=>'gibraltar','2045656322'=>'mirage','725342087'=>'bangalore','827049897'=>'wraith','898565421'=>'bloodhound','843405508'=>'octane');
        $statsArr = [
            'kills' => [
                1049917798,
                345008354,
                1509839340,
                196161681,
                1618935778,
                1814522143,
                15753331,
                1730527550,
                303788636
            ],
            'damage' => [
                1469728535,
                1447295346,
                1099437275,
                1081609860,
                833459246,
                2014839975,
                1114426503
            ],
            'games_played' => [
                1503453708,
                1596888018,
                1932917010,
                278004241,
                79320088,
                155530518
            ],
            'headshots' => [
                1455038865,
                2101929659,
                927222661,
                252848455,
                1454765265,
                1037054725,
                240059894,
                1174986907
            ],
            'revives' => [
                455519236,
                53059952,
                332820408,
                1600370805,
                1712819508,
                1539065824
            ],
            'empty' => 1905735931,
            'top_3' => [
                59904350,
                692891435,
                486927953,
                1996756430
            ],
            'wins_full_squad' => [
                888240106,
                31935871,
                1029543241,
                1031439873,
                1654975970
            ],
            'finishers' => [
                1010955107,
                1955189012,
                159674464,
                830747811
            ],
            'pistol_kills' => [
                1049919818,
                2143939673,
                1790559237,
                386848081,
                919756330
            ],
            'shotgun_kills' => [
                1730223930,
                2091825336,
                997037285
            ],
            'smg_kills' => [
                1807836495,
                553648221,
                1854222557
            ],
            'ar_kills' => [
                1758696453,
                1224674415,
                1913031309
            ],
            'lmg_kills' => [
                375248935,
                1436290069,
                1460730151,
                713918432
            ],
            'sniper_kills' => [
                704985961,
                1151783812,
                1080769684,
                1404343849
            ],
            'health_drone_healing' => 1013667227,
            'revive_shield_damage_blocked' => 3941687,
            'kill_leader_kills' => [
                172943936,
                218650152,
                1561856843,
                2015631597
            ],
            'winning_kills' => [
                1676898271,
                219040158,
                2019682590,
                1196421729,
                1196421729
            ],
            'lifeline_drop_call' => 1768041931,
            'mirage_encore_executions_escaped' => 230838395,
            'mirage_decoys_created' => 635416044,
            'mirage_bamboozles' => 884674356

        ];

        $userStatMass = [];
        $userStatMass['userInfo']['uid'] = $cdata['userInfo']['uid'];
        $userStatMass['userInfo']['hardware'] = $cdata['userInfo']['hardware'];
        $userStatMass['userInfo']['nick'] = $cdata['userInfo']['name'];
        $userStatMass['userInfo']['level'] = $cdata['userInfo']['cdata23']+1;
        $userStatMass['userInfo']['levelProgress'] = $cdata['userInfo']['cdata24'];
        $userStatMass['userInfo']['online'] = $cdata['userInfo']['online'];
        $userStatMass['userInfo']['inMatch'] = $cdata['userInfo']['cdata31'] == 0?'false':'true';

        $userStatMass['userInfo']['legendSelected']['name'] = $legendArr[$cdata['userInfo']['cdata2']];

        $userStatMass['userInfo']['legendSelected']['stats']['0']['name'] = self::getStatTitle($cdata['userInfo']['cdata12'],$statsArr)==''?'undefined':self::getStatTitle($cdata['userInfo']['cdata12'],$statsArr);
        $userStatMass['userInfo']['legendSelected']['stats']['1']['name'] = self::getStatTitle($cdata['userInfo']['cdata14'],$statsArr)==''?'undefined':self::getStatTitle($cdata['userInfo']['cdata14'],$statsArr);
        $userStatMass['userInfo']['legendSelected']['stats']['2']['name'] = self::getStatTitle($cdata['userInfo']['cdata16'],$statsArr)==''?'undefined':self::getStatTitle($cdata['userInfo']['cdata16'],$statsArr);

        $userStatMass['userInfo']['legendSelected']['stats']['0']['value'] = mb_substr($cdata['userInfo']['cdata13'],0,-2);
        $userStatMass['userInfo']['legendSelected']['stats']['1']['value'] = mb_substr($cdata['userInfo']['cdata15'],0,-2);
        $userStatMass['userInfo']['legendSelected']['stats']['2']['value'] = mb_substr($cdata['userInfo']['cdata17'],0,-2);

        return $userStatMass;
    }

    /**
     * @param $cdataId
     * @param $statsArr
     * @return int|string
     */
    private function getStatTitle($cdataId,$statsArr)
    {
        foreach ($statsArr as $statsTitle => $stValArr) {
            if ($stValArr == $cdataId) {
                return $statsTitle;
            }else{
                if (is_array($stValArr) || is_object($stValArr)) {
                    foreach ($stValArr as $key => $cdtatVal) {
                        if ($cdtatVal == $cdataId) {
                            return $statsTitle;
                        }
                    }
                }
            }
        }
    }

    /**
     * @param $nickName
     * @param $platform
     * @return mixed|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAvatar($nickName,$platform) {
        if ($platform == 'PS4') {
            $psAvatar = self::getPs4UserData($nickName)['avatarUrl'];

            if (!empty($psAvatar)) {
                return $psAvatar;
            }else{
                return 'Player not found';
            }
        }elseif ($platform == 'X1') {
            $xAvatar = self::getXboxUserData($nickName)['avatarUrl'];

            if (!empty($xAvatar)) {
                return $xAvatar;
            }else{
                return 'Player not found';
            }
        }elseif ($platform == 'PC') {
            $clientOrigin = new ApexLegends\Client();
            $clientOrigin->login(self::ORIGIN_MAIL,self::ORIGIN_PASS);
            $user = $clientOrigin->users($nickName)[0];

            if (!empty($user->id())) {
                $guzzle = new GuzzleHttp\Client();
                $getUserAvatar = $guzzle->request('GET', 'https://api1.origin.com/avatar/user/'.$user->id().'/avatars?size=2', [
                    'headers' => [
                        'AuthToken' => $clientOrigin->accessToken()
                    ]
                ]);

                $getXml = simplexml_load_string($getUserAvatar->getBody(), "SimpleXMLElement", LIBXML_NOCDATA);
                $xmlToJson = json_encode($getXml);
                $jsonToArr = json_decode($xmlToJson,TRUE);

                return $jsonToArr['user']['avatar']['link'];
            }else{
                return 'Player not found';
            }
        }
    }

    /**
     * @param $id
     * @param $platform
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getStatByID($id,$platform) {
        $guzzle = new GuzzleHttp\Client();
        $getUserArr = $guzzle->request('GET', 'https://r5-pc.stryder.respawn.com/user.php?qt=user-getinfo&getinfo=1&hardware='.$platform.'&uid='.$id.'&language=english&timezoneOffset=1&ugc=1&rep=1', [
            'headers' => [
                'User-Agent' => 'Respawn HTTPS/1.0'
            ]
        ]);

        return $getUserArr->getBody()->getContents();
    }

    /**
     * @param $nick
     * @param $platform
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkTRN($nick,$platform) {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://apex.tracker.gg/profile/'.$platform.'/'.$nick);

        $statarea_content = $res->getBody()->getContents(); //Получаем HTML код страницы
        $doc = phpQuery::newDocumentHTML($statarea_content, $charset = 'utf-8'); // Создаем обьект phpQuery

        $data = [];
        $i=0;
        $s=0;

        $doc->find('.trn-scont__content:eq(2) .trn-card:gt(8)')->remove();
        $sd = $doc->find('.trn-scont__content:eq(2) .trn-card');

        foreach ($sd as $key) {
            $key = pq($key);
            $i++;
            $legName = strtolower($key->find('.trn-card__header-title')->text());
            foreach ($key->find('.ap-legend-stats__stats .trn-defstat') as $keys) {
                $s++;
                $keys = pq($keys);
                $data[$legName][$s]['name'] = $legName.'_'.str_ireplace(array(':','.'),'',str_ireplace(array(' ','matches_played','full_squad_wins','times_top_3'),array('_','games_played','wins_full_squad','top_3'),strtolower($keys->find('.trn-defstat__name')->text())));
                $data[$legName][$s]['value'] = str_ireplace(array(',','.'), '', $keys->find('.trn-defstat__value')->text());
            }

        }

        return $data;
    }
}