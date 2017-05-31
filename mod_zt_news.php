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

jimport( 'joomla.application.module.helper' );

// Rerequire bootstrap file for init
require_once(dirname(__FILE__) . '/bootstrap.php');

// Variables
$showTitle            = $params->get('show_title', 1);
// $dateFormat           = $params->get('date_format');
$showIntro            = $params->get('show_intro', 1);
$showReadmore         = $params->get('show_readmore', 0);
$showIntroList        = $params->get('show_intro_list', 1);
$numberIntroItems     = (int) $params->get('number_intro_items', 1);
$numberLinkItems      = $params->get('number_link_items', 4);
$thumbMainWidth       = $params->get('thumb_main_width');
$thumbMainHeight      = $params->get('thumb_main_height');
$thumbListWidth       = $params->get('thumb_list_width');
$thumbListHeight      = $params->get('thumb_list_height');
// $showTitleCategory = $params->get('showtitlecat', 1);
// $showCreatedOnList = $params->get('show_date_list', 1);
// $showTitleOnList = $params->get('show_title_list', 1);
$clearCache           = $params->get('clear_cache', 0);
$isImage              = $params->get('is_image', 1);
$showImageOnList      = $params->get('is_image_list', 1);
// $showSubCategory = $params->get('is_subcat', 1);
$breakpoint_md        = $params->get('breakpoint_md', 3);
$breakpoint_sm        = $params->get('breakpoint_sm', 2);
$breakpoint_xs        = $params->get('breakpoint_xs', 1);
$space                = $params->get('space', 15);
$showNav              = $params->get('show_nav', 0);
$showDots             = $params->get('show_dots', 0);
$autoplay             = $params->get('autoplay', 0);
$columns              = $params->get('columns');
$intro_length         = $params->get('intro_length');

$showInfo             = $params->get('show_info', 0);
$showInfo2            = $params->get('show_info2', 0);
$image_order          = $params->get('image_order', 1);
$title_order          = $params->get('title_order', 2);
$intro_order           = $params->get('intro_order', 3);
$info_order           = $params->get('info_order', 4);
$info2_order          = $params->get('info2_order', 5);

// Source
$source = $params->get('source');

// Render
$templateType = $params->get('layout');

// Get items
$items = modZTNewsHelper::getItems($params);

// Should we also cache rendered layout

require JModuleHelper::getLayoutPath('mod_zt_news', $params->get('layout', 'headline'));