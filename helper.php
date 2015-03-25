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

    public function getItemsByCatId($cid)
    {
        //Check source
        if ($this->source == 'k2_category' && $this->k2)
            return $this->getItemsByK2CatId($cid);
        //End

        global $mainframe;
        $db = JFactory::getDBO();
        $user = JFactory::getUser();
        $userId = (int) $user->get('id');
        $count = (int) $this->params->get('no_intro_items') + (int) $this->params->get('no_link_items');
        $intro_lenght = intval($this->params->get('intro_length', 200));
        $nullDate = $db->getNullDate();
        $date = JFactory::getDate();
        $now = $date->toSQL();
        $is_allsub = $this->params->get('is_all');
        $where = 'a.state = 1'
                . ' AND(a.publish_up = ' . $db->Quote($nullDate) . ' OR a.publish_up <= ' . $db->Quote($now) . ')'
                . ' AND(a.publish_down = ' . $db->Quote($nullDate) . ' OR a.publish_down >= ' . $db->Quote($now) . ')'
        ;
        if ($is_allsub && !is_array($cid))
        {
            $categories = $this->getCategoryChilds($cid, true);
            $categories = @array_unique($categories);
            JArrayHelper::toInteger($categories);
            $categories = array_merge((array) $cid, $categories);
            $sql = @implode(',', $categories);
        } else if (is_array($cid))
        {
            $sql = @implode(',', $cid);
        } else
        {
            $sql = $cid;
        }
        $where .= " AND a.catid IN({$sql})";
        //end
        // User Filter
        switch ($this->params->get('user_id'))
        {
            case 'by_me':
                $where .= ' AND(created_by = ' . (int) $userId . ' OR modified_by = ' . (int) $userId . ')';
                break;
            case 'not_me':
                $where .= ' AND(created_by <> ' . (int) $userId . ' AND modified_by <> ' . (int) $userId . ')';
                break;
        }
        // Ordering
        switch ($this->params->get('rderingkcontent'))
        {
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
        // Content Items only
        $query = 'SELECT a.*, cc.title as cat_title,' .
                ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,' .
                ' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug' .
                ' FROM #__content AS a' .
                ' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
                ' WHERE ' . $where . '' .
                ' AND cc.published = 1' .
                ' ORDER BY ' . $orderby;
        $db->setQuery($query, 0, $count);

        $rows = $db->loadObjectList();
        $i = 0;
        $lists = array();
        foreach ($rows as $row)
        {
            $lists[$i] = new stdClass();
            $lists[$i]->title = $row->title;
            $lists[$i]->alias = $row->alias;
            $lists[$i]->hits = $row->hits;
            $lists[$i]->link = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug));
            $lists[$i]->introtext = $this->introContent($row->introtext, $intro_lenght);
            $lists[$i]->created = $row->created;
            $images = json_decode($row->images);
            if ($images)
            {
                if ($images->image_intro)
                {
                    $lists[$i]->thumb = JURI::root() . $images->image_intro;
                } else if ($images->image_fulltext)
                {
                    $lists[$i]->thumb = JURI::root() . $images->image_fulltext;
                } else
                {
                    if ($this->checkImage($row->introtext))
                    {
                        $lists[$i]->thumb = $this->getThumb($row->introtext);
                    }
                }
            }
            $i++;
        }
        return $lists;
    }

    public function getItemsByK2CatId($cid)
    {
        global $mainframe;
        $db = JFactory::getDBO();
        $user = JFactory::getUser();
        $userId = (int) $user->get('id');
        $count = (int) $this->params->get('no_intro_items') + (int) $this->params->get('no_link_items');
        $intro_lenght = intval($this->params->get('intro_length', 200));
        $is_allsub = $this->params->get('is_all');
        $nullDate = $db->getNullDate();
        $date = JFactory::getDate();
        $now = $date->toSql();

        $where = 'a.published = 1'
                . ' AND(a.publish_up = ' . $db->Quote($nullDate) . ' OR a.publish_up <= ' . $db->Quote($now) . ')'
                . ' AND(a.publish_down = ' . $db->Quote($nullDate) . ' OR a.publish_down >= ' . $db->Quote($now) . ')'
        ;
        if ($is_allsub && !is_array($cid))
        {
            $categories = $this->getK2CategoryChilds($cid, true);
            $categories = @array_unique($categories);
            JArrayHelper::toInteger($categories);
            $categories = array_merge((array) $cid, $categories);
            $sql = @implode(',', $categories);
        } else if (is_array($cid))
        {
            $sql = @implode(',', $cid);
        } else
        {
            $sql = $cid;
        }
        $where .= " AND a.catid IN({$sql})";
        //end
        // User Filter
        switch ($this->params->get('user_id'))
        {
            case 'by_me':
                $where .= ' AND(created_by = ' . (int) $userId . ' OR modified_by = ' . (int) $userId . ')';
                break;
            case 'not_me':
                $where .= ' AND(created_by <> ' . (int) $userId . ' AND modified_by <> ' . (int) $userId . ')';
                break;
        }

        // Ordering
        switch ($this->params->get('rderingk2'))
        {
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
            case 'best':
                $orderby = 'rating DESC';
                break;
            case 'comments':
                $orderby = 'numOfComments DESC';
                break;
            case 'modified':
                $orderby = 'a.modified DESC';
                break;
            default:
                $orderby = 'a.id DESC';
                break;
        }
        // Content Items only
        $query = 'SELECT a.*, cc.name as cat_title ' .
                ' FROM #__k2_items AS a' .
                ' INNER JOIN #__k2_categories AS cc ON cc.id = a.catid' .
                ' WHERE ' . $where . '' .
                ' AND cc.published = 1' .
                ' ORDER BY ' . $orderby;
        $db->setQuery($query, 0, $count);

        $rows = $db->loadObjectList();
        $i = 0;
        $data = array();
        foreach ($rows as $row)
        {
            @$data[$i]->title = $row->title;
            $data[$i]->alias = $row->alias;
            $data[$i]->hits = $row->hits;
            $data[$i]->link = JRoute::_(K2HelperRoute::getItemRoute($row->id, $row->catid));
            $data[$i]->introtext = $this->introContent($row->introtext, $intro_lenght);
            $data[$i]->created = $row->created;
            if (JFile::exists(JPATH_SITE . '/media/k2/items/cache' . md5("Image" . $row->id) . '_XL.jpg'))
            {
                $image = 'media/k2/items/cache/' . md5("Image" . $row->id) . '_XL.jpg';

                if ($this->image == 'upload')
                {
                    $row->introtext = '<img src="' . $image . '" />' . $row->introtext;
                } else
                {
                    $row->fulltext = $row->fulltext . '<img src="' . $image . '" />';
                }
            }
            $row->introtext = $row->introtext . $row->fulltext;
            if ($this->checkImage($row->introtext))
            {
                $data[$i]->thumb = $this->getThumb($row->introtext);
            }
            $i++;
        }
        return $data;
    }

    public function getCategoryChilds($catid, $clear = false)
    {
        static $array = array();
        if ($clear)
        {
            $array = array();
        }
        $catid = (int) $catid;
        $db = JFactory::getDBO();
        $query = "SELECT * FROM #__categories WHERE parent_id=" . $catid . " AND published=1 ORDER BY id";

        $db->setQuery($query);
        $rows = $db->loadObjectList();

        foreach ($rows as $row)
        {
            array_push($array, $row->id);
            if (modZTNewsHelper::hasChilds($row->id))
            {
                modZTNewsHelper::getCategoryChilds($row->id);
            }
        }
        return $array;
    }

    public function getK2CategoryChilds($catid, $clear = false)
    {
        static $array = array();
        if ($clear)
        {
            $array = array();
        }
        $catid = (int) $catid;
        $db = JFactory::getDBO();
        $query = "SELECT * FROM #__k2_categories WHERE parent=" . $catid . " AND published=1 ORDER BY id";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        foreach ($rows as $row)
        {
            array_push($array, $row->id);
            if (modZTNewsHelper::k2hasChilds($row->id))
            {
                modZTNewsHelper::getCategoryChilds($row->id);
            }
        }
        return $array;
    }

    public function k2hasChilds($id)
    {
        $user = JFactory::getUser();
        $id = (int) $id;
        $db = JFactory::getDBO();
        $query = "SELECT * FROM #__k2_categories WHERE parent={$id} AND published=1";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if (count($rows))
        {
            return true;
        } else
        {
            return false;
        }
    }

    public function hasChilds($id)
    {
        $user = JFactory::getUser();
        $db = JFactory::getDBO();
        $query = "SELECT * FROM #__categories WHERE parent_id={$id} AND published=1";
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if (count($rows))
        {
            return true;
        } else
        {
            return false;
        }
    }

    public function introContent($str, $limit = 100, $end_char = '&#8230;')
    {
        if (trim($str) == '')
            return $str;
        $str = strip_tags($str);
        preg_match('/\s*(?:\S*\s*){' . (int) $limit . '}/', $str, $matches);
        if (strlen($matches[0]) == strlen($str))
            $end_char = '';
        return rtrim($matches[0]) . $end_char;
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

    public static function getThumbnailLink($src, $width, $height)
    {
        $src = str_replace(JUri::root(), JPATH_ROOT . '/', $src);
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
                $imager->resize($width, $height);
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

    public function checkImage($file)
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

    public function getAllCategories()
    {
        //Check source
        if ($this->source == 'k2_category' && $this->k2)
            return $this->getAllK2Categories();
        //End 
        $db = JFactory::getDBO();
        $cids = (array) $this->params->get('catid', array());
        $lists = array();
        if (count($cids))
        {
            foreach ($cids as $cid)
            {
                $categories = $this->getCategoryChilds($cid, true);
                $categories = @array_unique($categories);
                JArrayHelper::toInteger($categories);
                $lists[] = array_merge((array) $cid, $categories);
            }
        }
        return $lists;
    }

    public function getAllK2Categories()
    {
        $db = JFactory::getDBO();
        $k2cids = (array) $this->params->get('k2_catid', array());
        $lists = array();
        $i = 0;
        if (count($k2cids))
        {
            foreach ($k2cids as $k2cid)
            {
                $categories = $this->getK2CategoryChilds($k2cid, true);
                $categories = @array_unique($categories);
                JArrayHelper::toInteger($categories);
                $lists[] = array_merge((array) $k2cid, $categories);
            }
        }
        return $lists;
    }

    public function getK2CategoryDetail($catId)
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

    public function getCategoryDetail($catId)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT c.id,c.title
				FROM #__categories AS c " .
                " WHERE c.published = 1 AND c.id =" . $catId .
                " ORDER BY c.title ASC";
        $db->setQuery($sql);
        $results = $db->loadObject();
        return $results;
    }

    public function getCategory($catids, $source) {
        $category = array();
        $category[] = '<div class="title_category">';
                            
        if(isset($catids)) {
            if ($source == 'category')
            {
                $catdetail = $this->getCategoryDetail($catids);
                $link = JRoute::_(ContentHelperRoute::getCategoryRoute($catids));
                $title = $catdetail->title;
            } else
            {
                $catdetail = $this->getK2CategoryDetail($catids);
                $link = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($catdetail->id . ':' . urlencode($catdetail->alias))));
                $title = $catdetail->name;
            }
          
            $category[] = '<a href="'.$link.'" alt="'.$title.'">'.$title.'</a>';
        }
        $category[] = '</div>';

        return implode($category); 
    }

    public function getProducts(array $listCategories){
        $products = array(); 
        foreach ($listCategories as $category) {
            if(isset($category[0])) {
                $listItems = $this->getItemsByCatId($category[0]);
                if(count($listItems) > 0) {
                    foreach ($listItems as $item) {
                        $key = $item->alias;
                        while(isset($products[$key])) {
                            $key = $key.'1';
                        }
                        $products[$key][] = $item;
                        $products[$key][] = $category[0];
                    }
                }
            }
        }
        ksort($products);
        return $products;
    }
}

?>