<?php
/*
 * @package BenzeePlugin
 */
namespace Inc\Api\Callbacks;


use Inc\Base\BaseController;

class TaxonomyManagerCallbacks extends BaseController
{
    public function taxSectionManager()
    {
        echo 'Manage Taxonomies';
    }
    public function TaxonomyTemplate()
    {
        return require_once("$this->plugin_path/templates/TaxonomyManager.php");
    }
    public function taxonomiesSanitize($input){

        $output = get_option('benzee_plugin_taxonomies');

        if (isset($_POST["remove"])){
            unset($output[$_POST["remove"]]);
            return $output;
        }
        if(count($output) == 0){
            $output[$input['taxonomy']] = $input;
            return $output;
        }
        foreach ($output as $key => $value){
            if ($input['taxonomy'] === $key){
                $output[$key] = $input;
            }else{
                $output[$input['taxonomy']] = $input;
            }
        }
        return $output;
    }

    public function textField( $args ){
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $value = '';
        if (isset($_POST['edit_taxonomy'])){
            $input= get_option($option_name);
            $value = $input[$_POST["edit_taxonomy"]][$name];
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
        if (isset($_POST['edit_taxonomy'])){
            $checkbox = get_option($option_name);
            $checked = isset($checkbox[$_POST['edit_taxonomy']][$name]) ?:false;
        }


        echo '<div class="'.$classes.'"><input type="checkbox" class="'.$classes.'" name="'.$option_name.'['.$name.']" 
        id="'.$name.'" value="1" '.($checked ? 'checked' : '').'>
                   <label for="'.$name.'"></div></div></label>
                </div>';
    }
    public function checkBoxPostTypesField( $args ){

        $output = '';
        $name = $args['label_for'];
        $classes = $args['class'];
        $option_name = $args['option_name'];

        $checked = false;
        if (isset($_POST['edit_taxonomy'])){
            $checkbox = get_option($option_name);

        }

        $post_types = get_post_types(array('show_ui'=> true));

        foreach ($post_types as $post){
            if (isset($_POST['edit_taxonomy'])){
                $checked = isset($checkbox[$_POST['edit_taxonomy']][$name][$post]) ?:false;
            }


            $output .= '<div class="'.$classes.'">
                            <input type="checkbox" class="'.$classes.'mb-10" name="'.$option_name.'['.$name.']['.$post.']" 
                                 id="'.$name.'" value="1" '.($checked ? 'checked' : '').'>
                            <label for="'.$name.'">
                            <strong>'.$post.'</strong></label>
                            
                        </div>';
        }
        echo $output;
    }
}
