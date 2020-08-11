<?php
if ( ! defined( 'WPCT_GRP_PATH' ) ) {
	wp_die( "Direct access not allowed by WHMPress", "Forbidden" );
}

global $wpdb;

?>

<div class="wrap wpct_admin_page">
	<h2><?php echo __( "Sliders & Comparison Settings", "whmpress" ); ?></h2>
	<!-- Title of Plugin Page -->

	<!-- Start Groups table -->
	<form action="options.php" method="post">
		<?php
		settings_fields( 'wpct' );
		do_settings_sections( 'wpct' );
		?>
		<table class="wpct_admin_pretty_table">
			<!-- Start Table Header -->
			<tbody>
			<!-- End table header -->

			<tr>
				<td class="right"><?php echo __( "HTML Template source", "whmpress" ) ?></td>
				<td>
					<select name="wpct_load_style_orders">
						<option value="">== Default ==</option>
						<option <?php echo get_option( 'wpct_load_style_orders' ) == "wpct" ? "selected=selected" : ""; ?> value="wpct">
							<?php echo __( "Matching Templates by WHMPress", "whmpress" ) ?>
						</option>
						<option <?php echo get_option( 'wpct_load_style_orders' ) == "author" ? "selected=selected" : ""; ?> value="author">
							<?php echo __( "Matching Templates by Theme Authors", "whmpress" ) ?>
						</option>
					</select>
				</td>
			</tr>
			<?php
			$wpct_cost_string1     = get_option( "wpct_cost_string1_".$this->get_current_language() );
			$wpct_cost_string2     = get_option( "wpct_cost_string2_".$this->get_current_language() );
			$wpct_discount_string1 = get_option( "wpct_discount_string1_".$this->get_current_language() );
			$wpct_discount_string2 = get_option( "wpct_discount_string2_".$this->get_current_language() );
			$wpct_feature_string1 = get_option( "wpct_feature_string1_".$this->get_current_language() );
			$wpct_feature_string2 = get_option( "wpct_feature_string2_".$this->get_current_language() );
			?>
			<tr>
				<td colspan="2">
					<?php esc_html_e('Up-sell/ Discount', 'wpct')?>
					<small>
						<em><br>
							<?php esc_html_e('You can customize the text that appear when you enable discount. Use placeholders {duration} and {discount} where you want to show duration and discount values.', 'wpct')?>
						</em>
					</small>
				</td>
			</tr>

			<!--
			<tr>
				<td class="right">
					<?php echo __( "Up-sell Text", "whmpress" ); ?> [ <b><?php echo $this->get_current_language(); ?></b> ]
				</td>
				<td>
					<input name="wpct_cost_string1_<?php echo $this->get_current_language() ?>" value="<?php echo esc_attr($wpct_cost_string1) ?>">
				</td>
			</tr>
			<tr>
				<td class="right">
					<?php echo __( "Discount", "whmpress" ); ?> [ <b><?php echo $this->get_current_language(); ?></b> ]
				</td>
				<td>
					<input name="wpct_cost_string2_<?php echo $this->get_current_language() ?>" value="<?php echo esc_attr($wpct_cost_string2) ?>">
				</td>
			</tr>
			
			-->
			<tr>
				<td class="right">
                    <?php echo __( "Up-sell Text", "whmpress" ); ?> <em><small>[<?php echo $this->get_current_language(); ?>]</small></em><br>
					<small>
						<em>
							<?php esc_html_e('Used with primary duration to show who much user will save for switching to longer duration. ', 'wpct')?>
						</em>
					</small>
				</td>
				<td>
					<input name="wpct_discount_string1_<?php echo $this->get_current_language() ?>" value="<?php echo ($wpct_discount_string1 == "") ? "Switch {duration} and save {discount}" : esc_attr($wpct_discount_string1) ?>">
				</td>
			</tr>
			<tr>
				<td class="right">
                    <?php echo __( "Discount Text", "whmpress" ); ?> <em><small>[ <?php echo $this->get_current_language(); ?> ]</small></em><br>
					<small>
						<em>
							<?php esc_html_e('Used to show how much user is saving with this duration. ', 'wpct')?>
						</em>
					</small>
				</td>
				<td>
					<input name="wpct_discount_string2_<?php echo $this->get_current_language() ?>" value="<?php echo ($wpct_discount_string2 == "") ? "You saved {discount}" : esc_attr($wpct_discount_string2) ?>">
				</td>
			</tr>
			<tr>
				<td class="right">
                    <?php echo __( "Up-sell Text (Banner)", "whmpress" ); ?><em><small> [ <?php echo $this->get_current_language(); ?> ]</small></em><br>
					<small>
						<em>
							<?php esc_html_e('Up-sell text to show on banner while with First Duration, ', 'wpct')?>
						</em>
					</small>
				</td>
				<td>
					<input name="wpct_feature_string1_<?php echo $this->get_current_language() ?>" value="<?php echo ($wpct_feature_string1 == "") ? "Switch {duration}<br>Save {discount}" : esc_attr($wpct_feature_string1) ?>">
				</td>
			</tr>
			<tr>
				<td class="right">
                    <?php echo __( "Discount Text (Banner)", "whmpress" ); ?> <em><small>[ <?php echo $this->get_current_language(); ?> ]</small></em><br>
					<small>
						<em>
							<?php esc_html_e('Discount text to show with second duration.', 'wpct')?>
						</em>
					</small>
				</td>
				<td>
					<input name="wpct_feature_string2_<?php echo $this->get_current_language() ?>" value="<?php echo ($wpct_feature_string2 == "") ? "Saved<br> {discount}" : esc_attr($wpct_feature_string2) ?>">
				</td>
			</tr>

			<!-- End Tooltip Row  -->
			<tr>
				<td colspan="4" class="center wpct_admin_text_center">
					<button class="button button-primary button-big"><?php echo __( "Save Settings", "whmpress" ) ?></button>
				</td>
			</tr>
			</tbody>
		</table>
	</form>
	<!-- End Tooltips Table -->
</div>

<script>
	jQuery( function() {
		jQuery( ".del-button" ).click( function( event ) {
			//event.preventDefault();

			if ( !confirm( "Are you sure you want to delete this group?" ) ) {
				return false;
			}
		} );
		jQuery( ".select_me" ).focus( function() {
			jQuery( this ).select();
		} );
	} );
</script>