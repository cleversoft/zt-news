<?php
$listArticles = array_slice($slide, $params->get('no_intro_items', 1));

$doc = JFactory::getDocument();

$lead = (int) $params->get('no_intro_items', 1);
$thumbmainwidth = $params->get('thumb_main_width');
$thumbmainheight = $params->get('thumb_main_height');
$thumblistwidth = $params->get('thumb_list_width');
$thumblistheight = $params->get('thumb_list_height');
$showtitlecat = $params->get('showtitlecat', 1);
$created = $params->get('show_date', 1);
$createdlist = $params->get('show_date_list', 1);
$showtitle = $params->get('show_title', 1);
$showtitlelist = $params->get('show_title_list', 1);
$showintro = $params->get('show_intro', 1);
$showintrolist = $params->get('show_intro_list', 1);
$showimglist = $params->get('is_image_list', 1);
$showsubcat = $params->get('is_subcat', 1);
$source = $params->get('source');
?>
<div class="zt-category headline">
    <div class="row">
        <?php $index = 0; ?>
        <?php foreach ($slide as $key => $article) : ?>



            <?php if ($index < $params->get('no_intro_items', 1)) : ?>
                <div class="col-md-6 zt-article-items">
                    <div class="link-category">
                        <?php echo $ztNews->getCategoryLink($article->cat->id, $source); ?>
                    </div>

                    <?php 
                        if($key == 0) {
                            $thumbUrl = modZTNewsHelper::getThumbnailLink($article->thumb, $thumbmainwidth, $thumbmainheight);     
                        }else {
                            $thumbUrl = modZTNewsHelper::getThumbnailLink($article->thumb, $thumblistwidth, $thumblistheight);     
                        }
                    
                    ?>
                   <a href="<?php echo $article->link; ?>" title="">
                        <img class="thumbnail" src="<?php echo $thumbUrl; ?>" alt="<?php echo $article->title; ?>"
                             title="<?php echo $article->title; ?>"/>
                    </a>
                    <div class="zt-article_content">
                        <?php 
                            if ($showtitle){
                            ?>
                                <h3>
                                    <a href="<?php echo $article->link; ?>" title="">
                                        <?php echo $article->title; ?>
                                    </a>
                                </h3>
                        <?php } ?>

                        <?php
                            if ($created){
                            ?>
                                <span class="created"><?php echo JHTML::_('date', $article->created, JText::_('DATE_FORMAT_LC3')); ?> - <?php
                                    echo $article->hits;
                                    echo JText::_(' Views');
                                    ?>
                                </span>
                        <?php } ?>

                        <?php
                            if ($showintro){
                            ?>
                                <?php
                                if ($article->introtext != false)
                                {
                                    ?>
                                    <p class="zt-introtext"><?php echo ($article->introtext); ?></p>
                                <?php } ?>
                        <?php } ?> 

                        <?php
                            if ($params->get('show_readmore') == 1){
                            ?>
                                <p class="zt-news-readmore">
                                    <a class="readmore" href="<?php echo $article->link; ?>"><?php echo JTEXT::_('READ MORE'); ?></a>
                                </p>
                        <?php } ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php $index++; ?>
        <?php endforeach; ?>

        <div class="col-md-6">
            <div class="row">
                <?php foreach ($listArticles as $article) : ?>
                    <div class="col-md-6 zt-article-items">
                        <div class="link-category">
                            <?php echo $ztNews->getCategoryLink($article->cat->id, $source); ?>
                        </div>
                        <?php 
                            if($key == 0) {
                                $thumbUrl = modZTNewsHelper::getThumbnailLink($article->thumb, $thumbmainwidth, $thumbmainheight);     
                            }else {
                                $thumbUrl = modZTNewsHelper::getThumbnailLink($article->thumb, $thumblistwidth, $thumblistheight);     
                            }
                    
                        ?>
                       <a href="<?php echo $article->link; ?>" title="">
                            <img class="thumbnail" src="<?php echo $thumbUrl; ?>" alt="<?php echo $article->title; ?>"
                                 title="<?php echo $article->title; ?>"/>
                        </a>
                        <div class="zt-article_content">
                            <?php 
                            if ($showtitle){
                                ?>
                                <h3>
                                    <a href="<?php echo $article->link; ?>" title="">
                                        <?php echo $article->title; ?>
                                    </a>
                                </h3>
                            <?php } ?>

                            <?php
                                if ($created){
                                ?>
                                <span class="created"><?php echo JHTML::_('date', $article->created, JText::_('DATE_FORMAT_LC3')); ?> - <?php
                                    echo $article->hits;
                                    echo JText::_(' Views');
                                    ?>
                                </span>
                            <?php } ?>

                           <?php
                                if ($showintrolist)
                                {
                                ?>
                                <p class="zt-introtext"> <?php echo substr($article->introtext, 0, 70); ?></p>
                            <?php } ?>

                            <?php
                                if ($params->get('show_readmore') == 1)
                                {
                                ?>
                                    <p class="zt-news-readmore">
                                        <a class="readmore" href="<?php echo $article->link; ?>"><?php echo JTEXT::_('READ MORE'); ?></a>
                                    </p>
                            <?php } ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>