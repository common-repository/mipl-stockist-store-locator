<?php
$mipl_sl_addons = array(
    'stores_locator_pro' => array(
        'name' => 'MIPL Stockist/Store Locator - Pro',
        'logo' => 'store-locator-logo-pro.png',
        'heading' => __('MIPL Stockist/Stores Locator - Pro'),
        'description' => __('Create a quick Stockist/Store Locator with Google map, Autocomplete search location & Distance & Category filter,
        also with multiple/custom layout and multiple/custom map style, Shortcode [mipl_stockist_store_locator].'),
        'product_link' => 'https://store.mulika.in/product/mipl-stockist-store-locator-pro/'
    ),
    'bing_map' => array(
        'name' => 'MIPL Stockist/Stores Locator - Bing Map',
        'logo' => 'store-locator-logo-bing-map.png',
        'heading' => 'MIPL Stockist/Store Locator - Bing Map (Addon)',
        'description' => __('Integrate the Bing Map in you site using "MIPL Stockist/Store Locator" with Multiple Map Type, Autocomplete address.'),
        'product_link' => 'https://store.mulika.in/product/mipl-stockist-store-locator-bing-map/'
    ),
    'here_map' => array(
        'name' => 'MIPL Stockist/Stores Locator - HERE Map',
        'logo' => 'store-locator-logo-here-map.png',
        'heading' => 'MIPL Stockist/Store Locator - HERE Map (Addon)',
        'description' => __('Intergrate the HERE Map in you site using "MIPL Stockist/Store Locator" with Multiple map type and Autocomplete address.'),
        'product_link' => 'https://store.mulika.in/product/mipl-stockist-store-locator-here-map/'
    ),
    'import_export' => array(
        'name' => 'MIPL Stockist Store Locator - Import/Export',
        'logo' => 'store-locator-import-export.png',
        'heading' => 'MIPL Stockist/Store Locator - Import/Export (Addon)',
        'description' => __('Import/Export the multiple Stores using CSV/Json file in "MIPL Stockist Store Locator".'),
        'product_link' => 'https://store.mulika.in/product/mipl-stockist-store-locator-import-export/'
    ),
    'openstreetmap' => array(
        'name' => 'MIPL Stockist/Stores Locator - OpenStreetMap',
        'logo' => 'store-locator-logo-openstreetmap.png',
        'heading' => 'MIPL Stockist/Store Locator - OpenStreetMap (Addon)',
        'description' => __('Integrate the OpenStreetMap in you site using "MIPL Stockist/Store Locator" with Multiple Tiles, and Geocoding search address bar.'),
        'product_link' => 'https://store.mulika.in/product/mipl-stockist-store-locator-openstreetmap/'
    ),
);


$installed_plugins = array();
$activated_plugins = array();

$all_plugins = get_plugins();
$active_plugins = get_option('active_plugins');

foreach($all_plugins as $plugin){
    array_push($installed_plugins, $plugin['Name']);
}

foreach ($active_plugins as $plugin){           
    if(isset($all_plugins[$plugin])){
        array_push($activated_plugins, $all_plugins[$plugin]);
    }
}

$all_active_plugins = array_column($activated_plugins, 'Name');
?>

<div class="wrap">
<h1 class="wp-heading-inline"><?php echo esc_html__('MIPL Stockist Store Locator - Addons');?></h1>
<div>
    <?php
    foreach ($mipl_sl_addons as $addon => $addon_data) {
        
        $install_status = $active_status = false;

        if( in_array($addon_data['name'], $installed_plugins) ){
            $install_status = true;
        }
        
        if( in_array($addon_data['name'], $all_active_plugins) ){
            $active_status = true;
        }
        
        $button_text = "Get This Add-On";
        $style = $disable_button = '';
        if($install_status == true && $active_status != true){
            $button_text = 'Installed';
            $disable_button = "disabled";
            // $style = "pointer-events: none;";
        }

        if($install_status == true && $active_status == true){
            $button_text = 'Activated';
            $disable_button = "disabled";
            // $style = "pointer-events: none;";
        }
        ?>
        <div class="mipl_sl_stockist_addons_wrapper" >
            <div class="mipl_sl_addons" style="padding: 10px 20px 10px;" >
                <img src="<?php echo esc_url(MIPL_SL_URL.'assets/images/'.$addon_data['logo']); ?>" style="width:110px">
                <h4 style="margin:0; margin-top:10px; margin-bottom:5px;"><?php echo esc_html($addon_data['heading']); ?></h4>
                <p style="margin:0;"><?php echo esc_html($addon_data['description']); ?></p>        
            </div>
            <div class="mipl_sl_addon_status"  style="padding: 10px 20px;" >
                <a class="button-primary" href="<?php echo esc_url($addon_data['product_link']); ?>" target="_blank" <?php echo esc_attr($disable_button); ?> ><?php echo esc_html__($button_text);?></a>
            </div>
        </div>
        <?php
        
    }
    ?>
</div>
</div>