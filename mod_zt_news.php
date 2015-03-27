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

// Rerequire bootstrap file for init
require_once(dirname(__FILE__) . '/bootstrap.php');
// Variables
$showTitle = $params->get('show_title', 1);
$showCreated = $params->get('show_date', 1);
$showIntro = $params->get('show_intro', 1);
$showReadmore = $params->get('show_readmore', 0);
$showIntroList = $params->get('show_intro_list', 1);
$source = $params->get('source');
$numberIntroItems = (int) $params->get('number_intro_items', 1);
$numberLinkItems = $params->get('number_link_items', 4);
$thumbMainWidth = $params->get('thumb_main_width');
$thumbMainHeight = $params->get('thumb_main_height');
$thumbListWidth = $params->get('thumb_list_width');
$thumbListHeight = $params->get('thumb_list_height');
$showTitleCategory = $params->get('showtitlecat', 1);
$showCreatedOnList = $params->get('show_date_list', 1);
$showTitleOnList = $params->get('show_title_list', 1);
$showImageOnList = $params->get('is_image_list', 1);
$showSubCategory = $params->get('is_subcat', 1);
$breakpoint = $params->get('breakpoint');

// Get items
$items = modZTNewsHelper::getItems($params);

// Get Category
$listCategories = modZTNewsHelper::getCategories($params);

// Get column and width
$columns = ($params->get('columns', 2) > count($listCategories)) ? count($listCategories) : $params->get('columns', 2);
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

// Render
$templateType = $params->get('template_type');
require(JModuleHelper::getLayoutPath('mod_zt_news', $templateType . '/default'));
