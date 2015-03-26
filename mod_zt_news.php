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
// Get items
$items = modZTNewsHelper::getItems($params);
// Render
require(JModuleHelper::getLayoutPath('mod_zt_news', 'headline' . '/default'));
