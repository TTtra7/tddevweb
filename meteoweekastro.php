<?php
require_once "./include/functions.inc.php";
$title = "Météo Info Astro";
$h1 ="Meteo Astro pour " . getcity();
require"./include/header.inc.php";
if (isset($_GET['city'])){
    echo addStat($_GET['city']);
}
?>
<?php if ($gotForecast): ?>
<main>
    <?php require "./include/forms.inc.php"; ?>
    <table>
        <caption>Tableau Astro des 3 prochains jours</caption>
        <tr>
            <th>Donnees\Jour</th>
            <th><a href="meteodetailled.php?city=<?php echo $city ?>&amp;day=0" class="tab-link"><?php echo date('d/m', strtotime($forecastday[0]['date'])); ?></a></th>
            <th><a href="meteodetailled.php?city=<?php echo $city ?>&amp;day=0" class="tab-link"><?php echo date('d/m', strtotime($forecastday[1]['date'])); ?></a></th>
            <th><a href="meteodetailled.php?city=<?php echo $city ?>&amp;day=0" class="tab-link"><?php echo date('d/m', strtotime($forecastday[2]['date'])); ?></a></th>
        </tr>
        <tr>
            <th>Lever du Soleil</th>
            <td><?php echo $forecastday[0]['astro']['sunrise']; ?></td>
            <td><?php echo $forecastday[1]['astro']['sunrise']; ?></td>
            <td><?php echo $forecastday[2]['astro']['sunrise']; ?></td>
        </tr>
        <tr>
            <th>Coucher du Soleil</th>
            <td><?php echo $forecastday[0]['astro']['sunset']; ?></td>
            <td><?php echo $forecastday[1]['astro']['sunset']; ?></td>
            <td><?php echo $forecastday[2]['astro']['sunset']; ?></td>
        </tr>
        <tr>
            <th>Phase de la lune</th>
            <td><?php echo $forecastday[0]['astro']['moon_phase']; ?></td>
            <td><?php echo $forecastday[1]['astro']['moon_phase']; ?></td>
            <td><?php echo $forecastday[2]['astro']['moon_phase']; ?></td>
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