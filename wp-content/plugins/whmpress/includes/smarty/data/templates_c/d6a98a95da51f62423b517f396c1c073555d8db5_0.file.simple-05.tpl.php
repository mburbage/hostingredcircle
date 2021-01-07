<?php /* Smarty version 3.1.27, created on 2020-12-15 18:24:29
         compiled from "C:\Users\Michael1\Documents\Development\redcirclehost\app\public\wp-content\plugins\whmpress_comp_tables\templates\whmpress_pricing_table_group\simple-05.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:13026754665fd8ff5d9b8348_01436140%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd6a98a95da51f62423b517f396c1c073555d8db5' => 
    array (
      0 => 'C:\\Users\\Michael1\\Documents\\Development\\redcirclehost\\app\\public\\wp-content\\plugins\\whmpress_comp_tables\\templates\\whmpress_pricing_table_group\\simple-05.tpl',
      1 => 1607989066,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13026754665fd8ff5d9b8348_01436140',
  'variables' => 
  array (
    'group' => 0,
    'plan' => 0,
    'desc_array' => 0,
    'string' => 0,
    'string_two' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5fd8ff5da55f00_30527641',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5fd8ff5da55f00_30527641')) {
function content_5fd8ff5da55f00_30527641 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '13026754665fd8ff5d9b8348_01436140';
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
<?php } elseif (count($_smarty_tpl->tpl_vars['group']->value['plans']) == 2) {?>vc_col-md-4
<?php } elseif (count($_smarty_tpl->tpl_vars['group']->value['plans']) == 3) {?>vc_col-md-4
<?php } elseif (count($_smarty_tpl->tpl_vars['group']->value['plans']) == 4) {?>vc_col-md-3
<?php }?>" data-plan-price="<?php echo $_smarty_tpl->tpl_vars['plan']->value['prefix'];
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
</span><span class="fraction"><?php echo $_smarty_tpl->tpl_vars['plan']->value['fraction'];?>
</span><?php }?></p>
						<?php if ($_smarty_tpl->tpl_vars['plan']->value['duration'] != '') {?>
						<span class="per"><?php echo $_smarty_tpl->tpl_vars['plan']->value['duration'];?>
</span><?php }?>
						<br /><span class="per"><?php echo $_smarty_tpl->tpl_vars['plan']->value['all_durations']['monthly']['discount']['discount_string'];?>
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
						<?php $_smarty_tpl->tpl_vars['desc_array'] = new Smarty_Variable(explode(" ",$_smarty_tpl->tpl_vars['plan']->value['description'][0]), null, 0);?>
						<?php if (count($_smarty_tpl->tpl_vars['desc_array']->value) < 25) {?><div id="desc-<?php echo $_smarty_tpl->tpl_vars['plan']->value['product_id'];?>
" class="pricing-description"><?php } else { ?>
							<div id="desc-<?php echo $_smarty_tpl->tpl_vars['plan']->value['product_id'];?>
" class="expandable-description"><?php }?>
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
							
							<?php $_smarty_tpl->tpl_vars['string'] = new Smarty_Variable(array_slice($_smarty_tpl->tpl_vars['desc_array']->value,0,25), null, 0);?>
							<?php $_smarty_tpl->tpl_vars['string_two'] = new Smarty_Variable(array_slice($_smarty_tpl->tpl_vars['desc_array']->value,26), null, 0);?>
							<?php echo implode(" ",$_smarty_tpl->tpl_vars['string']->value);?>

							<?php
$_smarty_tpl->tpl_vars['desc'] = $foreach_desc_Sav;
}
?>
							<?php if (count($_smarty_tpl->tpl_vars['desc_array']->value) >= 25) {?>
							<div id="more-btn-<?php echo $_smarty_tpl->tpl_vars['plan']->value['product_id'];?>
" class="more-button" onclick="toggleMoreDescription(<?php echo $_smarty_tpl->tpl_vars['plan']->value['product_id'];?>
)">Read More<i class="fa-down-chevron"></i></div>
							<span id="<?php echo $_smarty_tpl->tpl_vars['plan']->value['product_id'];?>
" class="full-description"><?php echo implode(" ",$_smarty_tpl->tpl_vars['string_two']->value);?>
</span>
							<div id="hide-btn-<?php echo $_smarty_tpl->tpl_vars['plan']->value['product_id'];?>
" class="more-button hide-btn" onclick="toggleMoreDescription(<?php echo $_smarty_tpl->tpl_vars['plan']->value['product_id'];?>
)"><i class="fa-up-chevron"></i>Close</div>
							<?php }?>

						</div>
						<div class="price-btn">

							<a type="button" class="ot-btn btn-dark" href="<?php echo $_smarty_tpl->tpl_vars['plan']->value['order_url'];?>
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
	<?php echo '<script'; ?>
>
		/**
			* 
			* ----------- More Button Price Descriptions
			* 
			*/
		function toggleMoreDescription(eventId) {
			document.getElementById(eventId).classList.toggle("show-desc");
			document.getElementById('desc-' + eventId).classList.toggle("show-pricing-description");
			document.getElementById('more-btn-' + eventId).classList.toggle('hide-btn');
			document.getElementById('hide-btn-' + eventId).classList.toggle('hide-btn');
		}

	<?php echo '</script'; ?>
>
</div>
<?php }
}
?>