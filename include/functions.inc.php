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

define('API_REGIONS', 'https://geo.api.gouv.fr/regions');
define('API_DEPARTEMENTS', 'https://geo.api.gouv.fr/regions/{code}/departements');
define('API_COMMUNES', 'https://geo.api.gouv.fr/departements/{code}/communes');
?>