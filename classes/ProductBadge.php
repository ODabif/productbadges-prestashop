<?php
class ProductBadge extends ObjectModel
{
    public $active;
    public $background_color;
    public $text_color;
    public $position;
    public $text;
    public $date_add;
    public $date_upd;
    
    public static $definition = [
        'table' => 'productbadges',
        'primary' => 'id_productbadge',
        'multilang' => true,
        'fields' => [
            'background_color' => ['type' => self::TYPE_STRING, 'required' => true, 'size' => 7],
            'text_color' => ['type' => self::TYPE_STRING, 'required' => true, 'size' => 7],
            'position' => ['type' => self::TYPE_INT, 'required' => true],
            'active' => ['type' => self::TYPE_BOOL, 'default' => 1],
            'date_add' => ['type' => self::TYPE_DATE],
            'date_upd' => ['type' => self::TYPE_DATE],
            'text' => ['type' => self::TYPE_STRING, 'lang' => true, 'required' => true, 'size' => 255],
        ],
    ];
}