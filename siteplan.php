<?php
require_once "./include/functions.inc.php";
$title = "Météo Info Plan Site";
$h1 ="Plan du Site";
require"./include/header.inc.php";
?>
<main>
	<ul>
        <li><a href="./index.php">Carte de France</a></li>
        <li><a href="./meteoweek.php">Meteo de la semaine</a></li>
        <li><a href="./meteoweekastro.php">Meteo Astro de la semaine</a></li>
        <li><a href="./stat.php">Statistiques</a></li>
        <li><a href="./siteplan.php">Plan du site</a></li>
    </ul>
</main>
<?php
require"./include/footer.inc.php";
?>