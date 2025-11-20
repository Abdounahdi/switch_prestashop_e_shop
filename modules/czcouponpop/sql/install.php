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


$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'czcouponpop` (
	`id_czcouponpop` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`cookies_time` int(11) NOT NULL DEFAULT \'12\',
	`active` tinyint(1) NOT NULL DEFAULT \'1\',
    PRIMARY KEY  (`id_czcouponpop`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'czcouponpop_shop` (
	`id_czcouponpop` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `id_shop` int(11) NOT NULL,
	`cookies_time` int(11) NOT NULL DEFAULT \'12\',
	`active` tinyint(1) NOT NULL DEFAULT \'1\',
    PRIMARY KEY  (`id_czcouponpop`, `id_shop`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'czcouponpop_lang` (
	`id_czcouponpop` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `id_shop` int(11) NOT NULL,
    `id_lang` int(11) NOT NULL,
	`content` text COLLATE utf8_unicode_ci NOT NULL,
	`background` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
    PRIMARY KEY  (`id_czcouponpop`, `id_shop`, `id_lang`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;';

foreach ($sql as $query)
	if (Db::getInstance()->execute($query) == false)
		return false;
