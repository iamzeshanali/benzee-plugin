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
    public $subpages = [];
    public $callbacks = [];
    public function register()
    {
        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->setPages();

        $this->setSubPages();

        $this->setSettings();

        $this->setSections();

        $this->setFields();

        $this->settings->addPages($this->pages)->withSubPage('Dashboard')->addSubPages($this->subpages)->register();
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

            [
                'page_title' => 'Subhan Plugin',
                'menu_title' => 'Subhan',
                'capability' => 'manage_options',
                'menu_slug' => 'subhan_plugin',
                'callback' => function(){echo '<h1>Subhan2 Plugin</h1>';},
                'icon_url' => 'dashicons-admin-users',
                'position' => 3
            ]
        ];
    }

    public function setSubPages(){
        $this->subpages = [
            [
                'parent_slug' => 'benzee_plugin',
                'page_title' => 'Custom Plugin',
                'menu_title' => 'CPT',
                'capability' => 'manage_options',
                'menu_slug' => 'benzee_plugin_cpt',
                'callback' => function(){echo '<h1>CPT Manager</h1>';},
            ],

            [
                'parent_slug' => 'benzee_plugin',
                'page_title' => 'Custom Taxonomies',
                'menu_title' => 'Taxonomies',
                'capability' => 'manage_options',
                'menu_slug' => 'benzee_plugin_taxonimies',
                'callback' => function(){echo '<h1>Taxonomies Manager</h1>';},
            ],

        ];
    }

    public function setSettings(){
        $args = [
            [
                'option_group' => 'benzee_options_group',
                'option_name' => 'test_example',
                'callback' => [$this->callbacks, 'benzeeOptionGroup'],
            ],
            [
                'option_group' => 'benzee_options_group',
                'option_name' => 'first_name',
                'callback' => [$this->callbacks, 'benzeeOptionGroup'],
            ]
        ];
        $this->settings->setSettings($args);
    }

    public function setSections(){
        $args = [
            [
                'id' => 'benzee_admin_index',
                'title' => 'Settings',
                'callback' => [$this->callbacks, 'benzeeAdminSection'],
                'page' => 'benzee_plugin'
            ]
        ];
        $this->settings->setSections($args);
    }

    public function setFields(){
        $args = [
            [
                'id' => 'test_example',
                'title' => 'Text Example',
                'callback' => [$this->callbacks, 'benzeeTextExample'],
                'page' => 'benzee_plugin',
                'section' => 'benzee_admin_index',
                'args' => [
                    'label_for' => 'test_example',
                    'class' => 'example-class',
                ],
            ],
            [
                'id' => 'first_name',
                'title' => 'First Name',
                'callback' => [$this->callbacks, 'benzeeFirstName'],
                'page' => 'benzee_plugin',
                'section' => 'benzee_admin_index',
                'args' => [
                    'label_for' => 'first_name',
                    'class' => 'example-class',
                ],
            ]
        ];
        $this->settings->setFields($args);
    }
}