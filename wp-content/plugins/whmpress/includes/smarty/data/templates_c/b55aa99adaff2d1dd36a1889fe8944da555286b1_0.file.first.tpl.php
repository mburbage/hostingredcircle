<?php /* Smarty version 3.1.27, created on 2020-07-17 18:28:00
         compiled from "/home/hostingredcircle/public_html/wp-content/plugins/whmpress1/templates/ajax/first.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:3695066295f11edb0548859_98775851%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b55aa99adaff2d1dd36a1889fe8944da555286b1' => 
    array (
      0 => '/home/hostingredcircle/public_html/wp-content/plugins/whmpress1/templates/ajax/first.tpl',
      1 => 1591813713,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3695066295f11edb0548859_98775851',
  'variables' => 
  array (
    'data' => 0,
    'domains' => 0,
    'domain' => 0,
    'load_more' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5f11edb0605757_63005485',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5f11edb0605757_63005485')) {
function content_5f11edb0605757_63005485 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '3695066295f11edb0548859_98775851';
?>


<div class="whmp_domain_search_ajax_results">
	

	<?php echo '<script'; ?>
>
		function openWhois( a ) {
			window.open( a, "whmpwin", "width=600,height=600,toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=0" );
		}
	<?php echo '</script'; ?>
>


	
	<div class="whmp_search_ajax_title <?php if ($_smarty_tpl->tpl_vars['data']->value['available'] == 1) {?> whmp_found_title <?php } else { ?> whmp_not_found_title <?php }?>">
		<div class="whmp_search_ajax_domain">
			<?php echo $_smarty_tpl->tpl_vars['data']->value['domain'];?>

		</div>
		<div class="whmp_search_ajax_message">
			<?php echo $_smarty_tpl->tpl_vars['data']->value['message'];?>

		</div>
		<div class="whmp_search_ajax_buttons">
			<?php if ($_smarty_tpl->tpl_vars['data']->value['available'] == 1) {?>
			<div class="whmp_title_price">
				<?php if ($_POST['show_price'] == "1") {?><span class="whmp_domain_price"><?php echo $_smarty_tpl->tpl_vars['data']->value['price'];?>
</span><?php }?>
				<?php if ($_POST['show_years'] == "1") {?><span class="whmp_duration"><?php echo $_smarty_tpl->tpl_vars['data']->value['duration'];?>
</span><?php }?>
			</div>

			<?php if ($_smarty_tpl->tpl_vars['data']->value['order_button_text'] != '') {?>
			<a href="<?php echo $_smarty_tpl->tpl_vars['data']->value['order_url'];?>
" <?php if (mb_strtolower($_smarty_tpl->tpl_vars['data']->value['params']['order_link_new_tab'], 'UTF-8') == "1") {?> target="_blank" <?php }?> class="" <?php echo $_smarty_tpl->tpl_vars['data']->value['button_action'];?>
><i class="fa fa-cart-plus"></i>
				<?php echo $_smarty_tpl->tpl_vars['data']->value['order_button_text'];?>
</a>
			<?php echo $_smarty_tpl->tpl_vars['data']->value['hidden_form'];?>

			<?php }?>
			<?php } else { ?>
			<?php if (mb_strtolower($_POST['enable_transfer_link'], 'UTF-8') == "yes") {?>
			<a class="" href="<?php echo $_smarty_tpl->tpl_vars['data']->value['order_url'];?>
" <?php if (mb_strtolower($_smarty_tpl->tpl_vars['data']->value['params']['order_link_new_tab'], 'UTF-8') == "1") {?> target="_blank" <?php }?> <?php echo $_smarty_tpl->tpl_vars['data']->value['button_action'];?>
><?php echo $_smarty_tpl->tpl_vars['data']->value['params']['transfer_text'];?>
</a>
			<?php echo $_smarty_tpl->tpl_vars['data']->value['hidden_form'];?>

			<?php }?>
			<?php if (mb_strtolower($_POST['www_link'], 'UTF-8') != "no") {?>
			<a class="" target="_blank" href="http://<?php echo $_smarty_tpl->tpl_vars['data']->value['domain'];?>
"><?php echo $_smarty_tpl->tpl_vars['data']->value['params']['www_text'];?>
</a>
			<?php }?>
			<?php if (mb_strtolower($_POST['whois_link'], 'UTF-8') != "no") {?>
			<a class="whois-btn" onclick="openWhois('<?php echo $_smarty_tpl->tpl_vars['data']->value['whois_link'];?>
')"><?php echo $_smarty_tpl->tpl_vars['data']->value['params']['whois_text'];?>
</a>
			<?php }?>
			<?php }?>
		</div>
	</div>
	<h3><?php echo $_smarty_tpl->tpl_vars['data']->value['recommended_domains_text'];?>
</h3>
	<div class="result-div">
		<?php
$_from = $_smarty_tpl->tpl_vars['domains']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['domain'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['domain']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['domain']->value) {
$_smarty_tpl->tpl_vars['domain']->_loop = true;
$foreach_domain_Sav = $_smarty_tpl->tpl_vars['domain'];
?>
		<ul class="whmp_search_ajax_result <?php if ($_smarty_tpl->tpl_vars['domain']->value['available'] == 1) {?>whmp_found_result <?php } else { ?> whmp_not_found_result<?php }?>">
			<li class="whmp_icon"><i class="fa fa-2x fa-<?php if ($_smarty_tpl->tpl_vars['domain']->value['available'] == 1) {?>check<?php } else { ?>close<?php }?>"></i></li>
			<li class="whmp_domain"><strong><?php echo $_smarty_tpl->tpl_vars['domain']->value['domain'];?>
</strong><?php echo $_smarty_tpl->tpl_vars['domain']->value['message'];?>
</li>
			<?php if ($_POST['show_price'] != "0") {?>
			<li class="whmp_domain_price"><?php echo $_smarty_tpl->tpl_vars['domain']->value['price'];?>
</li>
			<?php }?>
			<?php if ($_POST['show_years'] != "0") {?>
			<li class="whmp_duration"><?php echo $_smarty_tpl->tpl_vars['domain']->value['duration'];?>
</li>
			<?php }?>
			<li class="whmp_search_ajax_buttons">
				<?php if ($_smarty_tpl->tpl_vars['domain']->value['available'] == 1) {?>
				<?php if ($_smarty_tpl->tpl_vars['domain']->value['order_button_text'] != '') {?>
				<a class="" href="<?php echo $_smarty_tpl->tpl_vars['domain']->value['order_url'];?>
" <?php if (mb_strtolower($_smarty_tpl->tpl_vars['data']->value['params']['order_link_new_tab'], 'UTF-8') == "1") {?> target="_blank" <?php }?> <?php echo $_smarty_tpl->tpl_vars['domain']->value['button_action'];?>
><i class="fa fa-cart-plus"></i>
					<?php echo $_smarty_tpl->tpl_vars['domain']->value['order_button_text'];?>
</a>
				<?php echo $_smarty_tpl->tpl_vars['domain']->value['hidden_form'];?>

				<?php }?>
				<?php } else { ?>
				<?php if (mb_strtolower($_POST['enable_transfer_link'], 'UTF-8') == "yes") {?>
				<a class="" <?php if (mb_strtolower($_smarty_tpl->tpl_vars['data']->value['params']['order_link_new_tab'], 'UTF-8') == "1") {?> target="_blank" <?php }?> href="<?php echo $_smarty_tpl->tpl_vars['domain']->value['order_url'];?>
" <?php echo $_smarty_tpl->tpl_vars['domain']->value['button_action'];?>
><?php echo $_smarty_tpl->tpl_vars['data']->value['params']['transfer_text'];?>
</a>
				<?php echo $_smarty_tpl->tpl_vars['domain']->value['hidden_form'];?>

				<?php }?>
				<?php if (mb_strtolower($_POST['www_link'], 'UTF-8') != "no") {?><a class="" target="_blank" href="http://<?php echo $_smarty_tpl->tpl_vars['domain']->value['domain'];?>
"><?php echo $_smarty_tpl->tpl_vars['data']->value['params']['www_text'];?>
</a><?php }?>
				<?php if (mb_strtolower($_POST['whois_link'], 'UTF-8') != "no") {?><a class="whois-btn" onclick="openWhois('<?php echo $_smarty_tpl->tpl_vars['domain']->value['whois_link'];?>
')"><?php echo $_smarty_tpl->tpl_vars['data']->value['params']['whois_text'];?>
</a><?php }?>
				<?php }?>
			</li>
		</ul>
		<?php
$_smarty_tpl->tpl_vars['domain'] = $foreach_domain_Sav;
}
?>
		<?php echo $_smarty_tpl->tpl_vars['load_more']->value;?>

	</div>
</div>


<?php }
}
?>