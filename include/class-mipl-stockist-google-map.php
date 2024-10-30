<?php
class mipl_sl_stockist_google_map{

    //load google map scripts and styles
    function load_google_map_scripts_styles(){
        $google_map_api_key = get_option('_mipl_sl_google_map_api_key');
        wp_enqueue_script('mipl-sl-google-maps-cluster', MIPL_SL_URL.'assets/libs/markerclusterer/dist/index.min.js',  array(), '', true);
        wp_enqueue_script('mipl-sl-google-maps', 'https://maps.googleapis.com/maps/api/js?key='.$google_map_api_key.'&callback=mipl_sl_stockist_init_map&libraries=geometry,places', array(), '', true);
        wp_enqueue_script('mipl-sl-google-map', MIPL_SL_URL.'assets/js/mipl-sl-google-map.min.js', array('jquery'));
    } 
    
    
    // add settings before widget
    function add_seetings_json_before_widget(){
        return false; //disabled
        $map_settings = $this->mipl_get_map_settings();
        ?>
        <script>
        // var $MIPL_SL_MAP_SETTINGS = JSON.parse('<?php $map_settings;?>');
        </script>
        <?php
    }


    // map settings
    function mipl_get_map_settings(){

        include_once  MIPL_SL_DIR.'views/mipl-stockist-google-map-style.php';

        $mipl_google_map_settings = [];
    
        $mipl_google_map_settings['default_zoom'] = get_option('_mipl_sl_google_map_default_zoom');
        $Default_Location = get_option('_mipl_sl_google_map_default_location');
        $Default_loc = explode(",",$Default_Location);
        $map_type = get_option('_mipl_sl_google_map_type');
        
        $mipl_google_map_settings['default_location']= $Default_loc;
        $mipl_google_map_settings['map_type'] =  $map_type;
    
        $zoom_as_per_the_map_pins = get_option('_mipl_sl_google_zoom_as_per_the_map_pins');
        $mipl_google_map_settings['zoom_as_per_the_map_pins'] =  $zoom_as_per_the_map_pins;

        $map_controller = get_option('_mipl_sl_google_map_controller');
        $mipl_google_map_settings['map_controller'] =  $map_controller;

        $radius_circle = get_option('_mipl_sl_google_map_radius_circle');
        $mipl_google_map_settings['radius_circle'] =  $radius_circle;

        $markerclusterer = get_option('_mipl_sl_google_map_markerclusterer');
        $mipl_google_map_settings['markerclusterer'] =  $markerclusterer;
    
        $mipl_sl_map_style = get_option('_mipl_sl_google_map_style'); 
        if($mipl_sl_map_style == 'custom_style'){
           $mipl_sl_custom_map_style = get_option('_mipl_sl_google_map_custom_style');
            $mipl_google_map_settings['map_style'] =  base64_encode(stripslashes($mipl_sl_custom_map_style));
        }else{
            $mipl_google_map_settings['map_style'] = base64_encode(stripslashes(get_style($mipl_sl_map_style)));
        }
        $layout_types = array('template7', 'template9', 'template10', 'template11'); 
        $layout_type = get_option('_mipl_sl_layout_type');
        
        if(in_array($layout_type, $layout_types)){
            
            $mipl_google_map_settings['map_controller'] =  1;
            
        }
        $mipl_google_map_settings['layout'] =  get_option('_mipl_sl_layout_type');
        $mipl_google_map_settings['map_height'] = get_option('_mipl_sl_map_height');
        $mipl_google_map_settings['curr_loc_map_pin'] = mipl_sl_get_current_loc_map_pin();

        $mipl_google_map_settings['store_map_pin'] = mipl_sl_get_store_loc_map_pin();
        $open_info_window = get_option('_mipl_sl_open_info_window');
        $mipl_google_map_settings['open_info_window'] = $open_info_window;
        return $mipl_google_map_settings;
     
    }

}