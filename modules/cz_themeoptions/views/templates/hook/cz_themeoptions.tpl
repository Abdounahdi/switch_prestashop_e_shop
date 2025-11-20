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

<style type="text/css">

:root {
  --primary-color:{$CZPRIMARY_COLOR};
  --secondary-color:{$CZSECONDARY_COLOR};
  --price-color:{$CZPRICE_COLOR};
  --link-hover-color:{$CZLINKHOVER_COLOR};
  --box-bodybkg-color:{$CZBOX_BODYBKG_COLOR};
  --border-radius:{if ($CZBORDER_RADIUS == 1)}5px{else}0px{/if};
  --body-font-family:{$body_fontfamily};
  --title-font-family:{$title_fontfamily};
  --banner-font-family:{$banner_fontfamily};
  --body-font-size:{$CZBODY_FONT_SIZE};
}

body, .top-menu a[data-depth="0"], .btn{
    font-family: var(--body-font-family), Arial, Helvetica, sans-serif;
}

.flexslider .slides li .slide_content .headdings .sub_title,
.products-section-title, .block_newsletter .title, 
.footer-container .links .h3, .footer-container .links h3, .footer-container .links h3 a, 
#main > h1, #main h2.h2, #main .page-header h1, .block-category h1, 
#left-column .block .block_title, #right-column .block .block_title,
.breadcrumb .container h1,  .homeblog-latest .products-section-title,
#header .blockcart .cart_block .toggle-title,
#czverticalmenublock .block_title, .subcategory-heading,
#search_filters .facet .facet-title{
    font-family: var(--title-font-family), Arial, Helvetica, sans-serif;
}
 
.flexslider .slides li .slide_content,
#czsubbannercmsblock .subbanners .one-half .subbanner .banner-detail .title,
#czoffercmsblock .offer-title,
#czbannercmsblock .cmsbanners .one-half .cmsbanner-inner .cmsbanner .cmsbanner-text .main-title
{
    font-family: var(--banner-font-family), Arial, Helvetica, sans-serif;
} 
 
{if isset($CZBOX_LAYOUT)}
    body.box_layout{
        background-color: var(--box-bodybkg-color);
        {if isset($CZBOX_BGIMG) && $CZBOX_BGIMG != ''}
            background-image: url({$image_dir_url}{$CZBOX_BGIMG});
            {if $CZBOX_BGIMG_STYLE == 'repeat'}
                background-repeat: repeat;
            {else if $CZBOX_BGIMG_STYLE == 'strech'}
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-position: top center;
            {/if}
        {/if}
     }
{/if}

body, .product-title a, .top-menu a[data-depth="0"],
#subcategories ul li .subcategory-name{
    font-size: var(--body-font-size);
}

.product-cover .layer .zoom-in,
#czservicecmsblock .service_container .service-area .service-third:hover .service-icon,
.header-top .vertical-menu .nav-trigger,
.top_button,
.blog-image .blogicons .icon:hover::before,
.btn-primary, .btn-secondary:hover, .btn-tertiary:hover,
#header .header-nav, .pagination .current a,
.pagination a:hover, .input-group .input-group-btn > .btn:hover, 
.pagination li.disabled > span, .pagination li:hover > span, .pagination li.current > span,
#czverticalmenublock .block_title,
.flex-direction-nav a, #czservicecmsblock .service_container .service-area .service-fourth:hover .service-icon, #header .logo_text .icon,
#blockcart-modal .cart-content button:hover, 
 #header .blockcart .blockcart-header > .shopping-cart:hover > .icon, #header .user-info .user-info-title:hover .user-icon,
 .products .all-product-link, #header .search-widget .search_button:hover, #category #search_filter_toggler,
 .move-wishlist-item:hover, #header #czwelcomecmsblock,
 #header .search-widget .search_button.active:hover, .active_filters .filter-block,
#czheadercmsblock .header-cms:hover::before, #header .user-info .user-info-title:hover::before, #czverticalmenublock .block_content, 
.products .product_list li .wishlist, .products .product_list li .compare, .products .product_list li .outer-functional .functional-buttons .quick-view-btn,
.products .product_list li .product-actions, .special-products .products .product_list li .btn.add-to-cart,
.special-products .products .product_list li .product-actions .btn.add-to-cart.view_page,
#cztestimonialcmsblock .testimonial_container .testimonial-area ul#testimonial-carousel li.item .quote_img,
#cztestimonialcmsblock .customNavigation a:hover, .block_newsletter form input.btn,
.products-sort-order .select-list:hover,.products .product_list.list li .btn.add-to-cart, 
#products .products .product_list.list li .center-block .view_page, .tabs .nav-tabs .nav-link.active, .tabs .nav-tabs .nav-link.active:hover,
.search-widget form button[type="submit"], #czoffercmsblock .offercmsdetail, .products li .product-miniature .product-flags li.new, .customNavigation a:hover,
#product .pp-right-column .product-actions .input-radio:checked + span, #product .pp-right-column .product-actions .input-radio:hover + span,
.products li.product_item .product-miniature .product-flags li.new, .products li.item .product-miniature .product-flags li.new,
.block_newsletter form input.btn-primary:disabled:hover,
.product-miniature .thumbnail-container .wishlist .dropdown .dropdown-menu .wishlist-item.added,
 .product-miniature .thumbnail-container .wishlist .dropdown .dropdown-menu .wishlist-item.added:hover,
 .product-miniature .thumbnail-container .wishlist .dropdown .dropdown-menu .wishlist-item:hover, 
 .product-miniature .thumbnail-container .wishlist .dropdown .dropdown-menu .move-wishlist-item:hover,
 #product .pp-right-column .product-actions .wish_comp .wishlist .dropdown .dropdown-menu .move-wishlist-item:hover,
 #product .pp-right-column .product-actions .wish_comp .wishlist .dropdown .dropdown-menu .wishlist-item:hover,
 #product .pp-right-column .product-actions .wish_comp .wishlist .dropdown .dropdown-menu .wishlist-item.added,
 #product .pp-right-column .product-actions .wish_comp .wishlist .dropdown .dropdown-menu .wishlist-item.added:hover
#product #content .product-leftside .product-flags li.new, .tabs .nav-tabs .nav-link:hover, .tabs .nav-tabs .nav-link.active,
#product #content .product-leftside .product-flags li.new
{
    background-color: var(--primary-color);
    color: var(--secondary-color);
}

@media(min-width: 992px){
    #header .search-widget form button[type="submit"],
    #header .blockcart .blockcart-header > .shopping-cart > .icon:hover,
    #header .blockcart .blockcart-header > .shopping-cart   
    {
        background-color: var(--primary-color);
        color: var(--secondary-color);
    }
}

#czoffercmsblock .offercms-text .shopnow .btn-primary{
    background-color: var(--secondary-color);
}

#czbannercmsblock .cmsbanners .one-half .cmsbanner .cmsbanner-text .view_more .btn.btn-primary, 
#czbannercmsblock1 .cmsbanners1 .one-half .cmsbanner .cmsbanner-text .view_more .btn-primary,
.page-my-account #content .links a:hover i,
#czservicecmsblock .service_container .service-area .service-fourth:hover .service-content .service-heading, 
#czsubbannercmsblock .subbanners .one-third .subbanner .subbanner-text .view_more .btn.btn-primary,
.promo-discounts .cart-summary-line .label .code, #contact-rich .block_content .icon i,
#cztestimonialcmsblock .testimonial_container .testimonial-area ul#testimonial-carousel li.item .product_inner_cms a,
.featured-products.czfeatured .products .product_list li .btn.add-to-cart,
.cart-grid-right .promo-discounts .cart-summary-line .label .code,
.product-line-grid .cart-line-product-actions a:hover i,
.page-my-account #content .links a:hover i
{
    color: var(--primary-color);
}

body#checkout section.checkout-step.-reachable.-complete h1 .step-edit:hover,
body#checkout section.checkout-step .delete-address:hover, 
body#checkout section.checkout-step .edit-address:hover{
    color: var(--primary-color) !important;
}

#header .blockcart .blockcart-header > .shopping-cart::before,
.products .product-miniature a.st-wishlist-button,
.products .product_list li .compare a,
.products .product_list li .quick-view,
.products .product_list li .btn.add-to-cart
{
    background-color: var(--secondary-color);
}

.flex-control-paging li a:hover, .flex-control-paging li a.flex-active,
.czcategoryimagelist .owl-controls .owl-page:hover span, 
.czcategoryimagelist .owl-controls .owl-page.active span{
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.homeblog-latest .blog-item .blog-meta > span, 
.secondary-blog .blog-item .blog-meta > span{
    border-color: var(--secondary-color);
}

{*
.input-group .input-group-btn > .btn:hover, 
.btn-primary:hover, .btn-secondary, .btn-tertiary, .search-widget form button[type=submit]:hover{
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    opacity: .80;
}*}
.btn-primary:focus, .btn-primary.focus,
.btn-secondary:hover, .btn-tertiary:hover{
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    opacity: 1;
}



.btn-primary,  #subcategories ul li .subcategory-image a:hover,
.pagination li.disabled > span, .pagination li:hover > span, .pagination li.current > span, 
.pagination .current a, .pagination a:hover,
.input-radio:checked + span, .input-radio:hover + span,
.blog-image .blogicons .icon:hover::before, 
.images-container .js-qv-mask .thumb-container .thumb.selected, 
.images-container .js-qv-mask .thumb-container .thumb:hover,
#product-modal .modal-content .modal-body .product-images img:hover, 
#product-modal .modal-content .modal-body .product-images .thumb.js-modal-thumb.selected,
.page-my-account #content .links a:hover span.link-item,
.vertical-menu .sub-menu .top-menu .collapse, .products .all-product-link,
#header ul.dropdown-menu, .special-products .pspc-main, #header .cart_block, #blockcart-modal .cart-content button:hover,
#cz_toplink, #header .search-widget form input[type="text"], .block-promo .promo-input, .block_newsletter form input.btn,
.top_button::after, 
.products .product_list.list li .btn.add-to-cart, #products .products .product_list.list li .center-block .view_page, 
.input-group .input-group-btn > .btn:hover,
#product .pp-right-column .product-actions .input-radio:checked + span, #product .pp-right-column .product-actions .input-radio:hover + span,
.block_newsletter form input.btn-primary:disabled:hover
{
    border-color: var(--primary-color);
}

.flex-direction-nav a:before,
#czoffercmsblock .offercms-text
{
    border-color: var(--secondary-color);
}

#header .header-nav, .footer-after a,
#header .header-nav .expand-more,
#footer .block_newsletter .psgdpr_consent_message, 
.footer-after a, .footer-after a:hover,
.block-social li a::before,  #links_block_top #cz_toplink li a, .flex-direction-nav a::before,
.vertical-menu .top-menu li a[data-depth="0"],
 #czverticalmenublock .block_title .dropdown-arrow::before,
#czoffercmsblock .offercms-text, .customNavigation a:hover::before
{
    color: var(--secondary-color);
}


.products .product-price-and-shipping, 
.product-price, .cart-summary-line .value, 
.product-line-grid-right .cart-line-product-actions strong, 
.product-line-grid-right .product-price strong{
    color: var(--price-color);
}

a:focus, a:hover, .product-title a:hover, .breadcrumb li a:hover::before,
#header ul.dropdown-menu li a:hover, #header ul.dropdown-menu li.current a,
.top-menu a[data-depth="0"]:hover,
.top-menu .sub-menu li > a.dropdown-submenu:hover, .top-menu .sub-menu a:hover,
.header-top .menu #manufacturers .sub-menu .top-menu > li a.dropdown-submenu:hover,
.nav-item .nav-link.active, .nav-item .nav-separtor.active,
 #left-column .products-block .view_more a, #right-column .products-block .view_more a,
.special-products .products .product-title a:hover, 
.header-top-inner .menu #manufacturers .sub-menu .top-menu > li a.dropdown-submenu:hover,
.header-top-inner .menu .sub-menu.megamenu ul > li a.dropdown-submenu
{
    color: var(--link-hover-color);
}

.top_button, .top_button::after,
.btn, #right-column .block, .customNavigation a, .pspc-main .time,
#footer .block_newsletter, 
.products .item .product-description, .blockreassurance_product, .products .all-product-link,
.products .product_list li .wishlist,
.products .product_list li .outer-functional .functional-buttons .quick-view-btn, 
.products .product_list li .compare, 
.products .product_list li .product-actions,
#left-column .block, #right-column .block,
.blog-image .blogicons .icon::before,
.pagination li > span, .pagination a,
.block-promo .promo-input, #header .search-widget form input[type="text"],
#czoffercmsblock .offercmsdetail,
#czoffercmsblock .offercms-text,
.search-widget form input[type="text"],
#header ul.dropdown-menu
{
    border-radius: var(--border-radius);
    -webkit-border-radius: var(--border-radius);
    -moz-border-radius: var(--border-radius);
    -ms-border-radius: var(--border-radius);
    -o-border-radius: var(--border-radius);
}
.block_newsletter form input[type="text"],
.lang-rtl #header .search-widget form button[type="submit"], 
.lang-rtl .block_newsletter form input.btn,
.flex-direction-nav .flex-next{
    border-radius: var(--border-radius) 0 0 var(--border-radius);
    -webkit-border-radius: var(--border-radius) 0 0 var(--border-radius);
    -moz-border-radius: var(--border-radius) 0 0 var(--border-radius);
    -ms-border-radius: var(--border-radius) 0 0 var(--border-radius);
    -o-border-radius: var(--border-radius) 0 0 var(--border-radius);
}
#header .search-widget form button[type="submit"],
.block_newsletter form input.btn,
.search-widget form button[type="submit"],
.header-top-inner .vertical-menu ul > li:hover > .sub-menu{
    border-radius: 0 var(--border-radius) var(--border-radius) 0;
    -webkit-border-radius:  0 var(--border-radius) var(--border-radius) 0;
    -moz-border-radius:  0 var(--border-radius) var(--border-radius) 0;
    -ms-border-radius:  0 var(--border-radius) var(--border-radius) 0;
    -o-border-radius:  0 var(--border-radius) var(--border-radius) 0;
}

#header .blockcart .blockcart-header > .shopping-cart,
#czverticalmenublock .block_title,
#left-column .block .block_title, #right-column .block .block_title,
.tabs .nav-tabs .nav-link
{
     border-radius: var(--border-radius) var(--border-radius) 0 0;
    -webkit-border-radius:  var(--border-radius) var(--border-radius) 0 0;
    -moz-border-radius:  var(--border-radius) var(--border-radius) 0 0;
    -ms-border-radius:  var(--border-radius) var(--border-radius) 0 0;
    -o-border-radius:  var(--border-radius) var(--border-radius) 0 0;
}
#czverticalmenublock .block_content,
.header-top-inner .menu .sub-menu{
     border-radius: 0 0 var(--border-radius) var(--border-radius);
    -webkit-border-radius:  0 0 var(--border-radius) var(--border-radius);
    -moz-border-radius:  0 0 var(--border-radius) var(--border-radius);
    -ms-border-radius:  0 0 var(--border-radius) var(--border-radius);
    -o-border-radius:  0 0 var(--border-radius) var(--border-radius);
}

.lang-rtl .block_newsletter form input[type="text"],
.flex-direction-nav .flex-prev{
    border-radius: 0 var(--border-radius) var(--border-radius) 0;
    -webkit-border-radius: 0 var(--border-radius) var(--border-radius) 0;
    -moz-border-radius: 0 var(--border-radius) var(--border-radius) 0;
    -ms-border-radius: 0 var(--border-radius) var(--border-radius) 0;
    -o-border-radius: 0 var(--border-radius) var(--border-radius) 0;
}

.lang-rtl .block_newsletter form input.btn,
.lang-rtl .header-top-inner .vertical-menu ul > li:hover > .sub-menu,
.lang-rtl .search-widget form button[type="submit"]
{
    border-radius: var(--border-radius) 0 0 var(--border-radius);
    -webkit-border-radius:  var(--border-radius) 0 0 var(--border-radius);
    -moz-border-radius:  var(--border-radius) 0 0 var(--border-radius);
    -ms-border-radius:  var(--border-radius) 0 0 var(--border-radius);
    -o-border-radius:  var(--border-radius) 0 0 var(--border-radius);
}

@media(max-width: 991px){
    #header .search-widget .search_button:hover, #header .search-widget form button[type="submit"]:hover,
    #header .blockcart .blockcart-header > .shopping-cart .mobile_count {
        background-color: var(--primary-color);
        color: var(--secondary-color);
    }
}
</style> 