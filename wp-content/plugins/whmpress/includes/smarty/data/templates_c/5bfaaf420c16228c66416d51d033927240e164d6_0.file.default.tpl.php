<?php /* Smarty version 3.1.27, created on 2020-06-10 22:19:19
         compiled from "/home/hostingredcircle/public_html/wp-content/plugins/whmpress_comp_tables/templates/whmpress_pricing_table_group/default.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:15033610025ee15c67c7ea31_81054285%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5bfaaf420c16228c66416d51d033927240e164d6' => 
    array (
      0 => '/home/hostingredcircle/public_html/wp-content/plugins/whmpress_comp_tables/templates/whmpress_pricing_table_group/default.tpl',
      1 => 1591815519,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15033610025ee15c67c7ea31_81054285',
  'variables' => 
  array (
    'random' => 0,
    'group' => 0,
    'plan' => 0,
    'desc' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ee15c67cd8bd8_09749702',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ee15c67cd8bd8_09749702')) {
function content_5ee15c67cd8bd8_09749702 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '15033610025ee15c67c7ea31_81054285';
?>
<div id="group_<?php echo $_smarty_tpl->tpl_vars['random']->value;?>
" class="wpct_table_group
<?php if ($_smarty_tpl->tpl_vars['group']->value['enable_table_carousel'] == '1') {?> wpct_have_carousel <?php }?>
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
     data-wpct-hide-mobile="<?php echo $_smarty_tpl->tpl_vars['group']->value['mobile_breakpoint'];?>
">
    <div class="wpct_comparison_table_row">
    </div>
    <div class="wpct_table_group_row wpct_group_carousel">
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
            <div class="wpct_table_group_col">
                <div class="whmpress whmpress_pricing_table one <?php if ($_smarty_tpl->tpl_vars['plan']->value['product_id'] == $_smarty_tpl->tpl_vars['group']->value['important']) {?>featured<?php }?>">
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
</span><?php if ($_smarty_tpl->tpl_vars['plan']->value['fraction'] != '') {?>
                            <span class="decimal"><?php echo $_smarty_tpl->tpl_vars['plan']->value['decimal'];?>
</span>
                            <span class="fraction"><?php echo $_smarty_tpl->tpl_vars['plan']->value['fraction'];?>
</span><?php }?>
                            <span class="duration"><?php if ($_smarty_tpl->tpl_vars['plan']->value['duration'] != '') {?>Per <?php echo $_smarty_tpl->tpl_vars['plan']->value['duration'];
} else { ?>&nbsp;<?php }?></span>
                        </div>
                    </div>
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