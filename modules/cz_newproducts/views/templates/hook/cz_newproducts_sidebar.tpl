{*
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

<div id="newproduct_block" class="block products-block">
  	<h4 class="block_title hidden-md-down">
		{l s='New products' mod='cz_newproducts'}
	</h4>
	<h4 class="block_title hidden-lg-up" data-target="#newproduct_block_toggle" data-toggle="collapse">
		{l s='New products' mod='cz_newproducts'}
		<span class="pull-xs-right">
		  <span class="navbar-toggler collapse-icons">
			<i class="fa-icon add"></i>
			<i class="fa-icon remove"></i>
		  </span>
		</span>
	</h4>
	<div id="newproduct_block_toggle" class="block_content  collapse">
		 
		<ul class="products">
			{foreach from=$sidebarProducts item="sidebarProduct"}
				<li class="product_item">
				{include file="catalog/_partials/miniatures/product-sidebar.tpl" product=$sidebarProduct}
				</li>
			{/foreach}	
		</ul>
		 
		<div class="view_more">
			<a class="all-product-link btn btn-primary" href="{$allNewProductsLink}">
				{l s='All new products' mod='cz_newproducts'}
			</a>
		</div>
		
	</div>
</div>

