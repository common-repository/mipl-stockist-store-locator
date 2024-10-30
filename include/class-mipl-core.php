<?php

class mipl_sl_stockist_core {

    //load client side scripts and styles
    function load_scripts_styles() {

        wp_enqueue_script('jquery');
        wp_enqueue_script('mipl-sl-stockist', MIPL_SL_URL . 'assets/js/mipl-sl-stockist.min.js', array('jquery'));
        wp_enqueue_style('mipl-sl-stockist-style', MIPL_SL_URL . 'assets/css/mipl-sl-stockiest.min.css');
        wp_enqueue_style('mipl-sl-stockist-single-style', MIPL_SL_URL . 'assets/css/mipl-sl-stockiest-single-page.min.css');
        wp_enqueue_style('mipl-sl-icons', MIPL_SL_URL . 'assets/mipl-sl-icons/styles.min.css');
        if (is_single()) {
            wp_enqueue_script('mipl-sl-stockist-single', MIPL_SL_URL . 'assets/js/mipl-sl-stockist-single-page.min.js', array('jquery'));
        }

        // Localize the script with the translated strings
        wp_localize_script('mipl-sl-stockist', 'mipl_sl_scriptvars', array(
            'nosearchresult' => mipl_sl_get_label('no_search_result'),
            'submit' => esc_html__('Submit'),
            'loading' => mipl_sl_get_label('loading'),
            'get' => esc_html__('Get'),
            'directions' => esc_html__('Directions'),
            'get_directions' => mipl_sl_get_label('get_directions')
        ));

    }


    // load admin side scripts and styles
    function load_admin_scripts_styles() {

        wp_enqueue_script('jquery');
        wp_enqueue_script('mipl-sl-admin-stockist', MIPL_SL_URL . 'assets/js/mipl-sl-admin-stockist.min.js', array('jquery'));
        wp_enqueue_style('mipl-sl-admin-styles', MIPL_SL_URL . 'assets/css/mipl-sl-stockiest-admin.min.css');
        
    }


    // use thumbnail support
    function thumbnails_theme_support() {
        add_theme_support('post-thumbnails');
    }


    // use enqueue media
    function add_media_script() {
        wp_enqueue_media();
    }


    function mipl_sl_add_plugin_link($plugin_actions, $plugin_file) {

        $new_actions = array();

        if (plugin_basename(MIPL_SL_PLUGIN_FILE) === $plugin_file) {

            $new_actions['cl_settings'] = sprintf(__('<a href="%s">Settings</a>', 'comment-limiter'), esc_url(admin_url('edit.php?post_type=mipl_sl_stores&page=mipl-sl-settings')));
        }

        return array_merge($new_actions, $plugin_actions);
    }


    // Plugin Activation
    function plugin_activation() {

        $activated_plugins = array();
        $apl = get_option('active_plugins');
        $plugins = get_plugins();

        foreach ($apl as $p) {
            if (isset($plugins[$p])) {
                $activated_plugins[$plugins[$p]['Name']] = $plugins[$p];
            }
        }

        $count = 0;
        $deactivate_plugins = array(
            'MIPL Stockist/Store Locator - Pro' => array(
                'plugin_name' => 'MIPL Stockist/Store Locator - Pro',
                'dir_path' => '/mipl-stockist-store-locator-pro/mipl-stockist-store-locator-pro.php'
            ),
        );

        foreach ($activated_plugins as $key => $plugin) {
            if (isset($deactivate_plugins[$key]['plugin_name'])) {
                if ($deactivate_plugins[$key]['plugin_name'] == $plugin['Name']) {
                    deactivate_plugins($deactivate_plugins[$key]['dir_path'], true);
                }
                $count++;
            }
        }

        if ($count > 0) {
            $_SESSION['mipl_sl_admin_notices']['success'] = __($count . ' Plugin deactivated.');
        }
    }


    // create database table
    function create_mipl_store_database_table() {

        global $wpdb;

        $table_name = $wpdb->prefix . "mipl_store_locator";

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            `id` int(20) NOT NULL auto_increment,
            `post_id` int(20) NOT NULL,
            `latitude` varchar(50) NOT NULL,
            `longitude` varchar(50) NOT NULL,
            PRIMARY KEY id (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        $default_settiong = get_option('_mipl_sl_default_settings');
        if ($default_settiong != 'saved') {
            mipl_sl_default_settings();
        }
    }


    // create admin menu
    function register_admin_menu() {

        add_submenu_page('edit.php?post_type=' . MIPL_SL_POST_TYPE, __('Store Settings'), __('Settings'), 'manage_options', sanitize_key('mipl-sl-settings'), array($this, 'setting_listing'));

        $mipl_imp_exp_settings_obj = new MIPL_SL_Import_Export_Settings();
        add_submenu_page('edit.php?post_type=' . MIPL_SL_POST_TYPE, __('Tools'), __('Tools'), 'manage_options', sanitize_key('mipl-tools'), array($mipl_imp_exp_settings_obj, 'import_export_sttings'));

        add_submenu_page('edit.php?post_type=' . MIPL_SL_POST_TYPE, __('Addons'), __('Addons'), 'manage_options', sanitize_key('mipl-sl-addons'), array($this, 'mipl_sl_addons'));

    }


    // show setting list
    function setting_listing() {

        $map_service_provider = array(
            'mipl-sl-google-map' => array("title" => "Google Map", "installed" => true, "active" => true, "activation_key" => true, "link" => "#", "value" => "mipl-sl-google-map"),
            'mipl-sl-openstreetmap' => array("title" => "OpenStreetMap", "installed" => false, "active" => false, "activation_key" => false, "link" => "https://store.mulika.in/product/mipl-stockist-store-locator-openstreetmap/", "value" => "MIPL Stockist/Stores Locator - OpenStreetMap"),
            'mipl-sl-bing-map' => array("title" => "Bing Map", "installed" => false, "active" => false, "activation_key" => false, "link" => "https://store.mulika.in/product/mipl-stockist-stores-locator-bing-map-addon/", "value" => "MIPL Stockist/Stores Locator - Bing Map"),
            'mipl-sl-here-map' => array("title" => "HERE Map", "installed" => false, "active" => false, "activation_key" => false, "link" => "https://store.mulika.in/product/mipl-stockist-stores-locator-here-map-addon/", "value" => "MIPL Stockist/Stores Locator - HERE Map"),
        );

        $map_service_provider = apply_filters('mipl_sl_service_provider', $map_service_provider);

        include_once MIPL_SL_DIR . '/views/mipl-stockist-admin-settings.php';
    }


    function mipl_sl_addons() {
        include_once MIPL_SL_DIR . '/views/mipl-stockist-addons.php';
    }


    // Save settings
    function save_settings() {

        $settings_fields = mipl_sl_get_settings_fields();

        foreach ($settings_fields as $setting_field => $field_value) {
            if (isset($field_value['type']) && $field_value['type'] == "checkbox") {
                if (!isset($_POST[$setting_field])) {
                    $_POST[$setting_field] = "";
                }
            }
        }

        $val_obj = new MIPL_SL_Input_Validation($settings_fields);
        $val_obj->validate();
        $errors = $val_obj->get_errors();
        $post_data = $val_obj->get_valid_data();

        foreach ($post_data as $key => $value) {
            update_option($key, $value);
        }
        $custom_fields = "";
        $store_custom_fields = "";
        $custom_fields_errors = "";
        if (isset($_POST['_mipl_sl_stockist_custom_fields'])) {
            $custom_fields = $_POST['_mipl_sl_stockist_custom_fields'];
            $mipl_custom_field_obj = new MIPL_SL_Stockist_Custom_Fields();
            $store_custom_fields = $mipl_custom_field_obj->mipl_sl_get_custom_field_validate_data($custom_fields);
            if(is_array($store_custom_fields) && isset($store_custom_fields['errors'])){
                $custom_fields_errors = 'Some store fields have a validation issue!';
            }
            update_option('_mipl_sl_stockist_custom_fields', $store_custom_fields);
        }else{
            update_option('_mipl_sl_stockist_custom_fields', $store_custom_fields);
        }
        do_action('mipl_sl_save_stockist_custom_field');

        flush_rewrite_rules();

        //header("Location: ".admin_url("edit.php?post_type=".MIPL_SL_POST_TYPE."&page=mipl-sl-settings"));

        if (!empty($errors)) {
            $error_message = implode('<br />', $errors);
            echo json_encode(array('status' => 'error', 'error_massage' => $error_message));
        } else {
            
            echo json_encode(array('status' => 'success', 'success_message' => __("Successfully Saved!"), 'error_massage' => __($custom_fields_errors) ));
            
        }

        die();
    }


    // apply styles
    function mipl_sl_settings() {

        global $post;
        $primary_color = get_option('_mipl_sl_primary_color');
        $background_color = get_option('_mipl_sl_background_color');
        $height = get_option('_mipl_sl_map_height');
        ?>

        <script>
            let $MIPL_SL_SITE_URL = '<?php echo esc_url(home_url('/')); ?>';
            let $MIPL_ENDPOINT = '<?php echo esc_url(get_rest_url()); ?>';
            <?php
            $mipl_sl_map_provider = mipl_sl_get_selected_map_provider();
            if (get_option('_mipl_sl_here_map_api_key') &&
                $mipl_sl_map_provider == 'mipl-sl-here-map') {
                ?>
                let $MIPL_HERE_MAPS_KEY = '<?php echo esc_html(get_option('_mipl_sl_here_map_api_key')); ?>';
                <?php
            }
            ?>
        </script>
        <?php
        list($r, $g, $b) = sscanf($background_color, "#%02x%02x%02x");
        $rgb_color = "rgba($r,$g,$b,0.8)";
        ?>
        <style>
            .mipl_sl_stockist_wrapper,
            .mipl_sl_stockist .mipl_sl_stockist_map_tag {
                height:<?php echo esc_html($height) ?>px;
            }
            .mipl-sl-icon {
                fill:<?php echo esc_html($primary_color); ?>;
            }
            .mipl_sl_stockist_item .icon, .mipl_sl_infowindow_content .icon {
                color:<?php echo esc_html($primary_color); ?>;
            }
            .mipl_sl_stockist_sidebar,
            .mipl_sl_stockist_filter {
                background:<?php echo esc_html($background_color); ?>;
            }
            .mipl_sl_filter_button{
                color: white;
                background:<?php echo esc_html($primary_color); ?>;
            }
            .mipl_sl_stockist_item strong,
            .mipl_sl_infowindow_content strong{
                color:<?php echo esc_html($primary_color); ?>;
            }
            .mipl_sl_border_color {
                border: 1px solid <?php echo esc_html($primary_color); ?>!important;
            }

            .mipl_sl_template7 .mipl_sl_stockist_sidebar,
            .mipl_sl_template8 .mipl_sl_stockist_sidebar,
            .mipl_sl_template11 .mipl_sl_stockist_sidebar,
            .mipl_sl_template12 .mipl_sl_stockist_sidebar,
            .mipl_sl_template7 .mipl_sl_stockist_filter,
            .mipl_sl_template8 .mipl_sl_stockist_filter,
            .mipl_sl_template10 .mipl_sl_stockist_filter {
                background:<?php echo esc_html($rgb_color); ?>;
            }
        </style>
        <?php
    }


    // show success or error massage
    function mi_admin_notices() {

        $message_type = array('error', 'success', 'warning', 'info');
        foreach ($message_type as $type) {
            $class = 'notice is-dismissible';

            if (isset($_SESSION['mipl_sl_admin_notices'][$type]) && trim($_SESSION['mipl_sl_admin_notices'][$type]) != '') {
                $class = $class . ' notice-' . $type;
                $message = wp_kses_post($_SESSION['mipl_sl_admin_notices'][$type]);
                printf('<div class="%1$s"><p>%2$s</p></div>', $class, $message);
                unset($_SESSION['mipl_sl_admin_notices'][$type]);
            }
        }
    }


    // start session
    function mipl_sl_session() {

        if (!session_id()) {
            session_start();
        }

    }


    // 
    function mipl_sl_single_stores_page($template) {

        global $post;

        if (!isset($post->ID)) {
            return $template;
        }

        $post_type = get_post_type($post->ID);

        if ($post_type == MIPL_SL_POST_TYPE) {

            $temp_file = basename($template);

            if ($temp_file != 'single-mipl_sl_stores.php') {
                $template_file = MIPL_SL_DIR . 'single-mipl_sl_stores.php';
                return $template_file;
            }
        }

        return $template;
        
    }


    // 
    function mipl_sl_stockist_api_data() {

        $mipl_google_map_obj = new mipl_sl_stockist_google_map();
        $mipl_sl_map_provider = mipl_sl_get_selected_map_provider();

        if ($mipl_sl_map_provider == 'mipl-sl-google-map') {
            register_rest_route('mipl-stockist-store-locator/v1', '/get-map-settings', array(
                'methods' => 'GET, POST',
                'callback' => array($mipl_google_map_obj, 'mipl_get_map_settings'),
                'permission_callback' => '__return_true'
            ));
        }

        $mipl_stores_obj = new mipl_sl_stockist_stores();
        register_rest_route('mipl-stockist-store-locator/v1', '/get-map-filters', array(
            'methods' => 'GET, POST',
            'callback' => array($mipl_stores_obj, 'mipl_get_map_filter'),
            'permission_callback' => '__return_true'
        ));
    }


    // Plugin deactivation popup
    function print_deactivate_feedback_dialog() {
        global $pagenow;
        if ($pagenow == "plugins.php") {
            ?>

            <div id="deactive-mipl-stockist-store-locator" style="display:none;">

            <?php
            $deactivate_reasons = [
                'no_longer_needed' => [
                    'title' => esc_html__('I no longer need the plugin'),
                    'input_placeholder' => '',
                ],
                'found_a_better_plugin' => [
                    'title' => esc_html__('I found a better plugin', 'Plugin Name'),
                    'input_placeholder' => esc_html__('Please share which plugin'),
                ],
                'couldnt_get_the_plugin_to_work' => [
                    'title' => esc_html__("I couldn't get the plugin to work"),
                    'input_placeholder' => '',
                ],
                'temporary_deactivation' => [
                    'title' => esc_html__("It's a temporary deactivation"),
                    'input_placeholder' => '',
                ],
                'other' => [
                    'title' => esc_html__('Other', 'Plugin Name'),
                    'input_placeholder' => esc_html__('Please share the reason'),
                ],
            ];
            ?>

                <form id="mipl_sl_deactivation_form" method="post" style="margin-top:20px;margin-bottom:30px;">
                    <div id="" style="font-weight: 700; font-size: 15px; line-height: 1.4;"><?php echo esc_html__('If you have a moment, please share why you are deactivating plugin:'); ?></div>
                    <div id="" style="padding-block-start: 10px; padding-block-end: 0px;">
                    <?php foreach ($deactivate_reasons as $reason_key => $reason) { ?>
                            <div class="" style="display: flex; align-items: center; line-height: 2; overflow: hidden;">
                                <label>
                                    <input id="plugin-deactivate-feedback-<?php echo esc_attr($reason_key); ?>" class="" style="margin-block: 0; margin-inline: 0 15px; box-shadow: none;" type="radio" name="mipl_sl_deactivation_reason" value="<?php echo esc_attr($reason_key); ?>" required /><?php echo esc_html($reason['title']); ?>
                                </label>
                            </div>
                    <?php } ?>
                    </div>

                    <div id="mipl-sl-other-reason-textarea">
                        <textarea style="vertical-align:top;margin-left: 30px;" id="other-reason" name="mipl_sl_deactivation_other_reason" rows="4" cols="50" placeholder="Please share the reason" ></textarea>
                    </div>

                    <div class="" style="display: flex;  padding: 20px 0px;">
                        <button class="mipl_sl_submit_and_deactivate button button-primary button-large" type="submit" style="margin-right:10px;"><?php echo esc_html__('Submit & Deactivate'); ?></button>
                        <button class="mipl_sl_skip_and_deactivate button" type="button" ><?php echo esc_html__('Skip & Deactivate'); ?></button>
                    </div>

                </form>

            </div>

            <script>
                jQuery(document).ready(function () {

                    jQuery('#deactivate-mipl-stockist-store-locator').click(function () {
                        var $deactivate_url = jQuery(this).attr('href');
                        tb_show("Quick Feedback", "#TB_inline?&amp;inlineId=deactive-mipl-stockist-store-locator&amp;height=500;max-height: 330px; min-height: 330px;");
                        jQuery('#TB_window form').attr('data-deactivate_url', $deactivate_url);
                        return false;
                    });

                });


                jQuery(document).ready(function () {

                    jQuery('.mipl_sl_skip_and_deactivate').click(function () {
                        mipl_sl_deactivate_plugins();
                        return false;
                    });

                    jQuery('#mipl_sl_deactivation_form').submit(function () {
                        mipl_sl_deactivate_plugins();
                        return false;
                    });

                });


                function mipl_sl_deactivate_plugins() {

                    var $form_data = jQuery('#mipl_sl_deactivation_form').serializeArray();
                    var $deactivate_url = jQuery('#mipl_sl_deactivation_form').attr('data-deactivate_url');
                    jQuery('#mipl_sl_deactivation_form button').attr('disabled', 'disabled');
                    jQuery.post('?mipl_action=mipl_sl_submit_and_deactivate', $form_data, function (response) {
                        window.location = $deactivate_url;
                    });

                    return false;

                }


                jQuery(document).ready(function () {

                    jQuery('#mipl_sl_deactivation_form').on('change', 'input[name="mipl_sl_deactivation_reason"]', function () {
                        $feedback_val = jQuery(this).val();
                        jQuery('#mipl-sl-other-reason-textarea textarea').removeAttr('required');
                        if ($feedback_val == 'other') {
                            jQuery('#mipl-sl-other-reason-textarea textarea').attr('required', 'required');
                        }
                    });

                });

            </script>
            <?php
        }
    }


    // 
    function mipl_sl_submit_and_deactivate() {

        $feedback = "";
        if (isset($_POST['mipl_sl_deactivation_reason'])) {
            $feedback = sanitize_text_field($_POST['mipl_sl_deactivation_reason']);
        }

        if ($feedback == 'other' && isset($_POST['mipl_sl_deactivation_other_reason'])) {
            $feedback = sanitize_textarea_field($_POST['mipl_sl_deactivation_other_reason']);
        }

        if (empty($feedback)) {
            $feedback = 'Skipped feedback and plugin deactivated';
        }

        $deactivation_date = current_time('mysql');
        $home_url = home_url();
        $url = 'https://store.mulika.in/api/wp/v1/plugin/feedback/';
        $args = array(
            'method' => 'POST',
            'timeout' => 2,
            'body' => array(
                'home_url' => $home_url,
                'plugin_name' => MIPL_SL_UNIQUE_NAME,
                'deactivation_date' => $deactivation_date,
                'feedback' => $feedback
            )
        );

        $response = wp_remote_post($url, $args);

        if (is_wp_error($response)) {
            // $error_message = $response->get_error_message();
        } else {
            // echo json_encode( $response );
        }

        die();
    }


    // Add Elementor widget
    function mipl_sl_register_list_widget($widgets_manager) {

        include_once MIPL_SL_DIR . '/include/mipl-sl-elementor-block.php';
        $widgets_manager->register(new MIPL_SL_Stockist_Widget());

    }


    // Elementor Block Category
    function mipl_sl_add_elementor_widget_categories($elements_manager) {

        $elements_manager->add_category(
            'stockist-stores',
            [
                'title' => esc_html__('MIPL Stockist Store Locator'),
            // 'icon' => 'fa fa-plug',
            ]
        );
        
    }

}
