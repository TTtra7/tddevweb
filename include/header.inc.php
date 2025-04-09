<?php
require_once "./include/functions.inc.php";

$style = checkcookies('style');
$geoGeoPlugin = getGeoGeoPlugin();
$localcity = $geoGeoPlugin->geoplugin_city;
$localdata = getWeather($localcity);
$forecastlocal = $localdata['forecast']['forecastday'][0]['day'];
$city = getcity();
$citysansaccent = iconv('UTF-8', 'ASCII//TRANSLIT', $city);
$data = getWeather(str_replace(" ", "%20", $citysansaccent));
$forecastday = $data['forecast']['forecastday'];

echo addcityhistory();

$regionsData = regionlist();

$selectedRegion = $_GET['region'] ?? '';
$selectedDepartement = $_GET['departement'] ?? '';
$selectedCity = $_GET['city'] ?? '';

$departements = [];
$communes = [];

if ($selectedRegion && isset($regionsData[$selectedRegion])) {
    $departements = $regionsData[$selectedRegion];
}

if ($selectedDepartement) {
    foreach ($departements as $dep) {
        if ($dep[0] == $selectedDepartement) {
            $communes = $dep[2];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" type="text/css" href="css/<?= $style ?>.css"/>
</head>
<body>
    <header>
        <div class="header1">
            <a href="index.php"><p class="logo">Meteo Info</p></a> 
            <form method="GET">
                <input type="text" name="city" placeholder="Entrez une ville" required>
                <button type="submit">Rechercher</button>
            </form>
            <span><?php echo "Temp moyenne a $localcity : {$forecastlocal['avgtemp_c']}"; ?></span>
            <?php
                $params = $_GET;
                if ($style == 'clair') {
                    $nvstyle = 'sombre';
                } else {
                    $nvstyle = 'clair';
                }
                $params['style'] = $nvstyle;
                $query = http_build_query($params);
                $baseUrl = strtok($_SERVER['REQUEST_URI'], '?');
                echo "<a href='" . $baseUrl . "?" . $query . "'>Mode " . ucfirst($nvstyle) . "</a>";
            ?>
        </div>
        <h1><?= $h1 ?></h1>
        <nav id="navigation">
            <ul>
                <li><a href="index.php">Carte de France</a></li>
                <li><a href="meteoweek.php">Previsions</a></li>
                <li>Statistiques</li>
            </ul>
        </nav>
        <?php echo displayhistory(); ?>
    </header>