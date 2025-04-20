<?php
require_once "./include/functions.inc.php";

$style = checkcookies('style');
$geoGeoPlugin = getGeoGeoPlugin();
$localcity = $geoGeoPlugin->geoplugin_city;
$localdata = getWeather($localcity);
$forecastlocal = $localdata['forecast']['forecastday'][0]['day'];
$city = getcity();
if (!empty(getWeather($city))) {
    $data = getWeather($city);
    $forecastday = $data['forecast']['forecastday'];
    echo addcityhistory();
    $gotForecast=true;
} else {
    $gotForecast=false;
}

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
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="author" content="Adam LEOPOLE DIT MARIE, Alexis BERTRAND" />
    <link rel="icon" type="image/png" href="./images/favicon.png" />
    <title><?= $title ?></title>
    <link rel="stylesheet" type="text/css" href="css/<?= $style ?>.css"/>
</head>
<body>
    <header>
        <div class="header1">
            <div class="header1-1">
                <a href="index.php"><img src="images/logo.png" alt="Logo Meteo Info" width="150" height="150"/></a>
            </div>
            <div class="header1-2">
                <form method="GET" action="./meteoweek.php">
                    <label for="city-1">Ville : </label>
                    <input type="text" id="city-1" name="city" placeholder="Entrez une ville" required="required"/>
                    <button type="submit">Rechercher</button>
                </form>
            </div>
            <div class="header1-3">
                <div class="localforecast">
                    <span style="font-size: 30px;"><?php echo "$localcity : {$forecastlocal['avgtemp_c']}°C" ?></span>
                    <img src="<?php echo $forecastlocal['condition']['icon']; ?>" alt="Météo Icon" width='30' height='30'/>
                </div>
                <div class="style">
                    <?php
                        $params = $_GET;
                        if ($style == 'clair') {
                            $nvstyle = 'sombre';
                        } else {
                           $nvstyle = 'clair';
                        }
                        $params['style'] = $nvstyle;
                        $query = str_replace("&", "&amp;", http_build_query($params));
                        $baseUrl = strtok($_SERVER['REQUEST_URI'], '?');
                        echo "<a href='" . $baseUrl . "?" . $query . "'><img src='images/". $nvstyle .".png' alt='Logo style' width='55' height='55'/></a>";
                    ?>
                </div>
            </div>
        </div>
        <h1><?= $h1 ?></h1>
        <?php if (isset($_GET['city'])): ?>
        <nav id="navigation">
            <ul>
                <li><a href="index.php">Carte de France</a></li>
                <li><a href="meteoweek.php?city=<?php echo getcity() ?>">Prévisions</a></li>
                <li><a href="meteoweekastro.php?city=<?php echo getcity() ?>">Météo Astro de la semaine</a></li>
                <li><a href="stat.php">Statistiques</a></li>
            </ul>
        </nav>
        <?php else: ?>
        <nav id="navigation">
            <ul>
                <li><a href="index.php">Carte de France</a></li>
                <li><a href="meteoweek.php">Prévisions</a></li>
                <li><a href="meteoweekastro.php">Météo Astro de la semaine</a></li>
                <li><a href="stat.php">Statistiques</a></li>
            </ul>
        </nav>
        <?php endif; ?>
        <?php echo displayhistory(); ?>
    </header>