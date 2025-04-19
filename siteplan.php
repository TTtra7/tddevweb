<?php
require_once "./include/functions.inc.php";
$title = "Météo Info Plan Site";
$h1 ="Plan du Site";
require"./include/header.inc.php";
?>
<main>
	<ul>
        <li><a href="https://adamleopole.alwaysdata.net/projet/index.php">Carte de France</a></li>
        <li><a href="https://adamleopole.alwaysdata.net/projet/meteoweek.php">Meteo de la semaine</a></li>
        <li><a href="https://adamleopole.alwaysdata.net/projet/meteoweekastro.php">Meteo Astro de la semaine</a></li>
        <li><a href="https://adamleopole.alwaysdata.net/projet/stat.php">Statistiques</a></li>
        <li><a href="https://adamleopole.alwaysdata.net/projet/siteplan.php">Plan du site</a></li>
    </ul>
</main>
<?php
require"./include/footer.inc.php";
?>