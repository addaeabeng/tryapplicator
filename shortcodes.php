<?php

class Tryangle_Shortcodes{

    function __construct()
    {
        add_shortcode('application_form', array($this, 'application_form'));
    }

    function application_form(){
        ob_start();
        $validate = new Validator();
        include "templates/form.php";
        $form = ob_get_contents();
        ob_end_clean();
        return $form;
    }



}