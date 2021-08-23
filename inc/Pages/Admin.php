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
                'option_group' => 'benzee_plugin_settings',
                'option_name' => 'cpt_manager',
                'callback' => [$this->callbacks, 'checkboxSanitize'],
            ],
            [
                'option_group' => 'benzee_plugin_settings',
                'option_name' => 'taxonomy_manager',
                'callback' => [$this->callbacks, 'checkboxSanitize'],
            ],
            [
                'option_group' => 'benzee_plugin_settings',
                'option_name' => 'media_widget',
                'callback' => [$this->callbacks, 'checkboxSanitize'],
            ],
            [
                'option_group' => 'benzee_plugin_settings',
                'option_name' => 'gallery_manager',
                'callback' => [$this->callbacks, 'checkboxSanitize'],
            ],
            [
                'option_group' => 'benzee_plugin_settings',
                'option_name' => 'testimonial_manager',
                'callback' => [$this->callbacks, 'checkboxSanitize'],
            ],
            [
                'option_group' => 'benzee_plugin_settings',
                'option_name' => 'templates_manager',
                'callback' => [$this->callbacks, 'checkboxSanitize'],
            ],
            [
                'option_group' => 'benzee_plugin_settings',
                'option_name' => 'login_manager',
                'callback' => [$this->callbacks, 'checkboxSanitize'],
            ],
            [
                'option_group' => 'benzee_plugin_settings',
                'option_name' => 'membership_manager',
                'callback' => [$this->callbacks, 'checkboxSanitize'],
            ],
            [
                'option_group' => 'benzee_plugin_settings',
                'option_name' => 'chat_manager',
                'callback' => [$this->callbacks, 'checkboxSanitize'],
            ],
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
        $args = [
            [
                'id' => 'cpt_manager',
                'title' => 'Activate CPT Manager',
                'callback' => [$this->callbacks, 'checkBoxField'],
                'page' => 'benzee_plugin',
                'section' => 'benzee_admin_index',
                'args' => [
                    'options_name' => 'benzee_plugin',
                    'label_for' => 'cpt_manager',
                    'class' => 'ui-toggle',
                ],
            ],
            [
                'id' => 'taxonomy_manager',
                'title' => 'Activate Taxonomy Manager',
                'callback' => [$this->callbacks, 'checkBoxField'],
                'page' => 'benzee_plugin',
                'section' => 'benzee_admin_index',
                'args' => [
                    'options_name' => 'benzee_plugin',
                    'label_for' => 'taxonomy_manager',
                    'class' => 'ui-toggle',
                ],
            ],
            [
                'id' => 'media_widget',
                'title' => 'Activate Media Widget',
                'callback' => [$this->callbacks, 'checkBoxField'],
                'page' => 'benzee_plugin',
                'section' => 'benzee_admin_index',
                'args' => [
                    'options_name' => 'benzee_plugin',
                    'label_for' => 'media_widget',
                    'class' => 'ui-toggle',
                ],
            ],
            [
                'id' => 'gallery_manager',
                'title' => 'Activate Gallery Manager',
                'callback' => [$this->callbacks, 'checkBoxField'],
                'page' => 'benzee_plugin',
                'section' => 'benzee_admin_index',
                'args' => [
                    'options_name' => 'benzee_plugin',
                    'label_for' => 'gallery_manager',
                    'class' => 'ui-toggle',
                ],
            ],
            [
                'id' => 'testimonial_manager',
                'title' => 'Activate Testimonial Manager',
                'callback' => [$this->callbacks, 'checkBoxField'],
                'page' => 'benzee_plugin',
                'section' => 'benzee_admin_index',
                'args' => [
                    'options_name' => 'benzee_plugin',
                    'label_for' => 'testimonial_manager',
                    'class' => 'ui-toggle',
                ],
            ],
            [
                'id' => 'templates_manager',
                'title' => 'Activate Templates Manager',
                'callback' => [$this->callbacks, 'checkBoxField'],
                'page' => 'benzee_plugin',
                'section' => 'benzee_admin_index',
                'args' => [
                    'options_name' => 'benzee_plugin',
                    'label_for' => 'templates_manager',
                    'class' => 'ui-toggle',
                ],
            ],
            [
                'options_name' => 'benzee_plugin',
                'id' => 'login_manager',
                'title' => 'Activate Login Manager',
                'callback' => [$this->callbacks, 'checkBoxField'],
                'page' => 'benzee_plugin',
                'section' => 'benzee_admin_index',
                'args' => [
                    'label_for' => 'login_manager',
                    'class' => 'ui-toggle',
                ],
            ],
            [
                'options_name' => 'benzee_plugin',
                'id' => 'membership_manager',
                'title' => 'Activate Membership Manager',
                'callback' => [$this->callbacks, 'checkBoxField'],
                'page' => 'benzee_plugin',
                'section' => 'benzee_admin_index',
                'args' => [
                    'label_for' => 'membership_manager',
                    'class' => 'ui-toggle',
                ],
            ],
            [
                'options_name' => 'benzee_plugin',
                'id' => 'chat_manager',
                'title' => 'Activate Chat Manager',
                'callback' => [$this->callbacks, 'checkBoxField'],
                'page' => 'benzee_plugin',
                'section' => 'benzee_admin_index',
                'args' => [
                    'label_for' => 'chat_manager',
                    'class' => 'ui-toggle',
                ],
            ],

        ];
        $this->settings->setFields($args);
    }
}