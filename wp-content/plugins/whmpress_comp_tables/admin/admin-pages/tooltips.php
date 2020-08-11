<?php
/**
 * Created by PhpStorm.
 * User: fokado
 * Date: 10/21/2016
 * Time: 6:05 PM
 */


if ( ! defined( 'WPCT_GRP_PATH' ) ) {
	wp_die( "Direct access not allowed by WHMPress", "Forbidden" );
}

global $wpdb;

?>


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
				<?php esc_html_e('You can use tool tips to give extra details about package features you are offering. Tool tip will appear if you have enabled it in group and a feature name matches with a tool tip.', 'wpct')?>
			</p>
		<?php }
		elseif ( isset( $_GET["edit"] ) ) {
			?>
			<p>
				<?php esc_html_e('You can use tool tips to give extra details about package features you are offering. Tool tip will appear if you have enabled it in group and a feature name matches with a tool tip.', 'wpct')?>
			</p>
		<?php }
		else { ?>
			<p>
				<?php esc_html_e('You can use tool tips to give extra details about package features you are offering. Tool tip will appear if you have enabled it in group and a feature name matches with a tool tip.', 'wpct')?>
			</p>
		<?php } ?>
	</div>
	
	<?php
	/**
	 * This page control all operations of tooltips management.
	 */
	
	//~ DELETE
	if ( isset( $_GET["del-tooltip"] ) ) {
		$this->whmp_delete_tooltip( $_GET["del-tooltip"] );
		if ( isset( $_GET["name"] ) ) {
			echo "<div>Tooltip Name <strong>" . $_GET["name"] . "</strong> is deleted!</div>";
		}
	}
	
	//~~ ADD > user clicked Add
	if ( isset( $_GET["add"] ) ) {
		require_once WPCT_GRP_PATH . "/admin/admin-pages/tooltips/tooltip-add.php";
	}
	
	//~ Data submitted for add
	if ( isset( $_POST["matchstring"] ) ) {
		if ( isset( $_POST["matchstring"] ) ) {
			$data["match_string"] = $_POST["matchstring"];
		}
		if ( isset( $_POST["tooltiptext"] ) ) {
			$data["tooltip_text"] = $_POST["tooltiptext"];
		}
		
		if ( empty( $_POST["tooltip_id"] ) ) {
			$response = $wpdb->insert( whmp_get_group_tooltips_table_name(), $data );
		}
		else {
			$response = $wpdb->update( whmp_get_group_tooltips_table_name(), $data, [ "tooltip_id" => $_POST["tooltip_id"] ] );
		}
	}
	
	//~~ EDIT
	if ( isset( $_GET["edit"] ) ) {
		require_once WPCT_GRP_PATH . "/admin/admin-pages/tooltips/tooltip-edit.php";
	}
	
	//~~ Show list of pages if there is no action.
	if ( ! isset( $_GET["add"] ) && ! isset( $_GET["edit"] ) ) {        //~~ get rows from tooltips table
		$Q        = "SELECT * FROM `" . whmp_get_group_tooltips_table_name() . "`";
		$tooltips = $wpdb->get_results( $Q, ARRAY_A );
		?>
		
		<!-- Start Groups table -->
		<table class="wpct_admin_pretty_table">
			<!-- Start Table Header -->
			<thead>
			<tr class="table-heading2">
				<th><?php esc_html_e('ID', 'wpct')?></th>
				<th><?php esc_html_e('Match String', 'wpct')?></th>
				<th><?php esc_html_e('Tooltip Text', 'wpct')?></th>
				<th><?php esc_html_e('Actions', 'wpct')?></th>
			</tr>
			</thead>
			<tbody>
			<!-- End table header -->
			
			<?php
			if ( is_array( $tooltips ) && sizeof( $tooltips ) > 0 ) {
				foreach ( $tooltips as $tooltip ) {
					?>
					<!-- Start Tooltip Row  -->
					<tr>
						<td style="width: 10%;"><?php echo $tooltip["tooltip_id"] ?></td>
						<td style="width: 20%;">
							<a
								href="?page=wpct-tooltips&edit=<?php echo $tooltip["tooltip_id"] ?>"><?php echo $tooltip["match_string"] ?>
							</a>
						</td>
						<td style="width: 50%;"><?php echo $tooltip["tooltip_text"] ?></td>
						<td style="width: 10%;" class="wpct_admin_text_center">
							<a
								title="<?php esc_html_e('Delete', 'wpct')?>"
								data-id="<?php echo $tooltip["tooltip_id"] ?>"
								href="admin.php?page=wpct-tooltips&del-tooltip=<?php echo $tooltip["tooltip_id"] . "&name=" . $tooltip['match_string'] ?>"
								class="button button-primary"
								style="margin-bottom: 0"
							>
								<span class="lnr lnr-trash"></span>
							</a>
							<a
								href="?page=wpct-tooltips&edit=<?php echo $tooltip["tooltip_id"] ?>"
								class="button button-primary"
							>
								<span class="lnr lnr-pencil"></span>
							</a>
						</td>
					</tr>
					<!-- End Tooltip Row  -->
					<?php
				}
				?>
				<?php
			}
			else {
				?>
				<tr>
					<td colspan="4" style="text-align: center;"><em>No Tooltip found</em></td>
				</tr>
				<?php
			}
			?>
			<tr>
				<td colspan="4" style="text-align: center;">
					<a href="?page=<?php echo @$_GET['page']; ?>&add" class="button button-primary button-big">Add Tooltip</a>
				</td>
			</tr>
			</tbody>
		</table>
		<!-- End Tooltips Table -->
		<?php
	}
	?>
</div>

<script>
	jQuery(function ()
	{
		jQuery(".del-button").click(function (event)
		{
			//event.preventDefault();
			
			if (!confirm("Are you sure you want to delete this group?")) return false;
		});
		jQuery(".select_me").focus(function ()
		{
			jQuery(this).select();
		});
	});
</script>