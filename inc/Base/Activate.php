<?php
/*
 * @package BenzeePlugin
 */

namespace Inc\Base;

class Activate {
    public static function activate(){
        flush_rewrite_rules();
        $default = [];
        if ( ! get_option('benzee_plugin')){
            update_option('benzee_plugin', $default);
        }
        if ( ! get_option('benzee_plugin_cpt')){
            update_option('benzee_plugin_cpt', $default);
        }
        if ( ! get_option('benzee_plugin_taxonomies')){
            update_option('benzee_plugin_taxonomies', $default);
        }
    }
}