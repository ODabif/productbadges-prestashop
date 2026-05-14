<?php
class AdminProductBadgesController extends ModuleAdminController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->bootstrap = true;
        $this->table = 'productbadges';
        $this->className = 'ProductBadge';
        $this->identifier = 'id_productbadge';
        $this->lang = true;
        $this->_defaultOrderBy = 'id_productbadge';  
        $this->_orderBy = 'id_productbadge';
        
        $this->fields_list = [
    'id_productbadge' => [
        'title' => 'ID',
        'align' => 'center',
        'class' => 'fixed-width-xs'
    ],
    'text' => [ 
        'title' => 'Texto',
        'width' => 'auto'
    ],
    'background_color' => [
        'title' => 'Color fondo',
        'align' => 'center',
        'callback' => 'displayColor'
    ],
    'text_color' => [
        'title' => 'Color texto',
        'align' => 'center',
        'callback' => 'displayColor'
    ],
    'position' => [
        'title' => 'Posición',
        'align' => 'center',
        'callback' => 'displayPosition'
    ],
    'active' => [
        'title' => 'Activo',
        'align' => 'center',
        'active' => 'status',
        'type' => 'bool',
        'class' => 'fixed-width-sm'
    ],
];
    }
    
    public function displayColor($color, $tr)
    {
        return '<div style="width: 30px; height: 30px; background-color: ' . htmlspecialchars($color) . '; border: 1px solid #ccc; border-radius: 3px;"></div>';
    }

    public function renderList()
    {
        $this->addRowAction('edit');
        $this->addRowAction('delete');
        
        return parent::renderList();
    }
    
public function displayPosition($position, $tr)
{
    if ($position == 0) {
        return 'Izquierda';
    }
    return 'Derecha';
}
    public function renderForm()
    {
        $this->fields_form = [
            'legend' => [
                'title' => 'Badge',
                'icon' => 'icon-tag'
            ],
            'input' => [
                [
                    'type' => 'text',
                    'label' => 'Texto de la badge',
                    'name' => 'text',
                    'lang' => true,
                    'required' => true,
                    'desc' => 'El texto que aparecerá en la etiqueta'
                ],
                [
                    'type' => 'color',
                    'label' => 'Color de fondo',
                    'name' => 'background_color',
                    'required' => true,
                    'desc' => 'Formato hexadecimal: #RRGGBB (ej: #FF0000 para rojo)'
                ],
                [
                    'type' => 'color',
                    'label' => 'Color del texto',
                    'name' => 'text_color',
                    'required' => true,
                    'desc' => 'Formato hexadecimal: #RRGGBB (ej: #FFFFFF para blanco)'
                ],
                [
                    'type' => 'select',
                    'label' => 'Posición',
                    'name' => 'position',
                    'required' => true,
                    'options' => [
                        'query' => [
                            ['id' => 0, 'name' => 'Esquina superior izquierda'],
                            ['id' => 1, 'name' => 'Esquina superior derecha'],
                        ],
                        'id' => 'id',
                        'name' => 'name'
                    ]
                ],
                [
                    'type' => 'switch',
                    'label' => 'Activo',
                    'name' => 'active',
                    'is_bool' => true,
                    'values' => [
                        ['id' => 'active_on', 'value' => 1, 'label' => 'Sí'],
                        ['id' => 'active_off', 'value' => 0, 'label' => 'No']
                    ],
                ],
            ],
            'submit' => [
                'title' => 'Guardar',
            ],
        ];
        
        return parent::renderForm();
    }
}