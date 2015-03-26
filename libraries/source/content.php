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

if (!class_exists('ZtNewsSourceContent'))
{

    /**
     * Joomla content source
     */
    class ZtNewsSourceContent extends ZtNewsSourceAbstract
    {

        protected $_source = 'content';
        protected $_table_items = '#__content';
        protected $_table_categories = '#__categories';

        /**
         * 
         * @param object $item
         * @return object
         */
        protected function _prepareItem($item)
        {
            $item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
            $item->introtext = JHtml::_('string.truncate', $item->introtext, $this->_params->get('intro_length', 200));
            return $item;
        }

        /**
         * 
         * @param object $item
         * @return object
         */
        protected function _prepareItemImages($item)
        {
            $images = json_decode($item->images);
            if ($images)
            {
                if ($images->image_intro)
                {
                    $item->thumb = JURI::root() . $images->image_intro;
                } else if ($images->image_fulltext)
                {
                    $item->thumb = JURI::root() . $images->image_fulltext;
                } else
                {
//                        if ($this->checkImage($item->introtext))
//                        {
//                            $items[$i]->thumb = $this->getThumb($item->introtext);
//                        }
                }
            }
            return $item;
        }

    }

}