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

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.application.component.helper');

/**
 * Custom form field
 * @todo We should check class exists before declare
 */
class JFormFieldK2Categories extends JFormFieldList
{

    protected $type = 'K2Categories';
    var $options = array();

    /**
     * Check if K2 is installed
     * @return boolean
     */
    protected function k2Enabled()
    {
        $db = JFactory::getDbo();
        $query = ' SELECT ' . $db->quoteName('enabled')
            . ' FROM ' . $db->quoteName('#__extensions')
            . ' WHERE ' . $db->quoteName('name') . ' = ' . $db->quote('com_k2');
        $db->setQuery($query);
        $is_enabled = $db->loadResult();
        return $is_enabled;
    }

    /**
     * @return string
     */
    protected function getInput()
    {
        // If K2 is not exists than return empty
        if (!$this->k2Enabled())
        {
            return '';
        }

        $html = array();
        $attr = '';

        $attr .= $this->element['size'] ? ' size="' . (int) $this->element['size'] . '"' : '';
        $attr .= $this->multiple ? ' multiple="multiple"' : '';

        // Get the field options.
        $options = (array) $this->getOptions();
        // Create a read-only list (no name) with a hidden input to store the value.
        if ((string) $this->element['readonly'] == 'true')
        {
            $html[] = JHtml::_('select.genericlist', $options, '', trim($attr), 'value', 'text', $this->value, $this->id);
            $html[] = '<input type="hidden" name="' . $this->name . '" value="' . $this->value . '"/>';
        }
        // Create a regular list.
        else
        {
            $html[] = JHtml::_('select.genericlist', $options, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);
        }

        return implode($html);
    }

    /**
     * @return array|void
     */
    protected function getOptions()
    {
        if (!$this->k2Enabled())
        {
            return;
        }
        // Initialize variables.
        $session = JFactory::getSession();
        $db = JFactory::getDBO();

        // generating query
        // @todo Should clean query instead directly like this
        $db->setQuery("SELECT c.name AS name, c.id AS id, c.parent AS parent FROM #__k2_categories AS c WHERE published = 1 AND trash = 0 ORDER BY c.name, c.parent ASC");
        // getting results
        $results = $db->loadObjectList();

        // Recursive
        if (count($results))
        {
            // iterating
            $temp_options = array();

            foreach ($results as $item)
            {
                array_push($temp_options, array($item->id, $item->name, $item->parent));
            }

            foreach ($temp_options as $option)
            {
                if ($option[2] == 0)
                {
                    $this->options[] = JHtml::_('select.option', $option[0], $option[1]);
                    $this->recursive_options($temp_options, 1, $option[0]);
                }
            }

            return $this->options;
        } else
        {
            return $this->options;
        }
    }

    // bind function to save
    public function bind($array, $ignore = '')
    {
        if (key_exists('field-name', $array) && is_array($array['field-name']))
        {
            $array['field-name'] = implode(',', $array['field-name']);
        }

        return parent::bind($array, $ignore);
    }

    /**
     * @todo Use valid PSR-2 function name
     * @param $temp_options
     * @param $level
     * @param $parent
     */
    public function recursive_options($temp_options, $level, $parent)
    {
        foreach ($temp_options as $option)
        {
            if ($option[2] == $parent)
            {
                $level_string = '';
                for ($i = 0; $i < $level; $i++)
                    $level_string .= '- - ';
                $this->options[] = JHtml::_('select.option', $option[0], $level_string . $option[1]);
                $this->recursive_options($temp_options, $level + 1, $option[0]);
            }
        }
    }
}
