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

if (!class_exists('ZtNewsSourceK2'))
{

    /**
     * Joomla content source
     */
    class ZtNewsSourceK2 extends ZtNewsSourceAbstract
    {

        protected $_source = 'k2';
        protected $_table_items = '#__k2_items';
        protected $_table_categories = '#__k2_categories';

        /**
         * Prepare item properties
         */
        protected function _prepareItem($item)
        {
            $k2CateDetail = $this->getK2CategoryDetail($item->catid);
            $item->link = JRoute::_(K2HelperRoute::getItemRoute($item->id, $item->catid));
            $item->introtext = JHtml::_('string.truncate', $item->introtext, $this->_params->get('intro_length', 200));
            $item->cat_link = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($k2CateDetail->id . ':' . urlencode($k2CateDetail->alias))));
            return $item;
        }

        /**
         * Prepare images for item
         */
        protected function _prepareItemImages($item)
        {

            return $item;
        }

        protected function getK2CategoryDetail($catId)
        {
            $db = JFactory::getDBO();
            $sql = "SELECT c.id,c.name,c.alias
				FROM #__k2_categories AS c " .
                " WHERE c.published = 1 AND c.id =" . $catId .
                " ORDER BY c.name ASC";
            $db->setQuery($sql);
            $results = $db->loadObject();
            return $results;
        }

        /**
         * Recursive to get all children categories of k2 component
         */
        protected function getK2CategoryChilds($catid)
        {
            $cateArray = array();

            $catid = (int)$catid;
            $db = JFactory::getDBO();
            $query = "SELECT * FROM #__k2_categories WHERE parent=" . $catid . " AND published=1 ORDER BY id";
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            foreach ($rows as $row) {
                array_push($cateArray, $row->id);
                if ($this->hasK2CategoryChilds($row->id)) {
                    $this->getK2CategoryChilds($row->id);
                }
            }
            return $cateArray;
        }

        protected function hasK2CategoryChilds($id)
        {
            $id = (int)$id;
            $db = JFactory::getDBO();
            $query = "SELECT * FROM #__k2_categories WHERE parent={$id} AND published=1";
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