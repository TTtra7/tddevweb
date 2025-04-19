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
 * Permet de recuperer les infos geographiques avec l'api geoplugin 
 *
 * 
 * @return string qui est le flux xml recupere de l'api
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
 * Permet de recuperer les donnees de l'api meteo en prennant une ville en parametre
 * @param string nom de la ville pour la recherche
 * 
 * @return string flux json de la meteo de la ville pour les 3 prochains jours
 */
function getWeather($city) {
    $coords = getCoord($city);
    if ($coords) {
        $query = $coords['lat'] . ',' . $coords['lon'];
    } else {
        $query = $city;
    }

    $url = "http://api.weatherapi.com/v1/forecast.json?key=" . WEATHERAPI_API_KEY . "&q=" . $query . "&days=3&aqi=no&alerts=no";
    $info = @file_get_contents($url);
    if ($info) {
        return json_decode($info, true);
    }
    return null;
}


/**
 * Recupere les coordonnees de la ville demandee en passant par le csv contenant toutes les villes francaises
 * @param string nom de la ville pour la recherche
 * 
 * @return array de latitude et longitude si la ville est dans le fichier csv
 */
function getCoord($city) {
    $filename = 'cities.csv';
    if (!file_exists($filename)) return null;

    $rows = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($rows as $row) {
        $fields = str_getcsv($row);
        if (isset($fields[4]) && strtolower(trim($fields[4])) === strtolower(trim((string)$city))) {
                return [
                    'lat' => $fields[6],
                    'lon' => $fields[7]
                ];
        }
    }
    return null;
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

/**
 * Permet de decoder le flux json du cookie city_history
 *
 * 
 * @return array de l'historique des villes visitees contenu dans le cookie
 */
function loadCookieHistory() {
    if (isset($_COOKIE['city_history'])) {
        $history = json_decode($_COOKIE['city_history'], true);
        if (is_array($history)) {
            return $history;
        }
    }
    return [];
}

/**
 * Sauvegarde l'historique des villes visitees dans le cookie city_history
 * @param array contenant l'historique des villes visitees 
 * 
 *
 */
function saveCookieHistory($history) {
    $history = array_slice($history, 0, 5);
    setcookie('city_history', json_encode($history), time() + (864000), "/");
}

/**
 * Ajoute la ville visitee a l'historique des villes visitees
 * 
 * 
 *
 */
function addCityHistory() {
    $city = isset($_GET['city']) ? trim($_GET['city']) : null;
    if ($city) {
        $history = loadCookieHistory();

        // Supprimer la ville si elle est déjà dans l'historique (insensible à la casse)
        $history = array_filter($history, function($c) use ($city) {
            return strtolower($c) !== strtolower($city);
        });

        // Ajouter la nouvelle ville au début
        array_unshift($history, $city);

        // Sauvegarder
        saveCookieHistory($history);
    }
}

/**
 * Permet d'afficher l'historique des villes visitees sous la forme d'une nav 
 * 
 * 
 * @return string qui est le code html necessaire pour afficher la nav
 */
function displayhistory() {
    $history = loadCookieHistory();
    if (!empty($history)) {
        $display = "<nav id='history'><ul>";
        $last5cities = array_slice($history, 0, 5);
        foreach ($last5cities as $city) {
            $display .= "<li><a href='https://adamleopole.alwaysdata.net/projet/meteoweek.php?city=" . str_replace(" ", "%20", $city) . "'>" . htmlspecialchars($city) . "</a></li>";
        }
        $display .= "</ul></nav>";
        return $display;
    }
    return null;
}

/**
 * Verifie le cookie mis en parametres pour l'actualiser si necessaire
 * 
 * 
 * @return string cookie ou la valeur de base dans le cas du style
 */
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

/**
 * Incremente 1 au compteur de visite de la ville mise en parametre
 * @param string ville pour laquelle on doit augmenter la stat de visite
 * 
 * 
 */
function addStat($ville) {
    if (!empty($ville)) {

    $fichier = './recherches.csv';
    $stats = [];

    if (file_exists($fichier)) {
        $f = fopen($fichier, 'r');
        while (($ligne = fgetcsv($f)) !== false) {
            if (count($ligne) === 2) {
                $stats[$ligne[0]] = (int)$ligne[1];
            }
        }
        fclose($f);
    }

    $stats[$ville] = ($stats[$ville] ?? 0) + 1;

    if (!file_exists($fichier)) {
        $f = fopen($fichier, 'w');
        fputcsv($f, ['Ville', 'Nombre de recherches']);
    } else {
        $f = fopen($fichier, 'w');
    }

    foreach ($stats as $nom => $nb) {
        fputcsv($f, [$nom, $nb]);
    }
    fclose($f);

    }
}
?>
