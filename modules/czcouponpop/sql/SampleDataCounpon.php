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

class SampleDataCounpon
{
	public function initData()
	{
		$return = true;
		$languages = Language::getLanguages(true);
		$id_shop = Configuration::get('PS_SHOP_DEFAULT');
		
		$return &= Db::getInstance()->Execute('INSERT IGNORE INTO `'._DB_PREFIX_.'czcouponpop` (`id_czcouponpop`, `cookies_time`, `active`) VALUES 
		(1, 12, 1);
		');
		
		$return &= Db::getInstance()->Execute('INSERT IGNORE INTO `'._DB_PREFIX_.'czcouponpop_shop` (`id_czcouponpop`, `id_shop`, `cookies_time`, `active`) VALUES 
		(1, "'.$id_shop.'", 12, 1);
		');
		
		$text = '<div class="innerbox-newsletter"><h3 class="newsletter_title">Subscribe Newsletter!</h3><div class="newsletter-text"><p>Subscribe to our latest newsletter to get news about special discounts and upcoming sales.</p></div></div>';
		
		foreach ($languages as $language)
		{
			$return &= Db::getInstance()->Execute('INSERT IGNORE INTO `'._DB_PREFIX_.'czcouponpop_lang` (`id_czcouponpop`, `id_shop`, `id_lang`, `content`, `background`) VALUES 
			(1, "'.$id_shop.'", "'.$language['id_lang'].'", \''.$text.'\', "newsletter_banner.jpg");
			');
		}
		return $return;
	}
}
?>