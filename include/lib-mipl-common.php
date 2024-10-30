<?php 

//Get Default labels
if (!function_exists('mipl_sl_get_default_labels')){
    function mipl_sl_get_default_labels(){
        
        $default_labels = array(
            'store' => 'Stores',
            'store_category' => 'Store Category',
            'address' => 'Address',
            'location' => 'Location(Lat,Long)',
            'email' => 'Email',
            'phone' => 'Phone',
            'author' => 'Author',
            'image' => 'Image',
            'address_line' => 'Address Line',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
            'post_code' => 'Post Code',
            'map_location_latitude' => 'Map Location (Latitude)',
            'map_location_longitude' => 'Map Location (Longitude)',
            'website' => 'Website',
            'telephone' => 'Telephone',
            'fax' => 'Fax',
            'days' => 'Days',
            'opening_hours' => 'Opening Hours',
            'closing_hours' => 'Closing Hours',
            'closed' => 'Closed',
            'sunday' => 'Sunday',
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'twitter' => 'Twitter',
            'linkedin' => 'LinkedIn',
            'youtube' => 'YouTube',
            'whatsapp' => 'WhatsApp',
            'skype' => 'Skype',
            'pinterest' => 'Pinterest',
            'yelp' => 'Yelp',
            'trustpilot' => 'Trustpilot',
            'tripadvisor' => 'Trip Advisor',
            'google' => 'Google Business',
            'stores_details' => 'Stores Details',
            'social_media_links' => 'Social Media & Reviews',
            'store_custom_fields' => 'Store Custom Fields',
            'enter_your_location' => 'Enter Your Location',
            'select_distance' => 'Select Distance',
            'all_category' => 'All Category',
            'submit' => 'Search',
            'your_location' => 'Your Location',
            'get_directions' => 'Get Directions',
            'no_search_result' => 'No Search Result',
            'loading' => 'Loading',
        );
        
        return $default_labels;
        
    }
}


// Get label
if (!function_exists('mipl_sl_get_label')){
    function mipl_sl_get_label($label){
        
        $default_labels = mipl_sl_get_default_labels();
        
        if( !isset($GLOBALS['MIPL_SL_LABLES']) ){
            $saved_labels = get_option('_mipl_sl_labels');
            $GLOBALS['MIPL_SL_LABLES'] = $saved_labels;
        }else{
            $saved_labels = $GLOBALS['MIPL_SL_LABLES'];
        }

        if( isset($saved_labels[$label]) && !empty($saved_labels[$label]) ){
            return __($saved_labels[$label]);
        }

        if( isset($default_labels[$label]) ){
            return __($default_labels[$label]);
        }
        
        return $label;

    }
}


// Get current location map pin
if (!function_exists('mipl_sl_get_current_loc_map_pin')){
    function mipl_sl_get_current_loc_map_pin(){

        $default_pins = mipl_sl_get_marker_icons();

        $default_pins_key = array_keys($default_pins);
        $map_pin = MIPL_SL_URL.'assets/images/'.$default_pins_key[0];

        $curr_loc_pin = get_option('_mipl_sl_map_current_location_icon');
        if( !empty($curr_loc_pin) ){
            
            $map_pin = MIPL_SL_URL.'assets/images/'.$curr_loc_pin;
            if($curr_loc_pin == "custom_map_marker"){
                $property_images = get_option( '_mipl_sl_map_current_location_custom_pin' );
                $your_img_src = wp_get_attachment_image_src( $property_images, 'full' );
                $map_pin = $your_img_src[0];
            }
            
        }

        return $map_pin;

    }
}


//Get stores location map pin
if (!function_exists('mipl_sl_get_store_loc_map_pin')){
    function mipl_sl_get_store_loc_map_pin(){

        $default_pins = mipl_sl_get_marker_icons();
        $default_pins_key = array_keys($default_pins);
        $map_pin = MIPL_SL_URL.'assets/images/'.$default_pins_key[5];

        $store_loc_pin = get_option('_mipl_sl_map_stores_location_icon');
        if( !empty($store_loc_pin) ){
            
            $map_pin = MIPL_SL_URL.'assets/images/'.$store_loc_pin;
            if($store_loc_pin == "custom_store_map_marker"){
                $property_images = get_option( '_mipl_sl_map_stores_location_custom_pin' );
                $your_img_src = wp_get_attachment_image_src( $property_images, 'full' );
                $map_pin = $your_img_src[0];
            }

        }

        return $map_pin;

    }
}


// Get marker icons 
if (!function_exists('mipl_sl_get_marker_icons')){
    function mipl_sl_get_marker_icons(){

        $marker_icons = array(
            'mipl-sl-marker-1.png' => MIPL_SL_URL.'/assets/images/mipl-sl-marker-1.png',
            'mipl-sl-marker-2.png' => MIPL_SL_URL.'/assets/images/mipl-sl-marker-2.png',
            'mipl-sl-marker-3.png' => MIPL_SL_URL.'/assets/images/mipl-sl-marker-3.png',
            'mipl-sl-marker-4.png' => MIPL_SL_URL.'/assets/images/mipl-sl-marker-4.png',
            'mipl-sl-marker-5.png' => MIPL_SL_URL.'/assets/images/mipl-sl-marker-5.png',
            'mipl-sl-marker-6.png' => MIPL_SL_URL.'/assets/images/mipl-sl-marker-6.png',
            'mipl-sl-marker-7.png' => MIPL_SL_URL.'/assets/images/mipl-sl-marker-7.png',
            'mipl-sl-marker-8.png' => MIPL_SL_URL.'/assets/images/mipl-sl-marker-8.png',
            'mipl-sl-marker-9.png' => MIPL_SL_URL.'/assets/images/mipl-sl-marker-9.png',
            'mipl-sl-marker-10.png' => MIPL_SL_URL.'/assets/images/mipl-sl-marker-10.png',
        ); 
        
        return $marker_icons;
        
    }
}


// Save default settings
if (!function_exists('mipl_sl_default_settings')){
    function  mipl_sl_default_settings(){

        $mipl_sl_default_settings = get_option('_mipl_sl_default_settings');
        if( $mipl_sl_default_settings == 'saved' ){
            return false;
        }
        
        $settings_keys = array(
            '_mipl_sl_distance_unit' => 'km',
            '_mipl_sl_layout_type' => 'template1',
            '_mipl_sl_map_height' => '500',
            '_mipl_sl_google_map_default_zoom' => '4',
            '_mipl_sl_google_map_type' => 'roadmap',
            '_mipl_sl_google_map_style' => 'default',
            '_mipl_sl_distances' => '10,20,30,40,50',
            '_mipl_sl_map_current_location_icon' => 'mipl-sl-marker-1.png',
            '_mipl_sl_map_stores_location_icon' => 'mipl-sl-marker-9.png',
            '_mipl_sl_display_time_on_list' => 'yes',
            '_mipl_sl_display_time_on_infowindow' => 'yes',
            '_mipl_sl_disable_stores_public_url' => 'false',
            '_mipl_sl_background_color' => '#ffffff',
            '_mipl_sl_primary_color' => '#000000',
            '_mipl_sl_display_social_on_list' => 'no',
            '_mipl_sl_display_social_on_infowindow' => 'no',
            '_mipl_sl_hide_image_on_list' => 'no',
            '_mipl_sl_hide_image_on_infowindow' => 'no',
            '_mipl_sl_default_settings' => 'saved',
            '_mipl_sl_map_provider' => 'mipl-sl-google-map',
            '_mipl_sl_open_info_window' => 'click',
        );
        
        foreach ($settings_keys as $key => $val) {
            update_option($key, $val);                
        }
    
    }
}


// Get setting fields
if (!function_exists('mipl_sl_get_settings_fields')){
    function mipl_sl_get_settings_fields(){
        
        $settings_fields = array(
            '_mipl_sl_distance_unit' => array(
                'label' => "Distance unit",
                'values' => array('km','mile'),
                'type' => 'radio',
                'validation' => array(
                    'in_values'=>__('Disance unit should be valid!'),
                    'requried'=>__("Distance unit should not blank!")
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_distances' =>  array(
                'label' => "Distances",
                'type' => 'text',
                'validation' => array(
                    'requried'=>__('Distances should not blank!'),
                    'regex'=>'/^[0-9 ,]+$/',
                    'regex_msg'=>__('Distances should be valid!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_default_distance' => array(
                'label' => "Default Distance",
                'type' => 'number',
                'validation' => array(
                    'regex'=>'/^[0-9 ]{1,4}+$/',
                    'regex_msg'=>__('Default Distance should be valid!')
                ),
                'sanitize' => array('sanitize_text_field'),
            ),
            '_mipl_sl_display_time_on_list' =>  array(
                'label' => "Opening Hours on list",
                'type' => 'checkbox',
                'values' => array('yes','no'),
                'validation' => array(
                    'in_values'=>__('Display time on list should be valid!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_display_time_on_infowindow' =>  array(
                'label' => "Opening Hours on infowindow",
                'type' => 'checkbox',
                'values' => array( 'yes','no'),
                'validation' => array(
                    'in_values'=>__('Display time on infowindow should be valid!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_display_social_on_list' =>  array(
                'label' => "Social media on list",
                'type' => 'checkbox',
                'values' => array('', 'no', 'yes'),
                'validation' => array(
                    'in_values'=>__('Social media on list should be valid!')
                ),
                'sanitize' => array('sanitize_text_field'),
            ),
            '_mipl_sl_display_social_on_infowindow' =>  array(
                'label' => "Social media on infowindow",
                'type' => 'checkbox',
                'values' => array('', 'no', 'yes'),
                'validation' => array(
                    'in_values'=>__('Social media on infowindow should be valid!')
                ),
                'sanitize' => array('sanitize_text_field'),
            ),
            '_mipl_sl_hide_image_on_list' =>  array(
                'label' => "Store image on list",
                'type' => 'checkbox',
                'values' => array('', 'no', 'yes'),
                'validation' => array(
                    'in_values'=>__('Store image on list should be valid!')
                ),
                'sanitize' => array('sanitize_text_field'),
            ),
            '_mipl_sl_hide_image_on_infowindow' =>  array(
                'label' => "Store image on infowindow",
                'type' => 'checkbox',
                'values' => array('', 'no', 'yes'),
                'validation' => array(
                    'in_values'=>__('Store image on infowindow should be valid!')
                ),
                'sanitize' => array('sanitize_text_field'),
            ),
            '_mipl_sl_disable_stores_public_url' =>  array(
                'label' => "Disable stores public url",
                'type' => 'checkbox',
                'values' => array('','true','false'),
                'validation' => array(
                    'in_values'=>__('Disable stores public url should be valid!')
                ),
                'sanitize' => array('sanitize_text_field'),
            ),
            '_mipl_sl_map_provider' =>  array(
                'label' => "Map Provider",
                'type' => 'radio',
                'values' => array('mipl-sl-google-map', 'mipl-sl-openstreetmap', 'mipl-sl-bing-map', 'mipl-sl-here-map'),
                'validation' => array(
                    'in_values'=>__('Map provider should be valid!'),
                    'requried'=> __('Map Provider should not blank!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_open_info_window' => array(
                'label' => "Open Map info window",
                'values' => array('mouseover','click'),
                'type' => 'radio',
                'validation' => array(
                    'in_values'=>__('Open Map info window should be valid!'),
                    'requried'=>__("Open Map info window should not blank!")
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_layout_type' =>  array(
                'label' => "Layout Type",
                'type' => 'radio',
                'values' => array( 'template1','template4','template2','template3','template8','template12','template9','template11','template5','template6','template7','template10','custom_template'),
                'validation' => array(
                    'in_values'=>__('Layout type should be valid!'),
                    'requried'=>__('Layout type should not blank!'),
                    'regex'=>'',
                    'regex_msg'=>__('Layout type should be valid!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_custom_template' =>  array(
                'label' => "Custom Template",
                'type' => 'textarea',
                'depend' => array(
                    'field' => '_mipl_sl_layout_type',
                    'value' => 'custom_template'
                ),
                'validation' => array(
                    'requried'=>__('Custom template should not blank!'),                
                ),
                'ese' => array('wp_kses_post')
            ),
            '_mipl_sl_primary_color' =>  array(
                'label' => "Primary color",
                'type' => 'color',
                'validation' => array(
                    'requried'=>__('Primary color should not blank!'),
                    'regex'=>'/^#[a-f0-9]{3,8}$/i',
                    'regex_msg'=>__('Primary color should be valid!')
                ),
                'sanitize' => array('sanitize_hex_color')
            ),
            '_mipl_sl_background_color' =>  array(
                'label' => "Background color",
                'type' => 'color',
                'validation' => array(
                    'requried'=>__('Background color should not blank!'),
                    'regex'=>'/^#[a-f0-9]{3,8}$/i',
                    'regex_msg'=>__('Background color should be valid!')
                ),
                'sanitize' => array('sanitize_hex_color')
            ),
            '_mipl_sl_map_height' =>  array(
                'label' => "Map Height",
                'type' => 'number',
                'validation' => array(
                    'regex'=>'/^[0-9]{1,4}+$/',
                    'regex_msg'=>__('Map height should be valid!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_map_current_location_icon' =>  array(
                'label' => "Current Location Icon",
                'type' => 'radio',
                'values' => array( 'mipl-sl-marker-1.png','mipl-sl-marker-2.png','mipl-sl-marker-3.png','mipl-sl-marker-4.png','mipl-sl-marker-5.png','mipl-sl-marker-6.png','mipl-sl-marker-7.png','mipl-sl-marker-8.png','mipl-sl-marker-9.png','mipl-sl-marker-10.png','custom_map_marker'),
                'validation' => array(
                    'in_values'=>__('Current location icon is invalid'), 
                    'requried'=>__('Current Location Icon should not blank!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_map_current_location_custom_pin' =>  array(
                'label' => "Current location custom pin",
                'depend' => array(
                    'field' => '_mipl_sl_map_current_location_icon',
                    'value' => 'custom_map_marker'
                ),
                'type' => 'hidden',
                'validation' => array(
                    'requried'=>__('Current location custom pin should not blank!'),
                    'regex'=>'/^[0-9]{1,10}+$/',
                    'regex_msg'=>__('Current location custom pin should be valid!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_map_stores_location_icon' =>  array(
                'label' => "Stores location icon",
                'type' => 'radio',
                'values' => array( 'mipl-sl-marker-1.png','mipl-sl-marker-2.png','mipl-sl-marker-3.png','mipl-sl-marker-4.png','mipl-sl-marker-5.png','mipl-sl-marker-6.png','mipl-sl-marker-7.png','mipl-sl-marker-8.png','mipl-sl-marker-9.png','mipl-sl-marker-10.png','custom_store_map_marker'),
                'validation' => array(
                    'in_values'=>__('Stores location icon is invalid'),
                    'requried'=>__('Stores location icon should not blank!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_map_stores_location_custom_pin' =>  array(
                'label' => "Map stores location custom pin",
                'depend' => array(
                    'field' => '_mipl_sl_map_stores_location_icon',
                    'value' => 'custom_store_map_marker'
                ),
                'type' => 'hidden',
                'validation' => array(
                    'requried'=>__('Stores location custom icon should not blank!'),
                    'regex'=>'/^[0-9,]+$/',
                    'regex_msg'=>__('Stores location custom pin should be valid!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_labels' =>  array(
                'label' => "Labels",
                'type' => 'text',
                'sanitize' => array('mipl_sl_sanitize_array_fields'),
                'validation' => array(
                    'limit'=>'500',
                    'limit_msg'=>__('Label should be less than 500 Characters!'),
                    'custom_function'=> array('mipl_sl_labels_validation'), 
                    'custom_function_msg'=>__('Labels should not blank!')
                ),
            ),
            '_mipl_sl_google_map_api_key' =>  array(
                'label' => "Google Map API Key",
                'depend' => array(
                    'field' => '_mipl_sl_map_provider',
                    'value' => 'mipl-sl-google-map'
                ),
                'type' => 'text',
                'validation' => array(
                    'requried'=>__('Google Map Api key should not blank!'), 
                    'regex'=>'/^[A-Za-z0-9-_]{30,45}$/',
                    'regex_msg'=>__('Google Map API Key should be valid!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_google_map_default_location' =>  array(
                'label' => "Google Map default location",
                'depend' => array(
                    'field' => '_mipl_sl_map_provider',
                    'value' => 'mipl-sl-google-map'
                ),
                'type' => 'text',
                'validation' => array(
                    'requried'=>__('Google Map default location should not blank!'),
                    'regex'=>'/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*[-+]?(180(\.0+)?|((1[0-7]\d)|(\d{1,2}))(\.\d+)?)$/',
                    'regex_msg'=>__('Google Map default location should be valid!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_google_map_default_zoom' =>  array(
                'label' => "Google Map default zoom",
                'depend' => array(
                    'field' => '_mipl_sl_map_provider',
                    'value' => 'mipl-sl-google-map'
                ),
                'type' => 'number',
                'validation' => array(
                    'requried'=>__('Google Map Default Zoom should not blank!'),
                    'regex'=>'/^[0-9]+$/',
                    'regex_msg'=>__('Google Map Default zoom should be valid!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_google_zoom_as_per_the_map_pins' =>  array(
                'label' => "Auto zoom map as per the map pins",
                'type' => 'checkbox',
                'values' => array('', '0', '1'),
                'validation' => array(
                    'in_values'=>__('Auto zoom map as per the map pins should be valid!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_google_map_controller' =>  array(
                'label' => "Google Map controller",
                'type' => 'checkbox',
                'values' => array('', '0', '1'),
                'validation' => array(
                    'in_values'=>__('Google Map controller should be valid!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_google_map_radius_circle' =>  array(
                'label' => "Google Map Radius Circle",
                'type' => 'checkbox',
                'values' => array('', '0', '1'),
                'validation' => array(
                    'in_values'=>__('Google Map Radius Circle should be valid!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_google_map_markerclusterer' =>  array(
                'label' => "Google Map MarkerClusterer",
                'type' => 'checkbox',
                'values' => array('', '0', '1'),
                'validation' => array(
                    'in_values'=>__('Google Map MarkerClusterer should be valid!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_google_map_type' =>  array(
                'label' => "Google Map type",
                'depend' => array(
                    'field' => '_mipl_sl_map_provider',
                    'value' => 'mipl-sl-google-map'
                ),
                'type' => 'select',
                'values' => array( 'roadmap','satellite','hybrid','terrain'),
                'validation' => array(
                    'in_values'=>__('Google map type is invalid')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_google_map_style' =>  array(
                'label' => "Google Map style",
                'depend' => array(
                    'field'=>'_mipl_sl_map_provider', 
                    'value'=>'mipl-sl-google-map'
                ),
                'type' => 'radio',
                'values' => array( 'default','aubergine','night','silver','retro','dark','custom_style'),
                'validation' => array(
                    'in_values'=>__('Google map style is invalid')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_google_map_custom_style' => array(
                'label' => "Google Map custom style",
                'depend' => array(
                    'field' => '_mipl_sl_google_map_style',
                    'value' => 'custom_style'
                ),
                'validation' => array(
                    'requried'=>__('Google Map custom style should not blank!'), 
                    'custom_function'=> array('mipl_sl_is_json'), 
                    'custom_function_msg'=>__('Google Map custom style should be valid!')
                ),
                'type' => 'textarea',
                'sanitize' => array('sanitize_textarea_field'),
            ),
            
        );

        $settings_fields = apply_filters('mipl_sl_settings_fields', $settings_fields);

        return $settings_fields;

    }
}


// Get store details field
if (!function_exists('mipl_sl_get_store_details')){
    function mipl_sl_get_store_details(){

        $address_line =  mipl_sl_get_label('address_line');
        $city =  mipl_sl_get_label('city');
        $state =  mipl_sl_get_label('state');
        $country =  mipl_sl_get_label('country');
        $post_code =  mipl_sl_get_label('post_code');
        $map_location_latitude =  mipl_sl_get_label('map_location_latitude');
        $map_location_longitude =  mipl_sl_get_label('map_location_longitude');
        $website =  mipl_sl_get_label('website');
        $telephone =  mipl_sl_get_label('telephone');
        $fax =  mipl_sl_get_label('fax');
        $email =  mipl_sl_get_label('email');
        $opening_hours =  mipl_sl_get_label('opening_hours');
        $social_media_links =  mipl_sl_get_label('social_media_links');

        $stores_fields = array(
            '_mipl_sl_address'  =>  array(
                'label' => "Address Line",
                'type' => 'textarea',
                'validation' => array(
                    'limit'=>'1000',
                    'limit_msg'=>__($address_line.' should be less than 1000 Characters!')
                ),
                'sanitize' => array('sanitize_textarea_field')
            ),
            '_mipl_sl_latitude'  =>  array(
                'label' => "Map Location (Latitude)",
                'type' => 'text',
                'validation' => array(
                    'requried'=> __($map_location_latitude." should not blank!"),
                    'regex'=>'/\A[+-]?(?:90(?:\.0{1,18})?|\d(?(?<=9)|\d?)\.\d{1,18})\z/x',
                    'regex_msg'=>__($map_location_latitude.' should be valid!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_longitude'  =>  array(
                'label' =>"Map Location (longitude)",
                'type' => 'text',
                'validation' => array(
                    'requried'=>__($map_location_longitude." should not blank!"),
                    'regex'=>'/\A[+-]?(?:180(?:\.0{1,18})?|(?:1[0-7]\d|\d{1,2})\.\d{1,18})\z/x',
                    'regex_msg'=>__($map_location_longitude.' should be valid!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_email'  =>  array(
                'label' => "Email",
                'type' => 'email',
                'validation' => array(
                    'wp_inbuilt_function'=>array('is_email'),
                    'wp_inbuilt_function_msg'=>__($email.' should be valid!')
                ),
                'sanitize' => array('sanitize_email')
            ),
            '_mipl_sl_telephone'  =>  array(
                'label' => "Telephone",
                'type' => 'text',
                'validation' => array(
                    'limit'=>'100',
                    'limit_msg'=>__($telephone.' should be less than 100 Characters!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_city'  =>  array(
                'label' => "City",
                'type' => 'text',
                'validation' => array(
                    'limit' => '100',
                    'limit_msg' => __($city.' should be less than 100 Characters!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_state'  =>  array(
                'label' => "State",
                'type' => 'text',
                'validation' => array(
                    'limit'=>'100',
                    'limit_msg'=> __($state.' should be less than 100 Characters!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_country'  =>  array(
                'label' => "Country",
                'type' => 'text',
                'validation' => array(
                    'limit'=>'100',
                    'limit_msg'=> __($country.' should be less than 100 Characters!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_post_code'  =>  array(
                'label' => "Post Code",
                'type' => 'text',
                'validation' => array(
                    'limit'=>'50',
                    'limit_msg'=> __($post_code.' should be less than 100 Characters!')
                ),
                'sanitize' => array('sanitize_text_field'),
            ),
            '_mipl_sl_website'  =>  array(
                'label' => "Website",
                'type' => 'text',
                'sanitize' => array('sanitize_url'),
                'validation' => array(
                    'custom_function'=>array('mipl_sl_validate_url'),
                    'custom_function_msg'=> __($website.' should be valid!')
                ),
            ),
            '_mipl_sl_fax'  =>  array(
                'label' => "Fax",
                'type' => 'text',
                'validation' => array(
                    'limit'=>'100',
                    'limit_msg'=>__($fax.' should be less than 100 Characters!')
                ),
                'sanitize' => array('sanitize_text_field')
            ),
            '_mipl_sl_social_media_link' => array(
                'label' => "Social Media Link",
                'type' => 'text',
                'sanitize' => array('mipl_sl_sanitize_url_or_array_field'),
                'validation' => array(
                    'custom_function'=>array('mipl_sl_validate_social_media_links'),
                    'custom_function_msg'=> __($social_media_links.' should be valid!')
                ),
            ),
            '_mipl_sl_opening_hours' => array(
                'label' => "Opening Hours",
                'type' => 'text',
                'sanitize' => array('mipl_sl_sanitize_array_fields'),
                'validation' => array(
                    'limit'=>'500',
                    'limit_msg'=>__($opening_hours.' should be less than 500 Characters!')
                ),
            ),
            '_mipl_sl_opening_hours_note' => array(
                'label' => "Opening Hours note",
                'type' => 'textarea',
                'sanitize' => array('sanitize_textarea_field'),
                'validation' => array(
                    'limit'=>'1000',
                    'limit_msg'=> __('Opening Hours Note should be less than 1000 Characters!')
                ),
            )
            
        );

        return $stores_fields;
        
    }
}


// Json validation
if (!function_exists('mipl_sl_is_json')){
    function mipl_sl_is_json($string) {
        
        if (is_string($string)) {
            @json_decode( stripslashes($string) );
            return (json_last_error() === JSON_ERROR_NONE);
        }
        return false;

    }
}


// Url validation
if (!function_exists('mipl_sl_validate_url')){
    function mipl_sl_validate_url($url){
        
        // $url_new = filter_var($url, FILTER_VALIDATE_URL);
        $url_new = preg_match("/^https|http?:\\/\\/(?:www\\.)?[-a-zA-Z0-9@:%._\\+~#=]{1,256}\\.[a-zA-Z0-9()]{1,6}\\b(?:[-a-zA-Z0-9()@:%_\\+.~#?&\\/=]*)$/", $url);
        return $url_new;
        
    }
}


// validate social media links
if (!function_exists('mipl_sl_validate_social_media_links')){
    function mipl_sl_validate_social_media_links($social_media_links){
        
        $social_media = array(); 
        $social_media_error = array();
        
        foreach($social_media_links as $key => $social_media_link){
            
            if(empty($social_media_link)){
                continue;
            }

            if($social_media_link != "" && $key != 'whatsapp' && $key != 'skype'){
                $pattern = "/^https|http?:\\/\\/(?:www\\.)?[-a-zA-Z0-9@:%._\\+~#=]{1,256}\\.[a-zA-Z0-9()]{1,6}\\b(?:[-a-zA-Z0-9()@:%_\\+.~#?&\\/=]*)$/";
                $url = str_replace('%20', '', strtolower($social_media_link));
                $social_media['value'][$key] = $social_media_link;

                if(!preg_match($pattern, $url)){
                    $social_media['error'][] = __(ucfirst($key). ' URL should be valid!');
                    $social_media['value'][$key] = '';
                }
                
            }elseif($social_media_link != "" && ($key == 'whatsapp' || $key == 'skype')){
                $pattern = '/^(([a-zA-Z][a-zA-Z0-9.,\-_]{5,31})|(live:|cid:)[a-zA-Z0-9\.,\-_]{1,64}|[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})$/';
                $url = str_replace(' ', '', $social_media_link);
                $social_media['value'][$key] = $social_media_link;

                if($key == 'whatsapp'){
                    $pattern = '/^[0-9]{10,20}+$/';
                    $social_media['value'][$key] = ltrim($social_media['value'][$key], '0');
                }

                if($key == 'whatsapp' && !preg_match($pattern, $url)){
                    $social_media['error'][] = __(ucfirst($key). ' Number should be valid!');
                    $social_media['value'][$key] = '';
                }elseif($key == 'skype' && !preg_match($pattern, $url)){
                    $social_media['error'][] = __(ucfirst($key). ' Name should be valid!');
                    $social_media['value'][$key] = '';
                }
                
            }

        }
        
        if(empty($social_media)){
            return true;
        }
        if(isset($social_media['error'])){
            $social_media['error'] = implode('<br/>', $social_media['error']);
        }
        $social_media_error['social_media'] = $social_media;
        
        return $social_media_error;

    }
}


// sanitize array fields
if (!function_exists('mipl_sl_sanitize_array_fields')){
    function mipl_sl_sanitize_array_fields($fields) {
        
        if(!is_array($fields)){
            return $fields;
        }

        foreach ( $fields as $key => $value ) {
            if( is_array($value) ){
                if(!isset($value['closed'])){
                    $value['closed'] = '0';
                }
                foreach ( $value as $key1 => $value1 ) {
                    if( is_array($value1) ){
                        foreach($value1 as $key2 => $value2){
                            $fields[$key][$key2] = stripslashes(sanitize_text_field( $value2 ));
                        }
                    }else{
                        $fields[$key][$key1] = stripslashes(sanitize_text_field( $value1 ));
                    }
                }
            }else{
                $fields[$key] = stripslashes(sanitize_text_field( $value ));
            }
        }
        
        return $fields;

    }
}


// sanitize url array
if (!function_exists('mipl_sl_sanitize_url_or_array_field')){
    function mipl_sl_sanitize_url_or_array_field($fields) {
        
        if(!is_array($fields)){
            return $fields;
        }

        foreach ( $fields as $key => $value ) {
            
            if($key == 'whatsapp' || $key == 'skype'){
                if( is_array($value) ){
                    foreach ( $value as $key1 => $value1 ) {
                        $value1 = str_replace(' ', '', $value1);
                        $fields[$key][$key1] = sanitize_text_field( $value1 );
                    }
                }else{
                    $value = str_replace(' ', '', $value);
                    $fields[$key] = sanitize_text_field( $value );
                }
            }else{
                if( is_array($value) ){
                    foreach ( $value as $key1 => $value1 ) {
                        $fields[$key][$key1] = sanitize_url( $value1 );
                    }
                }else{
                    $fields[$key] = sanitize_url( $value );
                }
            }

        }

        return $fields;
    }
}


// Opening Hours validation 
if (!function_exists('mipl_sl_validate_opening_hours')){
    function mipl_sl_validate_opening_hours($_opening_hours){

        foreach($_opening_hours as $key => $_opening_hour){
            foreach($_opening_hour as $key2 => $value2){
                if(!empty($value2)){
                    if($key2 == 'opening_hour'){
                        if(!preg_match('/(0?[1-9]|1[0-2]).|:([0-5]\d)\s?(AM|A\.M\.|am|a\.m\.|PM|P\.M\.|pm|p\.m\.)/', $value2)){
                            $error_message[$key2] = __('Opening Hours should be valid!');
                        }
                    }
                    if($key2 == 'closing_hour'){
                        if(!preg_match('/(0?[1-9]|1[0-2]).|:([0-5]\d)\s?(AM|A\.M\.|am|a\.m\.|PM|P\.M\.|pm|p\.m\.)/', $value2)){
                            $error_message[$key2] = __('Closing Hours should be valid!');
                        }
                    }
                }
            }
        }
        
        if(empty($error_message)){
            return true;
        }else{
            return false;
        }
        
    }
}



// Store Custom Field Validation
if (!function_exists('mipl_sl_get_store_custom_fields')){
    function mipl_sl_get_store_custom_fields($post){
        
        $custom_field_val = array();
        $custom_fields =  get_option('_mipl_sl_stockist_custom_fields');
        
        if( isset($post['post_type']) && isset($custom_fields['label']) ){
            $explode_array = array();
            
            foreach($custom_fields['name'] as $field_key => $field_name){
                if(empty($custom_fields['name'][$field_key])){
                    continue;
                }
                $required = "";
                if(in_array($custom_fields['name'][$field_key], $custom_fields['required']) ){
                    $required = 'requried';
                }

                if($custom_fields['type'][$field_key] == 'text'){
                    $custom_field_val[$field_name] = array(
                        'label' => $custom_fields['label'][$field_key],
                        'type' => $custom_fields['type'][$field_key], 
                        'sanitize' => array('sanitize_text_field'),
                        'validation' => array(
                            $required => __($custom_fields['label'][$field_key].' should not blank!'), 
                            'limit'=>'100',
                            'limit_msg'=> __($custom_fields['label'][$field_key].' should be less than 100 Characters!')
                        ),
                    );
                }
                
                if($custom_fields['type'][$field_key] == 'textarea'){
                    $custom_field_val[$field_name] = array(
                        'label' => $custom_fields['label'][$field_key], 
                        'type' => $custom_fields['type'][$field_key], 
                        'sanitize' => array('sanitize_textarea_field'),
                        'validation' => array(
                            $required=> __($custom_fields['label'][$field_key].' should not blank!'),
                            'limit'=>'500',
                            'limit_msg'=> __($custom_fields['label'][$field_key].' should be less than 500 Characters!')
                        ),
                        'ese' => array('wp_kses_post')
                    );
                }
                
                if($custom_fields['type'][$field_key] == 'select'){
                    $field_values = $custom_fields['options'][$field_key];
                    $field_values = preg_split("/[\n]+/", trim($field_values));
                    
                    foreach($field_values as $option_key => $option_value){
                        if(strpos($option_value,":")){
                            $tmp = explode(':',trim($option_value));
                            if(!empty($tmp[0] && !empty($tmp[1]))){
                                $explode_array[strtolower(trim($tmp[0]))] = strtolower(trim($tmp[1]));
                            }
                        }else{
                            $tmp = explode('/n',trim($option_value));
                            if(!empty($tmp[0])){
                                $explode_array[strtolower(trim($tmp[0]))] = strtolower(trim($tmp[0]));
                            }
                        }
                    }

                    $custom_field_val[$field_name] = array(
                        'label' => $custom_fields['label'][$field_key], 
                        'type' => $custom_fields['type'][$field_key], 
                        'values' => array_values($explode_array),
                        'sanitize' => array('sanitize_text_field'),
                        'validation' => array(
                            'in_values'=> __($custom_fields['label'][$field_key].' should be valid!'),
                            $required=> __($custom_fields['label'][$field_key].' should not blank!'),
                        ),
                    );
                }

            }

        }
        
        return $custom_field_val;

    }
}

if (!function_exists('mipl_sl_get_selected_map_provider')){
    function mipl_sl_get_selected_map_provider(){

        $class_name = "";
        $selected_map_provider = get_option('_mipl_sl_map_provider');

        if($selected_map_provider == 'mipl-sl-google-map'){
            return $selected_map_provider;
        }

        $mipl_selected_provider = array(
            'mipl-sl-openstreetmap' => 'MIPL_SL_Stockist_OSM_Core',
            'mipl-sl-bing-map' => 'MIPL_SL_Stockist_Bing_Map_Core',
            'mipl-sl-here-map' => 'MIPL_SL_Stockist_Here_Map_Core'
        );
        
        if(isset($mipl_selected_provider[$selected_map_provider])){
            $class_name = $mipl_selected_provider[$selected_map_provider];
        }
        
        if( !empty($class_name) && !class_exists($class_name) ){ 
            $selected_map_provider = 'mipl-sl-google-map';
        }
        
        return $selected_map_provider;

    }
}


if (!function_exists('mipl_sl_labels_validation')){
    function mipl_sl_labels_validation($labels){

        
        foreach($labels as $label_key => $label_value){

            if(is_array($label_value)){

                foreach($label_value as $lbl_key => $lbl_val){
                    if(  strlen($lbl_val) == 0){
                        $label = mipl_sl_get_label($label_key);
                        $error_message[$label_key] = __(ucfirst($label). ' label should not blank!');
                    }
                }

            }else{
                
                if( strlen($label_value) == 0){
                    $label = mipl_sl_get_label($label_key);
                    $error_message[$label_key] = __(ucfirst($label). ' label should not blank!');
                }
            }

        }
        
        if(empty($error_message)){
            return true;
        }
        
        if(isset($error_message)){
            $error_massages = implode('<br/>', $error_message);
        }
        
        $labels_error['labels'] = $error_massages;    
        return $labels_error;

    }
}