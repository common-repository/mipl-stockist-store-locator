<?php
class MIPL_SL_Import_Export_Settings{

    function register_admin_menu(){

        // add_submenu_page( 'edit.php?post_type='.MIPL_SL_POST_TYPE, 'Tools',  'Tools',  'manage_options', sanitize_key('mipl-tools'), array($this,'import_export_sttings'));
	
    }


    function import_export_sttings(){
        ?>
        <div id="wpbody" role="main">
        <div id="wpbody-content">
        <div class="wrap" id="mipl-admin-tools">
            <h1><?php echo esc_html__('Tools');?></h1>
            
            <?php do_action('mipl_sl_stores_import_export_form'); ?>

            <div class="mipl-meta-box-wrap -grid">
            <div id="normal-sortables" class="meta-box-sortables">
            <div id="mipl-admin-tool-export" class="postbox ">
                <div class="postbox-header">
                    <h2 class="hndle"><?php echo esc_html__('Export Settings');?></h2>
                </div>
                <div class="inside">
                <form action="" method="post">
                <p class="mipl-submit">
                <input type="hidden" name="mipl_action" value="export_settings">
                <button type="submit" name="mipl_action" class="button button-primary" value="export_settings"><?php echo esc_html__('Export Settings'); ?></button>
                </p>
                </form>
                </div>
            </div>
            <div id="mipl-admin-tool-import" class="postbox ">
                <div class="postbox-header">
                    <h2 class="hndle"><?php echo esc_html__('Import Settings');?></h2>
                </div>
                <div class="inside">
                <form method="post" class="mipl_sl_import_setting" enctype="multipart/form-data">
                <div class="mipl-fields">
                <div class="mipl-field mipl-field-file" data-name="mipl_import_file" data-type="file">
                <!-- <div class="mipl-label">
                    <label for="mipl_import_file">Select File</label>
                </div> -->
                <div class="mipl-input">
                <div class="mipl-file-uploader" data-library="all" data-mime_types="" data-uploader="basic">
                    <strong><?php echo esc_html__('Select File');?></strong>: <input type="file" name="import_file">
                    <!-- File format: <a href="<?php plugins_url( 'example-1.csv', __FILE__ );?>" download>example-1.csv</a><br> -->
                </div>
                </div>
                </div>
                </div>
                <p class="mipl-submit">
                <input type="hidden" name="mipl_action" value="import_settings" >
                <button class="button button-primary" type="submit" name="mipl_action" value="import_settings"><?php echo esc_html__('Import Settings');?></button>
                </p>
                </form>
                </div>
            </div>
            </div>
            </div>
        </div>
        <div class="clear"></div>
        </div>
        <div class="clear"></div>
        </div>
        <?php
    }


    function mipl_stockist_export_settings() {

        if(isset($_POST['mipl_action'])) {

        $setting_keys = array(
            'distance_unit' =>   '_mipl_sl_distance_unit', 
            'distances' =>   '_mipl_sl_distances',  
            'default_distance' =>   '_mipl_sl_default_distance',
            'display_time_on_list'  => '_mipl_sl_display_time_on_list', 
            'display_time_on_infowindow' => '_mipl_sl_display_time_on_infowindow', 
            'display_social_on_list' => '_mipl_sl_display_social_on_list', 
            'display_social_on_infowindow' => '_mipl_sl_display_social_on_infowindow', 
            'disable_stores_public_url'  => '_mipl_sl_disable_stores_public_url', 
            'map_provider'  => '_mipl_sl_map_provider', 
            'open_info_window'  => '_mipl_sl_open_info_window', 
            'layout_type'  => '_mipl_sl_layout_type', 
            'custom_template'  => '_mipl_sl_custom_template', 
            'primary_color'  => '_mipl_sl_primary_color', 
            'background_color'  => '_mipl_sl_background_color', 
            'map_height'  => '_mipl_sl_map_height', 
            'map_current_location_icon'  => '_mipl_sl_map_current_location_icon', 
            'map_current_location_custom_pin'  => '_mipl_sl_map_current_location_custom_pin', 
            'map_stores_location_icon' => '_mipl_sl_map_stores_location_icon',
            'map_stores_location_custom_pin'  => '_mipl_sl_map_stores_location_custom_pin', 
            'labels'  => '_mipl_sl_labels', 
            'google_map_api_key'  => '_mipl_sl_google_map_api_key', 
            'google_map_default_location'  => '_mipl_sl_google_map_default_location', 
            'google_map_default_zoom' => '_mipl_sl_google_map_default_zoom',
            'google_map_controller'  => '_mipl_sl_google_map_controller', 
            'google_map_type' => '_mipl_sl_google_map_type', 
            'google_map_style' => '_mipl_sl_google_map_style', 
            'google_map_custom_style' => '_mipl_sl_google_map_custom_style',
            'store_fields' => '_mipl_sl_stockist_custom_fields',
            'hide_image_on_list' => '_mipl_sl_hide_image_on_list',
            'hide_image_on_infowindow' => '_mipl_sl_hide_image_on_infowindow',
            'google_zoom_as_per_the_map_pins' => '_mipl_sl_google_zoom_as_per_the_map_pins',
        );
        
        $setting_keys = apply_filters('mipl_sl_settings_keys', $setting_keys);
        
        $settings = array();
        foreach($setting_keys as $setting_key => $setting_val){

            if($setting_key != '_mipl_sl_labels'){
                $settings[$setting_key] = get_option($setting_val);
            }else{
                $labels = get_option($setting_val);
                $settings[$setting_key] = serialize($labels);                    
            }
            
        }

        header('Content-Description: File Transfer');
        header( 'Content-Type: application/json; charset=utf-8' );
        header( 'Content-Disposition: attachment; filename=mipl-settings-export-' . current_time( 'Y-m-d-h-i-s',1) . '.json' );
        header('Content-Transfer-Encoding: binary');
        header( "Expires: 0" );
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        echo json_encode($settings, JSON_PRETTY_PRINT);
        exit();

        }

    }


    function mipl_stockist_import_settings(){
                        
        if ($_FILES["import_file"]["error"] != UPLOAD_ERR_OK) {
            wp_die( __( 'Please upload a valid .json file' ) );
        }
         
        if($_FILES['import_file']['type'] != 'application/json'){
            wp_die( __( 'Please upload a valid .json file' ) );
        }
        
        $import_file_name = $_FILES['import_file']['name'];
        $file_explode_array = explode( '.', $import_file_name );
        
        $extension = end( $file_explode_array );
        
        if( $extension != 'json' ) {
            wp_die( __( 'Please upload a valid .json file' ) );
        }

        $import_file = $_FILES['import_file']['tmp_name'];

        if( empty( $import_file ) ) {
            wp_die( __( 'Please upload a file to import' ) );
        }
        
        $settings = (array) json_decode( file_get_contents( $import_file ) );
        
        $prefix = '_mipl_sl_';
        
        foreach($settings as $key => $val){
            if($key != 'labels' && $key != 'custom_fields' && $key != 'store_fields'){
                $mipl_settings[$prefix.$key] = $val;
            } elseif($key == 'labels' || $key == 'custom_fields') {
                $mipl_settings[$prefix.$key] = (array)$val;
            }elseif ($key == 'store_fields') {
                if(!empty($val)){
                    $mipl_settings['_mipl_sl_stockist_custom_fields'] = (array)$val;
                }                
            }
        }

        if (isset($mipl_settings['_mipl_sl_stockist_custom_fields'])) {
            $mipl_custom_field_obj = new MIPL_SL_Stockist_Custom_Fields();
            $custom_fields = $mipl_settings['_mipl_sl_stockist_custom_fields'];
            $store_custom_fields = $mipl_custom_field_obj->mipl_sl_get_custom_field_validate_data($custom_fields);
            update_option('_mipl_sl_stockist_custom_fields', $store_custom_fields);
        }

        $settings_fields = mipl_sl_get_settings_fields();

        $val_obj = new MIPL_SL_Input_Validation($settings_fields, $mipl_settings);
        $val_obj->validate();
        $setting_data = $val_obj->get_valid_data();
        $validation_errors = $val_obj->get_errors();
        
        foreach($setting_data as $key => $value){
            update_option($key, $value);
        }
        
        if( !empty($validation_errors) ){
            $_SESSION['mipl_sl_admin_notices']['error'] = implode("<br/>", $validation_errors);
        }else{
            $_SESSION['mipl_sl_admin_notices']['success'] = __('Setting saved successfully');
        }
        
        header("Location: ". admin_url( "edit.php?post_type=".MIPL_SL_POST_TYPE."&page=mipl-sl-settings" ) );
        
        exit();

    }
    
}