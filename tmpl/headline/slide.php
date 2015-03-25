<?php
$listArticles = array_slice($slide, $params->get('no_intro_items', 1));
?>
<div class="row">
    <?php $index = 0; ?>
    <?php foreach ($slide as $key => $article) : ?>
        <?php if ($index < $params->get('no_intro_items', 1)) : ?>
            <div class="col-md-6 head"><?php echo $article->title; ?></div>
        <?php endif; ?>
        <?php $index++; ?>
    <?php endforeach; ?>

    <div class="col-md-6">
        <div class="row">
            <?php foreach ($listArticles as $article) : ?>
                <div class="col-md-6"><?php echo $article->title; ?></div>
            <?php endforeach; ?>
        </div>
    </div>
</div>