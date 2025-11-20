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
<div class="product-variants js-product-variants">
    <div class="product-attributes js-product-attributes">
        {if isset($product_manufacturer->id)}
          <div class="product-manufacturer">
            <label class="label">{l s='Brand' d='Shop.Theme.Catalog'}: </label>
            <span> <a href="{$product_brand_url}">{$product_manufacturer->name}</a></span>
            
            {if isset($manufacturer_image_url)}
              <div class="manufacturer_image">
                <a href="{$product_brand_url}">
                    <img src="{$manufacturer_image_url}" class="img img-thumbnail manufacturer-logo" alt="{$product_manufacturer->name}" loading="lazy">
                </a>
              </div>
            {/if}
          </div>
        {/if}

        {block name='product_condition'}
          {if $product.condition}
          <div class="product-condition">
            <label class="label">{l s='Condition' d='Shop.Theme.Catalog'}: </label>
            <link itemprop="itemCondition" href="{$product.condition.schema_url}"/>
            <span>{$product.condition.label}</span>
          </div>
          {/if}
        {/block} 

        {block name='product_reference'}
            {if isset($product.reference_to_display) && $product.reference_to_display neq ''}
            <div class="product-reference">
            <label class="label">{l s='Reference' d='Shop.Theme.Catalog'}: </label>
              <span itemprop="sku">{$product.reference_to_display}</span>
            </div>
          {/if}
        {/block}

      {block name='product_quantities'}
        {if $product.show_quantities}
          <div class="product-quantities">
            <label class="label">{l s='Available In Stock: ' d='Shop.Theme.Catalog'}</label>
            <span data-stock="{$product.quantity}" data-allow-oosp="{$product.allow_oosp}">{$product.quantity} {$product.quantity_label}</span>
          </div>
        {/if}
      {/block}

      <div class="qtyprogress">
          {if $product.quantity > 0}
            {l s='Hurry up! only' d='Shop.Theme.Global'}<strong class="quantity"> {$product.quantity} </strong>{l s='items left in stock!' d='Shop.Theme.Global'}
          {else}
            {l s='Sorry, This item is out of stock.' d='Shop.Theme.Global'}
          {/if}
           <div class="progress">
            <div class="progress-bar" role="progressbar"></div>
        </div>
      </div>                  
    {hook h='PSProductCountdown' id_product=$product.id_product}  
    </div>

  {foreach from=$groups key=id_attribute_group item=group}
    {if !empty($group.attributes)}
    <div class="clearfix product-variants-item">
      <span class="control-label">{$group.name}{l s=': ' d='Shop.Theme.Catalog'}
          {foreach from=$group.attributes key=id_attribute item=group_attribute}
            {if $group_attribute.selected}{$group_attribute.name}{/if}
          {/foreach}
      </span>
      {if $group.group_type == 'select'}
        <select
          class="form-control form-control-select"
          id="group_{$id_attribute_group}"
          aria-label="{$group.name}"
          data-product-attribute="{$id_attribute_group}"
          name="group[{$id_attribute_group}]">
          {foreach from=$group.attributes key=id_attribute item=group_attribute}
            <option value="{$id_attribute}" title="{$group_attribute.name}"{if $group_attribute.selected} selected="selected"{/if}>{$group_attribute.name}</option>
          {/foreach}
        </select>
      {elseif $group.group_type == 'color'}
        <ul id="group_{$id_attribute_group}">
          {foreach from=$group.attributes key=id_attribute item=group_attribute}
            <li class="pull-xs-left input-container">
              <input class="input-color" type="radio" data-product-attribute="{$id_attribute_group}" name="group[{$id_attribute_group}]" value="{$id_attribute}" title="{$group_attribute.name}"{if $group_attribute.selected} checked="checked"{/if}>
              <span
                  {if $group_attribute.texture}
                    class="color texture" style="background-image: url({$group_attribute.texture})"
                  {elseif $group_attribute.html_color_code}
                    class="color" style="background-color: {$group_attribute.html_color_code}"
                  {/if}
                ><span class="attribute-name sr-only">{$group_attribute.name}</span></span>
            </li>
          {/foreach}
        </ul>
      {elseif $group.group_type == 'radio'}
        <ul id="group_{$id_attribute_group}">
          {foreach from=$group.attributes key=id_attribute item=group_attribute}
            <li class="input-container pull-xs-left">
              <input class="input-radio" type="radio" data-product-attribute="{$id_attribute_group}" name="group[{$id_attribute_group}]" value="{$id_attribute}"{if $group_attribute.selected} checked="checked"{/if}>
              <span class="radio-label">{$group_attribute.name}</span>
            </li>
          {/foreach}
        </ul>
      {/if}
    </div>
   {/if}
  {/foreach}
</div>
