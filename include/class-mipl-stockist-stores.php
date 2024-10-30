<?php
class mipl_sl_stockist_stores{

    //Resister post type
    function register_stores_post_type(){

        $public = true;
        if(get_option('_mipl_sl_disable_stores_public_url') == 'false'){
            $public = false;
        }

        $register_post_name = esc_html(mipl_sl_get_label('store'));        
        $register_post_category = esc_html(mipl_sl_get_label('store_category'));

        register_post_type(
            MIPL_SL_POST_TYPE,
            array(
                'labels'  => array(
                    'menu_name'     => __( 'Stockist' ),
                    'all_items'     => __( ucfirst($register_post_name) ),
                    'name'          => __( $register_post_name ),
                    'singular_name' => __( $register_post_name ),
                    'add_new'       => __( 'Add New' ),
                    'add_new_item'  => __( 'Add New '.$register_post_name ),
                    'search_items'  => __( 'Search '.$register_post_name ),
                    'edit_item'     => __( 'Edit '.$register_post_name )
                ),
                'public'      => $public,
                'show_ui'     => true,
                'has_archive' => true,
                'menu_icon'   => 'dashicons-store',
                'rewrite'     => array('slug' => 'stores'),
                'supports'    => array('title', 'editor', 'thumbnail', 'revisions')
            )
        );

        $labels = array(
            'name'              => __('Categories'),
            'singular_name'     => __('Category'),
            'search_items'      => __('Search Categories'),
            'all_items'         => __('All Categories'),
            'parent_item'       => __('Parent Category'),
            'parent_item_colon' => __('Parent Category:'),
            'edit_item'         => __('Edit Category'),
            'update_item'       => __('Update Category'),
            'add_new_item'      => __('Add New Category'),
            'new_item_name'     => __('New Category Name'),
            'menu_name'         => __($register_post_category)
        );

        $args = array(
            'public'            => false,
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'store_category'),
        );

        register_taxonomy('mipl_sl_store_category', array(MIPL_SL_POST_TYPE), $args);
        
    }


    //Add meta boxes
    function add_metaboxes(){
       
        $store_details =  mipl_sl_get_label('stores_details');
        $opning_hours =  esc_html(mipl_sl_get_label('opening_hours'));
        $social_media_links =  esc_html(mipl_sl_get_label('social_media_links'));
        $store_custom_fields =  esc_html(mipl_sl_get_label('store_custom_fields'));
        
        add_meta_box('mipl_sl_stores_details', __( $store_details ),  array($this,'stores_details_box'), MIPL_SL_POST_TYPE, 'normal', 'default');
        add_meta_box('mipl_sl_opening_details', __($opning_hours),   array($this,'stores_opening_details_box'), MIPL_SL_POST_TYPE, 'normal', 'default');
        add_meta_box('mipl_sl_socialmedia_details', __($social_media_links),  array($this,'social_media_links_details_box'), MIPL_SL_POST_TYPE, 'normal', 'default');

        add_meta_box('mipl_sl_custom_fields', __($store_custom_fields),  array($this,'store_custom_fields_meta_box'), MIPL_SL_POST_TYPE, 'normal', 'default');
    }

    
    // stores details
    function stores_details_box(){
        include_once MIPL_SL_DIR.'/views/mipl-stockist-stores-details.php';
    }

    
    //stores opening details
    function stores_opening_details_box(){        
        include_once MIPL_SL_DIR.'/views/mipl-stockist-stores-opening-details.php';        
    }


    //store social media links
    function social_media_links_details_box(){        
        include_once MIPL_SL_DIR.'/views/mipl-stockist-stores-social-media-details.php';        
    }


    // store fields metabox
    function store_custom_fields_meta_box(){
        
        global $post;
        $custom_fields =  get_option('_mipl_sl_stockist_custom_fields');
        $array_keys = array();
        if(isset($custom_fields['errors'])){
            foreach($custom_fields['errors'] as $key => $values){
                foreach($values as $key1 => $value){
                    $array_keys[$key1] = $value;
                }
            }
        }
        
        if(!empty($custom_fields) && isset($custom_fields['label'])){
            
            foreach($custom_fields['label'] as $key => $value){
                $id = get_the_ID();

                if(in_array($key, array_keys($array_keys))){
                    continue;
                }
                $requires_content = "";
                if(in_array($custom_fields['name'][$key], $custom_fields['required'])){
                    $requires_content = '<span class="mipl_sl_required">*</span>';
                }

                
                if(isset($custom_fields['type'][$key]) && $custom_fields['type'][$key] == "text"){
                    $current_post_metadata = get_post_meta($id, '_mipl_sl_'.$custom_fields['name'][$key], true);
                    $text_value = $custom_fields['default_value'][$key];
                    
                    if(!empty($current_post_metadata)){
                        $text_value = $current_post_metadata;
                    } 
                    ?>
                    <div class="mipl_custom_field">
                    <strong><label for="<?php echo esc_attr($custom_fields['name'][$key]);?>"><?php echo ucwords(esc_html__($value));?>:<?php echo wp_kses_post($requires_content);?></label></strong><br>
                        <input class="fields_full_width" type="<?php echo esc_attr($custom_fields['type'][$key]); ?>" name="<?php echo esc_attr($custom_fields['name'][$key]);?>" id="<?php echo esc_attr($custom_fields['name'][$key]);?>" value="<?php echo esc_attr($text_value);?>">
                    </div>
                    <br>
                    <?php
                }elseif(isset($custom_fields['type'][$key]) && $custom_fields['type'][$key] == "textarea"){
                    $textarea_value = $custom_fields['txt_default_value'][$key];
                    $current_post_metadata = get_post_meta($id, '_mipl_sl_'.$custom_fields['name'][$key], true);
                    if(!empty($current_post_metadata)){
                        $textarea_value = $current_post_metadata;
                    }
                    ?>
                    <div class="mipl_custom_field">
                    <strong><label for="<?php echo esc_attr($custom_fields['name'][$key]);?>"><?php echo ucwords(esc_html__($value));?>:<?php echo wp_kses_post($requires_content);?></label></strong><br>
                        <textarea class="fields_full_width" name="<?php echo esc_attr($custom_fields['name'][$key]);?>" id="<?php echo esc_attr($custom_fields['name'][$key]);?>"  rows=""><?php echo wp_kses_post($textarea_value);?></textarea>
                    </div>
                    <br>
                    <?php
                }elseif(isset($custom_fields['type'][$key]) && $custom_fields['type'][$key] == "select"){ ?>
                    <div class="mipl_custom_field">
                        <strong><label for="<?php echo esc_attr($custom_fields['name'][$key]);?>"><?php echo ucwords(esc_html__($value));?>:<?php echo wp_kses_post($requires_content);?></label><strong><br>
                        <select class="fields_full_width" name="<?php echo esc_attr($custom_fields['name'][$key]);?>" id="<?php echo esc_attr($custom_fields['name'][$key]);?>">  
                        <?php
                        $field_values = $custom_fields['options'][$key];
                        $field_values = preg_split("/[\n]+/", trim($field_values));
                        
                        foreach($field_values as $option_key => $option_value){
                            if(strpos($option_value,":")){
                                $tmp = explode(':',trim($option_value));
                                if(!empty($tmp[0] && !empty($tmp[1]))){
                                    $explode_array[strtolower(trim($tmp[0]))] = ucfirst(trim($tmp[1]));
                                }
                            }else{
                                $tmp = explode('/n',trim($option_value));
                                if(!empty($tmp[0])){
                                    $explode_array[strtolower(trim($tmp[0]))] = ucfirst(trim($tmp[0]));
                                }
                            }
                        }
                        
                        $selected_item = get_post_meta($id, '_mipl_sl_'.$custom_fields['name'][$key], true);
                        foreach($explode_array as $field_value => $field_title){
                            $selected = '';
                            if($selected_item == trim($field_value)){
                                $selected = 'selected';
                            } ?>
                            <option value="<?php echo esc_attr(trim($field_value));?>" <?php echo esc_attr($selected); ?>><?php echo esc_html__($field_title);?></option> <?php
                        } ?>
                        </select>
                    </div>
                    <br>
                    <?php 
                }
            }
        }?>
        
        <!-- <a href="<?php// echo admin_url( 'edit.php?post_type='.MIPL_SL_POST_TYPE.'&page=mipl-sl-settings#mipl-store-fields')?>" class="button">Add more fields</a> 
        -->

        <div class="mipl_sl_add_more_field_button">
            <button type="button" class="button mipl_sl_add_more_button" data-url="<?php echo esc_url( admin_url( 'edit.php?post_type=mipl_sl_stores&page=mipl-sl-settings#mipl-store-fields') )?>" ><?php echo esc_html__('Add more fields');?></button>
        </div>

        <script>
            jQuery(document).ready(function(){
                jQuery('.mipl_sl_add_more_button').on('click', function(){
                    var redirect_url = jQuery(this).attr('data-url');
                    localStorage.setItem('mipl_sl_setting_active_tab','mipl-store-fields');
                    window.location.href = redirect_url;
                });
            });
        </script>

        <?php 

    }

    
    //save postmeta
    function save_custom_postmeta($post_id, $post, $update){

        global $wpdb;
        
        if ( !$update ){
            return false;
        }

        $mipl_post_status = array('publish', 'draft');
        if( !in_array($post->post_status, $mipl_post_status)){
            return false;
        }
        
        if ( $post->post_type != MIPL_SL_POST_TYPE ){
            return false;
        }

        $store_fields = mipl_sl_get_store_details();
        
        $val_obj = new MIPL_SL_Input_Validation($store_fields);
        $val_obj->validate();
        $errors = $val_obj->get_errors();
        $post_data = $val_obj->get_valid_data();

        foreach($post_data as $key => $value){
            update_post_meta($post_id, $key, $value);
        }
                
        do_action('mipl_sl_custom_fields');

        if(isset($post_data['_mipl_sl_latitude'])){
            
            $table = $wpdb->prefix.'mipl_store_locator';
            $data = array(
                'post_id' => $post_id,
                'latitude' => $post_data['_mipl_sl_latitude'],
                'longitude' => $post_data['_mipl_sl_longitude'],
            );
            
            $checked_val = $this->get_stores($post_id);
            if ($checked_val === false) {
                $wpdb->insert($table, $data);
            } else {
                $wpdb->update($table, $data, array('post_id' => $post_id));
            }
            
        }
        
        if( !empty($errors) ){
            $_SESSION['mipl_sl_admin_notices']['error'] = implode('<br />',$errors);
        }

    }

    
    // get stores 
    function get_stores($postID){
        
        global $wpdb;
        
        $table = $wpdb->prefix.'mipl_store_locator';

        $post_id =  $wpdb->get_row("SELECT * FROM `$table` WHERE post_id = '$postID'");

        if ($post_id != null) {
            return true;
        } else {
            return false;
        }
        
    }
    

    // get stores html
    function mipl_get_stores_html(){

        global $wpdb;
        $distance = $latitude = $longitude = "";
        if (isset($_POST['mipl_sl_distance']) && !empty($_POST['mipl_sl_distance']) && isset($_POST['mipl_sl_current_location_latitude'])) {
            $distance =  sanitize_text_field($_POST['mipl_sl_distance']);
            $latitude = sanitize_text_field($_POST['mipl_sl_current_location_latitude']);
            $longitude = sanitize_text_field($_POST['mipl_sl_current_location_longitude']);
        }
   
        $distance_unit = get_option('_mipl_sl_distance_unit');
        if($distance_unit == 'km'){
            $unit = 6372.795477598;
        }elseif($distance_unit == 'mile'){
            $unit = 3959;
        }else{
            $unit = 6372.795477598;
        }


        $default_distance = get_option('_mipl_sl_default_distance');
        if( isset($_POST['mipl_sl_current_location_latitude']) ){
            $latitude = sanitize_text_field($_POST['mipl_sl_current_location_latitude']);
        }

        if(isset($_POST['mipl_sl_current_location_longitude'])){
            $longitude = sanitize_text_field($_POST['mipl_sl_current_location_longitude']);
        }


        $nearest_store_ids = array();
        if (isset($_POST['mipl_sl_distance']) && !empty($_POST['mipl_sl_distance']) && !empty($latitude) && !empty($longitude)  ) {

            $sl_table_name = $wpdb->prefix.'mipl_store_locator';
            $query = "SELECT post_id, ( $unit * acos ( cos ( radians('$latitude') ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians('$longitude') ) + sin ( radians('$latitude') ) * sin( radians( `latitude`) ) ) ) AS `distance` FROM `$sl_table_name` HAVING distance < '$distance' ORDER BY `distance`";

            $nearest_store_ids = $wpdb->get_col($query);            
            
            if (empty($nearest_store_ids)) {
                $data = "";
                echo $data;
                die();
            }

        }else if(!empty($default_distance) && !empty($latitude) && !empty($longitude) && (!isset($_POST['mipl_sl_distance']) || empty($_POST['mipl_sl_distance']))){
            
            $sl_table_name = $wpdb->prefix.'mipl_store_locator';
            $query = "SELECT post_id, ( $unit * acos ( cos ( radians('$latitude') ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians('$longitude') ) + sin ( radians('$latitude') ) * sin( radians( `latitude`) ) ) ) AS `distance` FROM `$sl_table_name` HAVING distance < '$default_distance' ORDER BY `distance`";

            $nearest_store_ids = $wpdb->get_col($query);
            if (empty($nearest_store_ids)) {
                $data = "";
                echo $data;
                die();
            }
            
        }

        $args = array(
            'numberposts' => -1,
            'post_type' => MIPL_SL_POST_TYPE,
        );

        if (!empty($nearest_store_ids)) {
            $args['post__in'] = $nearest_store_ids;
        }

        if( isset($_POST['mipl_sl_stores_category']) && $_POST['mipl_sl_stores_category'] != 'All') {
            $args['tax_query'][] = array(
                'taxonomy' => 'mipl_sl_store_category',
                'field'    => 'term_id',
                'terms'    => sanitize_text_field($_POST['mipl_sl_stores_category']),

            );
        }

        $stores = get_posts($args);
        
        ob_start();
        
        $time_on_list = get_option('_mipl_sl_display_time_on_list');
        $time_on_infowindow = get_option('_mipl_sl_display_time_on_infowindow');
        $social_on_list = get_option('_mipl_sl_display_social_on_list');
        $social_on_infowindow = get_option('_mipl_sl_display_social_on_infowindow');
        $map_provider = mipl_sl_get_selected_map_provider();
        $disable_stores_public_url = get_option('_mipl_sl_disable_stores_public_url');
        $hide_image_on_list = get_option('_mipl_sl_hide_image_on_list');
        $hide_image_on_infowindow = get_option('_mipl_sl_hide_image_on_infowindow');

        $the_date = date('d-m-Y');
        $name_of_the_day = date('l', strtotime($the_date));
        $name_of_the_day = strtolower($name_of_the_day);

        foreach ($stores as $key => $store) {

            $post_meta = get_post_meta($store->ID);
            
            $mipl_sl_address = $mipl_sl_email = $mipl_sl_latitude = $mipl_sl_longitude = $mipl_sl_telephone = "";
            if(isset($post_meta['_mipl_sl_address'][0])){
                $mipl_sl_address = rtrim($post_meta['_mipl_sl_address'][0],',');
            }
            if(isset($post_meta['_mipl_sl_city'][0]) && !empty($post_meta['_mipl_sl_city'][0])){
                $mipl_sl_address .= ', '.$post_meta['_mipl_sl_city'][0];
            }
            if (isset($post_meta['_mipl_sl_state'][0]) && !empty($post_meta['_mipl_sl_state'][0])) {
                $mipl_sl_address .= ', '.$post_meta['_mipl_sl_state'][0];
            }
            if( isset($post_meta['_mipl_sl_country'][0]) && !empty($post_meta['_mipl_sl_country'][0])){
                $mipl_sl_address .= ', '.$post_meta['_mipl_sl_country'][0];
            }

            $mipl_sl_telephone = (isset($post_meta['_mipl_sl_telephone'][0])) ? $post_meta['_mipl_sl_telephone'][0] : '';
            $mipl_sl_email = (isset($post_meta['_mipl_sl_email'][0])) ? $post_meta['_mipl_sl_email'][0] : '';
            $mipl_sl_latitude = (isset($post_meta['_mipl_sl_latitude'][0])) ? $post_meta['_mipl_sl_latitude'][0] : '';
            $mipl_sl_longitude = (isset($post_meta['_mipl_sl_longitude'][0])) ? $post_meta['_mipl_sl_longitude'][0] : '';
            $mipl_sl_telephone = (isset($post_meta['_mipl_sl_telephone'][0])) ? $post_meta['_mipl_sl_telephone'][0] : '';

            if(isset($post_meta['_mipl_sl_opening_hours'][0])){
                $time = ( is_serialized($post_meta['_mipl_sl_opening_hours'][0])) ? unserialize($post_meta['_mipl_sl_opening_hours'][0]) : $post_meta['_mipl_sl_opening_hours'][0];
            }
            
            
            $social_media = (is_serialized($post_meta['_mipl_sl_social_media_link'][0])) ? unserialize($post_meta['_mipl_sl_social_media_link'][0]) : $post_meta['_mipl_sl_social_media_link'][0];

            $mipl_sl_website = (isset($post_meta['_mipl_sl_website'][0])) ? $post_meta['_mipl_sl_website'][0] : '';
            $MIPL_SL_PATH = MIPL_SL_URL;
            $store_image = '';
            if( has_post_thumbnail( $store->ID ) ){
                $store_thumbnail_id =  get_post_thumbnail_id($store->ID);
                $store_src = wp_get_attachment_image_src( $store_thumbnail_id );
                $store_image = (empty($store_src)) ? '' : $store_src[0];
            }
            
            $todays_time = isset($time[$name_of_the_day]) ? $time[$name_of_the_day] : '';
            $store_opening_hour = "";
            
            if( isset($todays_time['closed']) && $todays_time['closed'] == '1'){
                $store_opening_hour = __('Closed');
            }else{
                if( (isset($todays_time['opening_hour']) && $todays_time['opening_hour'] != '') && (isset($todays_time['closing_hour']) && $todays_time['closing_hour'] != '')){
                    $store_opening_hour =  $todays_time['opening_hour'].' - '.$todays_time['closing_hour'];
                }
            }
            
            $store_opening_hour_info = "";
            if($time_on_infowindow == "yes" ){
                if( isset($todays_time['closed']) && $todays_time['closed'] == '1'){
                    $store_opening_hour_info = __('Closed');
                }else{
                    if(( isset($todays_time['opening_hour']) && $todays_time['opening_hour'] != '') && (isset($todays_time['closing_hour']) && $todays_time['closing_hour'] != '')){
                        $store_opening_hour_info =  $todays_time['opening_hour'].' - '.$todays_time['closing_hour'];
                    }
                }
            }
            ?>
            <div class="mipl_sl_stockist_item" data-store_id="<?php echo esc_attr($store->ID);?>" data-store_latitude="<?php echo esc_attr($mipl_sl_latitude);?>" data-store_longitude="<?php echo esc_attr($mipl_sl_longitude)?>" data-infotime="<?php echo esc_attr($time_on_infowindow);?>" data-infosocial="<?php echo esc_attr($social_on_infowindow);?>" data-image="<?php echo esc_attr($store_image); ?>" data-hide_image="<?php echo esc_attr($hide_image_on_infowindow); ?>">
            <?php
            if(!empty($store_image) && $hide_image_on_list != 'yes'){
                ?>
                <img src="<?php echo esc_attr($store_image);?>" width="70px" class="mipl_sl_store_img" />
                <?php
            }
            
            $item_permalink = '<strong class="mipl_sl_store_title">'.esc_html(ucwords($store->post_title)).'</strong>';
            if(get_option('_mipl_sl_disable_stores_public_url') != 'false' ){
                $item_permalink = '<a href="'.esc_attr(get_the_permalink($store->ID)).'"><strong class="mipl_sl_store_title">'.esc_html(ucwords($store->post_title)).'</strong></a>';
            }
            
            echo wp_kses_post($item_permalink);?>
                
            <?php if($mipl_sl_address != ""){ ?>
            <div class="mipl_sl_item_row" data-address="<?php echo esc_attr($mipl_sl_address);?>">
                <div class="icon mipl-sl-icon-home"></div>
                <?php echo esc_html($mipl_sl_address);?>
            </div>
            <?php } 
            
            if($mipl_sl_telephone != ""){ ?>
                <div class="mipl_sl_item_row" data-tel="<?php echo esc_attr($mipl_sl_telephone);?>">
                    <div class="icon mipl-sl-icon-call"></div>
                    <a href="tel:<?php echo esc_attr($mipl_sl_telephone);?>"><?php echo esc_html($mipl_sl_telephone);?></a>
                </div>
                <?php
            }
            
            if($mipl_sl_email != ""){?>
                <div class="mipl_sl_item_row" data-email="<?php echo esc_attr($mipl_sl_email);?>">
                    <div class="icon mipl-sl-icon-email"></div>
                    <a href="mailto:<?php echo esc_attr($mipl_sl_email);?>"><?php echo esc_html($mipl_sl_email);?></a>
                </div>
                <?php
            }
            
            if($mipl_sl_website != ""){?>
                <div class="mipl_sl_item_row" data-web="<?php echo urldecode_deep(esc_attr($mipl_sl_website));?>">
                    <div class="icon mipl-sl-icon-android-globe"></div>
                    <a target="_blank" href="<?php echo esc_attr($mipl_sl_website);?>"><?php echo urldecode_deep(esc_html($mipl_sl_website));?></a>
                </div>
                <?php
            }
            $display_opening_hour = "none";
            if($time_on_list == "yes" && $store_opening_hour != ''){
                $display_opening_hour = "";
            }
            
            ?>
            <div class="mipl_sl_item_row" style="display:<?php echo esc_attr($display_opening_hour);?>" data-time="<?php echo esc_attr($store_opening_hour);?>">
                <div class="icon mipl-sl-icon-time"></div>
                <a class="mipl_sl_full_week_time_shedule"><?php echo esc_html($store_opening_hour);?> ▾</a>
                <div class="mipl_sl_full_week_time"> </div>
            </div>
            <?php
            // }

            $display_social_media = "none";
            if($social_on_list == "yes"){
                $display_social_media = "";
            }

            if($social_media != "" ){
                ?>
                <div class="mipl_sl_item_row" style="margin-top:10px; display:<?php echo esc_attr($display_social_media);?>">
                    <div class="mipl_sl_social_media_links">
                        <?php $links = array("facebook", "twitter", "instagram", "linkedin", "youtube", "whatsapp", "skype","pinterest", "yelp", "trustpilot", "tripadvisor", "google"); 

                        // if($social_media != "" && $social_on_list != ""){
                            foreach($links as $link){

                                if(isset($social_media[$link]) && $social_media[$link] != "" && $link != 'whatsapp' && $link != 'skype'  && $link != 'trustpilot'){
                                ?>
                                <a href="<?php echo esc_attr($social_media[$link]); ?>" title="<?php echo esc_attr(ucfirst($link)); ?>" target="_blank">
                                <div class="icon mipl-sl-icon-<?php echo esc_attr($link);?>"></div></a>
                                <?php  
                                }elseif(isset($social_media[$link]) && $social_media[$link] != "" && $link == 'whatsapp'){
                                    ?>
                                    <a href="<?php echo esc_attr('https://wa.me/'.$social_media[$link]); ?>" target="_blank" title="<?php echo esc_attr(ucfirst($link)); ?>">
                                    <div class="icon mipl-sl-icon-<?php echo esc_attr($link);?>"></div></a>
                                    <?php  
                                }elseif(isset($social_media[$link]) && $social_media[$link] != "" && $link == 'skype'){
                                    ?>
                                    <a href="<?php echo esc_attr('skype:'.$social_media[$link].'?chat'); ?>" target="_blank" title="<?php echo esc_attr(ucfirst($link)); ?>"><div class="icon mipl-sl-icon-<?php echo esc_attr($link);?>"></div></a>
                                    <?php  
                                }elseif(isset($social_media[$link]) && $social_media[$link] != "" && $link == "trustpilot"){                                   
                                    ?>
                                    <a href="<?php echo esc_attr($social_media[$link]); ?>" style="vertical-align: top;" target="_blank" title="<?php echo esc_attr(ucfirst($link)); ?>">
                                    <img src="<?php echo esc_attr(MIPL_SL_URL.'assets/images/trustpilot.svg'); ?>" alt="" class="icon mipl_sl_trustpilot">
                                    </a>
                                    <?php 
                                }
                            }
                        // }
                        ?>
                    </div>
                </div>
                <?php
                }
                ?>

        </div>
        <?php
        }

        $html = ob_get_contents();
        ob_end_clean();

        echo $html;
        die();

        // $data['stores'] = $html;
        // return $data;

    }



    // Get store opening details
    function get_store_opening_details(){
        
        ob_start();
        $opening_time = get_post_meta($_POST['store_id'], '_mipl_sl_opening_hours', true);
        $opening_hours_note = get_post_meta($_POST['store_id'], '_mipl_sl_opening_hours_note', true);
        
        ?>
        <table>
        <?php
        $days = array("monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday");
        foreach($days as $day){
            if(isset($opening_time[$day]['opening_hour']) && 
            $opening_time[$day]['opening_hour'] != "" && 
            $opening_time[$day]['closing_hour'] != "" && 
            $opening_time[$day]['closed'] != '1'){ ?>
            <tr>
                <td><?php echo esc_html__(ucfirst($day))?></td>
                <td><?php echo esc_html($opening_time[$day]['opening_hour'] .' - '. $opening_time[$day]['closing_hour']) ?></td>
            </tr>
            <?php }
            if( isset($opening_time[$day]['closed']) && $opening_time[$day]['closed'] == 1){ ?>
                <tr>
                    <td><?php echo esc_html__(ucfirst($day))?></td> 
                    <td><?php echo esc_html__('Closed');?></td> 
                </tr>
           <?php }
        } ?>
        </table><?php
        if($opening_hours_note){
        echo esc_html('Description: ' .$opening_hours_note);
        }

        $contents = ob_get_contents();        
        ob_end_clean();
        echo $contents;
        die();
        return $contents;

    }


    // add custom columns
    function update_stores_columns($columns){

        $post_type = get_post_type();
        $address =  esc_html(mipl_sl_get_label('address'));
        $location =  esc_html(mipl_sl_get_label('location'));
        $email =  esc_html(mipl_sl_get_label('email'));
        $phone =  esc_html(mipl_sl_get_label('phone'));
        $author =  esc_html(mipl_sl_get_label('author'));
        $image =  esc_html(mipl_sl_get_label('image'));
        
        
        $new_columns = array(
            'cb' => $columns['cb'],            
            'image' => __($image),
            'title' => $columns['title'],
            'address' => __($address, 'your_text_domain'),
            'map_location' => __($location, 'your_text_domain'),
            'email' => __($email, 'your_text_domain'),
            'phone' => __($phone, 'text_domain'),
            'author' => __($author, 'text_domain'),
            'date' => $columns['date'],
        );
        if(wp_is_mobile()){
            $new_columns = array(
                'cb' => $columns['cb'],            
                'title' => $columns['title'],
                'image' => __($image),
                'address' => __($address, 'your_text_domain'),
                'map_location' => __($location, 'your_text_domain'),
                'email' => __($email, 'your_text_domain'),
                'phone' => __($phone, 'text_domain'),
                'author' => __($author, 'text_domain'),
                'date' => $columns['date'],
            );
        }
        
        return $new_columns;
        
    }


    // show table data
    function show_stores_columns_data($column_name, $id){
        if ( get_post_type( $id ) == MIPL_SL_POST_TYPE ) {
            if ('address' === $column_name) {
                $mipl_sl_address = get_post_meta($id, '_mipl_sl_address', true);
                if(!empty(get_post_meta($id, '_mipl_sl_city', true))){
                    $mipl_sl_address .= ', '.get_post_meta($id, '_mipl_sl_city', true);
                }
                if(!empty(get_post_meta($id, '_mipl_sl_state', true))){
                    $mipl_sl_address .= ', '.get_post_meta($id, '_mipl_sl_state', true);    
                }
                if(!empty(get_post_meta($id, '_mipl_sl_country', true))){
                    $mipl_sl_address .= ', '.get_post_meta($id, '_mipl_sl_country', true);    
                }                
                echo esc_html($mipl_sl_address);
            }
            if ('map_location' === $column_name) {

                $latlan = "";
                if(!empty(get_post_meta($id, '_mipl_sl_latitude', true))){
                    $latlan = esc_html(get_post_meta($id, '_mipl_sl_latitude', true));
                }
                if(!empty(get_post_meta($id, '_mipl_sl_longitude', true))){
                    if(empty($latlan)){
                        $latlan .= esc_html(get_post_meta($id, '_mipl_sl_longitude', true));
                    }else{
                        $latlan .= ", ".esc_html(get_post_meta($id, '_mipl_sl_longitude', true));
                    }
                }
                
                echo esc_html($latlan);
                
            }
            if ('email' === $column_name) {
                echo esc_html(get_post_meta($id, '_mipl_sl_email', true));
            }
            if ('phone' === $column_name) {
                echo esc_html(get_post_meta($id, '_mipl_sl_telephone', true));
            }
            if ('image' === $column_name) {
                $url = wp_get_attachment_url( get_post_thumbnail_id($id), 'thumbnail' ); ?>
                <img src="<?php echo esc_attr($url);?>" width="90px"  /><?php
            }
           
        }
    }
    


    // Get filter
    function mipl_get_map_filter(){

        $mipl_google_map_filters = [];
        if(empty(get_option('_mipl_sl_distances'))){
            $distance_values = array(10, 20, 30, 40, 50);
            $distance =  $distance_values;
        }else{
            $distance_values = get_option('_mipl_sl_distances');
            $distance = explode(",", $distance_values);
        }
        $mipl_google_map_filters['distance'] = $distance;
        $terms = get_terms('mipl_sl_store_category', array(
            'hide_empty' => false,
        ), array(MIPL_SL_POST_TYPE => false));
   
        $mipl_google_map_filters['category'] = $terms;    
    
        $distance_type = get_option('_mipl_sl_distance_unit');
        $mipl_google_map_filters['distance_type'] = $distance_type;
        if(empty($distance_type)){
            $mipl_google_map_filters['distance_type'] = 'km';
        }

        $default_distance = get_option('_mipl_sl_default_distance');
        $mipl_google_map_filters['default_distance'] = $default_distance;
    
        return $mipl_google_map_filters;
                
    }



    // show list and map
    function mipl_sl_listing(){

        ob_start();
        include_once MIPL_SL_DIR.'views/mipl-stockist-widgets.php';
        $contents = ob_get_contents();
        ob_end_clean();        
        return $contents;
        
    }


    function store_data_filter( $data, $postarr ) {
        
        if(MIPL_SL_POST_TYPE == $data['post_type']){
            
            if ( is_array( $data ) && 'publish' == $data['post_status'] ) {
                if( isset( $postarr['_mipl_sl_latitude'] ) && isset( $postarr['_mipl_sl_longitude'] )  && 'publish' == $data['post_status'] ){
                    if( empty( $data['post_title'] ) || empty( $postarr['_mipl_sl_latitude'] ) || empty( $postarr['_mipl_sl_longitude'] )){
                        $data['post_status'] = 'draft';
                    }
                }
            }

        }

        return $data;
        
    }

    
    function store_force_draft( $meta_id, $post_id ) {
        
        if( get_post_type( $post_id ) == MIPL_SL_POST_TYPE ) {
            
            $latitude = get_post_meta( $post_id, '_mipl_sl_latitude', true );
            $longitude = get_post_meta( $post_id, '_mipl_sl_longitude', true );
            if( ( !$latitude || !$longitude ) || empty( $latitude ) || empty( $longitude ) ) {
            
                $post_status = get_post_status($post_id);
                if($post_status != "draft"){
                    $my_post = array(
                        'ID' => $post_id,
                        'post_status' => 'draft'
                    );
                
                    wp_update_post( $my_post );
                
                }
            }
        }
    }

}