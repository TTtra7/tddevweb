<?php
require_once "./include/functions.inc.php";
$title = "Météo Info Semaine";
$h1 ="Meteo pour " . getcity();
require"./include/header.inc.php";
?>
<main>
	<? require"./include/forms.inc.php"; ?>

	<table>
        <caption>Tableau des previsions pour les 4 prochains jours</caption>
        <tr>
            <th><a href="meteodetailled.php?city=<?php echo $city?>&day=0"><?php echo date('d/m', strtotime($forecastday[0]['date'])); ?></a></th>
            <th><a href="meteodetailled.php?city=<?php echo $city?>&day=1"><?php echo date('d/m', strtotime($forecastday[1]['date'])); ?></a></th>
            <th><a href="meteodetailled.php?city=<?php echo $city?>&day=2"><?php echo date('d/m', strtotime($forecastday[2]['date'])); ?></a></th>
            <th><a href="meteodetailled.php?city=<?php echo $city?>&day=3"><?php echo date('d/m', strtotime($forecastday[3]['date'])); ?></a></th>
        </tr>
        <tr>
            <td><img src="<?php echo $forecastday[0]['day']['condition']['icon']; ?>" alt="Météo"></td>
            <td><img src="<?php echo $forecastday[1]['day']['condition']['icon']; ?>" alt="Météo"></td>
            <td><img src="<?php echo $forecastday[2]['day']['condition']['icon']; ?>" alt="Météo"></td>
            <td><img src="<?php echo $forecastday[3]['day']['condition']['icon']; ?>" alt="Météo"></td>
        </tr>
        <tr>
            <td><?php echo $forecastday[0]['day']['avgtemp_c']; ?>°C</td>
            <td><?php echo $forecastday[1]['day']['avgtemp_c']; ?>°C</td>
            <td><?php echo $forecastday[2]['day']['avgtemp_c']; ?>°C</td>
            <td><?php echo $forecastday[3]['day']['avgtemp_c']; ?>°C</td>
        </tr>
        <tr>
            <td>Vent: <?php echo $forecastday[0]['day']['maxwind_kph']; ?> km/h</td>
            <td>Vent: <?php echo $forecastday[1]['day']['maxwind_kph']; ?> km/h</td>
            <td>Vent: <?php echo $forecastday[2]['day']['maxwind_kph']; ?> km/h</td>
            <td>Vent: <?php echo $forecastday[3]['day']['maxwind_kph']; ?> km/h</td>
        </tr>
        <tr>
            <td>Précip.: <?php echo $forecastday[0]['day']['totalprecip_mm']; ?> mm</td>
            <td>Précip.: <?php echo $forecastday[1]['day']['totalprecip_mm']; ?> mm</td>
            <td>Précip.: <?php echo $forecastday[2]['day']['totalprecip_mm']; ?> mm</td>
            <td>Précip.: <?php echo $forecastday[3]['day']['totalprecip_mm']; ?> mm</td>
        </tr>
    </table>
</main>
<?php
require"./include/footer.inc.php";
?>