<?php
/**
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2016 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registred Trademark & Property of PrestaShop SA
*/

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Cz_NewProducts extends Module implements WidgetInterface
{
    
	private $templateFileDefault,
			$templateFileSidebar;

    public function __construct()
    {
        $this->name = 'cz_newproducts';
        $this->tab = 'front_office_features';
		$this->author = 'Codezeel';
        $this->version = '1.0.0';
        $this->need_instance = 0;

        $this->ps_versions_compliancy = array(
            'min' => '1.7.0.0',
            'max' => _PS_VERSION_,
        );

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->trans('CZ - New products', array(), 'Modules.Newproducts');
        $this->description = $this->trans('Displays new products as Slider or Grid in the central column of your homepage.', array(), 'Modules.Newproducts');
		
        
		$this->templateFileDefault = 'module:cz_newproducts/views/templates/hook/cz_newproducts.tpl';
		$this->templateFileSidebar = 'module:cz_newproducts/views/templates/hook/cz_newproducts_sidebar.tpl';
    }

    public function install()
    {
        $this->_clearCache('*');

        return parent::install()
            && Configuration::updateValue('CZNEW_PRODUCTS_NBR', 10)
			&& Configuration::updateValue('CZNEW_PRODUCTS_SIDEBAR_NBR', 3)
			&& Configuration::updateValue('CZNEW_PRODUCTS_SLIDER', 1)
            && $this->registerHook('actionProductAdd')
            && $this->registerHook('actionProductUpdate')
            && $this->registerHook('actionProductDelete')
            //&& $this->registerHook('displayCzNew')
			&& $this->registerHook('displayLeftColumn')
			&& $this->registerHook('displayHome')
        ;
    }

    public function uninstall()
    {
        $this->_clearCache('*');

        if (!parent::uninstall() ||
            !Configuration::deleteByName('CZNEW_PRODUCTS_NBR') ||
			!Configuration::deleteByName('CZNEW_PRODUCTS_SIDEBAR_NBR')) {
            return false;
        }

        return true;
    }

    public function hookActionProductAdd($params)
    {
        $this->_clearCache('*');
    }

    public function hookActionProductUpdate($params)
    {
        $this->_clearCache('*');
    }

    public function hookActionProductDelete($params)
    {
        $this->_clearCache('*');
    }

    public function _clearCache($template, $cache_id = null, $compile_id = null)
    {
        parent::_clearCache($this->templateFileDefault);
		parent::_clearCache($this->templateFileSidebar);
    }

    public function getContent()
    {
        $output = '';
        $errors = array();
		
		if (Tools::isSubmit('submitBlockCzNewProducts')) {

            $productNbr = Tools::getValue('CZNEW_PRODUCTS_NBR');
			if (!Validate::isInt($productNbr) || $productNbr <= 0) {
                $errors[] = $this->trans('The number of products is invalid. Please enter a positive number.', array(), 'Modules.Newproducts');
            }
			
			$productSidebarNbr = Tools::getValue('CZNEW_PRODUCTS_SIDEBAR_NBR');
			if (!Validate::isInt($productSidebarNbr) || $productSidebarNbr <= 0) {
                $errors[] = $this->trans('The number of products is invalid. Please enter a positive number.', array(), 'Modules.Newproducts');
            }
			
            if (isset($errors) && count($errors)) {
                $output = $this->displayError(implode('<br />', $errors));
            } else {
                Configuration::updateValue('PS_NB_DAYS_NEW_PRODUCT', (int)Tools::getValue('PS_NB_DAYS_NEW_PRODUCT'));
                Configuration::updateValue('CZNEW_PRODUCTS_NBR', (int)$productNbr);
				Configuration::updateValue('CZNEW_PRODUCTS_SIDEBAR_NBR', (int)$productSidebarNbr);
				Configuration::updateValue('CZNEW_PRODUCTS_SLIDER', (int)Tools::getValue('CZNEW_PRODUCTS_SLIDER'));

                $this->_clearCache('*');

                $output = $this->displayConfirmation($this->trans('The settings have been updated.', array(), 'Admin.Notifications.Success'));
            }
        }
        return $output.$this->renderForm();
    }

    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->trans('Settings', array(), 'Admin.Global'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->trans('Products to display', array(), 'Modules.Newproducts.Admin'),
                        'name' => 'CZNEW_PRODUCTS_NBR',
                        'class' => 'fixed-width-xs',
                        'desc' => $this->trans('Define the number of products to be displayed in this block.', array(), 'Modules.Newproducts.Admin'),
                    ),
                    array(
                        'type'  => 'text',
                        'label' => $this->trans('Number of days for which the product is considered \'new\'', array(), 'Modules.Newproducts.Admin'),
                        'name'  => 'PS_NB_DAYS_NEW_PRODUCT',
                        'class' => 'fixed-width-xs',
                    ),
					array(
                        'type' => 'switch',
                        'label' => $this->trans('Display New Product as Slider', array(), 'Modules.Newproducts'),
                        'name' => 'CZNEW_PRODUCTS_SLIDER',
                        'class' => 'fixed-width-xs',
                        'desc' => $this->trans('Display Slider or Grid.(Note:Slider is working if "Number of product" is set more than 4).', array(), 'Modules.Newproducts'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->trans('Yes', array(), 'Admin.Global'),
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->trans('No', array(), 'Admin.Global'),
                            ),
                        ),
                    ),
					array(
                        'type'  => 'text',
                        'label' => $this->trans('Products to display in sidebar', array(), 'Modules.Newproducts'),
                        'name'  => 'CZNEW_PRODUCTS_SIDEBAR_NBR',
                        'class' => 'fixed-width-xs',
						'desc' => $this->trans('Define the number of products to be displayed in this Left or Right column.', array(), 'Modules.Newproducts'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->trans('Save', array(), 'Admin.Actions')
                ),
            ),
        );

        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table =  $this->table;
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitBlockCzNewProducts';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) .
            '&configure=' . $this->name .
            '&tab_module=' . $this->tab .
            '&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm(array($fields_form));
    }

    public function getConfigFieldsValues()
    {
        return array(
            'PS_NB_DAYS_NEW_PRODUCT' => Tools::getValue('PS_NB_DAYS_NEW_PRODUCT', (int) Configuration::get('PS_NB_DAYS_NEW_PRODUCT')),
            'CZNEW_PRODUCTS_NBR' => Tools::getValue('CZNEW_PRODUCTS_NBR', (int) Configuration::get('CZNEW_PRODUCTS_NBR')),
			'CZNEW_PRODUCTS_SIDEBAR_NBR' => Tools::getValue('CZNEW_PRODUCTS_SIDEBAR_NBR', (int) Configuration::get('CZNEW_PRODUCTS_SIDEBAR_NBR')),
			'CZNEW_PRODUCTS_SLIDER' => Tools::getValue('CZNEW_PRODUCTS_SLIDER',(int)  Configuration::get('CZNEW_PRODUCTS_SLIDER')),
        );
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {
		if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];			
        }
		
		if ($hookName == 'displayLeftColumn' || $hookName == 'displaRightColumn') {
			
			if (!$this->isCached($this->templateFileSidebar, $this->getCacheId('cz_newproducts_sidebar'))) {
				$variables = $this->getWidgetVariables($hookName, $configuration);
				if (empty($variables)) {
					return false;
				}	
				$this->smarty->assign($variables);
			}			
			return $this->fetch($this->templateFileSidebar, $this->getCacheId('cz_newproducts_sidebar'));			
        } else {            
			 
			if (!$this->isCached($this->templateFileDefault, $this->getCacheId('cz_newproducts'))) {
				$variables = $this->getWidgetVariables($hookName, $configuration);
				if (empty($variables)) {
					return false;
				}	
				$this->smarty->assign($variables);
			}	
			return $this->fetch($this->templateFileDefault, $this->getCacheId('cz_newproducts'));
        }
    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        if ($hookName == null && isset($configuration['hook'])) {
            $hookName = $configuration['hook'];			
        }
		
		if ($hookName == 'displayLeftColumn' || $hookName == 'displayRightColumn') {
			$sidebarProducts = $this->getNewProducts((int)Configuration::get('CZNEW_PRODUCTS_SIDEBAR_NBR'));
			if (!empty($sidebarProducts)) {
				return array(
					'sidebarProducts' => $sidebarProducts,
					'allNewProductsLink' => Context::getContext()->link->getPageLink('new-products'),
				);
			}
		} else {
			$products = $this->getNewProducts((int)Configuration::get('CZNEW_PRODUCTS_NBR'));
			if (!empty($products)) {
				return array(
					'products' => $products,
					'allNewProductsLink' => Context::getContext()->link->getPageLink('new-products'),
					'no_prod' => (int) Configuration::get('CZNEW_PRODUCTS_NBR'),
					'slider' => (int) Configuration::get('CZNEW_PRODUCTS_SLIDER'),
				);
			}
		}
        return false;
    }

    protected function getNewProducts($productnbr)
    {
        if (Configuration::get('PS_CATALOG_MODE')) {
            //return false;
        }

        $newProducts = false;

        if (Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) {
            $newProducts = Product::getNewProducts(
                (int)$this->context->language->id,
                0,
                $productnbr
            );
        }

        $assembler = new ProductAssembler($this->context);

        $presenterFactory = new ProductPresenterFactory($this->context);
        $presentationSettings = $presenterFactory->getPresentationSettings();
        $presenter = new ProductListingPresenter(
            new ImageRetriever(
                $this->context->link
            ),
            $this->context->link,
            new PriceFormatter(),
            new ProductColorsRetriever(),
            $this->context->getTranslator()
        );

        $products_for_template = array();

        if (is_array($newProducts)) {
            foreach ($newProducts as $rawProduct) {
                $products_for_template[] = $presenter->present(
                    $presentationSettings,
                    $assembler->assembleProduct($rawProduct),
                    $this->context->language
                );
            }
        }

        return $products_for_template;
    }
}
