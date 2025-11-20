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

<section class="featured-products czfeatured clearfix">
<div class="container">
		<h2 class="h1 products-section-title text-uppercase">
			{l s='Featured products' mod='cz_featuredproducts'}
		</h2>
	<div class="featured-products-wrapper">
		<div class="products">			
			{assign var='sliderFor' value= 3} <!-- Define Number of product for SLIDER -->
			{if $slider == 1 && $no_prod >= $sliderFor}
				<div class="feature-double-slide">
					<ul id="feature-carousel" class="cz-carousel product_list">
						{assign var='featureCount' value=0}
						{assign var='featureTotalCount' value=0}
						{foreach from=$products item=product name=czFeatureProducts}
							{$featureTotalCount = $featureCount++}
						{/foreach}
						
						{if $featureCount > 4 && $slider == 1}
							{foreach from=$products item="product" name=czFeatureProducts}
								{if $smarty.foreach.czFeatureProducts.index % 2 == 0} 
									<li class="double-slideitem">
										<ul>
										   {/if}	
										   <li class="item">
											  {include file="catalog/_partials/miniatures/product-featured.tpl" product=$product}
										   </li>
										   {if $smarty.foreach.czFeatureProducts.index % 2 != 0} 
										</ul>
									</li>
								{/if}
							{/foreach}
						{/if}
					</ul>
				</div>
				
				<div class="customNavigation">
					<a class="btn prev feature_prev">&nbsp;</a>
					<a class="btn next feature_next">&nbsp;</a>
				</div>
			{else}
				<ul id="feature-grid" class="feature_grid product_list grid row gridcount">
					{foreach from=$products item="product"}
						<li class="product_item col-xs-12 col-sm-6 col-md-4 col-lg-3">
							{include file="catalog/_partials/miniatures/product-featured.tpl" product=$product}
						</li>
					{/foreach}
				</ul>
				<div class="view_more">
					<a class="btn btn-primary" href="{$allProductsLink}">
						{l s='All products' mod='cz_featuredproducts'}
					</a>
				</div>
			{/if}
		</div>
		</div>
	</div>
</div>
</section>