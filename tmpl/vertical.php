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

?>
<div id="zt-verticle" class="wrapper">
    <?php foreach ($list as $key => $slide) : ?>    
        <div class="item">
            <?php 
            $listItems = array_slice($slide, $numberIntroItems);
            ?>
              
            <div class="zt-category verticle">
                <div class="row">
                    <?php $index = 0; ?>
                    <?php foreach ($slide as $key => $item) : ?>         
                        <?php if ($index < $numberIntroItems) : ?>
                            <div class="col-sm-6 zt-item main">

                            <?php for ($j=0; $j < 6; $j++) : ?>
                            
                                <?php if ($image_order == $j) : ?>
                                    <?php if($isImage):?>
                                    <!-- Head Thumbnail -->
                                    <div class="post-thumnail">
                                        <a href="<?php echo $item->link; ?>" title="">
                                            <?php if (!empty($item->thumb)) : ?>
                                                <img class="thumbnail" 
                                                     src="<?php echo $item->thumb; ?>" 
                                                     alt="<?php echo $item->title; ?>"
                                                     title="<?php echo $item->title; ?>"
                                                     />
                                                 <?php endif; ?>

                                        </a>
                                    </div>
                                    <?php endif;?>
                                <?php endif ?>

                                <?php if ($image_order == $j) : ?>

                                    <?php if ($showTitle) : ?>
                                        <!-- Item title -->
                                        <h3 class="zt-title">
                                            <a href="<?php echo $item->link; ?>" title="">
                                                <?php echo $item->title; ?>
                                            </a>
                                        </h3>
                                    <?php endif; ?>

                                <?php endif ?>

                                <?php if ($intro_order == $j) : ?>
                                    <?php if ($showIntro && $item->introtext != false) : ?>
                                        <!-- Intro text -->
                                        <div class="zt-introtext"><?php echo ($item->introtext); ?></div>
                                        <?php if ($showReadmore) : ?>                     
                                            <!-- Readmore -->
                                            <p class="zt-news-readmore">
                                                <a class="readmore" href="<?php echo $item->link; ?>"><?php echo JTEXT::_('MOD_ZTNEWS_READMORE'); ?></a>
                                            </p>
                                        <?php endif; ?>
                                    <?php endif; ?> 
                                <?php endif ?>

                                <?php if ($info_order == $j) : ?>
                                    <?php if ($showInfo && !empty($item->info_format)) : ?>
                                        <!-- Information -->
                                        <div class="zt-newsinfo"><?php echo ($item->info_format); ?></div>
                                    <?php endif; ?> 
                                <?php endif ?>

                                <?php if ($info2_order == $j) : ?>
                                    <?php if ($showInfo2 && !empty($item->info2_format)) : ?>
                                        <!-- Information 2 -->
                                        <div class="zt-newsinfo2"><?php echo ($item->info2_format); ?></div>
                                    <?php endif; ?> 
                                <?php endif ?>

                            <?php endfor ?>

                            </div>
                        <?php endif; ?>      
                        <?php $index++; ?>
                    <?php endforeach; ?>

                    <div class="col-sm-6 zt-list-items">
                        <?php foreach ($listItems as $key => $item) : ?>
                            <div class="zt-item">
                                <?php for ($j=0; $j < 6; $j++) : ?>
                            
                                    <?php if ($image_order == $j) : ?>
                                    <div class="post-thumnail">                      
                                        <a href="<?php echo $item->link; ?>" title="">
                                            <?php if (!empty($item->subThumb)) : ?>
                                                <!-- List thumbnail -->
                                                <img class="thumbnail" 
                                                     src="<?php echo $item->subThumb; ?>" 
                                                     alt="<?php echo $item->title; ?>"
                                                     title="<?php echo $item->title; ?>"
                                                     />
                                                 <?php endif; ?>
                                        </a>
                                    </div>

                                    <?php endif ?>

                                    <?php if ($title_order == $j) : ?>
                                        <?php if ($showTitle) : ?>
                                            <!-- Item title -->
                                            <h4 class="zt-title">
                                                <a href="<?php echo $item->link; ?>" title="">
                                                    <?php echo $item->title; ?>
                                                </a>
                                            </h4>
                                        <?php endif; ?>
                                    <?php endif ?>

                                    <?php if ($intro_order == $j) : ?>
                                        <?php if ($showIntro && $item->introtext != false) : ?>
                                            <!-- Intro text -->
                                            <div class="zt-introtext"><?php echo ($item->introtext); ?></div>
                                            <?php if ($showReadmore) : ?>                     
                                                <!-- Readmore -->
                                                <p class="zt-news-readmore">
                                                    <a class="readmore" href="<?php echo $item->link; ?>"><?php echo JTEXT::_('MOD_ZTNEWS_READMORE'); ?></a>
                                                </p>
                                            <?php endif; ?>
                                        <?php endif; ?> 
                                    <?php endif ?>

                                    <?php if ($info_order == $j) : ?>
                                        <?php if ($showInfo && !empty($item->info_format)) : ?>
                                            <!-- Information -->
                                            <div class="zt-newsinfo"><?php echo ($item->info_format); ?></div>
                                        <?php endif; ?> 
                                    <?php endif ?>

                                    <?php if ($info2_order == $j) : ?>
                                        <?php if ($showInfo2 && !empty($item->info2_format)) : ?>
                                            <!-- Information 2 -->
                                            <div class="zt-newsinfo2"><?php echo ($item->info2_format); ?></div>
                                        <?php endif; ?> 
                                    <?php endif ?>

                                <?php endfor ?>    
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>
    <?php endforeach; ?>               
</div>