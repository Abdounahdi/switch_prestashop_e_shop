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
{assign var="contact_vars" value=Module::getInstanceByName('ps_contactinfo')->getWidgetVariables()}
{assign var="contact_infos" value=$contact_vars.contact_infos}
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

{* {block name='header_top'}
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
{/block} *}

{block name='header_top'}
	<div class="header-top">
		<div class="container">
			{hook h="displayNav2"}
			<div>
              <i class="fa fa-envelope-o"></i>
               {if isset($contact_infos.email) && $contact_infos.email}
					{mailto address=$contact_infos.email encode="javascript"}
				{/if}
            </div>
		</div>
   </div>	
{/block}

<div class="header-top-inner">
	<div class="container">
		<div class="menu_logo_container">
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
                <a href="{$urls.pages.index}">
                  <img class="logo img-responsive" src="{$shop.logo}" alt="{$shop.name}" loading="lazy">
                </a>
		</div>
		<div class="header_items_container">
			{hook h='displayNavFullWidth'}
			{hook h="displayTop"}
		</div>
	</div>
</div>

<script>
// faced a problem with the div positions that i couldn't fix with just changing hooks 
// this js waits 0.1s for the dom to load and change header items placemenet 
document.addEventListener("DOMContentLoaded", function () {
	if (window.innerWidth < 991) return;

	setTimeout(() => {
		
		 const container = document.querySelector(".header_items_container");
		if (!container) return;

		const leftWrapper = document.createElement("div");
		leftWrapper.classList.add("header-nav-left");

		const rightWrapper = document.createElement("div");
		rightWrapper.classList.add("header-nav-right");

		// Add wrappers
		container.insertBefore(leftWrapper, container.firstChild);
		container.appendChild(rightWrapper);

		// Select elements from inside container
		const searchWidget = container.querySelector("#search_widget");
		const userInfo = container.querySelector(".user-info");
		const desktopCart = container.querySelector("#desktop_cart");

		// Append to right wrapper in the correct order
		if (searchWidget) rightWrapper.appendChild(searchWidget);
		if (userInfo) rightWrapper.appendChild(userInfo);
		if (desktopCart) rightWrapper.appendChild(desktopCart);

		// Move everything else to LEFT wrapper
		Array.from(container.children).forEach(child => {
			if (child !== leftWrapper && child !== rightWrapper && !rightWrapper.contains(child)) {
				leftWrapper.appendChild(child);
			}
		});
	}, 100);
});
</script>