<?php
$enter_your_location = esc_html(mipl_sl_get_label('enter_your_location'));
$select_distance = esc_html(mipl_sl_get_label('select_distance'));
$all_category = esc_html(mipl_sl_get_label('all_category'));
$submit = esc_html(mipl_sl_get_label('submit'));
$loading = esc_html(mipl_sl_get_label('loading'));

$mipl_sl_filter = '<div class="mipl_sl_filter_form_wrap"></div>';
$mipl_sl_map = '<div id="mipl_sl_stockist_map" class="mipl_sl_stockist_height mipl_sl_stockist_map_tag"></div>';
$mipl_sl_list = '<div class="mipl_sl_stockist_listing"><div style="text-align:center; padding:10px;">'.esc_html__($loading).'</div></div>';
$mipl_template = get_option('_mipl_sl_layout_type');
$open_info_window = get_option('_mipl_sl_open_info_window');
$open_info_window = !empty($open_info_window) ? $open_info_window : 'click';

if(empty($mipl_template)){
    $mipl_template = 'template1';
}

if( $mipl_template == "custom_template"){
    $mipl_layout = wp_kses_post(stripslashes(get_option('_mipl_sl_custom_template')));
}else{
    include_once  MIPL_SL_DIR.'views/mipl-stockist-layout-type.php';
    $mipl_layout = get_layout($mipl_template);
}

if (!str_contains($mipl_layout, '[mipl_sl_stockist_store_list]')) {
    $mipl_layout = $mipl_layout.'<div class="mipl_sl_remove_listing">[mipl_sl_stockist_store_list]</div>';
}

if (!str_contains($mipl_layout, '[mipl_sl_stockist_map]')) {
    $mipl_layout = $mipl_layout.'<div class="mipl_sl_remove_map">[mipl_sl_stockist_map]</div>';
}

$layout = str_replace(array('[mipl_sl_stockist_filter]','[mipl_sl_stockist_store_list]','[mipl_sl_stockist_map]'),array($mipl_sl_filter, $mipl_sl_list, $mipl_sl_map), $mipl_layout);


if( $mipl_template == 'template3' || $mipl_template == 'template4' ){
    $mipl_template .= ' mipl_sl_template_sidefilter';
}
$mipl_sl_map_provider = mipl_sl_get_selected_map_provider();
$mipl_sl_address_style = "";
if($mipl_sl_map_provider == 'mipl-sl-bing-map'){
    $mipl_sl_address_style = "height: 35px;padding-top: 0; padding-bottom: 0; display: block"; 
}

?> 
<?php do_action('mipl_sl_before_stockist_widget');?>
<div class="mipl_sl_stockist mipl_sl_<?php echo $mipl_template;?>" data-open_info_window="<?php echo esc_attr($open_info_window); ?>">
    
<?php echo wp_kses_post($layout); ?>

<script type="text/template" class="mipl_sl_filter_form_template">
<form action="" method="post" id="stockist_filter_form" class="stockist_filter_form" name="stockist_filter_form">
<div class="mipl_sl_stockist_filter">
<div class="mipl_sl_input_wrap" id="mipl_sl_curr_loc_input">
<input type="text" name="mipl_sl_current_location" class="mipl_sl_current_location mipl_sl_border_color" id="mipl_sl_current_location" placeholder="<?php echo esc_attr($enter_your_location)?>" autocomplete="off" value="" style="<?php echo esc_attr($mipl_sl_address_style); ?>" />
<input type="hidden" id="mipl_sl_current_location_latitude" name="mipl_sl_current_location_latitude" value="">
<input type="hidden" id="mipl_sl_current_location_longitude" name="mipl_sl_current_location_longitude" value="">

<?php
$mipl_sl_map_provider = mipl_sl_get_selected_map_provider();
    
if($mipl_sl_map_provider == 'mipl-sl-openstreetmap'){
    ?>
    <a href="#" title="Search" id="mipl_sl_submit_name" class="mipl_sl_submit_name mipl_sl_border_color"><svg class="mipl-sl-icon mipl-sl-icon-search"><use xlink:href="<?php echo esc_attr(MIPL_SL_URL);?>assets/images/icons.svg#mipl-sl-icon-search" ></use></svg></a>
    <?php
}
?>
</div>
<div class="mipl_sl_input_wrap">
<a href="" title="Current Location" id="mipl_sl_getcurrentlocation" class="mipl_sl_current_location_btn mipl_sl_border_color"><svg class="mipl-sl-icon mipl-sl-icon-locate mipl_sl_user_current_location"><use xlink:href="<?php echo esc_attr(MIPL_SL_URL.'assets/images/icons.svg#mipl-sl-icon-locate')?>" ></use></svg></a>
</div>
<div class="mipl_sl_input_wrap">
<select id="mipl_sl_distance" name="mipl_sl_distance" class="mipl_sl_distance mipl_sl_border_color"><option value=""><?php echo esc_html__($select_distance)?></option></select>
</div>
<div class="mipl_sl_input_wrap">
<select id="mipl_sl_store_category" name="mipl_sl_stores_category" class="mipl_sl_store_category mipl_sl_border_color"><option value="All"><?php echo esc_html__($all_category)?></option></select>
</div>
<div class="mipl_sl_input_wrap"><button type="submit" name="mipl_sl_submit_button" class="button mipl_sl_filter_button" value="<?php echo esc_html($submit)?>" style="padding: 0px!important;"><?php echo esc_html__($submit)?></button></div>
</div>
</form>
</script>

<script>
if( jQuery('.mipl_sl_filter_form_wrap').length > 0 ){
    var $mipl_sl_filter_form_template =  document.querySelector(".mipl_sl_filter_form_template").innerText;
    document.querySelector(".mipl_sl_filter_form_wrap").innerHTML = $mipl_sl_filter_form_template;
} 
</script>

<?php
if( is_admin() ){
?>
<script>
 mipl_sl_stockist_init_map();
</script>
<?php
}elseif ( ( isset($_REQUEST['vc_editable']) && $_REQUEST['vc_editable'] == true ) && function_exists( 'vc_map' ) ) {    
?>
<script>
mipl_sl_stockist_init_map();
</script>
<?php
}
?>

</div>
<?php do_action('mipl_sl_after_stockist_widget');?>