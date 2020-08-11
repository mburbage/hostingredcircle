<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar( "announcements" );

//show front menu where applicable
if ( wcap_show_front_menu() ) {
	include_once $this->Path . "/views/top_links_front.php";
}

$response = wcap_get_announcements();


?>

<div class="wcap_services ">
	<div class="whcom_row">
		<?php if ( $show_sidebar ) { ?>
			<div class="whcom_col_sm_3">
				<?php //side bar content ?>
				<?php wcap_render_support_panel(); ?>
			</div>
		<?php } ?>
		<div class="<?php echo ( $show_sidebar ) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
			<div class="whcom_page_heading">
				<span><?php esc_html_e( "Announcements", "whcom" ) ?></span>
			</div>

			<?php //main content ?>

			<?php if ( $response["result"] == "ERROR" ) {
				wcap_show_error( $response["message"] );
			}
			?>


			<?php if ( $response["result"] == "success" ) { ?>
				<?php
				$curr_whmcs_lang = whcom_get_whmcs_relevant_language();

				$lang_announcements = [];
				foreach ( $response["announcements"]["announcement"] as $announcement ) {
					if (strtolower($announcement['language']) == strtolower($curr_whmcs_lang)) {
						$lang_announcements[$announcement['parentid']] = $announcement;
					}
				}
				$already_shown = [];
				?>
				<?php foreach ( $response["announcements"]["announcement"] as $announcement ) { ?>
					<?php if (in_array($announcement['id'], $already_shown)) {
						continue;
					} ?>
					<?php if ( $announcement['published'] == '1' ) {
						$already_shown[] = $announcement['id'];
						if (!empty($lang_announcements[$announcement['id']])) {
							$announcement = $lang_announcements[$announcement['id']];
						} ?>
						<div class="whcom_margin_bottom_30">
							<h3>
								<?php echo $announcement["title"] ?>
							</h3>
							<div class="whcom_margin_bottom_15">
								<?php echo $announcement["announcement"] ?>
							</div>

							<div class="whcom_text_light whcom_text_small">
								<span class="whcom_icon_calendar"></span> <?php echo $announcement["date"] ?>
							</div>
						</div>
					<?php } ?>
				<?php } ?>
			<?php } ?>


		</div>
	</div>
</div>




