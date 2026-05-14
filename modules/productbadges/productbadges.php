<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class ProductBadges extends Module
{
    public function __construct()
    {
        $this->name = 'productbadges';
        $this->version = '1.0.0';
        $this->author = 'David Otero Mesejo';
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Product Badges');
        $this->description = $this->l('Adds badges to products.');
    }
    public function install()
    {
        return parent::install();
    }
    public function uninstall()
    {
        return parent::uninstall();
    }
}
?>