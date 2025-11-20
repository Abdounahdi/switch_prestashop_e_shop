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

<script type="text/javascript">
    var cz_coupon_url = "{$cz_coupon_url|escape:'html':'UTF-8'}";
	var cookies_time = {$newsletter_setting.cookies_time|intval};
</script>

{if $newsletter_setting}
<div id="overlay" style="{if $cookies_time>0}display: none;{/if}" onclick="closeDialog(cookies_time)"></div>
<div id="newsletter-main" class="newsletter-main" style="{if $cookies_time>0}display: none;{/if}">
	<div class="cz-newsletter-popup-close">
		<a class="cz_close" href="javascript:void(0)" onclick="closeDialog(cookies_time)">
			<i class="material-icons clear">&#xe14c;</i>
		</a>

	</div>
	<div class="left-block">
		{if $newsletter_setting.background != ''}
		<div class="cz-newsletter-popup">
			<img src="{$newsletter_setting.background|escape:'html':'UTF-8'}">
		{else}
		<div class="cz-newsletter-popup">
		{/if}
		</div>
	</div>
	<div class="right-block">
	    <div class="inner">
	
			<div class="clearfix newsletter-content">
				{$newsletter_setting.content|escape:'quotes':'UTF-8' nofilter}
			</div>
			<div class="newsletter-form">
				<div class="newsletter-popup-form">
					<div class="input-wrapper">
						<input class="newsletter-input-email" id="newsletter_input_email" id="" type="text" name="email" size="18" placeholder="{l s='Enter your email address...' mod='czcouponpop'}" value="" />
						<a onclick="regisNewsletter()" name="submitNewsletter" class="btn btn-default button">{l s='Subscribe' mod='czcouponpop'}
							<i class="material-icons arrow_forward">&#xe5c8;</i>
						</a>
					</div>
				</div>
				<div id="regisNewsletterMessage"></div>
				
				{if $voucher_code != ''}
				<div class="coupon-side clearfix">
					<div class="coupon-wrapper clearfix">
						<div id="coupon-element" class="coupon" >
							<div class="dashed-border">
								<span id="coupon-text-before"  style="{if $show_voucher == 1}display: none;{else}display: block;{/if}">
								{l s='Your coupon code display here' mod='czcouponpop'}</span>
								<span id="coupon-text-after" style="{if $show_voucher == 1}display: block;{else}display: none;{/if}">{l s='Coupon Code' mod='czcouponpop'}: {$voucher_code|escape:'html':'UTF-8'}</span>
							</div>
						</div>
					</div>
				</div>
				{/if}
				<div class="newsletter-checkbox">                    
					<div class="checkbox">
						<input id="notshow" name="notshow" type="checkbox" value="1">
						{l s='Do not show this popup again' mod='czcouponpop'}
					</div>
				</div>
			</div>
	    </div> 
    </div>   
</div>

<script type="text/javascript">
var regisNewsletterMessage = '{l s='You have subscribled successfully!' mod='czcouponpop' js=1}';
var enterEmail = '{l s='Please enter valid email address!' mod='czcouponpop' js=1}';
</script>
{/if}
{*
<div class="cz-show-newsletter-popup {if $cookies_time>0}open{else}close{/if}">
	<div class="cz-coupon-small">
		<div class="tab-image"></div>
		<div class="shears-small"></div>
		<div class="dashes-d"></div>
		<div class="dashes-b"></div>
		<div class="share-coupon-small-wrapper"><a href="javascript: void(0)"><span>{l s='Discount' mod='czcouponpop'}</span></a></div>
	</div>
</div>
*}