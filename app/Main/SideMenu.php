<?php

namespace App\Main;

class SideMenu
{
    /**
     * List of side menu items.
     */
    public static function menu(): array
    {
        return [
            'dashboard' => [
                'icon' => 'home',
                'title' => 'Dashboard',
                'route_name' => 'dashboard-overview-1',
                'params' => [
                    'layout' => 'side-menu',
                ],
                /*  'sub_menu' => [
                    'dashboard-overview-1' => [
                        'icon' => 'activity',
                        'route_name' => 'dashboard-overview-1',
                        'params' => [
                            'layout' => 'side-menu',
                        ],
                        'title' => 'Overview 1'
                    ],
                    'dashboard-overview-2' => [
                        'icon' => 'activity',
                        'route_name' => 'dashboard-overview-2',
                        'params' => [
                            'layout' => 'side-menu',
                        ],
                        'title' => 'Overview 2'
                    ],
                    'dashboard-overview-3' => [
                        'icon' => 'activity',
                        'route_name' => 'dashboard-overview-3',
                        'params' => [
                            'layout' => 'side-menu',
                        ],
                        'title' => 'Overview 3'
                    ],
                    'dashboard-overview-4' => [
                        'icon' => 'activity',
                        'route_name' => 'dashboard-overview-4',
                        'params' => [
                            'layout' => 'side-menu',
                        ],
                        'title' => 'Overview 4'
                    ]
                ] */
            ],
            'menu-layout' => [
                'icon' => 'building',
                'title' => 'Gestión de Inventario',
                'sub_menu' => [
                    'side-menu' => [
                        'icon' => 'list',
                        'route_name' => 'dashboard-overview-1',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Listado de Inmuebles'
                    ],
                    'simple-menu' => [
                        'icon' => 'file-input',
                        'route_name' => 'dashboard-overview-1',
                        'params' => [
                            'layout' => 'simple-menu'
                        ],
                        'title' => 'Registrar Inmueble'
                    ],
                    'top-menu' => [
                        'icon' => 'link',
                        'route_name' => 'dashboard-overview-1',
                        'params' => [
                            'layout' => 'top-menu'
                        ],
                        'title' => 'Asignación de Equipos'
                    ]
                ]
            ],
            'apps' => [
                'icon' => 'toy-brick',
                'title' => 'Inventario de Equipos',
                'sub_menu' => [
                    'users' => [
                        'icon' => 'users',
                        'title' => 'Users',
                        'sub_menu' => [
                            'users-layout-1' => [
                                'icon' => 'zap',
                                'route_name' => 'users-layout-1',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 1'
                            ],
                            'users-layout-2' => [
                                'icon' => 'zap',
                                'route_name' => 'users-layout-2',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 2'
                            ],
                            'users-layout-3' => [
                                'icon' => 'zap',
                                'route_name' => 'users-layout-3',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 3'
                            ]
                        ]
                    ],
                    'profile' => [
                        'icon' => 'trello',
                        'title' => 'Profile',
                        'sub_menu' => [
                            'profile-overview-1' => [
                                'icon' => 'zap',
                                'route_name' => 'profile-overview-1',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Overview 1'
                            ],
                            'profile-overview-2' => [
                                'icon' => 'zap',
                                'route_name' => 'profile-overview-2',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Overview 2'
                            ],
                            'profile-overview-3' => [
                                'icon' => 'zap',
                                'route_name' => 'profile-overview-3',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Overview 3'
                            ]
                        ]
                    ],
                    'e-commerce' => [
                        'icon' => 'shopping-bag',
                        'title' => 'E-Commerce',
                        'sub_menu' => [
                            'categories' => [
                                'icon' => 'zap',
                                'route_name' => 'categories',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Categories'
                            ],
                            'add-product' => [
                                'icon' => 'zap',
                                'route_name' => 'add-product',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Add Product',
                            ],
                            'product-list' => [
                                'icon' => 'zap',
                                'route_name' => 'product-list',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Product List'
                            ],
                            'product-grid' => [
                                'icon' => 'zap',
                                'route_name' => 'product-grid',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Product Grid'
                            ],
                            'transaction-list' => [
                                'icon' => 'zap',
                                'route_name' => 'transaction-list',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Transaction List'
                            ],
                            'transaction-detail' => [
                                'icon' => 'zap',
                                'route_name' => 'transaction-detail',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Transaction Detail'
                            ],
                            'seller-list' => [
                                'icon' => 'zap',
                                'route_name' => 'seller-list',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Seller List'
                            ],
                            'seller-detail' => [
                                'icon' => 'zap',
                                'route_name' => 'seller-detail',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Seller Detail'
                            ],
                            'reviews' => [
                                'icon' => 'zap',
                                'route_name' => 'reviews',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Reviews'
                            ],
                        ]
                    ],
                    'inbox' => [
                        'icon' => 'inbox',
                        'route_name' => 'inbox',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Inbox'
                    ],
                    'file-manager' => [
                        'icon' => 'folder',
                        'route_name' => 'file-manager',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'File Manager'
                    ],
                    'point-of-sale' => [
                        'icon' => 'credit-card',
                        'route_name' => 'point-of-sale',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Point of Sale'
                    ],
                    'chat' => [
                        'icon' => 'message-square',
                        'route_name' => 'chat',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Chat'
                    ],
                    'post' => [
                        'icon' => 'file-text',
                        'route_name' => 'post',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Post'
                    ],
                    'calendar' => [
                        'icon' => 'calendar',
                        'route_name' => 'calendar',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Calendar'
                    ],
                    'crud' => [
                        'icon' => 'edit',
                        'title' => 'Crud',
                        'sub_menu' => [
                            'crud-data-list' => [
                                'icon' => 'zap',
                                'route_name' => 'crud-data-list',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Data List'
                            ],
                            'crud-form' => [
                                'icon' => 'zap',
                                'route_name' => 'crud-form',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Form'
                            ]
                        ]
                    ]
                ]
            ],
            'pages' => [
                'icon' => 'calendar-check',
                'title' => 'Mantenimientos',
                'sub_menu' => [
                    'wizards' => [
                        'icon' => 'activity',
                        'title' => 'Wizards',
                        'sub_menu' => [
                            'wizard-layout-1' => [
                                'icon' => 'zap',
                                'route_name' => 'wizard-layout-1',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 1'
                            ],
                            'wizard-layout-2' => [
                                'icon' => 'zap',
                                'route_name' => 'wizard-layout-2',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 2'
                            ],
                            'wizard-layout-3' => [
                                'icon' => 'zap',
                                'route_name' => 'wizard-layout-3',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 3'
                            ]
                        ]
                    ],
                    'blog' => [
                        'icon' => 'activity',
                        'title' => 'Blog',
                        'sub_menu' => [
                            'blog-layout-1' => [
                                'icon' => 'zap',
                                'route_name' => 'blog-layout-1',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 1'
                            ],
                            'blog-layout-2' => [
                                'icon' => 'zap',
                                'route_name' => 'blog-layout-2',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 2'
                            ],
                            'blog-layout-3' => [
                                'icon' => 'zap',
                                'route_name' => 'blog-layout-3',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 3'
                            ]
                        ]
                    ],
                    'pricing' => [
                        'icon' => 'activity',
                        'title' => 'Pricing',
                        'sub_menu' => [
                            'pricing-layout-1' => [
                                'icon' => 'zap',
                                'route_name' => 'pricing-layout-1',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 1'
                            ],
                            'pricing-layout-2' => [
                                'icon' => 'zap',
                                'route_name' => 'pricing-layout-2',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 2'
                            ]
                        ]
                    ],
                    'invoice' => [
                        'icon' => 'activity',
                        'title' => 'Invoice',
                        'sub_menu' => [
                            'invoice-layout-1' => [
                                'icon' => 'zap',
                                'route_name' => 'invoice-layout-1',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 1'
                            ],
                            'invoice-layout-2' => [
                                'icon' => 'zap',
                                'route_name' => 'invoice-layout-2',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 2'
                            ]
                        ]
                    ],
                    'faq' => [
                        'icon' => 'activity',
                        'title' => 'FAQ',
                        'sub_menu' => [
                            'faq-layout-1' => [
                                'icon' => 'zap',
                                'route_name' => 'faq-layout-1',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 1'
                            ],
                            'faq-layout-2' => [
                                'icon' => 'zap',
                                'route_name' => 'faq-layout-2',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 2'
                            ],
                            'faq-layout-3' => [
                                'icon' => 'zap',
                                'route_name' => 'faq-layout-3',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Layout 3'
                            ]
                        ]
                    ],
                    'login' => [
                        'icon' => 'activity',
                        'route_name' => 'login',
                        'params' => [
                            'layout' => 'base'
                        ],
                        'title' => 'Login'
                    ],
                    'register' => [
                        'icon' => 'activity',
                        'route_name' => 'register',
                        'params' => [
                            'layout' => 'base'
                        ],
                        'title' => 'Register'
                    ],
                    'error-page' => [
                        'icon' => 'activity',
                        'route_name' => 'error-page',
                        'params' => [
                            'layout' => 'base'
                        ],
                        'title' => 'Error Page'
                    ],
                    'update-profile' => [
                        'icon' => 'activity',
                        'route_name' => 'update-profile',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Update profile'
                    ],
                    'change-password' => [
                        'icon' => 'activity',
                        'route_name' => 'change-password',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Change Password'
                    ]
                ]
            ],
            'components' => [
                'icon' => 'inbox',
                'title' => 'Garantías',
                'sub_menu' => [
                    'grid' => [
                        'icon' => 'activity',
                        'title' => 'Grid',
                        'sub_menu' => [
                            'regular-table' => [
                                'icon' => 'zap',
                                'route_name' => 'regular-table',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Regular Table'
                            ],
                            'tabulator' => [
                                'icon' => 'zap',
                                'route_name' => 'tabulator',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Tabulator'
                            ]
                        ]
                    ],
                    'overlay' => [
                        'icon' => 'activity',
                        'title' => 'Overlay',
                        'sub_menu' => [
                            'modal' => [
                                'icon' => 'zap',
                                'route_name' => 'modal',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Modal'
                            ],
                            'slide-over' => [
                                'icon' => 'zap',
                                'route_name' => 'slide-over',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Slide Over'
                            ],
                            'notification' => [
                                'icon' => 'zap',
                                'route_name' => 'notification',
                                'params' => [
                                    'layout' => 'side-menu'
                                ],
                                'title' => 'Notification'
                            ],
                        ]
                    ],
                    'tab' => [
                        'icon' => 'activity',
                        'route_name' => 'tab',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Tab'
                    ],
                    'accordion' => [
                        'icon' => 'activity',
                        'route_name' => 'accordion',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Accordion'
                    ],
                    'button' => [
                        'icon' => 'activity',
                        'route_name' => 'button',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Button'
                    ],
                    'alert' => [
                        'icon' => 'activity',
                        'route_name' => 'alert',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Alert'
                    ],
                    'progress-bar' => [
                        'icon' => 'activity',
                        'route_name' => 'progress-bar',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Progress Bar'
                    ],
                    'tooltip' => [
                        'icon' => 'activity',
                        'route_name' => 'tooltip',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Tooltip'
                    ],
                    'dropdown' => [
                        'icon' => 'activity',
                        'route_name' => 'dropdown',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Dropdown'
                    ],
                    'typography' => [
                        'icon' => 'activity',
                        'route_name' => 'typography',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Typography'
                    ],
                    'icon' => [
                        'icon' => 'activity',
                        'route_name' => 'icon',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Icon'
                    ],
                    'loading-icon' => [
                        'icon' => 'activity',
                        'route_name' => 'loading-icon',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Loading Icon'
                    ]
                ]
            ],
            'forms' => [
                'icon' => 'settings',
                'title' => 'Parametrizacion',
                'sub_menu' => [
                    /*  'regular-form' => [
                        'icon' => 'activity',
                        'route_name' => 'regular-form',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Regular Form'
                    ], */
                    /*  'datepicker' => [
                        'icon' => 'activity',
                        'route_name' => 'datepicker',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Datepicker'
                    ], */
                    /*  'tom-select' => [
                        'icon' => 'activity',
                        'route_name' => 'tom-select',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Tom Select'
                    ], */
                    /* 'file-upload' => [
                        'icon' => 'activity',
                        'route_name' => 'file-upload',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'File Upload'
                    ], */
                   
                            // ─── Sección: Gestión de Inmuebles ──────────────────────────
                            'gestion-inmuebles' => [
                                'icon'     => 'building-2',
                                'title'    => 'Gestión de Inmuebles',
                                'sub_menu' => [
                                    'bloques' => [
                                        'icon'       => 'layout-grid',
                                        'route_name' => 'parametrizacion.bloques.index',
                                        'params'     => ['layout' => 'side-menu'],
                                        'title'      => 'Bloques',
                                    ],
                                    'tipos-inmueble' => [
                                        'icon'       => 'home',
                                        'route_name' => 'parametrizacion.tipos_inmueble.index',
                                        'params'     => ['layout' => 'side-menu'],
                                        'title'      => 'Tipos de Inmueble',
                                    ],
                                    'periodicidades-mantenimiento' => [
                                        'icon'       => 'calendar-clock',
                                        'route_name' => 'parametrizacion.periodicidades_mantenimiento.index',
                                        'params'     => ['layout' => 'side-menu'],
                                        'title'      => 'Periodicidades de Mantenimiento',
                                    ],
                                    'niveles-deterioro' => [
                                        'icon'       => 'alert-triangle',
                                        'route_name' => 'parametrizacion.niveles_deterioro.index',
                                        'params'     => ['layout' => 'side-menu'],
                                        'title'      => 'Niveles de Deterioro',
                                    ],
                                ],
                            ],

                            // ─── Sección: Gestión de Equipos ────────────────────────────
                            'gestion-equipos' => [
                                'icon'     => 'wrench',
                                'title'    => 'Gestión de Equipos',
                                'sub_menu' => [
                                    'tipos-equipo' => [
                                        'icon'       => 'package',
                                        'route_name' => 'parametrizacion.tipos_equipo.index',
                                        'params'     => ['layout' => 'side-menu'],
                                        'title'      => 'Tipos de Equipo',
                                    ],
                                    'estados-equipo' => [
                                        'icon'       => 'activity',
                                        'route_name' => 'parametrizacion.estados_equipo.index',
                                        'params'     => ['layout' => 'side-menu'],
                                        'title'      => 'Estados de Equipo',
                                    ],
                                    'categorias-equipo' => [
                                        'icon'       => 'layers',
                                        'route_name' => 'parametrizacion.categorias_equipo.index',
                                        'params'     => ['layout' => 'side-menu'],
                                        'title'      => 'Categorías de Equipo',
                                    ],
                                    'marcas' => [
                                        'icon'       => 'tag',
                                        'route_name' => 'parametrizacion.marcas.index',
                                        'params'     => ['layout' => 'side-menu'],
                                        'title'      => 'Marcas',
                                    ],
                                    'criticidades' => [
                                        'icon'       => 'target',
                                        'route_name' => 'parametrizacion.criticidades.index',
                                        'params'     => ['layout' => 'side-menu'],
                                        'title'      => 'Criticidades',
                                    ],
                                    ],
                                ],
                            
                       
                        /*  'validation' => [
                            'icon' => 'activity',
                            'route_name' => 'validation',
                            'params' => [
                                'layout' => 'side-menu'
                            ],
                            'title' => 'Validation'
                        ] */
                    ]
                ],
            /*  'widgets' => [
                'icon' => 'hard-drive',
                'title' => 'Widgets',
                'sub_menu' => [
                    'chart' => [
                        'icon' => 'activity',
                        'route_name' => 'chart',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Chart'
                    ],
                    'slider' => [
                        'icon' => 'activity',
                        'route_name' => 'slider',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Slider'
                    ],
                    'image-zoom' => [
                        'icon' => 'activity',
                        'route_name' => 'image-zoom',
                        'params' => [
                            'layout' => 'side-menu'
                        ],
                        'title' => 'Image Zoom'
                    ]
                ]
            ] */
        ];
    }
}