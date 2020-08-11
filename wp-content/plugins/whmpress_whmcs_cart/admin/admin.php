<?php
/**
 * Created by PhpStorm.
 * User: Fakhir
 * Date: 2/25/2019
 * Time: 12:11 PM
 */

add_action( 'admin_head', 'wcop_add_my_tc_button' );
function wcop_add_my_tc_button() {
    global $typenow;
    // check user permissions
    if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
        return;
    }
    // verify the post type
    if ( ! in_array( $typenow, [ 'post', 'page' ] ) ) {
        return;
    }
    // check if WYSIWYG is enabled
    if ( get_user_option( 'rich_editing' ) == 'true' ) {
        add_filter( "mce_external_plugins", "wcop_add_tinymce_plugin" );
        add_filter( 'mce_buttons', 'wcop_register_my_tc_button' );
    }
}

function wcop_add_tinymce_plugin( $plugin_array ) {
    $plugin_array['wcop_tc_button'] = WCOP_ADMIN_URL . '/js/shortcodes.js.php';

    return $plugin_array;
}


function wcop_register_my_tc_button( $buttons ) {
    array_push( $buttons, "wcop_tc_button" );

    return $buttons;
}