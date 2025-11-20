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

if (!defined('_PS_VERSION_'))
	exit;

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class Cz_Blockpaymentlogo extends  Module implements WidgetInterface
{
	private $templateFile;
	
	public function __construct()
	{
		$this->name = 'cz_blockpaymentlogo';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'Codezeel';
		$this->need_instance = 0;

		$this->bootstrap = true;
		parent::__construct();

		$this->displayName = $this->l('CZ - Payment logos block');
		$this->description = $this->l('Adds a block which displays all of your payment logos.');
		
		$this->ps_versions_compliancy = array('min' => '1.7.0.0', 'max' => _PS_VERSION_);

        $this->templateFile = 'module:cz_blockpaymentlogo/views/templates/hook/cz_blockpaymentlogo.tpl';
	}

	public function install()
	{
		Configuration::updateValue('CZ_PAYMENT_LOGO_CMS_ID', 1);
		return  parent::install() &&
			$this->registerHook('displayHeader') && 
			$this->registerHook('displayFooterAfter');
	}

	public function uninstall()
	{
		Configuration::deleteByName('CZ_PAYMENT_LOGO_CMS_ID');
		return parent::uninstall();
	}

	public function getContent()
	{
		$html = '';

		if (Tools::isSubmit('savecz_blockpaymentlogo'))
			if (Validate::isUnsignedInt(Tools::getValue('CZ_PAYMENT_LOGO_CMS_ID')))
			{
				Configuration::updateValue('CZ_PAYMENT_LOGO_CMS_ID', (int)(Tools::getValue('CZ_PAYMENT_LOGO_CMS_ID')));
				$this->_clearCache($this->templateFile);
				$html .= $this->displayConfirmation($this->l('The settings have been updated.'));
			}

		$cmss = CMS::listCms($this->context->language->id);

		if (!count($cmss))
			$html .= $this->displayError($this->l('No CMS page is available.'));
		else
			$html .= $this->renderForm();

		return $html;
	}

	public function renderForm()
	{
		$fields_form = array(
			'form' => array(
				'legend' => array(
					'title' => $this->getTranslator()->trans('Settings', array(), 'Admin.Global'),
					'icon' => 'icon-cogs'
				),
				'input' => array(
					array(
						'type' => 'select',
						'label' => $this->getTranslator()->trans('Destination page for the block\'s link', array(), 'Modules.BlockPaymentLogo'),
						'name' => 'CZ_PAYMENT_LOGO_CMS_ID',
						'required' => false,
						'default_value' => (int)$this->context->country->id,
						'options' => array(
							'query' => CMS::listCms($this->context->language->id),
							'id' => 'id_cms',
							'name' => 'meta_title'
						)
					),
				),
				'submit' => array(
					'title' => $this->getTranslator()->trans('Save', array(), 'Admin.Actions'),
				)
			),
		);

		$helper = new HelperForm();
		$helper->show_toolbar = false;
		$helper->table =  $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'savecz_blockpaymentlogo';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
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
			'CZ_PAYMENT_LOGO_CMS_ID' => Tools::getValue('CZ_PAYMENT_LOGO_CMS_ID', Configuration::get('CZ_PAYMENT_LOGO_CMS_ID')),
		);
	}
	
	public function renderWidget($hookName = null, array $configuration = [])
    {
        if (!$this->isCached($this->templateFile, $this->getCacheId('cz_blockpaymentlogo'))) {
            $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        }

        return $this->fetch($this->templateFile, $this->getCacheId('cz_blockpaymentlogo'));
    }
	
	public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        if (Configuration::get('PS_CATALOG_MODE'))
			return;
		
		if (!Configuration::get('CZ_PAYMENT_LOGO_CMS_ID'))
				return;
		
		$cms = new CMS(Configuration::get('CZ_PAYMENT_LOGO_CMS_ID'), $this->context->language->id);
		if (!Validate::isLoadedObject($cms))
			return;
		
		return array(
            'czblockpaymentlogo' => $cms,
			'image_url' => $this->context->link->getMediaLink(_MODULE_DIR_.'cz_blockpaymentlogo/views/img'),
        );
    }

}


