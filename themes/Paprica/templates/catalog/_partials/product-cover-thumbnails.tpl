{**
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
 *}
<div class="images-container js-images-container">
  {block name='product_cover'}
    <div class="product-cover">
        {if $product.default_image}
    	      <img class="js-qv-product-cover img-fluid zoom-product" 
              src="{$product.default_image.bySize.medium_default.url}" 
              {if !empty($product.default_image.legend)}
                alt="{$product.default_image.legend}"
                title="{$product.default_image.legend}"
              {else}
                alt="{$product.name}"
              {/if}
              loading="lazy" 
              style="width:100%;"
              data-zoom-image="{$product.default_image.bySize.large_default.url}"
            />
           <div class="layer" data-toggle="modal" data-target="#product-modal">
                <i class="fa fa-arrows-alt zoom-in"></i>
           </div>
        {else}
            <img  class="img-fluid zoom-product" 
                src="{$urls.no_picture_image.bySize.large_default.url}" 
                loading="lazy"
                style="width:100%;"
                data-zoom-image="{$urls.no_picture_image.bySize.large_default.url}"
            />
        {/if}
    </div>
  {/block}

  {block name='product_images'}
	{assign var='sliderFor' value=1} <!-- Define Number of product for SLIDER -->
	{assign var='thumbCount' value=count($product.images)}
	
	<div class="js-qv-mask mask {if $thumbCount >= $sliderFor}additional_slider{else}additional_grid{/if}">		
		{if $thumbCount >= $sliderFor}
			<ul class="cz-carousel product_list additional-carousel additional-image-slider">
		{else}
			<ul class="product_list grid row gridcount additional-image-slider">
		{/if}
	
		{foreach from=$product.images item=image}
         <li class="thumb-container js-thumb-container {if $thumbCount >= $sliderFor}item{else}product_item col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-3{/if}">
            <a href="javaScript:void(0)" class="elevatezoom-gallery" 
              data-image="{$image.bySize.medium_default.url}" 
              data-zoom-image="{$image.bySize.large_default.url}">
              <img
                class="thumb js-thumb {if $image.id_image == $product.default_image.id_image} selected js-thumb-selected{/if}"
                data-image-medium-src="{$image.bySize.medium_default.url}"
                data-image-large-src="{$image.bySize.large_default.url}"
                src="{$image.bySize.home_default.url}"
                {if !empty($image.legend)}
                alt="{$image.legend}"
                title="{$image.legend}"
              {else}
                alt="{$product.name}"
              {/if}
              loading="lazy"
              width="106"
              >
            </a>
          </li>
        {/foreach}
      </ul>
	  
	  {if $thumbCount >= $sliderFor}
		<div class="customNavigation">
			<a class="btn prev additional_prev">&nbsp;</a>
			<a class="btn next additional_next">&nbsp;</a>
		</div>
	  {/if}
	  
    </div>
  {/block}
</div>
{hook h='displayAfterProductThumbs' product=$product}