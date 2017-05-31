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

                <?php for ($j=0; $j < 6; $j++) : ?>
                            
                    <?php if ($image_order == $j) : ?>

                        <?php if (@$item->thumb != '' && $isImage == 1): ?>
                            <a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>">
                                <img alt="<?php echo $item->title; ?>"
                                     title="<?php echo $item->title; ?>" class="lazyOwl"
                                     src="<?php echo $item->thumb; ?>"/>
                            </a>
                        <?php endif; ?>

                    <?php endif ?>

                    <?php if ($title_order == $j) : ?>

                        <?php if ($showTitle): ?>
                            <h3 class="zt-title">
                                <a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>">
                                    <?php echo $item->title; ?>
                                </a>
                            </h3>
                        <?php endif; ?>

                    <?php endif ?>

                    <?php if ($intro_order == $j) : ?>
                        <!-- Intro text -->
                        <?php if ($showIntro && $item->introtext != false) : ?>
                            <div class="zt-introtext"><?php echo ($item->introtext); ?></div>
                            <?php if ($showReadmore == 1): ?>
                                <p class="zt-news-readmore">
                                    <a class="readmore"
                                       href="<?php echo $item->link; ?>"><?php echo JTEXT::_('MOD_ZTNEWS_READMORE'); ?></a>
                                </p>
                            <?php endif; ?>
                        <?php endif; ?> 
                    <?php endif ?>

                    <?php if ($info_order == $j) : ?>
                        <!-- Information -->
                        <?php if ($showInfo && !empty($item->info_format)) : ?>
                            <div class="zt-newsinfo"><?php echo ($item->info_format); ?></div>
                        <?php endif; ?> 
                    <?php endif ?>

                    <?php if ($info2_order == $j) : ?>
                        <!-- Information 2 -->
                        <?php if ($showInfo2 && !empty($item->info2_format)) : ?>
                            <div class="zt-newsinfo2"><?php echo ($item->info2_format); ?></div>
                        <?php endif; ?> 
                    <?php endif ?>

                <?php endfor ?>


                </div>
            <?php endforeach; ?>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $("#zt-news-scroll-<?php echo $module->id; ?>").owlCarousel({
                    margin: <?php echo $space ?>,
                    autoplay: <?php echo $autoplay == 1 ? 'true' : 'false' ?>,
                    nav: <?php echo $showNav == 1 ? 'true' : 'false' ?>,
                    dots: <?php echo $showDots == 1 ? 'true' : 'false' ?>,
                    responsive: {
                        0: {
                            items: <?php echo $breakpoint_xs; ?>
                        },
                        768: {
                            items: <?php echo $breakpoint_sm; ?>
                        },
                        992: {
                            items: <?php echo $breakpoint_md; ?>
                        }
                    }
                });
            });
        </script>
    </div>
    <div class="clearfix"></div>
</div>