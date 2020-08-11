<?php
/**
 * Copyright (c) 2014-2016 by creativeON.
 */

$last_synced = get_option("sync_time");
$site_url = get_site_url();
if ($last_synced == "") {
    echo "<div style='color: red;' '>WHMCS is not yet synced</div>";
    echo "<div><a href='$site_url/wp-admin/admin.php?page=whmp-sync'>Click here to Sync</a></div>";
}

$uurl = get_option( 'client_area_page_url' );
if ( is_numeric( $uurl ) ) {
	$uurl = get_page_link( $uurl );
} else {
	$uurl = get_bloginfo( "url" ) . "/" . get_option( 'client_area_page_url' );
}
$html = "";

$WHMPress = new WHMpress();

switch ( strtolower( $type ) ) {
	case "client_area":
		if ( is_active_cap() ) {
			$html .= $uurl;
		} else {
			$url = whmpress_get_option( 'client_area_url' );
			if ( $url == "" ) {
				$url = whmp_get_installation_url();
			}
			$html .= $url;
		}
		break;
	case "announcements":
		if ( is_active_cap() ) {
			if ( $WHMPress_Client_Area->is_permalink() ) {
				$html .= rtrim( $uurl, "/" ) . "/announcements/";
			} else {
				$html .= $uurl . "?whmpca=announcements";
			}
		} else {
			$url = whmpress_get_option( 'announcements_url' );
			if ( $url == "" ) {
				$url = whmp_get_installation_url() . "/announcements.php";
			}
			$html .= $url;
		}
		break;
	case "submit_ticket":
		if ( is_active_cap() ) {
			if ( $WHMPress_Client_Area->is_permalink() ) {
				$html .= rtrim( $uurl, "/" ) . "/submitticket/";
			} else {
				$html .= $uurl . "?whmpca=submitticket";
			}
		} else {
			$url = whmpress_get_option( 'submit_ticket_url' );
			if ( $url == "" ) {
				$url = whmp_get_installation_url() . "/submitticket.php";
			}
			$html .= $url;
		}
		break;
	case "downloads":
		if ( is_active_cap() ) {
			if ( $WHMPress_Client_Area->is_permalink() ) {
				$html .= rtrim( $uurl, "/" ) . "/downloads/";
			} else {
				$html .= $uurl . "?whmpca=downloads";
			}
		} else {
			$url = whmpress_get_option( 'downloads_url' );
			if ( $url == "" ) {
				$url = whmp_get_installation_url() . "/downloads.php";
			}
			$html .= $url;
		}
		break;
	case "support_tickets":
		if ( is_active_cap() ) {
			if ( $WHMPress_Client_Area->is_permalink() ) {
				$html .= rtrim( $uurl, "/" ) . "/submitticket/";
			} else {
				$html .= $uurl . "?whmpca=submitticket";
			}
		} else {
			$url = whmpress_get_option( 'support_tickets_url' );
			if ( $url == "" ) {
				$url = whmp_get_installation_url() . "/supporttickets.php";
			}
			$html .= $url;
		}
		break;
	case "knowledgebase":
		if ( is_active_cap() ) {
			if ( $WHMPress_Client_Area->is_permalink() ) {
				$html .= rtrim( $uurl, "/" ) . "/knowledgebase/";
			} else {
				$html .= $uurl . "?whmpca=knowledgebase";
			}
		} else {
			$url = whmpress_get_option( 'knowledgebase_url' );
			if ( $url == "" ) {
				$url = whmp_get_installation_url() . "/knowledgebase.php";
			}
			$html .= $url;
		}
		break;
	case "affiliates":
		if ( is_active_cap() ) {
			if ( $WHMPress_Client_Area->is_permalink() ) {
				$html .= rtrim( $uurl, "/" ) . "/affiliates/";
			} else {
				$html .= $uurl . "?whmpca=affiliates";
			}
		} else {
			$url = whmpress_get_option( 'affiliates_url' );
			if ( $url == "" ) {
				$url = whmp_get_installation_url() . "/affiliates.php";
			}
			$html .= $url;
		}
		break;
	case "order":
		$html .= $WHMPress->get_whmcs_url( "order" );
		break;
	case "contact_url":
		if ( is_active_cap() ) {
			if ( $WHMPress_Client_Area->is_permalink() ) {
				$html .= rtrim( $uurl, "/" ) . "/contact/";
			} else {
				$html .= $uurl . "?whmpca=contact";
			}
		} else {
			$url = whmpress_get_option( 'pre_sales_contact_url' );
			if ( $url == "" ) {
				$url = whmp_get_installation_url() . "/contact.php";
			}
			$html .= $url;
		}
		break;
	case "domain_checker":
		$html .= $WHMPress->get_whmcs_url( "domainchecker" );
		break;
	case "server_status":
		if ( is_active_cap() ) {
			if ( $WHMPress_Client_Area->is_permalink() ) {
				$html .= rtrim( $uurl, "/" ) . "/serverstatus/";
			} else {
				$html .= $uurl . "?whmpca=serverstatus";
			}
		} else {
			$url = whmpress_get_option( 'server_status_url' );
			if ( $url == "" ) {
				$url = whmp_get_installation_url() . "/serverstatus.php";
			}
			$html .= $url;
		}
		break;
	case "network_issues":
		if ( is_active_cap() ) {
			if ( $WHMPress_Client_Area->is_permalink() ) {
				$html .= rtrim( $uurl, "/" ) . "/networkissues/";
			} else {
				$html .= $uurl . "?whmpca=networkissues";
			}
		} else {
			$url = whmpress_get_option( 'network_issues_url' );
			if ( $url == "" ) {
				$url = whmp_get_installation_url() . "/networkissues.php";
			}
			$html .= $url;
		}
		break;
	case "whmcs_login":
	case "loginurl":
	case "login":
		$html .= $WHMPress->get_whmcs_url( "loginurl" );
		break;
	case "whmcs_register":
		if ( is_active_cap() ) {
			if ( $WHMPress_Client_Area->is_permalink() ) {
				$html .= rtrim( $uurl, "/" ) . "/register/";
			} else {
				$html .= $uurl . "?whmpca=register";
			}
		} else {
			$url = whmpress_get_option( 'whmcs_register_url' );
			$html .= $url;
		}
		break;
	case "whmcs_forget_password":
		if ( is_active_cap() ) {
			if ( $WHMPress_Client_Area->is_permalink() ) {
				$html .= rtrim( $uurl, "/" ) . "/pwreset/";
			} else {
				$html .= $uurl . "?whmpca=pwreset";
			}
		} else {
			$url = whmpress_get_option( 'whmcs_forget_password_url' );
			$html .= $url;
		}
		break;
	default:
		$html .= "#";
}

return $html;
?>