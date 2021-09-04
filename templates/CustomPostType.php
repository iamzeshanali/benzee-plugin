<div class="wrap">
    <h1 class="text-tp">Custom Post Type</h1>
    <?php settings_errors();?>

    <ul class="nav nav-tabs">
        <li class="<?php echo !isset($_POST['edit_post']) ? 'active':'' ?>"><a href="#tab-1">Your Custom Post Types</a></li>
        <li class="<?php echo isset($_POST['edit_post']) ? 'active':'' ?>">
            <a href="#tab-2">
                <?php echo isset($_POST['edit_post']) ? 'Edit':'Add' ?> Custom Post Types
            </a></li>
        <li class=""><a href="#tab-3">Export</a></li>
    </ul>

    <div class="tab-content">
        <div id="tab-1" class="tab-pane <?php echo !isset($_POST['edit_post']) ? 'active':'' ?>">
            <h3>Manage Your Custom Post types</h3>
            <?php
            $allOptions = get_option('benzee_plugin_cpt') ?: array();

            echo '<table>
                <tr>
                    <th>ID</th>
                    <th>Singular Name</th>
                    <th>Public</th>
                    <th>Archive</th>
                    <th>Actions</th>
                </tr>';
            foreach ($allOptions as $options){
                $public = isset($options['public']) ? "True" : "False";
                $archive = isset($options['has_archive']) ? "True" : "False";
                echo "
                        <tr>
                        <td>{$options['post_type']}</td>
                        <td>{$options['singular_name']}</td>
                        <td>{$public}</td>
                        <td>{$archive}</td>
                        <td>";
                echo '<form method="post" action="" class="inline-block">';
                echo '<input type="hidden" name="edit_post" value="'.$options['post_type'].'">';
                submit_button('Edit', 'primary small', 'submit', false);
                echo '</form> ';
                echo '<form method="post" action="options.php" class="inline-block">';
                settings_fields('benzee_plugin_cpt_setting');
                echo '<input type="hidden" name="remove" value="'.$options['post_type'].'">';
                submit_button('Delete', 'delete small', 'submit', false, array(
                        'onClick' => 'return confirm("Are you sure you want to delete this Custom Post Type?
                         The data associated with ot will not be deleted.");'
                ));
                echo '</form></td></tr>';

            }
            echo '</table>';
            ?>
        </div>

        <div id="tab-2" class="tab-pane <?php echo isset($_POST['edit_post']) ? 'active':'' ?>">
            <form method="post" action="options.php">
                <?php
                settings_fields('benzee_plugin_cpt_setting');
                do_settings_sections('benzee_cpt');
                submit_button();
                ?>
            </form>
        </div>

        <div id="tab-3" class="tab-pane">
            <h3>Export</h3>
        </div>
    </div>

</div>