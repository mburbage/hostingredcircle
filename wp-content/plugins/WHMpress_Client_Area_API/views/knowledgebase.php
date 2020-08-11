<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar( "knowledgebase" );

//show front menu where applicable
if ( wcap_show_front_menu() ) {
	include_once $this->Path . "/views/top_links_front.php";
}
$response = wcap_get_knowledgebase_cats();
?>

<div class="wcap_knowledgebase ">
	<div class="whcom_row">
		<?php if ( $show_sidebar ) { ?>
			<div class="whcom_col_sm_3">
				<?php //side bar content ?>
				<?php wcap_render_support_panel(); ?>
			</div>
		<?php } ?>
		<div class="<?php echo ( $show_sidebar ) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
			<div class="whcom_page_heading">
				<span><?php esc_html_e( "Knowledgebase", "whcom" ) ?></span>
			</div>

			<?php //main content ?>
			<div class="whcom_margin_bottom_15">
				<h3><?php esc_html_e( "Categories", "whcom" ) ?></h3>

				<?php if ( $response["status"] != "OK" ) { ?>
					<div class="whcom_alert whcom_alert_danger whcom_text_center">
						<?php echo $response["message"] ?>
					</div>
				<?php } ?>

				<?php if ( $response["status"] == "OK" ) {
					$curr_whmcs_lang             = whcom_get_whmcs_relevant_language();
					$all_kb_categories           = $response["data"];
					$lang_kb_categories          = [];
					$already_added_kb_categories = [];
					foreach ( $all_kb_categories as $all_kb_category ) {
						if ($all_kb_category['catid'] > 0) {
							$already_added_kb_categories[]                   = $all_kb_category['id'];
							if ( strtolower( $all_kb_category['language'] ) == strtolower( $curr_whmcs_lang ) ) {
								$lang_kb_categories[ $all_kb_category['catid'] ] = $all_kb_category;
							}
						}
					} ?>
					<?php foreach ( $all_kb_categories as $key => $category ) { ?>
						<?php
						if ( $category['hidden'] != 1 && ! in_array( $category['id'], $already_added_kb_categories ) ) {
							$cat_id = $category['id'];
							$already_added_kb_categories[] = $cat_id;
							if ( ! empty( $lang_kb_categories[ $cat_id ] ) ) {
								$category = $lang_kb_categories[ $cat_id ];
							} ?>
							<p><i class="whcom_icon_folder-empty"></i>
								<a href="?catid=<?php echo $cat_id; ?>" class="wcap_load_page"
								   data-page="kb_articles">
									<?php echo $category["name"]; ?>
								</a></br>

								<?php echo $category["description"]; ?>
							</p>
						<?php } ?>
					<?php } ?>
				<?php } ?>

			</div>


		</div>
	</div>
</div>







