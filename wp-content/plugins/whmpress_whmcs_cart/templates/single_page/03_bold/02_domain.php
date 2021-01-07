<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." ); ?>

<div class="wcop_sp_section_heading">
	<i class="whcom_icon_www"></i>
	<span><?php esc_html_e( "Choose a Domain", "whcom" ) ?></span>
</div>
<div class="wcop_sp_section_content">
	<?php echo wcop_sp_generate_domain_form() ?>
	<div class="wcop_sp_domain_response"></div>
</div>
<div class="wcop_sp_button">
    <button name="skip_step" id="skip_step" class="skip whcom_button_secondary" value="skip"
            onclick="skip_step()">
        SKIP DOMAIN ❯
    </button>
    <button type="button" name="next" class="next" disabled="disabled" value="continue"
            onclick="Gotonext1('.bold_domain_section')">NEXT
        ❯
    </button>
</div>


