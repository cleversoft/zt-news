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
$doc->addStyleSheet(JUri::root() . 'modules/mod_zt_news/assets/css/pnewsiv.css');

// Get items
$groupItems = modZTNewsHelper::getItems($params, true);

$columns = ($params->get('columns', 2) > count($groupItems)) ? count($groupItems) : $params->get('columns', 2);
switch ($columns) {
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


?>
<div class="zt_news_wrap">
    <div class="zt-newsiv-frame-cat">
        <?php foreach ($groupItems as $key => $items): ?>
        <div class="zt-category-even" style="width: <?php echo $width; ?>%">
            <!--Title Block-->
            <?php if ($showTitleCategory): ?>
                <div class="title_cat clearfix">
                    <h2 class="title">
                        <a href="<?php echo $items['category']->link; ?>" alt="<?php echo $items['category']->title; ?>"><?php echo $items['category']->title; ?></a>
                    </h2>
                </div>
            <?php endif; ?>
        </div>
        <!--Lead block-->
        <div class="row-fluid">
            <div class="news_lead">
                <?php
                $numberIntroItems = (count($items) <= $numberIntroItems) ? count($items) : $numberIntroItems;
                foreach ($items['items'] as $item) :
                    ?>
                    <div class="zt-article-item">
                        <div class="image">
                            <?php
                            if (@$item->thumb != '' && $params->get('is_image', 1) == 1): ?>

                                <a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>">
                                    <img src="<?php echo $item->thumb; ?>" alt="<?php echo $item->title; ?>"
                                         title="<?php echo $item->title; ?>"/>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="content">
                            <?php if ($showTitle): ?>
                                <h3>
                                    <a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>">
                                        <?php echo $item->title; ?>
                                    </a>
                                </h3>
                            <?php endif; ?>
                            <?php if ($showCreated): ?>
                                <span
                                    class="created"><?php echo JHTML::_('date', $item->created, JText::_('DATE_FORMAT_LC3')); ?>
                                    - <?php
                                    echo $item->hits;
                                    echo JText::_(' Views');
                                    ?></span>
                            <?php endif; ?>
                            <?php if ($showIntro): ?>
                                <?php if ($item->introtext != false): ?>
                                    <p class="zt-introtext"><?php echo($item->introtext); ?></p>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if ($params->get('show_readmore') == 1): ?>
                                <p class="zt-news-readmore">
                                    <a class="readmore"
                                       href="<?php echo $item->link; ?>"><?php echo JTEXT::_('READ MORE'); ?></a>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if ($numberIntroItems < count($items)): ?>
                    <div class="article-item">
                        <?php foreach ($items['items'] as $item): ?>
                            <div class="more_item <?php
                            if ($j == $numberIntroItems):
                                echo 'first-item';
                            elseif ($j == (count($items) - 1)):
                                echo 'last-item';
                            endif;
                            ?>">
                                <?php if (@$item->thumb != '' && $showImageOnList): ?>
                                    <a class="linkimg" href="<?php echo $item->link; ?>">
                                        <img src="<?php echo $item->thumb; ?>" alt="<?php echo $item->title; ?>"
                                             title="<?php echo $item->title; ?>"/>
                                    </a>
                                <?php endif; ?>
                                <div class="more_item_thumb">
                                    <?php if ($showTitleOnList): ?>
                                        <a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a>
                                    <?php endif; ?>
                                    <?php if ($showIntroList): ?>
                                        <p><?php echo substr($item->introtext, 0, 100); ?></p>
                                    <?php endif; ?>
                                    <?php if ($showCreatedOnList): ?>
                                        <p class="more-item-datetime"><?php echo JHTML::_('date', $item->created, JText::_('DATE_FORMAT_LC3')); ?>
                                            - <?php
                                            echo $item->hits;
                                            echo JText::_(' Views');
                                            ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <div class="clearfix"></div>
</div>