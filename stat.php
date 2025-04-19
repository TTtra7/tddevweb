<?php
require_once "./include/functions.inc.php";
$title = "Météo Info Statistiques";
$h1 ="Statistiques";
require"./include/header.inc.php";
?>
<main>
	<? require"./include/forms.inc.php"; ?>
    <?php
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

        echo "<table>";
        echo "<tr><th>Ville</th><th>Nombre de recherches</th></tr>";

        foreach ($stats as $ville => $nb_recherches) {
            echo "<tr><td>" . htmlspecialchars($ville) . "</td><td>" . $nb_recherches . "</td></tr>";
        }

        echo "</table>";
    ?>
</main>
<?php
require"./include/footer.inc.php";
?>