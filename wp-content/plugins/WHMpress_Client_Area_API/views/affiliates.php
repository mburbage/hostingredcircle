<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar("affiliates", true);

//show front menu where applicable
if (wcap_show_front_menu()) {
    include_once $this->Path . "/views/top_links_front.php";
}

$cur_id = whcom_get_current_currency_id();
$args = [
    "action" => "whcom_all_currencies",
];

$currencies = whcom_process_helper($args);

$conversion_rate = $currencies["all"][$cur_id]["rate"];

$args = [
    "action" => "configurations",
    //"setting"=>$affiliate_id,
];
$all_config = whcom_process_helper($args);
/*
 * AffiliateEnabled
 * AffiliateEarningPercent
 * AffiliateBonusDeposit
 * AffiliatePayout
 * AffiliateLinks
 */

$AffiliateEnabled = $all_config["AffiliateEnabled"];
$AffiliateEarningPercent = $all_config["AffiliateEarningPercent"];
$AffiliateBonusDeposit = $all_config["AffiliateBonusDeposit"];
$AffiliatePayout = $all_config["AffiliatePayout"];
$AffiliateLinks = $all_config["AffiliateLinks"];
$AffiliateEarningPercent = rtrim($AffiliateEarningPercent, "%");


$user_id = whcom_get_current_client_id();

$affiliate_data = wcap_get_affiliate($user_id);
if ($affiliate_data["result"] == "error") {
    $is_affiliate=false;
} else {
    $is_affiliate = $affiliate_data["totalresults"];
}


if ($is_affiliate) {
    //then show following data
    $affiliate_data = $affiliate_data["affiliates"]["affiliate"]["0"];
    $affiliate_id = $affiliate_data["id"];
    $clicks = $affiliate_data["visitors"];
    $Commissions_Pending_Maturation = $affiliate_data["payamount"];
    $Available_Commissions_Balance = $affiliate_data["balance"];
    $Total_Amount_Withdrawn = $affiliate_data["withdrawn"];

    //get missing info using helper
    $args = [
        "action" => "affiliate_details",
        "aff_id" => $affiliate_id,
    ];
    $affiliate_data2 = whcom_process_helper($args);


    $signups = $affiliate_data2["singups"];
    $conversions = ($clicks != 0) ? ($signups / $clicks * 100) : 0;//may be from orders
//build array to print referall details
    $referalls = $affiliate_data2["referalls"];
    $referall_currency_id = $affiliate_data2["referalls"][0]["currency"];
    $referall_currency_pefix = $currencies["all"][$referall_currency_id]["prefix"];
    $referall_currency_code = $currencies["all"][$referall_currency_id]["code"];

    $referalls2 = [];
    $index = 0;
    $setup = 0;
    $amount = 0;
    $total = 0;

    foreach ($referalls as $key => $value) {
        $index = $value["packageid"];
        $referalls2[$index]["packageid"] = $value["packageid"];
        $referalls2[$index]["date"] = $value["datecreated"];
        $referalls2[$index]["name"] = $value["name"];

        if ($value["type"] == "Setup") {
            $setup = $value["amount"];

        } else {
            $amount = $value["amount"];
        }

        $total = $setup + $amount;
        $referalls2[$index]["setup"] = $setup;
        $referalls2[$index]["amount"] = $amount;
        $referalls2[$index]["total"] = $total;
        $referalls2[$index]["commission"] = whcom_format_amount($referalls2[$index]["total"] * $AffiliateEarningPercent / 100 * $conversion_rate);
        $referalls2[$index]["status"] = $value["domainstatus"];

        $detail1 = $referall_currency_pefix . " " . $total . " " . $referall_currency_code . " " . esc_html__("Initially Then");
        $detail2 = $referall_currency_pefix . " " . $amount . " " . $referall_currency_code . " " . $value["billingcycle"];
        $referalls2[$index]["detail"] = $detail1 . " " . $detail2;
    }


    $refreal_link = "http://dummy-link.aff.php?aff=" . $affiliate_id;

}


?>

<div class="wcap_knowledgebase ">
    <div class="whcom_row">
        <?php if ($show_sidebar) { ?>
            <div class="whcom_col_sm_3">
                <?php //side bar content ?>
                <?php wcap_render_support_panel(); ?>
            </div>
        <?php } ?>
        <div class="<?php echo ($show_sidebar) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
            <div class="whcom_page_heading">
                <span><?php esc_html_e("Affiliates", "whcom" ) ?></span>
            </div>

            <?php //main content ?>
            <?php if (!($is_affiliate)) { ?>
                <div id="affiliate_not_active">
                    <div class="whcom_alert whcom_alert_info whcom_text_center whcom_padding_10 whcom_margin_bottom_30 ">
                        <h3>
                            Get Paid for Referring Customers to Us
                        </h3>
                        <div>
                            Activate your affiliate account and start earning money today...
                        </div>
                    </div>

                    <div>
                        <ul class="whcom_list">
                            <li>We pay commissions for every signup that comes via your custom signup link.</li>
                            <li>We track the visitors you refer to us using cookies, so users you refer don't have to purchase instantly for you to receive your commission.  Cookies last for up to 90 days following the initial visit.</li>
                            <li>If you would like to find out more, please contact us.</li>
                        </ul>
                    </div>
                </div>
            <?php } ?>

            <?php if ($is_affiliate) { ?>
                <div id="affiliate_active">
                    <div class="wcap whcom_row">
                        <div class="whcom_col_sm_12">
                            <!-- error message div-->
                            <div class="whcom_row">
                                <div class="whcom_col_sm_4">
                                    <div class="whcom_alert whcom_alert_warning">
                                        <div class="whcom_row">
                                            <div class="whcom_col_sm_6">
                                                <h1 class="whcom_icon_user-3"></h1>
                                            </div>
                                            <div class="whcom_col_sm_6">
                                                <h1 class="whcom_text_center_sm"> <?php echo $clicks; ?></h1>
                                                <h4 class="whcom_text_center_sm">Clicks</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="whcom_col_sm_4">
                                    <div class="whcom_alert whcom_alert_info">
                                        <div class="whcom_row">
                                            <div class="whcom_col_sm_6">
                                                <h1 class="whcom_icon_cart-plus"></h1>
                                            </div>
                                            <div class="whcom_col_sm_6">
                                                <h1 class="whcom_text_center_sm"> <?php echo $signups; ?></h1>
                                                <h4 class="whcom_text_center_sm">Signups</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="whcom_col_sm_4 ">
                                    <div class="whcom_alert whcom_alert_success">
                                        <div class="whcom_row">
                                            <div class="whcom_col_sm_6">
                                                <h1 class="whcom_icon_user"></h1>
                                            </div>
                                            <div class="whcom_col_sm_6">
                                                <h1 class="whcom_text_center_sm"> <?php echo $conversions; ?> % </h1>
                                                <h4 class="whcom_text_center_sm">Conversions</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="wcap whcmo_row">
                        <h3> Your Unique Referral Link</h3>

                        <div class="whcom_alert">
                            <h3> <?php echo $refreal_link; ?></h3>
                        </div>

                        <div class="whcom_alert"><h4>Commission Pending Maturation:
                                <strong><?php echo $referall_currency_pefix . $Commissions_Pending_Maturation; ?></strong>
                            </h4></div>

                        <div class="whcom_alert"><h4>Available Commission:
                                <strong><?php echo $referall_currency_pefix . $Available_Commissions_Balance; ?></strong>
                            </h4></div>

                        <div class="whcom_alert"><h4>Total Amount Withdrawn:
                                <strong><?php echo $referall_currency_pefix . $Total_Amount_Withdrawn; ?></strong></h4>
                        </div>

                        <?php $disabled = ($AffiliateEnabled == "on") ? "disabled" : ""; ?>

                        <div class="whcom_text_center <?php echo $disabled ?>">
                            <a class="button whcom_button_danger whcom_button_big"
                               href="<?php echo $AffiliatePayout ?>">Request A withdrawl</a>
                        </div>
                    </div>

                    <div class="">
                        <div class="">
                            <div class="_heading whcom_margin_bottom_15">
                                <h3>Your Referrals</h3>
                            </div>
                            <div class="wcap_domains_table whcom_table whcom_margin_bottom_15">
                                <table class="wcap_responsive_table dt-responsive" style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th>Signup Date</th>
                                        <th>Product/Service</th>
                                        <th>Amount</th>
                                        <th>Commission</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($referalls2 as $key => $ref) { ?>
                                        <tr>
                                            <td style="text-align: left;"> <?php echo $ref["date"] ?></td>
                                            <td><?php echo $ref["name"] ?></td>
                                            <td> <?php echo $ref["detail"] ?></td>
                                            <td><?php echo $ref["commission"] ?></td>
                                            <td><?php echo $ref["status"] ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="wcp_section">
                        <h2>Link To us</h2>
                        <div class="whcom_row">
                            <div class="whcom_col_sm_4"></div>
                            <div class="whcom_col_sm_8">
                                <?php echo html_entity_decode($AffiliateLinks); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>


    </div>
</div>
</div>







