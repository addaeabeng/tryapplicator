<?php

class Tryangle_Types {

    function __construct()
    {
        add_action('init', array($this, 'init_types'));
        add_filter( 'manage_applicant_posts_columns', array($this,'applicant_create_columns'));
        add_action( 'manage_applicant_posts_custom_column', array($this,'applicant_display_columns'), 10, 2) ;
        add_action( 'add_meta_boxes', array($this, 'metaboxes'));
    }

    public function init_types(){
        $args = array(
            'label'                 => __( 'Applications'),
            'description'           => __( 'Applications of bloggers' ),
            'supports'              => array( 'content' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 6,
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );
        register_post_type( 'applicant', $args );
    }

    public function applicant_create_columns($columns){
        $columns = array();
        unset($columns['cb']);
        unset($columns['title']);
        unset($columns['cb']);
        $columns['cb'] = '<input type="checkbox" />';
        $columns['title'] = 'Name';
        $columns['location'] = 'Location';
        $columns['skill'] = 'Skill';
        $columns['date'] = 'Date';

        return $columns;
    }

    public function applicant_display_columns($columns){
        $post_id = get_the_ID();
        switch ($columns){
            case 'location':
                if(empty(get_post_meta($post_id, 'location', true))) echo __('Unknown');
                else
                    echo get_post_meta($post_id, 'location', true);
                break;
            case 'skill':
                if(empty(get_post_meta($post_id, 'skill', true))) echo __('Unknown');
                else
                    echo get_post_meta($post_id, 'skill', true);
                break;
            default:
                break;
        }
    }

    public function metaboxes(){
        $this->setup_application_metabox();
    }

    public function setup_application_metabox(){
        remove_meta_box('slugdiv', 'applicant', 'normal'); // Slug
        remove_meta_box('submitdiv', 'applicant', 'side'); // Publish box

        add_meta_box(
            'applicant-data',      // Unique ID
            __( 'Applicant Details', 'example' ),    // Title
            array($this,'render_applicant_details'),   // Callback function
            'applicant',         // Admin page (or post type)
            'advanced',         // Context
            'default'         // Priority
        );
    }

    public function render_applicant_details(){
        global $post;
        $meta = get_post_meta( $post->ID );
        ?>
        <div class="wrap">
            <table class="widefat">
                <thead>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach($meta as $key => $value){

                    ?>
                    <tr>
                        <th class="post-meta-key"><?php echo $key; ?>:</th>
                        <td><?php echo $value[0]; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
                <tr>
                    <td></td>
                </tr>
            </table>
        </div>
        <?php
    }
}