<?php /* Smarty version 3.1.27, created on 2020-07-17 19:00:37
         compiled from "/home/hostingredcircle/public_html/wp-content/plugins/whmpress1/templates/whmpress_price_matrix/with-descriptions.html" */ ?>
<?php
/*%%SmartyHeaderCode:6936688075f11f5558bfaf3_85318493%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '272f9895fca22c1cc4aca79e13b52306748ddf82' => 
    array (
      0 => '/home/hostingredcircle/public_html/wp-content/plugins/whmpress1/templates/whmpress_price_matrix/with-descriptions.html',
      1 => 1591813713,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6936688075f11f5558bfaf3_85318493',
  'variables' => 
  array (
    'params' => 0,
    'search_label' => 0,
    'sr_title' => 0,
    'id_title' => 0,
    'name_title' => 0,
    'group_title' => 0,
    'monthly_title' => 0,
    'quarterly_title' => 0,
    'semiannually_title' => 0,
    'annually_title' => 0,
    'biennially_title' => 0,
    'triennially_title' => 0,
    'data' => 0,
    'whmp' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5f11f5559057b0_27093243',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5f11f5559057b0_27093243')) {
function content_5f11f5559057b0_27093243 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '6936688075f11f5558bfaf3_85318493';
?>
<div class="whmpress whmpress_price_matrix">
	<?php if (mb_strtolower($_smarty_tpl->tpl_vars['params']->value['data_table'], 'UTF-8') == "yes") {?>
	<?php echo '<script'; ?>
>
		jQuery(function ()
		{
			jQuery('table#<?php echo $_smarty_tpl->tpl_vars['params']->value['table_id'];?>
').DataTable();
		});
	<?php echo '</script'; ?>
>
	<?php } else { ?>
	<label><?php echo $_smarty_tpl->tpl_vars['search_label']->value;?>
</label>
	<input type='search' placeholder='Search' id='<?php echo $_smarty_tpl->tpl_vars['params']->value['table_id'];?>
_search_price_table' style='width:50%'>
	<?php echo '<script'; ?>
>
		jQuery(function ()
		{
			jQuery('input#<?php echo $_smarty_tpl->tpl_vars['params']->value['table_id'];?>
_search_price_table').quicksearch('table#<?php echo $_smarty_tpl->tpl_vars['params']->value['table_id'];?>
 tbody tr');
		});
	<?php echo '</script'; ?>
>
	<?php }?>
	<div class="table-responsive">
		<table id='<?php echo $_smarty_tpl->tpl_vars['params']->value['table_id'];?>
' class="table-responsive table-striped table-condensed">
			<thead>
			<tr>
				<?php if ($_smarty_tpl->tpl_vars['sr_title']->value) {?>
				<th><?php echo $_smarty_tpl->tpl_vars['sr_title']->value;?>
</th>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['id_title']->value) {?>
				<th><?php echo $_smarty_tpl->tpl_vars['id_title']->value;?>
</th>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['name_title']->value) {?>
				<th><?php echo $_smarty_tpl->tpl_vars['name_title']->value;?>
</th>
				<?php }?>
				<th>Description</th>
				<?php if ($_smarty_tpl->tpl_vars['group_title']->value) {?>
				<th><?php echo $_smarty_tpl->tpl_vars['group_title']->value;?>
</th>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['monthly_title']->value) {?>
				<th><?php echo $_smarty_tpl->tpl_vars['monthly_title']->value;?>
</th>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['quarterly_title']->value) {?>
				<th><?php echo $_smarty_tpl->tpl_vars['quarterly_title']->value;?>
</th>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['semiannually_title']->value) {?>
				<th><?php echo $_smarty_tpl->tpl_vars['semiannually_title']->value;?>
</th>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['annually_title']->value) {?>
				<th><?php echo $_smarty_tpl->tpl_vars['annually_title']->value;?>
</th>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['biennially_title']->value) {?>
				<th><?php echo $_smarty_tpl->tpl_vars['biennially_title']->value;?>
</th>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['triennially_title']->value) {?>
				<th><?php echo $_smarty_tpl->tpl_vars['triennially_title']->value;?>
</th>
				<?php }?>
				<th>Order Now</th>
			</tr>
			</thead>
			<tbody>
			<?php
$_from = $_smarty_tpl->tpl_vars['data']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['whmp'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['whmp']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['whmp']->value) {
$_smarty_tpl->tpl_vars['whmp']->_loop = true;
$foreach_whmp_Sav = $_smarty_tpl->tpl_vars['whmp'];
?>
			<tr>
				<?php if ($_smarty_tpl->tpl_vars['sr_title']->value) {?>
				<td data-content="<?php echo $_smarty_tpl->tpl_vars['sr_title']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['whmp']->value['sr'];?>
</td>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['id_title']->value) {?>
				<td data-content="<?php echo $_smarty_tpl->tpl_vars['id_title']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['whmp']->value['id'];?>
</td>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['name_title']->value) {?>
				<td data-content="<?php echo $_smarty_tpl->tpl_vars['name_title']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['whmp']->value['name'];?>
</td>
				<?php }?>
				<td data-content="Description"><?php if ($_smarty_tpl->tpl_vars['whmp']->value['description']) {
echo $_smarty_tpl->tpl_vars['whmp']->value['description'];
}?></td>
				<?php if ($_smarty_tpl->tpl_vars['group_title']->value) {?>
				<td data-content="<?php echo $_smarty_tpl->tpl_vars['group_title']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['whmp']->value['group'];?>
</td>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['monthly_title']->value) {?>
				<td data-content="<?php echo $_smarty_tpl->tpl_vars['monthly_title']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['whmp']->value['monthly'];?>
</td>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['quarterly_title']->value) {?>
				<td data-content="<?php echo $_smarty_tpl->tpl_vars['quarterly_title']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['whmp']->value['quarterly'];?>
</td>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['semiannually_title']->value) {?>
				<td data-content="<?php echo $_smarty_tpl->tpl_vars['semiannually_title']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['whmp']->value['semiannually'];?>
</td>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['annually_title']->value) {?>
				<td data-content="<?php echo $_smarty_tpl->tpl_vars['annually_title']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['whmp']->value['annually'];?>
</td>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['biennially_title']->value) {?>
				<td data-content="<?php echo $_smarty_tpl->tpl_vars['biennially_title']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['whmp']->value['biennially'];?>
</td>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['triennially_title']->value) {?>
				<td data-content="<?php echo $_smarty_tpl->tpl_vars['triennially_title']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['whmp']->value['triennially'];?>
</td>
				<?php }?>
				<td data-content="Order Now"><?php if ($_smarty_tpl->tpl_vars['whmp']->value['order_url']) {
echo $_smarty_tpl->tpl_vars['whmp']->value['order_url'];
}?></td>
			</tr>
			<?php
$_smarty_tpl->tpl_vars['whmp'] = $foreach_whmp_Sav;
}
?>
			</tbody>
		</table>
	</div>
</div><?php }
}
?>