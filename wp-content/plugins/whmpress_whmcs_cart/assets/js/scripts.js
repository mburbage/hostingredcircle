/**
 * Main Script files for wcop plugin
 */
(
    function ($) {

        // Single Page order processing starts below
        $(document).on('ready', function () {
            $(document).find('[name="promocode"]').each(function () {
                let input = $(this);
                if (input.val()) {
                    input.closest('.whcom_checkbox_container').find('.whcom_button').trigger('click');
                }
            });
            $('#wcop_sp_product_select').trigger('change');
            $('.wcop_submit_on_load').submit().removeClass('wcop_submit_on_load');
        });
        // Change Section Active CSS class
        $(document).on('click', '.wcop_sp_section', function () {
            let this_section = $(this);
            let parent = this_section.closest('.wcop_main');
            parent.find('.wcop_sp_section').removeClass('wcop_sp_section_active');
            this_section.addClass('wcop_sp_section_active');
        });


        $(document).on('change', '.wcop_sp_main input, .wcop_sp_main select', function () {
            let input = $(this);
            if (input.hasClass('wcop_input')) {
                wcop_sp_update_product_summary();
            }
        });
        $(document).on('click', '.wcop_sp_nav > ul > li', function () {
            $(this).addClass('active').siblings('li').removeClass('active');
        });
        $(window).on('scroll', function () {
            let scrollPos = $(document).scrollTop();
            $('.wcop_sp_nav a.whcom_smooth_scroll').each(function () {
                let currLink = $(this);
                let refElement = $(currLink.attr("href"));
                let topGap = $('.wcop_sp_nav').data('scroll-top-gap') || 20;
                let elemPositionTop = refElement.position().top;
                let elemPositionBottom = refElement.position().top + parseInt(refElement.outerHeight(true)) - topGap;

                if (elemPositionTop <= scrollPos && elemPositionBottom > scrollPos) {
                    currLink.closest('li').trigger("click");
                }
            });
        });
        // Check Product Domain
        $(document).on('click', '.whcom_domain_form_item_toggle', function () {
            let toggle = $(this);
            let this_option = toggle.closest('.whcom_domain_form_item_container');
            let parent = toggle.closest('.whcom_domain_form_container');
            parent.find('.whcom_domain_form_item_container').each(function () {
                let curr_option = $(this);
                if (curr_option[0] !== this_option[0]) {
                    curr_option.children('.whcom_domain_form_item_content').slideUp('fast', function () {
                        curr_option.removeClass('active');
                    });
                }
            });
            if (!this_option.hasClass('active')) {
                this_option.children('.whcom_domain_form_item_content').slideDown('fast', function () {
                    this_option.addClass('active');
                });
            }
        });
        $(document).on('submit', '.wcop_sp_check_product_domain', function (e) {
            e.preventDefault();
            let form = $(this);
            let product_selector = $('#wcop_sp_product_select');
            let selected_option = product_selector.find(':selected');
            let main_form = product_selector.closest('form.wcop_sp_add_product');
            let response_container = $('.wcop_sp_domain_response');
            let submit = form.find('button[type="submit"]');
            let submit_val = submit.html();
            let is_free_domain_attached = selected_option.data('is-free-domain-attached');


            let data = $(this).serializeArray();
            pid = main_form.find('[name="get_product_id"]').val();
            default_billingcycle = main_form.find('[name="default_billingcycle"]').val();
            data.push({'name': 'pid', 'value': pid});
            data.push({'name': 'default_billingcycle', 'value': default_billingcycle});
            data.push({'name': 'is_free_domain_attached', 'value': is_free_domain_attached});
            let cart_index = -1;
            if (form.hasClass('domain_already_in_cart')) {
                let tld = form.find('select[name="domain"] :selected').data('domain-tld');
                let domain_type = form.find('select[name="domain"] :selected').data('domain-type');
                cart_index = form.find('select[name="domain"] :selected').data('cart-index');
                data.push({'name': 'ext', 'value': tld});
                data.push({'name': 'domaintype', 'value': domain_type});
            }
            submit.html(whcom_spinner_icon_only);
            response_container.html(whcom_spinner_block);
            jQuery.ajax({
                url: wcop_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    let res = JSON.parse(response);
                    console.log(res);
                    submit.html(submit_val);
                    if (res.status === "OK") {
                        response_container.html(res.domain_attachment_form);
                        $('input[name="cart_index"]').val(cart_index);
                        if (res.type === 'existing') {
                            $('.wcop_sp_attach_product_domain').submit();
                        }
                        if (form.hasClass('domain_already_in_cart')) {
                            $('.wcop_sp_attach_product_domain').submit();
                        }
                    } else {
                        response_container.html(res.message);
                    }
                }
            });
        });
        // Reset Domain Form
        $(document).on('click', '.wcop_sp_reset_domain_form', function (e) {
            e.preventDefault();
            let response_container = $('.wcop_sp_domain_response');
            response_container.empty();
            $('#domain').focus();
            $('form.wcop_sp_check_product_domain').each(function () {
                $(this)['0'].reset()
            });
        });
        // Attach Product Domain
        $(document).on('submit', '.wcop_sp_attach_product_domain', function (e) {
            e.preventDefault();
            let form = $(this);
            let product_selector = $('#wcop_sp_product_select');
            let main_form = product_selector.closest('form.wcop_sp_add_product');
            let domain_options_container = $('#wcop_sp_domain_config');
            let submit = form.find('button[type="submit"]');
            let submit_val = submit.html();
            let selected_product = product_selector.find(':selected').val();
            let products_select = $('#wcop_sp_product_select_domains').html();
            let domain_notice = main_form.find('#wcop_sp_product_domain_notice');

            if (domain_notice.show()) {
                domain_notice.hide();
            }


            let data = $(this).serializeArray();
            pid = main_form.find('[name="get_product_id"]').val();
            default_billingcycle = main_form.find('[name="default_billingcycle"]').val();
            wcop_sp_template = main_form.find('[name="wcop_sp_template"]').val();
            data.push({'name': 'pid', 'value': pid});
            data.push({'name': 'default_billingcycle', 'value': default_billingcycle});
            data.push({'name': 'wcop_sp_template', 'value': wcop_sp_template});
            if (data[3].value === "transfer") {
                window.eppcode = data[5].value;
            }
            submit.html(whcom_spinner_icon).prop('disabled', true);

            //== Change Summary section heading either it is empty or populated with content
            jQuery('.whcom_empty_summary_section_heading').css('display', 'none');
            jQuery('.whcom_filled_summary_section_heading').css("display", "block");

            domain_options_container.hide();
            jQuery.ajax({
                url: wcop_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    let res = JSON.parse(response);
                    console.log(res);
                    if (res.status === "OK") {
                        $('#wcop_sp_choose_a_domain').slideUp('400', function () {
                            $(this).hide();
                        });
                        $("#wcop_sp_domain_config").show();
                        $('[href="#wcop_sp_choose_a_domain"]').prop('href', '#wcop_sp_domain_config');
                        submit.html(submit_val).prop('disabled', false);
                        if (res.free_domain === true) {
                            //domain_options_container.show().find( '.wcop_sp_section_content' ).html( res.domain_config_form ).prop('disabled',true);
                        } else {
                            domain_options_container.show().find('.wcop_sp_section_content').html(res.domain_config_form);
                        }
                        $('.wcop_input[name="regperiod"]').trigger('change');
                    } else {
                        $('.wcop_sp_domain_response').html(res.message, function () {
                            wcop_sp_update_product_summary();
                        });
                    }
                }
            });
        });
        // Select/Change Product
        $(document).on('change', '#wcop_sp_product_select', function () {
            let product_select = $('#wcop_sp_product_select');
            //let product_select = $( this );
            let selected_option = product_select.find(':selected');
            let main_form = product_select.closest('form.wcop_sp_add_product');
            let options_spinner = main_form.find('.wcop_sp_product_options_spinner');
            let options_container = main_form.find('#wcop_additional_services');
            let billingcycle_container = main_form.find('.wcop_sp_prod_billingcycle');
            let domain = main_form.find('input[name=domain]').val();
            let domain_attached = main_form.find('input[name=attached_domain]').val();
            let domain_required = selected_option.data('domain-required');
            let domain_notice = main_form.find('#wcop_sp_product_domain_notice');
            let wcop_sp_template = main_form.find('[name="wcop_sp_template"]').val();
            //== picking free domain notice div to show or hide
            let is_free_domain_attached = selected_option.data('is-free-domain-attached');
            let free_domain_notice = main_form.find('#wcop_sp_product_free_domain_notice');

            if (domain === undefined && domain_attached === undefined && domain_required === 'yes') {
                domain_notice.show();
            } else {
                domain_notice.hide();
            }

            //== show or hide free domain notice
            if (wcop_sp_template === '08_gator') {
                if (is_free_domain_attached === 'yes') {
                    free_domain_notice.show();
                } else {
                    free_domain_notice.hide();
                }
            }

            let data = {};
            data.action = "wcop_sp_process";
            data.wcop_sp_what = "change_product";
            data.default_billingcycle = main_form.find('[name="default_billingcycle"]').val();
            data.pid = $(this).val();
            //== Add wcop template options
            data.wcop_sp_template = wcop_sp_template;
            console.log(data);
            if (domain_attached === 'yes') {
                data.tld = main_form.find('[name=tld]').val();
                data.sld = main_form.find('[name=sld]').val();
                data.domain = main_form.find('[name=domain]').val();
                data.domaintype = main_form.find('[name=domaintype]').val();
            }
            options_spinner.show();
            billingcycle_container.html(whcom_spinner_block);
            options_container.hide();
            $.ajax({
                url: wcop_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    let res = JSON.parse(response);
                    console.log('I am in product select');
                    console.log(res);
                    if (res.status === "OK") {
                        options_spinner.hide();
                        billingcycle_container.html(res.response_html.billingcycles);
                        if (res.options_available) {
                            if (res.template_name === '03_bold' || res.template_name === '02_sleek_minimal' || res.template_name === '06_sleek') {
                                options_container.hide();
                            } else {
                                options_container.show();
                            }
                            options_container.find('.wcop_sp_section_content').html(res.response_html.configurations);
                        } else {
                            options_container.find('.wcop_sp_section_content').html('This product has no configureable options');
                        }
                        if (res.domain_options && res.domain_options.status === 'OK' && main_form.find('[name=free_domain]').val() !== res.domain_options.free_domain) {
                            main_form.find('#wcop_sp_domain_config').html(res.domain_options.domain_config_form);
                        }
                        window.renderWhcomCollapse();
                        main_form.find('#wcop_sp_product_billingcycle').trigger('change');
                    } else {
                        billingcycle_container.html(res.message);
                    }
                }
            });
        });
        // Select/Change Product Billingcycle
        $(document).on('change', '#wcop_sp_product_billingcycle', function () {
            let billingcycle_select = $(this);
            let main_form = billingcycle_select.closest('form.wcop_sp_add_product');
            let options_spinner = main_form.find('.wcop_sp_product_options_spinner');
            let options_container = main_form.find('.wcop_sp_config_options_container');
            let domain_attached = main_form.find('input[name=attached_domain]').val();

            let data = {};
            data.action = "wcop_sp_process";
            data.wcop_sp_what = "change_billingcycle";
            data.pid = main_form.find('[name="pid"]').val();
            data.billingcycle = billingcycle_select.val();
            if (domain_attached === 'yes') {
                data.tld = main_form.find('[name=tld]').val();
                data.sld = main_form.find('[name=sld]').val();
                data.domain = main_form.find('[name=domain]').val();
                data.domaintype = main_form.find('[name=domaintype]').val();
            }

            options_spinner.show();
            //== Commented because configurable options section was not showing
            /*options_container.hide();*/
            $.ajax({
                url: wcop_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    let res = JSON.parse(response);
                    options_spinner.hide();
                    if (res.status === "OK") {
                        if (res.options_available) {
                            options_container.show().html(res.options_html);
                        }
                        if (res.domain_options && res.domain_options.status === 'OK' && main_form.find('[name=free_domain]').val() !== res.domain_options.free_domain) {
                            main_form.find('#wcop_sp_domain_config').html(res.domain_options.domain_config_form);
                        }
                    }
                }
            });
        });
        // Add Remove discount coupon
        $(document).on('click', '.wcop_sp_apply_remove_coupon', function (e) {
            e.preventDefault();
            let button = $(this);
            let button_text = button.html();
            let coupon_container = button.closest('.wcop_sp_promo_container');
            let coupon_response = coupon_container.find('.wcop_sp_coupon_response');
            let promo_action = button.data('promo-action');
            let promocode = coupon_container.find('input[name="promocode"]').val();

            let data = {
                action: "wcop_sp_process",
                wcop_sp_what: "add_remove_coupon",
                promo_action: promo_action,
                promocode: promocode
            };
            button.html(whcom_spinner_icon_only);
            $.ajax({
                url: wcop_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    let res = JSON.parse(response);
                    console.log('I am here in coupon section');
                    console.log(res);
                    button.html(button_text);
                    if (res.status === "OK") {
                        coupon_container.html(res.response_html);
                        wcop_sp_update_product_summary();
                    } else {
                        coupon_response.html(res.message);
                        wcop_sp_update_product_summary();
                    }
                }
            });

        });
        // Add Remove discount coupon
        $(document).on('click', '.wcop_sp_summary_apply_remove_coupon', function (e) {
            e.preventDefault();
            let button = $(this);
            let button_text = button.html();
            let coupon_container = button.closest('.wcop_sp_promo_container');
            let coupon_response = coupon_container.find('.wcop_sp_coupon_response');
            let promo_action = button.data('promo-action');
            let promo_input = coupon_container.find('input[name="promocode"]');
            let promocode = promo_input.val();
            button.html(whcom_spinner_icon_only);
            if (promo_action === 'add_coupon') {
                console.log("I am here in add coupon");
                $('form.wcop_sp_add_product [name=promocode]').prop('value', promocode);
                wcop_sp_update_product_summary();
            } else if (promo_action === 'remove_coupon') {
                $('form.wcop_sp_add_product [name=promocode]').prop('value', '');
                console.log('Removing Coupon');
                wcop_sp_update_product_summary();
            }
        });
        // Estimate Taxes
        $(document).on('click', '.wcop_sp_estimate_taxes_button', function (e) {
            e.preventDefault();
            let button = $(this);
            let button_text = button.html();
            let container = button.closest('.wcop_sp_estimate_taxes_container');
            let country = container.find('[name="estimate_tax_country"]').val();
            let state = container.find('[name="estimate_tax_state"]').val();

            let data = {
                action: "wcop_sp_process",
                wcop_sp_what: "estimate_taxes",
                country: country,
                state: state
            };
            button.html(whcom_spinner_icon);
            $.ajax({
                url: wcop_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    let res = JSON.parse(response);
                    button.html(button_text);
                    if (res.status === "OK") {
                        wcop_sp_update_product_summary();
                    }
                }
            });

        });
        // Add Product to local cart Form
        $(document).on('submit', '.wcop_sp_add_product', function (e) {
            e.preventDefault();
            let $form = $(this);
            let response_field = $form.find('.whcom_sp_order_response');
            let response_div = $('#wcop_sp_main');
            let spepp = window.eppcode;
            let data = $(this).serializeArray();
            /*var elmnt = document.getElementById("wcop_sp_login_register_container");
            elmnt.scrollIntoView();*/
            data.push({'name': 'eppcode', 'value': spepp});
            response_field.show();
            response_field.html(whcom_spinner_icon);
            jQuery.ajax({
                url: wcop_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    let res = JSON.parse(response);
                    response_field.addClass('whcom_alert whcom_alert_warning whcom_alert_with_icon');
                    response_field.html(res.message);
                    whcom_show_notification(res.message, 'whcom_alert whcom_alert_danger');
                    console.log("I am here");
                    console.log(res.message);
                    if (res.message === 'Your product has been ordered...') {
                        window.scrollTo(0, 0);
                    }
                    if (res.status === "OK") {
                        response_div.html(res.response_html);
                        if (res.show_cc === 'show_invoice') {
                            $('.wcop_view_invoice_button').trigger('click');
                        }
                    } else if (res.status === 'invoice_generated') {
                        response_div.html(res.response_html).prepend(res.response_html);
                    } else {
                    }
                }
            });
        });
        // Payment gateway switching,
        $(document).on('change', '.whcom_sp_cc_switcher', function () {
            let checkbox = $(this);
            let cc_options_container = $('.whcom_sp_cc_fields');
            if (checkbox.val() === checkbox.data('merchent-gateway')) {
                cc_options_container.slideDown(300);
            } else {
                cc_options_container.slideUp(300);
            }
        });
        // Client Type Switching,
        $(document).on('whcomTabChanged', '.wcop_sp_client_type_switch', function () {
            let tab = $(this);
            let type_input = $('input[name="wcop_sp_client_type"]');
            let login_container = $('#wcop_sp_user_login');
            let register_container = $('#wcop_sp_register_account');

            login_container.find('[required]').each(function () {
                $(this).prop('required', false).addClass('wcop_sp_required');
            });
            register_container.find('[required]').each(function () {
                $(this).prop('required', false).addClass('wcop_sp_required');
            });


            if (tab.data('tab') === 'wcop_sp_register_account') {
                type_input.val('register');
                register_container.find('.wcop_sp_required').each(function () {
                    $(this).prop('required', true).removeClass('wcop_sp_required');
                });
            } else {
                type_input.val('login');
                login_container.find('.wcop_sp_required').each(function () {
                    $(this).prop('required', true).removeClass('wcop_sp_required');
                });
            }
        });
        $(document).on('click', '#wcop_sp_register_account_link', function (e) {
            e.preventDefault();
            let login_container = $('#wcop_sp_user_login');
            let register_container = $('#wcop_sp_register_account');
            $('#wcop_sp_register_account_link').fadeOut('', function () {
                $('#wcop_sp_user_login_link').fadeIn('', function () {
                    login_container.slideUp('', function () {
                        register_container.slideDown('', function () {
                            $('input[name="wcop_sp_client_type"]').val('register');
                            login_container.find('[required]').each(function () {
                                $(this).prop('required', false).addClass('wcop_sp_required');
                            });
                            register_container.find('[required]').each(function () {
                                $(this).prop('required', false).addClass('wcop_sp_required');
                            });
                            register_container.find('.wcop_sp_required').each(function () {
                                $(this).prop('required', true).removeClass('wcop_sp_required');
                            });
                        });
                    });
                });
            });
        });
        $(document).on('click', '#wcop_sp_user_login_link', function (e) {
            e.preventDefault();
            let login_container = $('#wcop_sp_user_login');
            let register_container = $('#wcop_sp_register_account');
            $('#wcop_sp_user_login_link').fadeOut('', function () {
                $('#wcop_sp_register_account_link').fadeIn('', function () {
                    register_container.slideUp('', function () {
                        login_container.slideDown('', function () {
                            $('input[name="wcop_sp_client_type"]').val('login');
                            login_container.find('[required]').each(function () {
                                $(this).prop('required', false).addClass('wcop_sp_required');
                            });
                            register_container.find('[required]').each(function () {
                                $(this).prop('required', false).addClass('wcop_sp_required');
                            });
                            login_container.find('.wcop_sp_required').each(function () {
                                $(this).prop('required', true).removeClass('wcop_sp_required');
                            });
                        });
                    });
                });
            });
        });
        $(document).on('click', '#wcop_sp_login_register_container button', function (e) {
            e.preventDefault();
            let button = $(this);
            let button_text = button.html();
            let section_container = button.closest('#wcop_billing_info');
            let register_form = section_container.find('#wcop_sp_register_account');
            let login_form = section_container.find('#wcop_sp_user_login');
            let main_form = button.closest('form');
            button.html(whcom_spinner_icon_only);
            if (button.prop('id') === 'wcop_register_form_login_toggle') {
                register_form.hide();
                login_form.show();
                button.html(button_text);
            }
            if (button.prop('id') === 'wcop_login_form_register_toggle') {
                register_form.show();
                login_form.hide();
                button.html(button_text);
            }
            if (button.prop('id') === 'wcop_login_form_login_button') {
                let login_button = login_form.find('#wcop_login_form_login_button');
                let login_button_text = login_button.text();
                login_button.html(whcom_spinner_icon);
                let data = {};
                data.action = "wcop_sp_process";
                data.wcop_sp_what = 'process_login';
                data.login_email = login_form.find('[name="login_email"]').val();
                data.login_pass = login_form.find('[name="login_pass"]').val();
                data.wcop_sp_template = main_form.find('[name="wcop_sp_template"]').val();
                jQuery.ajax({
                    url: whcom_ajax.ajax_url,
                    type: 'post',
                    data: data,
                    success: function (response) {
                        let res = JSON.parse(response);
                        login_button.text(login_button_text);
                        if (res.status === 'OK') {
                            whcom_show_notification(res.message, 'whcom_alert whcom_alert_success');
                            section_container.html(res.register_html);
                            button.html(button_text);
                        } else {
                            whcom_show_notification(res.message, 'whcom_alert whcom_alert_danger');
                            console.log(res);
                            button.html(button_text);
                        }
                    }
                });
            }
            if (button.prop('id') === 'wcop_login_form_logout_button') {
                let data = {};
                data.action = "wcop_sp_process";
                data.wcop_sp_what = 'process_logout';
                data.wcop_sp_template = main_form.find('[name="wcop_sp_template"]').val();
                jQuery.ajax({
                    url: whcom_ajax.ajax_url,
                    type: 'post',
                    data: data,
                    success: function (response) {
                        let res = JSON.parse(response);
                        console.log(res);
                        if (res.status === 'OK') {
                            whcom_show_notification(res.message, 'whcom_alert whcom_alert_success');
                            section_container.html(res.client_html);
                            button.html(button_text);
                        } else {
                            whcom_show_notification(res.message, 'whcom_alert whcom_alert_danger');
                            console.log(res);
                            button.html(button_text);
                        }
                    }
                });
            }
        });


        // Domain first order processing starts below
        // TLD add/remove form (whmpress)
        $(document).on('change', 'input[name="whcom_tld_add_remove"]', function (e) {
            e.preventDefault();

            let checkbox = $(this);
            let cart_index = checkbox.data('cart-index');
            let checkbox_id = checkbox.prop('id');
            let domain_action = (
                checkbox.prop('checked')
            ) ? 'add_item' : 'delete_item';

            let title_label = $('label[for="' + checkbox_id + '"].title_label');

            let icon_label = $('label[for="' + checkbox_id + '"].label_icon');
            let add_div = $('#' + checkbox_id + '_add_sub');
            let add_div_html = add_div.html();
            let remove_div = $('#' + checkbox_id + '_remove_sub');
            let remove_div_html = remove_div.html();


            checkbox.prop("disabled", true);
            title_label.html(whcom_spinner_icon);
            icon_label.find('i').removeClass().addClass('whcom_icon_spinner-1 whcom_animate_spin');
            remove_div.find('label > i').removeClass().addClass('whcom_icon_spinner-1 whcom_animate_spin');
            add_div.find('label').html(whcom_spinner_icon);
            if (domain_action === 'add_item') {
                remove_div.hide();
            } else {
                add_div.hide();
            }


            let data = {};
            data.action = "wcop_domain_first";
            data.cart_index = cart_index;
            data.wcop_what = "add_remove_domain";
            data.domain_action = domain_action;
            data.domain = checkbox.data('domain');
            data.domain_type = checkbox.data('domain-type');
            data.domain_price = checkbox.data('domain-price');
            data.domain_duration = checkbox.data('domain-duration');


            jQuery.ajax({
                url: wcop_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    let res = JSON.parse(response);
                    title_label.html(res.message);
                    checkbox.prop("disabled", false);


                    remove_div.find('label > i').removeClass().addClass('whcom_icon_spinner-1 whcom_animate_spin');
                    add_div.html(add_div_html);
                    remove_div.html(remove_div_html);

                    if (res.status === "OK") {
                        checkbox.data('cart-index', res.cart_index);
                        if (domain_action === 'add_item') {
                            icon_label.find('i').removeClass().addClass('whcom_icon_ok-circled2');
                            add_div.hide();
                            remove_div.show();
                        } else {
                            icon_label.find('i').removeClass().addClass('whcom_icon_circle-empty');
                            add_div.show();
                            remove_div.hide();
                        }
                    } else {
                        checkbox.prop('checked', false).prop('disabled', true);
                    }
                }
            });
        });
        // TLD select continue button (whmpress, after select all desired tlds, it will move now to wcop territory)
        $(document).on('click', '#wcop_df_domain_submit_button', function (e) {
            e.preventDefault();
            let button = $(this);
            let checked = $('input[name="whcom_tld_add_remove"]:checked').length;
            if (checked > 0) {
                window.location.href = button.prop('href');
            } else {
                alert('Kindly select at least one domain');
            }
        });
        // Domain Search Form (wcop, if domain is not added already by whmpress)
        $(document).on('submit', '.wcop_df_domain_search_form', function (e) {
            e.preventDefault();
            let $form = $(this);
            let container = $form.parents('#wcop_df_container');
            let result = container.find('.wcop_df_domain_search_result_content');
            let submit = $form.find('button');
            let submit_val = submit.html();


            let data = $form.serializeArray();
            submit.html(whcom_spinner_icon);
            result.hide();
            jQuery.ajax({
                url: wcop_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    let res = JSON.parse(response);
                    submit.html(submit_val);
                    if (res.status === "OK") {
                        result.html(res.response_form).show();
                    } else {
                        result.html(res.message).show();
                    }
                }
            });
        });
        // Domain Submit Form (wcop, if domain is not added already by whmpress)
        $(document).on('submit', '#wcop_df_domain_search_submit', function (e) {
            e.preventDefault();
            let container = $(this).parents('#wcop_df_container');
            let data = $(this).serializeArray();
            container.html(whcom_spinner_icon);
            jQuery.ajax({
                url: wcop_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    let res = JSON.parse(response);
                    if (res.status === "OK") {
                        container.html(res.response_form);
                    } else {
                        container.html(res.message);
                    }
                }
            });
        });
        // TLD dropdown for product selection (populate product selection form based on domain dropdown change)
        $(document).on('change', 'input[name=wcop_df_domain_selector]', function (e) {
            e.preventDefault();

            let radio = $(this);
            let main_container = radio.parents('.wcop_df_container');
            let domains_container = main_container.find('.wcop_df_domain_selector_container');
            let checked_radio = domains_container.find(':checked');
            let cart_index = checked_radio.data('cart-index');
            let cart_product = checked_radio.data('domain-product');
            let domain_name = checked_radio.data('domain-name');
            let product_wrapper = $('.wcop_df_products_wrapper');

            domains_container.find('input[name=wcop_df_domain_selector]').each(function () {
                let $curr_radio = $(this);
                if ($curr_radio.prop('checked')) {
                    $curr_radio.parents('label.whcom_alert').addClass('whcom_bordered_2x');
                } else {
                    $curr_radio.parents('label.whcom_alert').removeClass('whcom_bordered_2x');
                }
            });


            product_wrapper.html(whcom_spinner_icon);
            main_container.find('.wcop_df_select_product_domain_name').text(domain_name);
            let data = {};
            data.action = "wcop_domain_first";
            data.wcop_what = "get_domain_products";
            data.cart_index = cart_index;
            data.cart_product = cart_product;
            data.pids = $('input[name="pids"]').val();
            data.gids = $('input[name="gids"]').val();
            jQuery.ajax({
                url: wcop_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    let res = JSON.parse(response);
                    if (res.status === "OK") {
                        product_wrapper.html(res.products);
                    } else {
                        product_wrapper.html(res.message);
                    }
                }
            });
        });
        // Product add/remove for a tld
        $(document).on('change', 'input[name="whcom_product_add_remove"]', function (e) {
            e.preventDefault();

            let checkbox = $(this);
            let main_container = checkbox.parents('.wcop_df_container');
            let checkbox_id = checkbox.prop('id');
            let product_box = $('#wcop_df_product_' + checkbox_id);
            product_box.find('.wcop_df_product_icon i').removeClass().addClass('whcom_icon_spinner-1 whcom_animate_spin');


            let domains_container = main_container.find('.wcop_df_domain_selector_container');
            let selected_domain = domains_container.find(':checked');
            let selected_domain_container = selected_domain.parents('label');

            let cart_index = selected_domain.data('cart-index');
            $(document).find('input[name="whcom_product_add_remove"]').not(checkbox).each(function () {
                let checkbox_other = $(this);
                let checkbox_other_id = checkbox_other.prop('id');
                let product_box_other = $('#wcop_df_product_' + checkbox_other_id);
                product_box_other.find('.whcom_button').removeClass('whcom_button_danger');
                product_box_other.find('.add_text').show();
                product_box_other.find('.remove_text').hide();
                product_box_other.find('.wcop_df_product_icon i').removeClass().addClass('whcom_icon_circle-empty');

                checkbox_other.prop('checked', false);
            });

            let product_action = (
                checkbox.prop('checked')
            ) ? 'add_item' : 'delete_item';


            checkbox.prop("disabled", true);


            let data = {};
            data.action = "wcop_domain_first";
            data.wcop_what = "attach_domain_product";
            data.pid = checkbox.data('product-id');
            data.cid = checkbox.data('product-currency');
            data.billingcycle = checkbox.data('product-billingcycle');
            data.product_name = checkbox.data('product-name');
            data.product_price = checkbox.data('product-price');
            data.product_setup = checkbox.data('product-setup');
            data.cart_index = cart_index;
            data.product_action = product_action;

            jQuery.ajax({
                url: wcop_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    let res = JSON.parse(response);
                    checkbox.prop("disabled", false);
                    if (res.status === "OK") {
                        checkbox.data('cart-index', res.cart_index);
                        if (product_action === 'add_item') {
                            product_box.find('.wcop_df_product_icon i').removeClass().addClass('whcom_icon_ok-circled2');
                            selected_domain_container.addClass('.whcom_border_success whcom_text_success').find('.whcom_domain_product').text(checkbox.data('product-name'));
                            selected_domain_container.find('.whcom_pill').show();
                            product_box.find('.whcom_button').addClass('whcom_button_danger');
                            product_box.find('.add_text').hide();
                            product_box.find('.remove_text').show();
                        } else {
                            product_box.find('.wcop_df_product_icon i').removeClass().addClass('whcom_icon_circle-empty');
                            selected_domain_container.removeClass('.whcom_border_success whcom_text_success').find('.whcom_domain_product').text(selected_domain_container.data('domain-product-text'));
                            selected_domain_container.find('.whcom_pill').hide();
                            product_box.find('.whcom_button').removeClass('whcom_button_danger');
                            product_box.find('.add_text').show();
                            product_box.find('.remove_text').hide();
                        }
                    } else {
                        checkbox.prop('checked', false).prop('disabled', true);
                    }
                }
            });
        });
        // Continue when product attachment is completed (after attaching products with all/any domains)
        $(document).on('click', '#wcop_df_products_continue', function (e) {
            e.preventDefault();
            let button = $(this);
            let container = $(this).parents('#wcop_df_container');

            let data = {};
            data.action = "wcop_domain_first";
            data.wcop_what = "domain_products_attached";


            button.html(whcom_spinner_icon);

            jQuery.ajax({
                url: wcop_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    let res = JSON.parse(response);
                    if (res.status === "OK") {
                        container.html(res.response_form);
                        window.renderWhcomTabs();
                    } else {
                        alert('Something went wrong...');
                        window.location.reload();
                    }
                }
            });
        });
        // Domains Config Form
        $(document).on('submit', '.wcop_df_domains_config_form', function (e) {
            e.preventDefault();
            let form = $(this);
            let submit = form.find('button[type="submit"]');
            let submit_val = submit.text();
            let container = form.parents('#wcop_df_container');
            submit.html(whcom_spinner_icon);
            let data = form.serializeArray();
            jQuery.ajax({
                url: wcop_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    let res = JSON.parse(response);
                    submit.text(submit_val);
                    if (res.status === "OK") {
                        container.html(res.response_form);
                        wcop_df_update_product_summary();
                        $(".whcom_sticky_item").whcom_sticky({
                            'parent': '.whcom_main',
                            'offset_top': 40
                        });
                        $('html,body').animate({
                            scrollTop: 100
                        }, 700);
                    } else {
                    }
                }
            });
        });
        // Recalculate Product Config Options
        $(document).on('change', '.wcop_billingcycle_selector', function (e) {
            e.preventDefault();

            let select = $(this);
            let selected = select.find(':selected');
            let cart_index = select.data('cart-index');
            let billingcycle = selected.data('billingcycle');
            let product_id = select.data('product-id');
            let options_wrapper = $('#wcop_df_product_options_' + cart_index);


            options_wrapper.html(whcom_spinner_icon);
            let data = {};
            data.action = "wcop_domain_first";
            data.wcop_what = "get_product_options";
            data.cart_index = cart_index;
            data.billingcycle = billingcycle;
            data.product_id = product_id;

            jQuery.ajax({
                url: wcop_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    let res = JSON.parse(response);
                    if (res.status === "OK") {
                        options_wrapper.html(res.response_form);
                        wcop_df_update_product_summary();
                    } else {
                        options_wrapper.html(res.message);
                    }
                }
            });
        });
        // Recalculate Product Summaries
        $(document).on('change', '#wcop_df_container .wcop_input', function () {
            wcop_df_update_product_summary();
        });
        // Products Config Form
        $(document).on('submit', '.wcop_df_products_config_form', function (e) {

            e.preventDefault();
            let form = $(this);
            let submit = form.find('button[type="submit"]');
            let submit_val = submit.text();
            let container = form.parents('#wcop_df_container');
            let response_text = container.find('.wcop_contacts_response');
            submit.html(whcom_spinner_icon);
            response_text.html(whcom_spinner_icon).show();
            let data = form.serializeArray();
            jQuery.ajax({
                url: wcop_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    let res = JSON.parse(response);
                    submit.text(submit_val);
                    if (res.status === "OK") {
                        container.html(res.response_form);
                        whcom_op_update_cart_summaries();
                        $('html,body').animate({
                            scrollTop: 100
                        }, 700);
                    } else {
                        response_text.html(res.message).show();
                    }
                }
            });
        });
        // Order Checkout
        $(document).on('submit', '.wcop_df_review_form', function (e) {
            e.preventDefault();
            let form = $(this);
            let submit = form.find('button[type="submit"]');
            let submit_val = submit.text();
            let container = form.parents('#wcop_df_container');
            submit.html(whcom_spinner_icon);
            let data = form.serializeArray();
            jQuery.ajax({
                url: wcop_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    let res = JSON.parse(response);
                    submit.text(submit_val);
                    if (res.status === "OK") {
                        container.html(res.response_form);
                        $('html,body').animate({
                            scrollTop: 100
                        }, 700);
                    }
                }
            });
        });
        $(document).on('submit', '.wcop_df_checkout_form', function (e) {
            e.preventDefault();
            let form = $(this);
            let submit = form.find('button[type="submit"]');
            let submit_val = submit.text();
            let container = form.parents('#wcop_df_container');
            let response_text = container.find('.wcop_contacts_response');
            submit.html(whcom_spinner_icon);
            response_text.html(whcom_spinner_icon).show();
            let data = form.serializeArray();
            jQuery.ajax({
                url: wcop_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    let res = JSON.parse(response);
                    submit.text(submit_val);
                    if (res.status === "OK") {
                        container.html(res.response_form);
                        $('html,body').animate({
                            scrollTop: 100
                        }, 700);
                    } else {
                        response_text.html(res.message).show();
                    }
                }
            });
        });


        window.wcop_sp_update_product_summary = function () {

            let prd_form = $('form.wcop_sp_add_product');
            let curr_temp = prd_form.find('[name="wcop_current_template"]').val();
            console.log("I am here in update summary");
            if (prd_form[0]) {
                let prd_summary = $('.wcop_sp_order_summary');
                let prd_summary_spinner = $('.wcop_sp_product_summary_spinner');
                let prd_submit = $('.wcop_sp_product_submit');
                prd_submit.hide();
                prd_summary_spinner.show();
                $("#wcop_loader_id").css("opacity", "0.3");
                $(".wcop_loader_class").css("display", "block");
                $('.wcop_sp_replace_spinner').html(whcom_spinner_icon_only);
                if(curr_temp === '04_ease') {
                    $('.whcom_text_right.whcom_text_2x').html('Calculating Price...');
                }

                let data = prd_form.serializeArray();
                data.push({'name': 'wcop_sp_what', 'value': 'wcop_sp_generate_summary'});
                data.push({'name': 'wcop_sp_template', 'value': curr_temp });
                $.ajax({
                    url: wcop_ajax.ajax_url,
                    type: 'post',
                    data: data,
                    success: function (response) {
                        let res = JSON.parse(response);
                        console.log(res);
                        if (res.status === "OK") {
                            //== Change Summary section heading either it is empty or populated with content
                            jQuery('.whcom_empty_summary_section_heading').css("display", "none");
                            jQuery('.whcom_filled_summary_section_heading').css("display", "block");

                            whcom_show_notification(res.message, 'whcom_alert whcom_alert_success');
                            $("#wcop_loader_id").css("opacity", "1");
                            $(".wcop_loader_class").css("display", "none");
                            prd_submit.show();
                            prd_summary_spinner.fadeOut(500);
                            prd_summary.html(res.summary_html.side);
                            if (res.summary_html.free_domain) {
                                $('[name="regperiod"]').prop('disabled', true).find('option').each(function () {
                                    $(this).prop('selected', true);
                                    return false;
                                });
                            } else {
                                $('[name="regperiod"]').prop('disabled', false);
                            }
                            if (res.summary_html.no_options) {
                                $('.wcop_sp_product_no_options').show();
                            } else {
                                $('.wcop_sp_product_no_options').hide();
                            }
                            if (res.summary_html.discount_message) {
                                $('.wcop_sp_coupon_response').html(res.summary_html.discount_message);
                            }
                        } else {
                            whcom_show_notification(res.message, 'whcom_alert whcom_alert_danger');
                            prd_summary.html(res.message);
                        }
                    }
                });
            }
        };

        window.wcop_df_update_product_summary = function () {
            let prd_form = $('form.wcop_df_products_config_form');
            if (prd_form[0]) {
                let prd_summary = prd_form.find('.wcop_df_summary_sidebar');
                let prd_summary_spinner = prd_form.find('.wcop_df_product_summary .whcom_icon_spinner-1');
                let prd_submit = prd_form.find('.wcop_df_product_submit button');
                prd_submit.prop('disabled', true);
                prd_summary_spinner.show();
                if (prd_form) {
                    let data = prd_form.serializeArray();
                    data.push({'name': 'wcop_what', 'value': 'products_summary'});
                    $.ajax({
                        url: whcom_ajax.ajax_url,
                        type: 'post',
                        data: data,
                        success: function (response) {
                            let res = JSON.parse(response);
                            if (res.status === "OK") {
                                prd_submit.prop('disabled', false);
                                prd_summary_spinner.fadeOut(500);
                                prd_summary.html(res.summary_html);
                            } else {
                                prd_summary.html(res.message);
                            }
                        }
                    });
                }
            }
        };


        //By Fakhir
        $("#edit_domain").click(function () {
            $('#wcop_sp_choose_a_domain').show();
        });

        $(document).ready(function () {
            $("#wcop_sp_domain_config").hide();
        });

        $(document).ready(function () {
            window.scrollTo(0, 0);
        });

        //== Show popup for free domains attached to the product
        $(document).on('click', '#myBtn', function () {
            document.getElementById("myModal").style.display = 'block'
        });

        //== close free domain information popup on cross button click
        $(document).on('click', '#free_domain_modal_close', function () {
            document.getElementById("myModal").style.display = 'none'
        });

        //== Change Summary section heading either it is empty or populated with content
        if (jQuery('#whcom_08_gator_summary_section').is(':empty')) {
            jQuery('.whcom_empty_summary_section_heading').css("display", "block");
            jQuery('.whcom_filled_summary_section_heading').css("display", "none");
        } else {
            jQuery('.whcom_empty_summary_section_heading').css("display", "none");
            jQuery('.whcom_filled_summary_section_heading').css("display", "block");
        }

        //== Show Summary Message if 04_ease Cart Summary is empty
        $(document).ready(function () {
            if (jQuery('#ease_summary_area').is(':empty')) {
                empty_summary_section_message = '<h2>Your Cart is empty</h2>';
                empty_summary_section_message += '<p class="wcop_4_ease_dekstop_summary_section">Contact us -  if you need more information.</p>';
                empty_summary_section_message += '<p class="wcop_4_ease_dekstop_summary_section"><b>Search a domain or choose a service.</b></p>';
                empty_summary_section_message += '<div class="wcop_4_ease_mobile_summary_section">Chose a product or service below.</div>';
                jQuery('#ease_summary_area').html(empty_summary_section_message);
            }
        });

        //== Show client register section on button click
        $(document).on('click', '#wcop_sp_client_register_section', function () {
            let prd_form = $('form.wcop_sp_add_product');
            current_template = prd_form.find('[name="wcop_sp_template"]').val();
            billing_info_predecessor_container = jQuery(document).find('.wcop_billing_info_predecessor');
            billing_info_container = jQuery(document).find('#wcop_billing_info');

            let data = {};
            data.action = 'wcop_sp_process';
            data.wcop_sp_what = 'wcop_include_client_section';

            jQuery('#wcop_sp_client_register_section').html(whcom_spinner_icon);
            $.ajax({
                url: wcop_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    let res = JSON.parse(response);
                    jQuery('#wcop_sp_client_register_section').html("Register");
                    billing_info_predecessor_container.slideUp('', function () {
                        billing_info_container.slideDown('', function () {
                            if (current_template === '02_sleek_minimal' || current_template === '03_bold' || current_template === '06_sleek'){
                                jQuery('.wcop__inner__billing__info').css("display","block")
                            }else {
                                jQuery('#wcop_billing_info').css("display", "block");
                            }
                        });
                    });


                }
            });
        });

        //== Show client login section on button click
        $(document).on('click', '#wcop_sp_client_login_section', function () {

            let prd_form = $('form.wcop_sp_add_product');
            current_template = prd_form.find('[name="wcop_sp_template"]').val();
            billing_info_predecessor_container = jQuery(document).find('.wcop_billing_info_predecessor');
            billing_info_container = jQuery(document).find('#wcop_billing_info');
            let data = {};
            data.action = 'wcop_sp_process';
            data.wcop_sp_what = 'wcop_include_client_section';

            jQuery('#wcop_sp_client_login_section').html(whcom_spinner_icon);
            $.ajax({
                url: wcop_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    let res = JSON.parse(response);
                    jQuery('#wcop_sp_client_login_section').html("Login");
                    jQuery('.wcop_sp_billing_tab_link').trigger('click');
                    if (current_template === '05_simple'){
                        jQuery('#wcop_sp_user_login_link').trigger("click");
                    }
                    billing_info_predecessor_container.slideUp('', function () {
                        billing_info_container.slideDown('', function () {
                            if (current_template === '02_sleek_minimal' || current_template === '03_bold' || current_template === '06_sleek'){
                                jQuery('.wcop__inner__billing__info').css("display","block")
                            }else {
                                jQuery('#wcop_billing_info').css("display", "block");
                            }
                            });
                        });

                }
            });
        });

    }(jQuery)
);








