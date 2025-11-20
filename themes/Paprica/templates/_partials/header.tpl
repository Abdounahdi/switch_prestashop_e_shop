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
{block name='header_banner'}
  <div class="header-banner">
    {hook h='displayBanner'}
  </div>
{/block}

{block name='header_nav'}
<nav class="header-nav">
	<div class="container">
        
		{*<div class="hidden-sm-down">*}
			<div class="left-nav">
				{hook h='displayNav1'}
			</div>
			
			<div class="right-nav">
				{hook h='displayNav2'}
			</div>
		{*</div>*}
		
		{*<div class="hidden-md-up text-xs-center mobile">
			<div class="pull-xs-left" id="menu-icon">
				<i class="material-icons menu-open">&#xE5D2;</i>
				<i class="material-icons menu-close">&#xE5CD;</i>			  
			</div>
			<div class="pull-xs-right" id="_mobile_cart"></div>
			<div class="pull-xs-right" id="_mobile_user_info"></div>
			<div class="top-logo" id="_mobile_logo"></div>
			<div class="clearfix"></div>
		</div> *}
        
	</div>
</nav>
{/block}

{block name='header_top'}
	<div class="header-top">
		<div class="container">
			<div class="header_logo">
				{if $page.page_name == 'index'}
              <h1>
                <a href="{$urls.pages.index}">
                  <img class="logo img-responsive" src="{$shop.logo}" alt="{$shop.name}" loading="lazy">
                </a>
              </h1>
            {else}
                <a href="{$urls.pages.index}">
                  <img class="logo img-responsive" src="{$shop.logo}" alt="{$shop.name}" loading="lazy">
                </a>
            {/if}
			</div>
		    <div class="text-xs-left mobile hidden-lg-up mobile-menu">
				<div class="menu-icon">
					<div class="cat-title">{l s='Menu' d='Shop.Theme.Global'}</div>		  
				</div>
				
				<div id="mobile_top_menu_wrapper" class="row hidden-lg-up">
					<div class="mobile-menu-inner">
						<div class="menu-icon">
							<div class="cat-title">{l s='Menu' d='Shop.Theme.Global'}</div>		  
						</div>
				
				        <div class="js-top-menu mobile" id="_mobile_top_menu"></div>
						<div class="js-top-menu mobile" id="_mobile_main_menu"></div>
					</div>
				</div>
			</div>
			{hook h='displayTop'}					
		</div>
   </div>	
{/block}
<div class="header-top-inner">
	<div class="container">
		{hook h='displayNavFullWidth'}
	</div>
</div>