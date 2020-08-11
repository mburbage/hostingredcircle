<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." ); ?>

<div class="wcop_sp_section_heading">
	<i class="whcom_icon_www"></i>
	<span><?php esc_html_e( "Choose a Domain", "whcom" ) ?></span>
</div>
<div id="frm" class="wcop_sp_section_content">
	<?php echo wcop_sp_generate_domain_form() ?>
	<div class="wcop_sp_domain_response"></div>
</div>
