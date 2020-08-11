<?php
$WHMPress = new WHMpress();
?>
<div class="settings-wrap">
    <div id="whmp-dsearch-tabs" class="tab-container">
        <ul class='etabs'>
            <li class="tab"><a href="#SearchOptions"><?php echo esc_html_x( "Search Options",'admin', "whmpress" ) ?></a></li>
            <li class="tab"><a href="#CustomMessages"><?php echo esc_html_x( "Custom Messages",'admin', "whmpress" ) ?></a></li>
            <li class="tab"><a href="#WhoIsServers"><?php echo esc_html_x( "WhoIs Servers",'admin', "whmpress" ) ?></a></li>
        </ul>

        <div id="SearchOptions">
            <h3><?php echo esc_html_x( "Search Options",'admin', "whmpress" ) ?></h3>
            <table class="form-table">
                <tr valign="top">
                    <td style="width:30%;" scope="row"><?php echo esc_html_x( "Enable logs for searches",'admin', "whmpress" ) ?></td>
                    <td>
                        <select name="enable_logs">
                            <option value="0">No</option>
                            <option
                                    value="1" <?php echo get_option( 'enable_logs' ) == "1" ? "selected=selected" : ""; ?>>
                                Yes
                            </option>
                        </select>
                    </td>
                </tr>
				<?php if ( defined( 'WHCOM_VERSION' ) ) { ?>
                    <tr valign="top">
                        <td style="width:30%;" scope="row">
                            <?php echo esc_html_x( "Use WHMCS API for domain search",'admin', "whmpress" ) ?>
                        </td>
                        <td>
                            <select name="use_whmcs_domain_search" title="Use WHMCS API for domain search">
                                <option value="0">No</option>
                                <option
                                        value="1" <?php echo get_option( 'use_whmcs_domain_search' ) == "1" ? "selected=selected" : ""; ?>>
                                    Yes
                                </option>
                            </select>
                        </td>
                    </tr>
				<?php } ?>
                <tr valign="top">
                    <td style="width:30%;"
                        scope="row"><?php echo esc_html_x( "Number of domains to show in load more page",'admin', "whmpress" ) ?></td>
                    <td><input type="number" style="width:100%;" name="no_of_domains_to_show"
                               value="<?php echo esc_attr( get_option( 'no_of_domains_to_show', '2' ) ); ?>"/></td>
                </tr>
                <!--<tr valign="top">
                    <td scope="row"><?php /*_e("TLD orders, (Comma seprated)", "whmpress") */ ?></td>
                    <td><textarea style="width:100%;" rows="5" name="tld_order"><?php /*echo esc_attr( get_option('tld_order') ); */ ?></textarea></td>
                </tr>-->
                <tr>
                    <td></td>
                    <td><?php submit_button(); ?></td>
                </tr>
            </table>
        </div>
        <div id="CustomMessages">
            <h3><?php echo esc_html_x( "Custom Messages",'admin', "whmpress" ) ?></h3>
            <table class="form-table">
                <tr valign="top">
                    <td style="width:30%;" scope="row"><?php echo esc_html_x( "Domain available message",'admin', "whmpress" ); ?></td>
                    <td><input style="width:100%;"
                               name="<?php echo whmpress_process_key_name( 'domain_available_message' ); ?>"
                               value="<?php echo esc_attr( whmpress_get_option( 'domain_available_message' ) ); ?>"/>
                    </td>
                </tr>
                <tr valign="top">
                    <td scope="row"><?php echo esc_html_x( "Domain not available message",'admin', "whmpress" ) ?></td>
                    <td><input style="width:100%;"
                               name="<?php echo whmpress_process_key_name( 'domain_not_available_message' ); ?>"
                               value="<?php echo esc_attr( whmpress_get_option( 'domain_not_available_message' ) ); ?>"/>
                    </td>
                </tr>
                <tr valign="top">
                    <td scope="row"><?php echo esc_html_x( "Recommended domains list message",'admin', "whmpress" ) ?></td>
                    <td><input style="width:100%;"
                               name="<?php echo whmpress_process_key_name( 'domain_recommended_list' ); ?>"
                               value="<?php echo esc_attr( whmpress_get_option( 'domain_recommended_list' ) ); ?>"/>
                    </td>
                </tr>
                <tr valign="top">
                    <td scope="row"><?php echo esc_html_x( "Ongoing domain available message",'admin', "whmpress" ) ?></td>
                    <td><input style="width:100%;"
                               name="<?php echo whmpress_process_key_name( 'ongoing_domain_available_message' ); ?>"
                               value="<?php echo esc_attr( whmpress_get_option( 'ongoing_domain_available_message', esc_html_x( "[domain-name] is available",'admin', "whmpress" ) ) ); ?>"/>
                    </td>
                </tr>
                <tr valign="top">
                    <td scope="row"><?php echo esc_html_x( "Ongoing domain not available message",'admin', "whmpress" ) ?></td>
                    <td><input style="width:100%;"
                               name="<?php echo whmpress_process_key_name( 'ongoing_domain_not_available_message' ); ?>"
                               value="<?php echo esc_attr( whmpress_get_option( 'ongoing_domain_not_available_message', esc_html_x( "[domain-name] is registered",'admin', "whmpress" ) ) ); ?>"/>
                    </td>
                </tr>
                <tr valign="top">
                    <td scope="row"><?php echo esc_html_x( "Register domain button text",'admin', "whmpress" ) ?></td>
                    <td><input style="width:100%;"
                               name="<?php echo whmpress_process_key_name( 'register_domain_button_text' ); ?>"
                               value="<?php echo esc_attr( whmpress_get_option( 'register_domain_button_text', esc_html_x( "Select",'admin', "whmpress" ) ) ); ?>"/>
                    </td>
                </tr>
                <tr valign="top">
                    <td scope="row"><?php echo esc_html_x( "Load more button text",'admin', "whmpress" ) ?></td>
                    <td><input style="width:100%;"
                               name="<?php echo whmpress_process_key_name( 'load_more_button_text' ); ?>"
                               value="<?php echo esc_attr( whmpress_get_option( 'load_more_button_text', esc_html_x( "Load More",'admin', "whmpress" ) ) ); ?>"/>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php submit_button(); ?></td>
                </tr>
            </table>
        </div>
        <div id="WhoIsServers">
            <h3><?php echo esc_html_x( "WhoIs Servers",'admin', "whmpress" ) ?></h3>

            <table class="form-table">
                <tr>
                    <td style="width:30%;" scope="row"><?php echo esc_html_x( "WhoIs Servers",'admin', "whmpress" ) ?></td>
                    <td>
						<textarea style="width:100%;" rows="15"
                                  name="whois_db"><?php echo whmpress_get_option( 'whois_db' ); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php submit_button(); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>