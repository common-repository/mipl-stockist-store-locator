<?php
function get_layout($mipl_template){
    
    $layout1 = '<div class="mipl_sl_stockist_container"><div class="mipl_sl_stockist_store_filter">[mipl_sl_stockist_filter]</div><div class="mipl_sl_stockist_wrapper"><div id="mipl_sl_stockist_sidebar" class="mipl_sl_stockist_sidebar">[mipl_sl_stockist_store_list]</div><div class="mipl_sl_stockist_map">[mipl_sl_stockist_map]</div></div></div>';
    
    $layout2 = '<div class="mipl_sl_stockist_container "><div class="mipl_sl_stockist_wrapper"><div class="mipl_sl_stockist_sidebar"><div class="mipl_sl_stockist_store_filter">[mipl_sl_stockist_filter]</div>[mipl_sl_stockist_store_list]</div><div class="mipl_sl_stockist_map">[mipl_sl_stockist_map]</div></div></div>';
    
    $mipl_stockist = array();
    $mipl_stockist['template1'] = $layout1;
    $mipl_stockist['template2'] = $layout1;
    $mipl_stockist['template3'] = $layout2;
    $mipl_stockist['template4'] = $layout2;
    $mipl_stockist['template5'] = $layout1;
    $mipl_stockist['template6'] = $layout1;
    $mipl_stockist['template7'] = $layout1;
    $mipl_stockist['template8'] = $layout1;
    $mipl_stockist['template9'] = $layout1;
    $mipl_stockist['template10'] = $layout1;
    $mipl_stockist['template11'] = $layout1;
    $mipl_stockist['template12'] = $layout1;
    
    if( isset($mipl_stockist[$mipl_template]) ){
        return $mipl_stockist[$mipl_template];
    }
    
    return $mipl_stockist['template1'];
    
}