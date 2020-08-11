<?php

$atts = $_SESSION['atts'];

$page = "order_new_service";
$page = ($_POST["domain"]=="register")?"domain_register":$page;
$page = ($_POST["domain"]=="transfer")?"domain_transfer":$page;
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar($page);


//show front menu where applicable
if (empty(get_option('wcapfield_hide_whmcs_menu_op','')) && wcap_show_front_menu()) {
	include_once $this->Path . "/views/top_links_front.php";
}

if (!empty($_REQUEST['dp'])) {
	$show_sidebar = false;
}
?>

    <div class="wcap_order_new_service">
        <div class="whcom_row">
            <?php if ($show_sidebar) { ?>
                <div class="whcom_col_sm_3">
                    <?php //side bar content ?>
                    <?php wcap_render_categories_panel(); ?>
                </div>
            <?php } ?>
            <div class="<?php echo ($show_sidebar) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
                <?php echo do_shortcode('[whcom_order_process promocode=' .$atts['promocode'].' ]'); ?>
            </div>
        </div>
    </div>





