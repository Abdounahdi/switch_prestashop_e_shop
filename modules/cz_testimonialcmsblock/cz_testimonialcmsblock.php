<?php
/**
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
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

require_once _PS_MODULE_DIR_ . 'cz_testimonialcmsblock/classes/TestimonialCmsBlock.php';

class Cz_Testimonialcmsblock extends Module implements WidgetInterface
{
    // Equivalent module on PrestaShop 1.6, sharing the same data
    const MODULE_16 = 'blockcmsinfo';

    private $templateFile;

    public function __construct()
    {
        $this->name = 'cz_testimonialcmsblock';
        $this->tab = 'front_office_features';
        $this->author = 'Codezeel';
        $this->version = '4.1.1';
        $this->need_instance = 0;

        $this->bootstrap = true;
        parent::__construct();

        Shop::addTableAssociation('cztestimonialcmsblockinfo', ['type' => 'shop']);

        $this->displayName = $this->trans('CZ - Testimonial CMS Block', [], 'Modules.TestimonialCmsBlock.Admin');
        $this->description = $this->trans('Adds custom information block in your store', [], 'Modules.TestimonialCmsBlock.Admin');

        $this->ps_versions_compliancy = ['min' => '1.7.4.0', 'max' => _PS_VERSION_];

        $this->templateFile = 'module:cz_testimonialcmsblock/views/templates/hook/cz_testimonialcmsblock.tpl';
    }

    public function install()
    {
        // Remove 1.6 equivalent module to avoid DB issues
        if (Module::isInstalled(self::MODULE_16)) {
            return $this->installFrom16Version();
        }

        return $this->runInstallSteps()
            && $this->installFixtures();
    }

    public function runInstallSteps()
    {
        return parent::install()
            && $this->installDB()
            && $this->registerHook('displayHeader')
            && $this->registerHook('displayHome')
            && $this->registerHook('actionShopDataDuplication');
    }

    public function installFrom16Version()
    {
        require_once _PS_MODULE_DIR_ . $this->name . '/classes/MigrateData.php';
        $migration = new MigrateData();
        $migration->retrieveOldData();

        $oldModule = Module::getInstanceByName(self::MODULE_16);
        if ($oldModule) {
            $oldModule->uninstall();
        }

        return $this->uninstallDB()
            && $this->runInstallSteps()
            && $migration->insertData();
    }

    public function uninstall()
    {
        return parent::uninstall() && $this->uninstallDB();
    }

    public function installDB()
    {
        $return = true;
        $return &= Db::getInstance()->execute('
                CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'cztestimonialcmsblockinfo` (
                `id_cztestimonialcmsblockinfo` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                PRIMARY KEY (`id_cztestimonialcmsblockinfo`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8 ;'
        );

        $return &= Db::getInstance()->execute('
                CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'cztestimonialcmsblockinfo_shop` (
                `id_cztestimonialcmsblockinfo` INT(10) UNSIGNED NOT NULL,
                `id_shop` INT(10) UNSIGNED NOT NULL,
                PRIMARY KEY (`id_cztestimonialcmsblockinfo`, `id_shop`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8 ;'
        );

        $return &= Db::getInstance()->execute('
                CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'cztestimonialcmsblockinfo_lang` (
                `id_cztestimonialcmsblockinfo` INT UNSIGNED NOT NULL,
                `id_shop` INT(10) UNSIGNED NOT NULL,
                `id_lang` INT(10) UNSIGNED NOT NULL ,
                `text` text NOT NULL,
                PRIMARY KEY (`id_cztestimonialcmsblockinfo`, `id_lang`, `id_shop`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8 ;'
        );

        return $return;
    }

    public function uninstallDB($drop_table = true)
    {
        $ret = true;
        if ($drop_table) {
            $ret &= Db::getInstance()->execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'cztestimonialcmsblockinfo`')
                && Db::getInstance()->execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'cztestimonialcmsblockinfo_shop`')
                && Db::getInstance()->execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'cztestimonialcmsblockinfo_lang`');
        }

        return $ret;
    }

    public function getContent()
    {
        $output = '';

        if (Tools::isSubmit('savecz_testimonialcmsblock')) {
            if (!Tools::getValue('text_' . (int) Configuration::get('PS_LANG_DEFAULT'), false)) {
                $output = $this->displayError($this->trans('Please fill out all fields.', [], 'Admin.Notifications.Error'));
            } else {
                $update = $this->processSaveTestimonialCmsBlock();

                if (!$update) {
                    $output = '<div class="alert alert-danger conf error">'
                        . $this->trans('An error occurred on saving.', [], 'Admin.Notifications.Error')
                        . '</div>';
                }

                $this->_clearCache($this->templateFile);

                if ($update) {
                    Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name . '&conf=4');
                }
            }
        }

        return $output . $this->renderForm();
    }

    public function processSaveTestimonialCmsBlock()
    {
        $shops = Tools::getValue('checkBoxShopAsso_configuration', [$this->context->shop->id]);
        $text = [];
        $languages = Language::getLanguages(false);

        foreach ($languages as $lang) {
            $text[$lang['id_lang']] = (string) Tools::getValue('text_' . $lang['id_lang']);
        }

        $saved = true;
        foreach ($shops as $shop) {
            Shop::setContext(Shop::CONTEXT_SHOP, $shop);
            $cztestimonialcmsblockinfo = new TestimonialCmsBlock(Tools::getValue('id_cztestimonialcmsblockinfo', 1));
            $cztestimonialcmsblockinfo->text = $text;
            $saved &= $cztestimonialcmsblockinfo->save();
        }

        return $saved;
    }

    protected function renderForm()
    {
        $default_lang = (int) Configuration::get('PS_LANG_DEFAULT');

        $fields_form = [
            'tinymce' => true,
            'legend' => [
                'title' => $this->trans('CMS block', [], 'Modules.TestimonialCmsBlock.Admin'),
            ],
            'input' => [
                'id_info' => [
                    'type' => 'hidden',
                    'name' => 'id_cztestimonialcmsblockinfo',
                ],
                'content' => [
                    'type' => 'textarea',
                    'label' => $this->trans('Text block', [], 'Modules.TestimonialCmsBlock.Admin'),
                    'lang' => true,
                    'name' => 'text',
                    'cols' => 40,
                    'rows' => 10,
                    'class' => 'rte',
                    'autoload_rte' => true,
                ],
            ],
            'submit' => [
                'title' => $this->trans('Save', [], 'Admin.Actions'),
            ],
            'buttons' => [
                [
                    'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                    'title' => $this->trans('Back to list', [], 'Admin.Actions'),
                    'icon' => 'process-icon-back',
                ],
            ],
        ];

        if (Shop::isFeatureActive() && Tools::getValue('id_cztestimonialcmsblockinfo') == false) {
            $fields_form['input'][] = [
                'type' => 'shop',
                'label' => $this->trans('Shop association', [], 'Admin.Global'),
                'name' => 'checkBoxShopAsso_theme',
            ];
        }

        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = 'cz_testimonialcmsblock';
        $helper->identifier = $this->identifier;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        foreach (Language::getLanguages(false) as $lang) {
            $helper->languages[] = [
                'id_lang' => $lang['id_lang'],
                'iso_code' => $lang['iso_code'],
                'name' => $lang['name'],
                'is_default' => ($default_lang == $lang['id_lang'] ? 1 : 0),
            ];
        }

        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;
        $helper->toolbar_scroll = true;
        $helper->title = $this->displayName;
        $helper->submit_action = 'savecz_testimonialcmsblock';

        $helper->fields_value = $this->getFormValues();

        return $helper->generateForm([['form' => $fields_form]]);
    }

    public function getFormValues()
    {
        $fields_value = [];
        $idShop = $this->context->shop->id;
        $idInfo = TestimonialCmsBlock::getTestimonialCmsBlockIdByShop($idShop);

        Shop::setContext(Shop::CONTEXT_SHOP, $idShop);
        $cztestimonialcmsblockinfo = new TestimonialCmsBlock((int) $idInfo);

        $fields_value['text'] = $cztestimonialcmsblockinfo->text;
        $fields_value['id_cztestimonialcmsblockinfo'] = $idInfo;

        return $fields_value;
    }
    
	public function hookdisplayHeader($params)
    {
        $this->context->controller->registerJavascript('modules-cztestimonialcmsblock', 'modules/'.$this->name.'/views/js/parallax.js', ['position' => 'bottom', 'priority' => 150]);
    }

    public function renderWidget($hookName = null, array $configuration = [])
    {
        if (!$this->isCached($this->templateFile, $this->getCacheId('cz_testimonialcmsblock'))) {
            $this->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        }

        return $this->fetch($this->templateFile, $this->getCacheId('cz_testimonialcmsblock'));
    }

    public function getWidgetVariables($hookName = null, array $configuration = [])
    {
        $sql = 'SELECT * FROM `' . _DB_PREFIX_ . 'cztestimonialcmsblockinfo_lang`
            WHERE `id_lang` = ' . (int) $this->context->language->id . ' AND  `id_shop` = ' . (int) $this->context->shop->id;

    $imgname = Configuration::get('TESTIMONIAL_IMAGE', $this->context->language->id);
    if ($imgname && file_exists(_PS_MODULE_DIR_.'cz_themeimages/views/img'.DIRECTORY_SEPARATOR.$imgname)) {
        $this->smarty->assign('TESTIMONIAL_IMAGE', $this->context->link->getMediaLink(_MODULE_DIR_) . 'cz_themeimages/views/img/' . $imgname);
    }

        return [
            'cztestimonialcmsblockinfos' => Db::getInstance()->getRow($sql),
        ];
    }

    public function installFixtures()
    {
        $return = true;

        $html = '<div class="testimonial_wrapper">
        <div class="testimonial-area">
        <div class="customNavigation"><a class="btn prev cztestimonial_prev">&amp;nbps</a><a class="btn next cztestimonial_next">&amp;nbps</a></div>
        <ul id="testimonial-carousel" class="cz-carousel product_list">
        <li class="item">
        <div class="testimonial-item">
        <div class="item">
        <div class="testimonial-image"><img src="BASE_URLimg/cms/user1.jpg" alt="testimonial-user1" title="testimonial-user1" /></div>
        <div class="product_inner_cms">
        <div class="quote_img"></div>
        <div class="des">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt lorem consectetur adipiscing elit, sed do eiusmod tempor tempor minim simply random.</div>
        <div class="title">
        <div class="name"><a href="#">- Mark Jofferson</a></div>
        </div>
        </div>
        </div>
        </div>
        </li>
        <li class="item">
        <div class="testimonial-item">
        <div class="item">
        <div class="testimonial-image"><img src="BASE_URLimg/cms/user2.jpg" alt="testimonial-user2" title="testimonial-user2" /></div>
        <div class="product_inner_cms">
        <div class="quote_img"></div>
        <div class="des">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt lorem consectetur adipiscing elit, sed do eiusmod tempor tempor minim simply random.</div>
        <div class="title">
        <div class="name"><a href="#">- Luies Charls</a></div>
        </div>
        </div>
        </div>
        </div>
        </li>
        <li class="item">
        <div class="testimonial-item">
        <div class="item">
        <div class="testimonial-image"><img src="BASE_URLimg/cms/user3.jpg" alt="testimonial-user3" title="testimonial-user3" /></div>
        <div class="product_inner_cms">
        <div class="quote_img"></div>
        <div class="des">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt lorem consectetur adipiscing elit, sed do eiusmod tempor tempor minim simply random.</div>
        <div class="title">
        <div class="name"><a href="#">- Jecob Goeckno</a></div>
        </div>
        </div>
        </div>
        </div>
        </li>
        </ul>
        </div>
        </div>';
        $newhtml = str_replace('BASE_URL', $this->context->shop->getBaseURL(true), $html);

        $tabTexts = [
            [
                'text' => $newhtml 
            ],
        ];

        $shopsIds = Shop::getShops(true, null, true);
        $languages = Language::getLanguages(false);
        $text = [];

        foreach ($tabTexts as $tab) {
            $cztestimonialcmsblockinfo = new TestimonialCmsBlock();
            foreach ($languages as $lang) {
                $text[$lang['id_lang']] = $tab['text'];
            }
            $cztestimonialcmsblockinfo->text = $text;
            $return &= $cztestimonialcmsblockinfo->add();
        }

        if ($return && count($shopsIds) > 1) {
            foreach ($shopsIds as $idShop) {
                Shop::setContext(Shop::CONTEXT_SHOP, $idShop);
                $cztestimonialcmsblockinfo->text = $text;
                $return &= $cztestimonialcmsblockinfo->save();
            }
        }

        return $return;
    }

    /**
     * Add TestimonialCmsBlock when adding a new Shop
     *
     * @param array $params
     */
    public function hookActionShopDataDuplication($params)
    {
        if ($cztestimonialcmsblockinfoId = TestimonialCmsBlock::getTestimonialCmsBlockIdByShop($params['old_id_shop'])) {
            Shop::setContext(Shop::CONTEXT_SHOP, $params['old_id_shop']);
            $oldInfo = new TestimonialCmsBlock($infoId);

            Shop::setContext(Shop::CONTEXT_SHOP, $params['new_id_shop']);
            $newInfo = new TestimonialCmsBlock($infoId, null, $params['new_id_shop']);
            $newInfo->text = $oldInfo->text;

            $newInfo->save();
        }
    }
}
