<?php defined('ABSPATH') or die("Cannot access pages directly."); ?>

<div class="wcop_sp_section_heading">
    <i class="whcom_icon_www"></i>
    <span><?php esc_html_e("Choose a Domain", "whcom") ?></span>
</div>
<div class="wcop_sp_section_content">
    <?php echo wcop_sp_generate_domain_form() ?>
    <div class="wcop_sp_domain_response"></div>
</div>
<div class="wcop_sp_section_content wcop_sp_section_navi">
    <div class="my-button-item">
        <div class="wcop_sp_button">
            <button type="button" name="skip" id="skip" class="skip whcom_button_secondary" value="skip" onclick="skip()" style="float: left;"> <?php esc_html_e("Skip","whcom") ?> <i class="whcom_icon_angle-circled-right"></i></button>

            <button type="button" name="next" class="next"  disabled="disabled" value="continue" onclick="Gotonext('.sleek_domain_section')" style="float:right;"> <?php esc_html_e("Next","whcom") ?> <i class="whcom_icon_angle-circled-right"></i></button>
        </div>
    </div>
</div>



