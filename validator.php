<?php

class Validator {

    public function errorBag($field, $msg){
        $_SESSION['errors'][$field] =  $msg;
    }

    public function validate($validation, $fields){
        foreach($validation as $field => $rules){
            $to_check = explode('|',$rules);
            foreach ($to_check as $t){
                $this->$t($field ,$fields['application'][$field]);
            }
        }

        if(!count($_SESSION['errors'])){
            return true;
        }

        return false;

    }

    public function force_unset(){
        unset($_SESSION['errors']);
    }

    public function required($field, $value){
        if (empty($value)){
            $this->errorBag($field,'This field is required');
            return false;
        }
        unset($_SESSION['errors'][$field]);
        return true;
    }

    public function valid_email($field, $value){
        if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
            $this->errorBag($field,'Please enter a valid email');
            return false;
        }
        unset($_SESSION['errors'][$field]);
        return true;
    }

    public function tel($field, $value){
        if(preg_match('/^(?=.*[0-9])[- +()0-9]+$/',$value)){
            $this->errorBag($field,'Please enter a valid phone number');
            return false;
        }
        unset($_SESSION['errors'][$field]);
        return true;
    }

    public function valid_url($field, $value){
        if(!empty($value) && !filter_var($value, FILTER_VALIDATE_URL)){
            $this->errorBag($field,'Please enter a valid url');
            return false;
        }
        unset($_SESSION['errors'][$field]);
        return true;
    }

    public function display_error($field){
        if(isset($_SESSION['errors'][$field])){
            return $_SESSION['errors'][$field];
        }
        return false;
    }




}