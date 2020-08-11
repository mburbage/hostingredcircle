<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


?>

<form method="post" action="options.php">
	<?php settings_fields( "wcop_templates" ); ?>
    <div class="whcom_row">
        <div class="whcom_col_sm_12">
            <div class="whcom_panel">
                <div class="whcom_panel_header whcom_panel_header_white">
                    <strong><?php echo esc_html_x( 'Single Page Settings', "admin", "whcom" ) ?></strong>
                </div>
                <div class="whcom_panel_body">

                    <div class="whcom_form_field whcom_form_field_horizontal">
                        <label for="wcop_sp_nav_offset"><?php echo esc_html_x( 'Sticky Navbar offset', "admin", "whcom" ) ?></label>
						<?php $field = 'wcop_sp_nav_offset'; ?>
                        <input id="wcop_sp_nav_offset" type="text" name="<?php echo "$field" ?>"
                               value="<?php echo esc_attr( get_option( $field ) ); ?>">
                    </div>

                    <div class="whcom_form_field whcom_form_field_horizontal">
                        <label for="wcop_sp_scroll_offset"><?php echo esc_html_x( 'Scrolling Sections offset', "admin", "whcom" ) ?></label>
						<?php $field = 'wcop_sp_scroll_offset'; ?>
                        <input id="wcop_sp_scroll_offset" type="text" name="<?php echo "$field" ?>"
                               value="<?php echo esc_attr( get_option( $field ) ); ?>">
                    </div>

                    <div class="whcom_form_controll whcom_text_center_xs">
                        <button type="submit"
                                class="button button-primary"><?php echo esc_html_x( 'Save Settings', "admin", "whcom" ) ?></button>
                    </div>


                </div>
            </div>
        </div>
    </div>
</form>






