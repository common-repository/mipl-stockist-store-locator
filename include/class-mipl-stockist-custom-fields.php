<?php

class MIPL_SL_Stockist_Custom_Fields{

    // Save Custom Fields
    function save_custom_field_group(){
        
        $custom_fields = "";
        $store_custom_fields = "";

        if (isset($_POST['_mipl_sl_stockist_custom_fields'])) {
            $custom_fields = $_POST['_mipl_sl_stockist_custom_fields'];
            $store_custom_fields = $this->mipl_sl_get_custom_field_validate_data($custom_fields);
            update_option('_mipl_sl_stockist_custom_fields', $store_custom_fields);
        }else{
            update_option('_mipl_sl_stockist_custom_fields', $store_custom_fields);
        }
        
    }


    // 
    function save_custom_fields(){

        global $post;
        $post_data = (array)$post;

        $custom_field_val = mipl_sl_get_store_custom_fields($post_data);
        
        $val_obj = new MIPL_SL_Input_Validation($custom_field_val);
        $val_obj->validate();
        $errors = $val_obj->get_errors();
        $post_data = $val_obj->get_valid_data();
        
        foreach($post_data as $key => $value){
            update_post_meta($post->ID, '_mipl_sl_'.$key, $value);
        }

        if( !empty($errors) ){
            $_SESSION['mipl_sl_admin_notices']['error'] = implode('<br />',$errors);
        }

    }



    function mipl_sl_add_field_before_meta_fields(){
        
        $custom_fields =  get_option('_mipl_sl_stockist_custom_fields');
        if(!empty($custom_fields)){
            foreach($custom_fields['label'] as $key => $value){ 
                if(get_post_meta(get_the_id(), '_mipl_sl_'.$custom_fields['name'][$key], true) != ""){
                ?>
                <tr>
                    <td><?php echo esc_html__($value);?></td>
                    <td><?php echo wp_kses_post(get_post_meta(get_the_id(), '_mipl_sl_'.$custom_fields['name'][$key], true));?></td>
                </tr>
                <?php 
                }
            }
        }

    }



    function mipl_sl_get_custom_field_validate_data($custom_fields){

        $validation_array = array();
        $validation_data = array();
        $store_array = array();
        
        $sub_field_keys = array('label','name','type','default_value','options', 'txt_default_value', 'required');
        
        if(empty($custom_fields)){
            return $store_array;
        }

        foreach($custom_fields['name'] as $field_index => $field_name){
            
            $temp_field_label = 'label_'.$field_index;
            $validation_array[$temp_field_label]  =  array(
                'label' => "Field Label",
                'type' => 'text',
                'validation' => array( 
                    'requried'=>__('Field Label should not blank!'),                    
                    'limit'=>'200',
                    'limit_msg'=>__('Field Label should be less than 200 Characters!')
                ),
                'sanitize' => array('sanitize_text_field')
            );

            $temp_field_name = 'name_'.$field_index;
            $validation_array[$temp_field_name]  =  array(
                'label' => "Field Name",
                'type' => 'text',
                'validation' => array(
                    'requried'=>__('Field Name should not blank!'), 
                    'regex'=>'/^([a-z]|[A-Z]|[0-9]|_|-)+$/',
                    'regex_msg'=>__('Field Name should be valid!'), 
                    'limit'=>'100',
                    'limit_msg'=>__('Field Name should be less than 100 Characters!')
                ),
                'sanitize' => array('sanitize_text_field')
            );

            $temp_field_type = 'type_'.$field_index;
            $validation_array[$temp_field_type]  =  array(
                'label' =>"Field Type",
                'type' => 'select',
                'values' => array('', 'text', 'textarea', 'select'),
                'validation' => array(
                    'in_values'=>__('Field Type should be valid!')
                ),
                'sanitize' => array('sanitize_text_field')
            );

            $temp_field_dvalue = 'dvalue_'.$field_index;
            $validation_array[$temp_field_dvalue]  =  array(
                'label' => "Default Value",
                'type' => 'text',
                'validation' => array( 
                    'limit'=>'200',
                    'limit_msg'=>__('Field Default Value should be less than 200 Characters!')
                ),
                'sanitize' => array('sanitize_text_field')
            );

            $temp_field_options = 'options_'.$field_index;
            $validation_array[$temp_field_options]  =  array(
                'label' => "Select Options",
                'type' => 'textarea',
                'depend' => array(
                    'field' => $temp_field_type,
                    'value' => 'select'
                ),
                'validation' => array(
                    'requried'=>__("Select Field Options should not blank!"), 
                    'limit'=>'1000',
                    'limit_msg'=>__('Field Select Options should be less than 1000 Characters!')
                ),
                'sanitize' => array('sanitize_textarea_field')
            );
            $temp_txt_default_value = 'txt_default_value_'.$field_index;
            $validation_array[$temp_txt_default_value]  =  array(
                'label' => "Default Value",
                'type' => 'textarea',
                'depend' => array(
                    'field' => $temp_field_type,
                    'value' => 'textarea'
                ),
                'validation' => array(
                    'requried'=>__("Default Value should not blank!"), 
                    'limit'=>'1000',
                    'limit_msg'=>__('Default Value should be less than 1000 Characters!')
                ),
                'sanitize' => array('sanitize_textarea_field')
            );
            
            $temp_field_required = 'required_'.$field_index;
            $validation_array[$temp_field_required] = array(
                'label' => "Field Name",
                'type' => 'text',
                // 'validation' => array('regex'=>'/^([a-z]|[A-Z]|_|-)+$/','regex_msg'=>'Field Name should be valid!'),
                'sanitize' => array('sanitize_text_field')
            );

            $custom_fields['name'][$field_index] = isset($custom_fields['name'][$field_index]) ? trim(preg_replace("/[^A-Za-z0-9_-]/", '', $custom_fields['name'][$field_index]), '_') :'';

            if($custom_fields['name'][$field_index] == ""){

                $fieldNames = []; 
                $currentIndex = $field_index + 1;
                $filteredFieldNames = preg_grep('/^mipl_sl_field_/', $custom_fields['name']);

                $numericParts = array_map(function($value) {
                    return intval(substr($value, strrpos($value, '_') + 1));
                }, $filteredFieldNames);
                
                if(!empty($numericParts)){
                    $lastIndex = max($numericParts);
                }
                
                if ( !empty($filteredFieldNames) && $lastIndex >= $currentIndex) {
                    $currentIndex = $lastIndex + 1;
                }
                
                $custom_fields['name'][$field_index] = "mipl_sl_field_".$currentIndex;
            }
            
            $validation_data[$temp_field_label] = stripslashes(isset($custom_fields['label'][$field_index]) ? $custom_fields['label'][$field_index] : '');
            $validation_data[$temp_field_name] = isset($custom_fields['name'][$field_index]) ? trim(preg_replace("/[^A-Za-z0-9_-]/", '', $custom_fields['name'][$field_index]), '_') :'';
            $validation_data[$temp_field_type] = isset($custom_fields['type'][$field_index]) ? $custom_fields['type'][$field_index] : '';
            $validation_data[$temp_field_dvalue] = stripslashes(isset($custom_fields['default_value'][$field_index]) ? $custom_fields['default_value'][$field_index] : '');
            $validation_data[$temp_field_options] = stripslashes(isset($custom_fields['options'][$field_index]) ? $custom_fields['options'][$field_index] : '');

            $validation_data[$temp_txt_default_value] = stripslashes(isset($custom_fields['txt_default_value'][$field_index]) ? $custom_fields['txt_default_value'][$field_index] : '');

            $validation_data[$temp_field_required] = isset($custom_fields['required'][$field_index]) ? $custom_fields['required'][$field_index] : '';

            foreach($sub_field_keys as $sub_field_key){
                if( $sub_field_key == 'options' || $sub_field_key == "txt_default_value"){
                    $store_array[$sub_field_key][$field_index] =  stripslashes(sanitize_textarea_field($custom_fields[$sub_field_key][$field_index]));
                }elseif($sub_field_key == 'name'){
                    $store_array[$sub_field_key][$field_index] =  sanitize_text_field(isset($custom_fields[$sub_field_key][$field_index]) ? trim(preg_replace("/[^A-Za-z0-9_-]/", '', $custom_fields[$sub_field_key][$field_index]), "_") : '');
                }else{
                    $store_array[$sub_field_key][$field_index] =  stripslashes(sanitize_text_field(isset($custom_fields[$sub_field_key][$field_index]) ? $custom_fields[$sub_field_key][$field_index] : ''));
                }
            }
            
        }
        
        $counts = array_count_values(array_map('strtolower', $store_array['name']));
        // $counts = array_count_values($store_array['name']);
        $filtered = array_filter($store_array['name'], function ($value) use ($counts) {
            return $counts[strtolower($value)] > 1;
        });
        
        $array_first_key = array_key_first($filtered);

        if($array_first_key !== null){
            unset($filtered[$array_first_key]);
            foreach($filtered as  $filter_key => $filter_val){
                $duplicate_names['name_'.$filter_key] = __("Field name was duplicate");
            }
        }
    
        $val_obj = new MIPL_SL_Input_Validation($validation_array, $validation_data);
    
        $rs = $val_obj->validate();
        $errors = $val_obj->get_errors();
        $post_data = $val_obj->get_valid_data();
        
    
        foreach($store_array as $store_key => $store_fields){
            foreach($store_fields as $v_index => $value_arr){
                    
                if( isset($errors['label_'.$v_index]) ){
                    $store_array['errors']['label'][$v_index] = $errors['label_'.$v_index];
                }
                if( isset($errors['name_'.$v_index]) ){
                    $store_array['errors']['name'][$v_index] = $errors['name_'.$v_index];
                }elseif( !isset($errors['name_'.$v_index])  && isset($duplicate_names['name_'.$v_index])){
                    $store_array['errors']['name'][$v_index] = $duplicate_names['name_'.$v_index];
                }
                if( isset($errors['type_'.$v_index]) ){
                    $store_array['errors']['type'][$v_index] = $errors['type_'.$v_index];
                }
                if( isset($errors['dvalue_'.$v_index]) ){
                    $store_array['errors']['default_value'][$v_index] = $errors['dvalue_'.$v_index];
                }
                if( isset($errors['options_'.$v_index]) ){
                    $store_array['errors']['options'][$v_index] = $errors['options_'.$v_index];
                }
                if( isset($errors['txt_default_value_'.$v_index]) ){
                    $store_array['errors']['txt_default_value'][$v_index] = $errors['txt_default_value_'.$v_index];
                }
                
            }
        }
        
        return $store_array;
    
    }



    function get_custom_field_settings(){
        ob_start();
        ?>
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
                                <label><?php echo esc_html__('Field Name');?><span class="mipl_sl_required">*</span>:<input type="text" name="_mipl_sl_stockist_custom_fields[name][]" id="" value="<?php echo esc_html($custom_fields['name'][$key]);?>" class="mipl_post_type_input" style="<?php echo esc_attr($name_error_class);?>"><span class="mipl_sl_custom_field_error"><?php echo esc_html($name_error_massage); ?></span></label>
                                <label><?php echo esc_html__('Field Type');?><span class="mipl_sl_required">*</span>:<select name="_mipl_sl_stockist_custom_fields[type][]" class="mipl_post_type_input" style="<?php echo esc_html($type_error_class);?>"><?php  
                                $field_type = array( 'text' => 'Text', 'textarea' => 'Textarea', 'select' => 'Select' );
                                foreach($field_type as $name=>$title){ 
                                    $map_type_selected ="";
                                    if($custom_fields['type'][$key] == $name){
                                        $map_type_selected = 'selected="selected"';
                                    } ?>
                                <option value="<?php echo esc_html($name); ?>" <?php echo esc_attr($map_type_selected); ?>><?php echo esc_html__($title); ?></option><?php
                                } ?>
                                </select><span class="mipl_sl_custom_field_error"><?php echo esc_html($type_error_massage); ?></span></label>
                                
                                <label><?php echo esc_html__('Default Value');?>:<input type="text" name="_mipl_sl_stockist_custom_fields[default_value][]" id="" value="<?php echo esc_html($custom_fields['default_value'][$key]); ?>" class="mipl_post_type_input" style="<?php echo esc_attr($dvalue_error_class);?>"><span class="mipl_sl_custom_field_error"><?php echo esc_html($dvalue_error_massage); ?></span></label>

                                <label style="display:none"><?php echo esc_html__('Select Value');?>:<textarea name="_mipl_sl_stockist_custom_fields[options][]" class="mipl_post_type_input" style="<?php echo esc_attr($options_error_class);?>"><?php echo wp_kses_post($options_val);?></textarea> <span class="mipl_sl_custom_field_error"><?php echo esc_html($options_error_massage); ?></span> 
                                <strong><?php echo __('Note');?></strong>: <?php echo __('Enter each choice on a new line. For more control, you may specify both a value and label like');?> <strong><?php echo __('red : Red');?></strong>.
                                </label>

                                <label style="display:none"><?php echo esc_html__('Default Value');?>:<textarea name="_mipl_sl_stockist_custom_fields[txt_default_value][]" class="mipl_post_type_input" style="<?php echo esc_html($txt_default_class);?>"><?php echo wp_kses_post($custom_fields['txt_default_value'][$key]);?></textarea> <span class="mipl_sl_custom_field_error"><?php echo esc_html($txt_default_value_error_massage); ?></span></label>
                                
                                <?php
                                    $checked = "";
                                    if( isset($custom_fields['name'][$key]) && isset($custom_fields['required']) && in_array($custom_fields['name'][$key], $custom_fields['required'])){
                                        $checked = 'checked';
                                    } ?>

                                <label><input type="checkbox" name="_mipl_sl_stockist_custom_fields[required][]" id="" value="<?php echo stripslashes($custom_fields['name'][$key]) ?>" class="" <?php echo esc_attr($checked);?> > <?php echo esc_html__('Required field');?></label>

                                <a class="button"><?php echo esc_html__('Close Field');?></a>
                            </div>
                            </div>
                            <?php
                        // }
                    }
                } ?>
            
            </div>
            <a class="button add_new_field"><?php echo esc_html__('Add more')?></a>

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
                                <label><strong><?php echo esc_html__('Field Label');?><span class="mipl_sl_required">*</span>:</strong><input type="text" class="mipl_post_type_input field_label" name="_mipl_sl_stockist_custom_fields[label][]" value=""></label>
                                <label><strong><?php echo esc_html__('Field Name');?><span class="mipl_sl_required">*</span>:</strong><input type="text" class="mipl_post_type_input field_name" name="_mipl_sl_stockist_custom_fields[name][]" value=""></label>
                                <label><strong><?php echo esc_html__('Field Type');?><span class="mipl_sl_required">*</span>:</strong><select class="mipl_post_type_input" name="_mipl_sl_stockist_custom_fields[type][]"><?php $field_type = array( 'text' => 'Text', 'textarea' => 'Textarea', 'select' => 'Select'); $selected_map_type = get_option('_mipl_sl_google_field_type'); foreach($field_type as $name=>$title){ $map_type_selected =""; if($selected_map_type == $name){ $map_type_selected = 'selected="selected"';}?><option value="<?php echo esc_html($name); ?>" <?php echo esc_attr($map_type_selected); ?>><?php echo esc_html__($title); ?></option> <?php } ?> </select></label>
                                <label><strong><?php echo esc_html__('Default Value');?>:</strong><input type="text" class="mipl_post_type_input" id="default_value" name="_mipl_sl_stockist_custom_fields[default_value][]" value=""></label>
                                <label style="display:none"><?php echo esc_html__('Select Value');?>:<textarea name="_mipl_sl_stockist_custom_fields[options][]" class="mipl_post_type_input"></textarea><strong><?php echo __('Note');?></strong>:<?php echo __('Enter each choice on a new line. For more control, you may specify both a value and label like');?> <strong><?php echo __('red:Red');?></strong>. </label>
                                <label style="display:none"><?php echo esc_html__('Default Value');?>:<textarea name="_mipl_sl_stockist_custom_fields[txt_default_value][]" class="mipl_post_type_input"></textarea></label>
                                <label><input type="checkbox" name="_mipl_sl_stockist_custom_fields[required][]" id="" value="" class=""><?php echo esc_html__('Required field');?></label>
                                
                                <a class="button"><?php echo esc_html__('Close Field');?></a>
                            </div>
                        </div>`;

                        jQuery('.mipl_sl_custom_field_table .mipl_sl_add_custom_field').slideUp();

                        jQuery('.mipl_sl_custom_field_table').append($append_data);
                    });

                });

            </script>

            </div>
            
    
        </div>
        <?php
        $response = ob_get_contents();
        ob_end_clean();
        echo json_encode($response);          
        die();

    }

}