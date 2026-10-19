<?php

namespace App\Main;

class TopMenu
{
    /**
     * List of top menu items.
     */
    public static function menu(): array
    {
        return [
            // ─── Dashboard ────────────────────────────────────────
            'dashboard' => [
                'icon' => 'home',
                'title' => 'Dashboard',
                'route_name' => 'dashboard',
            ],

            // ─── Gestión ─────────────────────────────────────────
            'gestion' => [
                'icon' => 'folder',
                'title' => 'Gestión',
                'sub_menu' => [

                    // ── Inmuebles ──
                    'inmuebles' => [
                        'icon' => 'building-2',
                        'title' => 'Inmuebles',
                        'sub_menu' => [
                            'inmuebles-listado' => [
                                'icon'       => 'list',
                                'route_name' => 'gestion.inmuebles.index',
                                'title'      => 'Listado',
                            ],
                            'inmuebles-crear' => [
                                'icon'       => 'plus-circle',
                                'route_name' => 'gestion.inmuebles.create',
                                'title'      => 'Crear Inmueble',
                            ],
                        ],
                    ],

                    // ── Equipos ──
                    'equipos' => [
                        'icon' => 'wrench',
                        'title' => 'Equipos',
                        'sub_menu' => [
                            'equipos-listado' => [
                                'icon'       => 'list',
                                'route_name' => 'gestion.equipos.index',
                                'title'      => 'Listado',
                            ],
                            'equipos-registrar' => [
                                'icon'       => 'plus-circle',
                                'route_name' => 'gestion.equipos.create',
                                'title'      => 'Registrar Equipo',
                            ],
                            [
                                'icon' => 'arrow-up-down',
                                'title' => 'Asignación de Equipos',
                                'route_name' => 'gestion.asignaciones.index',
                            ],
                        ],
                    ],

                    // ── Mantenimientos ──
                    'mantenimientos' => [
                        'icon' => 'flashlight',
                        'title' => 'Mantenimientos',
                        'sub_menu' => [
                            'mantenimientos-listado' => [
                                'icon'       => 'list',
                                'route_name' => 'gestion.mantenimientos.index',
                                'title'      => 'Listado',
                            ],
                            'mantenimientos-programar' => [
                                'icon'       => 'clock',
                                'route_name' => 'gestion.mantenimientos.create',
                                'title'      => 'Programar',
                            ],
                            'mantenimientos-calendario' => [
                                'icon'       => 'calendar',
                                'route_name' => 'gestion.mantenimientos.calendario',
                                'title'      => 'Calendario',
                            ],
                            // En SideMenu.php y TopMenu.php, dentro del submenú de 'mantenimientos'
                            'presupuesto' => [
                                'icon' => 'bar-chart-2',
                                'title' => 'Presupuesto',
                                'route_name' => 'gestion.mantenimientos.presupuesto',
                            ],
                        ],
                    ],

                    // ── Garantías ──
                    'garantias' => [
                        'icon' => 'shield-check',
                        'title' => 'Garantías',
                        'sub_menu' => [
                            'garantias-listado' => [
                                'icon'       => 'list',
                                'route_name' => 'gestion.garantias.index',
                                'title'      => 'Listado',
                            ],
                            'garantias-registrar' => [
                                'icon'       => 'plus-circle',
                                'route_name' => 'gestion.garantias.create',
                                'title'      => 'Registrar',
                            ],
                        ],
                    ],

                    // ── Usuarios (NUEVO) ──
                    'usuarios' => [
                        'icon' => 'users',
                        'title' => 'Usuarios',
                        'sub_menu' => [
                            'usuarios-listado' => [
                                'icon'       => 'list',
                                'route_name' => 'gestion.usuarios.index',
                                'title'      => 'Listado',
                            ],
                            'usuarios-crear' => [
                                'icon'       => 'plus-circle',
                                'route_name' => 'gestion.usuarios.create',
                                'title'      => 'Crear Usuario',
                            ],
                        ],
                    ],

                ],
            ],

            // ─── Parametrización ──────────────────────────────────
            'parametrizacion' => [
                'icon' => 'settings',
                'title' => 'Parametrización',
                'sub_menu' => [
                    'gestion-inmuebles' => [
                        'icon'     => 'building-2',
                        'title'    => 'Gestión de Inmuebles',
                        'sub_menu' => [
                            'bloques' => [
                                'icon'       => 'layout-grid',
                                'route_name' => 'parametrizacion.bloques.index',
                                'title'      => 'Bloques',
                            ],
                            'tipos-inmueble' => [
                                'icon'       => 'home',
                                'route_name' => 'parametrizacion.tipos_inmueble.index',
                                'title'      => 'Tipos de Inmueble',
                            ],
                            'periodicidades-mantenimiento' => [
                                'icon'       => 'calendar-clock',
                                'route_name' => 'parametrizacion.periodicidades_mantenimiento.index',
                                'title'      => 'Periodicidades de Mantenimiento',
                            ],
                            'niveles-deterioro' => [
                                'icon'       => 'alert-triangle',
                                'route_name' => 'parametrizacion.niveles_deterioro.index',
                                'title'      => 'Niveles de Deterioro',
                            ],
                        ],
                    ],
                    'gestion-equipos' => [
                        'icon'     => 'wrench',
                        'title'    => 'Gestión de Equipos',
                        'sub_menu' => [
                            'tipos-equipo' => [
                                'icon'       => 'package',
                                'route_name' => 'parametrizacion.tipos_equipo.index',
                                'title'      => 'Tipos de Equipo',
                            ],
                            'estados-equipo' => [
                                'icon'       => 'activity',
                                'route_name' => 'parametrizacion.estados_equipo.index',
                                'title'      => 'Estados de Equipo',
                            ],
                            'categorias-equipo' => [
                                'icon'       => 'layers',
                                'route_name' => 'parametrizacion.categorias_equipo.index',
                                'title'      => 'Categorías de Equipo',
                            ],
                            'marcas' => [
                                'icon'       => 'tag',
                                'route_name' => 'parametrizacion.marcas.index',
                                'title'      => 'Marcas',
                            ],
                            'criticidades' => [
                                'icon'       => 'target',
                                'route_name' => 'parametrizacion.criticidades.index',
                                'title'      => 'Criticidades',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
