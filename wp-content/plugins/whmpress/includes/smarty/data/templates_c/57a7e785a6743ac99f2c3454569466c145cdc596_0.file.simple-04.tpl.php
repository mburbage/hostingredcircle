<?php /* Smarty version 3.1.27, created on 2021-01-11 13:34:51
         compiled from "C:\Users\Michael1\Documents\Development\redcirclehost\app\public\wp-content\plugins\whmpress_comp_tables\templates\whmpress_pricing_table_group\simple-04.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:7875568185ffc53fbe96b45_06086772%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '57a7e785a6743ac99f2c3454569466c145cdc596' => 
    array (
      0 => 'C:\\Users\\Michael1\\Documents\\Development\\redcirclehost\\app\\public\\wp-content\\plugins\\whmpress_comp_tables\\templates\\whmpress_pricing_table_group\\simple-04.tpl',
      1 => 1610229040,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7875568185ffc53fbe96b45_06086772',
  'variables' => 
  array (
    'group' => 0,
    'plan' => 0,
    'desc' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ffc53fc010267_32092903',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ffc53fc010267_32092903')) {
function content_5ffc53fc010267_32092903 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '7875568185ffc53fbe96b45_06086772';
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
				<div class="pricing <?php if ($_smarty_tpl->tpl_vars['plan']->value['productfeatured']) {?>featured<?php }?>">

					<h3 class="pricing-title id-color"><?php echo $_smarty_tpl->tpl_vars['plan']->value['name'];?>
</h3>

					<div class="pricing-price">
						<?php if ($_smarty_tpl->tpl_vars['plan']->value['promotions'] != false) {?>
						<p class="price"><span class="price-prefix"><?php echo $_smarty_tpl->tpl_vars['plan']->value['prefix'];?>
</span><?php echo sprintf("%.2f",((($_smarty_tpl->tpl_vars['plan']->value['amount']/12))*((100-$_smarty_tpl->tpl_vars['plan']->value['promotions']['value'])/100)));?>
<span class="price-postfix">/ mon</span>
						</p>
						
						<span class="per onsale">ON SALE - SAVE <?php echo sprintf("%.0f",$_smarty_tpl->tpl_vars['plan']->value['promotions']['value']);?>
%</span>
						<span class="per renewal"><?php echo $_smarty_tpl->tpl_vars['plan']->value['prefix'];
echo sprintf("%.2f",($_smarty_tpl->tpl_vars['plan']->value['amount']/12));?>
/mo when you renew</span>
						<br />
						<?php if (trim($_smarty_tpl->tpl_vars['plan']->value['duration']," ") != "Monthly") {?>
						<span class="per"><?php echo $_smarty_tpl->tpl_vars['plan']->value['all_durations']['annually']['discount']['discount_string'];?>
</span>
						<?php } else { ?>
						<span class="per"><?php echo $_smarty_tpl->tpl_vars['plan']->value['all_durations']['monthly']['discount']['discount_string'];?>
</span>
						<?php }?>
						<?php } else { ?>
						<p class="price"><span class="price-prefix"><?php echo $_smarty_tpl->tpl_vars['plan']->value['prefix'];?>
</span><?php echo sprintf("%.2f",(($_smarty_tpl->tpl_vars['plan']->value['amount']/12)));?>
<span class="price-postfix">/ mon</span>
						</p>
						<?php if (trim($_smarty_tpl->tpl_vars['plan']->value['duration']," ") != "Monthly") {?>
						<span class="per"><?php echo $_smarty_tpl->tpl_vars['plan']->value['all_durations']['annually']['discount']['discount_string'];?>
</span>
						<?php } else { ?>
						<span class="per"><?php echo $_smarty_tpl->tpl_vars['plan']->value['all_durations']['monthly']['discount']['discount_string'];?>
</span>
						<?php }?>
						<?php }?>

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
							<?php if ($_smarty_tpl->tpl_vars['plan']->value['promotions'] != false) {?>
							<a type="button" class="ot-btn btn-dark" href="<?php echo $_smarty_tpl->tpl_vars['plan']->value['order_url'];?>
&promocode=<?php echo $_smarty_tpl->tpl_vars['plan']->value['promotions']['code'];?>
"><?php echo $_smarty_tpl->tpl_vars['group']->value['button_text'];?>
</a>
							<?php } else { ?>
							<a type="button" class="ot-btn btn-dark" href="<?php echo $_smarty_tpl->tpl_vars['plan']->value['order_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['group']->value['button_text'];?>
</a>
							<?php }?>

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

</div>
<?php }
}
?>