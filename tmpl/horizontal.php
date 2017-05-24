<?php
/**
 * ZT News
 *
 * @package     Joomla
 * @subpackage  Module
 * @version     2.6.6
 * @author      ZooTemplate
 * @email       support@zootemplate.com
 * @link        http://www.zootemplate.com
 * @copyright   Copyright (c) 2017 ZooTemplate
 * @license     GPL v2
 */
defined('_JEXEC') or die('Restricted access');

$doc = JFactory::getDocument();

$doc->addScript(JUri::root() . 'modules/mod_zt_news/assets/js/owl.carousel.min.js');
$doc->addStyleSheet(JUri::root() . 'modules/mod_zt_news/assets/css/owl_carousel/owl.carousel.min.css');
$doc->addStyleSheet(JUri::root() . 'modules/mod_zt_news/assets/css/owl_carousel/owl.theme.default.min.css');

?>
<div class="zt_news_wrap">
    <div class="zt-newsiv-frame-cat">
        <div id="zt-news-scroll-<?php echo $module->id; ?>" class="zt-category owl-carousel owl-theme">
            <?php foreach ($items as $key => $item) : ?>
                <div class="item zt-article-item">
                    <?php if (@$item->thumb != '' && $isImage == 1): ?>
                        <a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>">
                            <img alt="<?php echo $item->title; ?>"
                                 title="<?php echo $item->title; ?>" class="lazyOwl"
                                 src="<?php echo $item->thumb; ?>"/>
                        </a>
                    <?php endif; ?>
                    <?php if ($showTitle): ?>
                        <h3>
                            <a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>">
                                <?php echo $item->title; ?>
                            </a>
                        </h3>
                    <?php endif; ?>
                    <!-- Author -->
                    <?php if ($showAuthor) : ?>     
                        <span class="author">
                            <?php echo $item->author; ?>
                        </span>
                    <?php endif ?>
                    <!-- Created -->
                    <?php if ($showCreated): ?>
                        <span
                            class="created"><?php echo JHTML::_('date', $item->created, JText::_($dateFormat)); ?>
                            - <?php
                            echo $item->hits;
                            echo JText::_('MOD_ZTNEWS_VIEWS');
                            ?></span>
                    <?php endif; ?>
                    <!-- Category -->
                    <?php if ($showTitleCategory) : 
                            echo JHTML::_('link', $item->cat_link, $item->cat_title, array('class'=>'incategory'));
                        endif ?>
                    <?php if ($showIntro): ?>
                        <?php if ($item->introtext != false): ?>
                            <div class="zt-introtext"><?php echo($item->introtext); ?></div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ($showReadmore == 1): ?>
                        <p class="zt-news-readmore">
                            <a class="readmore"
                               href="<?php echo $item->link; ?>"><?php echo JTEXT::_('MOD_ZTNEWS_READMORE'); ?></a>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $("#zt-news-scroll-<?php echo $module->id; ?>").owlCarousel({
                    autoplay: <?php echo $autoplay == 1 ? 'true' : 'false' ?>,
                    nav: <?php echo $showNav == 1 ? 'true' : 'false' ?>,
                    dots: <?php echo $showDots == 1 ? 'true' : 'false' ?>,
                    responsive: {
                        <?php if($responsive == 1) : ?>
                        0: {
                            items: 1
                        },
                        480: {
                            items: 2
                        },
                        768: {
                            items: <?php echo $breakpoint; ?>
                        }
                        <?php else : ?>
                        0: {
                            items: <?php echo $breakpoint; ?>
                        }
                        <?php endif ?>
                    }
                });
            });
        </script>
    </div>
    <div class="clearfix"></div>
</div>