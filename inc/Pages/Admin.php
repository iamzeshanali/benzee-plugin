<?php
/*
 * @package BenzeePlugin
 */
namespace Inc\Pages;

use Inc\Base\BaseController;

class Admin extends BaseController {

     public function register(){
         add_action('admin_menu', array($this, 'add_admin_pages'));
     }

     function add_admin_pages(){
         add_menu_page('Benzee Plugin', 'Benzee','manage_options','benzee_plugin', array($this, 'admin_index'), 'dashicons-store',110);
     }

     function admin_index(){
         require_once $this->plugin_path.'templates/admin.php';
     }
}