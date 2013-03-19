<?php
/*
  Plugin Name: BTM Email Meta
  Plugin URI: http://bluetent.com
  Description: This plugin adds a text field for email to add JavaScript to a page post type.
  Version: 1.0
  Author: travis@bluetent.com
 */

if( is_admin() ) {

    // Create new meta box
    add_action( 'add_meta_boxes', 'email_js_meta_box_add' );
    function email_js_meta_box_add()
    {
    add_meta_box( 'btm-email', 'Email JavaScript', 'email_js_meta_box', 'page', 'normal', 'high' );
    }

    // Render Meta box
    function email_js_meta_box( $post )
    {
        $values = get_post_custom( $post->ID );
        $text = isset( $values['email_meta_box_text'] ) ? $values['email_meta_box_text'] : '';  
        wp_nonce_field( 'email_meta_nonce', 'meta_box_nonce' );


    //Add text input 
        ?>
        <p>
        <label for="email_meta_box_text">Put email JS into this box</label>
        <input type="text" name="email_meta_box_text" id="email_meta_input" />
        </p>
        <?php
    }

    //Save email meta boxes
        add_action( 'save_post', 'email_meta_box_save' );
        function email_meta_box_save( $post_id )
        {

            //Bail if this is an autosave
            if(defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

            //Bail if nonce is missing or cannot verify
            if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'email_meta_nonce' ) ) return;

            //Bail if user can't edit this post
    //        if( !current_user_can( 'edit_post' ) ) return;

            //Now save the data

//            if( isset( $_POST['email_meta_box_text'] ) )
//                update_post_meta ( $post_id, 'email_meta_box_text', $_POST['email_meta_box_text'] );
            
            
            if( isset( $_POST['email_meta_box_text'] ) )  
                update_post_meta( $post_id, 'email_meta_box_text', esc_attr( $_POST['email_meta_box_text'] ) );
            
//              $custom_fields = get_post_custom( $post_id );
                //  $my_custom_field = $custom_fields['email_meta_box_text'];
                //  foreach ( $my_custom_field as $key => $value )
                //    echo $key . " => " . $value . "<br />";

        }
        

//    Add email js to footer
        function add_email_js_footer()
        {
            $meta_array = get_post_custom( $post_id );
            $email_js = $meta_array['email_meta_box_text'];
            
            return $email_js;
        }
        add_action('wp_footer', 'add_email_js_footer');
        
        
        
        
} //end if is_admin










?>