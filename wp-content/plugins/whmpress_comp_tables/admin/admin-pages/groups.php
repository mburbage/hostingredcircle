<?php
/**
 * @package Admin
 * @todo    Services page for WHMpress admin panel
 */

if ( ! defined( 'WHMP_VERSION' ) ) {
	wp_die( "Direct access not allowed by WHMPress", "Forbidden" );
}

global $wpdb;
?>

<script>
	<?php
	$files = $this->get_info_files( "whmpress_comparison_table" );
	$Files = [];
	foreach ( $files as $file ) {
		$Files[ $file ] = $this->get_info_file_content( "whmpress_comparison_table", $file );
	}
	echo "var InfoFiles1 = " . json_encode( $Files ) . ";";
	echo "var Folder1 = '" . WPCT_GRP_URL . "/templates/whmpress_comparison_table/';";
	?>
	
	<?php
	$files = $this->get_info_files( "whmpress_order_slider" );
	$Files = [];
	foreach ( $files as $file ) {
		$Files[ $file ] = $this->get_info_file_content( "whmpress_order_slider", $file );
	}
	echo "var InfoFiles2 = " . json_encode( $Files ) . ";";
	echo "var Folder2 = '" . WPCT_GRP_URL . "/templates/whmpress_order_slider/';";
	?>
	
	<?php
	$files = $this->get_info_files( "whmpress_pricing_table_group" );
	$Files = [];
	foreach ( $files as $file ) {
		$Files[ $file ] = $this->get_info_file_content( "whmpress_pricing_table_group", $file );
	}
	echo "var InfoFiles3 = " . json_encode( $Files ) . ";";
	echo "var Folder3 = '" . WPCT_GRP_URL . "/templates/whmpress_pricing_table_group/';";
	?>

</script>

<div class="wrap wpct_admin_page">
	<h2></h2>
	<!-- Title of Plugin Page -->
	<div class="wpct_admin_page_title">
		<span class="wpct_admin_logo"></span>
		<h2>
			<?php _e( "Sliders & Comparison Tables", "whmpress" ) ?>
		</h2>
		<?php
		if ( isset( $_GET["add"] ) ) {
			?>
			<p>
				You can add new group on this page, provide Group name and description, You can change this info later
				by using <strong style="color: #0085ba;">"Configure Options"</strong> button from all groups list.
			</p>
		<?php } elseif ( isset( $_GET["edit"] ) ) {
			?>
			<p>
				You can edit/configure you group settings on this page, you can select template for each short-code and
				also set some general parameters for group, like currency and billing-cycle etc etc.
			</p>
		<?php } else { ?>
			<p>
				On this page you can create a Group of Pricing Tables and then use the corresponding ShortCode to
				display them on your pages.After creating group, use <strong style="color: #0085ba;">"Select
					Plans"</strong> to add remove Plans/Packages and <strong style="color: #0085ba;">"Configure
					Options"</strong> to change all other settings.
			</p>
		<?php } ?>
	</div>
	
	<?php
	if ( isset( $_GET["del-group"] ) ) {
		$this->whmp_delete_group( $_GET["del-group"] );
		echo "<div class='updated'><p>Group Name <strong>" . $_GET["name"] . "</strong> is deleted!</p></div>";
	}
	
	
	//echo "<pre>"; print_r ($_POST); echo "</pre>";
	if ( isset( $_POST["id"] ) ) {
		
		//~~ Group Options
		if ( isset( $_POST["name"] ) ) {
			$data["name"] = $_POST["name"];
		}
		if ( isset( $_POST["description"] ) ) {
			$data["description"] = $_POST["description"];
		}
		if ( isset( $_POST["description_separator"] ) ) {
			$data["description_separator"] = $_POST["description_separator"];
		}
		if ( isset( $_POST["ribbon_text"] ) ) {
			$data["ribbon_text"] = $_POST["ribbon_text"];
		}
		$data["button_text"] = ( isset( $_POST["button_text"] ) ) ? $_POST["button_text"] : "Buy Now";
		if ( isset( $_POST["convert_to_symbol"] ) ) {
			$data["convert_to_symbol"] = $_POST["convert_to_symbol"];
		}
		if ( isset( $_POST["enable_tooltips"] ) ) {
			$data["enable_tooltips"] = $_POST["enable_tooltips"];
		}
		if ( isset( $_POST["enable_table_dots"] ) ) {
			$data["enable_table_dots"] = $_POST["enable_table_dots"];
		}
		if ( isset( $_POST["enable_table_carousel"] ) ) {
			$data["enable_table_carousel"] = $_POST["enable_table_carousel"];
		}
		
		
		//~~ Comparision Table
		if ( isset( $_POST["template_file"] ) ) {
			$data["template_file"] = $_POST["template_file"];
		}
		if ( isset( $_POST["rows_comparison"] ) ) {
			$data["rows_comparison"] = $_POST["rows_comparison"];
		}
		if ( isset( $_POST["hide_width_comparison"] ) && is_numeric( $_POST["hide_width_comparison"] ) ) {
			$data["hide_width_comparison"] = $_POST["hide_width_comparison"];
		}
		
		
		//~~ Slider
		if ( isset( $_POST["slider_template_file"] ) ) {
			$data["slider_template_file"] = $_POST["slider_template_file"];
		}
		if ( isset( $_POST["rows_slider"] ) ) {
			$data["rows_slider"] = $_POST["rows_slider"];
		}
		if ( isset( $_POST["hide_width_slider"] ) && is_numeric( $_POST["hide_width_slider"] ) ) {
			$data["hide_width_slider"] = $_POST["hide_width_slider"];
		}
		
		//~~ Tables
		if ( isset( $_POST["pricing_table_template_file"] ) ) {
			$data["pricing_table_template_file"] = $_POST["pricing_table_template_file"];
		}
		if ( isset( $_POST["swipe_scroll"] ) ) {
			$data["swipe_scroll"] = $_POST["swipe_scroll"];
		}
		if ( isset( $_POST["rows_table"] ) ) {
			$data["rows_table"] = $_POST["rows_table"];
		}
		if ( isset( $_POST["hide_width_table"] ) && is_numeric( $_POST["hide_width_table"] ) ) {
			$data["hide_width_table"] = $_POST["hide_width_table"];
		}
		
		//~~ Remaining fields
		if ( isset( $_POST["billingcycle"] ) ) {
			$data["billingcycle"] = $_POST["billingcycle"];
		}
		if ( isset( $_POST["billingcycle2"] ) ) {
			$data["billingcycle2"] = $_POST["billingcycle2"];
		}
		if ( isset( $_POST["show_discount"] ) ) {
			$data["show_discount"] = $_POST["show_discount"];
		}
		
		if ( isset( $_POST["show_discount_banner"] ) ) {
			$data["show_discount_banner"] = $_POST["show_discount_banner"];
		}
		
		if ( isset( $_POST["show_discount_secondary"] ) ) {
			$data["show_discount_secondary"] = $_POST["show_discount_secondary"];
		}
		
		if ( isset( $_POST["convert_yes_with"] ) ) {
			$data["convert_yes_with"] = $_POST["convert_yes_with"];
		}
		
		if ( isset( $_POST["convert_no_with"] ) ) {
			$data["convert_no_with"] = $_POST["convert_no_with"];
		}
		
		if ( isset( $_POST["show_duration_as"] ) ) {
			$data["show_duration_as"] = $_POST["show_duration_as"];
		}
		
		if ( isset( $_POST["duration_style"] ) ) {
			$data["duration_style"] = $_POST["duration_style"];
		}
		if ( isset( $_POST["duration_connector"] ) ) {
			$data["duration_connector"] = $_POST["duration_connector"];
		}
		
		if ( isset( $_POST["decimals"] ) ) {
			$data["decimals"] = $_POST["decimals"];
		}
		if ( isset( $_POST["currency"] ) ) {
			$data["currency"] = $_POST["currency"];
		}
		if ( isset( $_POST["html_id"] ) ) {
			$data["html_id"] = $_POST["html_id"];
		}
		if ( isset( $_POST["html_class"] ) ) {
			$data["html_class"] = $_POST["html_class"];
		}
		
		if ( empty( $_POST["id"] ) ) {
			$response = $wpdb->insert( whmp_get_group_table_name(), $data );
		} else {
			$response = $wpdb->update( whmp_get_group_table_name(), $data, [ "id" => $_POST["id"] ] );
		}
		
		if ( $response ) {
			echo "<div class='updated'><p>Group " . $data["name"] . " is saved!</p></div>";
		} else {
			echo "<div class='updated'><p>Error in Saving " . $data["name"] . "!</p></div>";
		}
	}
	
	
	/**~~
	 * Choose which page to load here, based on GET options.
	 */
	
	//~~ Add, Edit a new Group, Name, Description
	if ( isset( $_GET["add"] ) ): require_once WPCT_GRP_PATH . "/admin/admin-pages/groups/group-add.php";
	
	//~~ Select Plans for a group
	elseif ( isset( $_GET["plans"] ) ): require_once WPCT_GRP_PATH . "/admin/admin-pages/groups/group-plans.php";
	
	//~~  Configure Options for a group
	elseif ( isset( $_GET["edit"] ) ): require_once WPCT_GRP_PATH . "/admin/admin-pages/groups/group-edit.php";
	
	/**~~
	 * If none of above is set, then show the plugins main page, with Add group button and
	 * Show previously created Groups
	 */ else:
		
		$Q = "SELECT * FROM `" . whmp_get_group_table_name() . "`";    //~~ whmp_get_gropu_table_name is defined in WHMpress
		$groups = $wpdb->get_results( $Q, ARRAY_A );                  //~~ get rows from whmpress-groups table
		?>
		
		<?php //Build table to show groups
		?>
		<!-- Start Groups table -->
		<div style="text-align: right; margin-bottom: 15px"><a href="?page=wpct-groups&add"
		                                                       class="button button-primary"><span
					style="padding-top: 3px;"
					class="dashicons dashicons-plus"></span><?php esc_html_e( 'Add Group', 'whmpress' ) ?></a></div>
		<table class="wpct_admin_pretty_table" style="width:100%">
			<!-- Start Table Header -->
			<thead>
			<tr class="table-heading2">
				<th>ID</th>
				<th>Name</th>
				<th>Plans</th>
				<th>Short Codes</th>
				<th>Actions</th>
			</tr>
			</thead>
			<tbody>
			<!-- End table header -->
			<?php
			//~~Show Groups
			if ( is_array( $groups ) && sizeof( $groups ) > 0 ) {
				foreach ( $groups as $group ):
					$comparison_table_code = '[whmpress_comparison_table id="' . $group["id"] . '"]';
					$slider_code = '[whmpress_order_slider id="' . $group["id"] . '"]';
					$pricing_table_code = '[whmpress_pricing_table_group id="' . $group["id"] . '"]';
					?>
					<!-- Start Group Shortcodes Row  -->
					<tr>
						<td style="width: 5%" class="wpct_admin_text_center"><?php echo $group["id"] ?></td>
						<td style="width: 10%" class="wpct_admin_text_center"><a
								href="?page=wpct-groups&edit=<?php echo $group["id"] ?>"><?php echo $group["name"] ?></a>
						</td>
						<?php $plans_in_group = $wpdb->get_var( "SELECT COUNT(*) FROM `" . whmp_get_group_detail_table_name() . "` WHERE `group_id`=" . $group["id"] ); ?>
						<td style="width: 5%" class="wpct_admin_text_center"><?php echo $plans_in_group; ?></td>
						<td style="width: 50%">
							<table style="width:100%">
								<tr>
									<td style="text-align: right">Slider</td>
									<td><input style="width:100%;background-color:#FFFFFF" class="select_me" type="text"
									           value='<?php echo $slider_code ?>' readonly="readonly"/></td>
								</tr>
								<tr>
									<td style="text-align: right">Comparison Table</td>
									<td><input style="width:100%;background-color:#FFFFFF" class="select_me" type="text"
									           value='<?php echo $comparison_table_code ?>' readonly="readonly"/></td>
								</tr>
								<tr>
									<td style="text-align: right">Pricing Table</td>
									<td><input style="width:100%;background-color:#FFFFFF" class="select_me" type="text"
									           value='<?php echo $pricing_table_code ?>' readonly="readonly"/></td>
									</td>
								</tr>
							</table>
						</td>
						<td style="width: 10%" class="wpct_admin_text_center">
							<a class="button button-primary button-block"
							   href="?page=wpct-groups&plans=<?php echo $group["id"] ?>"><?php esc_html_e( 'Group Plans', 'whmpress' ) ?></a>
							<a class="button button-primary button-block"
							   href="?page=wpct-groups&edit=<?php echo $group["id"] ?>"><?php esc_html_e( 'Group Options', 'whmpress' ) ?></a>
							<a class="button button-primary button-block" title="Delete this group"
							   data-id="<?php echo $group["id"] ?>"
							   href="admin.php?page=wpct-groups&del-group=<?php echo $group["id"] . "&name=" . $group['name'] ?>">
								<span class="lnr lnr-trash"></span>
							</a>
						</td>
					</tr>
					<!-- End Group Shortcodes Row  -->
				<?php endforeach;
			} else { ?>
				<tr>
					<td colspan="7" style="text-align: center;"><em>No group found - <a href="?page=wpct-groups&add">Add
								new group</a></em></td>
				</tr>
			<?php } ?>
			
			<td colspan="7" style="text-align: center;">
				<a href="?page=wpct-groups&add" class="button button-primary button-big">Add Group</a>
			</td>
			</tbody>
		</table>
		<!-- End Groups Table -->
	<?php endif; ?>
</div>

<script>
	jQuery(function ()
	{
		jQuery(".del-button").click(function (event)
		{
			//event.preventDefault();
			
			if (!confirm("Are you sure you want to delete this group?")) {
				return false;
			}
		});
		jQuery(".select_me").focus(function ()
		{
			jQuery(this).select();
		});
		
		jQuery(document).on("change", "#template_file", function (event)
		{
			event.preventDefault();
			
			val = jQuery(this).val();
			val = val.replace(".tpl", ".info");
			val = val.replace(".html", ".info");
			imgSrc = val.replace(".info", ".png");
			
			
			var infoContainer = jQuery('#template_file_info');
			
			if (InfoFiles1[val]) {
				infoContainer.show();
				infoContainer.find('td').html(InfoFiles1[val]);
				infoContainer.find('.image > img').attr("src", Folder1+imgSrc);
			}
			else {
				infoContainer.hide();
			}
		});
		
		jQuery(document).on("change", "#slider_template_file", function (event)
		{
			event.preventDefault();
			
			val = jQuery(this).val();
			val = val.replace(".tpl", ".info");
			val = val.replace(".html", ".info");
			imgSrc = val.replace(".info", ".png");
			
			var infoContainer = jQuery('#slider_template_file_info');
			
			if (InfoFiles2[val]) {
				infoContainer.show();
				infoContainer.find('td').html(InfoFiles2[val]);
				infoContainer.find('.image > img').attr("src", Folder2+imgSrc);
			}
			else {
				infoContainer.hide();
			}
		});
		
		jQuery(document).on("change", "#pricing_table_template_file", function (event)
		{
			event.preventDefault();
			
			val = jQuery(this).val();
			val = val.replace(".tpl", ".info");
			val = val.replace(".html", ".info");
			imgSrc = val.replace(".info", ".png");
			
			var infoContainer = jQuery('#pricing_table_template_file_info');
			
			if (InfoFiles3[val]) {
				infoContainer.show();
				infoContainer.find('td').html(InfoFiles3[val]);
				infoContainer.find('.image > img').attr("src", Folder3+imgSrc);
			}
			else {
				infoContainer.hide();
			}
		});
	});
</script>