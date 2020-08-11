<?php
$domain = isset( $_GET["domain"] ) ? $_GET["domain"] : "";
if ( $domain == "" ) {
	die( "Domain missing." );
}
$Wp_load = realpath( dirname( __FILE__ ) . '/../../../wp-load.php' );
if ( ! is_file( $Wp_load ) ) {
	die( "WordPress library not found." );
}
require_once( $Wp_load );
include_once( WHMP_PLUGIN_DIR . "/includes/whois.class.php" );
$whois = new Whois;

$domain = ltrim( $domain, '//' );
if ( substr( strtolower( $domain ), 0, 7 ) == "http://" ) {
	$domain = substr( $domain, 7 );
}
if ( substr( strtolower( $domain ), 0, 8 ) == "https://" ) {
	$domain = substr( $domain, 8 );
}
$domain = "http://" . $domain;
$domain = parse_url( $domain );
if ( strtolower( substr( $domain["host"], 0, 4 ) ) == "www." ) {
	$domain["host"] = substr( $domain["host"], 4 );
}
if ( strtolower( substr( $domain["host"], 0, 3 ) ) == "ww." ) {
	$domain["host"] = substr( $domain["host"], 3 );
}

$domain["extension"] = whmp_get_domain_extension( $domain["host"] );
if ( $domain["extension"] == "" ) {
	$domain["host"] .= ".com";
	$domain["extension"] = "com";
}
$result = $whois->whoislookup( $domain["host"], $domain["extension"], true );
echo "<pre>";
echo $result;
echo "</pre>";
?>