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
            // ─── Dashboard ────────────────────────────────────────
            'dashboard' => [
                'icon' => 'home',
                'title' => 'Dashboard',
                'route_name' => 'dashboard',
                'params' => [
                    'layout' => 'side-menu',
                ],
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
                                'params'     => ['layout' => 'side-menu'],
                                'title'      => 'Listado',
                            ],
                            'inmuebles-crear' => [
                                'icon'       => 'plus-circle',
                                'route_name' => 'gestion.inmuebles.create',
                                'params'     => ['layout' => 'side-menu'],
                                'title'      => 'Crear Inmueble',
                            ],
                            'inmuebles-mapa' => [
                                'icon'       => 'map',
                                'route_name' => 'gestion.inmuebles.index',
                                'params'     => ['layout' => 'side-menu'],
                                'title'      => 'Mapa de Ubicaciones',
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
                                'params'     => ['layout' => 'side-menu'],
                                'title'      => 'Listado',
                            ],
                            'equipos-registrar' => [
                                'icon'       => 'plus-circle',
                                'route_name' => 'gestion.equipos.create',
                                'params'     => ['layout' => 'side-menu'],
                                'title'      => 'Registrar Equipo',
                            ],
                            'equipos-hoja-vida' => [
                                'icon'       => 'file-text',
                                'route_name' => 'gestion.equipos.index',
                                'params'     => ['layout' => 'side-menu'],
                                'title'      => 'Hoja de Vida',
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
                                'params'     => ['layout' => 'side-menu'],
                                'title'      => 'Listado',
                            ],
                            'mantenimientos-programar' => [
                                'icon'       => 'clock',
                                'route_name' => 'gestion.mantenimientos.create',
                                'params'     => ['layout' => 'side-menu'],
                                'title'      => 'Programar',
                            ],
                            'mantenimientos-calendario' => [
                                'icon'       => 'calendar',
                                'route_name' => 'gestion.mantenimientos.index',
                                'params'     => ['layout' => 'side-menu'],
                                'title'      => 'Calendario',
                            ],
                            [
                                'icon' => 'arrow-up-down',
                                'title' => 'Asignación de Equipos',
                                'route_name' => 'gestion.asignaciones.index',
                                'params' => [
                                    'layout' => 'side-menu',
                                ],
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
                                'params'     => ['layout' => 'side-menu'],
                                'title'      => 'Listado',
                            ],
                            'garantias-registrar' => [
                                'icon'       => 'plus-circle',
                                'route_name' => 'gestion.garantias.create',
                                'params'     => ['layout' => 'side-menu'],
                                'title'      => 'Registrar',
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

                    // ─── Sección: Gestión de Inmuebles ────
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

                    // ─── Sección: Gestión de Equipos ────
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

                ],
            ],
        ];
    }
}
