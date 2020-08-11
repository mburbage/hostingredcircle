<?php
/**~~
 *  Add or remove plans/pacakges to a group.
 *  Plans are submited back to same page
 * whmpress_groups = whmp_get_group_table_name = Group Name + Options
 * whmpress_group_details = whmp_get_group_details_table_name = Group Plans
 */


/**~~
 * Save/ Update only If form is submited
 */
if ( isset( $_POST["save"] ) ) {
	// Update value of featured in whmpress_groups table
	/**~~ changed form radio to checkboxs, only last checkbox value will be seaved, code moved below foreach.
	 * if (!isset($_POST["important"])) $_POST["important"] = "0";
	 * $Q = "UPDATE `".whmp_get_group_table_name()."` SET `important`='".$_POST["important"]."'";
	 * $wpdb->query($Q);
	 **/
	
	// Remove all rows for submited group from whmpress_group_details table (these will be added again).
	$Q = "DELETE FROM `" . whmp_get_group_detail_table_name() . "` WHERE `group_id`=" . @$_GET["plans"];
	$wpdb->query( $Q );
	
	// Insert a Row for each select value in whmpress_group_details
    $featured="";
	if ( isset( $_POST["product"] ) ) {
		foreach ( $_POST["product"] as $product_id ) {
			$Record["product_id"]   = $product_id;
			$Record["group_id"]     = @$_GET["plans"];
			$tmp                    = str_replace( [ "\t", "  " ], [
				"&nbsp;&nbsp; &nbsp;",
				"&nbsp;&nbsp;",
			], trim( @$_POST ["apend_comp"][ $product_id ] ) );
			$Record["comp_append"]  = $tmp;
			$Record["order_by"]     = $_POST["order_by"][ $product_id ];
			$Record["font_awesome"] = $_POST["font_awesome"][ $product_id ];

			if ( isset( $_POST["featured"][ $product_id ] ) ) {
				$featured = $_POST["featured"][ $product_id ];
			}
			
			$response = $wpdb->insert( whmp_get_group_detail_table_name(), $Record );
		}
	}
		$Q = "UPDATE `" . whmp_get_group_table_name() . "` SET `important`='" . $featured . "' WHERE `id`=" . @$_GET["plans"];
		$wpdb->query( $Q );
}

/**~~
 * End saving things
 */

/**~~
 * Subheading: Manage Plans for [group name]
 */

//--- Get Plan Name, description to show in subheading
$current_group = $wpdb->get_row( "SELECT * FROM `" . whmp_get_group_table_name() . "` WHERE `id`=" . $_GET["plans"] );

//~~ Show which group is being managed for plans
//wpct_pretty_print($group);
?>
<form method="post">
	<h3>Select plans for <strong style="color: #0085ba;"><?php echo $current_group->name; ?></strong>
		<button style="float: right; margin-left: 10px" type="submit"
		        class="button button-primary"><?php esc_html_e( 'Save Group Plans', 'whmpress' ) ?></button>
		<a href="?page=wpct-groups&edit=<?php echo $current_group->id; ?>" class="button button-primary"
		   style="float: right; margin-left: 10px">
			Group Options
		</a>
		<a href="?page=wpct-groups" class="button button-primary" style="float: right;">
			<span class="lnr lnr-arrow-left"></span> Back to List
		</a>
		<div style="clear: both"></div>
	</h3>
	
	<?php
	/**~~
	 * Show Selected Plans in rows and make a form
	 */
	?>
	
	
	<input type="hidden" name="save" value="1">  <!-- save flag -->
	<?php
	/**~~
	 * Following functions used in loop are defined in WHMpress
	 * whmp_get_service_types > returns active services types with display names
	 * whmp_get_type_groups > Returns groups based on service type
	 */
	
	$services = whmp_get_service_types();
	
	/**~~
	 * Print from in a formated table, in 3 levels
	 * * Product Types >> top most level. i.e. Hosting, Reseller, Servers or Others
	 * * * Product Groups
	 * * * * Products
	 *
	 *
	 */
	
	
	?>
	<!-- Button to Save -->
	<div style="text-align: center;">
	
	</div>
	<?php
	foreach ( $services as $key => $service ) { ?>
		<table class="wpct_admin_pretty_table">
			<tbody>
			<?php
			$grp = $current_group;
			//~~ Fetch group based on sectoin above
			$groups = whmp_get_type_groups( $key );
			//~~ Product Groups >> 2nd top level
			
			
			foreach ( $groups as $group ) { ?>
				<tr class="table-heading2" style="text-align: left">
					<th colspan="5">
						<?php echo $service; ?> <span class="lnr lnr-arrow-right"> </span><?php echo $group["name"] ?>
					</th>
				</tr>
				<?php
				//~~ Header >> 3rd level
				$prds = whmp_get_products_by_group( $group["id"] ); ?>
				<tr class="table-heading3">
					<td style="width: 20%"><?php esc_html_e( 'Select Product To Include', 'whmpress' ) ?></td>
					<td style="width: 50%"><?php esc_html_e( 'Additional Data for Comparison table', 'whmpress' ) ?></td>
					<td style="width: 10%"><?php esc_html_e( 'Font Awesome (beta)', 'whmpress' ) ?></td>
					<td style="width: 10%"><?php esc_html_e( 'Sort Order', 'whmpress' ) ?></td>
					<td style="width: 10%"><?php esc_html_e( 'Featured', 'whmpress' ) ?></td>
				</tr>
				<?php
				//~~ Products/Service >> 3rd level
				
				foreach ( $prds as $counter => $prd ) {
					if ( $key <> $prd['type'] ) {
						continue;
					}
					
					//1. Check if product is select in group
					$Selected           = $this->whmp_is_product_in_group( $prd["id"], @$_GET["plans"] ) ? "checked=checked" : "";
					$active             = $this->whmp_is_product_in_group( $prd["id"], @$_GET["plans"] ) ? "active" : "";
					$AppendToComparison = $this->whmp_append_to_comparison( $prd["id"], @$_GET["plans"] );
					$Orderby            = $this->whmp_order_by_in_group( $prd["id"], @$_GET["plans"] );
					$font_awesome       = $this->whmp_font_awesome_in_group( $prd["id"], @$_GET["plans"] );
					
					//3. Check if it is a featured product
					if ( isset( $grp->important ) && $prd["id"] == $grp->important ) { // check if a product is featured
						$Featured = "checked=checked";
					} else {
						$Featured = "";
					}
					?>
					<tr class="<?php echo $active ?>">
						<?php //~~ Lets take value from user in arrays, arrays are index with package plan ids ?>
						<td>
							<label style="display: block;">
								<input <?php echo $Selected ?> class="group-selector" type="checkbox"
								                               name="product[<?php echo $prd['id'] ?>]"
								                               value="<?php echo $prd['id'] ?>"/> <?php echo $prd["name"] ?>
							</label>
						</td>
						<td>
							<label style="display: block;">
								<textarea class="captureValue" name="apend_comp[<?php echo $prd["id"] ?>]"
								          onclick="captureValue(this)"><?php echo esc_attr( $AppendToComparison ); ?></textarea>
							</label>
						</td>
						<td>
							<input value="<?php echo $font_awesome ?>"
							       style="width;100%"
							       type="text"
							       title="<?php esc_html_e( 'You can enter a font-awesome class here...', 'whmpress' ) ?>"
							       placeholder="fa-heart-o"
							       name="font_awesome[<?php echo $prd["id"] ?>]">
						</td>
						<td style="width:70px">
							<input value="<?php echo $Orderby ?>"
							       style="width;100%; max-width: 60px"
							       type="number"
							       placeholder="Display Order #"
							       name="order_by[<?php echo $prd["id"] ?>]">
						</td>
						<td>
							<label>
								<input <?php echo $Featured ?>
									type="checkbox" name="featured[<?php echo $prd['id'] ?>]"
									value="<?php echo $prd['id'] ?>"/>Featured
							</label>
						</td>
					</tr>
				<?php } //~~ End Products >> third level ?>
			<?php } //~~ End Groups >> 2nd level ?>
			</tbody>
		</table>
	<?php } //~~ End product types >> 1st level ?>
	
	<!-- Button to Save -->
	<div style="text-align: center;">
		<button class="button button-primary button-big">Save Group Plans</button>
	</div>
	
	<div id="dialog" title="Dialog" data-modal='true'>
		<textarea name="" id="textValue"></textarea>
		<button class="button button-primary" id="textSave">Save</button>
	</div>
	<script>
		
		jQuery(document).on('ready', function ()
		{
			var windowHeight = jQuery(window).height();
			var modalHeight = 0.80 * windowHeight;
			console.log(modalHeight);
			jQuery("#dialog").dialog({
				autoOpen: false,
				height: modalHeight,
				top: '10%',
				maxWidth: 450,
				width: 'auto',
				fluid: true,
				modal: true,
				title: "Append Descriptions for this Product",
				dialogClass: "wpct_dialog wpct"
			});
			var $element = null;
		});
		function captureValue (element)
		{
			$element = element;
			var textValue = $element.value;
			jQuery('#dialog').dialog('open');
			jQuery('#dialog #textValue').val(textValue);
		}
		
		jQuery(function ()
		{
			jQuery('#dialog').find('#textSave').on('click', function ()
			{
				jQuery('#dialog').dialog('close');
				
				var insertedValue = jQuery('#dialog').find('#textValue').val();
				
				$element.value = insertedValue;
				
				//Clearing dialog textarea for next input
				jQuery('#dialog').find('#textValue').val('');
			});
			jQuery('.group-selector').on('change', function ()
			{
				if (jQuery(this).prop('checked')) {
					jQuery(this).parents('tr').addClass('active');
				}
				else {
					jQuery(this).parents('tr').removeClass('active');
				}
			})
		});
	
	</script>
</form>
