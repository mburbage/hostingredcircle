<?php /* Smarty version 3.1.27, created on 2020-08-11 22:23:17
         compiled from "C:\Users\Michael1\Documents\GitHub\redcirclehost\app\public\wp-content\plugins\whmpress_comp_tables\templates\whmpress_pricing_table_group\simple-03.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:17643366155f331a55346225_22279477%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd8c2e23cd49fef69d9647cc7c876b68684f5a30e' => 
    array (
      0 => 'C:\\Users\\Michael1\\Documents\\GitHub\\redcirclehost\\app\\public\\wp-content\\plugins\\whmpress_comp_tables\\templates\\whmpress_pricing_table_group\\simple-03.tpl',
      1 => 1597184589,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17643366155f331a55346225_22279477',
  'variables' => 
  array (
    'random' => 0,
    'group' => 0,
    'plan' => 0,
    'desc' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5f331a553c43d9_20329359',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5f331a553c43d9_20329359')) {
function content_5f331a553c43d9_20329359 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '17643366155f331a55346225_22279477';
?>
<div id="group_<?php echo $_smarty_tpl->tpl_vars['random']->value;?>
" class="wpct_table_group simple-03
<?php if ($_smarty_tpl->tpl_vars['group']->value['enable_table_carousel'] == "1") {?> wpct_have_carousel <?php }?>
<?php if ($_smarty_tpl->tpl_vars['group']->value['enable_table_dots'] == "1") {?> wpct_have_dots <?php }?>
<?php if (count($_smarty_tpl->tpl_vars['group']->value['plans']) == 1) {?>one_col
<?php } elseif (count($_smarty_tpl->tpl_vars['group']->value['plans']) == 2) {?>two_cols
<?php } elseif (count($_smarty_tpl->tpl_vars['group']->value['plans']) == 3) {?>three_cols
<?php } elseif (count($_smarty_tpl->tpl_vars['group']->value['plans']) == 4) {?>four_cols
<?php }?>"
     data-wpct-hide-mobile="<?php echo $_smarty_tpl->tpl_vars['group']->value['mobile_breakpoint'];?>
">
    <div class="wpct_comparison_table_row">
        <h2 class="wpct_group_title"><?php echo $_smarty_tpl->tpl_vars['group']->value['name'];?>
</h2>
    </div>
    <div class="" >
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
        <div class="wpb_column vc_column_container vc_col-sm-12 vc_col-md-4"
             data-plan-price="<?php echo $_smarty_tpl->tpl_vars['plan']->value['prefix'];
echo $_smarty_tpl->tpl_vars['plan']->value['amount'];
if ($_smarty_tpl->tpl_vars['plan']->value['fraction'] != '') {
echo $_smarty_tpl->tpl_vars['plan']->value['decimal'];
echo $_smarty_tpl->tpl_vars['plan']->value['fraction'];
}?>"
        >


            <div class="vc_column-inner whmpress whmpress_pricing_table reseller <?php if ($_smarty_tpl->tpl_vars['plan']->value['product_id'] == $_smarty_tpl->tpl_vars['group']->value['important']) {?>featured<?php }?>">
                <div class="pricing_table_heading">
                    <div class="holder">
                        <h2><?php echo $_smarty_tpl->tpl_vars['plan']->value['name'];?>
</h2>
                    </div>
                </div>
                <div class="pricing_table_price">
                    <div class="holder">
                        <span class="currency"><?php echo $_smarty_tpl->tpl_vars['plan']->value['prefix'];?>
</span><span class="amount"><?php echo $_smarty_tpl->tpl_vars['plan']->value['amount'];?>
</span><?php if ($_smarty_tpl->tpl_vars['plan']->value['fraction'] != '') {?><span class="decimal"><?php echo $_smarty_tpl->tpl_vars['plan']->value['decimal'];?>
</span><span class="fraction"><?php echo $_smarty_tpl->tpl_vars['plan']->value['fraction'];?>
</span><?php }
if ($_smarty_tpl->tpl_vars['plan']->value['duration'] != '') {?><span class="duration">/<?php echo $_smarty_tpl->tpl_vars['plan']->value['duration'];?>
</span><?php }?>
                    </div>
                </div>
	            <?php if ($_smarty_tpl->tpl_vars['plan']->value['cdescription'] != '') {?>
                    <div class="pricing_table_detail">
                        <div class="holder">
				            <?php echo $_smarty_tpl->tpl_vars['plan']->value['cdescription'];?>

                        </div>
                    </div>
	            <?php }?>
                <div class="pricing_table_features">
                    <div class="holder">
                        <ul>
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
                    </div>
                </div>
                <div class="pricing_table_submit">
                    <div class="holder">
                        <a type="button" class="whmpress-btn whmpress_order_button" href="<?php echo $_smarty_tpl->tpl_vars['plan']->value['order_url'];?>
"><?php echo $_smarty_tpl->tpl_vars['group']->value['button_text'];?>
</a>
                    </div>
                </div>
            </div>  <!-- /.price-table -->
        </div>
        <?php
$_smarty_tpl->tpl_vars['plan'] = $foreach_plan_Sav;
}
?>
    </div>
</div>
<?php }
}
?>