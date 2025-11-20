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

if (!defined('_PS_VERSION_')){
	exit;
}

class CzUeCookie extends Module {

	public function __construct() {
		$this->name = 'czuecookie';
		$this->tab = 'front_office_features';
		$this->version = '1.0.0';
		$this->author = 'Codezeel';
		$this->bootstrap = true;
		parent::__construct();
		$this->displayName = $this->trans('CZ - Cookies Law');
		$this->description = $this->trans('This module displays a nice information about Cookies in your shop');
		$this->ps_versions_compliancy = array('min' => '1.7.0.0', 'max' => _PS_VERSION_);
		$this->templateFile = 'module:czuecookie/views/templates/hook/czuecookie.tpl';
	}

	public function install() {
		Configuration::updateValue('CZ_COOKIE_LAW_CMS_ID', 2);
		return  parent::install() &&
			$this->registerHook('displayFooter');
	}

	public function uninstall()
	{
		Configuration::deleteByName('CZ_COOKIE_LAW_CMS_ID');
		return parent::uninstall();
	}

	public function getContent()
	{
		$html = '';

		if (Tools::isSubmit('saveczuecookie'))
			if (Validate::isUnsignedInt(Tools::getValue('CZ_COOKIE_LAW_CMS_ID')))
			{
				Configuration::updateValue('CZ_COOKIE_LAW_CMS_ID', (int)(Tools::getValue('CZ_COOKIE_LAW_CMS_ID')));
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
						'label' => $this->getTranslator()->trans('Select page for Privacy Policy link', array(), 'Modules.CzUeCookie'),
						'name' => 'CZ_COOKIE_LAW_CMS_ID',
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
		$helper->submit_action = 'saveczuecookie';
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
			'CZ_COOKIE_LAW_CMS_ID' => Tools::getValue('CZ_COOKIE_LAW_CMS_ID', Configuration::get('CZ_COOKIE_LAW_CMS_ID')),
		);
	}

	public function hookDisplayFooter($params) {
		$cms = new CMS(Configuration::get('CZ_COOKIE_LAW_CMS_ID'), $this->context->language->id);
		
		if (Validate::isLoadedObject($cms)){
			$pageurl = $this->context->link->getCMSLink($cms);
		} else {
			$pageurl = '';
		}
		
		$this->context->smarty->assign(array(
			'cmspageurl' => $pageurl
		));

		if (!isset($_COOKIE['cookie_law'])){
			return $this->fetch($this->templateFile, $this->getCacheId('czuecookie'));
		}
	}
}
?>