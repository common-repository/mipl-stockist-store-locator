<?php
global $post;
?>
<div style="overflow:auto">
    <?php
    $facebook =  mipl_sl_get_label('facebook'); 
    $instagram =  mipl_sl_get_label('instagram'); 
    $twitter =  mipl_sl_get_label('twitter'); 
    $linkedin =  mipl_sl_get_label('linkedin'); 
    $youtube =  mipl_sl_get_label('youtube'); 
    $whatsapp =  mipl_sl_get_label('whatsapp'); 
    $skype =  mipl_sl_get_label('skype'); 
    $pinterest =  mipl_sl_get_label('pinterest'); 
    $yelp =  mipl_sl_get_label('yelp'); 
    $trustpilot =  mipl_sl_get_label('trustpilot'); 
    $tripadvisor =  mipl_sl_get_label('tripadvisor'); 
    $google =  mipl_sl_get_label('google'); 

    $social_media = array(
        'facebook' => $facebook,
        'instagram' => $instagram,
        'twitter' => $twitter,
        'linkedin' => $linkedin,
        'youtube' => $youtube,
        'whatsapp' => $whatsapp,
        'skype' => $skype,
        'pinterest' => $pinterest,
        'yelp' => $yelp,
        'trustpilot' => $trustpilot,
        'tripadvisor' => $tripadvisor,
        'google' => $google
    );

    $social_media_links = get_post_meta($post->ID, '_mipl_sl_social_media_link', true);
    if(!$social_media_links || !is_array($social_media_links)){
        $social_media_links = array(
            "facebook" => "",
            "instagram" => "",
            "twitter" => "",
            "linkedin" => "",
            "youtube" => "",
            'whatsapp' => "",
            'skype' => "",
            'pinterest' => "",
            'yelp' => "",
            'trustpilot' => "",
            'tripadvisor' => "",
            'google' => ""
        );
    }

    foreach($social_media as $name => $title ){ 
        $mipl_sl_note = ' (URL)';
        if($name == 'skype'){
            $mipl_sl_note = ' (ID)';
        }

        $social_media_link = "";
        if(isset($social_media_links[$name])){
            $social_media_link = $social_media_links[$name];
        }

        $placeholder = "https://example.com";
        if($name == 'skype'){
            $placeholder = "";
        }

        if($name != "whatsapp"){
            ?>
            <strong><?php echo esc_html__($title . $mipl_sl_note); ?>:</strong><br>
            <input type="text" class="regular-text social_media" name="_mipl_sl_social_media_link[<?php echo esc_attr($name);?>]" placeholder="<?php echo esc_url($placeholder); ?>" value="<?php echo urldecode_deep(esc_attr($social_media_link));?>">
            <br><br>
        <?php
        }else{
            ?>
            <strong><?php echo esc_html__($title.' (Number with Country code)') ?>:</strong><br>
            <input type="text" class="regular-text social_media" name="_mipl_sl_social_media_link[<?php echo esc_attr($name);?>]" placeholder="9999999999" value="<?php echo esc_attr($social_media_link);?>">
            <br><br>
        <?php
        }
        
    }
    ?> 
</div>  