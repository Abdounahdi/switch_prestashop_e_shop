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

class CzCouponPopClass extends ObjectModel
{
	public $id_czcouponpop;
	public $cookies_time;
	public $background;
	public $content;
	public $active;
	
	public $temp_url = '{czcouponpop_url}';
	public static $definition = array(
		'table' => 'czcouponpop',
		'primary' => 'id_czcouponpop',
		'multilang' => true,
		'multilang_shop' => true,
		'fields' => array(
			'content' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isString'),
			'background' =>	array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isFileName'),
			'cookies_time'  => 		array('type' => self::TYPE_INT,'shop' => true),
			'active'  => 		array('type' => self::TYPE_BOOL,'shop' => true)
		)
	);
	
	public	function __construct($id = null, $id_lang = null, $id_shop = null)
	{
		parent::__construct($id, $id_lang, $id_shop);
		if ($this->id)
		{
			$languages = Language::getLanguages(false);
			foreach ($languages as $language)
				foreach ($this->fieldsValidateLang as $field => $validation)
				{	
					if (isset($this->{$field}[(int)($language['id_lang'])]))
					{
						$temp = str_replace($this->temp_url, _PS_BASE_URL_.__PS_BASE_URI__, $this->{$field}[(int)($language['id_lang'])]);
						$this->{$field}[(int)($language['id_lang'])] = $temp;
					}
				}
		}
		Shop::addTableAssociation('czcouponpop', array('type' => 'shop'));
		Shop::addTableAssociation('czcouponpop_lang', array('type' => 'fk_shop'));
	}
}
