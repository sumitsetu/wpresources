<?php

/**
 * class for fetching posts title
*/
class Wpresources_input_post_data{

    public function __construct() {
        add_action("wp_ajax_wpresource_action_for_blogs", array($this, "wpresource_action_for_blogs"));
        add_action("wp_ajax_wpresource_action_for_ebooks", array($this, "wpresource_action_for_ebooks"));
        add_action("wp_ajax_wpresource_action_for_casestudies", array($this, "wpresource_action_for_casestudies"));
    }
    public function wpresource_action_for_blogs(){
       // echo json_encode($_POST);
        global $wpdb;
        $custom_post_type = 'post';

        // A sql query to return all post titles
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT ID, post_title FROM {$wpdb->posts} WHERE post_type = %s and post_status = 'publish'", $custom_post_type ), ARRAY_A );

        // Return null if we found no results
        if ( ! $results )
            return;
        $output = '<div class="wpresource-input-data"><select name="wpresource-blogs[]" id="wpresource-select-blogs" class="wpresource_input_count regular-text">';
        $output .= '<option value="-1">Select Your Post</option>';
        foreach( $results as $index => $post ) {
            $output .= '<option value="' . $post['ID'] . '">' . $post['post_title'] . '</option>';
        }

        $output .= '</select><span></span></div>'; // end of select element

        // get the html
        echo $output;
        wp_die();
    }
    public function wpresource_action_for_ebooks(){
        // echo json_encode($_POST);
         global $wpdb;
         $custom_post_type = 'post';
 
         // A sql query to return all post titles
         $results = $wpdb->get_results( $wpdb->prepare( "SELECT ID, post_title FROM {$wpdb->posts} WHERE post_type = %s and post_status = 'publish'", $custom_post_type ), ARRAY_A );
 
         // Return null if we found no results
         if ( ! $results )
             return;
         $output = '<div class="wpresource-input-data"><select name="wpresource-ebooks[]" id="wpresource-select-blogs" class="wpresource_input_count regular-text">';
         $output .= '<option value="-1">Select Your Post</option>';
         foreach( $results as $index => $post ) {
             $output .= '<option value="' . $post['ID'] . '">' . $post['post_title'] . '</option>';
         }
 
         $output .= '</select><span></span></div>'; // end of select element
 
         // get the html
         echo $output;
         wp_die();
     }
     public function wpresource_action_for_casestudies(){
        // echo json_encode($_POST);
         global $wpdb;
         $custom_post_type = 'post';
 
         // A sql query to return all post titles
         $results = $wpdb->get_results( $wpdb->prepare( "SELECT ID, post_title FROM {$wpdb->posts} WHERE post_type = %s and post_status = 'publish'", $custom_post_type ), ARRAY_A );
 
         // Return null if we found no results
         if ( ! $results )
             return;
         $output = '<div class="wpresource-input-data"><select name="wpresource-casestudies[]" id="wpresource-select-blogs" class="wpresource_input_count regular-text">';
         $output .= '<option value="-1">Select Your Post</option>';
         foreach( $results as $index => $post ) {
             $output .= '<option value="' . $post['ID'] . '">' . $post['post_title'] . '</option>';
         }
 
         $output .= '</select><span></span></div>'; // end of select element
 
         // get the html
         echo $output;
         wp_die();
    }
}