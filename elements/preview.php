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

defined('JPATH_BASE') or die();
jimport('joomla.html.html');
jimport('joomla.access.access');
jimport('joomla.form.formfield');

/**
 * Class exists checking
 */
class JFormFieldPreview extends JFormField
{

    /**
     * Element name
     *
     * @access  protected
     * @var   string
     */
    protected $type = 'preview';

    protected function getInput()
    {
        $db = JFactory::getDBO();
        $document = JFactory::getDocument();
        $cId = JRequest::getVar('id', 0);
        // @todo Do never use like this
        $sql = "SELECT params FROM #__modules WHERE id=$cId";
        $db->setQuery($sql);
        $data = $db->loadResult();
        $params = new JRegistry($data);
        $layout = $params->get('layout');
        $html = '<div class="zt-news-layout">';
        if ($layout == 'headline')
        {
            $html .= '<div class="layout-item headline selected" data-layout="headline"></div>';
        } else
        {
            $html .= '<div class="layout-item headline" data-layout="headline"></div>';
        }
        if ($layout == 'horizontal')
        {
            $html .= '<div class="layout-item horizontal selected" data-layout="horizontal"></div>';
        } else
        {
            $html .= '<div class="layout-item horizontal"data-layout="horizontal"></div>';
        }
        if ($layout == 'newsiv')
        {
            $html .= '<div class="layout-item newsiv selected" data-layout="newsiv"></div>';
        } else
        {
            $html .= '<div class="layout-item newsiv" data-layout="newsiv"></div>';
        }
        
        if ($layout == 'newsiv2')
        {
            $html .= '<div class="layout-item newsiv2 selected" data-layout="newsiv2"></div>';
        } else
        {
            $html .= '<div class="layout-item newsiv2" data-layout="newsiv2"></div>';
        }
        if ($layout == 'newsiv3')
        {
            $html .= '<div class="layout-item newsiv3 selected" data-layout="newsiv3"></div>';
        } else
        {
            $html .= '<div class="layout-item newsiv3" data-layout="newsiv3"></div>';
        }
        if ($layout == 'vertical')
        {
            $html .= '<div class="layout-item vertical selected" data-layout="vertical"></div>';
        } else
        {
            $html .= '<div class="layout-item vertical" data-layout="vertical"></div>';
        }
        $html .= '</div>';

        return $html;
    }

}
