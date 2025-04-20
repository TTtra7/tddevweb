<form method="GET">
    <label for="region">Choisissez une région :</label>
    <select name="region" id="region" onchange="this.form.submit()">
        <option value="">-- sélectionner région --</option>
        <?php foreach ($regionsData as $regionName => $deps): ?>
            <option value="<?= htmlspecialchars($regionName) ?>" <?= ($regionName == $selectedRegion) ? 'selected' : '' ?>>
                <?= htmlspecialchars($regionName) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<?php if ($selectedRegion): ?>
    <form method="GET">
        <input type="hidden" name="region" value="<?= htmlspecialchars($selectedRegion) ?>">
        <label for="departement">Choisissez un département :</label>
        <select name="departement" id="departement" onchange="this.form.submit()">
            <option value="">-- sélectionner département --</option>
            <?php foreach ($departements as $dep): ?>
                <option value="<?= htmlspecialchars($dep[0]) ?>" <?= ($dep[0] == $selectedDepartement) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($dep[0]) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
<?php endif; ?>

<?php if ($selectedDepartement): ?>
    <form action="./meteoweek.php" method="GET">
        <input type="hidden" name="region" value="<?= htmlspecialchars($selectedRegion) ?>">
        <input type="hidden" name="departement" value="<?= htmlspecialchars($selectedDepartement) ?>">
        <label for="city-2">Choisissez une commune :</label>
        <input list="communeList" name="city" id="city-2" onchange="this.form.submit()" placeholder="- sélectionner commune -">
        <datalist id="communeList">
            <?php foreach ($communes as $city): ?>
                <option value="<?= htmlspecialchars($city) ?>">
                    <?= htmlspecialchars($city) ?>
                </option>
            <?php endforeach; ?>
        </datalist>
    </form>
<?php endif; ?>