<?php
/** @var \DigitalVernissage\Vernissage $app */

?>
<?php $this->insert("header", ['back' => $back]) ?>
<div class="row">
    <form method="post" action="<?= explode('?', $_SERVER['REQUEST_URI'], 2)[0] ?>">
        <div class="twelve columns">
            <h2>Title</h2>
            <?php $this->insert('translated_text', ["name" => "title", "string" => $app->getTitle()]) ?>
            <h2>Intro</h2>
            <?php $this->insert('translated_text', ["name" => "intro", "string" => $app->getIntro()]) ?>
        </div>
        <div class="one-half column">
            <input class="button-primary" name="welcome_submit" value="Save Welcome" type="submit">
        </div>
    </form>

</div>


<div class="row" style="margin-top: 30px;">
    <div class="one-half column">
        <h2>Choose an element</h2>
    </div>
    <div class="one-half column">
        <form method="get" action="<?= $_SERVER['REQUEST_URI'] ?>">
            <input type="submit" value="Create New">
            <input type="hidden" name="page" value="new"/>
            <input type="hidden" name="step" value="1"/>
        </form>
    </div>
</div>

<div class="row overview">
    <?php $i = 0;
    foreach ($app->getEntries() as $entry):
    ?>
    <div class="three columns">
        <a href="?page=entry&id=<?= $entry->getId() ?>"><img src="<?= "content/" . $entry->getThumb() ?>"></a>
    </div>
    <?php
    $i++;
    if ($i % 4 == 0):
    ?>
</div>
<div class="row overview">
    <?php
    endif;
    endforeach;
    ?>
</div>
<?php $this->insert("footer") ?>
