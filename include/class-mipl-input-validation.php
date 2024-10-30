<?php
/*
Class: MIPL Input Validation
Vserion: 1.0
*/

class MIPL_SL_Input_Validation{

    public $fields = array();
    public $errors = array();
    public $validated_data = array();
    public $post_data = array();

    function __construct($fields, $post_data = null) {
        if(!empty($fields)){
            $this->fields = $fields;
        }
        if( $post_data == null ){
            $this->post_data = $_POST;
        }else{
            $this->post_data = $post_data;
        }
    }


    function validate($fields=array(), $post_data = null){
        
        if(!empty($fields)){
            $this->fields = $fields;
        }

        if(!empty($this->post_data)){
            if( $post_data != null ){
                $this->post_data = $post_data;
            }
        }else{
            if( $post_data == null ){
                $this->post_data = $_POST;
            }
        }


        $error_message = array();
        $validated_data = array(); 

        foreach($this->fields as $field_key=>$field){

            if(isset($field['depend'])){
                $depend_field_key = $field['depend']['field'];
                if( !isset($this->post_data[$depend_field_key]) || 
                    $field['depend']['value'] != $this->post_data[$depend_field_key] ){
                    continue;
                }
            }
            
            // For Radio & Chcekbox
            if( !isset($this->post_data[$field_key]) ){
                if( isset($field['validation']['requried']) ){
                    $error_message[$field_key] = $field['validation']['requried'];
                }
                continue;
            }

            if(isset($this->post_data[$field_key]) && empty($this->post_data[$field_key]) && isset($field['validation']['requried'])){
                $error_message[$field_key] = $field['validation']['requried'];
                continue;
            }
            
            $field_value = '';
            if( isset($this->post_data[$field_key]) ){
                $field_value = $this->post_data[$field_key];
            }
            
            if( !empty($field['sanitize']) ){
                foreach($field['sanitize'] as $sanitize_func){
                    if (!function_exists($sanitize_func)){
                        continue;
                    }
                    $field_value = $sanitize_func($field_value);
                }                
            }

            if( !empty($field['ese']) ){
                foreach($field['ese'] as $ese_func){
                    if (!function_exists($ese_func)){
                        continue;
                    }
                    $field_value = $ese_func($field_value);
                }
            }

            if( !empty($field['validation']) ){
                foreach($field['validation'] as $validate=>$val_msg){

                    if( $validate == 'requried' && !empty($val_msg)){
                        if(trim($field_value) == ''){
                            $error_message[$field_key] = $val_msg;
                        }
                    }
                    
                    // Array used for custom validation
                    if( !is_array($field_value) && trim($field_value) == '' ){
                        continue;
                    }
                    
                    
                    if( $validate == 'in_values' && !empty($val_msg)){
                        if(!in_array($field_value,$field['values'])){
                            $error_message[$field_key] = $val_msg;
                        }
                    }

                    if( $validate == 'regex' && !empty($val_msg)){
                        if(!preg_match($val_msg, $field_value)){
                            $error_message[$field_key] = $field['validation']['regex_msg'];
                        }
                    }
                    
                    if($validate == 'custom_function' && !empty($val_msg)){
                        foreach($val_msg as $validation_func){
                            if (!function_exists($validation_func)){
                                continue;
                            }
                            $resp = $validation_func($field_value);
                            if($resp == false || $resp == 0){
                                $error_message[$field_key] = $field['validation']['custom_function_msg'];
                            }
                            if(is_array($resp) && in_array(0, $resp)){
                                $error_message[$field_key] = $field['validation']['custom_function_msg'];
                            }
                            if(is_array($resp) && isset($resp['social_media'])){
                                // $error_message[$field_key] = $resp['social_media'];
                                if(isset($resp['social_media']['error']) && !empty($resp['social_media']['error'])){
                                    $error_message[] = $resp['social_media']['error'];
                                }
                                $field_value = $resp['social_media']['value'];
                            }
                            if(is_array($resp) && isset($resp['labels'])){
                                if(isset($resp['labels']) && !empty($resp['labels']) ){
                                    $error_message[] = $resp['labels'];
                                }
                            }
                        } 
                    }

                    if($validate == 'wp_inbuilt_function' && !empty($val_msg)){
                        foreach($val_msg as $validation_func){
                            if (!function_exists($validation_func)){
                                continue;
                            }
                            $resp = $validation_func($field_value);
                            if($resp == false){
                                $error_message[$field_key] = $field['validation']['wp_inbuilt_function_msg'];
                            }
                        } 
                    }

                    if( $validate == 'limit' && !empty($val_msg)){
                        if(is_array($field_value)){
                            foreach($field_value as $label_key => $label_value){

                                if(is_array($label_value)){

                                    foreach($label_value as $lbl_key => $lbl_val){
                                        if(  strlen($lbl_val) > $field['validation']['limit']){
                                            $error_message[$field_key] = $field['validation']['limit_msg'];
                                        }        
                                    }

                                }else{
                                    
                                    if( strlen($label_value) > $field['validation']['limit']){
                                        $error_message[$field_key] = $field['validation']['limit_msg'];
                                    }
                                }

                            }
                        }else{
                            if(strlen($field_value) > $field['validation']['limit']){
                                $error_message[$field_key] = $field['validation']['limit_msg'];
                            }
                        }
                    }
                    
                }

                if( empty($error_message[$field_key]) ){
                    $validated_data[$field_key] = $field_value; 
                }

            }else{
                $validated_data[$field_key] = $field_value; 
            }
            
        }

        $this->validated_data = $validated_data; 
        $this->errors = $error_message;
        
    }
    


    function get_errors(){
        return $this->errors;
    }
    

    function get_valid_data(){
        return $this->validated_data;
    }



}