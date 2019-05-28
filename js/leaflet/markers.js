// TEXT MARKERS
var textMarkers = 
[{
    "name": "<span class='location'>ЧЕРЕП</span>",
    "coords": [956,1320]
},
{
    "name": "<span class='location'>МУТНЫЕ ОЗЕРА</span>",
    "coords": [3020,624]
},
{
    "name": "<span class='location'>АРТИЛЕРИЯ</span>",
    "coords": [3444,2216]
},
{
    "name": "<span class='location'>БОЙЦОВСКАЯ ЯМА</span>",
    "coords": [2656,972]
},
{
    "name": "<span class='location'>АВИАБАЗА</span>",
    "coords": [1816,472]
},
{
    "name": "<span class='location'>БУНКЕР</span>",
    "coords": [2136,1376]
},
{
    "name": "<span class='location'>КУПОЛ ГРОМА</span>",
    "coords": [636,904]
},
{
    "name": "<span class='location'>ВОДООЧИСТНАЯ УСТАНОВКА</span>",
    "coords": [192,2280]
},
{
    "name": "<span class='location'>РЕПУЛЬСОР</span>",
    "coords": [1008,3192]
},
{
    "name": "<span class='location'>ТОПИ</span>",
    "coords": [2024,3800]
},
{
    "name": "<span class='location'>БОЛОТА</span>",
    "coords": [2692,3212]
},
{
    "name": "<span class='location'>КАСКАДЫ</span>",
    "coords": [2608,1892]
},
{
    "name": "<span class='location'>МОСТЫ</span>",
    "coords": [1656,2360]
},
{
    "name": "<span class='location'>РЫНОК</span>",
    "coords": [1244,1980]
},
{
    "name": "<span class='location'>ПЛОТИНА ГЭС</span>",
    "coords": [1484,3224]
},
{
    "name": "<span class='location'>РЕЛЕ</span>",
    "coords": [3124,3312]
},
{
    "name": "<span class='location'>СТОК</span>",
    "coords": [2400,540]
}];

var respawnpoint = [
{
	"coords": [1682,393]
},
{
	"coords": [1399,1025]
},
{
	"coords": [1500,1665]
},
{
	"coords": [1000,1538]
},
{
	"coords": [720,1678]
},
{
	"coords": [723,953]
},
{
	"coords": [289,2496]
},
{
	"coords": [983,2461]
},
{
	"coords": [1345,2821]
},
{
	"coords": [1569,3083]
},
{
	"coords": [1918,2880]
},
{
	"coords": [1892,2487]
},
{
	"coords": [2141,1987]
},
{
	"coords": [2548,2117]
},
{
	"coords": [763,3086]
},
{
	"coords": [1648,3723]
},
{
	"coords": [2062,3384]
},
{
	"coords": [2323,2905]
},
{
	"coords": [2778,2540]
},
{
	"coords": [2648,2995]
},
{
	"coords": [3174,3010]
},
{
	"coords": [1904,1077]
},
{
	"coords": [2488,795]
},
{
	"coords": [2710,294]
},
{
	"coords": [3120,874]
},
{
	"coords": [3237,1365]
},
{
	"coords": [2833,1630]
},
{
	"coords": [3355,2225]
},
];

var scanerPoint = [
{
	"coords": [3198,780]
},
{
	"coords": [2358,1634]
},
{
	"coords": [2097,828]
},
{
	"coords": [1109,686]
},
{
	"coords": [843,2562]
},
{
	"coords": [1799,2438]
},
{
	"coords": [1473,3383]
},
{
	"coords": [3255,3250]
},
{
	"coords": [3528,2346]
},
{
	"coords": [968,1343]
},
];

var lootSpawn = [
{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[1968,240],[2038,414],[2214,542],[2418,516],[2556,394],[2616,228],[1968,240]]]}},
	"color":"#ec00ff",
	"tier":"tierThree"
},
{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[2278,1309],[2245,1176],[2543,1095],[2593,1282],[2278,1309]]]}},
	"color":"#0796ff",
	"tier":"tierTwo"
},
{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[2866,902],[2866,1274],[3492,1274],[3492,902],[2866,902]]]}},
	"color":"#ec00ff",
	"tier":"tierThree"
},
{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[703,776],[823,513],[1038,496],[1165,623],[989,866],[703,776]]]}},
	"color":"#ec00ff",
	"tier":"tierThree"
},
{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[286,1516],[286,2120],[668,2120],[668,1516],[286,1516]]]}},
	"color":"#ec00ff",
	"tier":"tierThree"
},
{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[1182,2040],[1182,2266],[1552,2266],[1552,2040],[1182,2040]]]}},
	"color":"#ec00ff",
	"tier":"tierThree"
},
{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[792,2590],[792,2846],[1130,2846],[1130,2590],[792,2590]]]}},
	"color":"#ec00ff",
	"tier":"tierThree"
},
{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[648,2698],[666,2222],[314,2218],[170,2412],[154,2596],[648,2698]]]}},
	"color":"#ec00ff",
	"tier":"tierThree"
},
{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[1894,3274],[1894,3684],[2540,3684],[2540,3274],[1894,3274]]]}},
	"color":"#ec00ff",
	"tier":"tierThree"
},
{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[3534,3182],[3506,3476],[3305,3626],[3239,3603],[3155,3339],[3262,3182],[3534,3182]]]}},
	"color":"#ec00ff",
	"tier":"tierThree"
},
{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[3623,2405],[3680,2124],[3681,1940],[3592,1819],[3433,1795],[3426,1683],[3805,1570],[3903,1734],[3901,2449],[3623,2405]]]}},
	"color":"#ec00ff",
	"tier":"tierThree"
},

{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[1177,580],[1142,405],[1408,329],[1492,531],[1177,580]]]}},
	"color":"#0796ff",
	"tier":"tierTwo"
},
{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[1066,1222],[1116,832],[1502,818],[1580,1156],[1086,1228],[1066,1222]]]}},
	"color":"#0796ff",
	"tier":"tierTwo"
},
{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[604,1058],[604,1306],[890,1306],[890,1058],[604,1058]]]}},
	"color":"#0796ff",
	"tier":"tierTwo"
},
{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[594,3304],[414,3224],[416,3000],[570,2964],[802,3046],[998,3014],[1008,3190],[816,3254],[594,3304]]]}},
	"color":"#0796ff",
	"tier":"tierTwo"
},
{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[2284,2484],[2268,2312],[2656,2284],[2688,2494],[2284,2484]]]}},
	"color":"#0796ff",
	"tier":"tierTwo"
},
{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[2878,2854],[2820,2468],[3334,2520],[3528,2694],[3522,2920],[2954,2904],[2878,2854]]]}},
	"color":"#0796ff",
	"tier":"tierTwo"
},
{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[2450,1906],[2376,1816],[2244,1818],[2196,1646],[2334,1536],[2532,1564],[2494,1744],[2548,1852],[2450,1906]]]}},
	"color":"#0796ff",
	"tier":"tierTwo"
},
{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[1812,2990],[1630,2915],[1552,2780],[1544,2673],[1539,2582],[1671,2453],[1876,2407],[2058,2631],[2037,2816],[1812,2990]]]}},
	"color":"#0796ff",
	"tier":"tierTwo"
},

{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[2033,1405],[1755,1375],[1683,1300],[1706,1175],[1872,1224],[2114,1224],[2119,1420],[2033,1405]]]}},
	"color":"#b9b9b9",
	"tier":"tierOne"
},
{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[1901,1137],[1723,1008],[1745,924],[1962,1026],[1901,1137]]]}},
	"color":"#b9b9b9",
	"tier":"tierOne"
},
{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[3078,818],[3025,791],[2978,706],[3032,584],[3257,706],[3197,800],[3119,769],[3078,818]]]}},
	"color":"#b9b9b9",
	"tier":"tierOne"
},
{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[2982,1719],[2967,1416],[3444,1427],[3442,1659],[3336,1705],[2982,1719]]]}},
	"color":"#b9b9b9",
	"tier":"tierOne"
},
{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[3179,1956],[3179,2093],[3421,2093],[3421,1956],[3179,1956]]]}},
	"color":"#b9b9b9",
	"tier":"tierOne"
},
{
	"data": {"type":"Feature","properties":{},"geometry":{"type":"Polygon","coordinates":[[[766,1942],[766,2157],[1074,2157],[1074,1942],[766,1942]]]}},
	"color":"#b9b9b9",
	"tier":"tierOne"
},
];