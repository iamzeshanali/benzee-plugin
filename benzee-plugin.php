<?php
/**
 * @package BenzeePlugin
 */
/*
  Plugin Name: BenzeePlugin
  Plugin URI: http://localhost/wealthfront/benzee-plugin
  Description: This is the first attempt for demo work of Plugin Development
  Version: 1.0.0
  Author: Zeeshan Ali
  Author URI: https://zeeshan-ali-2213.github.io/profile.github.io/
  License: GPLv2 or later
  Text Domain: benzee-plugin
 */

/*if (!defined('ABSPATH')){
    die;
}*/

defined('ABSPATH') or die('Hey! You can not access the file');

if(file_exists( dirname(__FILE__).'/vendor/autoload.php')){
    require_once dirname(__FILE__).'/vendor/autoload.php';
}

use Inc\Base\Activate;
use Inc\Base\Deactivate;

function activate_my_plugin (){
    Activate::activate();
}
register_activation_hook(__FILE__,'activate_my_plugin');

function deactivate_my_plugin(){
    Deactivate::deactivate();
}
register_deactivation_hook(__FILE__,'deactivate_my_plugin');

if (class_exists('Inc\\Init')){
    Inc\Init::register_services();
}