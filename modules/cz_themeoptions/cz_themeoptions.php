<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class Cz_Themeoptions extends Module implements WidgetInterface
{
    /**
     * @var string Name of the module running on PS 1.7.x. Used for data migration.
     */
    protected $html = '';
    protected $currentIndex;
    protected $image_folder = 'views/img/';
    private $templateFile;

    public function __construct()
    {
        $this->name = 'cz_themeoptions';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Codezeel';
        $this->need_instance = 0;

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->trans('CZ - Theme Options', array(), 'Modules.Themeoptions.Admin');
        $this->description = $this->trans('Theme options help you to change color, fonts and other theme related settings in a visual and friendly way.', array(), 'Modules.Themeoptions.Admin');

        $this->ps_versions_compliancy = array('min' => '1.7.0.0', 'max' => _PS_VERSION_);

        $this->templateFile = 'module:cz_themeoptions/views/templates/hook/cz_themeoptions.tpl';
        $this->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
    }   

    public function install()
    {
        
        return (parent::install() &&
            $this->registerHook('displayFooter') &&
            $this->registerHook('displayFooterAfter') &&
            $this->registerHook('header')  &&
            $this->createConfiguration());
    }

    public function uninstall()
    {

        $this->deleteConfiguration();
        
        return parent::uninstall();
    }

    //DONGND:: create configs
	public function createConfiguration()
    {

        //DONGND:: create config option for theme settings
        Configuration::updateValue('CZCONTROL_PANEL', 0);        
        Configuration::updateValue('CZBOX_LAYOUT', 0);
        Configuration::updateValue('CZBOX_BGIMG', 'boxed-bg.png');
        Configuration::updateValue('CZBOX_BGIMG_STYLE', 'strech');
        Configuration::updateValue('CZSTICKY_HEADER', 1);
        Configuration::updateValue('CZBORDER_RADIUS', 1);
        Configuration::updateValue('CZPRIMARY_COLOR', '#afbc25');
        Configuration::updateValue('CZSECONDARY_COLOR', '#ffffff');
        Configuration::updateValue('CZPRICE_COLOR', '#000000');
        Configuration::updateValue('CZLINKHOVER_COLOR', '#afbc25');
        Configuration::updateValue('CZBOX_BODYBKG_COLOR', '#ffffff');
        Configuration::updateValue('CZBODY_FONT', 'Roboto');
        Configuration::updateValue('CZTITLE_FONT', 'Roboto');
        Configuration::updateValue('CZBANNER_FONT', 'Roboto');
        Configuration::updateValue('CZBODY_FONT_SIZE', '14px');
        Configuration::updateValue('CZCUSTOM_CSS', '');
        
        return true;

    }

    
    
    //DONGND:: delete configs
	public function deleteConfiguration()
    {	

        //DONGND:: delete config option for theme settings
        Configuration::deleteByName('CZCONTROL_PANEL');
        Configuration::deleteByName('CZBOX_LAYOUT');
        Configuration::deleteByName('CZBOX_BGIMG');
        Configuration::deleteByName('CZBOX_BGIMG_STYLE');
        Configuration::deleteByName('CZSTICKY_HEADER');
        Configuration::deleteByName('CZBORDER_RADIUS');        
        Configuration::deleteByName('CZPRIMARY_COLOR');
        Configuration::deleteByName('CZSECONDARY_COLOR');
        Configuration::deleteByName('CZPRICE_COLOR');
        Configuration::deleteByName('CZLINKHOVER_COLOR');
        Configuration::deleteByName('CZBOX_BODYBKG_COLOR');
        Configuration::deleteByName('CZBODY_FONT');
        Configuration::deleteByName('CZTITLE_FONT');
        Configuration::deleteByName('CZBANNER_FONT');
        Configuration::deleteByName('CZBODY_FONT_SIZE');
        Configuration::deleteByName('CZCUSTOM_CSS');

        return true;
        
    }

    //DONGND:: Set Values for input
    protected function getGroupFieldsValues()
    {	
        return array(
            'CZCONTROL_PANEL' => Configuration::get('CZCONTROL_PANEL'),
            'CZBOX_LAYOUT' => Configuration::get('CZBOX_LAYOUT'),
            'CZBOX_BGIMG' => Configuration::get('CZBOX_BGIMG'),
            'CZBOX_BGIMG_STYLE' => Configuration::get('CZBOX_BGIMG_STYLE'),
            'CZSTICKY_HEADER' => Configuration::get('CZSTICKY_HEADER'),
            'CZBORDER_RADIUS' => Configuration::get('CZBORDER_RADIUS'),
            'CZPRIMARY_COLOR' => Configuration::get('CZPRIMARY_COLOR'),
            'CZSECONDARY_COLOR' => Configuration::get('CZSECONDARY_COLOR'),
            'CZPRICE_COLOR' => Configuration::get('CZPRICE_COLOR'),
            'CZLINKHOVER_COLOR' => Configuration::get('CZLINKHOVER_COLOR'),
            'CZBOX_BODYBKG_COLOR' => Configuration::get('CZBOX_BODYBKG_COLOR'),
            'CZBODY_FONT' => Configuration::get('CZBODY_FONT'),
            'CZTITLE_FONT' => Configuration::get('CZTITLE_FONT'),
            'CZBANNER_FONT' => Configuration::get('CZBANNER_FONT'),
            'CZBODY_FONT_SIZE' => Configuration::get('CZBODY_FONT_SIZE'),
            'CZCUSTOM_CSS' => Configuration::get('CZCUSTOM_CSS'),
        );
    }
    
    
    public function hookHeader()
    {
        //$templateFile = 'module:cz_themeoptions/views/templates/hook/hookHeader.tpl';
        $this->context->controller->addJS($this->_path.'views/js/frontdesign.js');
        $this->context->controller->addCSS($this->_path.'views/css/frontdesign.css');

        if (Configuration::get('CZCONTROL_PANEL'))
		{
            $this->context->controller->addJS($this->_path.'views/js/jquery.minicolors.min.js');
            $this->context->controller->addJS($this->_path.'views/js/controllpanel.js');
                    
            $this->context->controller->addCSS($this->_path.'views/css/jquery.minicolors.css');
            $this->context->controller->addCSS($this->_path.'views/css/controllpanel.css');
        }

        Media::addJsDef(
            array(
                'CZBOX_LAYOUT' => Configuration::get('CZBOX_LAYOUT'),
                'CZSTICKY_HEADER' => Configuration::get('CZSTICKY_HEADER'),
                'CZBORDER_RADIUS' => Configuration::get('CZBORDER_RADIUS'),
            )
        );
        
        $this->context->smarty->assign(array(
            'bodyFont' => Configuration::get('CZBODY_FONT'),
            'titleFont' => Configuration::get('CZTITLE_FONT'),
            'bannerFont' => Configuration::get('CZBANNER_FONT'),
            'customCSSCode' => Configuration::get('CZCUSTOM_CSS'),
        ));
        
        return $this->display(__FILE__, 'header.tpl');

    }

    public function hookDisplayFooterAfter()
    {
        $fontArray  =  array(
            array('id' => 'Open+Sans', 'name' => 'Open Sans', 'link' => 'Open+Sans:wght@300;400;500;600;700;800&display=swap'),
            array('id' => 'Poppins', 'name' => 'Poppins', 'link' => 'Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap'),
            array('id' => 'Lato', 'name' => 'Lato', 'link' => 'Lato:wght@100;300;400;700;900&display=swap'),
            array('id' => 'Inter', 'name' => 'Inter', 'link' => 'Inter:wght@100;200;300;400;500;600;700;800;900&display=swap'),
            array('id' => 'Raleway', 'name' => 'Raleway', 'link' => 'Raleway:wght@400;500;600;700;800&display=swap'),
            array('id' => 'Roboto', 'name' => 'Roboto', 'link' => 'Roboto:wght@100;300;400;500;700;900&display=swap'),
            array('id' => 'Oxygen', 'name' => 'Oxygen', 'link' => 'Oxygen:wght@300;400;700&display=swap'),
            array('id' => 'Jost', 'name' => 'Jost', 'link' => 'Jost:wght@100;200;300;400;500;600;700;800;900&display=swap'),
            array('id' => 'Lora', 'name' => 'Lora', 'link' => 'Lora:wght@400;500;600;700&display=swap'),
            array('id' => 'Hind+Siliguri', 'name' => 'Hind Siliguri', 'link' => 'Hind+Siliguri:wght@300;400;500;600;700&display=swap'), 
            array('id' => 'Montserrat', 'name' => 'Montserrat', 'link' => 'Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap'),
            array('id' => 'Oswald', 'name' => 'Oswald', 'link' => 'Oswald:wght@200;300;400;500;600;700&display=swap'),
            array('id' => 'Nunito+Sans', 'name' => 'Nunito Sans', 'link' => 'Nunito+Sans:wght@200;300;400;600;700;800;900&display=swap'),
            array('id' => 'Roboto+Condensed', 'name' => 'Roboto Condensed', 'link' => 'Roboto+Condensed:wght@300;400;700&display=swap'),
            array('id' => 'Heebo', 'name' => 'Heebo', 'link' => 'Heebo:wght@100;200;300;400;500;600;700;800;900&display=swap'),
            array('id' => 'Roboto+Slab', 'name' => 'Roboto Slab', 'link' => 'Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&display=swap'),
            array('id' => 'Playfair+Display', 'name' => 'Playfair Display', 'link' => 'Playfair+Display:wght@400;500;600;700;800;900&display=swap'),
            array('id' => 'Rajdhani', 'name' => 'Rajdhani', 'link' => 'Rajdhani:wght@300;400;500;600;700&display=swap'),
            array('id' => 'Mulish', 'name' => 'Mulish', 'link' => 'Mulish:wght@200;300;400;500;600;700;800;900&display=swap'),
            array('id' => 'Merriweather', 'name' => 'Merriweather', 'link' => 'Merriweather:wght@300;400;700;900&display=swap'),
            array('id' => 'Work+Sans', 'name' => 'Work Sans', 'link' => 'Work+Sans:wght@100;200;300;400;500;600;700;800;900&display=swap'),
            array('id' => 'Oxanium', 'name' => 'Oxanium', 'link' => 'Oxanium:wght@200;300;400;500;600;700;800&display=swap'),
            array('id' => 'Karla', 'name' => 'Karla', 'link' => 'Karla:wght@200;300;400;500;600;700;800&display=swap'),
            array('id' => 'Barlow', 'name' => 'Barlow', 'link' => 'Barlow:wght@100;200;300;400;500;600;700;800;900&display=swap'),
        );
        
        $fontSizeArray  =  array(
            array('id' => '13px', 'name' => '13px'),
            array('id' => '14px', 'name' => '14px'),
            array('id' => '15px', 'name' => '15px'),
            array('id' => '16px', 'name' => '16px'),
            array('id' => '17px', 'name' => '17px'),
            array('id' => '18px', 'name' => '18px'),
        );
        
        if (Configuration::get('CZCONTROL_PANEL')) {   
            $this->context->smarty->assign('image_url', $this->context->link->getMediaLink(_MODULE_DIR_.'cz_themeoptions/views/img/pattern'));
            $this->context->smarty->assign('fontlist_array', $fontArray);
            $this->context->smarty->assign('fontsize_array', $fontSizeArray);

            return $this->display(__FILE__, 'controlpanel.tpl');
        }
    }

    public function postProcess()
    {
        
        if (Tools::isSubmit('submitThemeSettings')) {
            
            // Upload Body Background Image
            $values = array();
            $update_images_values = false;

            if (isset($_FILES['CZBOX_BGIMG']) && !empty($_FILES['CZBOX_BGIMG']['tmp_name'])) {
                if ($error = ImageManager::validateUpload($_FILES['CZBOX_BGIMG'], 4000000)) {
                    return $this->displayError($error);
                } else {
                    $file_name = $_FILES['CZBOX_BGIMG']['name'];
                    if (!move_uploaded_file($_FILES['CZBOX_BGIMG']['tmp_name'], dirname(__FILE__).DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.$file_name)) {
                        return $this->displayError($this->trans('An error occurred while attempting to upload the file.', array(), 'Admin.Notifications.Error'));
                    } else {
                        $values['CZBOX_BGIMG'] = $file_name; 
                        $update_images_values = true;
                    }
                }
            } 

            if ($update_images_values) {
                Configuration::updateValue('CZBOX_BGIMG', $values['CZBOX_BGIMG']);
            }

            $form_values = $this->getGroupFieldsValues();
            foreach (array_keys($form_values) as $key) {
                if($key == "CZBOX_BGIMG"){
                    continue;
                }
                Configuration::updateValue($key, Tools::getValue($key));
            }

            $this->_clearCache($this->templateFile);

            return $this->displayConfirmation($this->trans('Theme design settings have been updated.', array(), 'Admin.Notifications.Success'));
        }
        
       
        if (Tools::isSubmit('deleteBoxBkgImage')) {
            $general_settings = Configuration::get('CZBOX_BGIMG');
            if ($general_settings) {
                $image_path = $this->local_path.$this->image_folder.$general_settings;

                if (file_exists($image_path)) {
                    unlink($image_path);
                }
                Configuration::updateValue('CZBOX_BGIMG', '');
                $this->_clearCache('*');
            }
            
            return $this->displayConfirmation($this->trans('Box image deleted successfully', array(), 'Admin.Notifications.Success'));
            Tools::redirectAdmin($this->currentIndex.'&configure='.$this->name.'&token='.Tools::getAdminTokenLite('AdminModules'));
        }
        
        return '';
    }

    public function getContent()
    {
        return $this->postProcess().$this->renderForm();
    }

    public function renderForm()
    {
        
        $boxbg_image_style = array(
            'query' => array(
                array('id' => 'repeat', 'name' => 'Repeat'),
                array('id' => 'strech', 'name' => 'Strech'),
            ),
            'id' => 'id',
            'name' => 'name',
        );

        $fontsize_options = array(
            'query' => array(
                array('id' => '13px', 'name' => '13px'),
                array('id' => '14px', 'name' => '14px'),
                array('id' => '15px', 'name' => '15px'),
                array('id' => '16px', 'name' => '16px'),
                array('id' => '17px', 'name' => '17px'),
                array('id' => '18px', 'name' => '18px'),
            ),
            'id' => 'id',
            'name' => 'name',
        );

        $font_options = array(
            'query' => array(
                array('id' => 'Open+Sans', 'name' => 'Open Sans'),
                array('id' => 'Poppins', 'name' => 'Poppins'),
                array('id' => 'Lato', 'name' => 'Lato'),
                array('id' => 'Inter', 'name' => 'Inter'),
                array('id' => 'Raleway', 'name' => 'Raleway'),
                array('id' => 'Roboto', 'name' => 'Roboto'),
                array('id' => 'Oxygen', 'name' => 'Oxygen'),
                array('id' => 'Jost', 'name' => 'Jost'),
                array('id' => 'Lora', 'name' => 'Lora'),
                array('id' => 'Hind+Siliguri', 'name' => 'Hind Siliguri'), 
                array('id' => 'Montserrat', 'name' => 'Montserrat'),
                array('id' => 'Oswald', 'name' => 'Oswald'),
                array('id' => 'Nunito+Sans', 'name' => 'Nunito Sans'),
                array('id' => 'Roboto+Condensed', 'name' => 'Roboto Condensed'),
                array('id' => 'Heebo', 'name' => 'Heebo'),
                array('id' => 'Roboto+Slab', 'name' => 'Roboto Slab'),
                array('id' => 'Playfair+Display', 'name' => 'Playfair Display'),
                array('id' => 'Rajdhani', 'name' => 'Rajdhani'),
                array('id' => 'Mulish', 'name' => 'Mulish'),
                array('id' => 'Merriweather', 'name' => 'Merriweather'),
                array('id' => 'Work+Sans', 'name' => 'Work Sans'),
                array('id' => 'Oxanium', 'name' => 'Oxanium'),
                array('id' => 'Karla', 'name' => 'Karla'),
                array('id' => 'Barlow', 'name' => 'Barlow'),
            ),
            'id' => 'id',
            'name' => 'name',
        );
        
        $boxbg_image_url = false;
        $boxbg_image_size = false;
        if (Configuration::get('CZBOX_BGIMG')) {
            $boxbg_image_url = $this->_path.$this->image_folder. Configuration::get('CZBOX_BGIMG');
            $boxbg_image_size = filesize($this->local_path.$this->image_folder.Configuration::get('CZBOX_BGIMG')) / 1000;
        }

        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->trans('Theme Design Settings', array(), 'Admin.Global'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->trans('Control Panel'),
                        'name' => 'CZCONTROL_PANEL',
                        'desc' => $this->trans('Enable this option to see controll panel on frontend'),
                        'is_bool' => true,
                        'values'    => array(
                            array(
                                'id'    => 'active_on',
                                'value' => 1,
                                'label' => $this->trans('Enable')
                            ),
                            array(
                                'id'    => 'active_off',
                                'value' => 0,
                                'label' => $this->trans('Disable')
                            )
                        ),
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'CZPRIMARY_COLOR',
                        'label' => $this->trans('Primary Color'),
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'CZSECONDARY_COLOR',
                        'label' => $this->trans('Secondary Color'),
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'CZPRICE_COLOR',
                        'label' => $this->trans('Price Color'),
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'CZLINKHOVER_COLOR',
                        'label' => $this->trans('Link Hover Color'),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->trans('Body Font'),
                        'name' => 'CZBODY_FONT',
                        'options' => $font_options,
                        'desc' => $this->trans('Select your body font.'),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->trans('Body Font Size'),
                        'name' => 'CZBODY_FONT_SIZE',
                        'options' => $fontsize_options,
                        'desc' => $this->trans('Select your body font size.'),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->trans('Title Font'),
                        'name' => 'CZTITLE_FONT',
                        'options' => $font_options,
                        'desc' => $this->trans('Select your title font.'),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->trans('Banner Font'),
                        'name' => 'CZBANNER_FONT',
                        'options' => $font_options,
                        'desc' => $this->trans('Select your banner font.'),
                        'form_group_class' => 'page-header',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->trans('Box Layout'),
                        'name' => 'CZBOX_LAYOUT',
                        'desc' => $this->trans('Enable this option to make your store design Box Layout'),
                        'is_bool' => true,
                        'values'    => array(
                            array(
                                'id'    => 'active_on',
                                'value' => 1,
                                'label' => $this->trans('Enable')
                            ),
                            array(
                                'id'    => 'active_off',
                                'value' => 0,
                                'label' => $this->trans('Disable')
                            )
                        ),
                    ),                    
                    array(
                        'type' => 'color',
                        'name' => 'CZBOX_BODYBKG_COLOR',
                        'label' => $this->trans('Box Layout Background Color'),
                    ),
                    array(
                        'type' => 'file',
                        'label' => $this->trans('Box Background Image'),
                        'name' => 'CZBOX_BGIMG',
                        'display_image' => true,
                        'image' => $boxbg_image_url ? '<img src="'.$boxbg_image_url.'" alt="" class="img-thumbnail" style="max-width: 100px;" />' : false,
                        'size' => $boxbg_image_size,
                        'delete_url' => $this->currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules').'&deleteBoxBkgImage',
                        'desc' => $this->trans('Set background image for boxed layout.'),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->trans('Box Background Image Style'),
                        'name' => 'CZBOX_BGIMG_STYLE',
                        'options' => $boxbg_image_style,
                        'desc' => $this->l('How a background image will be displayed.'),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->trans('Sticky Header'),
                        'name' => 'CZSTICKY_HEADER',
                        'desc' => $this->trans('Enable this option to make your store header sticky while page scroll down'),
                        'is_bool' => true,
                        'values'    => array(
                            array(
                                'id'    => 'active_on',
                                'value' => 1,
                                'label' => $this->trans('Enable')
                            ),
                            array(
                                'id'    => 'active_off',
                                'value' => 0,
                                'label' => $this->trans('Disable')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->trans('Border Radius'),
                        'name' => 'CZBORDER_RADIUS',
                        'desc' => $this->trans('Enable this option to apply 5px border radius'),
                        'is_bool' => true,
                        'values'    => array(
                            array(
                                'id'    => 'active_on',
                                'value' => 1,
                                'label' => $this->trans('Enable')
                            ),
                            array(
                                'id'    => 'active_off',
                                'value' => 0,
                                'label' => $this->trans('Disable')
                            )
                        ),
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->trans('Custom CSS'),
                        'name' => 'CZCUSTOM_CSS',
                        'cols' => 40,
                        'rows' => 10,
                        'desc' => $this->l('Add custom css code for your site.'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->trans('Save', array(), 'Admin.Actions'),
                    'name' => 'submitThemeSettings',
                )
            ),
        );
        

        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->default_form_language = $lang->id;
        $helper->module = $this;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->identifier = $this->identifier;
        //$helper->submit_action = 'submitStoreConf';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'uri' => $this->getPathUri(),
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm(array(
            $fields_form
        ));
    }

    public function getConfigFieldsValues()
    {
        return $this->getGroupFieldsValues();
    }
    
    public function renderWidget($hookName, array $params)
    {
        if (!$this->isCached($this->templateFile, $this->getCacheId('cz_themeoptions'))) {
            $this->smarty->assign($this->getWidgetVariables($hookName, $params));
        }
        return $this->fetch($this->templateFile, $this->getCacheId('cz_themeoptions'));
    }

    public function getWidgetVariables($hookName, array $params)
    {
        $fields = array();

        $fields = $this->getGroupFieldsValues();
        $fields['image_dir_url'] = $this->context->link->getMediaLink(_MODULE_DIR_) . 'cz_themeoptions/views/img/';
        $fields['body_fontfamily'] =  str_replace( '+', ' ', Configuration::get('CZBODY_FONT'));
        $fields['title_fontfamily'] =  str_replace( '+', ' ', Configuration::get('CZTITLE_FONT'));
        $fields['banner_fontfamily'] =  str_replace( '+', ' ', Configuration::get('CZBANNER_FONT'));
        $this->smarty->assign($fields);
        
    }
}

