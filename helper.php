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

if (!class_exists('modZTNewsHelper'))
{

    /**
     * Main helper class 
     */
    class modZTNewsHelper
    {

        /**
         * Get source object class
         * @staticvar className $sources
         * @param type $params
         * @return \className
         */
        public static function getSource($params)
        {
            static $sources;
            if (!isset($sources[$params->get('source')]))
            {
                $className = 'ZtNewsSource' . ucfirst($params->get('source'));
                $sources[$params->get('source')] = new $className($params);
            }
            return $sources[$params->get('source')];
        }

        /**
         * Get all items
         * @param type $params
         * @return type
         */
        public static function getItems($params, $groupByCategories = false)
        {
            return self::getSource($params)->getItems($groupByCategories);
        }

        /**
         * Get all Category
         * @param type $params
         * @return type
         */
        public static function getCategories($params)
        {
            return self::getSource($params)->getCategories();
        }

        public static function getThumbnailLink($src, $width, $height, $params)
        {
            $src = JPATH_ROOT . '/' . $src;
            if (JFile::exists($src))
            {
                require_once __DIR__ . '/libraries/imager.php';
                require_once __DIR__ . '/libraries/imager/abstract.php';
                require_once __DIR__ . '/libraries/imager/gd.php';
                require_once __DIR__ . '/libraries/imager/sizer.php';

                $ext = JFile::getExt($src);
                $cacheFile = JPATH_ROOT . '/cache/' . $width . '_' . $height . '_' . md5($src) . '.' . $ext;

                if (!JFile::exists($cacheFile))
                {
                    $imager = new ZtNewsImager('gd');
                    $imager->loadFile($src);
                    $method = $params->get('thumbnail_method', 'resize');
                    if ($method == 'crop')
                    {
                        $imager->crop($width, $height, array('position' => $params->get('thumbnail_crop_position', 'center')));
                    } else
                    {
                        $imager->$method($width, $height);
                    }

                    if ($imager->saveToFile($cacheFile, null, $params->get('thumbnail_quality', 100)))
                    {
                        return str_replace(JPATH_ROOT, rtrim(JUri::root(), '/'), $cacheFile);
                    }
                } else
                {
                    return str_replace(JPATH_ROOT, rtrim(JUri::root(), '/'), $cacheFile);
                }
            }
            return $src;
        }

    }

}
