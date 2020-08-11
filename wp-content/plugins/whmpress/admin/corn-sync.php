<?php

if ( get_option( 'whmpress_cron_recurrance' ) <> '' ) {
/*	wp_schedule_event( time(), get_option( 'whmpress_cron_recurrance' ), 'whmpress_hourly_event' );
add_action( 'whmpress_hourly_event', 'whmpress_cron' );*/
function whmpress_cron() {
echo "Starting WHMPress cron job.<br>";
echo "===========================<br>";
echo whmp_fetch_data();
echo "============================<br>";
echo "WHMPress cron job completed.<br>";
}
}