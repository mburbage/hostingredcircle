<?php /* Smarty version 3.1.27, created on 2020-07-17 18:48:21
         compiled from "/home/hostingredcircle/public_html/wp-content/plugins/whmpress1/templates/whmpress_price_domain_list/default.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:5838014895f11f275477809_22552719%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd97ca2f2ff391e380f460153ad7a8bba17a8a597' => 
    array (
      0 => '/home/hostingredcircle/public_html/wp-content/plugins/whmpress1/templates/whmpress_price_domain_list/default.tpl',
      1 => 1591813713,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5838014895f11f275477809_22552719',
  'variables' => 
  array (
    'data' => 0,
    'params' => 0,
    'domain' => 0,
    'show_promotions' => 0,
    'show_renewal' => 0,
    'show_trasnfer' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5f11f2754b10e8_87713785',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5f11f2754b10e8_87713785')) {
function content_5f11f2754b10e8_87713785 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '5838014895f11f275477809_22552719';
?>
<div class="whmpress_domain_price_list whmpress simple-01">
    <ul>
        <?php
$_from = $_smarty_tpl->tpl_vars['data']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['domain'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['domain']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['domain']->value) {
$_smarty_tpl->tpl_vars['domain']->_loop = true;
$foreach_domain_Sav = $_smarty_tpl->tpl_vars['domain'];
?>
            <li>
                <a <?php if ($_smarty_tpl->tpl_vars['params']->value['action_url'] != '') {?> href="<?php echo $_smarty_tpl->tpl_vars['params']->value['action_url'];?>
"<?php } else { ?> href="#"<?php }?>
                        class="<?php if ($_smarty_tpl->tpl_vars['domain']->value['details']['promo'] == '1') {?>whmpress_has_tooltip<?php }?>"
                >
                    <?php ob_start();
echo mb_strtolower($_smarty_tpl->tpl_vars['show_promotions']->value, 'UTF-8') == 'yes';
$_tmp1=ob_get_clean();
ob_start();
echo $_smarty_tpl->tpl_vars['domain']->value['details']['promo'] == '1';
$_tmp2=ob_get_clean();
if ($_tmp1 && $_tmp2) {?>
                        <span class="whmpress_tooltip">
							<strong><?php echo $_smarty_tpl->tpl_vars['domain']->value['details']['promo_text'];?>
</strong><br>
							<span><?php echo $_smarty_tpl->tpl_vars['domain']->value['details']['promo_details'];?>
</span>
						</span>
                    <?php }?>
                    <span class="domain_tld">
						<span class="domain_tld_title price_title">TLD Text:</span>
						<span class="domain_tld_value price_value"><?php echo $_smarty_tpl->tpl_vars['domain']->value['tld'];?>
</span>
					</span>
                    <span class="registration_price">
						<span class="registration_price_title price_title">Register for </span>
						<span class="registration_price_value price_value">
                        <span class="price_complete"><?php echo $_smarty_tpl->tpl_vars['domain']->value['register'];?>
</span>
                            
						</span>
					</span>
                    <span class="registration_duration">
						<span class="registration_duration_title price_title">Registration Period:</span>
						<span class="registration_duration_value price_value"><?php echo $_smarty_tpl->tpl_vars['domain']->value['years'];?>
</span>
					</span>
                    <?php ob_start();
echo mb_strtolower($_smarty_tpl->tpl_vars['show_renewal']->value, 'UTF-8') == 'yes';
$_tmp3=ob_get_clean();
ob_start();
echo $_smarty_tpl->tpl_vars['domain']->value['renewal'] != '';
$_tmp4=ob_get_clean();
if ($_tmp3 && $_tmp4) {?>
                        <span class="renew_price">
		                <span class="renew_price_title price_title">Renew Price:</span>
		                <span class="renew_price_value price_value">
	                        <span class="price_complete"><?php echo $_smarty_tpl->tpl_vars['domain']->value['renewal'];?>
</span>
		                </span>
					</span>
                    <?php }?>
                    <?php ob_start();
echo mb_strtolower($_smarty_tpl->tpl_vars['show_trasnfer']->value, 'UTF-8') == 'yes';
$_tmp5=ob_get_clean();
ob_start();
echo $_smarty_tpl->tpl_vars['domain']->value['transfer'] != '';
$_tmp6=ob_get_clean();
if ($_tmp5 && $_tmp6) {?>
                        <span class="transfer_price">
						<span class="transfer_price_title price_title">Transfer Price:</span>
						<span class="transfer_price_value price_value">
							<span class="price_complete"><?php echo $_smarty_tpl->tpl_vars['domain']->value['transfer'];?>
</span>
						</span>
					</span>
                    <?php }?>
                </a>
            </li>
        <?php
$_smarty_tpl->tpl_vars['domain'] = $foreach_domain_Sav;
}
?>
    </ul>
</div><?php }
}
?>