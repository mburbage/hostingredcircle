<?php
/**
 * Used to add tooltip
 *
 */
?>


<form action="?page=wpct-tooltips" method="post">
	<input type="hidden" name="id" value="0"/>
	<div>
		<table class="wpct_admin_pretty_table">
			<tr class="table-heading2">
				<th colspan="2">Provide details for new tooltip</th>
			</tr>
			<tr>
				<td style="width:30%"><label for="gname">Match String (<em>Text to match with a key </em>)</label></td>
				<td><input style="width: 100%;" type="text" required="required" name="matchstring" id="matchstring"
				           placeholder="Match Text"/></td>
			</tr>
			<tr>
				<td><label for="gdesc">ToolTip Text<br/>(<em>Tool tip text to show</em>)</label></td>
				<td><textarea style="width: 100%;height:75px" placeholder="Tooltip Text" id="tooltiptext"
				              name="tooltiptext"></textarea></td>
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