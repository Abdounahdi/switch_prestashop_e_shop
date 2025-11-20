{**
 * 2007-2018 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
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
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2018 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
{extends file='page.tpl'}

{block name='page_content_container'}
<section id="content" class="page-home">
	<div class="display-top-inner">
	  <div class="container">
			{block name='page_content_top'}{/block}
			{hook h='displayTopColumn'}
	  </div>
	</div>
	
{*	<section class="cz-hometabcontent">
		<div class="container"> 
				<h2 class="h1 products-section-title text-uppercase">{l s="New Products" d='Shop.Theme.Global'}</h2>
				<div class="tabs">
					<ul id="home-page-tabs" class="nav nav-tabs clearfix">
						<li class="nav-item">
							<a data-toggle="tab" href="#featureProduct" class="nav-link active" data-text="{l s='Featured' d='Shop.Theme.Global'}">
								<span>{l s='Featured' d='Shop.Theme.Global'}</span>
							</a>
						</li>
						<li class="nav-item">
							<a data-toggle="tab" href="#newProduct" class="nav-link" data-text="{l s='Latest' d='Shop.Theme.Global'}">
								<span>{l s='Latest' d='Shop.Theme.Global'}</span>
							</a>
						</li>
						<li class="nav-item">
							<a data-toggle="tab" href="#bestseller" class="nav-link" data-text="{l s='Best Sellers' d='Shop.Theme.Global'}">
								<span>{l s='Best Sellers' d='Shop.Theme.Global'}</span>
							</a>
						</li>
					</ul>
					<div class="tab-content">
						<div id="featureProduct" class="cz_productinner tab-pane active">	
							{hook h='displayCzFeature'}
						</div>
						<div id="newProduct" class="cz_productinner tab-pane">
							{hook h='displayCzNew'}
						</div>
						<div id="bestseller" class="cz_productinner tab-pane">
							{hook h='displayCzBestseller'}
						</div>
					</div>					
				</div>
		</div>
	</section>
	*}
	{block name='page_content'}
	  	{block name='hook_home'}
			{$HOOK_HOME nofilter}
		{/block}
	{/block}
	
</section>
{/block}
