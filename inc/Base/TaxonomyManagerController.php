<?php
/*
 * @package BenzeePlugin
 */

namespace Inc\Base;

use Inc\Api\Callbacks\CustomPostTypeCallbacks;
use Inc\Api\Callbacks\TaxonomyManagerCallbacks;
use Inc\Api\SettingsApi;

class TaxonomyManagerController extends BaseController {
    public $settings = [];
    public $callbacks = [];

    public $subPages = [];

    public $subpages = [];
    public $taxonomies = [];
    public function register(){

        if (!$this->activated('taxonomy_manager')) return;

        $this->settings = new SettingsApi();
        $this->callbacks = new TaxonomyManagerCallbacks();

        $this->setSubPages();

        $this->setSettings();

        $this->setSections();

        $this->setFields();

        $this->settings->addSubPages($this->subPages)->register();


    }
    public function setSubPages(){
        $this->subPages = [
            [
                'parent_slug' => 'benzee_plugin',
                'page_title' => 'Taxonomy Manager',
                'menu_title' => 'Taxonomy Manager',
                'capability' => 'manage_options',
                'menu_slug' => 'taxonomy_manager',
                'callback' => [$this->callbacks, 'TaxonomyTemplate'],
            ]

        ];
    }


    public function setSettings(){
        $args =  [
            [
                'option_group' => 'benzee_plugin_taxonomies_setting',
                'option_name' => 'benzee_plugin_taxonomies',
                'callback' => [$this->callbacks, 'taxonomiesSanitize'],
            ]
        ];

        $this->settings->setSettings($args);
    }

    public function setSections(){
        $args = [
            [
                'id' => 'benzee_taxonomy_index',
                'title' => 'Taxonomy Manager',
                'callback' => [$this->callbacks, 'taxSectionManager'],
                'page' => 'taxonomy_manager'
            ]
        ];
        $this->settings->setSections($args);
    }

    public function setFields(){

            $args = [
                [
                    'id' => 'taxonomy',
                    'title' => 'Custom Taxonomy ID',
                    'callback' => [$this->callbacks, 'textField'],
                    'page' => 'taxonomy_manager',
                    'section' => 'benzee_taxonomy_index',
                    'args' => [
                        'option_name' => 'benzee_plugin_taxonomies',
                        'label_for' => 'taxonomy',
                        'placeholder' => 'eg. genre'
                    ],
                ],
                [
                    'id' => 'singular_name',
                    'title' => 'Singular Name',
                    'callback' => [$this->callbacks, 'textField'],
                    'page' => 'taxonomy_manager',
                    'section' => 'benzee_taxonomy_index',
                    'args' => [
                        'option_name' => 'benzee_plugin_taxonomies',
                        'label_for' => 'singular_name',
                        'placeholder' => 'eg. genre'
                    ],
                ],
                [
                    'id' => 'hierarchical',
                    'title' => 'Has Hierarchical ?',
                    'callback' => [$this->callbacks, 'checkBoxField'],
                    'page' => 'taxonomy_manager',
                    'section' => 'benzee_taxonomy_index',
                    'args' => [
                        'option_name' => 'benzee_plugin_taxonomies',
                        'label_for' => 'hierarchical',
                        'class' => 'ui-toggle'
                    ],
                ],
            ];


        $this->settings->setFields($args);
    }

}