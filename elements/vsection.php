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
if (version_compare(JVERSION, '3.0', 'ge'))
{
    define('ZT_JNVersion', '30');
} else
{
    define('ZT_JNVersion', '25');
}
jimport('joomla.html.html');
jimport('joomla.access.access');
jimport('joomla.form.formfield');

class JFormFieldVsection extends JFormField
{

    /**
     * Element name
     *
     * @access	protected
     * @var		string
     */
    protected $type = 'vsection';

    protected function getInput()
    {
        $db = JFactory::getDBO();
        $document = JFactory::getDocument();
        $document->addStylesheet(JURI::root() . 'modules/mod_zt_news/admin/css/adminstyle.css');
        $cId = JRequest::getVar('id', '');
        $sql = "SELECT params FROM #__modules WHERE id=$cId";
        $db->setQuery($sql);
        $data = $db->loadResult();
        $params = new JRegistry($data);
        $source = $params->get('source', 'category');
        $layout = $params->get('template_type');
        ?>	
        <script type="text/javascript">
        <?php if (ZT_JNVersion == '25')
        { ?>
                window.addEvent('load', function () {
                    setTimeout(jpaneAutoHeight, 400);
                    sourceChange('<?php echo $source; ?>');
                    layoutChange('<?php echo $layout; ?>');
                    $('jform_params_source').addEvent('change', function () {
                        sourceChange(this.value);
                    });
                    $('jform_params_template_type').addEvent('change', function () {
                        layoutChange(this.value);
                    });
                });
        <?php } else
        { ?>
                jQuery(document).ready(function () {
                    sourceChange('<?php echo $source; ?>');
                    layoutChange('<?php echo $layout; ?>');
                    jQuery('#jform_params_source').change(function () {
                        sourceChange(jQuery(this).val());
                    });
                    jQuery('#jform_params_template_type').change(function () {
                        layoutChange(jQuery(this).val());
                    });

                });
        <?php } ?>
            var jpaneAutoHeight = function () {
                $$('.jpane-slider').each(function (item) {
                    item.setStyle('height', 'auto');
                });
            };
            function sourceChange(val) {
        <?php if (ZT_JNVersion == '25')
        { ?>
                    if (val == 'category') {
                        $('jform_params_k2_catid').getParent().setStyle('display', 'none');
                        $('jform_params_catid').getParent().setStyle('display', 'block');
                        $('jform_params_type_image').getParent().setStyle('display', 'none');
                        $('jform_params_rderingk2').getParent().setStyle('display', 'none');
                        $('jform_params_rderingkcontent').getParent().setStyle('display', 'block');
                    }
                    else {
                        $('jform_params_k2_catid').getParent().setStyle('display', 'block');
                        $('jform_params_catid').getParent().setStyle('display', 'none');
                        $('jform_params_type_image').getParent().setStyle('display', 'block');
                        $('jform_params_rderingk2').getParent().setStyle('display', 'block');
                        $('jform_params_rderingkcontent').getParent().setStyle('display', 'none');
                    }
        <?php } else
        { ?>
                    if (val == 'category') {
                        jQuery('#jform_params_k2_catid').parents('.control-group').hide();
                        jQuery('#jform_params_catid').parents('.control-group').show();
                        jQuery('#jform_params_type_image').parents('.control-group').hide();
                        jQuery('#jform_params_rderingk2').parents('.control-group').hide();
                        jQuery('#jform_params_rderingkcontent').parents('.control-group').show();
                    }
                    else {
                        jQuery('#jform_params_k2_catid').parents('.control-group').show();
                        jQuery('#jform_params_catid').parents('.control-group').hide();
                        jQuery('#jform_params_type_image').parents('.control-group').show();
                        jQuery('#jform_params_rderingk2').parents('.control-group').show();
                        jQuery('#jform_params_rderingkcontent').parents('.control-group').hide();
                    }
        <?php } ?>
            }
            function layoutChange(val) {
                if (val == 'horizontal') {
        <?php if (ZT_JNVersion == '25')
        { ?>
                        $('jform_params_breakpoint').getParent().setStyle('display', 'block');
                        $('jform_params_showtitlecat').getParent().setStyle('display', 'none');
                        $('jform_params_is_subcat').getParent().setStyle('display', 'none');
                        $('jform_params_is_all').getParent().setStyle('display', 'none');
                        $('jform_params_no_link_items').getParent().setStyle('display', 'none');
                        $('jform_params_columns').getParent().setStyle('display', 'none');
                        $('jform_params_thumb_list_width').getParent().setStyle('display', 'none');
                        $('jform_params_thumb_list_height').getParent().setStyle('display', 'none');
                        $('jform_params_show_title_list').getParent().setStyle('display', 'none');
                        $('jform_params_is_image_list').getParent().setStyle('display', 'none');
                        $('jform_params_show_intro_list').getParent().setStyle('display', 'none');
                        $('jform_params_show_date_list').getParent().setStyle('display', 'none');
        <?php } else
        { ?>
                        jQuery('#jform_params_breakpoint').parents('.control-group').show();
                        jQuery('#jform_params_showtitlecat').parents('.control-group').hide();
                        jQuery('#jform_params_is_subcat').parents('.control-group').hide();
                        jQuery('#jform_params_is_all').parents('.control-group').hide();
                        jQuery('#jform_params_no_link_items').parents('.control-group').hide();
                        jQuery('#jform_params_columns').parents('.control-group').hide();
                        jQuery('#jform_params_thumb_list_width').parents('.control-group').hide();
                        jQuery('#jform_params_thumb_list_height').parents('.control-group').hide();
                        jQuery('#jform_params_show_title_list').parents('.control-group').hide();
                        jQuery('#jform_params_is_image_list').parents('.control-group').hide();
                        jQuery('#jform_params_show_intro_list').parents('.control-group').hide();
                        jQuery('#jform_params_show_date_list').parents('.control-group').hide();
        <?php } ?>
                } else {
        <?php if (ZT_JNVersion == '25')
        { ?>
                        $('jform_params_breakpoint').getParent().setStyle('display', 'none');
                        $('jform_params_showtitlecat').getParent().setStyle('display', 'block');
                        $('jform_params_is_subcat').getParent().setStyle('display', 'block');
                        $('jform_params_is_all').getParent().setStyle('display', 'block');
                        $('jform_params_no_link_items').getParent().setStyle('display', 'block');
                        $('jform_params_columns').getParent().setStyle('display', 'block');
                        $('jform_params_thumb_list_width').getParent().setStyle('display', 'block');
                        $('jform_params_thumb_list_height').getParent().setStyle('display', 'block');
                        $('jform_params_show_title_list').getParent().setStyle('display', 'block');
                        $('jform_params_is_image_list').getParent().setStyle('display', 'block');
                        $('jform_params_show_intro_list').getParent().setStyle('display', 'block');
                        $('jform_params_show_date_list').getParent().setStyle('display', 'block');
        <?php } else
        { ?>
                        jQuery('#jform_params_breakpoint').parents('.control-group').hide();
                        jQuery('#jform_params_showtitlecat').parents('.control-group').show();
                        jQuery('#jform_params_is_subcat').parents('.control-group').show();
                        jQuery('#jform_params_is_all').parents('.control-group').show();
                        jQuery('#jform_params_no_link_items').parents('.control-group').show();
                        jQuery('#jform_params_columns').parents('.control-group').show();
                        jQuery('#jform_params_thumb_list_width').parents('.control-group').show();
                        jQuery('#jform_params_thumb_list_height').parents('.control-group').show();
                        jQuery('#jform_params_show_title_list').parents('.control-group').show();
                        jQuery('#jform_params_is_image_list').parents('.control-group').show();
                        jQuery('#jform_params_show_intro_list').parents('.control-group').show();
                        jQuery('#jform_params_show_date_list').parents('.control-group').show();
        <?php } ?>
                }
            }
        </script>
        <?php
    }

}
