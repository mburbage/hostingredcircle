<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." ); ?>

<div class="wcop_sp_section_heading">
	<i class="whcom_icon_www"></i>
	<span><?php esc_html_e( "Choose a Domain", "whcom" ) ?></span>
</div>
<div class="wcop_sp_section_content">
	<?php echo wcop_sp_generate_domain_form() ?>
	<div class="wcop_sp_domain_response"></div>
</div>
<div class="wcop_sp_section_content">
    <div class="my-button-item">
        <div class="wcop_sp_button">
            <button type="button" name="skip" class="prev whcom_button_secondary" onclick="skip()"
                    style="float: left;">Skip
            </button>
            <button type="button" name="next" class="next" value="continue" disabled="disabled" onclick="Gotonext('.sleek_minimal_domain_section')" style="float:right;">
                Continue
            </button>
        </div>
    </div>
</div>



