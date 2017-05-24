<?php /** @var \DigitalVernisage\Entry $entry */ ?>

<?php $this->insert("header") ?>

<form method="post" action="/?page=entry&id=<?= $_GET['id'] ?>">

<h2>Content</h2>
<div class="row">
    <div class="three columns">
        <img src="<?= 'content/' . $entry->getThumb() ?>">
    </div>

    <div class="nine columns">
        <?php $this->insert('translated_text', ["name" => "title", "string" => $entry->getTitle()]) ?>
        <div class="row">
            <div class="one-half column">
                <input class="button-primary" value="Upload Thumbnail" type="submit">
            </div>
            <div class="one-half column">
                <input class="button-primary" value="Upload Image" type="submit">
            </div>

        </div>

    </div>
</div>
<div class="row">
    <?php $this->insert('translated_textarea', ["name" => "text", "string" => $entry->getText()]) ?>
    <input class="button-primary" value="Save Entry" type="submit" name="entry_submit">

</div>
</form>

<?php $this->insert("footer") ?>
