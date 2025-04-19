<?php
require_once "./include/functions.inc.php";
$title = "Météo Info Semaine";
$h1 ="Meteo pour " . getcity();
require"./include/header.inc.php";
if (isset($_GET['city'])){
    echo addStat($_GET['city']);
}
?>
<?php if ($gotForecast): ?>
<main>
    <?php require "./include/forms.inc.php"; ?>
    <table>
        <caption>Tableau des prévisions pour les 3 prochains jours</caption>
        <tr>
            <th>Donnees\Jour</th>
            <th><a href="meteodetailled.php?city=<?php echo $city ?>&amp;day=0" class="tab-link"><?php echo date('d/m', strtotime($forecastday[0]['date'])); ?></a></th>
            <th><a href="meteodetailled.php?city=<?php echo $city ?>&amp;day=1" class="tab-link"><?php echo date('d/m', strtotime($forecastday[1]['date'])); ?></a></th>
            <th><a href="meteodetailled.php?city=<?php echo $city ?>&amp;day=2" class="tab-link"><?php echo date('d/m', strtotime($forecastday[2]['date'])); ?></a></th>
        </tr>
        <tr>
            <th>Icone Meteo</th>
            <td><img src="<?php echo $forecastday[0]['day']['condition']['icon']; ?>" alt="Météo Icon"/></td>
            <td><img src="<?php echo $forecastday[1]['day']['condition']['icon']; ?>" alt="Météo Icon"/></td>
            <td><img src="<?php echo $forecastday[2]['day']['condition']['icon']; ?>" alt="Météo Icon"/></td>
        </tr>
        <tr>
            <th>Temperature en °C</th>
            <td><?php echo $forecastday[0]['day']['avgtemp_c']; ?></td>
            <td><?php echo $forecastday[1]['day']['avgtemp_c']; ?></td>
            <td><?php echo $forecastday[2]['day']['avgtemp_c']; ?></td>
        </tr>
        <tr>
            <th>Vent en Km/h</th>
            <td><?php echo $forecastday[0]['day']['maxwind_kph']; ?> </td>
            <td><?php echo $forecastday[1]['day']['maxwind_kph']; ?> </td>
            <td><?php echo $forecastday[2]['day']['maxwind_kph']; ?> </td>
        </tr>
        <tr>
            <th>Précip. en mm</th>
            <td><?php echo $forecastday[0]['day']['totalprecip_mm']; ?></td>
            <td><?php echo $forecastday[1]['day']['totalprecip_mm']; ?></td>
            <td><?php echo $forecastday[2]['day']['totalprecip_mm']; ?></td>
        </tr>
    </table>
    <?php require "./include/randomImage.inc.php"; ?>
</main>
<?php else: ?>
<main>
    <span>Erreur lors de la saisie de la ville, veuillez réessayer</span>
    <form method="GET" action="https://adamleopole.alwaysdata.net/projet/meteoweek.php">
        <input type="text" name="city" placeholder="Entrez une ville" required>
        <button type="submit">Rechercher</button>
    </form>
    <?php require "./include/randomImage.inc.php"; ?>
</main>
<?php endif; ?>
<?php
require"./include/footer.inc.php";
?>