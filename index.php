<?php

/*
Plugin Name: Tryangle Applications
Plugin URI: http://tryangle.media
Description: A plugin to enable people to apply and work with us
Author: Addae Abeng
Version: 1.6
Author URI: http://tryangle.media
Registered types - applicant

*/

require "types.php";
require "shortcodes.php";
require "validator.php";

class Tryangle_Applications
{
    function __construct()
    {
        add_action('init', array($this, 'process_application'));
        add_action('init', array( $this, 'myStartSession'), 1);
    }

    function myStartSession() {
        if(!session_id()) {
            session_start();
        }
    }

    function myEndSession() {
        session_destroy ();
    }

    public function process_application(){
        global $post;

        if(isset($_POST['apsub']) && $_POST['apsub'] == 1){

            if(!wp_verify_nonce( $_REQUEST['_wpnonce'], 'add_application_'.$post->ID)){
                wp_nonce_ays();
            }

            if(!empty($_POST['xkhusa'])){
                wp_die('Ha Ha F U!');
            }

            $validate = new Validator();
            $rules = array(
                'name' => 'required',
                'email' => 'required|valid_email',
                'mobile' => 'required',
                'instagram' => 'valid_url',
                'twitter' => 'valid_url',
                'website' => 'valid_url'
            );
            $valid = $validate->validate($rules,$_POST);

            if ($valid) {
                $newApplication = array(
                    'name' => sanitize_text_field($_POST['application']['name']),
                    'email' => sanitize_email($_POST['application']['email']),
                    'mobile' => sanitize_text_field($_POST['application']['mobile']),
                    'instagram' => esc_url($_POST['application']['instagram']),
                    'twitter' => esc_url($_POST['application']['twitter']),
                    'website' => esc_url($_POST['application']['website']),
                    'location' => sanitize_text_field($_POST['application']['location']),
                    'skill' => sanitize_text_field($_POST['application']['skill']),
                    'about' => sanitize_text_field($_POST['application']['about']),
                    'grime' => sanitize_text_field($_POST['application']['grime']),
                    'ip' => sanitize_text_field($_POST['application']['ip'])
                );

                $post_arr = array(
                    'post_title' => sanitize_text_field('Application from '.$_POST['application']['name']),
                    'post_content' => 'mmm',
                    'post_status' => 'publish',
                    'post_type' => 'applicant',
                    'post_author' => get_current_user_id(),
                    'meta_input' => $newApplication
                );

                $insertPost = wp_insert_post($post_arr, true);

                if (is_wp_error($insertPost)) {
                    $errors = $insertPost->get_error_messages();
                    foreach ($errors as $error) {
                        echo $error;
                    }
                    die();
                } else {
                   wp_redirect(get_permalink(get_page_by_path('apply')));
                   exit;
                }
            }
        }
    }

    public function init_plugin(){
        $page_definitions = array(
            'application-successful' => array(
                'title' => __( 'Application Confirmed', 'dp-tickets' ),
                'content' => 'Your application was successful'
            ),
            'apply' => array(
                'title' => __( 'Ticket Details', 'dp-tickets' ),
                'content' => '[application_form]'
            )
        );

        foreach ( $page_definitions as $slug => $page ) {
            // Check that the page doesn't exist already
            $query = new WP_Query( 'pagename=' . $slug );
            if ( ! $query->have_posts() ) {
                // Add the page using the data from the array above
                wp_insert_post(
                    array(
                        'post_content'   => $page['content'],
                        'post_name'      => $slug,
                        'post_title'     => $page['title'],
                        'post_status'    => 'publish',
                        'post_type'      => 'page',
                        'ping_status'    => 'closed',
                        'comment_status' => 'closed',
                    )
                );
            }
        }

    }
}

new Tryangle_Types();
new Tryangle_Shortcodes();
new Tryangle_Applications();
register_activation_hook( __FILE__, array('Tryangle_Applications','init_plugin'));