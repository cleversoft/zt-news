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
            $item->cat_link = JRoute::_(ContentHelperRoute::getCategoryRoute($item->catid));
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
            $item->thumb = '';
            $item->subThumb = '';
            if ($images)
            {
                if ($images->image_intro)
                {
                    $item->thumb = modZTNewsHelper::getThumbnailLink($images->image_intro, $this->params->get('thumb_main_width'), $this->params->get('thumb_main_height'));
                    $item->subThumb = modZTNewsHelper::getThumbnailLink($images->image_intro, $this->params->get('thumb_list_width'), $this->params->get('thumb_list_height'));
                } else if ($images->image_fulltext)
                {
                    $item->thumb = modZTNewsHelper::getThumbnailLink($images->image_fulltext, $this->params->get('thumb_main_width'), $this->params->get('thumb_main_height'));
                    $item->subThumb = modZTNewsHelper::getThumbnailLink($images->image_fulltext, $this->params->get('thumb_list_width'), $this->params->get('thumb_list_height'));
                }
            }
            return $item;
        }

        /**
         * Recursive to get all children categories of joomla article
         */
        public function getContentCategoryChilds($catid)
        {
            $cateArray = array();

            $catid = (int)$catid;
            $db = JFactory::getDBO();
            $query = "SELECT * FROM #__categories WHERE parent_id=" . $catid . " AND published=1 ORDER BY id";

            $db->setQuery($query);
            $rows = $db->loadObjectList();

            foreach ($rows as $row) {
                array_push($cateArray, $row->id);
                if ($this->hasContentCategoryChilds($row->id)) {
                    $this->getContentCategoryChilds($row->id);
                }
            }
            return $cateArray;
        }

        protected function hasContentCategoryChilds($id)
        {
            $db = JFactory::getDBO();
            $query = "SELECT * FROM #__categories WHERE parent_id={$id} AND published=1";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            if (count($rows)) {
                return true;
            } else {
                return false;
            }
        }

    }

}