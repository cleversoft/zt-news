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
jimport('joomla.access.access');
jimport('joomla.form.formfield');

/**
 * Class exists checking
 */
class JFormFieldVsection extends JFormField
{

    /**
     * Element name
     *
     * @access  protected
     * @var     string
     */
    protected $type = 'vsection';

    protected function getInput()
    {
        $db = JFactory::getDBO();
        $document = JFactory::getDocument();
        $document->addStylesheet(JURI::root() . 'modules/mod_zt_news/admin/css/adminstyle.css');
        $cId = JRequest::getVar('id', 0);
        $sql = "SELECT params FROM #__modules WHERE id=$cId";
        $db->setQuery($sql);
        $data = $db->loadResult();
        $params = new JRegistry($data);
        $source = $params->get('source', 'content');
        $layout = $params->get('layout');
        $tem = explode(':', $layout);
        $defaultLayout = isset($tem[1]) ? $tem[1] : 'headline';
        ?>
        <!-- For these js must be stored in js file instead -->
        <script type="text/javascript">

            jQuery(document).ready(function () {
                layoutChange('<?php echo $defaultLayout ?>');
                jQuery('#jform_params_layout').change(function () {
                    var layout = jQuery(this).val();
                    var defaultLayout = layout.split(':')[1];
                    layoutChange(defaultLayout);
                });
                var wrap = jQuery('#jform_params_wrap_content').find('input:checked').val();
                toggleField(wrap);
                jQuery('#jform_params_wrap_content').change(function () {
                    var wrap = jQuery(this).find('input:checked').val();
                    toggleField(wrap);
                })
            });

            var jpaneAutoHeight = function () {
                $$('.jpane-slider').each(function (item) {
                    item.setStyle('height', 'auto');
                });
            };
            function layoutChange(layout) {
                if (/horizontal/i.test(layout)) {
                    jQuery('a[href="#attrib-slide_options"]').parent().show();
                    jQuery('a[href="#attrib-links_options"]').parent().hide();
                    jQuery('#jform_params_is_subcat').parents('.control-group').hide();
                    jQuery('#jform_params_is_all').parents('.control-group').hide();
                    jQuery('#jform_params_number_intro_items').parents('.control-group').hide();
                    jQuery('#jform_params_number_link_items').parents('.control-group').hide();
                    jQuery('#jform_params_columns').parents('.control-group').hide();
                    jQuery('#jform_params_thumb_list_width').parents('.control-group').hide();
                    jQuery('#jform_params_thumb_list_height').parents('.control-group').hide();
                    jQuery('#jform_params_show_title_list').parents('.control-group').hide();
                    jQuery('#jform_params_is_image_list').parents('.control-group').hide();
                    jQuery('#jform_params_show_intro_list').parents('.control-group').hide();
                    jQuery('#jform_params_show_date_list').parents('.control-group').hide();
                } else {
                    jQuery('a[href="#attrib-slide_options"]').parent().hide();
                    jQuery('a[href="#attrib-links_options"]').parent().show();
                    jQuery('#jform_params_showtitlecat').parents('.control-group').show();
                    jQuery('#jform_params_is_subcat').parents('.control-group').show();
                    jQuery('#jform_params_is_all').parents('.control-group').show();
                    jQuery('#jform_params_number_link_items').parents('.control-group').show();
                    jQuery('#jform_params_columns').parents('.control-group').show();
                    jQuery('#jform_params_thumb_list_width').parents('.control-group').show();
                    jQuery('#jform_params_thumb_list_height').parents('.control-group').show();
                    jQuery('#jform_params_show_title_list').parents('.control-group').show();
                    jQuery('#jform_params_is_image_list').parents('.control-group').show();
                    jQuery('#jform_params_show_intro_list').parents('.control-group').show();
                    jQuery('#jform_params_show_date_list').parents('.control-group').show();
                }
                jQuery('.zt-news-layout .layout-item').removeClass('selected');
                jQuery('.zt-news-layout .' + layout).addClass('selected');
            }
            function toggleField(wrap) {
                if (wrap==1)
                    jQuery('#jform_params_image_order').parents('.control-group').slideUp();
                else
                    jQuery('#jform_params_image_order').parents('.control-group').slideDown();
            }
        </script>
        <?php
    }

}
