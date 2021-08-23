<?php
/*
 * @package BenzeePlugin
 */
namespace Inc\Api\Callbacks;


use Inc\Base\BaseController;

class AdminCallbacks extends BaseController
{
    public function adminDashboard()
    {
        return require_once("$this->plugin_path/templates/admin.php");
    }

    public function benzeeOptionGroup( $input )
    {
        return $input;
    }

    public function benzeeAdminSection( )
    {
        echo 'Check this section';
    }

    public function benzeeTextExample( )
    {
        $value = esc_attr(get_option('text_example'));
        echo '<input type="text" class="regular-text" name="test_example" value="'.$value.'" placeholder="Write Here">';
    }

    public function benzeeFirstName( )
    {
        $value = esc_attr(get_option('text_example'));
        echo '<input type="checkbox" class="regular-text" name="first_name" value="'.$value.'" placeholder="First Name">';
    }
}
