<?php
/**
 * Created by PhpStorm.
 * User: Fakhir
 * Date: 2/23/2019
 * Time: 10:22 AM
 */
$realpath = realpath( "../../../../../../wp-load.php" );
if ( ! is_file( $realpath ) ) {
    echo "File '" . $realpath . "Not found.<br>Can't load WordPress Library.";
    exit;
}

include_once( $realpath );
if ( ! is_user_logged_in() ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit();
}
header( "Cache-Control: no-store, no-cache, must-revalidate, max-age=0" );
header( "Cache-Control: post-check=0, pre-check=0", false );
header( "Pragma: no-cache" );
header( 'Content-Type: application/javascript' );

?>

(function() {
    tinymce.PluginManager.add('wcap_tc_button', function( editor, url ) {
        editor.addButton( 'wcap_tc_button', {
            title: 'WCAP ShortCodes',
            type: 'menubutton',
            icon: 'icon wcap-own-icon',
            menu: [
                <?php
                $shorcodes = [
                    "whmcs_client_area",
                    "wcap_logged_in_content",
                    "wcap_logged_out_content",
                    "wcap_whmcs_nav_menu",
                    "wcap_login_form",
                ];
                foreach ($shorcodes as $SHORTCODES):
                $shortcodeParams = get_shortcode_parameters($SHORTCODES);
                $params = [];
                foreach ($shortcodeParams as $key => $spm) {

                    if (is_array($spm)) {

                        if ($key == "vc_options") {
                            $vc_shortcode_title = $spm["title"];
                        }

                        if ($key == "params") {
                            $params = $spm;
                        }
                    }
                }
                ?>
                {
                    text: '<?php echo $vc_shortcode_title ?>',
                    value: '<?php echo $SHORTCODES ?>',
                    onclick: function() {
                        editor.insertContent('[' + this.value() +']');
                    }
                },
                <?php endforeach; ?>
            ]
        });
    });
})();