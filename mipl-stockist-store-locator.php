<?php
/**
* Plugin Name:       MIPL Stockist/Store Locator - Google Maps, OpenStreetMap, Bing Maps, HERE Maps, Social Media Links, Custom Map Styles, Import/Export Stores
* Plugin URI:        https://wordpress.org/plugins/mipl-stockist-store-locator/
* Description:       Create a quick Stockist/Store Locator with Google map, Autocomplete search location & Distance & Category filter, also with multiple/custom layout and multiple/custom map style, Shortcode [mipl_stockist_store_locator].
* Version:           1.2.8
* Requires at least: 5.1.12
* Requires PHP:      7.0
* Author:            Mulika Team
* Author URI:        https://www.mulikainfotech.com/
* License:           GPL v2 or later
* License URI:       https://www.gnu.org/licenses/gpl-2.0.html
*/


/*
'MIPL Stockist/Store Locator' is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

'MIPL Stockist/Store Locator' is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with 'MIPL Stockist/Store Locator'. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/


// Define Const
define( 'MIPL_SL_URL', plugin_dir_url(__FILE__) );
define( 'MIPL_SL_DIR', plugin_dir_path(__FILE__) );
define( 'MIPL_SL_POST_TYPE', 'mipl_sl_stores' );
define( 'MIPL_SL_MAIN_DIR', basename(dirname( __FILE__ )) );
define( 'MIPL_SL_UNIQUE_NAME', 'mipl-stockist-store-locator' );
define( 'MIPL_SL_PLUGIN_FILE', __FILE__ );

// Include Lib and Classes
include_once MIPL_SL_DIR.'include/lib-mipl-common.php';
include_once MIPL_SL_DIR.'include/class-mipl-core.php';
include_once MIPL_SL_DIR.'include/class-mipl-stockist-stores.php';
include_once MIPL_SL_DIR.'include/class-mipl-stockist-google-map.php';
include_once MIPL_SL_DIR.'include/class-mipl-sl-import-export-settings.php';
include_once MIPL_SL_DIR.'include/class-mipl-input-validation.php';
include_once MIPL_SL_DIR.'include/class-mipl-stockist-custom-fields.php';
include_once MIPL_SL_DIR.'include/blocks/mipl-sl-stockist-blocks.php';
include_once MIPL_SL_DIR.'include/mipl-sl-vc-map.php';



// Create Class Objects
$mipl_core_obj = new mipl_sl_stockist_core();
$mipl_stores_obj = new mipl_sl_stockist_stores();
$mipl_google_map_obj = new mipl_sl_stockist_google_map();
$mipl_imp_exp_settings_obj = new MIPL_SL_Import_Export_Settings();
$mipl_custom_field_obj = new MIPL_SL_Stockist_Custom_Fields();
$mipl_blocks_obj = new MIPL_SL_Blocks();
$mipl_sl_vc_map_obj = new MIPL_SL_Vc_Map();

if( !wp_is_json_request() ){
    add_action('init', array($mipl_core_obj, 'mipl_sl_session'), 1);
}

// Global Hooks
add_action('init', array($mipl_stores_obj, 'register_stores_post_type'));
add_filter('template_include', array($mipl_core_obj, 'mipl_sl_single_stores_page'), 99 );
add_action('after_setup_theme', array($mipl_core_obj, 'thumbnails_theme_support'));



if( !wp_is_json_request() ){
    add_shortcode('mipl_stockist_store_locator', array($mipl_stores_obj, 'mipl_sl_listing'));
}

// Admin side hooks
if( is_admin() ){
    register_activation_hook( __FILE__, array($mipl_core_obj, 'plugin_activation'));
    register_activation_hook( __FILE__, array($mipl_core_obj, 'create_mipl_store_database_table' ));
    
    // Add setting link in plugin list
    add_filter( 'plugin_action_links', array($mipl_core_obj, 'mipl_sl_add_plugin_link'), 10, 2 );
    add_action('admin_enqueue_scripts', array($mipl_core_obj, 'load_admin_scripts_styles'));
    add_action('admin_enqueue_scripts', array($mipl_core_obj, 'add_media_script'));
    add_action('add_meta_boxes', array($mipl_stores_obj, 'add_metaboxes'));
    
    // Save store details
    add_action('save_post', array($mipl_stores_obj, 'save_custom_postmeta'), 10, 3);
    add_filter( 'wp_insert_post_data', array($mipl_stores_obj, 'store_data_filter'), 10, 2 );
    add_action( 'updated_post_meta', array($mipl_stores_obj, 'store_force_draft'), 20, 2 );
    add_filter('manage_'.MIPL_SL_POST_TYPE.'_posts_columns',  array($mipl_stores_obj, 'update_stores_columns'));
    add_action('manage_posts_custom_column', array($mipl_stores_obj, 'show_stores_columns_data'), 5, 2);
    add_action( 'admin_notices', array($mipl_core_obj, 'mi_admin_notices') );
    
    if ( isset($_POST['mipl_action']) && $_POST['mipl_action'] == 'save_settings') {
        add_action('init', array($mipl_core_obj, 'save_settings'));
    }
    
    add_action('admin_menu', array($mipl_core_obj, 'register_admin_menu'));
    
    if( isset($_POST['mipl_action']) && $_POST['mipl_action'] == 'export_settings' ){
        add_action( 'admin_init', array($mipl_imp_exp_settings_obj, 'mipl_stockist_export_settings') );
    }
    
    if( isset($_REQUEST['mipl_action']) && $_REQUEST['mipl_action'] == 'import_settings' ){
        set_time_limit(0);
        add_action( 'admin_init', array($mipl_imp_exp_settings_obj, 'mipl_stockist_import_settings') );
    }

    if ( isset($_REQUEST['mipl_action']) && $_REQUEST['mipl_action'] == 'get-custom-field') {
        add_action('init', array($mipl_custom_field_obj, 'get_custom_field_settings'));
    }
    // add_action('mipl_sl_save_stockist_custom_field', array($mipl_custom_field_obj, 'save_custom_field_group'));
    add_action('mipl_sl_custom_fields', array($mipl_custom_field_obj, 'save_custom_fields'));
    add_action('admin_footer',  array($mipl_core_obj, 'print_deactivate_feedback_dialog'));

    if ( isset($_REQUEST['mipl_action']) && $_REQUEST['mipl_action'] == 'mipl_sl_submit_and_deactivate') {
        add_action('init', array($mipl_core_obj, 'mipl_sl_submit_and_deactivate'));
    }


}


// Client side hooks
if( !is_admin() ){
    
    add_action('wp_head', array($mipl_core_obj, 'mipl_sl_settings') );
    
    $_mipl_sl_map_provider = mipl_sl_get_selected_map_provider();

    if( $_mipl_sl_map_provider == 'mipl-sl-google-map'){
        add_action('wp_enqueue_scripts', array($mipl_google_map_obj, 'load_google_map_scripts_styles'));
        add_action('mipl_sl_before_stockist_widget',array($mipl_google_map_obj,'add_seetings_json_before_widget'));
    }
    
    add_action('wp_enqueue_scripts', array($mipl_core_obj, 'load_scripts_styles'));
    add_action( 'rest_api_init', array($mipl_core_obj,'mipl_sl_stockist_api_data'));

    if(isset($_GET['mi_action']) && $_GET['mi_action'] == 'miplsl_load_store'){
        add_action( 'init', array($mipl_stores_obj, 'mipl_get_stores_html'));
    }

    if(isset($_REQUEST['mipl_action']) && $_REQUEST['mipl_action'] == 'get-store-opening-details'){
        add_action('init', array($mipl_stores_obj, 'get_store_opening_details'));
    }

    add_action('mipl_sl_before_meta_fields',array($mipl_custom_field_obj,'mipl_sl_add_field_before_meta_fields'));
    
}

// MIPL Blocks
add_filter( 'block_categories_all', array($mipl_blocks_obj, 'mipl_sl_custom_block_category'), 10, 2 );
add_action( 'enqueue_block_editor_assets', array($mipl_blocks_obj, 'mipl_sl_stockist_block'));

// Elementor Blocks
add_action( 'elementor/widgets/register', array($mipl_core_obj, 'mipl_sl_register_list_widget') );
add_action( 'elementor/elements/categories_registered', array($mipl_core_obj, 'mipl_sl_add_elementor_widget_categories' ));

// Vc Blocks
if (function_exists( 'vc_map' ) ) {
    add_action( 'vc_before_init', array($mipl_sl_vc_map_obj, 'mipl_sl_vc_map_forms' ));
}