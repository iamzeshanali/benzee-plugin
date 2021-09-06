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

        $this->storeCustomTaxonomies();

        if (!empty($this->taxonomies)){
            add_action('init', array($this, 'registerCustomTaxonomies'));
        }

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
                [
                    'id' => 'objects',
                    'title' => 'Post Types',
                    'callback' => [$this->callbacks, 'checkBoxPostTypesField'],
                    'page' => 'taxonomy_manager',
                    'section' => 'benzee_taxonomy_index',
                    'args' => [
                        'option_name' => 'benzee_plugin_taxonomies',
                        'label_for' => 'objects',
                        'class' => 'ui-toggle'
                    ],
                ],
            ];


        $this->settings->setFields($args);
    }

    public function storeCustomTaxonomies(){
        $allOptions = get_option('benzee_plugin_taxonomies') ?: array();

        foreach ($allOptions as $options){

            $labels = [
                'name'                  => $options['singular_name'],
                'singular_name'         => $options['singular_name'],
                'menu_name'             => $options['singular_name'],
                'name_admin_bar'        => $options['singular_name'],
                'archives'              => $options['singular_name'] . ' Archives',
                'attributes'            => $options['singular_name'] . ' Attributes',
                'parent_item_colon'     => 'Parent ' . $options['singular_name'],
                'all_items'             => 'All ' . $options['singular_name'],
                'add_new_item'          => 'Add New ' . $options['singular_name'],
                'add_new'               => 'Add New',
                'new_item'              => 'New ' . $options['singular_name'],
                'edit_item'             => 'Edit ' . $options['singular_name'],
                'update_item'           => 'Update ' . $options['singular_name'],
                'view_item'             => 'View ' . $options['singular_name'],
                'view_items'            => 'View ' . $options['singular_name'],
                'search_items'          => 'Search ' . $options['singular_name'],
                'not_found'             => 'No ' . $options['singular_name'] . ' Found',
                'not_found_in_trash'    => 'No ' . $options['singular_name'] . ' Found in Trash',
            ];
            $this->taxonomies[] = [
                'hierarchical' => isset($options['hierarchical']),
                'labels' => $labels,
                'show_ui' => true,
                'show_domain_column' => true,
                'query_var' => true,
                'rewrite' => array('slug' => $options['singular_name']),
                'objects' => isset($options['objects'])? $options['objects'] : null
            ];
        }


    }

    public function registerCustomTaxonomies(){

        foreach ($this->taxonomies as $taxonomy) {
            $objects = isset($taxonomy['objects']) ? array_keys($taxonomy['objects']) : null;
            register_taxonomy($taxonomy['rewrite']['slug'], $objects, $taxonomy);
        }
    }
}