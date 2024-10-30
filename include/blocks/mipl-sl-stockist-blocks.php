<?php
/* 
Class: MIPL SL Blocks
---------------
*/

class MIPL_SL_Blocks {


    function mipl_sl_stockist_block() {
        wp_enqueue_script(
        'mipl-sl-stockist-store-block', MIPL_SL_URL.'include/blocks/mipl-sl-stockist-blocks.min.js', array( 'wp-blocks', 'wp-element', 'wp-editor' )
        );
        
    }

    // Create Custom Categories
    function mipl_sl_custom_block_category( $categories ) {
        $custom_block = array(
            'slug'  => 'mipl-sl-stockist-store-category',
            'title' => 'MIPL Stockist Store Locator',
        );

        $categories_sorted = array();
        $categories_sorted[0] = $custom_block;

        foreach ($categories as $category) {
            $categories_sorted[] = $category;
        }

        
    }


    


}