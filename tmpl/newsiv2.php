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

$totalItemsPerSlide = $numberIntroItems + $numberLinkItems;
$index = 0;
$count = 0;
foreach ($items as $item)
{
    $list[$index][] = $item;
    $count++;
    if ($count == $totalItemsPerSlide)
    {
        $index++;
        $count = 0;
    }

}

$output  = '<div class="zt-news">';
$output .=  '<div class="zt-news-wrap newsiv2">';

foreach ($list as $key => $slide) {
    $listItems = array_slice($slide, $numberIntroItems);
    $index = 0; 

    $output .= '<div class="zt-article-item">';

        foreach ($slide as $key => $item) {
            if ($index < $numberIntroItems) {
                // Get image
                if ($isImage) {
                    $img    = '<div class="post-thumbnail">';
                    $img   .=   '<a href="' . $item->link . '" title="">';
                        if (!empty($item->thumb))
                            $img   .= '<img class="thumbnail" src="' . $item->thumb . '" alt="' . $item->title . '" title="' . $item->title . '"/>';
                    $img   .=   '</a>';
                    $img   .= '</div>';
                }

                // Get title
                if ($showTitle) {
                    $title  = '<h3 class="zt-title">';
                    $title .=   '<a href="' . $item->link . '">' . $item->title . '</a>';
                    $title .= '</h3>';
                }
                                                    
                // Get intro
                if ($showIntro && $item->introtext != false) {
                    $intro  = '<div class="zt-introtext">' . $item->introtext . '</div>';
                    if ($showReadmore) {
                        $intro  .= '<p class="zt-news-readmore">';
                        $intro  .=      '<a class="readmore" href="' . $item->link .'">' . JTEXT::_('MOD_ZTNEWS_READMORE') .'</a>';
                        $intro  .= '</p>';
                    }                    
                } 

                // Get infomation    
                if ($showInfo && !empty($item->info_format)) {
                    $info = '<div class="zt-newsinfo">' . $item->info_format . '</div>';
                }
                                                    
                // Get second infomation    
                if ($showInfo2 && !empty($item->info2_format)) {
                    $info = '<div class="zt-newsinfo2">' . $item->info2_format . '</div>';
                } 

                $output .= '<div class="col-sm-6 zt-main-item">';
                $output .=  '<div class="zt-item">';

                if ($wrapContent) {
                    if (isset($img))
                        $output .=  $img;
                    $output .=  '<div class="zt-content-wrap">';
                }
                                    
                for ($i=1; $i < 6; $i++) {

                    if (!$wrapContent)
                        if ($image_order == $i) 
                            if (isset($img))
                                $output .=  $img;

                    if ($title_order == $i) 
                        if (isset($title)) 
                            $output .=  $title;

                    if ($intro_order == $i) 
                        if (isset($intro)) 
                            $output .=  $intro;

                    if ($info_order == $i) 
                        if (isset($info)) 
                            $output .=  $info;

                    if ($info2_order == $i) 
                        if (isset($info2)) 
                            $output .=  $info2;      
                }

                if ($wrapContent)
                    $output .=  '</div> <!--  End .zt-content-wrap -->';

                $output .=  '</div>';
                $output .= '</div><!-- End .zt-main-item -->';

                $index++;
            }
        }

        $output .= '<div class="col-sm-6 zt-list-items">';

            foreach ($listItems as $key => $item) {
                // Get image
                if ($showImageList) {
                    $sub_img    = '<div class="post-thumbnail">';
                    $sub_img   .=   '<a href="' . $item->link . '" title="">';
                        if (!empty($item->subThumb))
                            $sub_img   .= '<img class="thumbnail" src="' . $item->subThumb . '" alt="' . $item->title . '" title="' . $item->title . '"/>';
                    $sub_img   .=   '</a>';
                    $sub_img   .= '</div>';
                }

                // Get title
                if ($showTitleList) {
                    $sub_title  = '<h3 class="zt-title">';
                    $sub_title .=   '<a href="' .$item->link . '">' . $item->title . '</a>';
                    $sub_title .= '</h3>';
                }
                                                    
                // Get intro
                if ($showIntroList && $item->introtext != false) 
                    $sub_intro  = '<div class="zt-introtext">' . $item->introtext . '</div>';                   

                // Get infomation    
                if ($showInfoList && !empty($item->info_format)) 
                    $sub_info = '<div class="zt-newsinfo">' . $item->info_format . '</div>';
                                                    
                // Get second infomation    
                if ($showInfo2List && !empty($item->info2_format)) 
                    $sub_info2 = '<div class="zt-newsinfo2">' . $item->info2_format . '</div>';

                $output .= '<div class="zt-item">';
                    if ($wrapContent) {
                        if (isset($sub_img))
                            $output .=  $sub_img;
                        $output .=  '<div class="zt-content-wrap">';
                    }
                    for ($j=1; $j < 6; $j++) {
                        if (!$wrapContent)
                            if ($image_order == $j) 
                                if (isset($sub_img))
                                    $output .=  $sub_img;

                        if ($title_order == $j) 
                            if (isset($sub_title)) 
                                $output .=  $sub_title;

                        if ($intro_order == $j) 
                            if (isset($sub_intro)) 
                                $output .=  $sub_intro;

                        if ($info_order == $j) 
                            if (isset($sub_info)) 
                                $output .=  $sub_info;

                        if ($info2_order == $j) 
                            if (isset($sub_info2)) 
                                $output .=  $sub_info2;      
                    }
                    if ($wrapContent)
                        $output .=  '</div> <!--  End .zt-content-wrap -->';

                $output .= '</div>';
            }

        $output .= '</div>';

    $output .= '</div>';
}

$output .=  '</div>';
$output .= '</div>';
        
echo $output;