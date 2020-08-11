<?php
/**
 * Used to add group
 *
 */
?>

<form action="?page=wpct-groups" method="post">
	<input type="hidden" name="id" value="0"/>
	<div>
		<table class="wpct_admin_pretty_table">
			<tr class="table-heading2">
				<th colspan="2">Provide New Group Details</th>
			</tr>
			<tr>
				<td style="width:30%">
					<label for="gname"><?php esc_html_e('Group Name', 'wpct')?></label>
				</td>
				<td><input style="width: 100%;" type="text" required="required" name="name" id="gname"
				           placeholder="<?php esc_html_e('Group Name', 'wpct')?>"/></td>
			</tr>
			<tr>
				<td>
					<label for="gdesc"><?php esc_html_e('Group Notes', 'wpct')?></label><br>
					<small>
						<em>
							<?php esc_html_e('Note: these notes are not visible on front-end...', 'wpct')?>
						</em>
					</small>
				</td>
				<td><textarea style="width: 100%;height:75px" placeholder="<?php esc_html_e('Group Notes', 'wpct')?>" id="gdesc"
				              name="description"></textarea></td>
			</tr>
			<tr class="wpct_admin_text_center">
				<td colspan="2">
					<input type="submit" value="Save" class="button button-primary"/>
					<a href="?page=wpct-groups" class="button button-primary"><?php esc_html_e('Cancel', 'wpct')?></a>
				</td>
			</tr>
		</table>
	</div>
</form>