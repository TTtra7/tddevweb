<?php
declare(strict_types=1);

/**
 * Prends un fichier en param pour ensuite incrementer la valeur contenue dans le fichier de 1 
 * @param $fichier qui servira de compteur pour le site 
 * 
 *
 */
function compteur($fichier) {
    if (!file_exists($fichier)) {
        file_put_contents($fichier, '0');
    }
    $compteur = (int)file_get_contents($fichier);
    $compteur++;
    file_put_contents($fichier, $compteur);
}

/**
 * Permet de recuperer le style de la page mis en parametre dans l'url
 *
 * 
 * @return string qui est le style mis en parametre dans l'url
 */
function getstyle():string {
    if (isset($_GET['style'])){
        return $_GET['style'];
    } else {
        return "clair";
    }
}

/**
 * Permet de recuperer la langue de la page mis en parametre dans l'url
 *
 * 
 * @return string qui est la langue mise en parametre dans l'url
 */
function getlang():string {
    if (isset($_GET['lang']) and $_GET['lang']=="en"){
        return $_GET['lang'];
    } else {
        return "fr";
    } 
}

/**
 * Permet de recuperer le style de la page mis en parametre dans l'url
 *
 * 
 * @return string qui est le style mis en parametre dans l'url
 */
function getcity():string {
    if (isset($_GET['city'])){
        return $_GET['city'];
    } else {
        $geoGeoPlugin = getGeoGeoPlugin();
        return "$geoGeoPlugin->geoplugin_city";
    }
}

/**
 *  
 *
 * 
 * @return 
 */
function getGeoGeoPlugin() {
    $ip = $_SERVER['REMOTE_ADDR'];
    $url = "http://www.geoplugin.net/xml.gp?ip=$ip";
    $info = file_get_contents($url);
    if ($info) {
        return simplexml_load_string($info);
    }
    return null;
}

define("WEATHERAPI_API_KEY", "87fd579e5f744cf9a2f190415253103");

/**
 *   
 *
 * 
 * @return 
 */
function getWeather($city) {
    $url = "http://api.weatherapi.com/v1/forecast.json?key=".WEATHERAPI_API_KEY."&q=$city&days=4&aqi=no&alerts=no";
    $info = file_get_contents($url);
    if ($info) {
        return json_decode($info, true);
    }
    return null;
}

/**
 *   
 *
 * 
 * @return 
 */
function getData($url) {
    $response = file_get_contents($url);
    if ($response === false) {
        return [];
    }
    return json_decode($response, true);
}

/**
 * extrait les regions et departement de fichiers csv puis cree un array des regions avec pour chaque region un array des departement de cette meme region
 *
 * 
 * @return $arrayreg est un array avec pour cle les regions et pour value un array des departements de la region cle 
 */
function regionlist() {
    $region = [];
    $dep = [];
    $cit = [];
    $fpreg = fopen('regions.csv', 'r');
    $fpdep = fopen('departments.csv', 'r');
    $fpcit = fopen('cities.csv', 'r');
    $arrayreg= [];
    while (($row = fgetcsv($fpreg)) !== false) {
        $region[] = $row;
    }
    while (($row = fgetcsv($fpdep)) !== false) {
        $dep[] = $row;
    }
    while (($row = fgetcsv($fpcit)) !== false) {
        $cit[] = $row;
    }

    fclose($fpreg);
    fclose($fpdep);
    fclose($fpcit);
    for ($i = 1; $i < count($region); $i++){
        $listdep = [];
        for ($j = 1; $j < count($dep); $j++){
            if ($region[$i][1]==$dep[$j][1]) {
                $listcit = [];
                for ($k = 1; $k < count($cit); $k++) {
                    if ($cit[$k][1] == $dep[$j][2]) {
                        $listcit[] = $cit[$k][4];
                    }
                }
                $listdep[] = array($dep[$j][3], $dep[$j][2], $listcit);
            }
        }
        $arrayreg[$region[$i][2]] = $listdep;
    }
    return $arrayreg;
}


define('HISTORY_CSV_FILE', 'history.csv');

function loadCSVHistory() {
    $history = [];
    if (file_exists(HISTORY_CSV_FILE)) {
        $rows = file(HISTORY_CSV_FILE, FILE_IGNORE_NEW_LINES);
        foreach ($rows as $row) {
            $fields = str_getcsv($row);
            $ip = array_shift($fields);
            $history[$ip] = $fields;
        }
    }
    return $history;
}

function saveCSVHistory($history) {
    $rows = [];
    foreach ($history as $ip => $cities) {
        $row = array_merge([$ip], $cities);
        $rows[] = implode(',', $row);
    }
    file_put_contents(HISTORY_CSV_FILE, implode("\n", $rows));
}

function addcityhistory() {
    $city = isset($_GET['city']) ? $_GET['city'] : NULL;
    $ip = $_SERVER['REMOTE_ADDR'];
    $history = loadCSVHistory();

    if ($city) {
        if (!isset($history[$ip])) {
            $history[$ip] = [];
        }

        $history[$ip] = array_filter($history[$ip], function($c) use ($city) {
            return strtolower($c) !== strtolower($city);
        });

        array_unshift($history[$ip], $city);

        saveCSVHistory($history);
    }
}

function displayhistory() {
    $ip = $_SERVER['REMOTE_ADDR'];
    $history = loadCSVHistory();
    if (isset($history[$ip])) {
        $display = "<nav id='history'><ul>";
        $last5cities = array_slice($history[$ip], 0, 5);
        foreach ($last5cities as $city) {
            $cityEncoded = iconv('UTF-8', 'ASCII//TRANSLIT', $city);
            $display .= "<li><a href='https://adamleopole.alwaysdata.net/projet/meteoweek.php?city=" . urlencode($cityEncoded) . "'>" . htmlspecialchars($city) . "</a></li>";
        }
        $display .= "</ul></nav>";
        return $display;
    }
    return NULL;
}

function checkcookies(string $cookie){
    if (isset($_GET[$cookie])){
        setcookie($cookie, $_GET[$cookie], time()+864000);
        return $_GET[$cookie];
    } elseif (!isset($_GET[$cookie]) and isset($_COOKIE[$cookie])){
        return $_COOKIE[$cookie];
    } elseif ($cookie === 'style' and !isset($_COOKIE['style']) and !isset($_GET['style'])) {
        setcookie($cookie, 'clair', time()+864000);
        return 'clair';
    }
}

function lasttowncookie(){
    if (isset($_GET[$cookie])){
        setcookie('lastcity', [$_GET[$cookie], time()], time()+864000);
    }
}
function alea(){
    $images = [
        'images/image1.jpg',
        'images/image2.jpg',
        'images/image3.jpg',
        'images/image4.jpg',
        'images/image5.jpg',
        'images/image6.jpg',
        'images/image7.jpg',
        'images/image8.jpg',
        'images/image9.jpg',
        'images/image10.jpg'
    ];
    $randomImage = $images[array_rand($images)];
    return $randomImage;
}
?>
