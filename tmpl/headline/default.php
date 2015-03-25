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
$doc->addStyleSheet(JUri::root() . 'modules/mod_zt_news/assets/css/default.css');
$doc->addStyleSheet(JUri::root() . 'modules/mod_zt_news/assets/css/headline.css');
$columns = ($params->get('columns', 2) > count($listCategories)) ? count($listCategories) : $params->get('columns', 2);
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
switch ($columns)
{
    case '1':
        $width = '100';
        break;
    case '2':
        $width = '49';
        break;
    case '3':
        $width = '32.9';
        break;
    case '4':
        $width = '24.5';
        break;
    case '5':
        $width = '19.5';
        break;
    default:
        $width = '49';
}

$number = (int) $params->get('no_intro_items') + (int) $params->get('no_link_items');
$products = $ztNews->getProducts($listCategories);

$items = array_slice($products, 0, $number);
$items = array_values($items);


?>

<div class="zt_news_wrap 12"> 
    <div class="zt-frame-cat">

            <div class="zt-category headline">
                <!--Title Block-->
               
                <!--Lead block-->
                <div class="row-fluid">
                    <div class="news_lead row">
                        <?php

                        $lead = (count($items) <= $lead) ? count($items) : $lead;

                        foreach($items as$key => $item) :
                            ?>
                            <div class="zt-article-items col-md-6">
                                <?php
                                echo $ztNews->getCategory($item[1] ,$source);
                                if (@$item[0]->thumb != '' && $params->get('is_image', 1) == 1)
                                {
                                    ?>
                                    <?php 
                                    if($key == 0) {
                                        $thumbUrl = modZTNewsHelper::getThumbnailLink($item[0]->thumb, $thumbmainwidth, $thumbmainheight);     
                                    }else {
                                        $thumbUrl = modZTNewsHelper::getThumbnailLink($item[0]->thumb, $thumblistwidth, $thumblistheight);     
                                    }
                                    
                                    ?>
                                    <a href="<?php echo $item[0]->link; ?>" title="<?php echo $item[0]->title; ?>" class="thurnail-image">
                                        <img class="thumbnail <?php if($key == 0) echo 'main-item'; ?>" src="<?php echo $thumbUrl; ?>" alt="<?php echo $item[0]->title; ?>"
                                             title="<?php echo $item[0]->title; ?>"/>
                                    </a>
                                <?php } ?>
                                <div class="zt-article_content">
                                    <?php
                                    if ($showtitle)
                                    {
                                        ?>
                                        <h3>
                                            <a href="<?php echo $item[0]->link; ?>" title="<?php echo $item[0]->title; ?>">
                                                <?php echo $item[0]->title; ?>
                                            </a>
                                        </h3>
                                    <?php } ?>
                                    <?php
                                    if ($created)
                                    {
                                        ?>
                                        <span class="created"><?php echo JHTML::_('date', $item[0]->created, JText::_('DATE_FORMAT_LC3')); ?> - <?php
                                            echo $item[0]->hits;
                                            echo JText::_(' Views');
                                            ?></span>
                                    <?php } ?>
                                    <?php
                                    if ($showintro)
                                    {
                                        ?>
                                        <?php
                                        if ($item[0]->introtext != false)
                                        {
                                            ?>
                                            <p class="zt-introtext"><?php echo ($item[0]->introtext); ?></p>
                                        <?php } ?>
                                    <?php } ?> 
                                    <?php
                                    if ($params->get('show_readmore') == 1)
                                    {
                                        ?>
                                        <p class="zt-news-readmore">
                                            <a class="readmore" href="<?php echo $item[0]->link; ?>"><?php echo JTEXT::_('READ MORE'); ?></a>
                                        </p>
                                    <?php } ?>
                                </div>
                            </div>
                      <?php endforeach; ?>
                    </div>
                </div>
            </div>
    </div>   
    <div class="clearfix"></div>
</div>