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
?>
<div class="zt_news_wrap"> 
    <div class="zt-newsiv-frame-cat">
        <div id="zt-news-scroll-<?php echo $module->id; ?>" class="zt-category">
            <?php
            foreach ($items as $key => $item) :

                ?>
                <div class="item zt-article-item">
                    <?php if (@$item->thumb != '' && $isImage == 1): ?>
                        <a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>">
                            <img alt="<?php echo $item->title; ?>"
                                 title="<?php echo $item->title; ?>" class="lazyOwl" data-src="<?php echo $item->thumb; ?>"/>
                        </a>
                    <?php endif; ?>
                    <?php if ($showTitle): ?>
                        <h3>
                            <a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>">
                                <?php echo $item->title; ?>
                            </a>
                        </h3>
                    <?php endif; ?>
                    <?php if ($showCreated): ?>
                        <span class="created"><?php echo JHTML::_('date', $item->created, JText::_('DATE_FORMAT_LC3')); ?> - <?php
                            echo $item->hits;
                            echo JText::_(' Views');
                            ?></span>
                    <?php endif; ?>
                    <?php if ($showIntro): ?>
                        <?php  if ($item->introtext != false): ?>
                            <p class="zt-introtext"><?php echo ($item->introtext); ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ($params->get('show_readmore') == 1): ?>
                        <p class="zt-news-readmore">
                            <a class="readmore" href="<?php echo $item->link; ?>"><?php echo JTEXT::_('READ MORE'); ?></a>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $("#zt-news-scroll-<?php echo $module->id; ?>").owlCarousel({
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