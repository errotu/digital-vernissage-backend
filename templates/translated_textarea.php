<div class="row">
    <?php
    foreach ($string->getLanguages() as $lang) {
        ?>
        <label>
            <?= $string->getLanguage($lang) ?>
            <textarea name="<?= $name . "-" . $lang ?>"><?= $string->read($lang) ?></textarea>
        </label>

        <?php
    }
    ?>
</div>
