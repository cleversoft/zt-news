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

require_once(dirname(__FILE__) . '/helper.php');
global $moduleId;
$moduleId = $module->id;
$categories = (array) $params->get('content_cids', array());
$k2categories = (array) $params->get('k2_cids', array());
$templateType = $params->get('template_type', 'default');
$ztNews = new modZTNewsHelper($params);
if (count($categories) || count($k2categories))
{
    $listCategories = $ztNews->getAllCategories();
    $imgAlign = $params->get('img_align');
    require(JModuleHelper::getLayoutPath('mod_zt_news', 'headline' . '/default'));
} 