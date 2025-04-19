<aside>
    <?php
        $images = glob('./photos/*.{jpg,jpeg,png,gif}', GLOB_BRACE);

        if (!empty($images)) {
            $randomImage = $images[array_rand($images)];
            $fileName = basename($randomImage);
            echo '<figure>';
            echo '<img src="'.$randomImage.'" alt="'.htmlspecialchars($fileName).'" width="500" height="500"/>';
            echo '<figcaption>'.htmlspecialchars($fileName).'</figcaption>';
            echo '</figure>';
        } else {
            echo '<p>Aucune image trouvée dans le dossier "photos".</p>';
        }
    ?>
</aside>