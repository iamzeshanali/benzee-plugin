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

    public function checkboxSanitize( $input )
    {
        return (isset($input));
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
    public function adminSectionManager( )
    {
        echo 'Activate the Sections and Features of this Plugin by activating the checkboxes from the following list.';
    }
    public function checkBoxField( $args )
    {
        $name = $args['label_for'];
        $classes = $args['class'];
        $checkbox = get_option($name);
        echo '<div class="'.$classes.'"><input type="checkbox" class="'.$classes.'" name="'.$name.'" id="'.$name.'" value="1" '.($checkbox ? 'checked' : '').'>
                   <label for="'.$name.'"></div></div></label>
                </div>';
    }
}
