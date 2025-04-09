<?php
require_once "./include/functions.inc.php";
$title = "Météo Info Detaillée";
$h1 = "Météo";

require"./include/header.inc.php";

if (isset($_GET['day'])) {
	$day = $_GET['day'];
} else {
	$day = 0;
}
$forecasthourday = $data['forecast']['forecastday'][$day]['hour'];
?>
<main>
	<? require"./include/forms.inc.php"; ?>

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
        <?php foreach ($forecasthourday as $hour) : ?>
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
<?php
require"./include/footer.inc.php";
?>