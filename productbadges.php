<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

require_once dirname(__FILE__) . '/classes/ProductBadge.php';

class Productbadges extends Module
{
    public function __construct()
    {
        $this->name = 'productbadges';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'David Otero Mesejo';
        $this->bootstrap = true;
        $this->need_instance = 0;
        
        parent::__construct();
        
        $this->displayName = $this->l('Product Badges');
        $this->description = $this->l('Adds customizable badges to products');
    }
    
    public function install()
    {
        if (!parent::install()) {
            return false;
        }
        
        // Crear tablas
        $sqlFile = dirname(__FILE__) . '/sql/install.php';
        if (file_exists($sqlFile)) {
            $queries = include $sqlFile;
            foreach ($queries as $query) {
                if (!Db::getInstance()->execute($query)) {
                    return false;
                }
            }
        }
        
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = 'AdminProductBadges';
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = 'Product Badges';
        }
        $tab->id_parent = (int)Tab::getIdFromClassName('AdminCatalog');
        $tab->module = $this->name;
        $tab->add();
        
        // Registrar hooks
        $this->registerHook('displayProductListReviews');
        $this->registerHook('displayProductAdditionalInfo');
        $this->registerHook('displayHeader');
        $this->registerHook('displayAdminProductsExtra');
        $this->registerHook('actionProductSave');
        
        Configuration::updateValue('PRODUCTBADGES_GLOBAL_ENABLED', true);
        Configuration::updateValue('PRODUCTBADGES_SHOW_IN_LISTS', true);
        Configuration::updateValue('PRODUCTBADGES_SHOW_IN_PRODUCT', true);
        Configuration::updateValue('PRODUCTBADGES_MAX_BADGES', 3);
        
        return true;
    }
    
    public function uninstall()
    {
        $id_tab = (int)Tab::getIdFromClassName('AdminProductBadges');
        if ($id_tab) {
            $tab = new Tab($id_tab);
            $tab->delete();
        }
        
        Configuration::deleteByName('PRODUCTBADGES_GLOBAL_ENABLED');
        Configuration::deleteByName('PRODUCTBADGES_SHOW_IN_LISTS');
        Configuration::deleteByName('PRODUCTBADGES_SHOW_IN_PRODUCT');
        Configuration::deleteByName('PRODUCTBADGES_MAX_BADGES');
        
        $sqlFile = dirname(__FILE__) . '/sql/uninstall.php';
        if (file_exists($sqlFile)) {
            $queries = include $sqlFile;
            foreach ($queries as $query) {
                Db::getInstance()->execute($query);
            }
        }
        
        return parent::uninstall();
    }
    
    public function getContent()
    {
        if (Tools::isSubmit('submitConfig')) {
            Configuration::updateValue('PRODUCTBADGES_GLOBAL_ENABLED', (int)Tools::getValue('PRODUCTBADGES_GLOBAL_ENABLED'));
            Configuration::updateValue('PRODUCTBADGES_SHOW_IN_LISTS', (int)Tools::getValue('PRODUCTBADGES_SHOW_IN_LISTS'));
            Configuration::updateValue('PRODUCTBADGES_SHOW_IN_PRODUCT', (int)Tools::getValue('PRODUCTBADGES_SHOW_IN_PRODUCT'));
            Configuration::updateValue('PRODUCTBADGES_MAX_BADGES', (int)Tools::getValue('PRODUCTBADGES_MAX_BADGES'));
            $this->context->controller->confirmations[] = $this->l('Configuración guardada');
        }
        
        $manageLink = $this->context->link->getAdminLink('AdminProductBadges');
        $manageButton = '<a class="btn btn-primary" href="'.$manageLink.'" style="margin-bottom:15px">
                            <i class="icon-tags"></i> '.$this->l('Gestionar Badges').'
                         </a>';
        
        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = 'productbadges';
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->title = $this->displayName;
        $helper->submit_action = 'submitConfig';
        
        $helper->fields_value['PRODUCTBADGES_GLOBAL_ENABLED'] = Configuration::get('PRODUCTBADGES_GLOBAL_ENABLED');
        $helper->fields_value['PRODUCTBADGES_SHOW_IN_LISTS'] = Configuration::get('PRODUCTBADGES_SHOW_IN_LISTS');
        $helper->fields_value['PRODUCTBADGES_SHOW_IN_PRODUCT'] = Configuration::get('PRODUCTBADGES_SHOW_IN_PRODUCT');
        $helper->fields_value['PRODUCTBADGES_MAX_BADGES'] = Configuration::get('PRODUCTBADGES_MAX_BADGES');
        
        $fields_form = [
            'form' => [
                'legend' => ['title' => $this->l('Configuración'), 'icon' => 'icon-cog'],
                'input' => [
                    [
                        'type' => 'switch',
                        'label' => $this->l('Activar módulo globalmente'),
                        'name' => 'PRODUCTBADGES_GLOBAL_ENABLED',
                        'is_bool' => true,
                        'values' => [['value' => 1, 'label' => 'Sí'], ['value' => 0, 'label' => 'No']]
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->l('Mostrar en listados'),
                        'name' => 'PRODUCTBADGES_SHOW_IN_LISTS',
                        'is_bool' => true,
                        'values' => [['value' => 1, 'label' => 'Sí'], ['value' => 0, 'label' => 'No']]
                    ],
                    [
                        'type' => 'switch',
                        'label' => $this->l('Mostrar en ficha producto'),
                        'name' => 'PRODUCTBADGES_SHOW_IN_PRODUCT',
                        'is_bool' => true,
                        'values' => [['value' => 1, 'label' => 'Sí'], ['value' => 0, 'label' => 'No']]
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('Máximo de badges por producto'),
                        'name' => 'PRODUCTBADGES_MAX_BADGES',
                        'class' => 'fixed-width-sm',
                        'desc' => $this->l('0 = sin límite')
                    ],
                ],
                'submit' => ['title' => $this->l('Guardar')],
            ],
        ];
        
        return $manageButton . $helper->generateForm([$fields_form]);
    }
    
    public function hookDisplayHeader($params)
    {
        $this->context->controller->addCSS($this->_path . 'views/css/productbadges.css');
    }
    
    public function hookDisplayProductListReviews($params)
    {
        if (!Configuration::get('PRODUCTBADGES_GLOBAL_ENABLED') || !Configuration::get('PRODUCTBADGES_SHOW_IN_LISTS')) {
            return '';
        }
        
        $product = $params['product'];
        $id_product = is_array($product) ? $product['id_product'] : $product->id;
        $max = (int)Configuration::get('PRODUCTBADGES_MAX_BADGES');
        
        $badges = $this->getProductBadges($id_product, $max ? $max : null);
        
        if (empty($badges)) {
            return '';
        }
        
        $this->context->smarty->assign('badges', $badges);
        return $this->display(__FILE__, 'views/templates/hooks/product_badges.tpl');
    }
    
    public function hookDisplayProductAdditionalInfo($params)
    {
        if (!Configuration::get('PRODUCTBADGES_GLOBAL_ENABLED') || !Configuration::get('PRODUCTBADGES_SHOW_IN_PRODUCT')) {
            return '';
        }
        
        $max = (int)Configuration::get('PRODUCTBADGES_MAX_BADGES');
        $badges = $this->getProductBadges($params['product']->id, $max ? $max : null);
        
        if (empty($badges)) {
            return '';
        }
        
        $this->context->smarty->assign('badges', $badges);
        return $this->display(__FILE__, 'views/templates/hooks/product_badges.tpl');
    }
    
    public function hookDisplayAdminProductsExtra($params)
    {
        $id_product = (int)$params['id_product'];
        $all_badges = $this->getAllBadges();
        $selected = $this->getProductBadgeIds($id_product);
        
        $this->context->smarty->assign([
            'badges' => $all_badges,
            'selected_badges' => $selected,
        ]);
        
        return $this->display(__FILE__, 'views/templates/admin/product_badges_selector.tpl');
    }
    
    public function hookActionProductSave($params)
    {
        $id_product = (int)$params['id_product'];
        $selected = Tools::getValue('product_badges');
        
        if (!is_array($selected)) {
            $selected = [];
        }
        
        Db::getInstance()->delete('productbadges_product', 'id_product = ' . $id_product);
        
        foreach ($selected as $id_badge) {
            Db::getInstance()->insert('productbadges_product', [
                'id_productbadge' => (int)$id_badge,
                'id_product' => $id_product,
            ]);
        }
    }
    
    private function getProductBadges($id_product, $limit = null)
    {
        $sql = 'SELECT b.*, bl.text 
                FROM ' . _DB_PREFIX_ . 'productbadges b
                LEFT JOIN ' . _DB_PREFIX_ . 'productbadges_lang bl ON b.id_productbadge = bl.id_productbadge
                LEFT JOIN ' . _DB_PREFIX_ . 'productbadges_product bp ON b.id_productbadge = bp.id_productbadge
                WHERE bp.id_product = ' . (int)$id_product . '
                AND b.active = 1
                AND bl.id_lang = ' . (int)$this->context->language->id;
        
        if ($limit) {
            $sql .= ' LIMIT ' . (int)$limit;
        }
        
        return Db::getInstance()->executeS($sql);
    }
    
    private function getAllBadges()
    {
        $sql = 'SELECT b.*, bl.text 
                FROM ' . _DB_PREFIX_ . 'productbadges b
                LEFT JOIN ' . _DB_PREFIX_ . 'productbadges_lang bl ON b.id_productbadge = bl.id_productbadge
                WHERE bl.id_lang = ' . (int)$this->context->language->id;
        
        return Db::getInstance()->executeS($sql);
    }
    
    private function getProductBadgeIds($id_product)
    {
        $sql = 'SELECT id_productbadge 
                FROM ' . _DB_PREFIX_ . 'productbadges_product 
                WHERE id_product = ' . (int)$id_product;
        
        $result = Db::getInstance()->executeS($sql);
        return $result ? array_column($result, 'id_productbadge') : [];
    }
}