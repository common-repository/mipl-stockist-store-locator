<?php
global $post;
$opening_hour = get_post_meta($post->ID, '_mipl_sl_opening_hours', true);

if( !$opening_hour || !is_array($opening_hour)){
    $opening_hour = array(
        'monday'=>array("opening_hour"=>"","closing_hour"=>"","closed"=>"0"),
        'tuesday'=>array("opening_hour"=>"","closing_hour"=>"","closed"=>"0"),
        'wednesday'=>array("opening_hour"=>"","closing_hour"=>"","closed"=>"0"),
        'thursday'=>array("opening_hour"=>"","closing_hour"=>"","closed"=>"0"),
        'friday'=>array("opening_hour"=>"","closing_hour"=>"","closed"=>"0"),
        'saturday'=>array("opening_hour"=>"","closing_hour"=>"","closed"=>"0"),
        'sunday'=>array("opening_hour"=>"","closing_hour"=>"","closed"=>"0"),
    );
}

if(is_array($opening_hour)){
    extract($opening_hour); 
}

$opening_hour_note = get_post_meta($post->ID, '_mipl_sl_opening_hours_note', true);

$day = mipl_sl_get_label('days');
$opning_hours = mipl_sl_get_label('opening_hours');
$closing_hours = mipl_sl_get_label('closing_hours');
$closed = mipl_sl_get_label('closed');
$label_sunday = mipl_sl_get_label('sunday');
$label_monday = mipl_sl_get_label('monday');
$label_tuesday = mipl_sl_get_label('tuesday');
$label_wednesday = mipl_sl_get_label('wednesday');
$label_thursday = mipl_sl_get_label('thursday');
$label_friday = mipl_sl_get_label('friday');
$label_saturday = mipl_sl_get_label('saturday');
?>
<div style="overflow:auto;">
    <div class="mipl_sl_opening_hours_table">
        <table>
            <tr>
                <td class="mipl_sl_week_days"><strong><?php echo esc_html__($day); ?></strong></td>
                <td class="mipl_sl_store_opening_hours"><strong><?php echo esc_html__($opning_hours) ?></strong></td>
                <td class="mipl_sl_store_closing_hours"><strong><?php echo esc_html__($closing_hours) ?></strong></td>
                <td class="mipl_sl_store_closed"><strong><?php echo esc_html__($closed) ?></strong></td>
            </tr>
            <tr>
                <td class="mipl_sl_week_days"><strong><?php echo esc_html__($label_monday)?></strong></td>
                <td class="mipl_sl_store_opening_hours"><input type="text" name="_mipl_sl_opening_hours[monday][opening_hour]" id="" value="<?php echo esc_attr($monday['opening_hour'])?>"></td>
                <td class="mipl_sl_store_closing_hours"><input type="text" name="_mipl_sl_opening_hours[monday][closing_hour]" id="" value="<?php echo esc_attr($monday['closing_hour']) ?>"></td>
                <td class="mipl_sl_store_closed"><label><input type="checkbox" name="_mipl_sl_opening_hours[monday][closed]" value="1" <?php if($monday['closed'] == '1'){ echo esc_attr('checked="checked"'); } ?>><?php echo esc_html__('Close');?></label></td>
            </tr>
            <tr>
                <td class="mipl_sl_week_days"><strong><?php echo esc_html__($label_tuesday); ?></strong></td>
                <td class="mipl_sl_store_opening_hours"><input type="text" name="_mipl_sl_opening_hours[tuesday][opening_hour]" id="" value="<?php echo esc_attr($tuesday['opening_hour'])?>"></td>
                <td class="mipl_sl_store_closing_hours"><input type="text" name="_mipl_sl_opening_hours[tuesday][closing_hour]" id="" value="<?php echo esc_attr($tuesday['closing_hour'])?>"></td>
                <td class="mipl_sl_store_closed"><label><input type="checkbox" name="_mipl_sl_opening_hours[tuesday][closed]" value="1" <?php if($tuesday['closed'] == '1'){echo esc_attr('checked="checked"');} ?>><?php echo esc_html__('Close');?></label></td>
            </tr>
            <tr>
                <td class="mipl_sl_week_days"><strong><?php echo esc_html__($label_wednesday); ?></strong></td>
                <td class="mipl_sl_store_opening_hours"><input type="text" name="_mipl_sl_opening_hours[wednesday][opening_hour]" id="" value="<?php echo esc_attr($wednesday['opening_hour'])?>"></td>
                <td class="mipl_sl_store_closing_hours"><input type="text" name="_mipl_sl_opening_hours[wednesday][closing_hour]" id="" value="<?php echo esc_attr($wednesday['closing_hour'])?>"></td>
                <td class="mipl_sl_store_closed"><label><input type="checkbox" name="_mipl_sl_opening_hours[wednesday][closed]" value="1" <?php if($wednesday['closed'] == '1'){echo esc_attr('checked="checked"');} ?>><?php echo esc_html__('Close');?></label></td>
            </tr>
            <tr>
                <td class="mipl_sl_week_days"><strong><?php echo esc_html__($label_thursday); ?></strong></td>
                <td class="mipl_sl_store_opening_hours"><input type="text" name="_mipl_sl_opening_hours[thursday][opening_hour]" id="" value="<?php echo esc_attr($thursday['opening_hour'])?>"></td>
                <td class="mipl_sl_store_closing_hours"><input type="text" name="_mipl_sl_opening_hours[thursday][closing_hour]" id="" value="<?php echo esc_attr($thursday['closing_hour']) ?>"></td>
                <td class="mipl_sl_store_closed"><label><input type="checkbox" name="_mipl_sl_opening_hours[thursday][closed]" value="1" <?php if($thursday['closed'] == '1'){echo esc_attr('checked="checked"');} ?>><?php echo esc_html__('Close');?></label></td>
            </tr>
            <tr>
                <td class="mipl_sl_week_days"><strong><?php echo esc_html__($label_friday); ?></strong></td>
                <td class="mipl_sl_store_opening_hours"><input type="text" name="_mipl_sl_opening_hours[friday][opening_hour]" id="" value="<?php echo esc_attr($friday['opening_hour'])?>"></td>
                <td class="mipl_sl_store_closing_hours"><input type="text" name="_mipl_sl_opening_hours[friday][closing_hour]" id="" value="<?php echo esc_attr($friday['closing_hour']) ?>"></td>
                <td class="mipl_sl_store_closed"><label><input type="checkbox" name="_mipl_sl_opening_hours[friday][closed]" value="1" <?php if($friday['closed'] == '1'){ echo esc_attr('checked="checked"'); } ?>><?php echo esc_html__('Close');?></label></td>
            </tr>
            <tr>
                <td class="mipl_sl_week_days"><strong><?php echo esc_html__($label_saturday); ?></strong></td>
                <td class="mipl_sl_store_opening_hours"><input type="text" name="_mipl_sl_opening_hours[saturday][opening_hour]" id="" value="<?php echo esc_attr($saturday['opening_hour'])?>"></td>
                <td class="mipl_sl_store_closing_hours"><input type="text" name="_mipl_sl_opening_hours[saturday][closing_hour]" id="" value="<?php echo esc_attr($saturday['closing_hour']) ?>"></td>
                <td class="mipl_sl_store_closed"><label><input type="checkbox" name="_mipl_sl_opening_hours[saturday][closed]" value="1" <?php if($saturday['closed'] == '1'){ echo esc_attr('checked="checked"'); } ?>><?php echo esc_html__('Close');?></label></td>
            </tr>
            <tr>
                <td class="mipl_sl_week_days"><strong><?php echo esc_html__($label_sunday); ?></strong></td>
                <td class="mipl_sl_store_opening_hours"><input type="text" name="_mipl_sl_opening_hours[sunday][opening_hour]" id="" value="<?php echo esc_attr($sunday['opening_hour'])?>"></td>
                <td class="mipl_sl_store_closing_hours"><input type="text" name="_mipl_sl_opening_hours[sunday][closing_hour]" id="" value="<?php echo esc_attr($sunday['closing_hour'])?>"></td>
                <td class="mipl_sl_store_closed"><label><input type="checkbox" name="_mipl_sl_opening_hours[sunday][closed]" value="1" <?php if($sunday['closed'] == '1'){echo esc_attr('checked="checked"');} ?>><?php echo esc_html__('Close');?></label></td>

            </tr>            
            <!-- <tr>
                <td></td>
                <td colspan="2"><textarea class="mipl_sl_opning_hours_note" name="_mipl_sl_opening_hours_note" id=""  placeholder="Opening hours note..."><?php// echo esc_html($opening_hour_note); ?></textarea></td>
            </tr> -->
        </table>
        <div class="mipl_sl_store_opening_hour_note">
            <textarea class="mipl_sl_opning_hours_note" name="_mipl_sl_opening_hours_note" id=""  placeholder="Opening hours note..."><?php echo wp_kses_post($opening_hour_note); ?></textarea>
        </div>
    </div>
</div>