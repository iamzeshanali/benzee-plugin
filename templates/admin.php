<div class="wrap">
    <h1 class="text-tp">Benzee Plugin</h1>
    <?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php
            settings_fields('benzee_options_group');
            do_settings_sections('benzee_plugin');
            submit_button();
        ?>
    </form>
</div>
