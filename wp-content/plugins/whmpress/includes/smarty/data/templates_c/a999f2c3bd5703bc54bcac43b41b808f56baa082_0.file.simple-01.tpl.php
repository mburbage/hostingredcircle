<?php /* Smarty version 3.1.27, created on 2020-07-22 12:07:05
         compiled from "/home/hostingredcircle/public_html/wp-content/plugins/whmpress_comp_tables/templates/whmpress_comparison_table/simple-01.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:4172224005f182be967bb25_45919631%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a999f2c3bd5703bc54bcac43b41b808f56baa082' => 
    array (
      0 => '/home/hostingredcircle/public_html/wp-content/plugins/whmpress_comp_tables/templates/whmpress_comparison_table/simple-01.tpl',
      1 => 1591815519,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4172224005f182be967bb25_45919631',
  'variables' => 
  array (
    'group' => 0,
    'random' => 0,
    'group_new' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5f182be9720854_77625130',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5f182be9720854_77625130')) {
function content_5f182be9720854_77625130 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '4172224005f182be967bb25_45919631';
?>
<style>
    .wpct_comparison_table.simple-01 .wpct_heading .wpct_holder h2 {
        background: #631d16;
        margin-bottom: 0px;
        color: #fff;
        padding: 20px 30px;
        font-size: 17px;
        text-transform: uppercase;
        font-weight: normal;
    }
    .wpct_comparison_table.simple-01 .wpct_pricing_table{
        padding:0;
    }

    .wpct_comparison_table_row.wpct_comparison_table_section_tables .wpct_price {
        display: block;
        padding: 35px 39px 28px 39px;
        margin:0;
        border: 1px solid #e2dddd;
    }

    .wpct_comparison_table.simple-01 .wpct_price .wpct_holder.monthly{
        color: #100f0d;
        font-size: 34px;
        font-weight: normal;
        margin-bottom: 0;
    }

    .wpct_comparison_table.simple-01 .wpct_price .wpct_holder.monthly span.wpct_period{
        color: #a79a98;
        font-size: 12px;
        text-transform: uppercase;
        margin-bottom: 0;
    }
    .wpct_comparison_table.simple-01 .wpct_price .wpct_holder.monthly span.wpct_unit{
        color: #aea7a6;
        font-size: 30px;
        position: relative;
        top: -12px;
        left: -2px;
    }
    .wpct_comparison_table.simple-01 .wpct_discounts_container {
        display: none;
    }
    .wpct_comparison_table.simple-01 .wpct_price .wpct_holder.annually{
        color: #100f0d;
        font-size: 34px;
        font-weight: normal;
        margin-bottom: 0;
    }


    .wpct_comparison_table.simple-01 .wpct_price .wpct_holder.annually span.wpct_period{
        color: #a79a98;
        font-size: 12px;
        text-transform: uppercase;
        margin-bottom: 0;
    }
    .wpct_comparison_table.simple-01 .wpct_price .wpct_holder.annually span.wpct_unit{
        color: #aea7a6;
        font-size: 30px;
        position: relative;
        top: -12px;
        left: -2px;
    }
    .wpct_comparison_table.simple-01 .wpct_comparison_table_row .wpct_comparison_table_col {
        border:none;
    }
    .wpct_comparison_table.simple-01 .wpct_comparison_table_row.wpct_comparison_table_section_heading{
        background: #631D16;
    }
    .wpct_comparison_table.simple-01 .wpct_comparison_table_col.wpct_comparison_table_titles_col ul.wpct_comparison_table_feature_titles li{

        text-align: center;
        color: #585c61;
        font-size: 12px;
        padding: 12px 20px;
        border-left: 1px solid #e2dddd;
        background: #fff;
        border-bottom: 1px dashed;
    }
    .wpct_comparison_table.simple-01 .wpct_comparison_table_col ul.wpct_comparison_table_feature_values li{
        padding: 0px;
        text-align: center;
        color: #585c61;
        font-size: 12px;
        padding: 12px 20px;
        border-left: 1px solid #e2dddd;
        background: #fff;
    }
    .wpct_comparison_table.simple-01 .wpct_button .wpct_holder.monthly a.wpct_submit-button.wpct_submit{
        width: 140px;
        height: 39px;
        display: block;
        background: #e94d3a;
        color: #fff;
        line-height: 39px;
        border-radius: 4px;
        margin: auto;
        text-transform: uppercase;
    }
    .wpct_comparison_table.simple-01 .wpct_button .wpct_holder.monthly a.wpct_submit-button.wpct_submit:hover{
        background: #f4260c;
    }
    .wpct_comparison_table.simple-01 .wpct_comparison_table_col ul.wpct_comparison_table_feature_values li i.fa.wpct_icon_yes.fa-check{
        color: #ffffff;
        background-color: #F08275;
        padding: 3px 3px;
        border-radius: 15px;
        font-size: 12px;
    }
    .wpct_comparison_table.simple-01 .wpct_comparison_table_col ul.wpct_comparison_table_feature_values li i.fa.wpct_icon_no.fa-close{
        color: #ffffff;
        background-color: #F08275;
        padding: 3px 4px;
        border-radius: 20px;
        font-size: 12px;
    }
    .wpct_comparison_table.simple-01 .wpct_comparison_table_col.wpct_comparison_table_titles_col ul.wpct_comparison_table_feature_titles li span.wpct_feature_title_text:before{
        content: "\f00c";
        font: normal normal normal 12px/1 FontAwesome;
        color:#F08275;
        margin-right: 2px;
    }

    @media (max-width: 768px){
        .wpct_comparison_table.simple-01 ul{
            margin: 0;
        }
    }
</style>
<div class="wpct_comparison_table simple-01 wpct_comparison_has_toggle
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

</div>

<?php }
}
?>