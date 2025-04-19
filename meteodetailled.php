<?php
require_once "./include/functions.inc.php";
$title = "Météo Info Detaillée";
$tab = ['0' => " aujourd'hui",'1' => ' demain','2' => ' apres demain'];
$h1 = "Meteo pour " . getcity() . $tab[$_GET['day']];

require"./include/header.inc.php";

if (isset($_GET['day'])) {
	$day = $_GET['day'];
} else {
	$day = 0;
}
?>
<?php if ($gotForecast): ?>
<?php $forecasthourday = $data['forecast']['forecastday'][$day]['hour']; ?>
<main>
	<? require"./include/forms.inc.php"; ?>
    <a href="https://adamleopole.alwaysdata.net/projet/meteoweek.php?city=<?php echo $_GET['city']?>" class="link" style="margin-top: 20px; margin-bottom: 20px;"> Retour a la meteo pour les 3 jours</a>
	<table class="detailled">
    <caption>Tableau des prévisions détaillées pour aujourd'hui</caption>
    <tr>
        <th>Données</th>
        <?php foreach ($forecasthourday as $hour) : ?>
            <th><?php echo date('H:i', strtotime($hour['time'])); ?></th>
        <?php endforeach; ?>
    </tr>
    <tr>
        <th>Température (°C)</th>
        <?php foreach ($forecasthourday as $hour) : ?>
            <td><?php echo $hour['temp_c']; ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <th>Icône</th>
        <?php foreach ($forecasthourday as $hour) : ?>
            <td><img src="<?php echo $hour['condition']['icon']; ?>" alt="Météo"/></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <th>Vent (km/h)</th>
        <?php foreach ($forecasthourday as $hour) : ?>
            <td><?php echo $hour['wind_kph']; ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <th>Humidité (%)</th>
        <?php foreach ($forecasthourday as $hour) : ?>
            <td><?php echo $hour['humidity']; ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <th>Nuages (%)</th>
        <?php foreach ($forecasthourday as $hour) : ?>
            <td><?php echo $hour['cloud']; ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <th>UV Index</th>
        <?php foreach ($forecasthourday as $hour) : ?>
            <td><?php echo $hour['uv']; ?></td>
        <?php endforeach; ?>
    </tr>
</table>
</main>
<?php else: ?>
<main>
    <span>Erreur lors de la saisie de la ville, veuillez réessayer</span>
    <form method="GET" action="https://adamleopole.alwaysdata.net/projet/meteoweek.php">
        <input type="text" name="city" placeholder="Entrez une ville" required>
        <button type="submit">Rechercher</button>
    </form>
</main>
<?php endif; ?>
<?php
require"./include/footer.inc.php";
?>