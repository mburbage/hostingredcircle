<?php
//page initialization, veriables for whole page

//wcap_ppa($_REQUEST);
$show_sidebar = wcap_show_side_bar( "order_new_service");

$args=[
    'goto'                  => "viewinvoice.php?wcap_no_redirect=1&id=" . $_REQUEST["id"] . "&wcap_iframe" ,
    'append_no_redirect'    => 'yes'
];
$invoice_url =whcom_generate_auto_auth_link($args);


?>


<div class="wcap_view_invoice ">
    <div class="whcom_row">
        <?php if ($show_sidebar) { ?>
            <div class="whcom_col_sm_3">
                <?php //side bar content ?>
                <?php
                wcap_render_categories_panel();
                wcap_render_services_panel_action();
                ?>
            </div>
        <?php } ?>
        <div class="<?php echo ($show_sidebar) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
            <!--<div class="whcom_page_heading">
                <?php /*_e("Order Received..", "whcom" ) */?>
            </div>-->
            <?php //main content ?>
            <div class="whcom_row">
                <div class="whcom_col_sm_12">
                    <?php if ( ! empty( $_REQUEST['id'] ) && (int) $_REQUEST['id'] > 0 ) {
                    $order_complete_url = get_option('wcapfield_client_area_url' . whcom_get_current_language(), '?whmpca=dashboard');
                    echo whcom_generate_invoice_iframe((int)$_REQUEST['id'], $order_complete_url);
                    } ?>

                </div>
            </div>


        </div>
    </div>
</div>


<script>
    //window.open('<?php echo $url ?>');

    //show_invoice = function() {
    //	if (is_mobile) {
    //		tb_show( 'View Invoice', '<?php echo $url ?>#TB_iframe=true&KeepThis=true&height=520&width=350' );
    //	} else {
    //		tb_show( 'View Invoice', '<?php echo $url ?>#TB_iframe=true&KeepThis=true&height=520&width=700' );
    //	}
    //}

    //show_invoice();*/

/*
    jQuery(window).bind('tb_load', function () {
        /!*if (tb_unload_count > 1) {
         tb_unload_count = 1;
         } else {
         // do something here
         tb_unload_count = tb_unload_count + 1;
         }*!/
        alert("Loaded");
    });
*/

    //	$(document).on("click", "#open_invoice_link", function( event ) {
    //		event.preventDefault();
    //		show_invoice();
    //	})
</script>