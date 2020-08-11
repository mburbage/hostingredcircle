<?php
/**~~
 * Set Group Options in Detail
 *
 */

//~~ Get row for edit
$row = $wpdb->get_row( "SELECT * FROM `" . whmp_get_group_tooltips_table_name() . "` WHERE `tooltip_id`=" . $_GET["edit"] );

?>

<form action="?page=wpct-tooltips&edit=<?php echo $row->tooltip_id ?>" method="post">
	<input type="hidden" name="tooltip_id" value="<?php echo $row->tooltip_id ?>"/>
	<div>
		<table class="wpct_admin_pretty_table">
			<tr class="table-heading2">
				<th colspan="2">Manage settings for <u><?php echo $row->match_string ?></u></th>
			</tr>
			<tr>
				<td style="width:30%"><label for="gname">Match String (<em>Text to match with a key </em>)</label></td>
				<td><input style="width: 100%;" type="text" required="required" name="matchstring" id="matchstring"
				           placeholder="Match Text"
				           value="<?php echo $row->match_string; ?>"/>
				</td>
			</tr>
			<tr>
				<td><label for="gdesc">ToolTip Text<br/>(<em>Tool tip text to show</em>)</label></td>
				<td><textarea style="width: 100%;height:75px" placeholder="Tooltip Text" id="tooltiptext"
				              name="tooltiptext"> <?php echo $row->tooltip_text; ?> </textarea></td>
			</tr>
			<tr class="wpct_admin_text_center">
				<td colspan="2">
					<input type="submit" value="Save Tooltip" class="button button-primary"/>
					<a href="?page=wpct-tooltips" class="button button-primary">Cancel</a>
				</td>
			</tr>
		</table>
	</div>
</form>

