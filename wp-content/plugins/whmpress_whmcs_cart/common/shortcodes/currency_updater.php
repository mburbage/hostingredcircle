<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );


$all_currencies   = whcom_get_all_currencies();
$current_currency = whcom_get_current_currency_id();

if ( ! empty( $all_currencies ) ) { ?>
	<div class="whcom_currency_updater whcom_main">
		<?php foreach ( $all_currencies as $currency ) { ?>
			<button
				class="whcom_button <?php echo ($currency['id'] == $current_currency) ? 'active' : 'whcom_currency_updater_item';?>"
				data-currency-id="<?php echo $currency['id']; ?>">
				<?php echo $currency['prefix']; ?>
			</button>
		<?php } ?>
	</div>
<?php } ?>






