<?php
require_once "./include/functions.inc.php";
$geoGeoPlugin = getGeoGeoPlugin();
$localcity = $geoGeoPlugin->geoplugin_city;
$localdata = getWeather($localcity);
$forecastlocal = $localdata['forecast']['forecastday'][0]['day'];
$city = getcity();
$citysansaccent = iconv('UTF-8', 'ASCII//TRANSLIT', $city);
$data = getWeather($citysansaccent);
$forecasthour = $data['forecast']['forecastday'][0]['hour'];
$forecastday = $data['forecast']['forecastday'];

$regions = getData(API_REGIONS);

$selectedRegion = $_GET['region'] ?? '';
$selectedDepartement = $_GET['departement'] ?? '';
$departements = [];
$communes = [];

if ($selectedRegion) {
    $departements = getData(str_replace('{code}', $selectedRegion, API_DEPARTEMENTS));
}

if ($selectedDepartement) {
    $communes = getData(str_replace('{code}', $selectedDepartement, API_COMMUNES));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Météo Info</title>
    <link rel="stylesheet" type="text/css" href="css/clair.css"/>
</head>
<body>
    <header>
        <div class="header1">
            <p class="logo">Meteo Info</p>
            <form method="GET">
                <input type="text" name="city" placeholder="Entrez une ville" required>
                <button type="submit">Rechercher</button>
            </form>
            <span><?php echo "Temp moyenne a $localcity : {$forecastlocal['avgtemp_c']}"; ?></span>
        </div>
        <h1>Météo de <?php echo htmlspecialchars($city); ?></h1>
        <nav>
            <ul>
                <li>Carte de France</li>
                <li>Villes Principales</li>
                <li>Statistiques</li>
            </ul>
        </nav>
    </header>
<main>
    <form method="GET">
        <label for="region">Choisissez une region :</label>
        <select name="region" id="region" onchange="this.form.submit()">
            <option value="">-- selectionner region --</option>
            <?php foreach ($regions as $region): ?>
                <option value="<?= $region['code'] ?>" <?= ($region['code'] == $selectedRegion) ? 'selected' : '' ?>>
                    <?= $region['nom'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if ($selectedRegion): ?>
    <form method="GET">
        <input type="hidden" name="region" value="<?= $selectedRegion ?>">
        <label for="departement">Choisissez un departement :</label>
        <select name="departement" id="departement" onchange="this.form.submit()">
            <option value="">-- selectionner departement --</option>
            <?php foreach ($departements as $departement): ?>
                <option value="<?= $departement['code'] ?>" <?= ($departement['code'] == $selectedDepartement) ? 'selected' : '' ?>>
                    <?= $departement['nom'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
    <?php endif; ?>

    <?php if ($selectedDepartement): ?>
    <form method="GET">
        <input type="hidden" name="region" value="<?= $selectedRegion ?>">
        <input type="hidden" name="departement" value="<?= $selectedDepartement ?>">
        <label for="city">Choisissez une commune :</label>
        <select name="city" id="city" onchange="this.form.submit()">
            <option value="">-- selectionner commune --</option>
            <?php foreach ($communes as $commune): ?>
                <option value="<?= $commune['nom'] ?>" <?= ($commune['nom'] == $city) ? 'selected' : '' ?>>
                    <?= $commune['nom'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
    <?php endif; ?>

    <img src="./images/carte_france.jpg" usemap="#image-map">

    <map name="image-map">
        <area target="_self" alt="Guyane" title="Guyane" href="https://adamleopole.alwaysdata.net/projet/index.php?region=03" coords="188,845,197,843,203,847,214,848,221,856,227,860,237,863,248,863,255,865,263,867,271,872,280,878,287,886,294,893,301,898,309,901,315,908,319,909,323,909,328,916,335,921,341,925,345,931,343,934,350,933,360,933,366,941,365,951,373,954,369,962,374,965,376,977,374,984,361,983,364,992,357,998,354,1006,348,1010,345,1019,332,1039,332,1045,319,1049,317,1057,319,1065,313,1069,313,1077,307,1081,299,1108,292,1113,295,1118,288,1120,280,1124,272,1132,262,1133,252,1133,242,1136,243,1126,235,1120,227,1128,206,1124,205,1116,195,1122,189,1132,176,1137,154,1136,140,1126,138,1117,152,1109,158,1093,166,1088,166,1056,173,1047,177,1031,185,1022,178,1012,174,1004,166,1000,158,992,154,982,150,969,152,957,146,950,152,937,146,929,142,921,144,910,148,896,158,884,168,878,174,868,182,863,181,852" shape="poly">
        <area target="_self" alt="Guadeloupe" title="Guadeloupe" href="https://adamleopole.alwaysdata.net/projet/index.php?region=01" coords="194,264,205,264,206,272,201,278,193,276" shape="poly">
        <area target="_self" alt="Guadeloupe" title="Guadeloupe" href="https://adamleopole.alwaysdata.net/projet/index.php?region=01" coords="158,258,153,250,154,242,153,232,150,225,154,221,162,223,168,228,173,227,180,223,177,217,176,209,181,205,189,208,191,217,193,223,203,224,207,228,211,231,201,235,191,235,181,237,172,236,174,246,174,253,166,261" shape="poly">
        <area target="_self" alt="Martinique" title="Martinique" href="https://adamleopole.alwaysdata.net/projet/index.php?region=02" coords="161,374,170,375,178,375,184,382,190,387,190,395,195,400,201,407,199,419,194,423,191,415,181,415,172,413,182,403,172,400,162,397,164,386" shape="poly">
        <area target="_self" alt="Mayotte" title="Mayotte" href="https://adamleopole.alwaysdata.net/projet/index.php?region=06" coords="166,537,173,533,178,533,181,540,186,544,195,549,191,555,188,562,191,566,191,571,186,577,185,582,177,585,170,578,178,575,177,566,172,556,168,546,161,543" shape="poly">
        <area target="_self" alt="Réunion" title="Réunion" href="https://adamleopole.alwaysdata.net/projet/index.php?region=04" coords="156,726,166,731,172,734,181,734,194,735,202,738,207,731,205,721,211,714,209,706,202,704,197,696,194,686,182,686,173,685,166,680,158,685,157,696,149,698,148,706,156,713" shape="poly">
        <area target="_self" alt="Corse" title="Corse" href="https://adamleopole.alwaysdata.net/projet/index.php?region=94" coords="1371,1032,1371,1023,1371,1012,1372,1002,1377,996,1385,999,1384,1006,1387,1012,1384,1028,1381,1037,1388,1040,1388,1049,1388,1060,1389,1068,1389,1077,1391,1085,1388,1093,1383,1100,1383,1110,1381,1122,1379,1132,1377,1139,1371,1146,1376,1149,1376,1155,1368,1163,1363,1169,1354,1167,1350,1159,1340,1158,1335,1151,1335,1141,1340,1137,1328,1132,1331,1124,1334,1113,1319,1114,1322,1104,1331,1100,1324,1093,1318,1085,1319,1076,1326,1076,1319,1068,1319,1059,1327,1055,1326,1047,1335,1041,1340,1037,1352,1037,1355,1030,1364,1028" shape="poly">
        <area target="_self" alt="Hauts-De-France" title="Hauts-De-France" href="https://adamleopole.alwaysdata.net/projet/index.php?region=32" coords="824,285,822,276,816,268,802,257,800,249,805,240,805,225,805,213,804,199,808,184,810,168,821,162,828,159,835,158,846,156,857,155,863,151,873,148,879,151,883,158,882,172,891,174,895,178,899,185,906,183,914,176,923,178,928,183,931,192,931,201,932,208,940,208,951,207,960,216,960,224,969,227,979,225,991,228,1000,235,997,244,1001,250,1000,264,1000,273,1002,282,1000,290,993,295,987,305,989,314,988,325,980,329,968,333,960,333,953,339,956,347,948,351,951,360,948,367,939,370,931,359,927,347,919,343,911,347,902,350,894,350,886,347,877,344,869,342,858,342,849,338,837,339,829,342,821,341,829,331,826,321,828,310,826,299" shape="poly">
        <area target="_self" alt="Île-De-France" title="Île-De-France" href="https://adamleopole.alwaysdata.net/projet/index.php?region=11" coords="804,366,801,370,812,394,817,407,823,409,825,419,830,421,838,425,840,432,848,435,858,435,868,436,876,443,876,452,882,454,893,456,905,450,911,448,913,439,915,429,922,431,934,431,937,429,937,420,939,412,947,408,943,400,938,390,934,378,922,367,921,355,910,358,895,359,883,358,874,354,865,348,855,351,845,350,834,348,820,350,810,360,804,366" shape="poly">
        <area target="_self" alt="Provence-Alpes-Côte d'Azur" title="Provence-Alpes-Côte d'Azur" href="https://adamleopole.alwaysdata.net/projet/index.php?region=93" coords="1006,947,1018,952,1021,944,1030,942,1029,951,1028,960,1033,967,1047,966,1050,958,1057,954,1061,947,1071,943,1073,952,1069,960,1059,964,1071,967,1078,963,1083,966,1082,975,1093,976,1099,980,1107,983,1114,987,1116,996,1123,993,1128,987,1135,988,1140,996,1151,992,1167,981,1180,980,1185,972,1185,960,1193,952,1200,951,1203,943,1212,940,1214,930,1228,923,1241,919,1244,907,1246,894,1258,885,1252,875,1241,873,1224,878,1210,870,1199,862,1200,849,1196,838,1205,830,1210,822,1206,812,1203,801,1193,801,1187,788,1180,780,1173,775,1168,781,1159,783,1152,775,1148,789,1156,792,1156,803,1146,809,1135,811,1123,816,1122,822,1119,829,1108,826,1106,833,1108,842,1102,849,1094,844,1094,850,1103,856,1110,861,1114,873,1106,877,1100,885,1091,885,1081,877,1069,872,1061,866,1059,857,1061,848,1051,849,1050,856,1053,863,1053,872,1045,869,1040,857,1036,863,1045,877,1044,884,1049,893,1047,901,1036,904,1038,918,1028,926,1020,926" shape="poly">
        <area target="_self" alt="Grand-Est" title="Grand-Est" href="https://adamleopole.alwaysdata.net/projet/index.php?region=44" coords="1006,268,1005,281,1002,293,997,298,992,311,992,326,979,333,964,338,968,347,961,358,963,370,955,376,948,384,951,394,959,403,944,423,959,437,963,452,971,452,979,460,981,473,994,472,1010,470,1020,470,1036,464,1046,468,1057,481,1059,496,1071,507,1083,515,1099,501,1107,488,1114,478,1132,470,1143,468,1151,474,1164,477,1180,470,1188,484,1205,492,1216,506,1221,522,1228,530,1238,522,1246,514,1244,502,1246,481,1244,470,1244,457,1254,444,1257,420,1273,396,1286,388,1290,372,1263,362,1241,350,1222,352,1204,350,1195,342,1191,350,1183,333,1168,318,1151,314,1140,311,1128,317,1115,307,1104,309,1093,309,1087,298,1077,289,1061,282,1054,285,1051,276,1051,265,1050,253,1049,244,1038,246,1037,257,1030,262,1020,266" shape="poly">
        <area target="_self" alt="Bretagne" title="Bretagne" href="https://adamleopole.alwaysdata.net/projet/index.php?region=53" coords="515,531,506,521,496,526,479,523,490,514,468,514,460,505,443,500,431,501,415,497,406,493,398,492,382,494,377,482,366,474,349,472,350,461,370,465,377,460,370,445,361,443,344,433,344,411,356,408,376,405,398,392,423,400,431,395,430,378,447,378,460,380,472,386,476,390,483,400,492,412,504,419,519,401,529,411,537,405,549,396,565,401,568,412,576,413,581,420,592,424,602,424,612,419,613,427,616,441,612,457,617,468,606,477,604,486,585,486,570,496,560,498,544,497,540,513" shape="poly">
        <area target="_self" alt="Normandie" title="Normandie" href="https://adamleopole.alwaysdata.net/projet/index.php?region=28" coords="552,288,565,294,576,297,598,289,604,297,598,309,614,329,623,327,637,327,655,330,672,331,683,334,699,329,727,318,695,310,703,298,716,280,735,280,773,266,796,256,814,273,813,299,814,321,818,334,809,350,790,374,786,390,768,390,753,399,760,417,756,428,744,443,751,447,735,441,724,433,723,420,712,417,702,423,691,424,686,405,676,415,663,416,639,417,626,413,610,413,590,416,600,401,584,395,578,368,581,344,569,333,556,315" shape="poly">
        <area target="_self" alt="Occitanie" title="Occitanie" href="https://adamleopole.alwaysdata.net/projet/index.php?region=76" coords="674,1014,685,1031,694,1030,710,1024,717,1031,732,1034,744,1030,744,1018,758,1012,768,1024,776,1024,781,1031,791,1030,799,1034,811,1038,819,1045,825,1057,833,1061,842,1071,850,1061,868,1059,878,1067,893,1062,909,1054,927,1055,927,1042,923,1020,923,1000,930,977,942,972,952,972,962,955,982,940,1000,941,1012,928,1025,915,1037,898,1032,880,1029,867,1011,866,995,865,986,851,979,837,962,804,944,806,942,789,931,796,925,802,925,812,913,823,905,818,905,809,895,800,883,802,885,814,881,823,872,826,864,826,850,821,849,812,848,802,834,790,819,798,805,788,799,809,788,821,777,837,777,853,764,870,743,891,726,894,711,895,695,906,682,904,686,918,680,927,687,933,695,938,700,946,703,962,690,986,679,995" shape="poly">
        <area target="_self" alt="Nouvelle-Aquitaine" title="Nouvelle-Aquitaine" href="https://adamleopole.alwaysdata.net/projet/index.php?region=75" coords="691,960,692,979,676,994,667,1019,654,1007,639,1003,623,995,612,993,597,1000,594,992,601,974,581,972,574,963,585,956,593,911,597,883,601,833,608,789,613,739,634,752,643,787,647,767,646,743,621,732,612,720,617,683,618,665,620,654,634,656,654,648,658,634,653,611,650,592,634,580,665,581,684,576,691,583,698,573,710,579,719,589,733,596,748,587,763,611,760,629,776,636,788,648,800,648,813,644,822,648,832,639,845,641,861,648,879,665,883,680,873,705,873,731,871,755,850,787,825,780,810,780,796,797,780,821,759,853,757,873,740,888,716,891,680,900,675,924,686,945" shape="poly">
        <area target="_self" alt="Auvergne-Rhône-Alpes" title="Auvergne-Rhône-Alpes" href="https://adamleopole.alwaysdata.net/projet/index.php?region=84" coords="863,640,877,627,886,612,900,607,912,603,923,612,939,615,953,615,957,606,963,624,969,631,979,641,971,651,979,665,992,672,1005,670,1020,664,1030,655,1037,661,1046,665,1055,652,1053,631,1066,633,1078,639,1082,647,1085,655,1097,657,1104,655,1112,661,1136,645,1122,665,1132,676,1148,677,1159,662,1153,644,1163,641,1180,639,1189,652,1184,672,1196,680,1203,689,1184,696,1183,709,1203,719,1214,741,1214,761,1201,774,1152,771,1142,779,1151,800,1104,821,1097,832,1091,845,1104,865,1093,874,1071,857,1066,847,1057,845,1046,848,1029,856,1012,857,996,853,956,796,943,778,930,788,919,800,915,816,902,802,883,795,874,816,859,814,849,792,861,772,871,759,879,741,881,721,879,702,887,673,878,653" shape="poly">
        <area target="_self" alt="Pays De La Loire" title="Pays De La Loire" href="https://adamleopole.alwaysdata.net/projet/index.php?region=52" coords="623,419,633,423,638,429,649,425,655,420,665,421,675,420,683,416,683,425,694,427,704,425,716,420,720,425,724,437,728,440,735,445,741,447,752,449,755,461,749,468,748,478,745,486,741,494,732,497,735,507,723,509,714,511,703,518,708,531,702,539,700,547,698,556,690,564,682,562,674,562,667,563,662,570,654,578,641,578,627,579,639,588,649,594,651,606,650,613,654,623,655,633,650,648,633,653,619,653,604,653,589,651,576,641,560,635,559,621,555,609,541,603,540,586,549,576,537,564,531,553,541,546,548,549,548,542,537,546,523,554,515,546,509,537,525,530,539,518,544,507,552,506,569,502,589,496,604,492,608,478,621,469,617,454,617,440,617,427" shape="poly">
        <area target="_self" alt="Centre-Val De Loire" title="Centre-Val De Loire" href="https://adamleopole.alwaysdata.net/projet/index.php?region=24" coords="777,633,790,644,804,643,819,629,844,633,865,629,881,612,899,596,913,594,914,574,906,553,900,531,906,511,911,490,911,465,899,460,888,460,875,454,866,440,856,436,837,436,829,427,820,415,807,395,799,388,784,387,774,395,760,397,764,421,764,433,756,437,759,457,752,469,747,486,737,509,706,518,707,534,700,556,696,564,714,580,733,594,749,583,759,600,767,609,765,623" shape="poly">
        <area target="_self" alt="Bourgogne-Franche-Comté" title="Bourgogne-Franche-Comté" href="https://adamleopole.alwaysdata.net/projet/index.php?region=27" coords="956,440,960,458,968,460,973,474,981,484,994,477,1018,477,1032,477,1040,468,1050,486,1053,503,1065,513,1079,514,1086,517,1095,513,1104,505,1115,497,1118,486,1128,486,1136,477,1150,477,1161,482,1168,477,1179,478,1183,486,1188,493,1196,492,1201,505,1204,517,1209,526,1199,537,1204,546,1199,559,1176,587,1167,598,1155,606,1144,629,1140,640,1130,643,1123,651,1107,652,1094,651,1086,641,1079,636,1071,631,1061,629,1050,628,1049,649,1045,657,1034,652,1024,651,1018,660,1009,662,1000,666,987,662,984,652,984,639,981,629,969,627,964,611,960,598,949,606,941,609,932,607,923,603,919,595,919,586,920,575,912,558,903,530,912,506,918,477,912,453,922,436,944,431" shape="poly">
</map>

    <table>
        <caption>Tableau des previsions pour les 4 prochains jours</caption>
        <tr>
            <th><?php echo date('d/m', strtotime($forecastday[0]['date'])); ?></th>
            <th><?php echo date('d/m', strtotime($forecastday[1]['date'])); ?></th>
            <th><?php echo date('d/m', strtotime($forecastday[2]['date'])); ?></th>
            <th><?php echo date('d/m', strtotime($forecastday[3]['date'])); ?></th>
        </tr>
        <tr>
            <td><img src="<?php echo $forecastday[0]['day']['condition']['icon']; ?>" alt="Météo"></td>
            <td><img src="<?php echo $forecastday[1]['day']['condition']['icon']; ?>" alt="Météo"></td>
            <td><img src="<?php echo $forecastday[2]['day']['condition']['icon']; ?>" alt="Météo"></td>
            <td><img src="<?php echo $forecastday[3]['day']['condition']['icon']; ?>" alt="Météo"></td>
        </tr>
        <tr>
            <td><?php echo $forecastday[0]['day']['avgtemp_c']; ?>°C</td>
            <td><?php echo $forecastday[1]['day']['avgtemp_c']; ?>°C</td>
            <td><?php echo $forecastday[2]['day']['avgtemp_c']; ?>°C</td>
            <td><?php echo $forecastday[3]['day']['avgtemp_c']; ?>°C</td>
        </tr>
        <tr>
            <td>Vent: <?php echo $forecastday[0]['day']['maxwind_kph']; ?> km/h</td>
            <td>Vent: <?php echo $forecastday[1]['day']['maxwind_kph']; ?> km/h</td>
            <td>Vent: <?php echo $forecastday[2]['day']['maxwind_kph']; ?> km/h</td>
            <td>Vent: <?php echo $forecastday[3]['day']['maxwind_kph']; ?> km/h</td>
        </tr>
        <tr>
            <td>Précip.: <?php echo $forecastday[0]['day']['totalprecip_mm']; ?> mm</td>
            <td>Précip.: <?php echo $forecastday[1]['day']['totalprecip_mm']; ?> mm</td>
            <td>Précip.: <?php echo $forecastday[2]['day']['totalprecip_mm']; ?> mm</td>
            <td>Précip.: <?php echo $forecastday[3]['day']['totalprecip_mm']; ?> mm</td>
        </tr>
    </table>

    <table>
        <caption>Tableau des previsions detaillees pour aujourd'hui</caption>
        <tr>
            <th>Heure</th>
            <th>Température (°C)</th>
            <th>Icône</th>
            <th>Vent (km/h)</th>
            <th>Humidité (%)</th>
            <th>Nuages (%)</th>
            <th>UV Index</th>
        </tr>
        <?php foreach ($forecasthour as $hour) : ?>
            <tr>
                <td><?php echo date('H:i', strtotime($hour['time'])); ?></td>
                <td><?php echo $hour['temp_c']; ?></td>
                <td><img src="<?php echo $hour['condition']['icon']; ?>" alt="Météo"></td>
                <td><?php echo $hour['wind_kph']; ?></td>
                <td><?php echo $hour['humidity']; ?></td>
                <td><?php echo $hour['cloud']; ?></td>
                <td><?php echo $hour['uv']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</main>
<footer>
    <div class="footer_left">
        <span>Meteos des 20 plus grands villes</span>
        <span>•<a href="https://adamleopole.alwaysdata.net/projet/index.php?city=Paris">Paris</a> • Ville • Ville • Ville • Ville • Ville • Ville • Ville • Ville • Ville</span>
        <span>• Ville • Ville • Ville • Ville • Ville • Ville • Ville • Ville • Ville • Ville</span>
    </div>
    <div class="footer_middle">
    </div>
    <div class="footer_right">
        <span>Adam LEOPOLE DIT MARIE, Alexis BERTRAND</span>
        <span>CY Cergy Paris Université - L2 INFORMATIQUE</span>
        <span>UE Développement Web - Avril 2025</span>
    </div>
</footer>
</body>
</html>