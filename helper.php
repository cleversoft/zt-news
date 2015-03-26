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

// com_content route
if (is_file(JPATH_SITE . '/components/com_content/helpers/route.php'))
{
    require_once(JPATH_SITE . '/components/com_content/helpers/route.php');
}
// k2 route
if (is_file(JPATH_SITE . '/components/com_k2/helpers/route.php'))
{
    require_once(JPATH_SITE . '/components/com_k2/helpers/route.php');
}

class modZTNewsHelper
{

    public $params = array();
    public $source = NULL;
    public $image = NULL;
    public $k2 = false;

    public function __construct($params)
    {

        $this->params = $params;
        $this->source = $params->get('source', 'category');
        if (is_file(JPATH_SITE . 'components/com_k2/k2.php'))
        {
            $this->k2 = true;
            $this->image = $params->get('type_image', 'upload');
        }
    }

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
    public static function getItems($params)
    {
        return self::getSource($params)->getItems();
    }

    public function getThumb($text)
    {
        global $moduleId;
        preg_match('/<img(.*?)src="(.*?)"(.*?)>/', $text, $matches);
        $paths = array();
        $thumb_url = '';
        if (isset($matches[2]))
        {
            $image_path = $matches[2];
            $isInternalLink = $this->isInternalLink($image_path);
            if (!$isInternalLink)
            {
                $thumb_url .= $image_path;
            } else
            {
                $thumb_url .= JURI::root() . $image_path;
            }
            return($thumb_url);
        } else
        {
            return false;
        }
    }

    public static function getThumbnailLink($src, $width, $height, $method = 'resize')
    {
        $src = JPATH_ROOT . '/' . $src;
        if (JFile::exists($src))
        {
            require_once __DIR__ . '/lib/imager.php';
            require_once __DIR__ . '/lib/imager/abstract.php';
            require_once __DIR__ . '/lib/imager/gd.php';
            require_once __DIR__ . '/lib/imager/sizer.php';

            $ext = JFile::getExt($src);
            $cacheFile = JPATH_ROOT . '/cache/' . md5($src) . '.' . $ext;

            if (!JFile::exists($cacheFile))
            {
                $imager = new ZtNewsImager('gd');
                $imager->loadFile($src);
                $imager->$method($width, $height);
                if ($imager->saveToFile($cacheFile))
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

    public function isInternalLink($image_path)
    {
        $full_url = JURI::base();
        //remove any protocol/site info from the image path
        $parsed_url = parse_url($full_url);
        $paths[] = $full_url;
        if (isset($parsed_url['path']) && $parsed_url['path'] != "/")
            $paths[] = $parsed_url['path'];
        foreach ($paths as $path)
        {
            if (strpos($image_path, $path) !== false)
            {
                $image_path = substr($image_path, strpos($image_path, $path) + strlen($path));
            }
        }
        // remove any / that begins the path
        if (substr($image_path, 0, 1) == '/')
            $image_path = substr($image_path, 1);
        //if after removing the uri, still has protocol then the image
        //is remote and we don't support thumbs for external images
        if (strpos($image_path, 'http://') !== false || strpos($image_path, 'https://') !== false)
        {
            return false;
        }
        return true;
    }

    public static function checkImage($file)
    {
        preg_match("/\<img.+?src=\"(.+?)\".+?\/>/", $file, $matches);

        if (count($matches))
        {
            return $matches[1];
        } else
        {
            return '';
        }
    }

}