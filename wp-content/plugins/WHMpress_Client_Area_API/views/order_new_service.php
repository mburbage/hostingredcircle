<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." ); ?>


<?php

//show front menu where applicable
if (empty(get_option('wcapfield_hide_whmcs_menu_op','')) && wcap_show_front_menu()) {
	include_once $this->Path . "/views/top_links_front.php";
}


//page initialization, veriables for whole page
//$page=(whcom_is_client_logged_in())?"order_new_service":"store";
$show_sidebar = true;


//$active_tab = $_POST["active"];
$active_tab = "";

global $WCOP;
$currency_id = $gids = $pids = $domain_products = '';
$currency_id = whcom_get_current_currency_id();

$page_id         = url_to_postid( esc_attr( get_option( $field ) ) );
$config_prod_url = get_permalink( $page_id );
$groups = whcom_get_all_products();

$groups = ( empty( $groups['groups'] ) ) ? [] : $groups['groups'];
if ( empty( $groups ) ) {
    esc_html_e( 'No Groups/Products Found', "whcom" );

    return;
}

if ( ! empty( $_POST['pid'] ) ) {
    foreach ( $groups as $key => $group ) {
        foreach ( $group['products'] as $product ) {
            if ( $_POST['pid'] == $product['id'] ) {
                if ( $product['showdomainoptions'] == '1' ) {
                    echo "<script>
                                set_url_parameter_value('showdomainoption', '1');
                                console.log('called the showdomainoption');
                                LoadData();
                          </script>";
                }
            }
        }
    }
}

$cop_active=wcap_is_wcop_active();
$order_url="";
if ( $cop_active ) {
    // use cop links
    $field = 'configure_product' . whcom_get_current_language();
    $base_url = esc_attr( get_option( $field, '' ));
    $order_url = $base_url . '?order_type=order_product&';
}else
{ //use cap links
       //$order_url="?whmpca=order_process&a=add&pid=";
       $order_url="?whmpca=order_process&a=add&";
}

?>



<div class="wcap_knowledgebase ">
    <div class="whcom_row whcom_tabs_container">
        <?php if ($show_sidebar) { ?>
            <div class="whcom_col_sm_3">
                <?php //side bar content ?>
                <!-- tabs links -->
                <div class="whcom_panel">
                    <div class="whcom_panel_header whcom_has_icon">
                        <i class="whcom_icon_basket-1"></i>
                        <?php esc_html_e( "Categories", "whcom" ) ?>
                    </div>
                    <div class="whcom_panel_body whcom_has_list">
<!--                        <ul class="whcom_list_wcap_style_2">-->
<!--                            --><?php
//                            $active = true;
//                            foreach ( $groups as $key => $group ) {
//                                if ( ! empty( $group['products'] ) ) {
//                                    $group_unique_id = 'whcom_products_group_' . $key;
//
//                                    if ( ! empty( $active_tab ) ) {
//                                        $active_class = ( $active_tab == $group_unique_id ) ? 'active' : '';
//                                    }
//                                    else {
//                                        $active_class = ( $active ) ? 'active' : '';
//                                    }
//
//                                    echo '<li data-tab="' . $group_unique_id . '" class="whcom_tab_link ' . $active_class . '"><a>' . $group["name"] . '</a></li>';
//                                    $active = false;
//                                }
//                            } ?>
<!--                        </ul>-->

                        <ul class="whcom_list_wcap_style_2">
                            <?php
                            $active = true;
                            foreach ( $groups as $key => $group ) {
                                if ( ! empty( $group['products'] ) ) {
                                    $group_unique_id = 'whcom_products_group_' . $key;

                                    if (!empty($active_tab)) {
                                        $active_class = ($active_tab == $group_unique_id) ? 'active' : '';
                                    } else {
                                        $active_class = ($active) ? 'active' : '';
                                    }
                                    foreach ($group['products'] as $product) {

                                        echo '<li data-tab="' . $group_unique_id . '" class="whcom_tab_link ' . $active_class . '"><a>' . $product['group_name'] . '</a></li>';
                                        $active = false;
                                    break;
                                    }
                                }
                            } ?>
                        </ul>

                    </div>
                </div>
                <!-- tabs link end -->
                <?php
                wcap_render_domains_panel_action();
                ?>

            </div>
        <?php } ?>
        <div class="<?php echo ($show_sidebar) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
            <?php //main content ?>
            <div class="whcom_margin_bottom_15">
                <?php
                $active = true;
                foreach ( $groups as $key => $group ) {
                    ?>

                    <?php if ( ! empty( $group['products'] ) ) { ?>

                        <?php $group_unique_id = 'whcom_products_group_' . $key; ?>

                        <?php

                        if ( ! empty( $active_tab ) ) {
                            $active_class = ( $active_tab == $group_unique_id ) ? 'active' : '';
                        }
                        else {
                            $active_class = ( $active ) ? 'active' : '';
                        }
                        ?>
                        <?php foreach ( $group['products'] as $product ) { ?>
                        <div class="whcom_tabs_content <?php echo $active_class; ?>"
                             id="<?php echo $group_unique_id; ?>">
                            <div class="whcom_page_heading"><?php echo $product['group_name']; ?></div>
                            <div class="wcop_product_boxes whcom_row">
                                <?php break; } ?>
                                <?php foreach ( $group['products'] as $product ) { ?>
                                    <?php
                                    $price_array  = wcap_calculate_default_product_price( $product );
                                    $duration     = $price_array['billingcycle'];
                                    $billingcycle = $price_array['billingcycle'];

                                    $price = $price_array['price'] + $price_array['config_price'];
                                    $price = whcom_format_amount( $price );

                                    $setup = $price_array['setup'] + $price_array['config_setup'];
                                    $setup = whcom_format_amount( $setup );

                                    ?>
                                    <div class="whcom_col_lg_4 whcom_col_md_4 whcom_col_sm_6 whcom_col_xs_12">
                                        <div class="wcop_product_box whcom_panel">
                                            <div class="whcom_text_center whcom_panel_header">
                                                <span><?php echo $product["name"] ?></span>
                                            </div>
                                            <div class="whcom_panel_body">
                                                <div class="wcop_product_info" style="min-height: 90px;">
                                                    <div class="price_box whcom_margin_bottom_15">
	                                                    <?php echo whcom_render_product_price($product); ?>
                                                    </div>
                                                </div>
                                                <div class="wcop_product_description">
                                                    <?php echo nl2br( strip_tags( $product["description"] ) ) ?><br>
                                                </div>
                                            </div>
                                            <?php $url = $order_url . "pid={$product["id"]}&a=add&currency={$currency_id}&billingcycle={$duration}"; ?>
                                            <div class="whcom_panel_footer whcom_text_center_xs">
                                                    <a class="whcom_button whcom_button_success"
                                                       href="<?php echo $url ?>"
                                                        <i class="whcom_icon_basket"></i> <?php esc_html_e( "Order Now", "whcom" ); ?>
                                                    </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php $active = false; ?>
                <?php } ?>
            </div>


        </div>
    </div>
</div>





