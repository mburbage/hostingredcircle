<?php /* Smarty version 3.1.27, created on 2020-08-23 19:58:15
         compiled from "C:\Users\Michael1\Documents\GitHub\redcirclehost\app\public\wp-content\plugins\whmpress_comp_tables\templates\whmpress_pricing_table_group\simple-04.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:18546637215f42ca577eb0a2_77404683%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '38d24b0e67ffda5a76e6459a936bacf86644f7fe' => 
    array (
      0 => 'C:\\Users\\Michael1\\Documents\\GitHub\\redcirclehost\\app\\public\\wp-content\\plugins\\whmpress_comp_tables\\templates\\whmpress_pricing_table_group\\simple-04.tpl',
      1 => 1598007784,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18546637215f42ca577eb0a2_77404683',
  'variables' => 
  array (
    'group' => 0,
    'plan' => 0,
    'desc' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5f42ca578ae7c8_85694235',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5f42ca578ae7c8_85694235')) {
function content_5f42ca578ae7c8_85694235 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '18546637215f42ca577eb0a2_77404683';
?>
<div class="row">
		<?php
$_from = $_smarty_tpl->tpl_vars['group']->value['plans'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['plan'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['plan']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['plan']->value) {
$_smarty_tpl->tpl_vars['plan']->_loop = true;
$foreach_plan_Sav = $_smarty_tpl->tpl_vars['plan'];
?>
		<div class="wpb_column vc_column_container  
		<?php if (count($_smarty_tpl->tpl_vars['group']->value['plans']) == 1) {?>vc_col-sm-12
<?php } elseif (count($_smarty_tpl->tpl_vars['group']->value['plans']) == 2) {?>vc_col-md-6
<?php } elseif (count($_smarty_tpl->tpl_vars['group']->value['plans']) == 3) {?>vc_col-md-4
<?php } elseif (count($_smarty_tpl->tpl_vars['group']->value['plans']) == 4) {?>vc_col-md-3
<?php }?>"
			data-plan-price="<?php echo $_smarty_tpl->tpl_vars['plan']->value['prefix'];
echo $_smarty_tpl->tpl_vars['plan']->value['amount'];
if ($_smarty_tpl->tpl_vars['plan']->value['fraction'] != '') {
echo $_smarty_tpl->tpl_vars['plan']->value['decimal'];
echo $_smarty_tpl->tpl_vars['plan']->value['fraction'];
}?>">

			<div class="vc_column-inner">
				<div class="wpb_wrapper">
					<div class="pricing  <?php if ($_smarty_tpl->tpl_vars['plan']->value['product_id'] == $_smarty_tpl->tpl_vars['group']->value['important']) {?>active<?php }?>">



						<h3 class="pricing-title id-color"><?php echo $_smarty_tpl->tpl_vars['plan']->value['name'];?>
</h3>


						<div class="pricing-price">

							<p class="price"><?php echo $_smarty_tpl->tpl_vars['plan']->value['prefix'];
echo $_smarty_tpl->tpl_vars['plan']->value['amount'];
if ($_smarty_tpl->tpl_vars['plan']->value['fraction'] != '') {?><span class="decimal"><?php echo $_smarty_tpl->tpl_vars['plan']->value['decimal'];?>
</span><span
									class="fraction"><?php echo $_smarty_tpl->tpl_vars['plan']->value['fraction'];?>
</span><?php }?></p>
							<?php if ($_smarty_tpl->tpl_vars['plan']->value['duration'] != '') {?>
							<span class="per"><?php echo $_smarty_tpl->tpl_vars['plan']->value['duration'];?>
</span><?php }?>
							<br/><span class="per"><?php echo $_smarty_tpl->tpl_vars['plan']->value['all_durations']['monthly']['discount']['discount_string'];?>
</span>
						</div>
						<div class="pricing-features">
							<?php if ($_smarty_tpl->tpl_vars['plan']->value['cdescription'] != '') {?>
							<div class="pricing_table_detail">
								<div class="holder">
									<?php echo $_smarty_tpl->tpl_vars['plan']->value['cdescription'];?>

								</div>
							</div>
							<?php }?>
							<ul class="price-list">
								<?php
$_from = $_smarty_tpl->tpl_vars['plan']->value['description'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['desc'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['desc']->_loop = false;
$_smarty_tpl->tpl_vars['__foreach_i'] = new Smarty_Variable(array('index' => -1));
foreach ($_from as $_smarty_tpl->tpl_vars['desc']->value) {
$_smarty_tpl->tpl_vars['desc']->_loop = true;
$_smarty_tpl->tpl_vars['__foreach_i']->value['index']++;
$foreach_desc_Sav = $_smarty_tpl->tpl_vars['desc'];
?>
								<?php if ((isset($_smarty_tpl->tpl_vars['__foreach_i']->value['index']) ? $_smarty_tpl->tpl_vars['__foreach_i']->value['index'] : null) == $_smarty_tpl->tpl_vars['group']->value['rows_table']) {
break 1;
}?>
								<li><?php echo $_smarty_tpl->tpl_vars['desc']->value;?>
</li>
								<?php
$_smarty_tpl->tpl_vars['desc'] = $foreach_desc_Sav;
}
?>
							</ul>
							<div class="price-btn">

								<a type="button" class="ot-btn btn-dark"
									href="<?php echo $_smarty_tpl->tpl_vars['plan']->value['order_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['group']->value['button_text'];?>
</a>

							</div>
						</div>
					</div> <!-- /.price-table -->
				</div>
			</div>
		</div>
		<?php
$_smarty_tpl->tpl_vars['plan'] = $foreach_plan_Sav;
}
?>
	
</div><?php }
}
?>