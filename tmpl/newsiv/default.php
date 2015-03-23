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
?>
<div style="display: none;"><a href="http://www.joomvision.com" title="Joomla Templates">Joomla Templates</a> and Joomla Extensions by JoomVision.Com</div>
<div class="zt_news_wrap"> 
    <div class="zt-newsiv-frame-cat">
        <?php
        for ($i = 0; $i < count($listCategories); $i++)
        {
            ?>
            <?php $catids = $listCategories[$i]; ?>
            <?php
            if (($i + 1) % 2)
            {
                ?>
                <div class="zt-category-even" style="width: <?php echo $width; ?>%">
                    <?php
                } else
                {
                    ?>
                    <div class="zt-category" style="width: <?php echo $width; ?>%">
                    <?php } ?>
                    <!--Title Block-->
                    <?php
                    if ($showtitlecat)
                    {
                        ?>
                        <div class="title_cat clearfix">
                            <?php
                            for ($j = 0; $j < count($catids); $j++)
                            {
                                if ($source == 'category')
                                {
                                    $catdetail = $ztNews->getCategoryDetail($catids[$j]);
                                    $link = JRoute::_(ContentHelperRoute::getCategoryRoute($catids[$j]));
                                    $title = $catdetail->title;
                                } else
                                {
                                    $catdetail = $ztNews->getK2CategoryDetail($catids[$j]);
                                    $link = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($catdetail->id . ':' . urlencode($catdetail->alias))));
                                    $title = $catdetail->name;
                                }
                                if ($j == 0)
                                {
                                    ?>
                                    <h2 class="title"><a href="<?php echo $link; ?>" alt="<?php echo $title; ?>"><?php echo $title; ?></a></h2>
                                    <?php
                                    break;
                                }
                                ?>
                            <?php } ?> 
						</div>
                        <?php } ?>
                        <?php
                        if ($showsubcat)
                        {
                            ?>
                            <ul> 
                                <?php
                                for ($j = 0; $j < count($catids); $j++)
                                {
                                    if ($source == 'category')
                                    {
                                        $catdetail = $ztNews->getCategoryDetail($catids[$j]);
                                        $link = JRoute::_(ContentHelperRoute::getCategoryRoute($catids[$j]));
                                        $title = $catdetail->title;
                                    } else
                                    {
                                        $catdetail = $ztNews->getK2CategoryDetail($catids[$j]);
                                        $link = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($catdetail->id . ':' . urlencode($catdetail->alias))));
                                        $title = $catdetail->name;
                                    }
                                    ?>
                                    <?php
                                    if ($j != 0)
                                    {
                                        ?>
                                        <li>
                                            <div class="zt-title-category"> 
                                                <h3><span><a href="<?php echo $link; ?>" alt="<?php echo $title; ?>"><?php echo $title; ?></a></span></h3>
                                            </div>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                    <!--Lead block-->
                    <div class="row-fluid">
                        <div class="news_lead">
                            <?php
                            $listItems = $ztNews->getItemsByCatId($catids[0]);
                            $lead = (count($listItems) <= $lead) ? count($listItems) : $lead;
                            for ($j = 0; $j < $lead; $j++) :
                                ?>
                                <div class="zt-article-item">
									<div class="image">
										<?php
										if (@$listItems[$j]->thumb != '' && $params->get('is_image', 1) == 1)
										{
											?>
											<?php $thumbUrl = modZTNewsHelper::getThumbnailLink($listItems[$j]->thumb, $thumbmainwidth, $thumbmainheight); ?>
											<a href="<?php echo $listItems[$j]->link; ?>" title="<?php echo $listItems[$j]->title; ?>">
												<img src="<?php echo $thumbUrl; ?>" alt="<?php echo $listItems[$j]->title; ?>" 
													 title="<?php echo $listItems[$j]->title; ?>"/>
											</a> 
										<?php } ?>
									</div>
									<div class="content">
										<?php
										if ($showtitle)
										{
											?>
											<h3>
												<a href="<?php echo $listItems[$j]->link; ?>" title="<?php echo $listItems[$j]->title; ?>">
													<?php echo $listItems[$j]->title; ?>
												</a>
											</h3>
										<?php } ?>
										<?php
										if ($created)
										{
											?>
											<span class="created"><?php echo JHTML::_('date', $listItems[$j]->created, JText::_('DATE_FORMAT_LC3')); ?> - <?php
												echo $listItems[$j]->hits;
												echo JText::_(' Views');
												?></span>
										<?php } ?>
										<?php
										if ($showintro)
										{
											?>
											<?php
											if ($listItems[$j]->introtext != false)
											{
												?>
												<p class="zt-introtext"><?php echo ($listItems[$j]->introtext); ?></p>
											<?php } ?>
										<?php } ?> 
										<?php
										if ($params->get('show_readmore') == 1)
										{
											?>
											<p class="zt-news-readmore">
												<a class="readmore" href="<?php echo $listItems[$j]->link; ?>"><?php echo JTEXT::_('READ MORE'); ?></a>
											</p>
										<?php } ?>
									</div>
								</div>
                            <?php endfor; ?>
                            <?php
                            if ($lead < count($listItems))
                            {
                                ?> 
                                <div class="article-item">
                                    <?php
                                    for ($j = $lead; $j < count($listItems); $j++)
                                    {
                                        ?>
                                        <div class="more_item <?php
                                        if ($j == $lead)
                                        {
                                            echo 'first-item';
                                        } elseif ($j == (count($listItems) - 1))
                                        {
                                            echo 'last-item';
                                        }
                                        ?>">
                                                 <?php
                                                 if (@$listItems[$j]->thumb != '' && $showimglist)
                                                 {
                                                     ?>
                                                <a class="linkimg" href="<?php echo $listItems[$j]->link; ?>">
                                                    <img src="<?php echo JURI::root() . 'modules/mod_zt_news/timthumb.php?src=' . $listItems[$j]->thumb . '&amp;h=' . $thumblistheight . '&amp;w=' . $thumblistwidth; ?>" alt="<?php echo $listItems[$j]->title; ?>" 
                                                         title="<?php echo $listItems[$j]->title; ?>"/>
                                                </a>
                                            <?php } ?>								
                                            <div class="more_item_thumb">
                                                <?php
                                                if ($showtitlelist)
                                                {
                                                    ?>
                                                    <a href="<?php echo $listItems[$j]->link; ?>"><?php echo $listItems[$j]->title; ?></a>
                                                <?php } ?>
                                                <?php
                                                if ($showintrolist)
                                                {
                                                    ?>
                                                    <p><?php echo substr($listItems[$j]->introtext, 0, 100); ?></p>
                                                <?php } ?>
                                                <?php
                                                if ($createdlist)
                                                {
                                                    ?>
                                                    <p class="more-item-datetime"><?php echo JHTML::_('date', $listItems[$j]->created, JText::_('DATE_FORMAT_LC3')); ?> - <?php
                                                        echo $listItems[$j]->hits;
                                                        echo JText::_(' Views');
                                                        ?></p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
    
        <div class="clearfix"></div>
    </div>