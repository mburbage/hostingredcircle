<?php
/**
 * @package Admin
 * @todo    Services page for WHMpress admin panel
 */

if ( ! defined( 'WHMP_VERSION' ) ) {
	wp_die( "Direct access not allowed by WHMPress", "Forbidden" );
}
$WHMPress = new WHMpress();
global $wpdb;
?>
<div class="wrap whmp_wrap">
    <h2></h2>
    <h2 class="nav-tab-wrapper">
        <a class="nav-tab"
           href="<?php echo admin_url() ?>admin.php?page=whmp-dashboard"><?php echo esc_html_x( 'Dashboard','admin', 'whmpress' ); ?></a>
        <a class="nav-tab"
           href="<?php echo admin_url() ?>admin.php?page=whmp-services"><?php echo esc_html_x( 'Products/Services','admin', 'whmpress' ); ?></a>
        <a class="nav-tab"
           href="<?php echo admin_url() ?>admin.php?page=whmp-settings"><?php echo esc_html_x( 'Settings','admin', 'whmpress' ); ?></a>
        <a class="nav-tab nav-tab-active"
           href="<?php echo admin_url() ?>admin.php?page=whmp-pricing-tables"><?php echo esc_html_x( 'Pricing Tables','admin', 'whmpress' ) ?></a>
        <a class="nav-tab"
           href="<?php echo admin_url() ?>admin.php?page=whmp-sync"><?php echo esc_html_x( 'Sync WHMCS','admin', 'whmpress' ); ?></a>
        <a class="nav-tab" href="<?php echo admin_url() ?>admin.php?page=whmp-debug"><?php echo esc_html_x('Debug info','admin', 'whmpress')?></a>
    </h2>
    <div class="whmp_page_description">
		<?php
		if ( isset( $_GET["add"] ) ) {
			?>
            <p>
				<?php echo esc_html_x( 'You can use tool tips to give extra details about package features you are offering. Tool tip will appear if you have enabled it in group and a feature name matches with a tool tip.','admin', 'whmpress' ) ?>
            </p>
		<?php }
        elseif ( isset( $_GET["edit"] ) ) {
			?>
            <p>
				<?php echo esc_html_x( 'You can use tool tips to give extra details about package features you are offering. Tool tip will appear if you have enabled it in group and a feature name matches with a tool tip.','admin', 'whmpress' ) ?>
            </p>
		<?php }
		else { ?>
            <p>
				<?php echo esc_html_x( 'You can use tool tips to give extra details about package features you are offering. Tool tip will appear if you have enabled it in group and a feature name matches with a tool tip.','admin', 'whmpress' ) ?>
            </p>
		<?php } ?>
    </div>


	<?php
	/**
	 * This page control all operations of tooltips management.
	 */

	//~ DELETE
	if ( isset( $_GET["del-tooltip"] ) ) {
		$WHMPress->whmp_delete_tooltip( $_GET["del-tooltip"] );
		if ( isset( $_GET["name"] ) ) {
			echo "<div>Tooltip Name <strong>" . $_GET["name"] . "</strong> is deleted!</div>";
		}
	}

	//~~ ADD > user clicked Add
	if ( isset( $_GET["add"] ) ) {
		?>
        <form action="?page=whmp-pricing-tables" method="post">
            <input type="hidden" name="id" value="0"/>
            <div>
                <table class="whmp_admin_pretty_table">
                    <tr class="table-heading2">
                        <th colspan="2">Provide details for new tooltip</th>
                    </tr>
                    <tr>
                        <td style="width:30%"><label for="gname">Match String (<em>Text to match with a
                                    key </em>)</label></td>
                        <td><input style="width: 100%;" type="text" required="required" name="matchstring"
                                   id="matchstring"
                                   placeholder="Match Text"/></td>
                    </tr>
                    <tr>
                        <td><label for="gdesc">ToolTip Text<br/>(<em>Tool tip text to show</em>)</label></td>
                        <td><textarea style="width: 100%;height:75px" placeholder="Tooltip Text" id="tooltiptext"
                                      name="tooltiptext"></textarea></td>
                    </tr>
                    <tr>
                        <td style="width:30%"><label for="icon_class">Icon Class</label></td>
                        <td><input style="width: 100%;" type="text" name="icon_class"
                                   id="icon_class"
                                   placeholder="fa fa-"/></td>
                    </tr>
                    <tr class="whmp_text_center">
                        <td colspan="2">
                            <input type="submit" value="Save Tooltip" class="button button-primary"/>
                            <a href="?page=whmp-pricing-tables" class="button button-primary">Cancel</a>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
		<?php
	}

	//~ Data submitted for add
	if ( isset( $_POST["matchstring"] ) ) {
		if ( isset( $_POST["matchstring"] ) ) {
			$data["match_string"] = esc_attr($_POST["matchstring"]);
		}
		if ( isset( $_POST["tooltiptext"] ) ) {
			$data["tooltip_text"] = esc_attr($_POST["tooltiptext"]);
		}
		if ( isset( $_POST["icon_class"] ) ) {
			$data["icon_class"] = esc_attr($_POST["icon_class"]);
		}

		if ( empty( $_POST["tooltip_id"] ) ) {
			$response = $wpdb->insert( whmp_get_tooltips_table_name(), $data );
		}
		else {
			$response = $wpdb->update( whmp_get_tooltips_table_name(), $data, [ "tooltip_id" => $_POST["tooltip_id"] ] );
		}
	}

	//~~ EDIT
	if ( isset( $_GET["edit"] ) ) {
		//~~ Get row for edit
		$row = $wpdb->get_row( "SELECT * FROM `" . whmp_get_tooltips_table_name() . "` WHERE `tooltip_id`=" . $_GET["edit"] );

		?>

        <form action="?page=whmp-pricing-tables&edit=<?php echo $row->tooltip_id ?>" method="post">
            <input type="hidden" name="tooltip_id" value="<?php echo $row->tooltip_id ?>"/>
            <div>
                <table class="whmp_admin_pretty_table">
                    <tr class="table-heading2">
                        <th colspan="2">Manage settings for <u><?php echo $row->match_string ?></u></th>
                    </tr>
                    <tr>
                        <td style="width:30%"><label for="gname">Match String (<em>Text to match with a
                                    key </em>)</label></td>
                        <td><input style="width: 100%;" type="text" required="required" name="matchstring"
                                   id="matchstring"
                                   placeholder="Match Text"
                                   value="<?php echo stripcslashes($row->match_string); ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="gdesc">ToolTip Text<br/>(<em>Tool tip text to show</em>)</label></td>
                        <td><textarea style="width: 100%;height:75px" placeholder="Tooltip Text" id="tooltiptext"
                                      name="tooltiptext"> <?php echo stripcslashes($row->tooltip_text); ?> </textarea></td>
                    </tr>
                    <tr>
                        <td><label for="gdesc">Icon Class</label></td>
                        <td><input type="text" style="width: 100%;" placeholder="fa fa-" id="icon_class"
                                      name="icon_class" value="<?php echo $row->icon_class; ?>"></td>
                    </tr>
                    <tr class="whmp_text_center">
                        <td colspan="2">
                            <input type="submit" value="Save Tooltip" class="button button-primary"/>
                            <a href="?page=whmp-pricing-tables" class="button button-primary">Cancel</a>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
		<?php

	}

	//~~ Show list of pages if there is no action.
	if ( ! isset( $_GET["add"] ) && ! isset( $_GET["edit"] ) ) {        //~~ get rows from tooltips table
		$Q        = "SELECT * FROM `" . whmp_get_tooltips_table_name() . "`";
		$tooltips = $wpdb->get_results( $Q, ARRAY_A );
		?>

        <!-- Start Groups table -->
        <table class="whmp_admin_pretty_table">
            <!-- Start Table Header -->
            <thead>
            <tr class="table-heading2">
                <th><?php echo esc_html_x( 'ID','admin', 'whmpress' ) ?></th>
                <th><?php echo esc_html_x( 'Match String','admin', 'whmpress' ) ?></th>
                <th><?php echo esc_html_x( 'Tooltip Text','admin', 'whmpress' ) ?></th>
                <th><?php echo esc_html_x( 'Icon Class','admin', 'whmpress' ) ?></th>
                <th><?php echo esc_html_x( 'Actions','admin', 'whmpress' ) ?></th>
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
                                    href="?page=whmp-pricing-tables&edit=<?php echo $tooltip["tooltip_id"] ?>"><?php echo stripcslashes($tooltip["match_string"]) ?>
                            </a>
                        </td>
                        <td style="width: 40%;"><?php echo stripcslashes($tooltip["tooltip_text"]) ?></td>
                        <td style="width: 10%;"><?php echo $tooltip["icon_class"] ?></td>
                        <td style="width: 10%;" class="whmp_text_center">
                            <a
                                    title="<?php esc_html_x( 'Delete','admin', 'whmpress' ) ?>"
                                    data-id="<?php echo $tooltip["tooltip_id"] ?>"
                                    href="admin.php?page=whmp-pricing-tables&del-tooltip=<?php echo $tooltip["tooltip_id"] . "&name=" . $tooltip['match_string'] ?>"
                                    onclick="return confirm('Are you sure?')"
                                    class="button button-primary del-button"
                                    style="margin-bottom: 0"
                            >
                                <span class="lnr lnr-trash"></span>
                            </a>
                            <a
                                    href="?page=whmp-pricing-tables&edit=<?php echo $tooltip["tooltip_id"] ?>"
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
                <td colspan="5" style="text-align: center;">
                    <a href="?page=whmp-pricing-tables&add" class="button button-primary button-big">Add
                        Tooltip</a>
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

			if (!confirm("<?php esc_html_x('Are you sure you want to delete this group?','admin', 'whmpress')?>")) return false;
		});
		jQuery(".select_me").focus(function ()
		{
			jQuery(this).select();
		});
	});
</script>

