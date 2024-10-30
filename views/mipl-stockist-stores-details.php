<?php
global $post;

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


$Default_loc = array();
$mipl_sl_map_provider = mipl_sl_get_selected_map_provider();

$mipl_map_providers = array(
    'mipl-sl-google-map' => '_mipl_sl_google_map_default_location',
    'mipl-sl-here-map' => '_mipl_sl_here_map_default_location',
    'mipl-sl-bing-map' => '_mipl_sl_bing_map_default_location',
    'mipl-sl-openstreetmap' => '_mipl_sl_osm_default_location',
);

$Default_Location = get_option($mipl_map_providers[$mipl_sl_map_provider]);

$mipl_map_keys = array(
    'mipl-sl-google-map' => '_mipl_sl_google_map_api_key',
    'mipl-sl-here-map' => '_mipl_sl_here_map_api_key',
    'mipl-sl-bing-map' => '_mipl_sl_bing_map_api_key',
);

$show_current_map = 'show';
if(isset($mipl_map_keys[$mipl_sl_map_provider])){
    $show_current_map = get_option($mipl_map_keys[$mipl_sl_map_provider]);
}

if(!empty($Default_Location)){  
    $Default_loc = explode(",",$Default_Location);
}

$Default_loc[0] = isset($Default_loc[0])?$Default_loc[0]:'';
$Default_loc[1] = isset($Default_loc[1])?$Default_loc[1]:'';

$geocode_service = '';

$mipl_here_map_api = null;
if($mipl_sl_map_provider == 'mipl-sl-here-map'){
    $mipl_here_map_api = get_option('_mipl_sl_here_map_api_key');
}

?>
<div style="overflow:auto;">
    <div style="position:relative;float:left;width:100%;">
    <div class="mipl_sl_stores_details_box">
        <strong><?php echo esc_html__($address_line); ?>:</strong><span class="mipl_sl_required">*</span><br>
        <?php $_mipl_sl_address = get_post_meta($post->ID, '_mipl_sl_address', true); ?>
        <textarea class="regular-text mipl_sl_store_address_textarea" name="_mipl_sl_address"><?php echo esc_html($_mipl_sl_address); ?></textarea>
        
        <strong><?php echo esc_html__($city) ?>:</strong><span class="mipl_sl_required">*</span><br>
        <?php $_city = get_post_meta($post->ID, '_mipl_sl_city', true); ?>
        <input type="text" class="regular-text" name="_mipl_sl_city" value="<?php echo esc_attr($_city); ?>" />
        
        <strong><?php echo esc_html__($state);  ?>:</strong><span class="mipl_sl_required">*</span><br>
        <?php $_state = get_post_meta($post->ID, '_mipl_sl_state', true); ?>
        <input type="text" class="regular-text" name="_mipl_sl_state" value="<?php echo esc_attr($_state); ?>" />
        
        <strong><?php echo esc_html__($country); ?>:</strong><span class="mipl_sl_required">*</span><br>
        <?php $_country = get_post_meta($post->ID, '_mipl_sl_country', true); ?>
        <input type="text" class="regular-text" name="_mipl_sl_country" value="<?php echo esc_attr($_country); ?>" />
        
        <strong><?php echo esc_html__($map_location_latitude); ?>:</strong><span class="mipl_sl_required">*</span><br>
        <?php $_latitude = get_post_meta($post->ID, '_mipl_sl_latitude', true); ?>
        <input type="text" class="regular-text" name="_mipl_sl_latitude" value="<?php echo esc_attr($_latitude); ?>" />
        
    </div>
    <div class="mipl_sl_stores_details_box">
        <strong><?php echo esc_html__($email); ?>:</strong><span class="mipl_sl_required">*</span><br>
        <?php $_email = get_post_meta($post->ID, '_mipl_sl_email', true); ?>
        <input type="text" class="regular-text" name="_mipl_sl_email" value="<?php echo esc_attr($_email); ?>" />
        
        <strong><?php echo esc_html__($website); ?>:</strong><br>
        <?php $_website = get_post_meta($post->ID, '_mipl_sl_website', true); ?>
        <input type="text" placeholder="https://example.com"  class="regular-text" name="_mipl_sl_website" value="<?php echo urldecode_deep(esc_attr($_website)); ?>" />
        
        <strong><?php echo esc_html__($telephone); ?>:</strong><span class="mipl_sl_required">*</span><br>
        <?php $_telephone = get_post_meta($post->ID, '_mipl_sl_telephone', true); ?>
        <input type="text" class="regular-text" name="_mipl_sl_telephone" value="<?php echo esc_attr($_telephone); ?>" />
        
        <strong><?php echo esc_html__($post_code); ?>:</strong><span class="mipl_sl_required">*</span><br>
        <?php $_post_code = get_post_meta($post->ID, '_mipl_sl_post_code', true); ?>
        <input type="text" class="regular-text" name="_mipl_sl_post_code" value="<?php echo esc_attr($_post_code); ?>" />

        <strong><?php echo esc_html__($fax); ?>:</strong><br>
        <?php $_fax = get_post_meta($post->ID, '_mipl_sl_fax', true); ?>
        <input type="text" class="regular-text" name="_mipl_sl_fax" value="<?php echo esc_attr($_fax); ?>" />

        <strong><?php echo esc_html__($map_location_longitude);  ?>:</strong><span class="mipl_sl_required">*</span><br>
        <?php $_longitude = get_post_meta($post->ID, '_mipl_sl_longitude', true); ?>
        <input type="text" class="regular-text" name="_mipl_sl_longitude" value="<?php echo esc_attr($_longitude); ?>" />
    </div>
    </div>
    
    <?php 
    if($Default_Location && ($show_current_map) ){ ?>
        <div><strong><?php echo __('Note');?>:</strong> <?php echo __('Drag the map pin to your store location.');?></div>
        <div class="mipl_sl_map_location_wrapper" id="mipl_sl_map_location_wrapper" data-map_key="<?php echo esc_attr($mipl_here_map_api); ?>">
            <input type="text" name="mipl_sl_latlng_autocomplete" id="mipl_sl_latlng_autocomplete" style="position:absolute;left:15px;top:15px;z-index:999;width:250px" placeholder="<?php echo __('Enter Your Location');?>" autocomplete="off">            
            <?php 
            if($mipl_sl_map_provider == 'mipl-sl-bing-map'){ ?>
                <div id="mipl_sl_bing_map_autosuggest_opt" style="position:absolute;left:15px;top:45px;z-index:999;width:250px"></div>
                <?php
            }
            if($mipl_sl_map_provider == 'mipl-sl-openstreetmap'){
                $geocode_service = get_option('_mipl_sl_osm_geocode_service');
                ?>
                <a href="#" title="Search" id="mipl_sl_submit_osm_name" class="mipl_sl_submit_osm_name" data-geo_service="<?php echo esc_attr($geocode_service);?>" style="display: block; padding: 5px; width: 30px; height: 30px; box-sizing: border-box; position: absolute; left: 263px; top: 15px; background: white; z-index:9999; border: 1px solid #aaa; border-left: none;" ><svg class="mipl-sl-icon mipl-sl-icon-search" style="width:20px;height:20px"><use xlink:href="<?php echo esc_url(MIPL_SL_URL.'assets/images/icons.svg#mipl-sl-icon-search');?>" ></use></svg></a>
                <?php
            }
            ?>

            <div class="mipl_sl_map_location" id="mipl_sl_map_location" style="z-index:0;" data-provider="<?php echo esc_attr($mipl_sl_map_provider); ?>" data-lat="<?php echo esc_attr($Default_loc[0]); ?>" data-lng="<?php echo esc_attr($Default_loc[1]); ?>">
            </div>
        </div>
        
    <?php 
    } ?>
</div>
<?php

if($mipl_sl_map_provider == "mipl-sl-google-map"){

    $mipl_google_map_api = get_option('_mipl_sl_google_map_api_key');
    if($Default_Location && $mipl_google_map_api){
        wp_enqueue_script('mipl-sl-admin-google-maps', 'https://maps.googleapis.com/maps/api/js?key='.$mipl_google_map_api.'&libraries=geometry,places', array(), '', true);
        wp_enqueue_script('mipl-sl-admin-google-map-js', MIPL_SL_URL.'assets/js/mipl-sl-google-map-admin.min.js', array('jquery'));    
    }
    
}else{

    do_action( 'mipl_sl_add_admin_map' );

}
