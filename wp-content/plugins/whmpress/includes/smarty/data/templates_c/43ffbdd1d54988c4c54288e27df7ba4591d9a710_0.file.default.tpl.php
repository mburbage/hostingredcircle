<?php /* Smarty version 3.1.27, created on 2020-07-22 12:02:33
         compiled from "/home/hostingredcircle/public_html/wp-content/plugins/whmpress_comp_tables/templates/whmpress_comparison_table/default.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:5839051695f182ad9e00117_00395378%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '43ffbdd1d54988c4c54288e27df7ba4591d9a710' => 
    array (
      0 => '/home/hostingredcircle/public_html/wp-content/plugins/whmpress_comp_tables/templates/whmpress_comparison_table/default.tpl',
      1 => 1591815519,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5839051695f182ad9e00117_00395378',
  'variables' => 
  array (
    'group' => 0,
    'random' => 0,
    'group_new' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5f182ad9e399e7_94581373',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5f182ad9e399e7_94581373')) {
function content_5f182ad9e399e7_94581373 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '5839051695f182ad9e00117_00395378';
?>
<div class="wpct_comparison_table first wpct_comparison_has_toggle
<?php if (count($_smarty_tpl->tpl_vars['group']->value['plans']) == 1) {?>one_col
<?php } elseif (count($_smarty_tpl->tpl_vars['group']->value['plans']) == 2) {?>two_cols
<?php } elseif (count($_smarty_tpl->tpl_vars['group']->value['plans']) == 3) {?>three_cols
<?php } elseif (count($_smarty_tpl->tpl_vars['group']->value['plans']) == 4) {?>four_cols
<?php } elseif (count($_smarty_tpl->tpl_vars['group']->value['plans']) == 5) {?>five_cols
<?php } elseif (count($_smarty_tpl->tpl_vars['group']->value['plans']) == 6) {?>six_cols
<?php } elseif (count($_smarty_tpl->tpl_vars['group']->value['plans']) == 7) {?>seven_cols
<?php } elseif (count($_smarty_tpl->tpl_vars['group']->value['plans']) == 8) {?>eight_cols
<?php } elseif (count($_smarty_tpl->tpl_vars['group']->value['plans']) == 9) {?>nine_cols
<?php } elseif (count($_smarty_tpl->tpl_vars['group']->value['plans']) == 10) {?>ten_cols
<?php } elseif (count($_smarty_tpl->tpl_vars['group']->value['plans']) == 11) {?>eleven_cols
<?php }?>"
     id="wpct_comparison_table_<?php echo $_smarty_tpl->tpl_vars['random']->value;?>
"
     data-wpct-hide-mobile="<?php echo $_smarty_tpl->tpl_vars['group']->value['mobile_breakpoint'];?>
">
	<?php echo $_smarty_tpl->tpl_vars['group_new']->value['top'];?>

	<?php echo $_smarty_tpl->tpl_vars['group_new']->value['middle'];?>

	<?php echo $_smarty_tpl->tpl_vars['group_new']->value['bottom'];?>

</div><?php }
}
?>