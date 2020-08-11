<?php
$ctable_name = whmp_get_countries_table_name();
// Creating IP Tables for country detection.
$Q = "CREATE TABLE {$ctable_name} (
    id int(11) NOT NULL AUTO_INCREMENT,
    country_code varchar(2) NOT NULL default '',
    country_name varchar(100) NOT NULL default '',
    UNIQUE KEY id (id)
) " . $charset_collate;
dbDelta( $Q );

#Inserting countries.
if ( $wpdb->get_var( "SELECT COUNT(*) FROM `$ctable_name`" ) == "0" ) {
	global $wp_filesystem;
	if ( empty( $wp_filesystem ) ) {
		require_once( ABSPATH . '/wp-admin/includes/file.php' );
		WP_Filesystem();
	}
	
	$_countries = whmp_read_local_file( dirname( __FILE__ ) . "/countries.sql" );
	$_countries = str_replace( "INSERT INTO `countries`", "INSERT INTO `$ctable_name`", $_countries );
	$_countries = explode( "\n", $_countries );
	foreach ( $_countries as $_country ) {
		$wpdb->query( $_country );
	}
}