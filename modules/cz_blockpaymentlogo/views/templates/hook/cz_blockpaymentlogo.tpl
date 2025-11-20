{**
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<!-- Block payment logo module -->
<div id="payement_logo_block_left" class="payement_logo_block">
	{*<div class="title">
		<span class="main-title">{l s='Payment Method' mod='czblockpaymentlogo'}</span>
	</div>*}
	<a href="{$link->getCMSLink($czblockpaymentlogo)}">
		<img class="lazyload" data-src="{$image_url}/carte_bleue.png" alt="carte_bleue" width="37" height="23" />
		<img class="lazyload" data-src="{$image_url}/visa.png" alt="visa" width="37" height="23" />
		<img class="lazyload" data-src="{$image_url}/master_card.png" alt="master_card" width="37" height="23" />
		<img class="lazyload" data-src="{$image_url}/american_express.png" alt="american_express" width="37" height="23" />
		<img class="lazyload" data-src="{$image_url}/paypal.png" alt="paypal" width="37" height="23" />
	</a>
</div>
<!-- /Block payment logo module -->