<?php
/**
 * Created by PhpStorm.
 * User: zain
 * Date: 4/15/2020
 * Time: 4:23 PM
 */ ?>
<?php
$tld_tables = [
    "whmpress_tlds",
    "whmpress_tld_categories",
    "whmpress_tld_category_pivot",
];
$tld_tbl_name = $wpdb->prefix . 'whmpress_tlds';
$tld_tbl_categories_name = $wpdb->prefix . 'whmpress_tld_categories';
$tld_tbl_categories_pivot_name = $wpdb->prefix . 'whmpress_tld_category_pivot';

//== drop tables if Exist
foreach ($tld_tables as $tt) {
    $complete_tld_table_name = $wpdb->prefix . $tt;
    $Q = "DROP TABLE IF EXISTS `$complete_tld_table_name`";
    $r = $wpdb->query($Q);
}

//== Creating tlds table
$Q_tld = "CREATE TABLE {$tld_tbl_name} (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tld` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  UNIQUE KEY id (id)
)" . $charset_collate;
dbDelta($Q_tld);

//== Inserting tlds.
if ( $wpdb->get_var( "SELECT COUNT(*) FROM `$tld_tbl_name`" ) == "0" ) {
    $insert__tld__query = whmp_read_local_file( dirname( __FILE__ ) . "/tlds.sql" );
    $insert__tld__query = str_replace( "INSERT INTO `tbltlds`", "INSERT INTO `$tld_tbl_name`",$insert__tld__query);
    $wpdb->query( $insert__tld__query );
}

//== Creating tlds_categories table
$Q_tld_cat = "CREATE TABLE {$tld_tbl_categories_name} (
  `id` int(10) UNSIGNED NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `display_order` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  UNIQUE KEY id (id)
)" . $charset_collate;
dbDelta($Q_tld_cat);

//== Inserting tlds_categories.
if ( $wpdb->get_var( "SELECT COUNT(*) FROM `$tld_tbl_categories_name`" ) == "0" ) {
    $insert__tld__cat__query = whmp_read_local_file( dirname( __FILE__ ) . "/tlds_cat.sql" );
    $insert__tld__cat__query = str_replace( "INSERT INTO `tbltld_categories`", "INSERT INTO `$tld_tbl_categories_name`",$insert__tld__cat__query);
    $wpdb->query( $insert__tld__cat__query );
}

//== Creating tlds_categories_pivot table
$Q_tld_cat_pivot = "CREATE TABLE {$tld_tbl_categories_pivot_name} (
  `id` int(10) UNSIGNED NOT NULL,
  `tld_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  UNIQUE KEY id (id)
)" . $charset_collate;
dbDelta($Q_tld_cat_pivot);

//== Inserting tlds_categories_pivot.
if ( $wpdb->get_var( "SELECT COUNT(*) FROM `$tld_tbl_categories_pivot_name`" ) == "0" ) {
    $insert__tld__cat__pivot__query = whmp_read_local_file( dirname( __FILE__ ) . "/tlds_cat_pivot.sql" );
    $insert__tld__cat__pivot__query = str_replace( "INSERT INTO `tbltld_category_pivot`", "INSERT INTO `$tld_tbl_categories_pivot_name`",$insert__tld__cat__pivot__query);
    $wpdb->query( $insert__tld__cat__pivot__query );
}
?>
