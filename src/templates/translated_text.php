<div class="row">
    <?php
    foreach ($string->getLanguages() as $lang) {
        ?>
        <label>
            <?= $string->getLanguage($lang) ?>
            <input name="<?= $name . "-" . $lang ?>" type="text" value="<?= $string->read($lang) ?>">
        </label>

        <?php
    }
    ?>
</div>
