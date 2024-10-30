<div class="wrap">
<h1 class="wp-heading-inline"><?php echo esc_html__('Settings');?></h2>
<hr class="wp-header-end" />
<form name="mipl_sl_settings_form" action="" method="post" id="mipl_sl_settings_form">
<div id="poststuff">
<div id="post-body" class="metabox-holder columns-2">
    <div id="postbox-container-1" class="postbox-container">
        <div id="side-sortables" class="meta-box-sortables ui-sortable post_save_box">
        <div id="submitdiv" class="postbox ">
        <div class="postbox-header">
            <h2 class="hndle ui-sortable-handle"><?php echo esc_html__('Publish');?></h2>
        </div>
        <div class="inside">
            <div class="submitbox" id="submitpost">
            <div id="minor-publishing">
            <div class="mipl_sl_stockist_shortcode"> <strong><?php echo esc_html__('Add this shortcode to Pages');?> </strong>  <br>
            <input class="show_shortcode" type="text" readonly value="[mipl_stockist_store_locator]"></div>
            </div>
            <div id="major-publishing-actions">
                <div id="publishing-action">

                <button type="submit" class="button button-primary button-large" name="mipl_action" value="save_settings"><?php echo esc_html__('Save Changes');?></button> 
                
            </div>
                <div class="clear"></div>
            </div>
            </div>
        </div>
        </div>
        </div>

        <div id="side-sortables" class="meta-box-sortables ui-sortable">
            <div id="submitdiv" class="postbox ">
                <div class="inside">
                    <div class="help_box">
                        <p><strong><?php echo esc_html__('Do you need help?');?></strong></p>
                        <ol style="margin-left:1em;">

                            <li><a href="https://store.mulika.in/documentation/mipl-stockist-store-locator/integrate-stockist-map-in-page/" target="_blank"><?php echo esc_html__('Integrate Stockist Map?');?></a></li>
                            <li><a href="https://store.mulika.in/documentation/mipl-stockist-store-locator/how-to-get-a-google-map-api-key/" target="_blank"><?php echo esc_html__('Get the Google Map API Key?');?></a></li>
                            <?php do_action('mipl_sl_help_box_content'); ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div id="postbox-container-2" class="postbox-container">
        
        <div id="mi_stores_details" class="postbox">
            <div class="postbox-header">
                <h2 class="hndle ui-sortable-handle"><?php echo esc_html__('Stores Settings');?></h2>
            </div>
            <div class="inside tabs_wrapper">
                <div class="mipl_sl_tabs_wrap" id="mipl-sl-settings-tabs">
                <?php
                $admin_tabs = array(
                    "mipl-general" => "General",
                    "mipl-layouts" => "Layout/Design",
                    "mipl-labels" => "Labels",
                    "mipl-store-fields" => "Store Fields",
                    "mipl-google-map" => "Google Map",
                );
                $admin_tabs = apply_filters('mipl_sl_settings_tabs', $admin_tabs);
                ?>
                <!-- Tabs -->
                <ul class="mipl_sl_tabs">
                    <?php
                    foreach($admin_tabs as $key=>$tab){
                        ?>
                        <li><a href="#<?php echo esc_attr($key);?>"><?php echo esc_html__($tab);?></a></li>
                        <?php
                    }
                    ?>
                </ul>

                <!-- Tabs Content -->
                <div id="mipl-general" class="mipl_sl_tab_content" style="display:block" aria-hidden="false" >
                    <div class="mipl_stockist_style_container">
                    <div class="mipl_store_setting_title">
                        <strong><?php echo esc_html__('Distance unit');?>:</strong><span class="mipl_sl_required">*</span>
                    </div>

                    <?php
                    $distance_unit = array(
                        'km' => 'km',
                        'mile' => 'mile',
                    );
                    $selected_unit = get_option('_mipl_sl_distance_unit');
                    foreach($distance_unit as $name=>$title){ 
                        $checked = "";
                        if($selected_unit == $name){
                            $checked = 'checked="checked"';
                        }?>
                        <div class="mipl_store_content">
                            <label> <input type="radio" name="_mipl_sl_distance_unit" value="<?php echo esc_html($name);?>" <?php echo esc_attr($checked); ?>><?php echo esc_html__($title); ?></label>
                        </div>
                        <?php
                    }?>
                    </div>

                    
                    <div class="mipl_stockist_style_container">
                    <div class="mipl_store_setting_title">
                        <strong><?php echo esc_html__('Distances');?>:</strong><span class="mipl_sl_required">*</span>
                        <p><?php echo __('Enter distances by comma(,) seprated, distances must be numeric.');?></p>
                    </div>
   
                    <div class="mipl_store_content">
                        <?php $distance = get_option('_mipl_sl_distances'); ?>
                        <input type="text" id="mipl_distances" name="_mipl_sl_distances"
                        value="<?php echo esc_html($distance); ?>">
                       
                    </div>
                    </div>


                    <div class="mipl_stockist_style_container">
                        <div class="mipl_store_setting_title">
                            <strong><?php echo esc_html__('Default Distance');?>:</strong>
                        </div>

                        <div class="mipl_store_content">
                            <?php $Default_distance = get_option('_mipl_sl_default_distance'); ?>
                            <input type="number" name="_mipl_sl_default_distance" id="mipl_sl_default_distance" value="<?php echo esc_attr($Default_distance); ?>">
                        </div>
                    </div>


                    <div class="mipl_stockist_style_container">
                        <div class="mipl_store_setting_title">
                            <strong><?php echo esc_html__('Display store "Opening Hours"');?>:</strong>
                        </div>
                        <?php 
                            $display_on_list = get_option('_mipl_sl_display_time_on_list');
                            if($display_on_list == 'yes'){
                                    $selected = 'checked="checked"';
                            }else{ 
                                $selected ="";
                            }
                        ?>
                        <div class="mipl_store_content">
                            <label> <input type="checkbox" name="_mipl_sl_display_time_on_list" value="yes" <?php echo esc_attr($selected); ?>><?php echo esc_html__('Display on store Listing.');?></label>
                        </div>
                        <?php 
                            $display_on_infowindow = get_option('_mipl_sl_display_time_on_infowindow');
                            if($display_on_infowindow == 'yes'){
                                    $infowindow_selected = 'checked="checked"';
                            }else{ 
                                $infowindow_selected ="";
                            }
                        ?>
                        <div class="mipl_store_content">
                        <label> <input type="checkbox" name="_mipl_sl_display_time_on_infowindow" value="yes" <?php echo esc_attr($infowindow_selected); ?>><?php echo esc_html__('Display on map Info Window.');?></label>
                        </div>
                    </div>

                    <div class="mipl_stockist_style_container">
                        <div class="mipl_store_setting_title">
                            <strong><?php echo esc_html__('Display social media icons');?>:</strong>
                        </div>
                        <?php 
                            $display_on_list = get_option('_mipl_sl_display_social_on_list');
                            if($display_on_list == 'yes'){
                                    $selected = 'checked="checked"';
                            }else{ 
                                $selected = "";
                            }
                        ?>
                        <div class="mipl_store_content">
                            <label> <input type="checkbox" name="_mipl_sl_display_social_on_list" value="yes" <?php echo esc_attr($selected); ?>><?php echo esc_html__('Display on store Listing.');?></label>
                        </div>
                        <?php 
                            $display_on_infowindow = get_option('_mipl_sl_display_social_on_infowindow');
                            if($display_on_infowindow == 'yes'){
                                    $infowindow_selected = 'checked="checked"';
                            }else{ 
                                $infowindow_selected ="";
                            }
                        ?>
                        <div class="mipl_store_content">
                        <label> <input type="checkbox" name="_mipl_sl_display_social_on_infowindow" value="yes" <?php echo esc_attr($infowindow_selected); ?>><?php echo esc_html__('Display on map Info Window.');?></label>
                        </div>
                    </div>

                    <div class="mipl_stockist_style_container">
                        <div class="mipl_store_setting_title">
                            <strong><?php echo esc_html__('Display store image');?>:</strong>
                        </div>
                        <?php 
                            $display_on_list = get_option('_mipl_sl_hide_image_on_list');
                            if($display_on_list == 'yes'){
                                    $selected = 'checked="checked"';
                            }else{ 
                                $selected = "";
                            }
                        ?>
                        <div class="mipl_store_content">
                            <label> <input type="checkbox" name="_mipl_sl_hide_image_on_list" value="yes" <?php echo esc_attr($selected); ?>><?php echo esc_html__('Hide on store Listing.');?></label>
                        </div>
                        <?php 
                            $display_on_infowindow = get_option('_mipl_sl_hide_image_on_infowindow');
                            if($display_on_infowindow == 'yes'){
                                    $infowindow_selected = 'checked="checked"';
                            }else{ 
                                $infowindow_selected = "";
                            }
                        ?>
                        <div class="mipl_store_content">
                        <label> <input type="checkbox" name="_mipl_sl_hide_image_on_infowindow" value="yes" <?php echo esc_attr($infowindow_selected); ?>><?php echo esc_html__('Hide on map Info Window.');?></label>
                        </div>
                    </div>

                    <div class="mipl_stockist_style_container">
                    <div class="mipl_store_setting_title">
                        <strong><?php echo esc_html__('Disable stores public access');?>:</strong>
                    </div>
                    <?php
                    $disable_stores_public_url = get_option('_mipl_sl_disable_stores_public_url');
                    if($disable_stores_public_url == 'false'){
                            $selected_url = 'checked="checked"';
                    }else{ 
                        $selected_url ="";
                    }
                    ?>
                    <div class="mipl_store_content">
                        <label><input type="checkbox" name="_mipl_sl_disable_stores_public_url" value="false"
                        <?php echo esc_attr($selected_url);?>><?php echo esc_html__('Disable store public access url and search engine visibility.');?></label><br>
                    </div>
                    <p class="mipl_sl_page_layput_note"><?php echo esc_html__('Note: To edit the single page layout, copy "single-mipl_sl_stores.php" to your Theme');?></p>
                    </div>

                    <div class="mipl_stockist_style_container">
                        <div class="mipl_store_setting_title">
                            <strong><?php echo esc_html__('Map Provider');?>:</strong><span class="mipl_sl_required">*</span>
                        </div>
                        <?php 

                        $installed_plugins = array();
                        $all_plugins = get_plugins();
                        foreach($all_plugins as $plugin){
                            array_push($installed_plugins, $plugin['Name']);
                        }

                        $activated_plugins=array();
                        $apl = get_option('active_plugins');
                        $plugins=get_plugins();
                        foreach ($apl as $p){           
                            if(isset($plugins[$p])){
                                array_push($activated_plugins, $plugins[$p]);
                            }           
                        }
                        
                        $selected_map_provider = mipl_sl_get_selected_map_provider();
                        foreach( $map_service_provider as $value => $title){ 
                            $checked = "";
                            $provider = $title['value'];
                            
                            if($selected_map_provider == $value){
                                $checked = 'checked="checked"';
                            }
                            
                            $install_status = $title['installed'];
                            if( in_array($provider, $installed_plugins) ){
                                $install_status = true;
                            }
                            
                            $active_status = $title['active'];
                            foreach($activated_plugins as $active_plugin){
                                if($active_plugin['Name'] == $provider ){
                                    $active_status = true;
                                }
                            } 

                            $disable = 'disabled';
                            if($active_status == true && $title['activation_key'] == true){
                                $disable = '';
                            }

                            $addon_link = "";
                            if($install_status != true){ 
                                $provider = "";
                               $addon_link = wp_kses_post('<a href="'.$title['link'].'" class="mipl_sl_stockist_addon_link" target="_blank">'.__('Get Addon').'</a>');
                            }
                            
                            if( $install_status == true && $active_status != true){ 
                                $provider = "";
                                $addon_link = wp_kses_post('<a href="'.home_url().'/wp-admin/plugins.php" >Activate Plugin</a>');
                            } 
                            
                            if( $active_status == true && $install_status == true && $title['activation_key'] == false){
                                $provider = "";
                                $addon_link = wp_kses_post('<a href="'.home_url().'/wp-admin/edit.php?post_type=mipl_sl_stores&page=mipl-sl-verify-addon-api-key">'.__('Addon Activation').'</a>'); 
                            }

                            ?>
                        <div class="mipl_store_content">
                            <label> <input type="radio" name="_mipl_sl_map_provider" value="<?php echo esc_html($value);?>" <?php echo esc_attr($checked);?> <?php echo esc_attr($disable); ?> ><?php echo esc_html__($title['title']); ?></label>
                            <?php echo wp_kses_post($addon_link);?> 
                        </div>
                        <?php 
                        }
                        ?>
                    </div>


                    <div class="mipl_stockist_style_container">
                        <div class="mipl_store_setting_title">
                            <strong><?php echo esc_html__('Map info window (Open on)');?>:</strong><span class="mipl_sl_required">*</span>
                        </div>

                        <?php
                        $window_options = array(
                            'mouseover' => 'Mouse Over',
                            'click' => 'Mouse Click',
                        );
                        $selected_unit = get_option('_mipl_sl_open_info_window');
                        foreach($window_options as $name=>$title){ 
                            $checked = "";
                            if($selected_unit == $name){
                                $checked = 'checked="checked"';
                            }
                            ?>
                            <div class="mipl_store_content">
                                <label> <input type="radio" name="_mipl_sl_open_info_window" value="<?php echo esc_html($name); ?>" <?php echo esc_attr($checked); ?>><?php echo esc_html__($title); ?></label>
                                </div>
                            <?php
                        }
                        ?>
                    </div>


                </div>
                
                <div id="mipl-layouts" style="display:none" class="mipl_sl_tab_content" aria-hidden="true" >

                    <div class="mipl_stockist_style_container" >
                        <div class="mipl_store_setting_title">
                            <strong> <?php echo esc_html__('Layout Type');?>:</strong><span class="mipl_sl_required">*</span>
                        </div>
                        <?php  
                        $layout_type = array(
                            'template1' => MIPL_SL_URL."assets/images/mipl_sl_top_filter_with_left_side_listing.png",
                            'template2' => MIPL_SL_URL."assets/images/mipl_sl_top_filter_with_right_side_listing.png",
                            'template3' => MIPL_SL_URL."assets/images/mipl_sl_filter_with_list_left_sidebar.png",
                            'template4' => MIPL_SL_URL."assets/images/mipl_sl_filter_with_list_right_sidebar.png",
                            'template5' => MIPL_SL_URL."assets/images/mipl_sl_left_side_list_withmap.png",
                            'template6' => MIPL_SL_URL."assets/images/mipl_sl_right_side_list_with_map.png",
                            'template7' => MIPL_SL_URL."assets/images/mipl_sl_leftside_list_and_filter_on_map.png",
                            'template8' => MIPL_SL_URL."assets/images/mipl_sl_rightside_list_and_filter_on_map.png",
                            'template9' => MIPL_SL_URL."assets/images/mipl_sl_top_filter_with_full_map.png",
                            'template10' => MIPL_SL_URL."assets/images/mipl_sl_filter_on_map.png",
                            'template11' => MIPL_SL_URL."assets/images/mipl_sl_list_on_map_left_sidebar.png",
                            'template12' => MIPL_SL_URL."assets/images/mipl_sl_list_on_map_right_side.png",
                            'custom_template'=> "Custom Template",
                        );
                        $selected_layout = get_option('_mipl_sl_layout_type');
                        ?>
                        <ul class="mipl_sl_layout_list">
                        <?php
                        foreach($layout_type as $name=>$title){ 
                            $checked = "";
                            if($selected_layout == $name){
                                $checked = 'checked="checked"';
                            }
                            if($name != 'custom_template'){ ?>
                                <div class="mipl_sl_store_content">
                                <li class="mipl_sl_layout_image"><label> <input type="radio" name="_mipl_sl_layout_type" value="<?php echo esc_html($name); ?>"  <?php echo esc_attr($checked); ?>><img src="<?php echo esc_html($title); ?>" alt=""></label></li>
                                </div>
                                <?php
                            }else{?>
                                <div class="mipl_sl_store_content">
                                <li class="mipl_sl_layout_image">
                                <label><input type="radio" name="_mipl_sl_layout_type" value="<?php echo esc_html($name);?>"  <?php echo esc_attr($checked); ?>> <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8/5+hHgAHggJ/PchI7wAAAABJRU5ErkJggg=="><span><?php echo esc_html__('Custom Template');?></span></label>
                                </li>
                                </div>
                                <?php 
                            }
                        }
                        ?>
                        </ul>
                        <p><strong><?php echo __('Custom Layout');?></strong><br>
                        <?php echo __('Enter custom HTML template here');?>. <br> 
                        <strong><?php echo __('Shortcode');?>:</strong> [mipl_sl_stockist_filter], [mipl_sl_stockist_store_list],  [mipl_sl_stockist_map]</p>
                        <textarea name="_mipl_sl_custom_template"  style="width:100%;  min-height: 100px;" placeholder="Enter custom HTML template here"><?php echo wp_kses_post(stripslashes(get_option('_mipl_sl_custom_template')));?></textarea>
                            
                    </div>
                    
                    <div class="mipl_stockist_style_container">
                        <div class="mipl_store_setting_title">
                            <strong><?php echo esc_html__('Primary Color');?>:</strong><span class="mipl_sl_required">*</span>
                        </div>
                        <?php $primary_color = get_option('_mipl_sl_primary_color'); ?>
                        <div class="mipl_store_content">
                            <input type="color" name="_mipl_sl_primary_color" value="<?php echo esc_html($primary_color); ?>">
                        </div>
                    </div>

                    <div class="mipl_stockist_style_container">
                        <div class="mipl_store_setting_title">
                            <strong><?php echo esc_html__('Background Color');?>:</strong>
                        </div>
                        <?php $background_color = get_option('_mipl_sl_background_color'); ?>
                        <div class="mipl_store_content">
                            <input type="color" name="_mipl_sl_background_color" value="<?php echo esc_html($background_color); ?>">
                        </div>
                    </div>

                    <div class="mipl_stockist_style_container">
                        <div class="mipl_store_setting_title">
                            <label for="map_height">
                                <strong> <?php echo esc_html__('Map Height (px)');?>:</strong><span class="mipl_sl_required">*</span>
                            </label>
                        </div>
                        <div class="mipl_store_content">
                            <input type="number" id="map_height" name="_mipl_sl_map_height"
                            value="<?php echo esc_html(get_option('_mipl_sl_map_height')); ?>">
                        </div>
                    </div>

                    <div class="mipl_stockist_style_container">
                        <div class="mipl_store_setting_title">
                            <label for="marker_pin_icons">
                                <strong> <?php echo esc_html__('Current Location Pin');?>:</strong><span class="mipl_sl_required">*</span>
                            </label>
                        </div>
                        <div class="mipl_store_content">
                            <?php
                            $marker_icon = mipl_sl_get_marker_icons();
                        
                            $selected_pin =  get_option('_mipl_sl_map_current_location_icon');
                            $map_pin_image = get_option( '_mipl_sl_map_current_location_custom_pin' );

                            $map_pin_image_tag = '<img src="'.MIPL_SL_URL.'/assets/images/mipl-sl-blank.png" width="70px" id="mipl_sl_store_img">';;
                            $map_pin_button_text = "Select Image";
                            if(!empty($map_pin_image)){
                                $map_pin_button_text = "Change Image";
                                $your_img_src = wp_get_attachment_image_src( $map_pin_image, 'full' );
                                $map_pin_image_tag = '<img src="'.$your_img_src[0].'" alt="" style="max-width:100%;"/>';
                            }
                            ?>

                            <ul>
                                <?php
                                foreach($marker_icon as $name=>$title){ 
                                    $checked ="";
                                    if($selected_pin == $name){
                                        $checked = 'checked="checked"';
                                    }
                                    ?>
                                <li class="map_marker"><label><input type="radio" name="_mipl_sl_map_current_location_icon" value="<?php echo esc_html($name); ?>" class="map_marker_radio" <?php echo esc_attr($checked); ?>><img class="map_marker_icon" src="<?php echo esc_html($title); ?>" alt=""></label></li>
                                <?php
                                }
                                ?>
                                <li class="map_marker">
                                <label class="current_location_label" for="current_location">
                                    <input type="radio" id="current_location" name="_mipl_sl_map_current_location_icon" value="custom_map_marker" class="map_marker_radio" <?php if(get_option('_mipl_sl_map_current_location_icon') == 'custom_map_marker'){echo esc_attr('checked="checked"');} ?>>
                                    <div class="current_location_map_pin_wrap">
                                        <?php echo wp_kses_post($map_pin_image_tag); ?><span><?php echo esc_html__('Custom Map Pin');?></span>
                                    </div>
                                </label>
                                </li>
                            </ul>

                            <a class="button current_location_map_pin_button"><?php echo esc_html($map_pin_button_text); ?></a>
                            <input type="hidden" name="_mipl_sl_map_current_location_custom_pin" value="<?php echo wp_kses_post($map_pin_image); ?>" />
                            
                        </div>
                    </div>
                    <div class="mipl_stockist_style_container">
                        <div class="mipl_store_setting_title">
                            <label for="marker_pin_icons">
                                <strong> <?php echo esc_html__('Store Location Pins');?>:</strong><span class="mipl_sl_required">*</span>
                            </label>
                        </div>
                        <div class="mipl_store_content">
                        
                        <?php
                            $map_pin_image = get_option( '_mipl_sl_map_stores_location_custom_pin' );

                            $map_pin_image_tag = '<img src="'.MIPL_SL_URL.'/assets/images/mipl-sl-blank.png" width="70px" id="mipl_sl_store_img">';
                            $map_pin_button_text = "Select Image";
                            if(!empty($map_pin_image)){

                                $map_pin_button_text = "Change Image";
            
                                $your_img_src = wp_get_attachment_image_src( $map_pin_image, 'full' );
                                $map_pin_image_tag = '<img src="'.$your_img_src[0].'" alt="" style="max-width:100%;"/>';
                            }
                        ?>

                        <ul>
                        <?php
                            $selected_pin =  get_option('_mipl_sl_map_stores_location_icon');
                            foreach($marker_icon as $name=>$title){ 
                                $checked ="";
                                if($selected_pin == $name){
                                    $checked = 'checked="checked"';
                                }
                                ?>
                            <li class="map_marker"><label><input type="radio" name="_mipl_sl_map_stores_location_icon" value="<?php echo wp_kses_post($name); ?>" class="map_marker_radio" <?php echo esc_attr($checked); ?>><img class="map_marker_icon" src="<?php echo wp_kses_post($title); ?>" alt=""></label></li>
                            <?php
                            }
                            ?>
                            <li class="map_marker">
                                <label  class="current_location_label" for="store_location">
                                <input type="radio" id="store_location" name="_mipl_sl_map_stores_location_icon" value="custom_store_map_marker" class="map_marker_radio" <?php if(get_option('_mipl_sl_map_stores_location_icon') == 'custom_store_map_marker'){echo esc_attr('checked="checked"');} ?>>
                                <div class="store_location_map_pin_wrap">
                                    <?php echo wp_kses_post($map_pin_image_tag); ?><span><?php echo esc_html__('Custom Map Pin');?></span>
                                </div>
                                </label>
                            </li>
                        </ul>
                        <a class="button stores_location_map_pin_button"><?php echo esc_html($map_pin_button_text); ?></a>
                        <input type="hidden" name="_mipl_sl_map_stores_location_custom_pin" value="<?php echo wp_kses_post($map_pin_image); ?>" />
                        </div>
                    </div>
                </div>
                
                <div id="mipl-labels" style="display:none" class="mipl_sl_tab_content" aria-hidden="true" >
                    <div class="mipl_stockist_style_container">
                    <div class="mipl_store_content">
                    <table class="labels_listing_table">
                    <?php 
                   
                    $default_labels = mipl_sl_get_default_labels();

                    $updated_labels = get_option('_mipl_sl_labels');
                    
                    foreach($default_labels as $name => $title){
                        
                        if(!empty($updated_labels[$name])){
                            $current_label = $updated_labels[$name];
                        }else{
                            $current_label = $title;
                        }?>
                            <tr class="default_labels">
                            <td class="labels_listing_label"><label for="<?php echo esc_attr($name); ?>"><?php echo esc_html($title); ?>:</label><span class="mipl_sl_required">*</span></td>
                            <td><input type="text" name="_mipl_sl_labels[<?php echo esc_html($name); ?>]" id="<?php echo esc_attr($name); ?>" value="<?php echo esc_html($current_label); ?>"></td>
                            
                        </tr>
                        <tr><td colspan="2"><hr></td></tr>                        
                        <?php
                    }
                    ?>
                    </table>
                    </div>
                    </div>
                </div>
                
                <div id="mipl-google-map" style="display:none" class="mipl_sl_tab_content" aria-hidden="true" >
                
                    <div class="mipl_stockist_style_container">
                        <div class="mipl_store_setting_title">
                            <!-- <strong> active Map:</strong><span class="mipl_sl_required">*</span> -->
                        </div>
                        <?php 
                        
                        $selectrd_map_provider = mipl_sl_get_selected_map_provider();
                        if($selectrd_map_provider == 'mipl-sl-google-map'){
                            $checked = 'checked="checked"';
                        }
                        ?>
                        <div class="mipl_store_content">
                            <label> <input type="radio"  class="mipl_sl_enable_map"  name="_mipl_sl_enable_map" value="mipl-sl-google-map" <?php echo esc_attr($checked);?>><?php echo esc_html__('Enable Google Map'); ?></label>
                        </div>
                    </div>

                    <div class="mipl_stockist_style_container">
                        <div class="mipl_store_setting_title">
                            <label for="API_Key">
                            <strong><?php echo esc_html__('Google Map API Key');?>:</strong><span class="mipl_sl_required">*</span>
                            </label>
                        </div>
                        <div class="mipl_store_content">
                        <?php echo esc_html__('How to get Google Map API key');?>:  <strong><a href="https://store.mulika.in/documentation/mipl-stockist-store-locator/how-to-get-a-google-map-api-key/" target="
                            _blank"><?php echo esc_html__('Click Here');?></a></strong> <br>
                            <span><?php echo esc_html__('Enable API: Maps JavaScript API, Places API, Geocoding API');?></span>
                            <?php $api_key = get_option('_mipl_sl_google_map_api_key') ?>

                            <input type="text" id="API_Key" name="_mipl_sl_google_map_api_key"
                            value="<?php echo esc_html($api_key); ?>">
                        </div>
                    </div>
                    <div class="mipl_stockist_style_container">
                        <div class="mipl_store_setting_title">
                            <label for="Map_Default_Location">
                            <strong><?php echo esc_html__('Map Default Location (Latitude,Longitude)');?>: </strong><span class="mipl_sl_required">*</span>
                            </label>
                        </div>
                        <div class="mipl_store_content">
                            <?php $lat_lan = get_option('_mipl_sl_google_map_default_location') ?>
                            <input type="text" id="Map_Default_Location"
                            name="_mipl_sl_google_map_default_location"
                            value="<?php echo esc_html($lat_lan); ?>">
                        </div>
                    </div>
                    <div class="mipl_stockist_style_container">
                        <div class="mipl_store_setting_title">
                            <label for="Default_Zoom">
                                <strong><?php echo esc_html__('Default Zoom');?>:</strong><span class="mipl_sl_required">*</span>
                            </label>
                        </div>
                        <div class="mipl_store_content">
                        <?php $default_zoom = get_option('_mipl_sl_google_map_default_zoom') ?>
                            <input type="number" id="Default_Zoom" name="_mipl_sl_google_map_default_zoom"
                            value="<?php echo esc_html($default_zoom); ?>">
                        </div>
                    </div>
                    <div class="mipl_stockist_style_container">
                        <div class="mipl_store_setting_title">
                            <label>
                            <strong><?php echo esc_html__('Auto zoom map as per the map pins');?>:</strong>
                            </label>
                        </div>
                        <div class="mipl_store_content">
                        <?php $zoom_as_per_the_map_pins = '';
                        if(get_option('_mipl_sl_google_zoom_as_per_the_map_pins') ==  true ){
                            $zoom_as_per_the_map_pins = 'checked="checked"';
                        } ?>
                        <input type="checkbox" id="zoom_as_per_the_map_pins"
                        name="_mipl_sl_google_zoom_as_per_the_map_pins" value="<?php echo esc_html(true); ?>" <?php echo esc_attr($zoom_as_per_the_map_pins);?> >
                        <label for="zoom_as_per_the_map_pins"><?php echo esc_html__('Auto zoom map as per the map pins (Map pins boundaries)');?></label>
                        </div>
                    </div>

                    <div class="mipl_stockist_style_container">
                        <div class="mipl_store_setting_title">
                            <label>
                            <strong><?php echo esc_html__('Map Controller');?>:</strong>
                            </label>
                        </div>
                        <div class="mipl_store_content">
                        <?php $map_controller = '';
                        if(get_option('_mipl_sl_google_map_controller') ==  true ){
                            $map_controller = 'checked="checked"';
                        } ?>
                        <input type="checkbox" id="Map_Controller_hide"
                        name="_mipl_sl_google_map_controller" value="<?php echo esc_html(true); ?>" <?php echo esc_attr($map_controller);?> >
                        <label for="Map_Controller_hide"><?php echo esc_html__('Map Controller Hide');?></label>
                        </div>
                    </div>


                    <div class="mipl_stockist_style_container">
                        <div class="mipl_store_setting_title">
                            <label>
                            <strong><?php echo esc_html__('Radius Circle');?>:</strong>
                            </label>
                        </div>
                        <div class="mipl_store_content">
                        <?php $radius_circle = '';
                        if(get_option('_mipl_sl_google_map_radius_circle') ==  true ){
                            $radius_circle = 'checked="checked"';
                        } ?>
                        <input type="checkbox" id="Map_radius_circle"
                        name="_mipl_sl_google_map_radius_circle" value="<?php echo esc_html(true) ?>" <?php echo esc_attr($radius_circle);?> >
                        <label for="Map_radius_circle"><?php echo esc_html__('Show Radius Circle');?></label>
                        </div>
                    </div>



                    <div class="mipl_stockist_style_container">
                        <div class="mipl_store_setting_title">
                            <label>
                            <strong><?php echo esc_html__('MarkerClusterer');?>:</strong>
                            </label>
                        </div>
                        <div class="mipl_store_content">
                        <?php $MarkerClusterer = '';
                        if(get_option('_mipl_sl_google_map_markerclusterer') ==  true ){
                            $MarkerClusterer = 'checked="checked"';
                        } ?>
                        <input type="checkbox" id="Map_markerclusterer"
                        name="_mipl_sl_google_map_markerclusterer" value="<?php echo esc_html(true);?>" <?php echo esc_attr($MarkerClusterer);?> >
                        <label for="Map_markerclusterer"><?php echo esc_html__('Show MarkerClusterer');?></label>
                        </div>
                    </div>




                    <div class="mipl_stockist_style_container">
                        <div class="mipl_store_setting_title">
                            <label for="Map_Type">
                            <strong><?php echo esc_html__('Map Type');?>:</strong><span class="mipl_sl_required">*</span>
                            </label>
                        </div>
                        <div class="mipl_store_content">
                            <select  name="_mipl_sl_google_map_type">
                            <?php  
                            $map_type = array(
                                'roadmap' => 'RoadMap',
                                'satellite' => 'Satellite',
                                'hybrid' => 'Hybrid',
                                'terrain' => 'Terrain',
                            );

                            $selected_map_type = get_option('_mipl_sl_google_map_type');
                                
                            foreach($map_type as $name=>$title){ 
                                $map_type_selected ="";
                                if($selected_map_type == $name){
                                    $map_type_selected = 'selected="selected"';
                                }
                                ?>
                            <option value="<?php echo esc_html($name); ?>" <?php echo esc_attr($map_type_selected); ?>><?php echo esc_html__($title); ?></option>
                                <?php
                            }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="mipl_stockist_style_container">
                        <div class="mipl_store_setting_title">
                            <label for="Map_Style">
                                <strong><?php echo esc_html__('Map Style');?>:</strong><span class="mipl_sl_required">*</span>
                            </label>
                        </div>

                        <?php             
                            $map_style = array(
                                'default' => MIPL_SL_URL.'assets/images/mipl_sl_standard .jpg',
                                'aubergine' => MIPL_SL_URL.'assets/images/mipl_sl_aubergine.jpg',
                                'dark' => MIPL_SL_URL.'assets/images/mipl_sl_dark.jpg',
                                'night' => MIPL_SL_URL.'assets/images/mipl_sl_night.jpg',
                                'silver' => MIPL_SL_URL.'assets/images/mipl_sl_silver .jpg',
                                'retro' => MIPL_SL_URL.'assets/images/mipl_sl_retro.jpg',
                                'custom_style' => 'Custom Style',
                            );
                            $selected_map_style = stripslashes(get_option('_mipl_sl_google_map_style')); ?>
                              <ul class="mipl_sl_stockist_map_style"> <?php
                            foreach($map_style as $name=>$title){ 
                                $checked ="";
                                if($selected_map_style == $name){
                                    $checked = 'checked="checked"';
                                }
                                if($name != 'custom_style'){
                                ?>
                                <li class="mipl_sl_stockist_map_style_image">
                                <div class="mipl_store_content">
                                <label>
                                    <input type="radio" name="_mipl_sl_google_map_style" <?php echo esc_attr($checked); ?> value="<?php echo esc_html($name); ?>"> 
                                    <!--<img src="<?php echo esc_html($title); ?>" alt="">-->
                                    <span><?php echo esc_html__(ucfirst($name));?></span>
                                </label>
                                </div>
                                </li>
                                <?php
                                }else{ ?>

                                <li class="mipl_sl_stockist_map_style_image">
                                <div class="mipl_store_content">
                                <label> 
                                <input type="radio" name="_mipl_sl_google_map_style" value="<?php echo esc_html($name); ?>"  <?php echo esc_attr($checked); 
                                $google_map_api_key = get_option('_mipl_sl_google_map_api_key');
                                ?> />
                                    <!--<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8/5+hHgAHggJ/PchI7wAAAABJRU5ErkJggg==" /><span>Custom Map Style</span> -->
                                    <span><?php echo esc_html__('Custom Map Style');?></span>
                                </label>
                                </div>
                                </li>

                            <?php }
                            }
                            ?>
                            </ul>  
                        <strong><?php echo esc_html__('Get custom style from following sites');?>:</strong><br> <strong><a target="_blank" href="https://mapstyle.withgoogle.com/"><?php echo esc_html__('https://mapstyle.withgoogle.com/');?> </a></strong> <br> <strong><a target="_blank"href="https://snazzymaps.com/"> <?php echo esc_html__('https://snazzymaps.com/');?></a></strong>
                        <textarea name="_mipl_sl_google_map_custom_style"  style="width:100%;  min-height: 100px;" placeholder="Enter Custom Style"><?php echo esc_html(stripslashes(get_option('_mipl_sl_google_map_custom_style')));?></textarea>
                    </div>
                  
                </div>
                <?php include_once MIPL_SL_DIR."views/view-mipl-sl-custom-fields-tab-panel.php";      
                ?> 
                <?php do_action('mipl_sl_settings_tab_panel'); ?>

                </div>
            </div>
        </div>
        
        <input type="hidden" name="mipl_action" value="save_settings" />
        <button type="submit" class="button button-primary button-large" name="mipl_action" value="save_settings"><?php echo esc_html__('Save Changes');?></button>

    </div>
</div>
</div>
</form>
</div>

<script>
jQuery(document).ready(function(){
    
    jQuery('form#mipl_sl_settings_form').submit(function(){
        
        var $this_obj = jQuery(this);
        var $req_data = jQuery(this).serializeArray();
        jQuery(this).find('button').text('Saving...');
        jQuery('.mipl_sl_notice').remove();
        jQuery.post('',$req_data,function($resp_data){
            $resp_data = JSON.parse($resp_data);
            if($resp_data.status == 'error'){
                jQuery('.wp-header-end').after('<div class="notice is-dismissible notice-error mipl_sl_notice"><p>'+$resp_data.error_massage+'</p></div>');
            }else{
                jQuery('.wp-header-end').after('<div class="notice is-dismissible notice-success mipl_sl_notice"><p>'+$resp_data.success_message+'</p></div>');

                if($resp_data.error_massage){
                    jQuery('.wp-header-end').after('<div class="notice is-dismissible notice-error mipl_sl_notice"><p>'+$resp_data.error_massage+'</p></div>');
                }
                
            }
            $this_obj.find('button').text('Save Settings');
            setTimeout(function(){ jQuery('.mipl_sl_notice').remove(); }, 3000);
        });
        
        return false;
        
    });
    
    
    
    var $active_tab = localStorage.getItem('mipl_sl_setting_active_tab');
    if( $active_tab == null ){
        $active_tab = '#mipl-general';
    }
    mipl_change_tab($active_tab);
    
    jQuery('.mipl_sl_tabs li a').click(function(){
        var $tab = jQuery(this).attr('href');
        return mipl_change_tab($tab);
    });
    
    function mipl_change_tab($tab){
        
        $tab = $tab.replaceAll('#',''); 
        
        if( jQuery('#'+$tab).length <= 0 ){ 

            if(jQuery('#mipl-general').length == 0 ){
                return false;
            }
            $tab = '#mipl-general';
            $tab = $tab.replaceAll('#',''); 
            
        }
        
        jQuery('.mipl_sl_tabs li').removeClass('mipl_sl_tab_active');
        jQuery('.mipl_sl_tabs li a[href=#'+$tab+']').parent('li').addClass('mipl_sl_tab_active');
        
        jQuery('.mipl_sl_tabs_wrap .mipl_sl_tab_content').hide(0);
        jQuery('.mipl_sl_tabs_wrap .mipl_sl_tab_content#'+$tab).show(0);
        
        localStorage.setItem('mipl_sl_setting_active_tab',$tab);
        
        return false;
        
    }
    
});
</script>