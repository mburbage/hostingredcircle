<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$payment_gateways    = whcom_get_payment_gateways()['payment_gateways'];
$wcop_items = $_SESSION['whcom_cart']['all_items_view'];
$cart_pids           = (!empty($wcop_items['pid'])) ? $wcop_items['pid'] : [];
$user_email          = $_SESSION['whmcs_user']['username'];
$invoice_id = (!empty($_POST['invoiceid']) && $_POST['invoiceid'] > 0) ? $_POST['invoiceid'] : 0;


?>

<div class="wcop_df_cart_list wcop_df_page">
	<div class="wcop_df_page_header_2">
		<?php $page='checkout'?>
		<?php include_once wcop_get_template_directory('domain_first') . '/templates/domain_first/default/00_top_icons.php'; ?>
	</div>
	<div class="wcop_df_summary_container wcop_df_page_content">
		<div class="wcop_df_summary_form_container">
			<form class="wcop_df_capture_payment_form" method="post">
				<input type="hidden" name="action" value="wcop_domain_first">
				<input type="hidden" name="wcop_what" value="capture_payment">
				<input type="hidden" name="invoiceid" value="<?php echo $invoice_id; ?>">


				<h3 class="wcop_df_section_heading_2">
					<span><?php esc_html_e( 'Payment Details', "whcom" ); ?></span>
				</h3>
				<div class="wcop_df_summary_form_section">
					<!-- Card Type -->
					<div class="whcom_form_field whcom_form_field_horizontal">
						<label for="cardtype" class="main_label"><?php esc_html_e( 'Card Type', "whcom" ) ?></label>
						<input type="text" name="cardtype" id="cardtype" value="">
						<div class="whcom_clearfix"></div>
						<span>Credit card type. Provide full name: Visa, Mastercard, American Express, etc…</span>
					</div>
					<!-- Card Number -->
					<div class="whcom_form_field whcom_form_field_horizontal">
						<label for="cardnum" class="main_label"><?php esc_html_e( 'Card Number', "whcom" ) ?></label>
						<input type="number" name="cardnum" id="cardnum" value="">
					</div>
					<!-- Expiry Date -->
					<div class="whcom_form_field whcom_form_field_horizontal">
						<label for="expdate" class="main_label"><?php esc_html_e( 'Expiry Date', "whcom" ) ?></label>
						<input type="date" name="expdate" id="expdate" value="">
					</div>
					<!-- Card CVV -->
					<div class="whcom_form_field whcom_form_field_horizontal">
						<label for="cvv" class="main_label"><?php esc_html_e( 'Security Code', "whcom" ) ?></label>
						<input type="password" name="cvv" id="cvv" value="">
					</div>
				</div>
				<div class="wcop_df_summary_form_section">
					<div class="whcom_text_center_xs whcom_form_field whcom_form_field_horizontal wcop_submit_container">
						<p class="wcop_response" style="display: none"></p>
						<button type="submit"><?php esc_html_e( 'Complete Order', "whcom" ) ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>






