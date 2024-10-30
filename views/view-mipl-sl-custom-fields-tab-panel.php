<div id="mipl-store-fields" class="mipl_sl_tab_content"> 
    <div id="mipl-sl-post-type-tabs">
            <div id="" class="mipl_sl_post_type_tab" >
            <div class="mipl_sl_custom_field_table">
                <div class="mipl_sl_list_row">
                    <div class="mipl_sl_custom_field_row">
                        <div class="mipl_sl_post_type_column"><strong><?php echo esc_html__('Field Label');?></strong></div>
                        <div class="mipl_sl_post_type_column"><strong><?php echo esc_html__('Field Name');?></strong></div>
                        <div class="mipl_sl_post_type_column"><strong><?php echo esc_html__('Field Type');?></strong></div>
                        <div class="mipl_sl_post_type_column"><strong><?php echo esc_html__('Default Value');?></strong></div>
                        <div class="mipl_sl_post_type_column"><strong><?php echo esc_html__('Actions');?></strong></div>
                    </div>
                </div>

                <?php 
                $custom_fields =  get_option('_mipl_sl_stockist_custom_fields');
                
                if($custom_fields != ""){
                    foreach($custom_fields['name'] as $key => $val){
                        
                        $error_index = array();
                        $field_select_option = $label_error_massage = $name_error_massage = $type_error_massage = $dvalue_error_massage = $options_error_massage = $txt_default_value_error_massage = "";
                        if(isset($custom_fields['options'][$key])){
                            $field_select_option = $custom_fields['options'][$key];
                        }
                        
                        $label_error_class = $name_error_class = $type_error_class = $dvalue_error_class = $options_error_class = $txt_default_class = "";
                        if(isset($custom_fields['errors']['label'][$key])){
                            $error_index[] = $key;
                            $label_error_class = "border:1px solid red";
                            $label_error_massage = $custom_fields['errors']['label'][$key];
                        }

                        if(isset($custom_fields['errors']['name'][$key])){
                            $error_index[] = $key;
                            $name_error_class = "border:1px solid red";
                            $name_error_massage =  $custom_fields['errors']['name'][$key];
                        }

                        if(isset($custom_fields['errors']['type'][$key])){
                            $error_index[] = $key;
                            $type_error_class = "border:1px solid red";
                            $type_error_massage = $custom_fields['errors']['type'][$key];
                        }

                        if(isset($custom_fields['errors']['default_value'][$key])){
                            $error_index[] = $key;
                            $dvalue_error_class = "border:1px solid red";
                            $dvalue_error_massage = $custom_fields['errors']['default_value'][$key];
                        }

                        if(isset($custom_fields['errors']['options'][$key])){
                            $error_index[] = $key;
                            $options_error_class = "border:1px solid red";
                            $options_error_massage = $custom_fields['errors']['options'][$key];
                        }

                        if(isset($custom_fields['errors']['txt_default_value'][$key])){
                            $error_index[] = $key;
                            $txt_default_class = "border:1px solid red";
                            $txt_default_value_error_massage = $custom_fields['errors']['txt_default_value'][$key];
                        }
                        

                        $field_values = preg_split("/[\n]+/", trim($field_select_option));
                        $explode_array = array();
                        foreach($field_values as $option_key => $option_value){
                            if(strpos($option_value,":")){
                                $tmp = explode(':',trim($option_value));
                                if(!empty($tmp[0] && !empty($tmp[1]))){
                                    $explode_array[strtolower(trim($tmp[0]))] = strtolower(trim($tmp[0])) .' : '. ucfirst(trim($tmp[1]));
                                }
                            }else{
                                $tmp = explode('/n',trim($option_value));
                                if(!empty($tmp[0])){
                                    $explode_array[strtolower(trim($tmp[0]))] = strtolower(trim($tmp[0])) .' : '. ucfirst(trim($tmp[0]));
                                }
                            }
                        }
                        $options_val = implode(PHP_EOL, $explode_array);

                        // if($custom_fields['label'][$key] != "" ){ 
                            $error_style = "";
                            if(in_array($key, $error_index)){
                                $error_style = "border-left:3px solid red";
                            }
                            ?>
                        
                            <div class="mipl_sl_list_row" style="<?php echo esc_attr($error_style);?>">
                            <div class="mipl_sl_custom_field_row">
                                <div class="mipl_sl_post_type_column">
                                    <a href="#" class="mipl_post_type_edit_field" disable><?php echo esc_html($custom_fields['label'][$key]);?></a>
                                </div>
                                <div class="mipl_sl_post_type_column">
                                    <span class="mipl_sl_custom_field_span"><?php echo esc_html($custom_fields['name'][$key]);?></span>
                                </div>
                                <div class="mipl_sl_post_type_column">
                                    <span class="mipl_sl_custom_field_span"><?php echo esc_html($custom_fields['type'][$key]);?></span>
                                </div>
                                <div class="mipl_sl_post_type_column">
                                    <span class="mipl_sl_custom_field_span"><?php echo esc_html($custom_fields['default_value'][$key]);?></span>
                                </div>
                                <div class="mipl_sl_post_type_column">
                                    <a href="#" class="mipl_post_type_edit_field"><?php echo esc_html__('Edit');?></a>
                                </div>
                                <div class="mipl_sl_post_type_column">
                                    <a href="#" class="mipl_custom_field_delete_field"><?php echo esc_html__('Delete');?></a>
                                </div>
                            </div>
                            <div class="mipl_sl_add_custom_field" style="display:none">

                                <label><?php echo esc_html__('Field Label');?><span class="mipl_sl_required">*</span>:<input type="text" name="_mipl_sl_stockist_custom_fields[label][]" id="" value="<?php echo esc_html($custom_fields['label'][$key]) ?>" class= "mipl_post_type_input" style="<?php echo esc_attr($label_error_class);?>"><span class="mipl_sl_custom_field_error"><?php echo esc_html($label_error_massage); ?></span></label>

                                <label><?php echo esc_html__('Field Name');?><span class="mipl_sl_required">*</span>:<input type="text" name="_mipl_sl_stockist_custom_fields[name][]" id="" value="<?php echo esc_html($custom_fields['name'][$key]) ?>" class="mipl_post_type_input" style="<?php echo esc_attr($name_error_class);?>"><span class="mipl_sl_custom_field_error"><?php echo esc_html($name_error_massage); ?></span></label>

                                <label><?php echo esc_html__('Field Type');?><span class="mipl_sl_required">*</span>:<select name="_mipl_sl_stockist_custom_fields[type][]" class="mipl_post_type_input" style="<?php echo esc_attr($type_error_class);?>"><?php  
                                $field_type = array( 'text' => 'Text', 'textarea' => 'Textarea', 'select' => 'Select' );
                                foreach($field_type as $name=>$title){ 
                                    $map_type_selected ="";
                                    if($custom_fields['type'][$key] == $name){
                                        $map_type_selected = 'selected="selected"';
                                    } ?>
                                <option value="<?php echo esc_html($name); ?>" <?php echo esc_attr($map_type_selected); ?>><?php echo esc_html__($title); ?></option><?php
                                } ?>
                                </select><span class="mipl_sl_custom_field_error"><?php echo esc_html($type_error_massage); ?></span></label>
                                
                                <label><?php echo esc_html__('Default Value');?>:<input type="text" name="_mipl_sl_stockist_custom_fields[default_value][]" id="" value="<?php echo esc_html($custom_fields['default_value'][$key]) ?>" class="mipl_post_type_input" style="<?php echo esc_attr($dvalue_error_class);?>"><span class="mipl_sl_custom_field_error"><?php echo esc_html($dvalue_error_massage); ?></span></label>

                                <label style="display:none"><?php echo esc_html__('Select Value');?>:<textarea name="_mipl_sl_stockist_custom_fields[options][]" class="mipl_post_type_input" style="<?php echo esc_html($options_error_class);?>"><?php echo wp_kses_post($options_val);?></textarea> <span class="mipl_sl_custom_field_error"><?php echo esc_html($options_error_massage); ?></span> <strong><?php echo __('Note');?></strong>: <?php echo __('Enter each choice on a new line. For more control, you may specify both a value and label like');?> <strong><?php echo __('red : Red');?></strong>.
                                </label>

                                <label style="display:none"><?php echo esc_html__('Default Value');?>:<textarea name="_mipl_sl_stockist_custom_fields[txt_default_value][]" class="mipl_post_type_input" style="<?php echo esc_html($txt_default_class);?>"><?php echo wp_kses_post($custom_fields['txt_default_value'][$key]);?></textarea> <span class="mipl_sl_custom_field_error"><?php echo esc_html($txt_default_value_error_massage); ?></span></label>
                                
                                <?php
                                $checked = "";
                                if( isset($custom_fields['name'][$key]) && isset($custom_fields['required']) && in_array(stripslashes($custom_fields['name'][$key]), $custom_fields['required'])){
                                    $checked = 'checked';
                                }
                                ?>

                                <label><input type="checkbox" name="_mipl_sl_stockist_custom_fields[required][]" id="" value="<?php echo esc_html(stripslashes($custom_fields['name'][$key])) ?>" class="" <?php echo esc_attr($checked);?> ><?php echo esc_html__('Required field');?></label>

                                <a class="button"><?php echo esc_html__('Close Field');?></a>
                            </div>
                            </div>
                            <?php
                        // }
                    }
                } ?>
            
            </div>
            <a class="button add_new_field"><?php echo esc_html__('Add more');?></a>

            <script>
                jQuery(document).ready(function(){

                    jQuery('.add_new_field').click(function(){ 
                        var $append_data = `<div class="mipl_sl_list_row">
                            <div class="mipl_sl_custom_field_row">
                                <div class="mipl_sl_post_type_column"><a href="#" class="mipl_post_type_edit_field" disable><?php echo esc_html__('(Field Label)');?></a></div>
                                <div class="mipl_sl_post_type_column"><span class="mipl_sl_custom_field_span"><?php echo esc_html__('(Field Name)');?></span></div>
                                <div class="mipl_sl_post_type_column"><span class="mipl_sl_custom_field_span"><?php echo esc_html__('(Field Type)');?></span></div>
                                <div class="mipl_sl_post_type_column"><span class="mipl_sl_custom_field_span"><?php echo esc_html__('(Default value)');?></span></div>
                                <div class="mipl_sl_post_type_column"><a href="#" class="mipl_post_type_edit_field"><?php echo esc_html__('Edit');?></a></div>
                                <div class="mipl_sl_post_type_column"><a href="#" class="mipl_custom_field_delete_field"><?php echo esc_html__('Delete');?></a></div>
                            </div>
                            <div class="mipl_sl_add_custom_field">
                                <label><strong><?php echo esc_html__('Field Label');?>:<span class="mipl_sl_required">*</span></strong><input type="text" class="mipl_post_type_input field_label" name="_mipl_sl_stockist_custom_fields[label][]" value=""></label>
                                <label><strong><?php echo esc_html__('Field Name');?>:<span class="mipl_sl_required">*</span></strong><input type="text" class="mipl_post_type_input field_name" name="_mipl_sl_stockist_custom_fields[name][]" value=""></label>
                                <label><strong><?php echo esc_html__('Field Type');?>:<span class="mipl_sl_required">*</span></strong><select class="mipl_post_type_input" name="_mipl_sl_stockist_custom_fields[type][]"><?php $field_type = array( 'text' => 'Text', 'textarea' => 'Textarea', 'select' => 'Select'); $selected_map_type = get_option('_mipl_sl_google_field_type'); foreach($field_type as $name=>$title){ $map_type_selected =""; if($selected_map_type == $name){ $map_type_selected = 'selected="selected"';}?><option value="<?php echo $name; ?>" <?php echo $map_type_selected; ?>><?php echo $title; ?></option> <?php } ?> </select></label>
                                <label><strong><?php echo esc_html__('Default Value');?>:</strong><input type="text" class="mipl_post_type_input" id="default_value" name="_mipl_sl_stockist_custom_fields[default_value][]" value=""></label>
                                <label style="display:none"><?php echo esc_html__('Select Value');?>:<textarea name="_mipl_sl_stockist_custom_fields[options][]" class="mipl_post_type_input"></textarea><strong><?php echo esc_html__('Note');?></strong>: <?php echo esc_html__('Enter each choice on a new line. For more control, you may specify both a value and label like');?> <strong><?php echo esc_html__('red:Red');?></strong>. </label>
                                <label style="display:none"><?php echo esc_html__('Default Value');?>:<textarea name="_mipl_sl_stockist_custom_fields[txt_default_value][]" class="mipl_post_type_input"></textarea></label>

                                <label><input type="checkbox" name="_mipl_sl_stockist_custom_fields[required][]" id="" value="" class=""> <?php echo esc_html__('Required field');?></label>

                                <a class="button"><?php echo esc_html__('Close Field');?></a>
                            </div>
                        </div>`;
                        jQuery('.mipl_sl_custom_field_table').append($append_data);
                    });

                });

                
                jQuery('body').on('focusout','input[name="_mipl_sl_stockist_custom_fields[label][]"]',function(){ 
                    
                    var $label = jQuery(this).val();
                    jQuery(this).parents('.mipl_sl_list_row').find('.mipl_sl_post_type_column:first-child .mipl_post_type_edit_field').text($label);
                    
                    $label = $label.split(' ').join('_');
                    $label = $label.toLowerCase();
                    $label = $label.replace(/[^\w\s]/g, '');
                    $label = $label.replace(/^_+|_+$/g, '');
                    
                    var $value = jQuery(this).parents('.mipl_sl_list_row').find('input[name="_mipl_sl_stockist_custom_fields[name][]"]').val();
                    $value = $value.trim();

                    if($value == ""){

                        currentIndex = mipl_sl_get_field_name(jQuery(this));

                        if($label == ""){
                            $label = "mipl_sl_field_"+currentIndex;
                        }

                        jQuery(this).parents('.mipl_sl_list_row').find('input[name="_mipl_sl_stockist_custom_fields[name][]"]').val($label);
                        jQuery(this).parents('.mipl_sl_list_row').find('input[name="_mipl_sl_stockist_custom_fields[required][]"]').val($label);

                    }
                    

                    var $value = jQuery(this).parents('.mipl_sl_list_row').find('input[name="_mipl_sl_stockist_custom_fields[name][]"]').val();

                    jQuery(this).parents('.mipl_sl_list_row').find('.mipl_sl_post_type_column:nth-child(2) .mipl_sl_custom_field_span').text($value);

                    jQuery(this).parents('.mipl_sl_list_row').find('input[name="_mipl_sl_stockist_custom_fields[required][]"]').val($value);

                });

                jQuery('body').on('focusout','input[name="_mipl_sl_stockist_custom_fields[name][]"]',function(){ 
                    var $name = jQuery(this).val();
                    $name = jQuery.trim($name.replace(/[^A-Za-z0-9_-]/g, ''));
                    
                    if($name == ""){

                        currentIndex = mipl_sl_get_field_name(jQuery(this));

                        $name = "mipl_sl_field_"+currentIndex;

                    }



                    var $parent = jQuery(this).parents('.mipl_sl_list_row').find('.mipl_sl_post_type_column:nth-child(2) .mipl_sl_custom_field_span').text($name);
                    jQuery(this).parents('.mipl_sl_list_row').find('input[name="_mipl_sl_stockist_custom_fields[required][]"]').val($name);
                    jQuery(this).val($name);
                });





                function mipl_sl_get_field_name($this){

                    var fieldNames = [];
                    jQuery('input[name="_mipl_sl_stockist_custom_fields[name][]"]').each(function(index, element) {
                        var $label = jQuery(element).val();
                        fieldNames.push($label);
                    });

                    var filteredFieldNames = fieldNames.filter(function(value) {
                        return value.startsWith('mipl_sl_field_');
                    });

                    var numericParts = jQuery.map(filteredFieldNames, function(value) {
                        return parseInt(value.substr(value.lastIndexOf('_') + 1));
                    });

                    var last_index = Math.max.apply(null, numericParts);
                    var last_matched_index = jQuery.inArray('mipl_sl_field_'+last_index, fieldNames);
                    var closestTable = $this.closest('.mipl_sl_custom_field_table');
                    var listRowElements = closestTable.find('.mipl_sl_add_custom_field');
                    var clicked_Index = listRowElements.index($this.closest('.mipl_sl_add_custom_field'));
                    var currentIndex = listRowElements.index($this.closest('.mipl_sl_add_custom_field'));

                    if(currentIndex == 0){
                        currentIndex = 1;
                    }

                    if (last_index >= currentIndex) {
                        currentIndex = last_index + 1;
                    }

                    if(currentIndex < clicked_Index +1){
                        currentIndex = clicked_Index +1;
                    }
                    $second_last_value = $second_last_value = 0;

                    if(fieldNames[clicked_Index-1] != undefined){
                        $second_last_value = parseInt(fieldNames[clicked_Index-1].substr(fieldNames[clicked_Index-1].lastIndexOf('_') + 1));
                    }

                    if(clicked_Index > last_matched_index && $second_last_value == last_index ){
                        diff_index = clicked_Index - (last_matched_index + 1);                            
                        currentIndex = currentIndex + diff_index;
                    }

                    return currentIndex;

                }






                jQuery('body').on('change','select[name="_mipl_sl_stockist_custom_fields[type][]"]',function(){ 
                    var $label = jQuery(this).val();
                    jQuery(this).parents('.mipl_sl_list_row').find('.mipl_sl_post_type_column:nth-child(3) .mipl_sl_custom_field_span').text($label);

                    var $default_value = jQuery(this).closest('.mipl_sl_add_custom_field').find('input[name="_mipl_sl_stockist_custom_fields[default_value][]"]').closest('label');
                    var $select_option = jQuery(this).closest('.mipl_sl_add_custom_field').find('textarea[name="_mipl_sl_stockist_custom_fields[options][]').closest('label');
                    var $txt_default_value = jQuery(this).closest('.mipl_sl_add_custom_field').find('textarea[name="_mipl_sl_stockist_custom_fields[txt_default_value][]').closest('label');

                    $default_value.css('display','block');
                    $select_option.css('display','none');
                    $txt_default_value.css('display','none');

                    if($label == "select"){
                        $default_value.css('display','none');
                        $select_option.css('display','block');
                        $txt_default_value.css('display','none');
                    }

                    if($label == "textarea"){
                        $txt_default_value.css('display','block');
                        $default_value.css('display','none');
                        $select_option.css('display','none');
                    }

                });
                    
                jQuery('#mipl-store-fields').on('click','.mipl_post_type_edit_field', function(){ 
                    
                    var $label = jQuery(this).parents('.mipl_sl_list_row').find('select[name="_mipl_sl_stockist_custom_fields[type][]"]').val();

                    var $default_value = jQuery(this).closest('.mipl_sl_list_row').find('input[name="_mipl_sl_stockist_custom_fields[default_value][]"]').closest('label');
                    var $select_option = jQuery(this).closest('.mipl_sl_list_row').find('textarea[name="_mipl_sl_stockist_custom_fields[options][]').closest('label');
                    var $txt_default_value = jQuery(this).closest('.mipl_sl_list_row').find('textarea[name="_mipl_sl_stockist_custom_fields[txt_default_value][]').closest('label');

                    $default_value.css('display','block');
                    $select_option.css('display','none');
                    $txt_default_value.css('display','none');

                    if($label == "select"){
                        $default_value.css('display','none');
                        $select_option.css('display','block');
                        $txt_default_value.css('display','none');
                    }
                    
                    if($label == "textarea"){
                        $txt_default_value.css('display','block');
                        $default_value.css('display','none');
                        $select_option.css('display','none');
                    }
                });
                    
                jQuery('#mipl-store-fields').on('click','a.button',function(){
                jQuery(this).parents('.mipl_sl_list_row').find('.mipl_sl_add_custom_field').hide();
                return false;
                });

                jQuery('body').on('focusout','input[name="_mipl_sl_stockist_custom_fields[default_value][]"]',function(){ 
                    var $label = jQuery(this).val();
                    jQuery(this).parents('.mipl_sl_list_row').find('.mipl_sl_post_type_column:nth-child(4) .mipl_sl_custom_field_span').text($label);
                });

                jQuery('body').on('focusout','textarea[name="_mipl_sl_stockist_custom_fields[txt_default_value][]"]',function(){ 
                    var $label = jQuery(this).val();                    
                    jQuery(this).parents('.mipl_sl_list_row').find('.mipl_sl_post_type_column:nth-child(4) .mipl_sl_custom_field_span').text($label);
                });
            
            </script>

            </div>
    
    </div>
                
    <script>
        jQuery('#mipl-store-fields').on('click','.mipl_post_type_edit_field',function(e){
        
            jQuery('.mipl_sl_custom_field_table .mipl_sl_add_custom_field').not(jQuery(this).closest('.mipl_sl_list_row').find('.mipl_sl_add_custom_field')).slideUp();
            jQuery(this).closest('.mipl_sl_list_row').find('.mipl_sl_add_custom_field').slideToggle(500);
            return false;

        });

        jQuery('#mipl-store-fields').on('click','.mipl_custom_field_delete_field',function(){
            if (confirm('Are you sure you want to delete this item?') == true) {
                jQuery(this).parents('.mipl_sl_list_row').remove();
            }
        });
        

        jQuery(document).ready(function(){
            jQuery('form#mipl_sl_settings_form').submit(function(){

            setTimeout(function(){  
                jQuery.post('?mipl_action=get-custom-field', function($resp_data){
                
                $resp_data = JSON.parse($resp_data);
                jQuery('#mipl-store-fields').html('');
                jQuery('#mipl-store-fields').html($resp_data);
                // jQuery('#mipl-store-fields').load();
                }); 
            }, 1000);

            return false;

            });
        });


    </script>

</div>
