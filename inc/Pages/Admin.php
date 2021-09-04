<?php
/*
 * @package BenzeePlugin
 */
namespace Inc\Pages;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;



class Admin extends BaseController {

    public $settings = [];
    public $pages = [];
//    public $subpages = [];
    public $callbacks = [];
    public function register()
    {
        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->setPages();

//        $this->setSubPages();

        $this->setSettings();

        $this->setSections();

        $this->setFields();

        $this->settings->addPages($this->pages)->withSubPage('Dashboard')->register();
    }

    public function setPages(){
        $this->pages = [
            [
                'page_title' => 'Benzee Plugin',
                'menu_title' => 'Benzee',
                'capability' => 'manage_options',
                'menu_slug' => 'benzee_plugin',
                'callback' => [$this->callbacks, 'adminDashboard'],
//                'callback' => function(){echo '<h1>Subhan2 Plugin</h1>';},
                'icon_url' => 'dashicons-store',
                'position' => 2
            ],

//            [
//                'page_title' => 'Subhan Plugin',
//                'menu_title' => 'Subhan',
//                'capability' => 'manage_options',
//                'menu_slug' => 'subhan_plugin',
//                'callback' => function(){echo '<h1>Subhan2 Plugin</h1>';},
//                'icon_url' => 'dashicons-admin-users',
//                'position' => 3
//            ]
        ];
    }

//    public function setSubPages(){
//        $this->subpages = [
//            [
//                'parent_slug' => 'benzee_plugin',
//                'page_title' => 'Custom Plugin',
//                'menu_title' => 'CPT',
//                'capability' => 'manage_options',
//                'menu_slug' => 'benzee_plugin_cpt',
//                'callback' => function(){echo '<h1>CPT Manager</h1>';},
//            ],
//
//            [
//                'parent_slug' => 'benzee_plugin',
//                'page_title' => 'Custom Taxonomies',
//                'menu_title' => 'Taxonomies',
//                'capability' => 'manage_options',
//                'menu_slug' => 'benzee_plugin_taxonimies',
//                'callback' => function(){echo '<h1>Taxonomies Manager</h1>';},
//            ],
//
//        ];
//    }

    public function setSettings(){
        $args =  [
            [
                'option_group' => 'benzee_plugin_settings',
                'option_name' => 'benzee_plugin',
                'callback' => [$this->callbacks, 'checkboxSanitize'],
            ]
        ];

        $this->settings->setSettings($args);
    }

    public function setSections(){
        $args = [
            [
                'id' => 'benzee_admin_index',
                'title' => 'Settings Manager',
                'callback' => [$this->callbacks, 'adminSectionManager'],
                'page' => 'benzee_plugin'
            ]
        ];
        $this->settings->setSections($args);
    }

    public function setFields(){
        $args = [];
        foreach ($this->managers as $key => $value){
            $args[] = [
                    'id' => $key,
                    'title' => $value,
                    'callback' => [$this->callbacks, 'checkBoxField'],
                    'page' => 'benzee_plugin',
                    'section' => 'benzee_admin_index',
                    'args' => [
                        'option_name' => 'benzee_plugin',
                        'label_for' => $key,
                        'class' => 'ui-toggle',
                    ],
                ];

        }
        $this->settings->setFields($args);
    }
}