<?php /* Smarty version 3.1.27, created on 2020-07-22 11:51:04
         compiled from "/home/hostingredcircle/public_html/wp-content/plugins/whmpress_comp_tables/templates/whmpress_comparison_table/comparison-01.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:16851157165f182828c98a19_68285486%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '20cee5b887ddd8e70b24106888f38f99c80055f8' => 
    array (
      0 => '/home/hostingredcircle/public_html/wp-content/plugins/whmpress_comp_tables/templates/whmpress_comparison_table/comparison-01.tpl',
      1 => 1591815519,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16851157165f182828c98a19_68285486',
  'variables' => 
  array (
    'group' => 0,
    'random' => 0,
    'group_new' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5f182828cfa654_57969658',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5f182828cfa654_57969658')) {
function content_5f182828cfa654_57969658 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '16851157165f182828c98a19_68285486';
?>
<style>
    .wpct_comparison_table.first .wpct_tooltip:after {
        border-color: #337ab7 transparent transparent transparent;
    }
</style>
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