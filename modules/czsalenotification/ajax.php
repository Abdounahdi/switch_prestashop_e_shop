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

require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');
include_once(dirname(__FILE__).'/czsalenotification.php');

$module = new Czsalenotification();
$context = Context::getContext();
$id_lang = $context->language->id;

if (Tools::getIsset('action') && Tools::getValue('action') == 'searchProduct') {
	$token = Tools::getValue('token');
	$name = Tools::getValue('name');
	$cz_token = Tools::getAdminToken('AdminDashboard');
	$list_id = Tools::getValue('id_product');

	if ($token != $cz_token) {
		die(Tools::jsonEncode(array(
			'success' => 0,
			'message' => $module->l('Invalid Token')
		)));
	}

	$products = Product::searchByName($id_lang, $name);

	if (!empty($products)) {
		if ($list_id) {
			$array_product = explode(',', $list_id);
		}

		foreach ($products as $key_p => $val_p) {
			$product = new Product((int)$val_p['id_product'], true, $id_lang);
			$products[$key_p]['link'] = $context->link->getProductLink($product);
			$image = Image::getCover((int)$val_p['id_product']);

			$imagePath = $context->link->getImageLink(
				$product->link_rewrite,
				$image['id_image'],
				ImageType::getFormattedName('home')
			);


			$products[$key_p]['image'] = $imagePath;
			$products[$key_p]['image'] = $imagePath;
			$products[$key_p]['price_tax_incl'] = Tools::displayPrice($val_p['price_tax_incl']);
			$products[$key_p]['price_tax_excl'] = Tools::displayPrice($val_p['price_tax_excl']);

			if (isset($array_product)) {
				if (in_array($val_p['id_product'], $array_product)) {
					unset($products[$key_p]);
				}
			}
		}

        $html = $module->displayProductSearch($products);

        die(Tools::jsonEncode(array(
            'success' => 1,
            'message' => $html
        )));
	} else {
		die(Tools::jsonEncode(array(
			'success' => 0,
			'message' => $module->l('No Product'),
		)));
	}
}
