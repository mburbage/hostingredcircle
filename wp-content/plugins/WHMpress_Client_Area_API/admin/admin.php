<?php
/**
 * Created by PhpStorm.
 * User: Fakhir
 * Date: 2/23/2019
 * Time: 10:22 AM
 */

add_action( 'admin_head', 'wcap_add_my_tc_button' );
function wcap_add_my_tc_button() {
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
        add_filter( "mce_external_plugins", "wcap_add_tinymce_plugin" );
        add_filter( 'mce_buttons', 'wcap_register_my_tc_button' );
    }
}

function wcap_add_tinymce_plugin( $plugin_array ) {
    $plugin_array['wcap_tc_button'] = WCAP_ADMIN_URL . '/assets/js/shortcodes.js.php';

    return $plugin_array;
}


function wcap_register_my_tc_button( $buttons ) {
    array_push( $buttons, "wcap_tc_button" );

    return $buttons;
}