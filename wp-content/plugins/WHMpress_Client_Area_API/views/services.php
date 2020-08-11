<?php
/*
 * Menu - Services > My Services
 * WHCOM - logic
 * WHCOM - HTML
 * todo: naveed, why this class?
 *
 *
*/


/*//get current user data, returns array
whcom_get_current_client();
whcom_get_client();

whcom_register_new_client();

//returns true or fallse
whcom_is_client_logged_in();

//destroys the session
whcom_client_log_out();

whcom_get_all_currencies();
whcom_get_current_currency_id();
whcom_get_current_currency();



//todo: change function to get_currencies all over
//todo: nadeem, change client register funciton
//todo: AW, get client contacts*/
//todo: Shakeel, category links on other pages are not working,
//todo: Mass payment page
//todo: nadeem, change popup to message in client update/ register
//todo: nadeem, editor
//todo: nadeem, open ticket, autofill name, email addresss

//todo: Notice: Trying to get property of non-object in C:\xampp\htdocs\me\wp2\wp-content\plugins\WHMpress_Client_Area_API\library\WCAP.php on line 1428
?>


<?php


$time1 = microtime(true);

/*
 *  Services > my products and services
 */
$currencies = whcom_get_current_currency();

//$response = wcap_get_client_products("clientid=" . whcom_get_current_client_id());
//$response = $_SESSION["client_services"];
//$response = $service_response;
$response = wcap_get_client_products( [
	"clientid" => whcom_get_current_client_id(),
	"status"   => isset( $_POST["status"] ) ? $_POST["status"] : "",
] );


$StatusArray = ["Active", "Completed", "Pending", "Suspended", "Terminated", "Cancelled"];

// count tickets
$fill_array = [
    "All" => "0",
    "Active" => "0",
    "Completed" => "0",
    "Pending" => "0",
    "Suspended" => "0",
    "Terminated" => "0",
    "Cancelled" => "0",
];
$status_array = wcap_count_status($fill_array, $response["products"]["product"]);
$show_sidebar = wcap_show_side_bar("my_services", TRUE);
?>

    <div class="wcap_services">
        <!-- start content -->
        <div class="whcom_row">
            <?php if($show_sidebar){ ?>
                <div class="whcom_col_sm_3">
                    <div class="whcom_panel">
                        <div class="whcom_panel_header whcom_has_icon">
                            <i class="whcom_icon_filter panel_header_icon"></i><?php esc_html_e('View', "whcom" ) ?>
                        </div>
                        <div class="whcom_panel_body whcom_has_list">
                            <ul class="whcom_list_wcap_style_2">
                                <li>
                                    <a class="wcap_services_filter" data-status="" href="#"><?php esc_html_e('All', "whcom" ) ?>
                                        <span class="whcom_pull_right"><?php echo $status_array["All"]; ?></span></a>
                                </li>

                                <li>
                                    <a class="wcap_services_filter" data-status="Active"
                                       href="#"><?php esc_html_e('Active', "whcom" ) ?>
                                        <span class="whcom_pull_right"><?php echo $status_array["Active"]; ?></span></a>
                                </li>
                                <li>
                                    <a class="wcap_services_filter" data-status="Pending"
                                       href="#"><?php esc_html_e('Pending', "whcom" ) ?>
                                        <span class="whcom_pull_right"><?php echo $status_array["Pending"]; ?></span></a>
                                </li>
                                <li>
                                    <a class="wcap_services_filter" data-status="Suspended"
                                       href="#"><?php esc_html_e('Suspended', "whcom" ) ?>
                                        <span class="whcom_pull_right"><?php echo $status_array["Suspended"]; ?></span></a>
                                </li>
                                <li>
                                    <a class="wcap_services_filter" data-status="Terminated"
                                       href="#"><?php esc_html_e('Terminated', "whcom" ) ?>
                                        <span class="whcom_pull_right"><?php echo $status_array["Terminated"]; ?></span></a>
                                </li>
                                <li>
                                    <a class="wcap_services_filter" data-status="Cancelled"
                                       href="#"><?php esc_html_e('Cancelled', "whcom" ) ?>
                                        <span class="whcom_pull_right"><?php echo $status_array["Cancelled"]; ?></span></a>
                                </li>

                            </ul>
                        </div>
                    </div>

                    <?php wcap_render_services_panel_action() ?>
                </div>


                <?php } ?>


            <div class=<?php echo ($show_sidebar)?"whcom_col_sm_9":"whcom_col_sm_12"?>>
                <div class="whcom_page_heading">
                    <?php esc_html_e("My Products & Services", "whcom" ) ?>
                </div>
                <div class="wcap_services_table whcom_table whcom_margin_bottom_15">
                    <table class="dt-responsive wcap_responsive_table data_table" style="width: 100%">
                        <thead>
                        <tr>
                            <th><?php esc_html_e("Product/Service", "whcom" ) ?></th>
                            <th><?php esc_html_e("Pricing", "whcom" ) ?></th>
                            <th><?php esc_html_e("Next Due Date", "whcom" ) ?></th>
                            <th><?php esc_html_e("Status", "whcom" ) ?></th>
                            <th><?php esc_html_e("Actions", "whcom" ) ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($response["products"]["product"] as $product) { ?>
                            <tr data-status="<?php echo $product["status"]; ?>">
                                <td>
                                    <strong><?php echo $product["name"] ?></strong>
                                    <?php if(! trim($product["domain"])=="") { ?>
                                    <div class="whcom_margin_bottom_15">
                                        <a target="_blank"
                                           href="http://<?php echo $product["domain"] ?>"><?php echo $product["domain"] ?>
                                        </a>
                                    </div>
                    <?php
                    }?>
                                </td>
                                <td class="whcom_text_center">
                                    <div><?php echo  whcom_format_amount($product["recurringamount"]) ?></div>
                                    <div><?php echo whcom_convert_billingcycle(strtolower($product["billingcycle"])) ; ?></div>
                                </td>
                                <td class="whcom_text_center"><?php echo wcap_date_ml($product["nextduedate"]) ?></td>
                                <!--<td>Primary Domain: Package-domain.com [Addons] [ Aliases] [Sub-domains]</td>-->
                                <td class="whcom_text_center">
                                    <a class="wcap_load_page whcom_pill_<?php echo ( strtolower( $product["status"] ) == 'active' ) ? 'success' : 'danger'; ?>"
                                       href="?id=<?php echo $product["id"] ?>" data-page="productdetails">
                                        <?php echo wcap_status_ml($product["status"]); ?>
                                    </a>

                                </td>
                                <td class="whcom_text_center">
                                    <a href="?id=<?php echo $product["id"] ?>"
                                       class="whcom_button wcap_load_page" data-page="productdetails">
                                        <?php esc_html_e("Details","whcom" ); ?>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <!-- end wcap whcom_row -->
    </div>

