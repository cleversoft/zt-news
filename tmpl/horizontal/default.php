<?php
/**
 * ZT News
 * 
 * @package     Joomla
 * @subpackage  Module
 * @version     2.0.0
 * @author      ZooTemplate 
 * @email       support@zootemplate.com 
 * @link        http://www.zootemplate.com 
 * @copyright   Copyright (c) 2015 ZooTemplate
 * @license     GPL v2
 */
defined('_JEXEC') or die('Restricted access');

$doc = JFactory::getDocument();
if (!version_compare(JVERSION, '3.0', 'ge'))
{
    $doc->addScript(JUri::root() . 'modules/mod_zt_news/assets/js/jquery-1.11.1.min.js');
}
$doc->addScript(JUri::root() . 'modules/mod_zt_news/assets/js/owl_carousel/owl.carousel.min.js');
$doc->addStyleSheet(JUri::root() . 'modules/mod_zt_news/assets/css/owl_carousel/owl.carousel.css');
$doc->addStyleSheet(JUri::root() . 'modules/mod_zt_news/assets/css/owl_carousel/owl.theme.css');
$doc->addStyleSheet(JUri::root() . 'modules/mod_zt_news/assets/css/owl_carousel/owl.transitions.css');
$thumbmainwidth = $params->get('thumb_main_width');
$thumbmainheight = $params->get('thumb_main_height');
$created = $params->get('show_date', 1);
$showtitle = $params->get('show_title', 1);
$showintro = $params->get('show_intro', 1);
$source = $params->get('source');
$breakpoint = $params->get('breakpoint');
?>
<div class="zt_news_wrap"> 
    <div class="zt-newsiv-frame-cat">
        <div id="zt-news-scroll-<?php echo $moduleId; ?>" class="zt-category">
            <?php $cats = array(); ?>
            <?php
                for ($i = 0; $i < count($listCategories); $i++):
            ?>
                <?php $cats[$i] = $listCategories[$i][0]; ?>
            <?php endfor; ?>
            <?php
            $listItems = $ztNews->getItemsByCatId($cats);
            for ($j = 0; $j < count($listItems); $j++) :
                ?>
                <div class="item zt-article-item">
                    <?php if (@$listItems[$j]->thumb != '' && $params->get('is_image', 1) == 1): ?>
                        <?php $thumbUrl = modZTNewsHelper::getThumbnailLink($listItems[$j]->thumb, $thumbmainwidth, $thumbmainheight); ?>
                        <a href="<?php echo $listItems[$j]->link; ?>" title="<?php echo $listItems[$j]->title; ?>">
                            <img alt="<?php echo $listItems[$j]->title; ?>"
                                 title="<?php echo $listItems[$j]->title; ?>" class="lazyOwl" data-src="<?php echo $thumbUrl; ?>"/>
                        </a>
                    <?php endif; ?>
                    <?php if ($showtitle): ?>
                        <h3>
                            <a href="<?php echo $listItems[$j]->link; ?>" title="<?php echo $listItems[$j]->title; ?>">
                                <?php echo $listItems[$j]->title; ?>
                            </a>
                        </h3>
                    <?php endif; ?>
                    <?php if ($created): ?>
                        <span class="created"><?php echo JHTML::_('date', $listItems[$j]->created, JText::_('DATE_FORMAT_LC3')); ?> - <?php
                            echo $listItems[$j]->hits;
                            echo JText::_(' Views');
                            ?></span>
                    <?php endif; ?>
                    <?php if ($showintro): ?>
                        <?php  if ($listItems[$j]->introtext != false): ?>
                            <p class="zt-introtext"><?php echo ($listItems[$j]->introtext); ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ($params->get('show_readmore') == 1): ?>
                        <p class="zt-news-readmore">
                            <a class="readmore" href="<?php echo $listItems[$j]->link; ?>"><?php echo JTEXT::_('READ MORE'); ?></a>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $("#zt-news-scroll-<?php echo $moduleId; ?>").owlCarousel({
                    lazyLoad: true,
                    navigation: true,
                    pagination: false,
                    slideSpeed: 500,
                    itemsCustom: [<?php echo $breakpoint; ?>]
                });
            });
        </script>
    </div>   
    <div class="clearfix"></div>
</div>