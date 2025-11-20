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

class Cz_Themeimages extends Module implements WidgetInterface
{
    /**
     * @var string Name of the module running on PS 1.7.x. Used for data migration.
     */

    private $templateFile;
    const UPLOAD_OPTIONS = ['FOOTER_IMAGE', 'TESTIMONIAL_IMAGE'];
    const SAMPLE_IMAGES = ['footer_bg.jpg', 'testimonial_bg.jpg'];

    public function __construct()
    {
        $this->name = 'cz_themeimages';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Codezeel';
        $this->need_instance = 0;

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->trans('CZ - Theme Images', array(), 'Modules.Themeimages.Admin');
        $this->description = $this->trans('This module help you to change background and parallax images for your store in a visual and friendly way.', array(), 'Modules.Themeimages.Admin');

        $this->ps_versions_compliancy = array('min' => '1.7.0.0', 'max' => _PS_VERSION_);

        $this->templateFile = 'module:cz_themeimages/views/templates/hook/cz_themeimages.tpl';
    }

    public function install()
    {
        
        return (parent::install() &&
            $this->registerHook('displayFooter') &&
            $this->installSamples());
    }

    protected function installSamples()
    {
        $languages = Language::getLanguages(false);
        $values = array();
        foreach (static::UPLOAD_OPTIONS as $key => $option) {
            foreach ($languages as $lang) {
                $values[$option][(int)$lang['id_lang']] = static::SAMPLE_IMAGES[$key];
                Configuration::updateValue($option, $values[$option]);
            }
        }

        return true;
    }

    public function uninstall()
    {
        foreach (static::UPLOAD_OPTIONS as $option) {
            Configuration::deleteByName($option);
        }
        return parent::uninstall();
    }
    
    public function postProcess()
    {
        if (Tools::isSubmit('submitStoreConf')) {

            $languages = Language::getLanguages(false);
            $values = array();
            $update_images_values = false;
            
            // Upload Image File
            foreach (static::UPLOAD_OPTIONS as $option) {
                foreach ($languages as $lang) {
                    if (isset($_FILES[$option.'_'.$lang['id_lang']])
                        && isset($_FILES[$option.'_'.$lang['id_lang']]['tmp_name'])
                        && !empty($_FILES[$option.'_'.$lang['id_lang']]['tmp_name'])) {
                        if ($error = ImageManager::validateUpload($_FILES[$option.'_'.$lang['id_lang']], 4000000)) {
                            return $this->displayError($error);
                        } else {
                            $ext = Tools::substr($_FILES[$option.'_'.$lang['id_lang']]['name'], strrpos($_FILES[$option.'_'.$lang['id_lang']]['name'], '.') + 1);
                            $file_name = md5($_FILES[$option.'_'.$lang['id_lang']]['name']).'_'.Tools::strtolower($option).$lang['id_lang'].'.'.$ext;
                            if (!move_uploaded_file($_FILES[$option.'_'.$lang['id_lang']]['tmp_name'], dirname(__FILE__).DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.$file_name)) {
                                return $this->displayError($this->trans('An error occurred while attempting to upload the file.', array(), 'Admin.Notifications.Error'));
                            } else {
                                if (Configuration::hasContext($option, $lang['id_lang'], Shop::getContext())
                                    && Configuration::get($option, $lang['id_lang']) != $file_name
                                    && (!in_array(Configuration::get($option, $lang['id_lang']), static::SAMPLE_IMAGES))) {
                                    @unlink(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'views'.DIRECTORY_SEPARATOR.'img' . DIRECTORY_SEPARATOR . Configuration::get($option, $lang['id_lang']));
                                }
                                
                                $values[$option][$lang['id_lang']] = $file_name;
                            }
                        }
                        $update_images_values = true;
                        if ($update_images_values) {
                            Configuration::updateValue($option, $values[$option]);
                        }
                    }
                }
            }
            $this->_clearCache($this->templateFile);

            return $this->displayConfirmation($this->trans('The settings have been updated.', array(), 'Admin.Notifications.Success'));
        }

        return '';
    }

    public function getContent()
    {
        return $this->postProcess().$this->renderForm();
    }

    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->trans('Theme Images', array(), 'Admin.Global'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'file_lang',
                        'label' => $this->trans('Footer Background Image', array(), 'Modules.Themeimages.Admin'),
                        'name' => 'FOOTER_IMAGE',
                        'desc' => $this->trans('Upload an image for Footer section. The recommended dimensions are 1903px x 700px if you are using the default theme. Allowed formats are: .gif, .jpg, .png', array(), 'Modules.Themeimages.Admin'),
                        'lang' => true,
                    ),
                    array(
                        'type' => 'file_lang',
                        'label' => $this->trans('Testimonial Background Image', array(), 'Modules.Themeimages.Admin'),
                        'name' => 'TESTIMONIAL_IMAGE',
                        'desc' => $this->trans('Upload an image for Testimonial section. The recommended dimensions are 1920px x 1080px if you are using the default theme. Allowed formats are: .gif, .jpg, .png', array(), 'Modules.Themeimages.Admin'),
                        'lang' => true,
                    )
                ),
                'submit' => array(
                    'title' => $this->trans('Save', array(), 'Admin.Actions')
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
        $helper->submit_action = 'submitStoreConf';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'uri' => $this->getPathUri(),
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm(array($fields_form));
    }

    public function getConfigFieldsValues()
    {
        $languages = Language::getLanguages(false);
        $fields = array();

        foreach (static::UPLOAD_OPTIONS as $option) {
            foreach ($languages as $lang) {
                $fields[$option][$lang['id_lang']] = Tools::getValue($option.'_'.$lang['id_lang'], Configuration::get($option, $lang['id_lang']));
            }
        }

        return $fields;
    }
    
    public function renderWidget($hookName, array $params)
    {
        if (!$this->isCached($this->templateFile, $this->getCacheId('cz_themeimages'))) {
            $this->smarty->assign($this->getWidgetVariables($hookName, $params));
        }

        return $this->fetch($this->templateFile, $this->getCacheId('cz_themeimages'));
    }

    public function getWidgetVariables($hookName, array $params)
    {
        foreach (static::UPLOAD_OPTIONS as $option) {
            if (Configuration::get($option, $this->context->language->id)
                 && file_exists(_PS_MODULE_DIR_.$this->name.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.Configuration::get($option, $this->context->language->id))) {
                    $this->smarty->assign($option, $this->context->link->protocol_content . Tools::getMediaServer(Configuration::get($option, $this->context->language->id)). $this->_path . 'views/img/' . Configuration::get($option, $this->context->language->id));
            }
        }
    }
}