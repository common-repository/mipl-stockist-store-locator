<?php get_header(); ?>

<?php $mipl_sl_map_provider = mipl_sl_get_selected_map_provider(); ?>
<div class="mipl_sl_single_store_container" data-provider="<?php echo esc_attr($mipl_sl_map_provider);?>">
    <div class="mipl_sl_inner_block">
        <h1 class="mipl_sl_stockist_heading"><?php echo esc_html__(ucfirst(get_the_title())); ?></h1>
        <div class="mipl_sl_store_image">
            <?php the_post_thumbnail('large'); ?>
        </div> 
        
        <div class="mipl_sl_store_description_wrapper">
            <div class="mipl_sl_store_description">
                <?php the_content(); ?>
            </div>
        </div>
        
        <div class="mipl_sl_stockist_fields">
        <div class="mipl_sl_store_details">
        <h2><?php echo esc_html__('Contact Details');?></h2>
        <table class="mipl_sl_first_table">
            <tr>
                <td class="mipl_sl_first_column"> <?php echo esc_html__('Address Line');?>:</td>
                <td class="mipl_sl_second_column"><?php echo wp_kses_post(nl2br(get_post_meta(get_the_id(), '_mipl_sl_address', true))); ?></td>
            </tr>
            <tr>
                <td><?php echo esc_html__('City');?>:</td>
                <td><?php echo wp_kses_post(ucfirst(get_post_meta(get_the_id(), '_mipl_sl_city', true))); ?></td>
            </tr>
            <tr>
                <td><?php echo esc_html__('State');?>:</td>
                <td><?php echo wp_kses_post(ucfirst(get_post_meta(get_the_id(), '_mipl_sl_state', true))); ?></td>
            </tr>
            <tr>
                <td><?php echo esc_html__('Country');?>:</td>
                <td><?php echo wp_kses_post(ucfirst(get_post_meta(get_the_id(), '_mipl_sl_country', true))); ?></td>
            </tr>
            <tr>
                <td><?php echo esc_html__('Post Code');?>:</td>
                <td><?php echo wp_kses_post(get_post_meta(get_the_id(), '_mipl_sl_post_code', true)); ?></td>
            </tr>                
            <tr>
                <td class="mipl_sl_first_column"><?php echo esc_html__('Email');?>:</td>
                <td class="mipl_sl_second_column"> <a href="mailto:<?php echo wp_kses_post(get_post_meta(get_the_id(), '_mipl_sl_email', true)); ?>" class="mipl_sl_listing_text"><?php echo wp_kses_post(get_post_meta(get_the_id(), '_mipl_sl_email', true)); ?></a></td>
            </tr>
            <tr>
                <td><?php echo esc_html__('Website');?>:</td>
                <td><a href="<?php echo wp_kses_post(get_post_meta(get_the_id(), '_mipl_sl_website', true)); ?>" class="mipl_sl_listing_text" target="_blank"><?php echo urldecode_deep(wp_kses_post(get_post_meta(get_the_id(), '_mipl_sl_website', true))); ?></a></td>
            </tr>
            <tr>
                <td><?php echo esc_html__('Telephone');?>:</td>
                <td><a href="tel:<?php echo wp_kses_post(get_post_meta(get_the_id(), '_mipl_sl_telephone', true)); ?>" class="mipl_sl_listing_text"><?php echo wp_kses_post(get_post_meta(get_the_id(), '_mipl_sl_telephone', true)); ?></a></td>
            </tr>
            <tr>
                <td><?php echo esc_html__('Fax');?>:</td>
                <td><?php echo wp_kses_post(get_post_meta(get_the_id(), '_mipl_sl_fax', true)); ?></td>
            </tr>

            <?php do_action('mipl_sl_before_meta_fields');?>
            
        </table>
        <div class="mipl_sl_store_map_wrapper">
            <div class="mipl_sl_single_store_map" id="mipl_sl_single_store_map"></div>
            <input type="hidden" name="mipl_sl_single_store_latitude" id="mipl_sl_single_store_latitude" value="<?php echo wp_kses_post(get_post_meta(get_the_id(), '_mipl_sl_latitude', true)); ?>">
            <input type="hidden" name="mipl_sl_single_store_longitude" id="mipl_sl_single_store_longitude" value="<?php echo wp_kses_post(get_post_meta(get_the_id(), '_mipl_sl_longitude', true)); ?>">
            <input type="hidden" name="mipl_sl_single_marker" id="mipl_sl_single_marker" value="<?php echo wp_kses_post(mipl_sl_get_store_loc_map_pin()); ?>">
        </div>
        </div>
        </div>
    </div>
</div>

<?php get_footer();