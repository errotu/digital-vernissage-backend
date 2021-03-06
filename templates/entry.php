<?php /** @var \DigitalVernissage\Entry $entry */ ?>

<?php $this->insert("header", ['back' => $back]) ?>

<form method="post" action="<?= explode('?', $_SERVER['REQUEST_URI'], 2)[0] ?>?page=entry&id=<?= $id ?>">

    <h2>Content</h2>
    <div class="row">
        <div class="three columns">
            <?php if (empty($entry->getThumb())): ?>
                <p>No thumbnail for <?= $entry->getSource() ?> found.</p>
            <?php else: ?>
                <img src="<?= $app->basepath . $entry->getThumb() ?>">
            <?php endif; ?>
        </div>

        <div class="nine columns">
            <?php $this->insert('translated_text', ["name" => "title", "string" => $entry->getTitle()]) ?>
            <!--<div class="row">
                <div class="one-half column">
                    <input class="button-primary" value="Upload Thumbnail" type="submit">
                </div>
                <div class="one-half column">
                    <input class="button-primary" value="Upload Image" type="submit">
                </div>

            </div>-->

        </div>
    </div>
    <div class="row">
        <?php $this->insert('translated_textarea', ["name" => "text", "string" => $entry->getText()]) ?>
    </div>
    <div class="row">
        <div class="one-half column">
            <input class="button-primary" value="Save Entry" type="submit" name="entry_submit">
        </div>
        <div class="one-half column">
            <input class="button-primary button-red" value="Delete Entry" type="submit" name="entry_delete"
                   onClick="return confirm('Are you sure you want to delete this Entry?')">
        </div>
    </div>
    <div class="row">
        <div class="one-third column">
            <img src="http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=<?= urlencode($entry->getUrl()) ?>">
        </div>
    </div>
</form>

<?php $this->insert("footer") ?>
