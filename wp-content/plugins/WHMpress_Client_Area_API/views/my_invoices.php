<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar( "my_invoices" );


$currency = whcom_get_current_currency();

$invoices_stats = wcap_get_invoices( "limitnum=9999&status=Unpaid&userid=" . whcom_get_current_client_id() );


if ( isset( $invoices_stats["invoices"]["invoice"] ) && is_array( $invoices_stats["invoices"]["invoice"] ) ) {
	$no_of_invoices = count( $invoices_stats["invoices"]["invoice"] );
}
else {
	$invoices = 0;
}

$invoice_total = 0;
foreach ( $invoices_stats["invoices"]["invoice"] as $invoice ) {
	$invoice_total = $invoice_total + $invoice["total"];
}
$invoice_total .= " " . $currency["suffix"];


$invoices = wcap_get_invoices( "userid=" . whcom_get_current_client_id() );

// count status
$fill_array   = [
	"All"       => "0",
	"Paid"      => "0",
	"Unpaid"    => "0",
	"Cancelled" => "0",
	"Refunded"  => "0",
];
$status_array = wcap_count_status( $fill_array, $invoices["invoices"]["invoice"] );


?>

<div class="wcap_services ">
    <div class="whcom_row">
		<?php if ( $show_sidebar ) { ?>
            <div class="whcom_col_sm_3">
				<?php //side bar content ?>
                <div class="whcom_panel">
                    <div class="whcom_panel_header whcom_has_icon">
                        <i class="whcom_icon_credit-card whcom_header_icon"></i>
						<?php $no_of_invoices . " " . esc_html_e( 'Invoices Due', "whcom" ) ?>
                    </div>

                    <div class="whcom_panel_body">

						<?php
						if ( $invoice_total == 0 ) {
							esc_html_e( "My Invoices", "whcom" );
						}
						else {
							printf( esc_html__( 'You have %1$s invoice(s) currently unpaid with a total balance of %2$s', "whcom" ), $no_of_invoices, $invoice_total );

						}
						?>
                    </div>

					<?php
					//show mass pay button only if option is enabled
					$all_config    = whcom_process_helper( [ "action" => "configurations" ] );
					$EnableMassPay = $all_config["EnableMassPay"];
					if ( $EnableMassPay == "on" ) {
						?>
                        <div class="whcom_panel_footer">
                            <a class="whcom_button whcom_button_block whcom_button_success wcap_load_page"
                               data-page="profile"
                               href="#">
                                <i class="whcom_icon_check"></i> <?php esc_html_e( 'Pay All', "whcom" ) ?></a>
                        </div>
					<?php } ?>

                </div>

                <div class="whcom_panel">
                    <div class="whcom_panel_header whcom_has_icon">
                        <i class="whcom_icon_filter whcom_header_icon"></i><?php esc_html_e( 'Status', "whcom" ) ?>
                    </div>
                    <div class="whcom_panel_body whcom_has_list">
                        <ul class="whcom_list_wcap_style_2">
                            <li>
                                <a class="wcap_invoices_filter" data-status=""
                                   href="#"><?php esc_html_e( 'All', "whcom" ) ?>
                                    <span class="whcom_pull_right"><?php echo $status_array["All"]; ?></span></a>
                            </li>

                            <li>
                                <a class="wcap_invoices_filter" data-status="Paid"
                                   href="#"><?php esc_html_e( 'Paid', "whcom" ) ?>
                                    <span class="whcom_pull_right"><?php echo $status_array["Paid"]; ?></span></a>
                            </li>
                            <li>
                                <a class="wcap_invoices_filter" data-status="Unpaid"
                                   href="#"><?php esc_html_e( 'Unpaid', "whcom" ) ?>
                                    <span class="whcom_pull_right"><?php echo $status_array["Unpaid"]; ?></span></a>
                            </li>
                            <li>
                                <a class="wcap_invoices_filter" data-status="Cancelled"
                                   href="#"><?php esc_html_e( 'Cancelled', "whcom" ) ?>
                                    <span class="whcom_pull_right"><?php echo $status_array["Cancelled"]; ?></span></a>
                            </li>
                            <li>
                                <a class="wcap_invoices_filter" data-status="Refunded"
                                   href="#"><?php esc_html_e( 'Refunded', "whcom" ) ?>
                                    <span class="whcom_pull_right"><?php echo $status_array["Refunded"]; ?></span></a>
                            </li>
                        </ul>
                    </div>
                </div>

				<?php wcap_render_billing_panel(); ?>

            </div>
		<?php } ?>
        <div class="<?php echo ( $show_sidebar ) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
			<?php //main content ?>
            <div class="whcom_page_heading">
				<?php esc_html_e( "My Invoices", "whcom" ) ?>
            </div>
            <div class="wcap_domains_table whcom_table whcom_margin_bottom_15">

                <table class="dt-responsive wcap_responsive_table whcom_table data_table" style="width: 100%">
                    <thead>
                    <tr>
                        <th><?php esc_html_e( "Invoice #", "whcom" ) ?></th>
                        <th><?php esc_html_e( "Invoice Date", "whcom" ) ?></th>
                        <th><?php esc_html_e( "Due Date", "whcom" ) ?></th>
                        <th><?php esc_html_e( "Total", "whcom" ) ?></th>
                        <th><?php esc_html_e( "Status", "whcom" ) ?></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
					<?php
					$invoices = wcap_get_invoices( "userid=" . whcom_get_current_client_id() );
					foreach ( $invoices["invoices"]["invoice"] as $invoice ) {
						$args = [
							'goto'               => "viewinvoice.php?wcap_no_redirect=1&id=" . $invoice["id"] . "&wcap_iframe",
							'append_no_redirect' => 'yes'
						];
						$link = whcom_generate_auto_auth_link( $args );


						?>
                        <tr data-status="<?php echo $invoice["status"]; ?>">
                            <td><?php echo $invoice["id"] ?></td>
                            <td><?php echo wcap_date_ml( $invoice["date"] ) ?></td>
                            <td><?php echo wcap_date_ml( $invoice["duedate"] ) ?></td>
                            <td><?php echo whcom_format_amount( $invoice["total"] ) . " " . $invoice["currencysuffix"] ?></td>
                            <td>
                                <span class="whcom_pill_block whcom_pill_<?php echo ( strtolower( $invoice["status"] ) == 'paid' ) ? 'success' : 'danger'; ?>"><?php echo wcap_status_ml( $invoice["status"] ) ?></span>
                            </td>
                            <td>
								<?php
								if ( get_option( 'wcapfield_show_invoice_as', 'popup' ) == 'minimal' ) {
									$invoice_link = '<a href="' . $link . '" class="whcom_button wcop_view_invoice_button">' . esc_html__( 'View', "whcom" ) . '</a> ';
								}
								else if ( get_option( 'wcapfield_show_invoice_as', 'popup' ) == 'same_tab' ) {
									$invoice_link = '<a href="?whmpca=order_process&a=viewinvoice&id=' . $invoice["id"] . '" class="whcom_button wcop_view_invoice_button">' . esc_html__( 'View', "whcom" ) . '</a> ';
								}
								else if ( get_option( 'wcapfield_show_invoice_as', 'popup' ) == 'new_tab' ) {
									$invoice_link = '<a target="_blank" href="?whmpca=order_process&a=viewinvoice&id=' . $invoice["id"] . '" class="whcom_button wcop_view_invoice_button">' . esc_html__( 'View', "whcom" ) . '</a> ';
								}
								else {
									$order_complete_url = get_option( 'wcapfield_client_area_url' . whcom_get_current_language(), '?whmpca=dashboard' );
									$redirect_link      = '<a class="whcom_op_thickbox_redirect_overlay" href="' . $order_complete_url . '">' . esc_html__( 'Close', 'whcom' ) . '</a> ';
									$invoice_div        = '<div id="invoice_' . $invoice["id"] . '" style="display:none;"><iframe style="width: 100%; height: 100%; overflow: auto;" src="' . $link . '"></iframe>' . $redirect_link . '</div>';
									$invoice_anchor     = '<a href="#TB_inline?width=1050&height=550&inlineId=invoice_' . $invoice["id"] . '" class="thickbox whcom_button whcom_op_view_invoice_button">' . esc_html__( 'View', 'whcom' ) . '</a> ';
									$invoice_link       = $invoice_anchor . $invoice_div;
								}


								?>
								<?php echo $invoice_link ?>
                            </td>

                        </tr>
					<?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>



