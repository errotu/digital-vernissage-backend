<?php $this->insert("header") ?>
<p>The Thumbnail has to have the <b>same</b> name as the image, ending with _thumb.</p>
<p>For example:<br/>
The Thumbnail of image1.png is named image1_thumb.png</p>
<h3>Select an Image</h3>
<div class="row select-image">
    <form method="get" action="<?= explode('?', $_SERVER['REQUEST_URI'], 2)[0] ?>">
        <div class="three columns">
            <?php for ($i = 0; $i < sizeof($images); $i = $i + 3): ?>
                <label><input type="radio" name="newImage" value="<?= $images[$i]['name'] ?>" required><img class="select"
                                                                src="<?= $images[$i]['webPath'] ?>"/></label>
            <?php endfor; ?>
        </div>
        <div class="three columns">
            <?php for ($i = 1; $i < sizeof($images); $i = $i + 3): ?>
                <label><input type="radio" name="newImage" value="<?= $images[$i]['name'] ?>" required><img class="select"
                                                                src="<?= $images[$i]['webPath'] ?>"/></label>
            <?php endfor; ?>
        </div>
        <div class="three columns">
            <?php for ($i = 2; $i < sizeof($images); $i = $i + 3): ?>
                <label><input type="radio" name="newImage" value="<?= $images[$i]['name'] ?>" required><img class="select"
                                                                src="<?= $images[$i]['webPath'] ?>"/></label>
            <?php endfor; ?>
        </div>
        <input type="hidden" name="page" value="new">
        <input type="hidden" name="step" value="2">
        <input type="submit" value="Next Step">
    </form>
</div>
<?php $this->insert("footer") ?>
