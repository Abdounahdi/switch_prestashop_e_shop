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

<style>
    {literal}
    #cookie_notice{
		background: #222222;
		padding: 12px;
		text-align: center;
		color: #fff;
		z-index: 99;
		position: fixed;
		width: 100%;
		bottom: 0px;
		right: 0;
		left: 0;
	}
	#cookie_notice a{ 
		text-decoration: underline; 
    	color: #fff;
	}
	#cookie_notice a:hover { 
		text-decoration: none;
	}
    .closeButtonNormal {
        text-align: center;
        padding: 2px 5px;
        border-radius: 2px;
        cursor: pointer;
    }
    #cookieNotice p {
        margin: 0px;
        padding: 0px;
    }
	.cookie-button{
		padding: 4px 13px;
		margin-left: 10px;
		font-size: 13px;
		background: #fff;
		color: #000;
		border-radius: 3px;
	}
	#footer{ margin-bottom: 56px; }
	.top_button{  bottom: 100px; }
    {/literal}
</style>

<div id="cookie_notice" class="global-site-notice cookie_notice" >
	<div class="cookie-inner"><span>{l s='This site uses cookies. By continuing use this site, you are agreeing to our use of cookies.' mod='czuecookie'}</span> 
	{if $cmspageurl}<a href="{$cmspageurl}">{l s='Privacy Policy' mod='czuecookie'}</a>{/if}
	<button class="button btn cookie-button" onclick="closeCookieNotice()">{l s='Accept' mod='czuecookie'}</button></div>
</div>

<script type="text/javascript">
	function setCookie()
	{
		var cookiename = 'cookie_law';
		var cookievalue = '1';
		var expire = new Date();
		expire.setMonth(expire.getMonth()+12);
		document.cookie = cookiename + "=" + escape(cookievalue) +";path=/;" + ((expire==null)?"" : ("; expires=" + expire.toGMTString()))
	}
	function closeCookieNotice()
	{
		$('#cookie_notice').slideUp();
		setCookie();
	} 
</script>
