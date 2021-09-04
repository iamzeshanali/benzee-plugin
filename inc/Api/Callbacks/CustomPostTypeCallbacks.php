<?php
/*
 * @package BenzeePlugin
 */
namespace Inc\Api\Callbacks;


use Inc\Base\BaseController;

class CustomPostTypeCallbacks extends BaseController
{
    public function cptSectionManager()
    {
        echo 'Manage your Custom Post Types';
    }
    public function CustomPostTypeTemplate()
    {
        return require_once("$this->plugin_path/templates/CustomPostType.php");
    }
    public function cptSanitize($input){

        $output = get_option('benzee_plugin_cpt');

        if (isset($_POST["remove"])){
            unset($output[$_POST["remove"]]);
            return $output;
        }
        if(count($output) == 0){
            $output[$input['post_type']] = $input;
            return $output;
        }
        foreach ($output as $key => $value){
            if ($input['post_type'] === $key){
                $output[$key] = $input;
            }else{
                $output[$input['post_type']] = $input;
            }
        }
        return $output;
    }

    public function textField( $args ){
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $value = '';
        if (isset($_POST['edit_post'])){
            $input= get_option($option_name);
            $value = $input[$_POST["edit_post"]][$name];
        }
        $placeholder = $args['placeholder'];

        echo '<input type="text" class="regular-text" id="'.$name.'" name="'.$option_name.'['.$name.']"  value="'.$value.'" required placeholder="'.$placeholder.'"';
    }
    public function checkBoxField( $args )
    {
        $name = $args['label_for'];
        $classes = $args['class'];
        $option_name = $args['option_name'];

        $checked = false;
        if (isset($_POST['edit_post'])){
            $checkbox = get_option($option_name);
            $checked = isset($checkbox[$_POST['edit_post']][$name]) ?:false;
        }


        echo '<div class="'.$classes.'"><input type="checkbox" class="'.$classes.'" name="'.$option_name.'['.$name.']" 
        id="'.$name.'" value="1" '.($checked ? 'checked' : '').'>
                   <label for="'.$name.'"></div></div></label>
                </div>';
    }
}
