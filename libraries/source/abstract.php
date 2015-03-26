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

if (!class_exists('ZtNewsSourceAbstract')) {

    abstract class ZtNewsSourceAbstract
    {

        /**
         * Source name
         * @var string
         */
        protected $_source = 'content';

        /**
         * Plugin params
         * @var JRegistry
         */
        protected $_params;

        /**
         * Items table name
         * @var string
         */
        protected $_table_items = '#__content';

        /**
         * Categories table name
         * @var string
         */
        protected $_table_categories = '#__categories';

        public function __construct($params)
        {
            $this->_params = $params;
        }

        /**
         * Get array of request categories
         * @return array
         */
        public function getCategories()
        {
            $categories = $this->_params->get($this->_source . '_cids');
            if ($this->_params->get('get_children')) {
                return $this->getChildrenCategories();
            } else {
                return $categories;
            }
            /**
             *
             * @todo Get children categories if needed
             */
        }

        /**
         * Recursive to get all children categories
         */
        public function getChildrenCategories()
        {
            $cids = $this->_params->get($this->_source . '_cids');
            $lists = $cids;
            if (count($cids)) {
                foreach ($cids as $cid) {

                    $functionName = 'get'.ucfirst($this->_source).'CategoryChilds';

                    $categories = call_user_func(array($this, $functionName));

                    JArrayHelper::toInteger($categories);

                    $lists = array_merge($lists, array_unique($categories));
                }
            }
            return $lists;
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

        /**
         * Get items in categories
         * @return type
         */
        public function getItems()
        {
            $categories = $this->getCategories();

            $db = JFactory::getDbo();
            $date = JFactory::getDate();
            $now = $date->toSQL();
            $nullDate = $db->getNullDate();
            $user = JFactory::getUser();
            $userId = (int)$user->get('id');

            // Base WHERE
            $where = 'a.state = 1'
                . ' AND(a.publish_up = ' . $db->Quote($nullDate) . ' OR a.publish_up <= ' . $db->Quote($now) . ')'
                . ' AND(a.publish_down = ' . $db->Quote($nullDate) . ' OR a.publish_down >= ' . $db->Quote($now) . ')';
            // Filter by categories
            $where .= ' AND ' . $db->quoteName('a') . '.' . $db->quoteName('catid') . ' IN ' . ' ( ' . implode(',', $categories) . ' ) ';
            // User Filter
            switch ($this->_params->get('user_id')) {
                case 'by_me':
                    $where .= ' AND ( ' . $db->quoteName('created_by') . ' = ' . (int)$userId . ' OR ' . $db->quoteName('modified_by') . ' = ' . (int)$userId . ')';
                    break;
                case 'not_me':
                    $where .= ' AND ( ' . $db->quoteName('created_by') . ' <> ' . (int)$userId . ' AND ' . $db->quoteName('modified_by') . ' <> ' . (int)$userId . ')';
                    break;
            }
            // Ordering
            switch ($this->_params->get('rderingkcontent')) {
                case 'date':
                    $orderby = 'a.created ASC';
                    break;
                case 'rdate':
                    $orderby = 'a.created DESC';
                    break;
                case 'alpha':
                    $orderby = 'a.title';
                    break;
                case 'ralpha':
                    $orderby = 'a.title DESC';
                    break;
                case 'order':
                    $orderby = 'a.ordering';
                    break;
                case 'rorder':
                    $orderby = 'a.ordering DESC';
                    break;
                case 'hits':
                    $orderby = 'a.hits DESC';
                    break;
                case 'rand':
                    $orderby = 'RAND()';
                    break;
                case 'modified':
                    $orderby = 'a.modified DESC';
                    break;
                default:
                    $orderby = 'a.id DESC';
                    break;
            }
            $query = ' SELECT a.*, cc.title as cat_title,' .
                ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,' .
                ' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug' .
                ' FROM ' . $this->_table_items . ' AS a' .
                ' INNER JOIN ' . $this->_table_categories . ' AS cc ON cc.id = a.catid' .
                ' WHERE ' . $where . '' .
                ' AND cc.published = 1' .
                ' ORDER BY ' . $orderby;


            $db->setQuery($query);
            $list = $db->loadObjectList();
            return $this->_prepareItems($list);
        }

        /**
         *
         * @param array $list
         * @return array
         */
        protected function _prepareItems($list)
        {
            $items = array();
            foreach ($list as $index => $item) {
                $item = $this->_prepareItem($item);
                $item = $this->_prepareItemImages($item);
                $items[$index] = $item;
            }
            return $items;
        }

        /**
         * Prepare item properties
         */
        abstract protected function _prepareItem($item);

        /**
         * Prepare images for item
         */
        abstract protected function _prepareItemImages($item);
    }

}