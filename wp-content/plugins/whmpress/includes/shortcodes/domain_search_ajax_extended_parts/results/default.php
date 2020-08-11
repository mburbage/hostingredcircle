<?php
if ( ! empty( $result_details ) && is_array( $result_details ) ) { ?>
    <?php if ( ! empty( $is_title ) ) { ?>
        <div class="whmpress_domain_search_ajax_extended_search_result_title whcom_op_whmp_domain_container results_loaded">
            <input type="hidden" name="cart_index" value="-1">
            <div class="whcom_alert whcom_border_success whcom_bg_white whcom_margin_bottom_0">
                <div class="whcom_row">
                    <div class="whcom_col_md_8 whcom_text_left_sm whcom_text_center_xs">
                        <div class="domain_result">
                            <div class="domain_message">
                                <?php echo $result_details['message'] ?>
                            </div>
                            <div class="domain_name">
                                <input type="hidden" name="domain" value="<?php echo $result_details['domain'] ?>">
                                <span class="whcom_text_2x">
									<?php echo $result_details['domain'] ?>
								</span>
                            </div>
                        </div>
                    </div>
                    <div class="whcom_col_md_4 whcom_text_center_xs whcom_text_right_md">
                        <div class="domain_price whcom_text_2x">
                            <?php if ( ! empty( $params['show_price'] ) && strtolower( $params['show_price'] ) != 'no' && strtolower( $params['show_price'] ) != '0' ) { ?>
                                <?php if ( $result_details['available'] ) { ?>
                                    <?php if ( ! empty( $result_details['multi_price'] ) && is_array( $result_details['multi_price'] ) ) {
                                        $duration_display = '';
                                        ?>
                                        <?php foreach ( $result_details['multi_price'] as $duration => $price_details ) { ?>
                                            <label class="domain_price_text duration<?php echo (int) $duration; ?>" <?php echo $duration_display ?>>
                                                <?php echo $price_details['price'] ?>
                                            </label>
                                            <?php $duration_display = 'style = "display: none"'; ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <div class="domain_duration whcom_form_field whcom_margin_bottom_0">
                            <?php if ( ! empty( $params['show_years'] ) && strtolower( $params['show_years'] ) != 'no' && strtolower( $params['show_years'] ) != '0' ) { ?>
                                <?php if ( $result_details['available'] ) { ?>
                                    <?php if ( ! empty( $result_details['multi_price'] ) && is_array( $result_details['multi_price'] ) ) { ?>
                                        <?php if ( count( $result_details['multi_price'] ) > 1 ) { ?>
                                            <div class="whcom_radio_container whcom_fancy_select_2">
                                                <select name="regperiod" title="Select Duration" class="domain_duration_select">
                                                    <?php foreach ( $result_details['multi_price'] as $duration => $price_details ) { ?>
                                                        <option value="<?php echo (int) $duration; ?>">
                                                            <?php echo $duration ?>
                                                            <?php echo ( $duration == 1 ) ? esc_html__( 'Year', 'whmpress' ) : esc_html__( 'Years', 'whmpress' ); ?>
                                                        </option>

                                                    <?php } ?>
                                                </select>
                                            </div>
                                        <?php } else { ?>
                                            <?php foreach ( $result_details['multi_price'] as $duration => $price_details ) { ?>
                                                <input type="hidden" name="regperiod"
                                                       value="<?php echo (int) $duration; ?>">
                                                <span class="domain_duration_text duration<?php echo (int) $duration; ?>">
													<?php echo $duration ?>
                                                    <?php echo ( $duration == 1 ) ? esc_html__( 'Year', 'whmpress' ) : esc_html__( 'Years', 'whmpress' ); ?>
												</span>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <div class="domain_actions whcom_form_field">
                            <?php if ( ! empty( $result_details['multi_price'] ) && is_array( $result_details['multi_price'] ) ) { ?>
                                <?php if ( $result_details['available'] ) { ?>
                                    <input type="hidden" name="domaintype" value="register">
                                    <button class="whcom_button whcom_button_primary whcom_op_add_domain_whmp">
                                        <?php echo $params['order_button_text'] ?>
                                    </button>
                                    <span class="whcom_pill_filled_success whcom_op_added_domain_whmp"
                                          style="display: none">
										<?php echo $params['added_button_text'] ?>
									</span>
                                    <a href="#" class="whcom_op_remove_domain_whmp" style="display: none">
                                        <i class="whcom_icon_cancel"></i>
                                    </a>
                                <?php } else { ?>
                                    <?php if ( ! empty( $params['enable_transfer_link'] ) && strtolower( $params['enable_transfer_link'] ) == 'yes' ) { ?>
                                        <input type="hidden" name="domaintype" value="transfer">
                                        <button class="whcom_button whcom_button_primary whcom_op_add_domain_whmp">
                                            <?php echo $params['transfer_button_text'] ?>
                                        </button>
                                        <span class="whcom_pill_filled_success whcom_op_added_domain_whmp"
                                              style="display: none">
											<?php echo $params['added_button_text'] ?>
										</span>
                                        <a href="#" class="whcom_op_remove_domain_whmp" style="display: none">
                                            <i class="whcom_icon_cancel"></i>
                                        </a>
                                    <?php } ?>
                                    <?php if ( ! empty( $params['whois_link'] ) && strtolower( $params['whois_link'] ) == 'yes' ) { ?>
                                        <a class="whcom_button whcom_button_primary whcom_op_add_remove_domain_whmp" onclick="openWhois('<?php echo $result_details['whois_link'] ?>')">
                                            <?php echo $params['whois_button_text'] ?>
                                        </a>
                                    <?php } ?>
                                    <?php if ( ! empty( $params['www_link'] ) && strtolower( $params['www_link'] ) == 'yes' ) { ?>
                                        <a class="whcom_button whcom_button_primary" target="_blank" href="http://<?php echo $result_details['domain'] ?>">
                                            <?php echo $params['www_button_text'] ?>
                                        </a>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="whmpress_domain_search_ajax_extended_search_result whcom_op_whmp_domain_container results_loaded">
            <input type="hidden" name="cart_index" value="-1">
            <div class="domain_result whcom_text_center whcom_text_left_sm">
                <div class="domain_name">
                    <input type="hidden" name="domain" value="<?php echo $result_details['domain'] ?>">
                    <strong>
                        <?php echo $result_details['domain'] ?>
                    </strong>
                </div>
                <div class="domain_message <?php echo ( $result_details['available'] ) ? 'whcom_text_success': 'whcom_text_danger'; ?>">
                    <?php echo $result_details['message'] ?>
                </div>
            </div>
            <div class="domain_duration whcom_text_center whcom_text_left_sm whcom_form_field">
                <?php if ( ! empty( $params['show_years'] ) && strtolower( $params['show_years'] ) != 'no' && strtolower( $params['show_years'] ) != '0' ) { ?>
                    <?php if ( $result_details['available'] ) { ?>
                        <?php if ( ! empty( $result_details['multi_price'] ) && is_array( $result_details['multi_price'] ) ) { ?>
                            <?php if ( count( $result_details['multi_price'] ) > 1 ) { ?>
                                <div class="whcom_radio_container whcom_fancy_select_2">
                                    <select name="regperiod" title="Select Duration" class="domain_duration_select">
                                        <?php foreach ( $result_details['multi_price'] as $duration => $price_details ) { ?>
                                            <option value="<?php echo (int) $duration; ?>">
                                                <?php echo $duration ?>
                                                <?php echo ( $duration == 1 ) ? esc_html__( 'Year', 'whmpress' ) : esc_html__( 'Years', 'whmpress' ); ?>
                                            </option>

                                        <?php } ?>
                                    </select>
                                </div>
                            <?php } else { ?>
                                <?php foreach ( $result_details['multi_price'] as $duration => $price_details ) { ?>
                                    <input type="hidden" name="regperiod" value="<?php echo (int) $duration; ?>">
                                    <label class="domain_duration_text duration<?php echo (int) $duration; ?>">
                                        <?php echo $duration ?>
                                        <?php echo ( $duration == 1 ) ? esc_html__( 'Year', 'whmpress' ) : esc_html__( 'Years', 'whmpress' ); ?>
                                    </label>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="domain_price whcom_text_center whcom_text_left_sm whcom_form_field">
                <?php if ( ! empty( $params['show_price'] ) && strtolower( $params['show_price'] ) != 'no' && strtolower( $params['show_price'] ) != '0' ) { ?>
                    <?php if ( $result_details['available'] ) { ?>
                        <?php if ( ! empty( $result_details['multi_price'] ) && is_array( $result_details['multi_price'] ) ) {
                            $duration_display = '';
                            ?>
                            <?php foreach ( $result_details['multi_price'] as $duration => $price_details ) { ?>
                                <label class="domain_price_text duration<?php echo (int) $duration; ?>" <?php echo $duration_display ?>>
                                    <?php echo $price_details['price'] ?>
                                </label>
                                <?php $duration_display = 'style = "display: none"'; ?>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="domain_actions whcom_text_center whcom_text_right_sm">
                <?php if ( ! empty( $result_details['multi_price'] ) && is_array( $result_details['multi_price'] ) ) { ?>
                    <?php if ( $result_details['available'] ) { ?>
                        <input type="hidden" name="domaintype" value="register">
                        <button class="whcom_button whcom_button_primary whcom_op_add_domain_whmp">
                            <?php echo $params['order_button_text'] ?>
                        </button>
                        <span class="whcom_pill_filled_success whcom_op_added_domain_whmp"
                              style="display: none">
							<?php echo $params['added_button_text'] ?>
						</span>
                        <a href="#" class="whcom_op_remove_domain_whmp" style="display: none">
                            <i class="whcom_icon_cancel"></i>
                        </a>
                    <?php } else { ?>
                        <?php if ( ! empty( $params['enable_transfer_link'] ) && strtolower( $params['enable_transfer_link'] ) == 'yes' ) { ?>
                            <input type="hidden" name="domaintype" value="transfer">
                            <button class="whcom_button whcom_button_primary whcom_op_add_domain_whmp">
                                <?php echo $params['transfer_button_text'] ?>
                            </button>
                            <span class="whcom_pill_filled_success whcom_op_added_domain_whmp" style="display: none">
								<?php echo $params['added_button_text'] ?>
							</span>
                            <a href="#" class="whcom_op_remove_domain_whmp" style="display: none">
                                <i class="whcom_icon_cancel"></i>
                            </a>
                        <?php } ?>
                        <?php if ( ! empty( $params['whois_link'] ) && strtolower( $params['whois_link'] ) == 'yes' ) { ?>
                            <a class="whcom_button whcom_button_primary whcom_op_add_remove_domain_whmp" onclick="openWhois('<?php echo $result_details['whois_link'] ?>')">
                                <?php echo $params['whois_button_text'] ?>
                            </a>
                        <?php } ?>
                        <?php if ( ! empty( $params['www_link'] ) && strtolower( $params['www_link'] ) == 'yes' ) { ?>
                            <a class="whcom_button whcom_button_primary" target="_blank" href="http://<?php echo $result_details['domain'] ?>">
                                <?php echo $params['www_button_text'] ?>
                            </a>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    No Details found!
<?php } ?>


