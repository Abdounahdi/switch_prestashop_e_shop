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

class Czsalenotification extends Module
{
    protected $config_form = false;
    public $id_lang;

    public function __construct()
    {
        $this->name = 'czsalenotification';
        $this->version = '1.0.0';
        $this->author = 'Codezeel';
        $this->tab = 'front_office_features';
        $this->need_instance = 0;
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->trans('CZ - Sale Notification Popup');
        $this->description = $this->trans('This module help you to display sale notification popup on frontend.');
        $this->ps_versions_compliancy = array('min' => '1.7.0.0', 'max' => _PS_VERSION_);
        $this->context = Context::getContext();
        $this->id_lang = $this->context->language->id;
    }

    public function install()
    {
        Configuration::updateValue('CZSALENOTIFICATION_ACTIVE', '1');
        Configuration::updateValue('CZSALENOTIFICATION_TIME', '7000');
        Configuration::updateValue('CZSALENOTIFICATION_COOKIETIME', '12');
        Configuration::updateValue('CZSALENOTIFICATION_POSITION', '3');
        Configuration::updateValue('CZSALENOTIFICATION_SELECT_TYPE', '1');

        return parent::install() &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('ActionAdminControllerSetMedia') &&
            $this->registerHook('displayFooter') &&
            $this->disableDevice(Context::DEVICE_MOBILE);
    }

    public function uninstall()
    {
        Configuration::deleteByName('CZSALENOTIFICATION_ACTIVE');
        Configuration::deleteByName('CZSALENOTIFICATION_TIME');
        Configuration::deleteByName('CZSALENOTIFICATION_COOKIETIME');
        Configuration::deleteByName('CZSALENOTIFICATION_CATEGORY');
        Configuration::deleteByName('CZSALENOTIFICATION_POSITION');
        Configuration::deleteByName('CZSALENOTIFICATION_SELECT_TYPE');
        Configuration::deleteByName('CZSALENOTIFICATION_LIST_PRODUCT');
        Configuration::deleteByName('CZSALENOTIFICATION_CUSTOMER');

        return parent::uninstall();
    }

    public function getContent()
    {
        $output = '';
        $errors = array();

        if (((bool)Tools::isSubmit('submitCzsalenotificationModule')) == true) {
           
            $time = Tools::getValue('CZSALENOTIFICATION_TIME');
            if (!Validate::isInt($time)) {
                $errors[] = $this->trans(
                    'Invalid value for the Popup Time',
                    array(),
                    'Modules.Czsalenotification.Admin'
                );
            }

            $cookietime = Tools::getValue('CZSALENOTIFICATION_COOKIETIME');
            if (!Validate::isInt($cookietime)) {
                $errors[] = $this->trans(
                    'Invalid value for the Cookie Time',
                    array(),
                    'Modules.Czsalenotification.Admin'
                );
            }

            if (isset($errors) && count($errors)) {
                $output = $this->displayError(implode('<br />', $errors));
            } else {
                $this->postProcess();

                $output = $this->displayConfirmation(
                    $this->trans(
                        'The settings have been updated.',
                        array(),
                        'Admin.Notifications.Success'
                    )
                );
            }
        }

        $this->context->smarty->assign('module_dir', $this->_path);

        return $output.$this->renderForm();
    }

    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitCzsalenotificationModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    public function getProduct($id_product = '')
    {
        if ($id_product != '') {
            return Db::getInstance()->executeS(
                'SELECT p.`id_product`, pl.`name`, pl.`link_rewrite`
                FROM `'._DB_PREFIX_.'product` p
                LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
                ON p.`id_product` = pl.`id_product`
                WHERE p.`active` = 1 AND p.`id_product` IN ('.pSQL($id_product).')
                AND pl.`id_lang` = '.(int)$this->id_lang
            );
        } else {
            return array();
        }
    }

    protected function getConfigForm()
    {
        $categories = $this->getCategory();

        if (!empty($categories)) {
            foreach ($categories as $category) {
                $query[] = array(
                    'id_option' => $category['id_category'], 
                    'name' => $category['name'],
                );
            }
        }

        $query1 = array(
            array(
                'id_option' => 1,
                'name' => $this->trans('Top Left')
            ),
            array(
                'id_option' => 2,
                'name' => $this->trans('Top Right')
            ),
            array(
                'id_option' => 3,
                'name' => $this->trans('Bottom Left')
            ),
            array(
                'id_option' => 4,
                'name' => $this->trans('Bottom Right')
            ),
        );

        $this->smarty->assign(array(
            'products' => $this->getProduct(Configuration::get('CZSALENOTIFICATION_LIST_PRODUCT')),
            'customers' => unserialize($this->base64Decode(
                Configuration::get('CZSALENOTIFICATION_CUSTOMER')
            ))
        ));

        $html = $this->fetch('module:czsalenotification/views/templates/hook/form.tpl');

        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->trans('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'html',
                        'name' => 'html_data1',
                        'html_content' =>  '',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->trans('Popup Active'),
                        'name' => 'CZSALENOTIFICATION_ACTIVE',
                        'is_bool' => true,
                        'desc' => $this->trans('Enable sale notification popup on frontend'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->trans('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->trans('Disabled')
                            )
                        ),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'name' => 'CZSALENOTIFICATION_TIME',
                        'label' => $this->trans('Popup Time'),
                        'desc' => $this->trans('Set notification popup time interval in milisecond(Ex. 1000).'),
                    ),
                    array(
                        'col' => 3,
                        'type' => 'text',
                        'label' => $this->trans('Cookies Time'),
                        'name' => 'CZSALENOTIFICATION_COOKIETIME',
                        'desc' => $this->trans('Set cookie time in hours you want to allow browser store cookie for hide sale notification on frontend.'),
                    ),	
                    array(
                        'type' => 'select',
                        'label' => $this->trans('Select Position'),
                        'name' => 'CZSALENOTIFICATION_POSITION',
                        'options' => array(
                            'query' => $query1,
                            'id' => 'id_option', 
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->trans('Select Type'),
                        'name' => 'CZSALENOTIFICATION_SELECT_TYPE',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->trans('Categories'),
                                ),
                                array(
                                    'id_option' => 2,
                                    'name' => $this->trans('Orders'),
                                ),
                                array(
                                    'id_option' => 3,
                                    'name' => $this->trans('Custom'),
                                ),
                            ),
                            'id' => 'id_option', 
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->trans('Select Category'),
                        'name' => 'CZSALENOTIFICATION_CATEGORY',
                        'options' => array(
                            'query' => $query,
                            'id' => 'id_option', 
                            'name' => 'name'
                        ),
                        'desc' => $this->trans('Product in category selected will display'),
                    ),
                    array(
                        'type' => 'html',
                        'name' => 'html_data',
                        'html_content' =>  $html,
                    ),
                ),
                'submit' => array(
                    'title' => $this->trans('Save'),
                ),
            ),
        );
    }

    protected function getConfigFormValues()
    {
        return array(
            'CZSALENOTIFICATION_ACTIVE' => Configuration::get('CZSALENOTIFICATION_ACTIVE'),
            'CZSALENOTIFICATION_TIME' => Configuration::get('CZSALENOTIFICATION_TIME'),
            'CZSALENOTIFICATION_COOKIETIME' => Configuration::get('CZSALENOTIFICATION_COOKIETIME'),
            'CZSALENOTIFICATION_CATEGORY' => Configuration::get('CZSALENOTIFICATION_CATEGORY'),
            'CZSALENOTIFICATION_POSITION' => Configuration::get('CZSALENOTIFICATION_POSITION'),
            'CZSALENOTIFICATION_SELECT_TYPE' => Configuration::get('CZSALENOTIFICATION_SELECT_TYPE')
        );
    }

    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }

        if (Tools::getValue('CZSALENOTIFICATION_SELECT_TYPE') == 3) {
            Configuration::updateValue('CZSALENOTIFICATION_LIST_PRODUCT', Tools::getValue('CZSALENOTIFICATION_LIST_PRODUCT'));

            $customer = array();
            $name = Tools::getValue('cz_name');
            $city = Tools::getValue('cz_city');

            if (!empty($name)) {
                $count = 1;

                for ($i=0; $i < count($name); $i++) { 
                    $customer[$i]['name'] = $name[$i];
                    $customer[$i]['city'] = $city[$i];
                }
            }

            Configuration::updateValue(
                'CZSALENOTIFICATION_CUSTOMER',
                $this->base64Encode(serialize($customer))
            );
        }
    }
    
    public function hookDisplayHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

    public function hookActionAdminControllerSetMedia()
    {
        $this->context->controller->addJS($this->_path.'/views/js/back.js');
        $this->context->controller->addCSS($this->_path.'/views/css/back.css');

        Media::addJsDef(array(
            'url' => $this->context->shop->getBaseURL(true, true) . 'modules/czsalenotification/ajax.php',
            'cz_token' => Tools::getAdminToken('AdminDashboard'),
        ));
    }

    public function hookdisplayFooter($params)
    {
        if (Configuration::get('CZSALENOTIFICATION_ACTIVE') != 1) {
            return;
        }

        $id_category = 0;        
        if (Configuration::get('CZSALENOTIFICATION_CATEGORY') != '') {
            $id_category = (int) Configuration::get('CZSALENOTIFICATION_CATEGORY');
        } else {
            $categories = $this->getCategory();
            
            if (!empty($categories)) {
                $id_category = (int)$categories[0]['id_category'];
            }
        }

        $products = array();
        $customers = array();

        if (Configuration::get('CZSALENOTIFICATION_SELECT_TYPE') == 2) {
            $array_orders = Db::getInstance()->executeS(
                'SELECT `id_order`
                FROM `'._DB_PREFIX_.'orders`
                WHERE 1 ORDER BY RAND() LIMIT 10'
            );

            $id_order = '';

            if (!empty($array_orders)) {
                foreach ($array_orders as $key => $array_order) {
                    if ($key == 0) {
                        $id_order .= $array_order['id_order'];
                    } else {
                        $id_order .= ',' . $array_order['id_order'];
                    }
                }
            }

            $products = Db::getInstance()->executeS(
                'SELECT DISTINCT p.`id_product`, pl.`name`, pl.`link_rewrite`
                FROM `'._DB_PREFIX_.'product` p
                LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
                ON p.`id_product` = pl.`id_product`
                LEFT JOIN `'._DB_PREFIX_.'product_shop` pshop
                ON p.`id_product` = pshop.`id_product`
                LEFT JOIN `'._DB_PREFIX_.'category_product` pc
                ON p.`id_product` = pc.`id_product`
                WHERE pc.`id_product`
                IN (SELECT DISTINCT `product_id` FROM `'._DB_PREFIX_.'order_detail` WHERE `id_order` IN('.$id_order.'))
                AND pl.`id_lang` = '.(int)$this->id_lang.'
                AND pshop.`active` = 1'
            );

            $products = $this->getImageProduct($products);

            $customers = Db::getInstance()->executeS(
                'SELECT CONCAT(LEFT(`firstname`, 1), `lastname`) AS `name`, `city`
                FROM `'._DB_PREFIX_.'address`
                WHERE id_customer
                IN (SELECT DISTINCT `id_customer` FROM `'._DB_PREFIX_.'orders` WHERE `id_order` IN('.$id_order.'))'
            );
        } else if (Configuration::get('CZSALENOTIFICATION_SELECT_TYPE') == 3) {
            $products = $this->getProduct(Configuration::get('CZSALENOTIFICATION_LIST_PRODUCT'));
            $products = $this->getImageProduct($products);

            $customers = unserialize($this->base64Decode(
                Configuration::get('CZSALENOTIFICATION_CUSTOMER')
            ));
        } else {
            $products = $this->getProductByIDCategory($id_category);
        }

        if (!empty($customers)) {
            $customer = $customers[0];
            $customer['city'] = $customer['city'];

            foreach ($customers as $key_c => $val_c) {
                $customers[$key_c]['city'] = $val_c['city'];
            }
        } else {
            $customer = array();
        }

        if (!empty($products)) {
            $product = $products[0];
        }

        $time = 7000;
        $cookietime = 12;
        $position = 3;

        if (isset($this->context->cookie->cookie_popup)) {
            $popup = Tools::jsonDecode($this->context->cookie->cookie_popup, true);

            $time = $popup['time'];
            $position = $popup['position'];
        } else {
            if (Configuration::get('CZSALENOTIFICATION_TIME') != '') {
                $time = Configuration::get('CZSALENOTIFICATION_TIME');
            }

            if (Configuration::get('CZSALENOTIFICATION_COOKIETIME') != '') {
                $cookietime = Configuration::get('CZSALENOTIFICATION_COOKIETIME');
            }

            if (Configuration::get('CZSALENOTIFICATION_POSITION') != ''){
                $position = Configuration::get('CZSALENOTIFICATION_POSITION');
            }
                
        }

        $this->smarty->assign(array(
            'type' => Configuration::get('CZSALENOTIFICATION_SELECT_TYPE'),
            'time' => $time,
            'cookietime' => $cookietime,
            'products' => $products,
            'product' => $product,
            'position' => $position,
            'customers' => $customers,
            'customer' => $customer,
        ));

        return $this->display(__FILE__, 'views/templates/hook/popup.tpl');
    }

    public function getCategory()
    {
        $sql = 'SELECT c.`id_category`, cl.`name`
        FROM `'._DB_PREFIX_.'category` c
        LEFT JOIN `'._DB_PREFIX_.'category_lang` cl
        ON c.`id_category` = cl.`id_category`
        WHERE c.`id_category`
        IN (SELECT DISTINCT `id_category` FROM `'._DB_PREFIX_.'category_product` WHERE 1)
        AND c.`active` = 1 AND cl.`id_lang` = ' . (int)$this->id_lang;

        return Db::getInstance()->executeS($sql);
    }

    public function getProductByIDCategory($id_category)
    {
        $products = Db::getInstance()->executeS(
            'SELECT p.`id_product`, pl.`name`, pl.`link_rewrite`
            FROM `'._DB_PREFIX_.'product` p
            LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
            ON p.`id_product` = pl.`id_product`
            WHERE p.`id_product`
            IN (SELECT `id_product` FROM `'._DB_PREFIX_.'category_product` WHERE `id_category` = '.(int)$id_category.')
            AND pl.`id_lang` = '.(int)$this->id_lang.'
            LIMIT 10'
        );

        return $this->getImageProduct($products);
    }

    public function getImageProduct($products)
    {
        if (!empty($products)) {
            foreach ($products as $key_p => $product) {
                $products[$key_p]['url'] = $this->context->link->getProductLink($product['id_product']);
                $image = Image::getCover($product['id_product']);
                
                if (isset($image) && is_array($image)){
                    $products[$key_p]['img'] = $this->context->link->getImageLink(
                        $product['link_rewrite'],
                        $image['id_image'],
                        ImageType::getFormattedName('home')
                    );
                }
            }
        }

        return $products;
    }

    public function base64Decode($data)
    {
        return call_user_func('base64_decode', $data);
    }

    public function base64Encode($data)
    {
        return call_user_func('base64_encode', $data);
    }

    public function displayProductSearch($products)
    {
        $this->smarty->assign(array(
            'products' => $products,
        ));

        return $this->fetch('module:czsalenotification/views/templates/hook/product.tpl');
    }
}
