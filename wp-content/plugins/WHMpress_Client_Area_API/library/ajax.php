<?php
//global $W;
//$W = new WCAP();

switch ( $_POST["what"] ) {
	case "validate_login":
		$response = $this->validate_whmcs_user( $_POST );
		//unset($response['data']);

        $data=json_encode($response,JSON_FORCE_OBJECT);
        echo $data;
		break;
	case "whmcs_logout":
		$response = $this->whmcs_logout();

		if ( $response ) {
			echo "OK";
			//include_once $this->Path . "/views/login.php";
		} else {
			echo "Can't logout";
		}
		break;
	case "load_services_page":
		//include_once( $this->Path . "/views/services.php" );
		break;
	case "load_domains_page":
		//include_once $this->Path . "/views/domains.php";
		break;
	case "load_tickets_page":
		//include_once $this->Path . "/views/tickets.php";
		break;
	case "load_invoices_page":
		//include_once $this->Path . "/views/invoices.php";
		break;
	case "load_page":
	case "load_data":
		## By pass login check for these pages.
		$by_pass_login_check = [
			//--- Frontend only URLs
			"create_client_account",
			"password_reset",
			"password_reset_final",
			"password_reset_update",
			"logged_out",
			//--- Frontend + Backend common URLs
			"announcements",
			"knowledgebase",
			"network_status",
			"contact",
			"order_new_service",
			"add_service_page",
            "order_process",
			"domain_register",
            "domain_service",
            "domain_transfer",
			"order_process",
            "logged_out",
            "kb_articles",
		];

		if ( ! in_array( $_POST["page"], $by_pass_login_check ) && ! whcom_is_client_logged_in() ) {
			$_POST["page"] = "login";
		}

		if ( $_POST["page"] == "login" && whcom_is_client_logged_in() ) {
			$_POST["page"] = "dashboard";
		}

		if ( whcom_is_client_logged_in() && $_POST["page"] == "logout" ) {
			$_POST["page"] = "login";
		}

		if ( ! is_file( $this->Path . "/views/" . $_POST["page"] . ".php" ) ) {
			$_POST["page"] = "404";
		}

		if ( substr( $_POST["page"], - 4 ) <> ".php" ) {
			$_POST["page"] .= ".php";
		}

		$_SESSION["WMPCA_page"] = $_POST["page"];

		$file_path = $this->Path . "/views/" . $_POST["page"];
		if ( ! is_file( $file_path ) ) {
			$file_path = $this->Path . "/views/404.php";
		}

		include_once( $file_path );
		break;
	case "update_client_profile":
		echo $this->update_client( $_POST );
		break;
	case "update_client_password":
		echo $this->update_client_password( $_POST );
		break;
	case "update_whmcs_client_password":
		echo $this->reset_client_password( $_POST );
		exit;
		break;
	case "register_new_client":
		echo $this->register_new_client( $_POST );
		break;
	case "add_new_contact":
		echo $this->add_clients_contact( $_POST );
		break;
	case "choose_contact":
		include_once $this->Path . "/views/contacts.php";
		break;
	case "update_contact":
		if ( ( ! empty( $_POST['delete_contact'] ) ) && ( $_POST['delete_contact'] == 'yes' ) ) {
			echo $this->delete_contact( $_POST );
		} else {
			echo $this->update_contact( $_POST );
		}
		break;
	case "ticket_form":
		include_once $this->Path . "/views/open_ticket2.php";
		break;
	case "open_new_ticket":
		$_POST["clientid"] = whcom_get_current_client_id();

		echo $this->open_ticket( $_POST );
		break;
	case "reply_ticket":
		echo $this->reply_ticket( $_POST );

		break;
	/*case "load_data":
		echo $this->load_data( $_POST );

		break;*/
	case "add_order":
		$response = $this->add_order( $_POST );
		if ( is_array( $response ) ) {
			echo json_encode( $response );
		} else {
			echo $response;
		}
		break;
	case "add_order_to_cart":
		echo $this->add_to_cart( $_POST );
		break;
	case "add_order_to_whmcs":
		$response = $this->add_order_from_cart( $_POST );

		if ( isset( $response["invoiceid"] ) ) {
			$this->empty_cart();
		}

		if ( is_array( $response ) ) {
			echo json_encode( $response );
		} else {
			echo $response;
		}

		break;
	case "remove_cart_time":
		echo $this->remove_cart_item( $_POST["key"] );
		break;
	case "domain_whois":
		if ( isset( $_POST["domain"] ) ) {
			$_SESSION["last_checked_domain"]         = $_POST["domain"];
			$_SESSION["last_checked_domain_paytype"] = $_POST["paytype"];
		}
		$response                              = $this->check_domain_whois( $_POST );
		$_SESSION["wcap_domain_whois_checked"] = $_POST["domain"];


		//todo: make a proper place for this array

		if ( $response["status"] == "available" ) {
			$response["domain_price"]      = $this->get_whmcs_domains( [
				"extension" => $this->get_domain_extension( $_POST["domain"] ),
			] );
			$response["domain_price"]      = $response["domain_price"]['data'][ $this->get_domain_extension( $_POST["domain"] ) ]["domainregister"];
			$response["domain_price_html"] = "";
			$currs                         = $this->get_currencies();
			$prefix                        = "";
			foreach ( $currs as $curr ) {
				if ( $response["domain_price"]["currency"] == $curr["id"] ) {
					$prefix = $curr["prefix"];
					$cur_id = $curr["id"];
					break;
				}

			}


			$response["domain_price_html"] = "<input name='currency' value='{$cur_id}' type='hidden'>";
			$response["domain_price_html"] .= "<div class='whcom_form_field whcom_form_field_horizontal whcom_text_left'>";
			$response["domain_price_html"] .= "<label>" . esc_html__( 'Continue to register this domain for', 'whcom' ) . "</label> ";
			$response["domain_price_html"] .= "<select name='billingcycle' class='wcap_billingcycle'>";
			foreach ( $this->YearPeriods as $key=>$field ) {
				if ( (float)$response["domain_price"][ $field ] > 0 ) {
					$response["domain_price_html"] .= "<option value='{$field}'>" . $prefix . $response["domain_price"][ $field ] . "/" . ( $key + 1 ) . " Year" . "</option>";
				}
			}
			$response["domain_price_html"] .= "</select></div>";
		}


		echo json_encode( $response);
		break;
	case "configurable_options_html":
		$product = $this->get_whmcs_products( "pid=" . $_POST["pid"] );
		if ( ! isset( $product['data'][0] ) ) {
			echo __( "Product not found in database", "whcom" );
			exit;
		}
		$product = $product['data'][0];

		if ( isset( $_POST["configoption"] ) && is_array( $_POST["configoption"] ) ) {
			$config_html        = $this->display_order_configurable_options_html( $product, $_POST["billingcycle"], $_POST["configoption"] );
			$order_summary_html = $this->display_order_summary_html( $product, $_POST["billingcycle"], $_POST["configoption"] );
		} else {
			$config_html        = $this->display_order_configurable_options_html( $product, $_POST["billingcycle"] );
			$order_summary_html = $this->display_order_summary_html( $product, $_POST["billingcycle"] );
		}

		echo json_encode( [
			"config_html"        => $config_html,
			"order_summary_html" => $order_summary_html,
			"prices"             => $this->calculate_prices_by_product_row( $product, $_POST["billingcycle"], $_POST["configoption"] ),
		] );
		break;
	case "domain_own_check":
		if ( ! isset( $_POST["domain"] ) ) {
			echo __( "Find your new domain name. Enter your name or keywords below to check availability.", "whcom" );
			exit;
		}

		if ( ! $this->is_domain_valid( $_POST["domain"] ) ) {
			echo __( "Please enter a Valid Domain Name", "whcom" );
			exit;
		}

		$_SESSION["last_checked_domain"]         = $_POST["domain"];
		$_SESSION["last_checked_domain_paytype"] = "domainown";
		echo "OK";
		break;
	case "registerdomain":
		$_POST["domain"] = $_SESSION["wcap_domain_whois_checked"];

		//return $_SESSION["wcap_domain_whois_checked"];

		$ext       = $this->get_domain_extension( $_POST['domain'] );

		$dom_price = $this->get_whmcs_domains( "extension=$ext&currency=" . $_POST["currency"] );

		$dom_price = $dom_price['data'][ $ext ]["domainregister"];
		$cart = $this->get_cart();
		$currs  = $this->get_currencies();
		$prefix = $suffix = "";
		foreach ( $currs as $curr ) {
			if ( $_POST["currency"] == $curr["id"] ) {
				$prefix = $curr["prefix"];
				$suffix = $curr["suffix"];
				break;
			}
		}
		$cart[] = [
			"type"         => "domain",
			"paytype"      => "domainregister",
			"billingcycle" => $_POST["billingcycle"],
			"name"         => $_SESSION["wcap_domain_whois_checked"],
			"description"  => "",
			"price"        => $dom_price[ $_POST["billingcycle"] ],
			"prefix"       => $prefix,
			"suffix"       => $suffix,
			"setup"        => 0,
		];

		$_SESSION["wcap_cart"] = $cart;

		echo "OK";
		break;
	case "transferdomain":
       // $_POST["domain"] = $_SESSION["wcap_domain_whois_checked"];
		$ext = $this->get_domain_extension( $_POST["domain"] );
		if ( ! isset( $_POST["currency"] ) ) {
			$_POST["currency"] = whcom_get_current_currency_id();
		}
		$dom_price = $this->get_whmcs_domains( "extension=$ext&currency=" . $_POST["currency"] );
		$dom_price = $dom_price['data'][ $ext ]["domaintransfer"];


		$cart = $this->get_cart();

		$currs = $this->get_currencies();

		if ( ! isset( $_POST["billingcycle"] ) ) {
			$_POST["billingcycle"] = "1";
		}

		$prefix = $suffix = "";
		foreach ( $currs as $curr ) {
			if ( $_POST["currency"] == $curr["id"] ) {
				$prefix = $curr["prefix"];
				$suffix = $curr["suffix"];
				break;
			}
		}

		$cart[] = [
			"name"         => $_POST["domain"],
			"type"         => "domain",
			"paytype"      => "domaintransfer",
			"billingcycle" => $_POST["billingcycle"],
			"description"  => "",
			"price"        => $dom_price["msetupfee"],
			"prefix"       => $prefix,
			"suffix"       => $suffix,
			"setup"        => 0,
		];

		$_SESSION["wcap_cart"] = $cart;

		echo "OK";
		break;
	case "domain_renew_modal":
		if ( ! isset( $_POST['domain'] ) ) {
			echo __( "No domain name found to renew", "whcom" );
			exit;
		}
		$ext = $this->get_domain_extension( $_POST['domain'] );

		$dom_price = $this->get_whmcs_domains( "extension=$ext" );
		if ( ! isset( $dom_price[ $ext ]["domainrenew"] ) ) {
			echo __( "System can't process domain renew", "whcom" );
		}

		$curr = $this->get_currency();

		$options = "";
		foreach ( $this->YearPeriods as $key => $field ) {
			if ( $dom_price[ $ext ]["domainrenew"][ $field ] > 0 ) {
				$options .= "<option value='" . ( $key + 1 ) . "'>" . ( $key + 1 ) . " Years / " . $curr["prefix"] . $dom_price[ $ext ]["domainrenew"][ $field ] . "</option>";
			}
		}

		echo <<<EOT
		<form id="domain_renew_form">
			Renew Domain <b>{$_POST["domain"]}</b><hr>
			<input type='hidden' name='action' value='{$_POST["action"]}'>
			<input type='hidden' name='what' value='domain_renew'>
			<input type='hidden' name='domainid' value='{$_POST["domainid"]}'>
			<input type='hidden' name='domain' value='{$_POST["domain"]}'>
			
			<select name="regperiod">
				$options
			</select>
			<button class="button">Renew</button>
		</form>
EOT;
		//echo $this->renew_domain( $_POST );
		break;
	case "domain_renew":
		echo $this->renew_domain( $_POST );
		break;

	case "domain_renewal_order":
		echo $this->domain_renewal_order( $_POST );
		break;
	case "update_donotrenew_status":
		print_r( $this->update_donotrenew_status( $_POST["domainid"], $_POST["status"] ) );
		break;
	case "add_addon_order":
		if ( empty( $_POST["addonids"] ) ) {
			echo __( "The following addons are available for this product. Choose the addons you wish to order below", "whcom" );
			exit;
		}
		if ( empty( $_POST["serviceid"] ) ) {
			echo __( "Please provide serviceid", "whcom" );
			exit;
		}
		unset( $_POST["action"] );
		unset( $_POST["what"] );
		foreach ( $_POST["addonids"] as $addonid ) {
			$_POST["serviceids"][] = $_POST["serviceid"];
		}
		unset( $_POST["serviceid"] );

		$response = $this->add_order( $_POST );
		if ( isset( $response["invoiceid"] ) ) {
			echo "OK" . $response["invoiceid"];
		} else {
			if ( is_array( $response ) ) {
				echo json_encode( $response );
			} else {
				echo $response;
			}
		}
		break;
	case "add_addon_order2":
		## Adding addon id in cart.
		if ( empty( $_POST["addonid"] ) ) {
			echo __( "The following addons are available for this product. Choose the addons you wish to order below", "whcom" );
			exit;
		}
		if ( empty( $_POST["serviceid"] ) ) {
			echo __( "Please provide serviceid", "whcom" );
			exit;
		}
		$array                 = $this->make_array( $_POST["serviceid"] );
		$_POST["serviceid"]    = $array[0];
		$_POST["billingcycle"] = @$array[1];
		unset( $_POST["action"], $_POST["what"] );

		echo $this->add_to_cart( $_POST );
		break;
	case "update_auto_renew_status":
		echo $this->update_auto_renew_status( $_POST );
		break;
	case "update_registrar_lock_status":
		echo $this->update_registrar_lock_status( $_POST );
		break;
	case "update_dns_servers":
		echo $this->update_domain_nameservers_i( $_POST );
		break;
	case "update_wohis_info":
		echo $this->set_domain_whois_info( $_POST );
		break;
	case "validate_coupon":
		$_SESSION["wcap_coupon"] = $_POST["code"];
		echo $this->validate_code_from_cart();
		break;
	case "remove_coupon":
		$this->remove_coupon_from_cart();
		break;
	case "epp_code":
		echo 'Domain EPP Code: <input type="text" disabled="disabled" value="' . $this->get_domain_epp_code( "domainid=" . $_POST["domainid"] ) . '">';
		break;
	case "calculate_updowngrade":
		//$_POST["calconly"] = true;

		//echo $this->update_service_product($_POST);
		break;
	case "calculate_updowngrade_options":
		//$_POST["calconly"] = true;

		//echo $this->update_service_product($_POST);
		break;
	case "updowngrade_product":
		echo wcap_updowngrade_service( $_POST );
		break;

	case "updowngrade_product_options":

		echo wcap_updowngrade_options( $_POST );
		break;

	case "add_request_cancel":
		$response = $this->add_request_cancel( $_POST );

		if ( is_array( $response ) ) {
			echo json_encode( $response );
		} else {
			echo $response;
		}

		break;
	case "reset_password_email":

		//check if user exists in WHMCS

		$response = $this->is_whmcs_user_exists( $_POST["email"] );

		if ( $response == "success" ) {
			echo $this->send_reset_password_email( @$_POST["email"], @$_POST["url"] );
		} else {
			echo $response;
		}

		break;
	case "submit_contact_form":
		$response = $this->submit_contact_form($_POST);
		$response['post'] = $_POST;
		echo json_encode($response, JSON_FORCE_OBJECT);
		exit;
	case "update_security_question":
		echo $this->update_security_questions( $_POST );

		exit;
	case "update_credit_card":
		echo $this->update_credit_card( $_POST );

		exit;
	case "mass_payment":
		$response = $this->pay_mass_payment( $_POST );

		echo json_encode( $response, JSON_FORCE_OBJECT );
		break;
	case "upate_domain_config":
		$carts = $this->get_cart();

		foreach ( $carts as $key => &$cart ) {
			if ( $cart["type"] <> "domain" ) {
				continue;
			}
			$cart["nameserver1"] = isset( $_POST["nameserver1"] ) ? $_POST["nameserver1"] : "";
			$cart["nameserver2"] = isset( $_POST["nameserver2"] ) ? $_POST["nameserver2"] : "";
			$cart["nameserver3"] = isset( $_POST["nameserver3"] ) ? $_POST["nameserver3"] : "";
			$cart["nameserver4"] = isset( $_POST["nameserver5"] ) ? $_POST["nameserver4"] : "";
			$cart["nameserver4"] = isset( $_POST["nameserver5"] ) ? $_POST["nameserver5"] : "";

			$cart["dnsmanagement"]   = empty( $_POST["dnsmanagement"][ $key ] ) ? false : true;
			$cart["emailforwarding"] = empty( $_POST["emailforwarding"][ $key ] ) ? false : true;
			$cart["idprotection"]    = empty( $_POST["idprotection"][ $key ] ) ? false : true;
		}

		$_SESSION["wcap_cart"] = $carts;
		echo "OK";
		break;
	case "loggedin":
		if ( $_SESSION["WMPCA_page"] == "login.php" ) {
			echo "OK";
			break;
		}
		if ( ! isset( $_SESSION["whcom_reloaded"] ) && ! whcom_is_client_logged_in() ) {
			$_SESSION["whcom_reloaded"] = 1;
			echo "RELOAD";
		} else {
			echo "OK";
		}
		break;
}


die();