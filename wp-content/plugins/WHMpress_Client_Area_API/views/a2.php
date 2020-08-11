
<div class="wcap_contactus wcap_view_container">
            <div class="whcom_margin_bottom_15 wcap_view_content">
            </div>
            <div class="wcap_view_response wcap_response_div">

            </div>

</div>

<script>
    SubmitContactForm = function ( event ) {
        event.preventDefault();
        var k = jQuery( "#wcap_contactus_from" ).serialize();
        k += "&action=wcap_requests&what=submit_contact_form&url=" + page_url;


        var view_container = jQuery('.wcap_view_container');
        var view_content = view_container.find( '.wcap_view_content' );
        var view_response = view_container.find( '.wcap_response_div' );


        view_response.html(wcap_spinner_icon).show();
        jQuery.post( wcap_ajaxurl, k, function ( data ) {
            var res = JSON.parse( data );
            console.log(res);
            view_response.show().html(res.message);
            if ( res.status === "OK" ) {
                view_content.hide();
            }
        } );
    };

</script>

<?php
// Testing codes.

echo do_shortcode("[whcom_components]");
?>


<div class="whcom_main">
	<h2>Buttonst</h2>
	<button class="whcom_button">Button</button>
	<br><br>
	<button class="whcom_button whcom_button_secondary">Button Secondary</button>
	<br><br>
	<button class="whcom_button_success">Button Success</button>
	<br><br>
	<button class="whcom_button_info">Button Info</button>
	<br><br>
	<button class="whcom_button_warning">Button Warning</button>
	<br><br>
	<button class="whcom_button_danger">Button Danger</button>
	<br><br>
	<button class="whcom_button_tiny">Button Tiny</button>
	<br><br>
	<button class="whcom_button_small">Button Small</button>
	<br><br>
	<button class="whcom_button_micro">Button Micro</button>
	<br><br>
	<button class="whcom_button_big">Button Big</button>
	<br><br>
	<button class="whcom_button_big">Button Large</button>
	<br><br>
	<button class="whcom_button_block">Button Block</button>
	<br><br>
	<button class="whcom_button_block whcom_button_large">Button Big Block</button>
	<br><br>

</div>

<div class="whcom_main">
	<h2>Grid System</h2>
	<h3>Mobile (all screens)</h3>
	<div class="whcom_row">
		<div class="whcom_col_xs_6" style="background: green"></div>
		<div class="whcom_col_xs_6" style="background: blue"></div>
	</div>
	<h3>Tablet Portrait (576px and above)</h3>
	<div class="whcom_row">
		<div class="whcom_col_sm_6" style="background: green"></div>
		<div class="whcom_col_sm_6" style="background: blue"></div>
	</div>
	<h3>Tablet Landscape (768px and above)</h3>
	<div class="whcom_row">
		<div class="whcom_col_md_6" style="background: green"></div>
		<div class="whcom_col_md_6" style="background: blue"></div>
	</div>
	<h3>Desktop (992px and above)</h3>
	<div class="whcom_row">
		<div class="whcom_col_lg_6" style="background: green"></div>
		<div class="whcom_col_lg_6" style="background: blue"></div>
	</div>
	<h3>Large Desktops (1200px and above)</h3>
	<div class="whcom_row">
		<div class="whcom_col_xl_6" style="background: green"></div>
		<div class="whcom_col_xl_6" style="background: blue"></div>
	</div>


	<h3>Responsive Example</h3>
	<div class="whcom_row">
		<div class="whcom_col_xs_6 whcom_col_sm_4 whcom_col_md_3 whcom_col_lg_2 whcom_col_xl_1" style="background: green"></div>
		<div class="whcom_col_xs_6 whcom_col_sm_4 whcom_col_md_3 whcom_col_lg_2 whcom_col_xl_1" style="background: blue"></div>
		<div class="whcom_col_xs_6 whcom_col_sm_4 whcom_col_md_3 whcom_col_lg_2 whcom_col_xl_1" style="background: green"></div>
		<div class="whcom_col_xs_6 whcom_col_sm_4 whcom_col_md_3 whcom_col_lg_2 whcom_col_xl_1" style="background: blue"></div>
		<div class="whcom_col_xs_6 whcom_col_sm_4 whcom_col_md_3 whcom_col_lg_2 whcom_col_xl_1" style="background: green"></div>
		<div class="whcom_col_xs_6 whcom_col_sm_4 whcom_col_md_3 whcom_col_lg_2 whcom_col_xl_1" style="background: blue"></div>
		<div class="whcom_col_xs_6 whcom_col_sm_4 whcom_col_md_3 whcom_col_lg_2 whcom_col_xl_1" style="background: green"></div>
		<div class="whcom_col_xs_6 whcom_col_sm_4 whcom_col_md_3 whcom_col_lg_2 whcom_col_xl_1" style="background: blue"></div>
		<div class="whcom_col_xs_6 whcom_col_sm_4 whcom_col_md_3 whcom_col_lg_2 whcom_col_xl_1" style="background: green"></div>
		<div class="whcom_col_xs_6 whcom_col_sm_4 whcom_col_md_3 whcom_col_lg_2 whcom_col_xl_1" style="background: blue"></div>
		<div class="whcom_col_xs_6 whcom_col_sm_4 whcom_col_md_3 whcom_col_lg_2 whcom_col_xl_1" style="background: green"></div>
		<div class="whcom_col_xs_6 whcom_col_sm_4 whcom_col_md_3 whcom_col_lg_2 whcom_col_xl_1" style="background: blue"></div>
	</div>
</div>

<div class="whcom_main">
	<h2>Icons</h2>
	<div class="whcom_row">
		<div title="Code: 0xe800" class="whcom_col_lg_3"><i class="whcom_icon_basket"></i>
			<span>whcom_icon_basket</span></div>
		<div title="Code: 0xe801" class="whcom_col_lg_3"><i class="whcom_icon_minus"></i> <span>whcom_icon_minus</span>
		</div>
		<div title="Code: 0xe802" class="whcom_col_lg_3"><i class="whcom_icon_like"></i> <span>whcom_icon_like</span>
		</div>
		<div title="Code: 0xe803" class="whcom_col_lg_3"><i class="whcom_icon_mail"></i> <span>whcom_icon_mail</span>
		</div>
	</div>
	<div class="whcom_row">
		<div title="Code: 0xe804" class="whcom_col_lg_3"><i class="whcom_icon_rocket"></i>
			<span>whcom_icon_rocket</span></div>
		<div title="Code: 0xe805" class="whcom_col_lg_3"><i class="whcom_icon_rocket-basket"></i>
			<span>whcom_icon_rocket-basket</span></div>
		<div title="Code: 0xe806" class="whcom_col_lg_3"><i class="whcom_icon_user"></i> <span>whcom_icon_user</span>
		</div>
		<div title="Code: 0xe807" class="whcom_col_lg_3"><i class="whcom_icon_www"></i> <span>whcom_icon_www</span>
		</div>
	</div>
	<div class="whcom_row">
		<div title="Code: 0xe808" class="whcom_col_lg_3"><i class="whcom_icon_card"></i> <span>whcom_icon_card</span>
		</div>
		<div title="Code: 0xe809" class="whcom_col_lg_3"><i class="whcom_icon_user-2"></i>
			<span>whcom_icon_user-2</span></div>
		<div title="Code: 0xe80a" class="whcom_col_lg_3"><i class="whcom_icon_ok"></i> <span>whcom_icon_ok</span></div>
		<div title="Code: 0xe80b" class="whcom_col_lg_3"><i class="whcom_icon_wrench"></i>
			<span>whcom_icon_wrench</span></div>
	</div>
	<div class="whcom_row">
		<div title="Code: 0xe80c" class="whcom_col_lg_3"><i class="whcom_icon_ok-circled"></i>
			<span>whcom_icon_ok-circled</span></div>
		<div title="Code: 0xe80d" class="whcom_col_lg_3"><i class="whcom_icon_ok-circled2"></i>
			<span>whcom_icon_ok-circled2</span></div>
		<div title="Code: 0xe80e" class="whcom_col_lg_3"><i class="whcom_icon_cancel"></i>
			<span>whcom_icon_cancel</span></div>
		<div title="Code: 0xe80f" class="whcom_col_lg_3"><i class="whcom_icon_plus"></i> <span>whcom_icon_plus</span>
		</div>
	</div>
	<div class="whcom_row">
		<div title="Code: 0xe810" class="whcom_col_lg_3"><i class="whcom_icon_cancel-circled"></i>
			<span>whcom_icon_cancel-circled</span></div>
		<div title="Code: 0xe811" class="whcom_col_lg_3"><i class="whcom_icon_cancel-circled2"></i>
			<span>whcom_icon_cancel-circled2</span></div>
		<div title="Code: 0xe812" class="whcom_col_lg_3"><i class="whcom_icon_help-circled"></i>
			<span>whcom_icon_help-circled</span></div>
		<div title="Code: 0xe813" class="whcom_col_lg_3"><i class="whcom_icon_attention-circled"></i>
			<span>whcom_icon_attention-circled</span></div>
	</div>
	<div class="whcom_row">
		<div title="Code: 0xe814" class="whcom_col_lg_3"><i class="whcom_icon_plus-circled"></i>
			<span>whcom_icon_plus-circled</span></div>
		<div title="Code: 0xe815" class="whcom_col_lg_3"><i class="whcom_icon_info-circled"></i>
			<span>whcom_icon_info-circled</span></div>
		<div title="Code: 0xe816" class="whcom_col_lg_3"><i class="whcom_icon_minus-circled"></i>
			<span>whcom_icon_minus-circled</span></div>
		<div title="Code: 0xe817" class="whcom_col_lg_3"><i class="whcom_icon_home"></i> <span>whcom_icon_home</span>
		</div>
	</div>
	<div class="whcom_row">
		<div title="Code: 0xe818" class="whcom_col_lg_3"><i class="whcom_icon_thumbs-up"></i>
			<span>whcom_icon_thumbs-up</span></div>
		<div title="Code: 0xe819" class="whcom_col_lg_3"><i class="whcom_icon_thumbs-down"></i>
			<span>whcom_icon_thumbs-down</span></div>
		<div title="Code: 0xe81a" class="whcom_col_lg_3"><i class="whcom_icon_down-open"></i>
			<span>whcom_icon_down-open</span></div>
		<div title="Code: 0xe81b" class="whcom_col_lg_3"><i class="whcom_icon_up-open"></i>
			<span>whcom_icon_up-open</span></div>
	</div>
	<div class="whcom_row">
		<div title="Code: 0xe81c" class="whcom_col_lg_3"><i class="whcom_icon_attention"></i>
			<span>whcom_icon_attention</span></div>
		<div title="Code: 0xe81d" class="whcom_col_lg_3"><i class="whcom_icon_wrench-1"></i>
			<span>whcom_icon_wrench-1</span></div>
		<div title="Code: 0xe81e" class="whcom_col_lg_3"><i class="whcom_icon_cog-alt"></i>
			<span>whcom_icon_cog-alt</span></div>
		<div title="Code: 0xe81f" class="whcom_col_lg_3"><i class="whcom_icon_cog"></i> <span>whcom_icon_cog</span>
		</div>
	</div>
	<div class="whcom_row">
		<div title="Code: 0xe820" class="whcom_col_lg_3"><i class="whcom_icon_paper-plane"></i>
			<span>whcom_icon_paper-plane</span></div>
		<div title="Code: 0xe821" class="whcom_col_lg_3"><i class="whcom_icon_database"></i>
			<span>whcom_icon_database</span></div>
		<div title="Code: 0xe822" class="whcom_col_lg_3"><i class="whcom_icon_trash"></i> <span>whcom_icon_trash</span>
		</div>
		<div title="Code: 0xe823" class="whcom_col_lg_3"><i class="whcom_icon_cog-1"></i> <span>whcom_icon_cog-1</span>
		</div>
	</div>
	<div class="whcom_row">
		<div title="Code: 0xe824" class="whcom_col_lg_3"><i class="whcom_icon_params"></i>
			<span>whcom_icon_params</span></div>
		<div title="Code: 0xe825" class="whcom_col_lg_3"><i class="whcom_icon_diamond"></i>
			<span>whcom_icon_diamond</span></div>
		<div title="Code: 0xe826" class="whcom_col_lg_3"><i class="whcom_icon_megaphone"></i>
			<span>whcom_icon_megaphone</span></div>
		<div title="Code: 0xe827" class="whcom_col_lg_3"><i class="whcom_icon_thumbs-up-1"></i>
			<span>whcom_icon_thumbs-up-1</span></div>
	</div>
	<div class="whcom_row">
		<div title="Code: 0xe828" class="whcom_col_lg_3"><i class="whcom_icon_trash-empty"></i>
			<span>whcom_icon_trash-empty</span></div>
		<div title="Code: 0xe829" class="whcom_col_lg_3"><i class="whcom_icon_right-open"></i>
			<span>whcom_icon_right-open</span></div>
		<div title="Code: 0xe82a" class="whcom_col_lg_3"><i class="whcom_icon_left-open"></i>
			<span>whcom_icon_left-open</span></div>
		<div title="Code: 0xe82b" class="whcom_col_lg_3"><i class="whcom_icon_down-dir"></i>
			<span>whcom_icon_down-dir</span></div>
	</div>
	<div class="whcom_row">
		<div title="Code: 0xe82c" class="whcom_col_lg_3"><i class="whcom_icon_up-dir"></i>
			<span>whcom_icon_up-dir</span></div>
		<div title="Code: 0xe82d" class="whcom_col_lg_3"><i class="whcom_icon_left-dir"></i>
			<span>whcom_icon_left-dir</span></div>
		<div title="Code: 0xe82e" class="whcom_col_lg_3"><i class="whcom_icon_right-dir"></i>
			<span>whcom_icon_right-dir</span></div>
		<div title="Code: 0xe839" class="whcom_col_lg_3"><i class="whcom_icon_spinner whcom_animate_spin"></i>
			<span>whcom_icon_spinner</span></div>
	</div>
	<div class="whcom_row">
		<div title="Code: 0xf0fe" class="whcom_col_lg_3"><i class="whcom_icon_plus-squared"></i>
			<span>whcom_icon_plus-squared</span></div>
		<div title="Code: 0xf100" class="whcom_col_lg_3"><i class="whcom_icon_angle-double-left"></i>
			<span>whcom_icon_angle-double-left</span></div>
		<div title="Code: 0xf101" class="whcom_col_lg_3"><i class="whcom_icon_angle-double-right"></i>
			<span>whcom_icon_angle-double-right</span></div>
		<div title="Code: 0xf102" class="whcom_col_lg_3"><i class="whcom_icon_angle-double-up"></i>
			<span>whcom_icon_angle-double-up</span></div>
	</div>
	<div class="whcom_row">
		<div title="Code: 0xf103" class="whcom_col_lg_3"><i class="whcom_icon_angle-double-down"></i>
			<span>whcom_icon_angle-double-down</span></div>
		<div title="Code: 0xf104" class="whcom_col_lg_3"><i class="whcom_icon_angle-left"></i>
			<span>whcom_icon_angle-left</span></div>
		<div title="Code: 0xf105" class="whcom_col_lg_3"><i class="whcom_icon_angle-right"></i>
			<span>whcom_icon_angle-right</span></div>
		<div title="Code: 0xf106" class="whcom_col_lg_3"><i class="whcom_icon_angle-up"></i>
			<span>whcom_icon_angle-up</span></div>
	</div>
	<div class="whcom_row">
		<div title="Code: 0xf107" class="whcom_col_lg_3"><i class="whcom_icon_angle-down"></i>
			<span>whcom_icon_angle-down</span></div>
		<div title="Code: 0xf10c" class="whcom_col_lg_3"><i class="whcom_icon_circle-empty"></i>
			<span>whcom_icon_circle-empty</span></div>
		<div title="Code: 0xf110" class="whcom_col_lg_3"><i class="whcom_icon_spinner-1 whcom_animate_spin"></i>
			<span>whcom_icon_spinner-1</span></div>
		<div title="Code: 0xf118" class="whcom_col_lg_3"><i class="whcom_icon_smile"></i> <span>whcom_icon_smile</span>
		</div>
	</div>
	<div class="whcom_row">
		<div title="Code: 0xf119" class="whcom_col_lg_3"><i class="whcom_icon_frown"></i> <span>whcom_icon_frown</span>
		</div>
		<div title="Code: 0xf11a" class="whcom_col_lg_3"><i class="whcom_icon_meh"></i> <span>whcom_icon_meh</span>
		</div>
		<div title="Code: 0xf128" class="whcom_col_lg_3"><i class="whcom_icon_help"></i> <span>whcom_icon_help</span>
		</div>
		<div title="Code: 0xf129" class="whcom_col_lg_3"><i class="whcom_icon_info"></i> <span>whcom_icon_info</span>
		</div>
	</div>
	<div class="whcom_row">
		<div title="Code: 0xf12a" class="whcom_col_lg_3"><i class="whcom_icon_attention-alt"></i>
			<span>whcom_icon_attention-alt</span></div>
		<div title="Code: 0xf146" class="whcom_col_lg_3"><i class="whcom_icon_minus-squared"></i>
			<span>whcom_icon_minus-squared</span></div>
		<div title="Code: 0xf147" class="whcom_col_lg_3"><i class="whcom_icon_minus-squared-alt"></i>
			<span>whcom_icon_minus-squared-alt</span></div>
		<div title="Code: 0xf14a" class="whcom_col_lg_3"><i class="whcom_icon_ok-squared"></i>
			<span>whcom_icon_ok-squared</span></div>
	</div>
	<div class="whcom_row">
		<div title="Code: 0xf164" class="whcom_col_lg_3"><i class="whcom_icon_thumbs-up-alt"></i>
			<span>whcom_icon_thumbs-up-alt</span></div>
		<div title="Code: 0xf165" class="whcom_col_lg_3"><i class="whcom_icon_thumbs-down-alt"></i>
			<span>whcom_icon_thumbs-down-alt</span></div>
		<div title="Code: 0xf196" class="whcom_col_lg_3"><i class="whcom_icon_plus-squared-alt"></i>
			<span>whcom_icon_plus-squared-alt</span></div>
		<div title="Code: 0xf1b3" class="whcom_col_lg_3"><i class="whcom_icon_cubes"></i> <span>whcom_icon_cubes</span>
		</div>
	</div>
	<div class="whcom_row">
		<div title="Code: 0xf1db" class="whcom_col_lg_3"><i class="whcom_icon_circle-thin"></i>
			<span>whcom_icon_circle-thin</span></div>
		<div title="Code: 0xf1f8" class="whcom_col_lg_3"><i class="whcom_icon_trash-1"></i>
			<span>whcom_icon_trash-1</span></div>
		<div title="Code: 0xf291" class="whcom_col_lg_3"><i class="whcom_icon_shopping-basket"></i>
			<span>whcom_icon_shopping-basket</span></div>
	</div>
</div>

<div class="whcom_main">
	<h2>Alerts</h2>
	<div class="whcom_alert"><span>Default: This is Simple Alert</span></div>
	<div class="whcom_alert whcom_alert_success"><span>Success: This is Simple Alert</span></div>
	<div class="whcom_alert whcom_alert_info"><span>Info: This is Simple Alert</span></div>
	<div class="whcom_alert whcom_alert_warning"><span>Warning: This is Simple Alert</span></div>
	<div class="whcom_alert whcom_alert_danger"><span>Danger: This is Simple Alert</span></div>

	<h2>Alerts with Icons</h2>
	<div class="whcom_alert whcom_alert_with_icon"><span>Default: This is Simple Alert</span></div>
	<div class="whcom_alert whcom_alert_with_icon whcom_alert_success"><span>Success: This is Simple Alert</span></div>
	<div class="whcom_alert whcom_alert_with_icon whcom_alert_info"><span>Info: This is Simple Alert</span></div>
	<div class="whcom_alert whcom_alert_with_icon whcom_alert_warning"><span>Warning: This is Simple Alert</span></div>
	<div class="whcom_alert whcom_alert_with_icon whcom_alert_danger"><span>Danger: This is Simple Alert</span></div>
</div>

<div class="whcom_main">
	<h2>DropDowns</h2>
	<div class="whcom_row">
		<div class="whcom_col_sm_3">
			<div class="whcom_dropdown">
				<span class="whcom_dropdown_toggle">Dropdown Simple</span>
				<div class="whcom_dropdown_content">
					Drop Down Content
				</div>
			</div>
		</div>
		<div class="whcom_col_sm_3">
			<div class="whcom_dropdown whcom_dropdown_hover">
				<span class="whcom_dropdown_toggle">Dropdown Hover</span>
				<div class="whcom_dropdown_content">
					Drop Down Content
				</div>
			</div>
		</div>
		<div class="whcom_col_sm_3">
			<div class="whcom_dropdown">
				<span class="whcom_dropdown_toggle whcom_button">Dropdown Button</span>
				<div class="whcom_dropdown_content">
					Drop Down Content
				</div>
			</div>
		</div>
	</div>
</div>

<div class="whcom_main">
	<h2>Tabs Simple</h2>
	<div class="whcom_tabs_container">
		<ul class="whcom_tab_links">
			<li class="whcom_tab_link active" data-tab="tab-1">Fist Tab</li>
			<li class="whcom_tab_link" data-tab="tab-2">Second Tab</li>
			<li class="whcom_tab_link" data-tab="tab-3">Third Tab</li>
		</ul>
		<div id="tab-1" class="whcom_tabs_content active">
			First Tab
		</div>
		<div id="tab-2" class="whcom_tabs_content">
			Second Tab
		</div>
		<div id="tab-3" class="whcom_tabs_content">
			<div class="whcom_tabs_container">
				<ul class="whcom_tab_links">
					<li class="whcom_tab_link whcom_current_tab_link" data-tab="tabq-1">Fist Tab</li>
					<li class="whcom_tab_link" data-tab="tabq-2">Second Tab</li>
					<li class="whcom_tab_link" data-tab="tabq-3">Third Tab</li>
				</ul>
				<div id="tabq-1" class="whcom_tabs_content  whcom_current_tab">
					First Tab
				</div>
				<div id="tabq-2" class="whcom_tabs_content">
					Second Tab
				</div>
				<div id="tabq-3" class="whcom_tabs_content">
					Third Tab
				</div>
			</div>
		</div>
	</div>

	<h2>Tabs Vertical</h2>
	<div class="whcom_tabs_container whcom_tabs_vertical">
		<ul class="whcom_tab_links">
			<li class="whcom_tab_link active" data-tab="tabv-1">Fist Tab</li>
			<li class="whcom_tab_link" data-tab="tabv-2">Second Tab</li>
			<li class="whcom_tab_link" data-tab="tabv-3">Third Tab</li>
		</ul>
		<div id="tabv-1" class="whcom_tabs_content active">
			First Tab
		</div>
		<div id="tabv-2" class="whcom_tabs_content">
			Second Tab
		</div>
		<div id="tabv-3" class="whcom_tabs_content">
			<div class="whcom_tabs_container">
				<ul class="whcom_tab_links">
					<li class="whcom_tab_link whcom_current_tab_link" data-tab="tabqv-1">Fist Tab</li>
					<li class="whcom_tab_link" data-tab="tabqv-2">Second Tab</li>
					<li class="whcom_tab_link" data-tab="tabqv-3">Third Tab</li>
				</ul>
				<div id="tabqv-1" class="whcom_tabs_content  whcom_current_tab">
					First Tab
				</div>
				<div id="tabqv-2" class="whcom_tabs_content">
					Second Tab
				</div>
				<div id="tabqv-3" class="whcom_tabs_content">
					Third Tab
				</div>
			</div>
		</div>
	</div>
</div>

<div class="whcom_main">
	<h2>Modal example</h2>
	<div id="popup" class="whcom_modal_box">
		<div class="whcom_modal_header">
			<a href="#" class="whcom_modal_close close_x">×</a>
			<h3><a href="http://www.jqueryscript.net/tags.php?/Modal/">Modal</a> Title</h3>
		</div>
		<div class="whcom_modal_body">
			<p>Modal Body</p>
		</div>
		<div class="whcom_modal_footer">
			<a href="#" class="whcom_modal_close whcom_button">Close Button</a>
		</div>
	</div>
	<a class="whcom_button whcom_modal_opener" href="#" data-modal-id="popup"> Click me </a>
</div>

<div class="whcom_main">
	<h2>Collapse Example</h2>
	<div class="whcom_collapse">
		<div class="whcom_collapse_toggle">
			<span>Collapse</span>
		</div>
		<div class="whcom_collapse_content">
			<p>Collapse Content</p>
		</div>
	</div>
</div>

<div class="whcom_main">
	<h2>Accordion Example</h2>
	<div class="whcom_accordion">
		<div class="whcom_accordion_toggle" data-accordion="acc-1">
			Accordion Toggle One
		</div>
		<div class="whcom_accordion_content" id="acc-1">
			Accordion Content One
		</div>
		<div class="whcom_accordion_toggle" data-accordion="acc-2">
			Accordion Toggle Two
		</div>
		<div class="whcom_accordion_content" id="acc-2">
			Accordion Content Two
		</div>
		<div class="whcom_accordion_toggle" data-accordion="acc-3">
			Accordion Toggle Three
		</div>
		<div class="whcom_accordion_content" id="acc-3">
			Accordion Content Three
		</div>
		<div class="whcom_accordion_toggle" data-accordion="acc-4">
			Accordion Toggle Four
		</div>
		<div class="whcom_accordion_content" id="acc-4">
			Accordion Content Four
		</div>
	</div>
</div>

<div class="whcom_main">
	<h2>Form Elements</h2>
	<div class="whcom_form_field">
		<label for="text">Text</label>
		<input type="text" name="text" id="text">
	</div>
	<div class="whcom_form_field whcom_form_field_horizontal">
		<label for="text2">Text Two</label>
		<input type="text" name="text" id="text2">
	</div>

	<div class="whcom_form_field whcom_form_field_horizontal">
		<label>Check Boxes</label>
		<div class="whcom_checkbox_container">
			<input type="checkbox" id="check-1" value="1">
			<label for="check-1">Check Box 1</label>
			<input type="checkbox" id="check-2" value="1">
			<label for="check-2">Check Box 2</label>
			<input type="checkbox" id="check-3" value="1">
			<label for="check-3">Check Box 3</label>
			<input type="checkbox" id="check-4" value="1">
			<label for="check-4">Check Box 4</label>
		</div>
	</div>

	<div class="whcom_form_field whcom_form_field_horizontal">
		<label>Radio Buttons</label>
		<div class="whcom_radio_container">
			<input type="radio" id="radio-1" value="1" name="radio">
			<label for="radio-1">radio Box 1</label>
			<input type="radio" id="radio-2" value="1" name="radio">
			<label for="radio-2">radio Box 2</label>
			<input type="radio" id="radio-3" value="1" name="radio">
			<label for="radio-3">radio Box 3</label>
			<input type="radio" id="radio-4" value="1" name="radio">
			<label for="radio-4">radio Box 4</label>
		</div>
	</div>
</div>

<div class="whcom_main">
	<h2>Panels</h2>
	<div class="whcom_row">
		<div class="whcom_col_lg_3">
			<div class="whcom_panel">
				<div class="whcom_panel_header">
					<span>Panel Simple</span>
				</div>
				<div class="whcom_panel_body">
					Panel Body Content
				</div>
			</div>
		</div>
		<div class="whcom_col_lg_3">
			<div class="whcom_panel whcom_panel_primary">
				<div class="whcom_panel_header">
					<span>Panel Primary</span>
				</div>
				<div class="whcom_panel_body">
					Panel Body Content
				</div>
			</div>
		</div>
		<div class="whcom_col_lg_3">
			<div class="whcom_panel whcom_panel_success">
				<div class="whcom_panel_header">
					<span>Panel Success</span>
				</div>
				<div class="whcom_panel_body">
					Panel Body Content
				</div>
			</div>
		</div>
		<div class="whcom_col_lg_3">
			<div class="whcom_panel whcom_panel_info">
				<div class="whcom_panel_header">
					<span>Panel Info</span>
				</div>
				<div class="whcom_panel_body">
					Panel Body Content
				</div>
			</div>
		</div>
		<div class="whcom_col_lg_3">
			<div class="whcom_panel whcom_panel_warning">
				<div class="whcom_panel_header">
					<span>Panel Warning</span>
				</div>
				<div class="whcom_panel_body">
					Panel Body Content
				</div>
			</div>
		</div>
		<div class="whcom_col_lg_3">
			<div class="whcom_panel whcom_panel_danger">
				<div class="whcom_panel_header">
					<span>Panel Danger</span>
				</div>
				<div class="whcom_panel_body">
					Panel Body Content
				</div>
			</div>
		</div>
	</div>
	<h2>Panels Fancy Style 1</h2>
	<div class="whcom_row">
		<div class="whcom_col_lg_3">
			<div class="whcom_panel whcom_panel_fancy_1">
				<div class="whcom_panel_header">
					<span>Panel Simple</span>
				</div>
				<div class="whcom_panel_body">
					Panel Body Content
				</div>
			</div>
		</div>
		<div class="whcom_col_lg_3">
			<div class="whcom_panel whcom_panel_primary whcom_panel_fancy_1">
				<div class="whcom_panel_header">
					<span>Panel Primary</span>
				</div>
				<div class="whcom_panel_body">
					Panel Body Content
				</div>
			</div>
		</div>
		<div class="whcom_col_lg_3">
			<div class="whcom_panel whcom_panel_success whcom_panel_fancy_1">
				<div class="whcom_panel_header">
					<span>Panel Success</span>
				</div>
				<div class="whcom_panel_body">
					Panel Body Content
				</div>
			</div>
		</div>
		<div class="whcom_col_lg_3">
			<div class="whcom_panel whcom_panel_info whcom_panel_fancy_1">
				<div class="whcom_panel_header">
					<span>Panel Info</span>
				</div>
				<div class="whcom_panel_body">
					Panel Body Content
				</div>
			</div>
		</div>
		<div class="whcom_col_lg_3">
			<div class="whcom_panel whcom_panel_warning whcom_panel_fancy_1">
				<div class="whcom_panel_header">
					<span>Panel Warning</span>
				</div>
				<div class="whcom_panel_body">
					Panel Body Content
				</div>
			</div>
		</div>
		<div class="whcom_col_lg_3">
			<div class="whcom_panel whcom_panel_danger whcom_panel_fancy_1">
				<div class="whcom_panel_header">
					<span>Panel Danger</span>
				</div>
				<div class="whcom_panel_body">
					Panel Body Content
				</div>
			</div>
		</div>
	</div>
	<h2>Panels Fancy Style 2</h2>
	<div class="whcom_row">
		<div class="whcom_col_lg_3">
			<div class="whcom_panel  whcom_panel_fancy_2">
				<div class="whcom_panel_header">
					<span>Panel Simple</span>
				</div>
				<div class="whcom_panel_body">
					Panel Body Content
				</div>
			</div>
		</div>
		<div class="whcom_col_lg_3">
			<div class="whcom_panel whcom_panel_primary whcom_panel_fancy_2">
				<div class="whcom_panel_header">
					<span>Panel Primary</span>
				</div>
				<div class="whcom_panel_body">
					Panel Body Content
				</div>
			</div>
		</div>
		<div class="whcom_col_lg_3">
			<div class="whcom_panel whcom_panel_success whcom_panel_fancy_2">
				<div class="whcom_panel_header">
					<span>Panel Success</span>
				</div>
				<div class="whcom_panel_body">
					Panel Body Content
				</div>
			</div>
		</div>
		<div class="whcom_col_lg_3">
			<div class="whcom_panel whcom_panel_info whcom_panel_fancy_2">
				<div class="whcom_panel_header">
					<span>Panel Info</span>
				</div>
				<div class="whcom_panel_body">
					Panel Body Content
				</div>
			</div>
		</div>
		<div class="whcom_col_lg_3">
			<div class="whcom_panel whcom_panel_warning whcom_panel_fancy_2">
				<div class="whcom_panel_header">
					<span>Panel Warning</span>
				</div>
				<div class="whcom_panel_body">
					Panel Body Content
				</div>
			</div>
		</div>
		<div class="whcom_col_lg_3">
			<div class="whcom_panel whcom_panel_danger whcom_panel_fancy_2">
				<div class="whcom_panel_header">
					<span>Panel Danger</span>
				</div>
				<div class="whcom_panel_body">
					Panel Body Content
				</div>
			</div>
		</div>
	</div>


</div>



