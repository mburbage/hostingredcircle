<?php

$show_sidebar = wcap_show_side_bar( "mass_pay", true );
$currency = whcom_get_current_currency();

$invoices_stats = wcap_get_invoices( "limitnum=9999&status=Unpaid&userid=" . whcom_get_current_client_id() );
if ( isset( $invoices_stats["invoices"]["invoice"] ) && is_array( $invoices_stats["invoices"]["invoice"] ) ) {
	$no_of_invoices = count( $invoices_stats["invoices"]["invoice"] );
} else {
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

$invoices = $invoices_stats["invoices"]["invoice"];
?>


<div class="wcap_billings">
    <div class="whcom_row">
        <?php if($show_sidebar) {?>
            <div class="whcom_col_sm_3">


                <div class="whcom_panel">
                    <div class="whcom_panel_header whcom_has_icon">
                        <i class="whcom_icon_credit-card"></i><?php esc_html_e( 'Invoices Due', "whcom" ) ?>
                    </div>

                    <div class="whcom_panel_body">
			            <?php
			            if ( $invoice_total == 0 ) {
				            esc_html_e( "My Invoices", "whcom" );
			            } else {
				            printf( esc_html__( 'You have %1$s invoice(s) currently unpaid with a total balance of %2$s', "whcom" ), $no_of_invoices, $invoice_total );
			            }
			            ?>
                    </div>
                    <div class="whcom_panel_footer">
                        <a class="whcom_button whcom_button_block whcom_button_small wcap_load_page" data-page="profile" href="#">
                            <i class="whcom_icon_check"></i> <?php esc_html_e( 'Pay All', "whcom" ) ?></a>
                    </div>

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
        <?php }?>

        <div class="<?php echo ($show_sidebar)?"whcom_col_sm_9":"whcom_col_sm_12"?>">
            <div class="whcom_page_heading">
				<?php esc_html_e( "Mass Payment", "whcom" ) ?>
            </div>
            <div class=" whcom_margin_bottom_15 wcap_mass_pay_container">
                <div class="whcom_margin_bottom_15">
                    <div class="whcom_pull_left_sm"><strong><?php esc_html_e("Description","whcom" ) ?></strong></div>
                    <div class="whcom_pull_right_sm"><strong><?php esc_html_e("Amount","whcom" ) ?></strong></div>
                    <div class="clearfix"></div>
                </div>

                <form id="mass_pay_form">
                    <input type="hidden" name="action" value="wcap_requests">
                    <input type="hidden" name="what" value="mass_payment">
					<?php
					$invoice_total    = 0;
					$invoice_balance  = 0;
					$invoice_payments = 0;
					foreach ( $invoices as $invoice ) {
						if ( $invoice["status"] == "Unpaid" ) {
							$invoice_id = $invoice["id"];
							?>
                            <input type="hidden" name="ids[]" value="<?php echo $invoice_id ?>">
                            <input type="hidden" name="amount[]" value="<?php echo $invoice["subtotal"] ?>">
                            <div class="whcom_panel whcom_panel_info whcom_panel_fancy_1">
                            <div class="whcom_alert whcom_alert_info" style="color:#000 !important">
								<?php echo "<strong>".esc_html__( "Invoice #", "whcom" ) . $invoice_id."</strong>"; ?>
                            </div>
                            <div class="whcom_panel_body">
							<?php
							$invoice_details = wcap_get_invoice( $invoice_id );
							$invoice_total   = $invoice_total + $invoice_details["subtotal"];
							$invoice_balance = $invoice_balance + $invoice_details["balance"];
							foreach( $invoice_details["items"]["item"] as $invoice_item ) {
								?>
                                <div class="wcap_invoice_item_detail whcom_pull_left_sm">
									<?php
									$description = explode("\n",$invoice_item["description"]);
									foreach ($description as $des) {
										echo $des."<br/>";
									}
									// echo $invoice_item["description"]; ?>
                                </div>
                                <div class="wcap_invoice_item_total whcom_pull_right_sm">
									<?php echo $invoice_item["amount"]; ?>
                                </div>
                                <div class="clearfix"></div>

							<?php } ?>



						<?php } ?>

                        </div>

                        </div>
						<?php


					} ?>

					<?php
					$invoice_payments = $invoice_total - $invoice_balance;
					?>

                    <div class="whcom_panel">
                        <div class="whcom_panel_header">
                            <div class="whcom_text_right_sm">
								<?php echo "<strong>".esc_html__( "Sub Total:", "whcom" ) . whcom_format_amount( $invoice_total )."</strong>"; ?>
                            </div>
                            <div class="whcom_text_right_sm">
								<?php echo "<strong>".esc_html__( "Partial Payments:", "whcom" ). whcom_format_amount( $invoice_payments )."</strong>"; ?>
                            </div>
                            <div class="whcom_text_right_sm">
								<?php echo "<strong>".esc_html__( "Total Due:", "wcap " ) . whcom_format_amount( $invoice_balance )."</strong>"; ?>
                            </div>
                        </div>
                    </div>

	                <div class="wcap_mass_pay_response">

	                </div>
                    <button class="button"><?php esc_html_e("Proceed Mass Payment","whcom" ) ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

