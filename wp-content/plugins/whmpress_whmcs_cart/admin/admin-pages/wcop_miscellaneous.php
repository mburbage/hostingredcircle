<?php
/**
 * Created by PhpStorm.
 * User: zain
 * Date: 11/27/2019
 * Time: 12:22 PM
 */
defined('ABSPATH') or die('No script kiddies please!');
?>

<div class="wrap whcom_admin_page">
    <div class="wcop_admin_content">
        <form method="post" action="options.php">
            <?php settings_fields("wcop_misc"); ?>
            <div class="whcom_row">
                <div class="whcom_col_sm_12">
                    <div class="whcom_panel">
                        <div class="whcom_panel_header whcom_panel_header_white">
                            <strong><?php echo esc_html_x('Optimization Settings', "admin", "whcom") ?></strong>
                        </div>
                        <div class="whcom_panel_body">

                            <div class="whcom_form_field whcom_form_field_horizontal">

                                <label for="wcop_show_register_form"><?php echo esc_html_x('Preload registration form?', "admin", "whcom") ?></label>
                                <?php $field_register_form = 'wcop_show_register_form'; ?>
                                <?php $checked = (esc_attr(get_option($field_register_form)) == 'yes') ? ' checked' : ''; ?>
                                <input id="show_register_from" type="checkbox"
                                       name="<?php echo "$field_register_form" ?>"
                                       value="yes" <?php echo $checked; ?>>
                                <div class="whcom_checkbox_container whcom_alert whcom_alert_info">
                                    <?php echo esc_html_x( 'If checked, Client Registration form will be included in One-page checkout order form ',"admin", "whcom" ) ?>
                                </div>
                            </div>
                            <div class="whcom_form_field whcom_form_field_horizontal">
                                <div class="whcom_form_controll whcom_text_center_xs">
                                    <button type="submit"
                                            class="button button-primary"><?php echo esc_html_x('Save Settings', "admin", "whcom") ?></button>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>