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
                                       
$output = '<div class="zt-news">';
$output .=  '<div class="zt-news-wrap horizontal">';
$output .=    '<div id="zt-news-scroll-' . $module->id . '" class="zt-category owl-carousel owl-theme">';

foreach ($items as $key => $item) {

    // Get image
    if (@$item->thumb != '' && $isImage == 1) {
        $img     = '<div clas="post-thumbnail">';
        $img    .=      '<a href="' . $item->link .'" title="' . $item->title . '">';
        $img    .=          '<img alt="' . $item->title . '" title="' . $item->title . '" class="lazyOwl" src="' . $item->thumb . '"/>';
        $img    .=      '</a>';
        $img    .=  '</div>';
    }

    // Get title
    if ($showTitle) {
        $title  =   '<h3 class="zt-title">';
        $title  .=      '<a href="' .$item->link . '" title="' . $item->title . '">'. $item->title . '</a>';
        $title  .=   '</h3>';
    }
                            
    // Get introtext
    if ($showIntro && $item->introtext != false) {
        $intro  =   '<div class="zt-introtext">' . $item->introtext . '</div>';
        if ($showReadmore == 1) {
            $intro  .=  '<p class="zt-news-readmore">';
            $intro  .=      '<a class="readmore" href="' . $item->link . '">' . JTEXT::_('MOD_ZTNEWS_READMORE') . '</a>';
            $intro  .=  '</p>';
        }
    }

    // Get information
    if ($showInfo && !empty($item->info_format)) {
        $info   =   '<div class="zt-newsinfo">' . $item->info_format . '</div>';
    }

    // Get information 2
    if ($showInfo2 && !empty($item->info2_format)) {
        $info2  =   '<div class="zt-newsinfo2">' . $item->info2_format . '</div>';
    }

    $output .= '<div class="zt-article-item">';

        if ($wrapContent) {

            if (isset($img))
                $output .=  $img;

            $output .=  '<div class="zt-content-wrap">';

        }
                        
        for ($j=0; $j < 6; $j++) {

            if (!$wrapContent)
                if ($image_order == $j) 
                    if (isset($img))
                        $output .=  $img;

            if ($title_order == $j) 
                if (isset($title)) 
                    $output .=  $title;

            if ($intro_order == $j) 
                if (isset($intro)) 
                    $output .=  $intro;

            if ($info_order == $j) 
                if (isset($info)) 
                    $output .=  $info;

            if ($info2_order == $j) 
                if (isset($info2)) 
                    $output .=  $info2;      
        }

        if ($wrapContent)
            $output .=  '</div> <!--  End .zt-content-wrap -->';

    $output .= '</div>';
}

$output .=    '</div>';
$output .=   '<div class="clearfix"></div>';
$output .=  '</div>';
$output .= '</div>';

echo $output;

$script = array();
$script[] =  'jQuery(document).ready(function ($) {';
$script[] =  '   $("#zt-news-scroll-' . $module->id . '").owlCarousel({';
$script[] =  '       margin: ' . $space .',';
$script[] =  '       autoplay: ' . ($autoplay == 1 ? 'true' : 'false') . ',';
$script[] =  '       nav: '. ($showNav == 1 ? 'true' : 'false') . ',';
$script[] =  '       dots: '. ($showDots == 1 ? 'true' : 'false') . ',';
$script[] =  '       responsive: {';
$script[] =  '           0:     { items: ' . $breakpoint_xs . '},';
$script[] =  '           768:   { items: ' . $breakpoint_sm . '},';
$script[] =  '           992:   { items: ' . $breakpoint_md . '}';
$script[] =  '       }';
$script[] =  '   });';
$script[] =  '});';

JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));