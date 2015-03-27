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
?>
<div class="zt_news_wrap"> 
    <div class="zt-frame-cat">
        <?php for ($i = 0; $i < count($listCategories); $i++): ?>
            <?php $catids = $listCategories[$i]; ?>
            <div class="zt-category" style="width: <?php echo $width; ?>%">
                <!--Title Block-->
                <?php if ($showTitleCategory): ?>
                    <div class="title_cat clearfix">
                        <?php
                        for ($j = 0; $j < count($catids); $j++):
                            if ($source == 'content'):
                                $catdetail = $ztNews->getCategoryDetail($catids[$j]);
                                $link = JRoute::_(ContentHelperRoute::getCategoryRoute($catids[$j]));
                                $title = $catdetail->title;
                            else:
                                $catdetail = $ztNews->getK2CategoryDetail($catids[$j]);
                                $link = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($catdetail->id . ':' . urlencode($catdetail->alias))));
                                $title = $catdetail->name;
                            endif;
                            if ($j == 0):
                                ?>
                                <h2 class="title"><a href="<?php echo $link; ?>" alt="<?php echo $title; ?>"><?php echo $title; ?></a></h2>
                                <?php
                                break;
                                endif;
                            ?>
                        <?php endfor; ?> 
                    </div>
                    <?php endif; ?>
                    <?php if ($showSubCategory): ?>
                        <ul> 
                            <?php for ($j = 0; $j < count($catids); $j++):
                                if ($source == 'content'):
                                    $catdetail = $ztNews->getCategoryDetail($catids[$j]);
                                    $link = JRoute::_(ContentHelperRoute::getCategoryRoute($catids[$j]));
                                    $title = $catdetail->title;
                                else:
                                    $catdetail = $ztNews->getK2CategoryDetail($catids[$j]);
                                    $link = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($catdetail->id . ':' . urlencode($catdetail->alias))));
                                    $title = $catdetail->name;
                                endif;
                                ?>
                                <?php if ($j != 0): ?>
                                    <li>
                                        <div class="zt-title-category"> 
                                            <h3><span><a href="<?php echo $link; ?>" alt="<?php echo $title; ?>"><?php echo $title; ?></a></span></h3>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <!--Lead block-->
                <div class="row-fluid">
                    <div class="news_lead">
                        <?php
                        $numberIntroItems = (count($items) <= $numberIntroItems) ? count($items) : $numberIntroItems;
                        for ($j = 0; $j < $numberIntroItems; $j++) :
                            ?>
                            <div class="zt-article-item">
                                <?php if (@$items[$j]->thumb != '' && $params->get('is_image', 1) == 1): ?>
                                    <?php $thumbUrl = modZTNewsHelper::getThumbnailLink($items[$j]->thumb, $thumbMainWidth, $thumbMainHeight); ?>
                                    <a href="<?php echo $items[$j]->link; ?>" title="<?php echo $items[$j]->title; ?>">
                                        <img class="thumbnail" src="<?php echo $thumbUrl; ?>" alt="<?php echo $items[$j]->title; ?>"
                                             title="<?php echo $items[$j]->title; ?>"/>
                                    </a>
                                <?php endif; ?>
                                <?php if ($showTitle): ?>
                                    <h3>
                                        <a href="<?php echo $items[$j]->link; ?>" title="<?php echo $items[$j]->title; ?>">
                                            <?php echo $items[$j]->title; ?>
                                        </a>
                                    </h3>
                                <?php endif; ?>
                                <?php if ($showCreated): ?>
                                    <span class="created"><?php echo JHTML::_('date', $items[$j]->created, JText::_('DATE_FORMAT_LC3')); ?> - <?php
                                        echo $items[$j]->hits;
                                        echo JText::_(' Views');
                                        ?></span>
                                <?php endif; ?>
                                <?php if ($showIntro): ?>
                                    <?php if ($items[$j]->introtext != false): ?>
                                        <p class="zt-introtext"><?php echo ($items[$j]->introtext); ?></p>
                                    <?php endif; ?>
                                <?php endif; ?> 
                                <?php if ($params->get('show_readmore') == 1): ?>
                                    <p class="zt-news-readmore">
                                        <a class="readmore" href="<?php echo $items[$j]->link; ?>"><?php echo JTEXT::_('READ MORE'); ?></a>
                                    </p>
                                <?php endif; ?>
                            </div>
                        <?php endfor; ?>
                        <?php if ($numberIntroItems < count($items)): ?>
                            <div class="article-item">
                                <?php for ($j = $numberIntroItems; $j < count($items); $j++): ?>
                                    <div class="more_item <?php
                                    if ($j == $numberIntroItems):
                                        echo 'first-item';
                                    elseif ($j == (count($items) - 1)):
                                        echo 'last-item';
                                    endif;
                                    ?>">
                                        <?php if (@$items[$j]->thumb != '' && $showImageOnList): ?>
                                            <?php $thumbUrl = modZTNewsHelper::getThumbnailLink($items[$j]->thumb, $thumbListWidth, $thumbListHeight); ?>
                                            <a class="linkimg" href="<?php echo $items[$j]->link; ?>">
                                                <img src="<?php echo $thumbUrl; ?>" alt="<?php echo $items[$j]->title; ?>" 
                                                     title="<?php echo $items[$j]->title; ?>"/>
                                            </a>
                                        <?php endif; ?>								
                                        <div class="more_item_thumb">
                                            <?php if ($showTitleOnList): ?>
                                                <a href="<?php echo $items[$j]->link; ?>"><?php echo $items[$j]->title; ?></a>
                                            <?php endif; ?>
                                            <?php if ($showIntroList): ?>
                                                <p><?php echo substr($items[$j]->introtext, 0, 100); ?></p>
                                            <?php endif; ?>
                                            <?php if ($showCreatedOnList): ?>
                                                <p class="more-item-datetime"><?php echo JHTML::_('date', $items[$j]->created, JText::_('DATE_FORMAT_LC3')); ?> - <?php
                                                    echo $items[$j]->hits;
                                                    echo JText::_(' Views');
                                                    ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
 
    <div class="clearfix"></div>
</div>