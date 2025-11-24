{*
* 2007-2017 PrestaShop
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
*  @copyright  2007-2017 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{assign var="current_language_name" value=""}
{foreach from=$languages item=language}
    {if $language.id_lang == $current_language.id_lang}
        {assign var="current_language_name" value=$language.name_simple}
    {/if}
{/foreach}

<div class="dropdown language-selector" id="language-selector">
    <button class="dropdown-toggle">
        <i class="material-icons earth_icon_language_selector_dropdown">public</i>
        <span class="current-language">{$current_language_name}</span>
    </button>
    <div class="dropdown-menu">
        {foreach from=$languages item=language}
            {if $language.id_lang != $current_language.id_lang}
                <a href="{url entity='language' id=$language.id_lang}" class="dropdown-item" data-iso="{$language.iso_code}">
                    <span class="dropdown-label">{$language.name_simple}</span>
                </a>
            {/if}
        {/foreach}
    </div>
</div>

{literal}
    <style>
        .earth_icon_language_selector_dropdown{
            font-size: 16px;
        }
        #language-selector {
            position: relative;
            display: inline-block;
        }
        #language-selector .dropdown-toggle {
            display: flex;
            align-items: center;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 5px 10px;
            color: inherit;
            position: relative;
            z-index: 1;
            cursor: pointer;
            color: #111827;
            justify-content: center;
            gap: 5px;
        }
        #language-selector .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            min-width: 120px;
            width: auto;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            z-index: 10;
            padding: 5px 0;
            border-radius: 4px;
            margin-top: -5px;
            opacity: 0;
            transform: translateY(8px);
        }
        #language-selector:hover .dropdown-menu {
            display: block;
            animation: fadein 0.2s forwards;
        }
        @keyframes fadein {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        #language-selector .dropdown-item {
            display: flex;
            align-items: center;
            padding: 6px 12px;
            text-decoration: none;
            transition: background-color 0.2s;
            white-space: nowrap;
            color: #111827;
            font-size: 14px;
            line-height: 1.2;
        }
        #language-selector .dropdown-item:hover {
            background-color: #f5f5f5;
        }
        #language-selector .dropdown-flag {
            width: 20px;
            height: 15px;
            margin-right: 8px;
            object-fit: cover;
        }
        #language-selector .sicon-flag-wave,
        #language-selector .sicon-keyboard_arrow_down {
            font-size: 16px;
            margin: 0 4px;
        }
    </style>
{/literal}
