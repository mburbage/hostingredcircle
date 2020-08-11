
var t0 = performance.now();

var current_request = null;

var is_mobile = false; //initiate as false
// device detection
if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0, 4))) {
    is_mobile = true;
}

function base64_encode(stringToEncode) {
    var encodeUTF8string = function (str) {
        // first we use encodeURIComponent to get percent-encoded UTF-8,
        // then we convert the percent encodings into raw bytes which
        // can be fed into the base64 encoding algorithm.
        return encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
            function toSolidBytes(match, p1) {
                return String.fromCharCode('0x' + p1)
            })
    }
    if (typeof window !== 'undefined') {
        if (typeof window.btoa !== 'undefined') {
            return window.btoa(encodeUTF8string(stringToEncode))
        }
    }
    else {
        return new Buffer(stringToEncode).toString('base64')
    }
    var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/='
    var o1
    var o2
    var o3
    var h1
    var h2
    var h3
    var h4
    var bits
    var i = 0
    var ac = 0
    var enc = ''
    var tmpArr = []
    if (!stringToEncode) {
        return stringToEncode
    }
    stringToEncode = encodeUTF8string(stringToEncode)
    do {
        // pack three octets into four hexets
        o1 = stringToEncode.charCodeAt(i++)
        o2 = stringToEncode.charCodeAt(i++)
        o3 = stringToEncode.charCodeAt(i++)
        bits = o1 << 16 | o2 << 8 | o3
        h1 = bits >> 18 & 0x3f
        h2 = bits >> 12 & 0x3f
        h3 = bits >> 6 & 0x3f
        h4 = bits & 0x3f
        // use hexets to index into b64, and append result to encoded string
        tmpArr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4)
    } while (i < stringToEncode.length)
    enc = tmpArr.join('')
    var r = stringToEncode.length % 3
    return (
            r ? enc.slice(0, r - 3) : enc
        ) + '==='.slice(r || 3)
}

function urlencode(str) {
    str = (
        str + ''
    )
    // Tilde should be allowed unescaped in future versions of PHP (as reflected below),
    // but if you want to reflect current
    // PHP behavior, you would need to add ".replace(/~/g, '%7E');" to the following.
    return encodeURIComponent(str)
        .replace(/!/g, '%21')
        .replace(/'/g, '%27')
        .replace(/\(/g, '%28')
        .replace(/\)/g, '%29')
        .replace(/\*/g, '%2A')
        .replace(/%20/g, '+')
}

function isset() {
    var a = arguments
    var l = a.length
    var i = 0
    var undef
    if (l === 0) {
        throw new Error('Empty isset')
    }
    while (i !== l) {
        if (a[i] === undef || a[i] === null) {
            return false
        }
        i++
    }
    return true
}

function print_r(array, returnVal) {
    var echo = require('../strings/echo')
    var output = ''
    var padChar = ' '
    var padVal = 4
    var _repeatChar = function (len, padChar) {
        var str = ''
        for (var i = 0; i < len; i++) {
            str += padChar
        }
        return str
    }
    var _formatArray = function (obj, curDepth, padVal, padChar) {
        if (curDepth > 0) {
            curDepth++
        }
        var basePad = _repeatChar(padVal * curDepth, padChar)
        var thickPad = _repeatChar(padVal * (
                curDepth + 1
            ), padChar)
        var str = ''
        if (typeof obj === 'object' &&
            obj !== null &&
            obj.constructor) {
            str += 'Array\n' + basePad + '(\n'
            for (var key in obj) {
                if (Object.prototype.toString.call(obj[key]) === '[object Array]') {
                    str += thickPad
                    str += '['
                    str += key
                    str += '] => '
                    str += _formatArray(obj[key], curDepth + 1, padVal, padChar)
                }
                else {
                    str += thickPad
                    str += '['
                    str += key
                    str += '] => '
                    str += obj[key]
                    str += '\n'
                }
            }
            str += basePad + ')\n'
        }
        else if (obj === null || obj === undefined) {
            str = ''
        }
        else {
            // for our "resource" class
            str = obj.toString()
        }
        return str
    }
    output = _formatArray(array, 0, padVal, padChar)
    if (returnVal !== true) {
        echo(output)
        return true
    }
    return output
}

function SubmitUpdateSecurityQuestions(event) {
    event.preventDefault();

    jQuery("#success_message, #success_error").hide();
    jQuery.post(wcap_ajaxurl, jQuery(this).serialize(), function (data) {
        if (data == "OK") {
            jQuery("#success_message").html("Success!").show();
        }
        else {
            jQuery("#success_error").html(data).show();
        }
    })
}

//byfarooq
function SubmitUpdateUpdateCreditCard(event) {

    event.preventDefault();

    var k = jQuery("#update_credit_card_form").serialize();

    var view_container = jQuery('.wcap_view_container');
    var view_content = view_container.find('.wcap_view_content');
    var view_response = view_container.find('.wcap_view_response');

    view_response.html(wcap_spinner_icon).show();

    jQuery.post(wcap_ajaxurl, k, function (data) {
        var res = JSON.parse(data);
        console.log(res['api_response']);
        view_response.show().html(res.message);
        if (res.status === "OK") {
            view_content.hide();
        }
    });
}


function count(mixedVar, mode) {
    //  discuss at: http://locutus.io/php/count/
    // original by: Kevin van Zonneveld (http://kvz.io)
    //    input by: Waldo Malqui Silva (http://waldo.malqui.info)
    //    input by: merabi
    // bugfixed by: Soren Hansen
    // bugfixed by: Olivier Louvignes (http://mg-crea.com/)
    // improved by: Brett Zamir (http://brett-zamir.me)
    //   example 1: count([[0,0],[0,-4]], 'COUNT_RECURSIVE')
    //   returns 1: 6
    //   example 2: count({'one' : [1,2,3,4,5]}, 'COUNT_RECURSIVE')
    //   returns 2: 6
    var key;
    var cnt = 0;
    if (mixedVar === null || typeof mixedVar === 'undefined') {
        return 0
    }
    else if (mixedVar.constructor !== Array && mixedVar.constructor !== Object) {
        return 1
    }
    if (mode === 'COUNT_RECURSIVE') {
        mode = 1
    }
    if (mode !== 1) {
        mode = 0
    }
    for (key in mixedVar) {
        if (mixedVar.hasOwnProperty(key)) {
            cnt++
            if (mode === 1 && mixedVar[key] &&
                (
                    mixedVar[key].constructor === Array ||
                    mixedVar[key].constructor === Object
                )) {
                cnt += count(mixedVar[key], 1)
            }
        }
    }
    return cnt
}

function rtrim(str, charlist) {
    //  discuss at: http://locutus.io/php/rtrim/
    // original by: Kevin van Zonneveld (http://kvz.io)
    //    input by: Erkekjetter
    //    input by: rem
    // improved by: Kevin van Zonneveld (http://kvz.io)
    // bugfixed by: Onno Marsman (https://twitter.com/onnomarsman)
    // bugfixed by: Brett Zamir (http://brett-zamir.me)
    //   example 1: rtrim('    Kevin van Zonneveld    ')
    //   returns 1: '    Kevin van Zonneveld'
    charlist = !charlist ? ' \\s\u00A0' : (
        charlist + ''
    )
        .replace(/([[\]().?/*{}+$^:])/g, '\\$1')
    var re = new RegExp('[' + charlist + ']+$', 'g')
    return (
        str + ''
    ).replace(re, '')
}

function trim(str, charlist) {
    var whitespace = [
        ' ',
        '\n',
        '\r',
        '\t',
        '\f',
        '\x0b',
        '\xa0',
        '\u2000',
        '\u2001',
        '\u2002',
        '\u2003',
        '\u2004',
        '\u2005',
        '\u2006',
        '\u2007',
        '\u2008',
        '\u2009',
        '\u200a',
        '\u200b',
        '\u2028',
        '\u2029',
        '\u3000'
    ].join('');
    var l = 0;
    var i = 0;
    str += '';
    if (charlist) {
        whitespace = (
            charlist + ''
        ).replace(/([[\]().?/*{}+$^:])/g, '$1')
    }
    l = str.length;
    for (i = 0; i < l; i++) {
        if (whitespace.indexOf(str.charAt(i)) === -1) {
            str = str.substring(i)
            break
        }
    }
    l = str.length;
    for (i = l - 1; i >= 0; i--) {
        if (whitespace.indexOf(str.charAt(i)) === -1) {
            str = str.substring(0, i + 1)
            break
        }
    }
    return whitespace.indexOf(str.charAt(0)) === -1 ? str : '';
}

function unset() {
    // http://kevin.vanzonneveld.net
    // +   original by: Brett Zamir (http://brett-zamir.me)
    // *     example 1: var arr = ['a', 'b', 'c'];
    // *     example 1: unset('arr[1]');
    // *     returns 1: undefined

    // Must pass in a STRING to indicate the variable, not the variable itself (whether or not that evaluates to a string)
    // Works only on globals
    var i = 0, arg = '', win = '', winRef = /^(?:this)?window[.[]/, arr = [], accessor = '',
        bracket = /\[['"]?(\d+)['"]?\]$/;
    for (i = 0; i < arguments.length; i++) {
        arg = arguments[i];
        winRef.lastIndex = 0, bracket.lastIndex = 0;
        win = winRef.test(arg) ? '' : 'this.window.';
        if (bracket.test(arg)) {
            accessor = arg.match(bracket)[1];
            arr = eval(win + arg.replace(bracket, ''));
            arr.splice(accessor, 1); // We remove from the array entirely, rather than leaving a gap
        }
        else {
            eval('delete ' + win + arg);
        }
    }
}

function is_json(str) {
    str = jQuery.trim(str);
    if (str == "") {
        return false;
    }
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

(function ($) {


    //Credit Abdul Waheed
    $(document).on('change', 'input[name="wcap_op_product_domain_option_selector"]', function () {

        $("#continue_domain_transfer_btn_container, #continue_domain_register_btn_container").hide();

        $('.whcom_product_domain_option_form').hide();
        $(".wcap_op_domain_response").hide();
        $("#continue_domain_register_btn_container").hide();

        $('#' + $(this).val()).show();
    });

    // Data tables pagination buttons
    jQuery.fn.dataTable.ext.classes.sPageButton = 'whcom_button whcom_button_small whcom_button_secondary';
    jQuery.fn.dataTable.ext.classes.sPageButtonActive = 'whcom_button_primary';


    CheckDomainAvailability = function (event) {
        event.preventDefault();

        jQuery("#continue_btn").hide();
        var k = jQuery("#ask_domain_form").serialize();
        jQuery("#ask_domain_form button, #ask_domain_form input[name=domain]").prop("disabled", true);
        jQuery.post(wcap_ajaxurl, k, function (data) {
            jQuery("#ask_domain_form button, #ask_domain_form input[name=domain]").prop("disabled", false);
            if (is_json(data)) {
                data = JSON.parse(data);
                var paytype = jQuery("#ask_domain_form input[name=paytype]:checked").val();
                if (data.result == "error") {
                    jQuery("#asking_domain_response").html(data.message);
                }
                else if (data.status == "unavailable" && paytype == "domainregister") {
                    jQuery("#asking_domain_response").html("Domain not available, Please select another domain");
                }
                else if (data.status == "unavailable" && paytype == "domaintransfer") {
                    jQuery("#asking_domain_response").html("Domain is Eligible.");
                    jQuery("#continue_btn").show();
                }
                else if (data.status == "available" && paytype == "domainregister") {
                    jQuery("#asking_domain_response").html("Congratulation, Domain available");
                    jQuery("#continue_btn").show();
                }
                else if (data.status == "available" && paytype == "domaintransfer") {
                    jQuery("#asking_domain_response").html("Domain is not Eligible.");
                }
            }
            else {
                jQuery("#asking_domain_response").html(data);
            }
        });
    };
    OpenInvoice = function () {
        var $GET = GET();
        invoiceid = $GET["invoiceid"];

        jQuery.post(wcap_ajaxurl, {"action": "wcap_requests", "what": "whmcs_login"}, function (data) {
            jQuery("#i").html("<pre>" + data + "</pre>");
            window.open("http://whmcs2.whmpress.com/viewinvoice.php?wcap_no_redirect=1&id=" + invoiceid);
        });

    };
    CheckOut1 = function (event) {
        event.preventDefault();

        k = "action=wcap_requests&what=add_order_to_whmcs&paymentmethod=" + jQuery("[name=paymentmethod]").val();
        jQuery.post(wcap_ajaxurl, k, function (data) {
            if (is_json(data)) {
                data = JSON.parse(data);
                if (data.invoiceid) {
                    /*new_link = "<a style='display:none' href='invoiceid=" + data.invoiceid + "' class='wcap_load_page' data-page='viewinvoice' id='wcap_new_link'>Go</a>";
                     jQuery("#main_div_100").append(new_link);
                     jQuery("#wcap_new_link").click();*/
                    set_url_parameter_value("whmpca", "viewinvoice");
                    set_url_parameter_value("invoiceid", data.invoiceid);
                    LoadData();
                }
                else if (data.message) {
                    alert(data.message);
                }
                else {
                    alert(JSON.stringify(data));
                }
            }
            else {
                alert(data);
            }
        });

    };
    LoginToWHMCS = function () {

    };

    DocumentReady = function () {
        jQuery('.wcap_progress_circle').circliful({
            animationStep: 5,
            foregroundBorderWidth: 5,
            backgroundBorderWidth: 15,
            percent: 80,
            iconPosition: 'middle',
            halfCircle: 1,
            textBelow: true
        });

        jQuery(document).find('.whcom_table:not(.wcap_not_datatable) table').each(function () {

            jQuery.fn.dataTable.ext.classes.sPageButton = 'whcom_button whcom_button_small whcom_button_secondary';
            jQuery.fn.dataTable.ext.classes.sPageButtonActive = 'whcom_button_primary';
            jQuery(this).DataTable(dataTablesConfig);
        });
    };

    SubmitResetPassword = function (event) {
        event.preventDefault();
        var k = jQuery("#whmcs_reset_pwd_form").serialize();
        k += "&action=wcap_requests&what=reset_password_email&url=" + page_url;

        jQuery("#reset_email").prop("disabled", true);
        jQuery("#reset_submit").val(WCAP_Working_text);

        jQuery.post(wcap_ajaxurl, k, function (data) {
            jQuery("#reset_email").prop("disabled", false);

            if (data == "OK") {
                jQuery("#success_message").show();
                jQuery("#whmcs_reset_pwd_form").remove();
            }
            else {
                jQuery("#error_message").html(data).show();
                jQuery("#reset_submit").val("Submit");
            }

        });
    }

    /** Sample Code - Farooq **/
    SubmitContactForm = function (event) {
        event.preventDefault();
        var k = jQuery("#wcap_contactus_from").serialize();
        k += "&action=wcap_requests&what=submit_contact_form&url=" + page_url;

        var view_container = jQuery('.wcap_view_container');
        var view_content = view_container.find('.wcap_view_content');
        var view_response = view_container.find('.wcap_response_div');

        view_response.html(wcap_spinner_icon).show();
        jQuery.post(wcap_ajaxurl, k, function (data) {
            var res = JSON.parse(data);
            console.log(res);
            view_response.show().html(res.message);
            if (res.status === "OK") {
                view_content.hide();
            }
        });
    };

    SubmitValidationForm = function (event) {
        event.preventDefault();

        var k = jQuery("#whmcs_validation_form").serialize();
        k += "&action=wcap_requests&what=validate_login";

        var old_html = jQuery("#whmcs_validation_form input[type=submit]").val();
        jQuery("#whmcs_validation_form input[type=email]").prop("disabled", true);
        jQuery("#whmcs_validation_form input[type=password]").prop("disabled", true);
        jQuery("#whmcs_validation_form input[type=submit]").prop("disabled", true).val(WCAP_Working_text);
        jQuery("#error_message").hide();
        var login_form_flag = jQuery("#whmcs_validation_form input[name=login_form_flag]").val();

        jQuery.post(wcap_ajaxurl, k, function (data) {
            data = JSON.parse(data);
            console.log(data);
            if (data.status === "OK") {
                //== if client login through wcap login form
                if (login_form_flag === '1'){
                    window.location.href = client_area_url;
                }
                else {
                    if (redirect_login !== "0") {
                        window.location.href = redirect_login;
                    } else {
                        window.location.reload();
                    }
                }
                /*jQuery( "#wcap_main_div" ).html( data.substr( 2 ) );
                 if ( jQuery( "table.wcap_responsive_table" ).length > 0 ) {
                 jQuery( "table.wcap_responsive_table" ).tablesaw();
                 }*/
            }
            else {
                jQuery("#whmcs_validation_form input[type=email]").prop("disabled", false);
                jQuery("#whmcs_validation_form input[type=password]").prop("disabled", false);
                jQuery("#whmcs_validation_form input[type=submit]").prop("disabled", false).val(old_html);
                jQuery("#error_message").html(data.message).show();

            }
        });
    };

    ModalOpener = function (e) {

        var dialogTitle = jQuery(this).data('dialog-title');
        var dialogWidth = (
                jQuery('.wcap').outerWidth(false)
            ) - 40;
        var dialogPosition = {my: "center top", at: "center top+30", of: "body"}
        var dialogID = jQuery(this).data('dialog-id');

        e.preventDefault();
        jQuery('.wcap_modal#' + dialogID).dialog({
            dialogClass: 'wcap_dialog',
            title: dialogTitle,
            maxWidth: 600,
            width: dialogWidth,
            position: dialogPosition,
            open: function () {
            }
        });
    };
    LoadSingleTicket = function (event) {
        event.preventDefault();

        var id = jQuery(this).attr("data-id");
        var args = "action=wcap_requests&what=load_page&page=viewticket&tid=" + id;

        var html = '<div style="padding:20px;text-align: center;font-size:20px"><i class="whcom_icon_spinner-1"></i> ' + WCAP_Loading_text + '</div>';
        jQuery("#wcap_main_div .wcap").html(html);

        jQuery.post(wcap_ajaxurl, args, function (data) {
            data += "<button style='display: none' class='wcap_load_single_ticket' data-id='" + id + "' id='load_ticket_btn'>Load Ticket</button>";
            jQuery("#wcap_main_div .wcap").html(data);

            jQuery(document).find('.whcom_table:not(.wcap_not_datatable) table').each(function () {
                jQuery.fn.dataTable.ext.classes.sPageButton = 'whcom_button whcom_button_small whcom_button_secondary';
                jQuery.fn.dataTable.ext.classes.sPageButtonActive = 'whcom_button_primary';
                jQuery(this).DataTable(dataTablesConfig);
            });

            /* var simplemde= new SimpleMDE({element: jQuery('#wcap_md_editor')});*/

            /*jQuery( "textarea.summernote" ).summernote( {
             height: 250
             } );*/
        });
    };

    Logout = function (event) {
        event.preventDefault();

        jQuery(this).html(WCAP_Working_text);
        jQuery(this).val(WCAP_Working_text);
        var k = "action=wcap_requests&what=whmcs_logout";

        jQuery.post(wcap_ajaxurl, k, function (data) {
            console.log(data);
            data = JSON.parse(data);
            if (data.status == "OK") {
                if (redirect_logout != '0') {
                    window.location.href = redirect_logout;
                }
                else {
                    // set_url_parameter_value( "whmpca", "logged_out" );
                    // LoadData();
                    window.location.reload();
                }
            }
            else {
                alert(data);
            }
        });
    };
    NoLoad = function (event) {
        event.preventDefault();
    };
    LoadPage = function (event) {
        event.preventDefault();

        var tagName = jQuery(this).prop("tagName");
        var page = jQuery(this).attr("data-page");
        var dept_id = jQuery(this).attr("data-id");
        if (!page) {
            page = "dashboard";
        }
        var href = jQuery(this).attr("href");
        var $this = jQuery(this);

        var params = {};
        var remove_params = new Array("a", "pid", "invoiceid", "wcap");

        if (href && href != "#") {
            if (href.substr(0, 1) == "?") {
                href = trim(href, "?");
            }
            //params = JSON.parse('{"' + decodeURI(href).replace(/"/g, '\\"').replace(/&/g, '","').replace(/=/g,'":"') + '"}');

            params = href ? JSON.parse('{"' + href.replace(/&/g, '","').replace(/=/g, '":"') + '"}',
                function (key, value) {
                    return key === "" ? value : decodeURIComponent(value)
                }) : {}

            jQuery.each(remove_params, function (i, v) {
                if (params[v]) {
                    delete (
                        remove_params[i]
                    );
                }
            });

            params["whmpca"] = page;

            set_multi_url_parameters_value(params, remove_params);
        }
        else {
            params["whmpca"] = page;
            //var remove_params = JSON.parse('{"0":"a"}');
            set_multi_url_parameters_value(params, remove_params);
        }

        if (params["whmpca"] == "add_service_page" && !params["pid"]) {
            params["whmpca"] = "order_new_service";
        }

        if (tagName == "A") {
            jQuery("li.current-menu-item").removeClass("current-menu-item");

            jQuery("#primary_nav_wrap").find('a[data-page=' + page + ']').closest("li").addClass("current-menu-item");
            var Parent = jQuery("#primary_nav_wrap").find("a[data-page=" + page + "]").closest("li")
                .addClass("current-menu-item").parent();
            if (Parent.prop("tagName") != "LI") {
                Parent = Parent.parent();
                if (Parent.prop("tagName") == "LI") {
                    Parent.addClass("current-menu-item");
                }
            }
            else {
                Parent.addClass("current-menu-item");
            }
        }

        /* else {
         jQuery( this ).html( "<i class='fa fa-spin fa-spinner'></i> Loading ...." );
         jQuery( this ).val( "<i class='fa fa-spin fa-spinner'></i> Loading ...." );
         }*/

        /*var html = `<div style="padding:20px;text-align: center;font-size:20px"><i class="fa fa-spin fa-spinner"></i> Loading ....</div>`;
         jQuery( "#wcap_main_div .wcap" ).html( html );

         var args = "action=wcap_requests&what=load_page&page=" + page;
         jQuery.post( wcap_ajaxurl, args, function( data ) {
         jQuery( "#wcap_main_div .wcap" ).html( data );
         if ( jQuery( "table.wcap_responsive_table" ).length > 0 ) {
         jQuery( "table.wcap_responsive_table" ).tablesaw();
         }
         } );*/

        LoadData(dept_id);
    };
    LoadData = function (dept_id = 0) {
        get_params = GET();
        t1 = performance.now();

        var page = get_params.whmpca;
        if (!page || page === 'clientarea') {
            page = "dashboard";
        }
        get_params["page"] = page;
        WMPCA_page = page;
        get_params["action"] = "wcap_requests";
        get_params["what"] = "load_data";
        get_params["dept_id"] = dept_id;

        var match,
            pl = /\+/g,  // Regex for replacing addition symbol with a space
            search = /([^&=]+)=?([^&]*)/g,
            decode = function (s) {
                return decodeURIComponent(s.replace(pl, " "));
            }

        if (jQuery(this).attr("href")) {
            var args = jQuery(this).attr("href");
            if (args.substr(0, 1) == "?") {
                args = args.substr(1);
            }
            while (match = search.exec(args)) {
                get_params[decode(match[1])] = decode(match[2]);
            }
        }

        if (get_params.whmpca == "add_service_page" && (
                !get_params.pid
            )) {
            get_params.whmpca = "order_new_service";
        }

        if (get_params.whmpca == 'order_new_service' && get_params.pid != '') {
            var k = '';
            if (get_params.order_type == "order_product") {
                if (get_params.showdomainoption == '1') {
                    var k = "?whmpca=domain_service&pid=" + get_params.pid + "&billingcycle=" + get_params.billingcycle;
                }
                else {
                    var k = "?whmpca=add_service_page&pid=" + get_params.pid + "&billingcycle=" + get_params.billingcycle;

                }

                // var k = "?whmpca=add_service_page&pid=" + get_params.pid + "&billingcycle=" + get_params.billingcycle;
                set_new_url(k);
                LoadData();
            }

        }

        if (get_params.whmpca == 'order_new_service' && get_params.order_type == "order_domain") {
            var k = '';
            if (get_params.domain == 'register') {

                var k = "?whmpca=domain_register&sld=" + get_params.sld + "&tld=" + get_params.tld;
                set_new_url(k);
                LoadData();
            }
            else if (get_params.domain == "transfer") {

                var k = "?whmpca=domain_transfer&sld=" + get_params.sld + "&tld=" + get_params.tld;
                set_new_url(k);
                LoadData();
            }
        }

        /*if ( jQuery( "#wcap_menu_div" ).length > 0 ) {
         jQuery( 'html,body' ).animate( {
         scrollTop: jQuery( "#wcap_menu_div" ).offset().top
         },
         'slow' );
         }*/

        var html = '<div style="padding:20px;text-align: center;font-size:20px">' +
            '<i class="whcom_icon_spinner-1 whcom_animate_spin"></i> ' + WCAP_Loading_text + '</div>';

        jQuery("#wcap_main_div .wcap").html(html);

        current_request = jQuery.ajax({
            type: 'POST',
            data: get_params,
            url: wcap_ajaxurl,
            beforeSend: function () {
                if (current_request != null) {
                    current_request.abort();
                }
            },
            success: function (data) {
                // Remving url parameter status
                new_url = remove_url_parameter("status");

                //------ remove URL Parameters-----

                // If tickets page is opened then remove URL parameter id
                if (!(
                        get_params["whmpca"] == "service" || get_params["whmpca"] == "ticket"
                        || get_params["whmpca"] == "updowngrade" || get_params["whmpca"] == "productdetails"
                    )) {
                    new_url = remove_url_parameter("id", new_url);
                }

                //--- Knowledge base ---
                if ((
                        get_params["whmpca"] == "kb_articles"
                    )) {
                    new_url = remove_url_parameter("active", new_url);
                }


                //for all pages other than order_new_service remove parameter
                if ((
                        get_params["whmpca"] == "order_new_service"
                    )) {
                    new_url = remove_url_parameter("active", new_url);
                }

                new_url = remove_url_parameter("emptycart", new_url);

                if ((
                        get_params["whmpca"] == "upgrade_final"
                    )) {
                    //new_url = remove_url_parameter( "k", new_url );
                }

                if ((
                        get_params["whmpca"] == "mass_pay"
                    )) {
                    //new_url = remove_url_parameter( "k", new_url );
                }

                //for all pages other than order_new_service remove parameter
                if ((
                        get_params["whmpca"] == "domain_register"
                    )) {
                    new_url = remove_url_parameter("domain", new_url);
                }

                if ((
                        get_params["whmpca"] == "cart"
                    )) {
                    new_url = remove_url_parameter("domain", new_url);
                }

                // Set new URL in browser.
                set_new_url(new_url);

                jQuery("#wcap_main_div .wcap").html(data);

                jQuery(document).find('.whcom_table:not(.wcap_not_datatable) table').each(function () {
                    jQuery.fn.dataTable.ext.classes.sPageButton = 'whcom_button whcom_button_small whcom_button_secondary';
                    jQuery.fn.dataTable.ext.classes.sPageButtonActive = 'whcom_button_primary';
                    jQuery(this).DataTable(dataTablesConfig);
                });
                jQuery(".fancybox").fancybox();
                jQuery(".ifancybox").fancybox({
                    type: "iframe",
                    scrolling: "yes",
                    iframe: {'scrolling': 'yes'},
                    afterShow: function () {
                        var customContent = '<a title="Close" class="whcom_op_thickbox_redirect_overlay" href="javascript:;">Close</a>';
                        jQuery('.fancybox-outer').append(customContent);
                    }
                });

                if (get_params["whmpca"] == "order_new_service" && get_params["gid"]) {
                    jQuery("li[data-li=" + get_params["gid"] + "]").click();
                }
                else if (get_params["whmpca"] == "viewinvoice" && jQuery("#view_invoice_link").length == 1) {
                    jQuery("#view_invoice_link").click();
                }
                renderWhcomTabs();

                //Registration form submit
                if (get_params.whmpca == 'domain_register') {
                    if (get_params.sld && get_params.tld) {
                        jQuery("#domain_search_form").trigger('submit');
                        //  console.log(get_params.sld);
                    }
                }

                //Transfer form submit

                if (get_params.whmpca == 'domain_transfer' && get_params.sld && get_params.tld) {
                    jQuery("#wcap_domain_transfer_submit").trigger('click');
                }

                window.whcom_op_update_cart_summaries();
                window.whcom_op_update_product_summary();
	            $('.whcom_op_submit_on_load').submit().removeClass('whcom_op_submit_on_load');
                window.initWhcom();
            },
            error: function (jqXHR, textStatus) {
                console.log(textStatus);
            },
            complete: function () {
                current_request = null;

            }
        });

    };
    LoadInvoiceLink = function (event) {
        event.preventDefault();

        jQuery(this).html("<i class='whcom_icon_spinner-1 whcom_animate_spin'></i> " + WCAP_Loading_text);
        var k = "action=wcap_requests&what=load_invoices_page";
        jQuery.post(wcap_ajaxurl, k, function (data) {
            jQuery("#wcap_main_div").html(data);

            jQuery(document).find('.whcom_table:not(.wcap_not_datatable) table').each(function () {
                jQuery.fn.dataTable.ext.classes.sPageButton = 'whcom_button whcom_button_small whcom_button_secondary';
                jQuery.fn.dataTable.ext.classes.sPageButtonActive = 'whcom_button_primary';
                jQuery(this).DataTable(dataTablesConfig);
            });
            //jQuery( "table.wcap_responsive_table" ).tablesaw();
            //jQuery( "table.whcom_table" ).tablesaw();
            //jQuery( "table.wcap_responsive_table" ).trigger( "enhance.tablesaw" );

            //jQuery('table#whcom_table').table().data( "table" ).refresh();
            //jQuery('table#whcom_table').tablesaw().data( "tablesaw" ).refresh();
        });
    };
    LoadTicketsLink = function (event) {
        event.preventDefault();

        jQuery(this).html("<i class='whcom_icon_spinner-1  whcom_animate_spin'></i> " + WCAP_Loading_text);
        var k = "action=wcap_requests&what=load_tickets_page";
        jQuery.post(wcap_ajaxurl, k, function (data) {
            jQuery("#wcap_main_div").html(data);

            jQuery(document).find('.whcom_table:not(.wcap_not_datatable) table').each(function () {
                jQuery.fn.dataTable.ext.classes.sPageButton = 'whcom_button whcom_button_small whcom_button_secondary';
                jQuery.fn.dataTable.ext.classes.sPageButtonActive = 'whcom_button_primary';
                jQuery(this).DataTable(dataTablesConfig);
            });
        });
    };
    LoadDomainsLink = function (event) {
        event.preventDefault();

        jQuery(this).html("<i class='whcom_icon_spinner-1  whcom_animate_spin'></i> " + WCAP_Loading_text);
        var k = "action=wcap_requests&what=load_domains_page";
        jQuery.post(wcap_ajaxurl, k, function (data) {
            jQuery("#wcap_main_div").html(data);

            jQuery(document).find('.whcom_table:not(.wcap_not_datatable) table').each(function () {
                jQuery.fn.dataTable.ext.classes.sPageButton = 'whcom_button whcom_button_small whcom_button_secondary';
                jQuery.fn.dataTable.ext.classes.sPageButtonActive = 'whcom_button_primary';
                jQuery(this).DataTable(dataTablesConfig);
            });
        });
    };
    LoadServiceLink = function (event) {

        event.preventDefault();

        jQuery(this).html("<i class='whcom_icon_spinner-1  whcom_animate_spin'></i> " + WCAP_Loading_text);
        var k = "action=wcap_requests&what=load_services_page";
        jQuery.post(wcap_ajaxurl, k, function (data) {
            jQuery("#wcap_main_div").html(data);
            jQuery(document).find('.whcom_table:not(.wcap_not_datatable) table').each(function () {
                jQuery.fn.dataTable.ext.classes.sPageButton = 'whcom_button whcom_button_small whcom_button_secondary';
                jQuery.fn.dataTable.ext.classes.sPageButtonActive = 'whcom_button_primary';
                jQuery(this).DataTable(dataTablesConfig);
            });
        });

    };
    SubmitUpdateClient = function (event) {
        event.preventDefault();

        var args = jQuery(this).serialize();

        jQuery("#wcap_update_client_form input").prop("disabled", true);

        console.log(args);

        jQuery.post(wcap_ajaxurl, args, function (data) {
            jQuery("#wcap_update_client_form input").prop("disabled", false);

            data = JSON.parse(data);
            if (data.result == "success") {
                window.scrollTo(0, 0);
                jQuery("#profile_update_success").show();
                jQuery("#profile_update_error").hide();
                jQuery("#wcap_update_client_form").hide();
            }
            else {
                console.log(data);
                jQuery("#profile_update_error").html(data).show();
            }
        });
    };
    SubmitUpdatePassword = function (event) {
        event.preventDefault();

        var args = jQuery(this).serialize();

        jQuery("#wcap_update_password_form input").prop("disabled", true);

        jQuery.post(wcap_ajaxurl, args, function (data) {
            jQuery("#wcap_update_password_form input").prop("disabled", false);

            if (data['status'] == "success") {
                alert("Password updated successfully!");
                jQuery("#wcap_update_password_form input[type=reset]").click();
            }
            else {
                alert(data);
            }
        });
    };
    SubmitRegisterClient = function (event) {
        event.preventDefault();

        var args = jQuery(this).serialize();
        oldHTML = jQuery("#register_form_button").html();

        var view_container = jQuery('.wcap_view_container');
        var view_content = view_container.find('.wcap_vew_content');
        var view_response = view_container.find('.wcap_view_response');

        view_response.html(wcap_spinner_icon).show();

        jQuery.post(wcap_ajaxurl, args, function (data) {
            data = JSON.parse(data);
            console.log(data);
            if (data.status == "OK") {


                jQuery('html, body').animate({
                    scrollTop: jQuery('#register_client_form').offset().top - 40 //#DIV_ID is an example. Use the id of your destination on the page
                }, 'slow');

                jQuery("#register_message").removeClass();
                jQuery("#register_client_form").fadeOut();
                /*alert( "New User has been created" );*/

                jQuery('.wcop_response').addClass('whcom_alert whcom_alert_success');
                jQuery('.wcop_response').html("New User Created Successfull").show().delay(100);
                var oldURL = window.location.href;
                var index = 0;
                var newURL = oldURL;
                index = oldURL.indexOf('?');
                if (index === -1) {
                    index = oldURL.indexOf('#');
                }
                if (index !== -1) {
                    newURL = oldURL.substring(0, index);
                }
                setTimeout(function () {
                    window.location.replace(newURL);
                }, 1000);
            }
            else {


                jQuery('html, body').animate({
                    scrollTop: jQuery('#register_client_form').offset().top - 40 //#DIV_ID is an example. Use the id of your destination on the page
                }, 'slow');

                jQuery("#register_form_button").html(oldHTML);

                jQuery('.wcop_response').addClass('whcom_alert whcom_alert_danger');
                jQuery('.wcop_response').html(data.message).show().delay(200);
                jQuery('#register_client_form :input:enabled:visible:first').focus();

            }
        });
    };


    SubmitAddAccount = function (event) {
        event.preventDefault();

        var args = jQuery(this).serialize();
        var form = jQuery("#wcap_add_contact_form");
        var response_container = form.find('.wcap_response_text');
        response_container.removeClass('whcom_alert_success whcom_alert_info whcom_alert_warning whcom_alert_danger').slideUp(500);

        jQuery.post(wcap_ajaxurl, args, function (data) {
            var res = JSON.parse(data);
            console.log(res);
            response_container.slideDown(500).text(res.message);
            form.html(response_container);
            if (res.result === 'success') {
                response_container.addClass('whcom_alert_success');
            }
            else {
                response_container.addClass('whcom_alert_danger');
            }
            setTimeout(function () {
                jQuery("#wcap_choose_contact_form").submit();
            }, 3000);
        });
    };
    SubmitSelectAccount = function (event) {
        event.preventDefault();
        jQuery("#wcap_main_div .wcap").html('<div style="padding:20px;text-align: center;font-size:20px">' +
            '<i class="whcom_icon_spinner-1 whcom_animate_spin"></i> ' + WCAP_Loading_text + '</div>');
        var args = jQuery(this).serialize();
        jQuery.post(wcap_ajaxurl, args, function (data) {
            jQuery("#wcap_main_div  .wcap").html(data);
        });
    };
    SubmitUpdateAccount = function (event) {

        event.preventDefault();

        var k = jQuery("#wcap_update_contact_form").serialize();
        console.log(k);
        var view_container = jQuery('.wcap_view_container');
        var view_content = view_container.find('.wcap_view_content');
        var view_response = view_container.find('.wcap_view_response');

        view_response.html(wcap_spinner_icon).show();

        jQuery.post(wcap_ajaxurl, k, function (data) {
                var res = JSON.parse(data);
                console.log(res['api_response']);
                view_response.show().html(res.message);
                if (res.status === "OK") {

                    if (res.action_dont_hide != "YES") {
                        view_content.hide();
                    }

                    if (res.action_refresh === "YES") {
                        //refresh here there is a command
                    }
                }
            }
        );
    };

    OpenTicket = function (event) {
        event.preventDefault();

        var id = jQuery(this).attr("data-id");

        var args = 'id=' + id + '&action=wcap_requests&what=ticket_form';

        var html = '<div style="padding:20px;text-align: center;font-size:20px">' +
            '<i class="whcom_icon_spinner-1  whcom_animate_spin"></i> ' + WCAP_Loading_text + '</div>';
        jQuery("#wcap_main_div .wcap").html(html);

        jQuery.post(wcap_ajaxurl, args, function (data) {
            jQuery("#wcap_main_div .wcap").html(data);

            jQuery(document).find('.whcom_table:not(.wcap_not_datatable) table').each(function () {
                jQuery.fn.dataTable.ext.classes.sPageButton = 'whcom_button whcom_button_small whcom_button_secondary';
                jQuery.fn.dataTable.ext.classes.sPageButtonActive = 'whcom_button_primary';
                jQuery(this).DataTable(dataTablesConfig);
            });
            //jQuery( "table.wcap_responsive_table" ).tablesaw();
            //jQuery( "table.whcom_table" ).tablesaw();
            //jQuery( "table.wcap_responsive_table" ).trigger( "enhance.tablesaw" );

            //jQuery('table#whcom_table').table().data( "table" ).refresh();
            //jQuery('table#whcom_table').tablesaw().data( "tablesaw" ).refresh();
        });
    };
    // SubmitOpenTicketForm = function (event) {
    //     event.preventDefault();
    //     oldHtml = jQuery("#wcap_md_form_submit").html();
    //     jQuery("#wcap_md_form_submit").html("<i class='whcom_icon_spinner-1  whcom_animate_spin'></i>");
    //     var args = jQuery("#open_ticket_form").serialize();
    //     jQuery("#open_ticket_form input").prop("disabled", true);
    //     jQuery("#open_ticket_form button").prop("disabled", true);
    //     jQuery("#open_ticket_form textarea").prop("disabled", true);
    //
    //     jQuery.post(wcap_ajaxurl, args, function (data) {
    //         if (is_json(data)) {
    //             data = JSON.parse(data);
    //             console.log(data);
    //             if (data.result == "success") {
    //                 jQuery("#open_ticket_form").hide();
    //                 var open_ticket_message_container = jQuery("#open_ticket_message");
    //                 open_ticket_message_container.removeClass();
    //                 jQuery('html, body').animate({
    //                     scrollTop: jQuery('#open_ticket_message').offset().top - 10000 //#DIV_ID is an example. Use the id of your destination on the page
    //                 }, 'slow');
    //                 open_ticket_message_container.removeClass().html(data.response_html).show();
    //                 /*                    setTimeout(function () {
    //
    //                  jQuery("#wcap_main_div .wcap").html("<div style='padding:15px;text-align: center'>" +
    //                  "<i class='whcom_icon_spinner-1 whcom_animate_spin'></i> Loading ...</div>");
    //                  var k = "action=wcap_requests&what=load_page&page=tickets";
    //
    //                  jQuery.post(wcap_ajaxurl, k, function (data) {
    //                  jQuery("#wcap_main_div").html(data);
    //
    //                  jQuery(document).find('.whcom_table:not(.wcap_not_datatable) table').each(function () {
    //                  jQuery.fn.dataTable.ext.classes.sPageButton = 'whcom_button whcom_button_small whcom_button_secondary';
    //                  jQuery.fn.dataTable.ext.classes.sPageButtonActive = 'whcom_button_primary';
    //                  jQuery(this).DataTable(dataTablesConfig);
    //                  }
    //                  );
    //                  });
    //                  }, 2000);*/
    //             }
    //             else {
    //                 jQuery("#open_ticket_message").addClass("whcom_alert whcom_alert_warning").html("<span class='whcom_icon_cancel-circled'></span>" + data.result);
    //                 jQuery('html, body').animate({
    //                     scrollTop: jQuery('#ticket_top').offset().top - 20 //#DIV_ID is an example. Use the id of your destination on the page
    //                 }, 'slow');
    //                 jQuery("#open_ticket_form").show();
    //                 jQuery("#wcap_md_form_submit").html(oldHtml);
    //
    //                 // var top = $('#ticket_top');
    //                 // if (top.length) {
    //                 //     jQuery('html, body').animate({
    //                 //         scrollTop: jQuery('#ticket_top').offset().top - 20 //#DIV_ID is an example. Use the id of your destination on the page
    //                 //     }, 'slow');
    //                 //     jQuery("#open_ticket_form").show();
    //                 //     jQuery("#wcap_md_form_submit").html(oldHtml);
    //                 // }
    //             }
    //         }
    //         else {
    //             jQuery("#open_ticket_message").addClass("whcom_alert whcom_alert_warning").html("<span class='whcom_icon_cancel-circled'></span> " + data);
    //             jQuery("#wcap_md_form_submit").html(oldHtml);
    //             jQuery("#open_ticket_form:input:enabled:visible:first:focus");
    //
    //             jQuery('html, body').animate({
    //                 scrollTop: jQuery('#open_ticket_message').offset().top - 10000 //#DIV_ID is an example. Use the id of your destination on the page
    //             }, 'slow');
    //             setTimeout(function () {
    //                 jQuery("#open_ticket_message").fadeOut();
    //             }, 2000);
    //
    //
    //             jQuery("#open_ticket_form input").prop("disabled", false);
    //             jQuery("#open_ticket_form button").prop("disabled", false);
    //             jQuery("#open_ticket_form textarea").prop("disabled", false);
    //         }
    //     });
    // };
    SubmitReplyTicket = function (event) {
        event.preventDefault();

        var args = jQuery(this).serialize();

        jQuery.post(wcap_ajaxurl, args, function (data) {
            data = JSON.parse(data);
            if (data.status == "OK") {
                //jQuery( "#reply_ticket_form textarea[name=message]" ).summernote( "code", "" );
                jQuery('#reply_ticket_form').slideToggle();
                jQuery("#load_ticket_btn").click();
            }
            else {
                alert(data);
            }
        });
    };
    RemoveCartTR = function (event) {
        event.preventDefault();

        key = jQuery(this).closest("tr").attr("data-key");
        jQuery(this).closest("tr").remove();
        jQuery("#total_price").html("<i class='whcom_icon_spinner-1  whcom_animate_spin'></i>");
        jQuery.post(wcap_ajaxurl, {
            action: "wcap_requests",
            what: "remove_cart_time",
            key: key
        }, function (data) {
            jQuery("#total_price").html(data);
        })
    };
    SubmitRequestCancel = function (event) {
        event.preventDefault();
        jQuery.post(wcap_ajaxurl, jQuery(this).serialize(), function (data) {
            if (is_json(data)) {
                data = JSON.parse(data);
                if (data.result == "success") {
                    jQuery("#wcap_request_cancel").hide();
                    jQuery("#wcap_success_div").show();
                }
                else if (data.result == "error") {
                    jQuery("#wcap_request_cancel").hide();
                    jQuery("#wcap_error_div").html(data.message).show();
                }
            }
            else {
                jQuery("#wcap_request_cancel").hide();
                jQuery("#wcap_error_div").html(data).show();
            }
        })
    };
    /*AddProduct = function( event ) {
     event.preventDefault();

     var pid = jQuery( this ).attr( "data-pid" );
     var page = "cart";

     var args = jQuery( this ).attr( "href" );
     if ( args.substr( 0, 1 ) == "?" ) {
     args = args.substr( 1 );
     }

     args += '&action=wcap_requests&what=load_page&page=' + page;

     // var html = `<div style="padding:20px;text-align: center;font-size:20px"><i class="fa fa-spin fa-spinner"></i> Loading ....</div>`;
     // jQuery( "#wcap_main_div .wcap" ).html( html );
     //
     // jQuery.post( wcap_ajaxurl, args, function( data ) {
     // 	jQuery( "#wcap_main_div .wcap" ).html( data );
     // 	if ( jQuery( "table.wcap_responsive_table" ).length > 0 ) {
     // 		jQuery( "table.wcap_responsive_table" ).tablesaw();
     // 	}
     // } );
     }*/
    PopState = function (event) {
        /*st = event.originalEvent.state;
         console.log( st );
         console.log( st.url );*/

        //console.log( window.location.href );
        //console.log( GET() );
        LoadData();
    };
    GET = function () {
        var urlParams;
        var match,
            pl = /\+/g,  // Regex for replacing addition symbol with a space
            search = /([^&=]+)=?([^&]*)/g,
            decode = function (s) {
                return decodeURIComponent(s.replace(pl, " "));
            },
            query = window.location.search.substring(1);

        urlParams = {};
        while (match = search.exec(query)) {
            urlParams[decode(match[1])] = decode(match[2]);
        }

        return urlParams;
    };
    set_new_url = function ($new_url, title) {
        if (title) {
            window.history.pushState({}, title, $new_url);
            document.title = title;
        }
        else {
            window.history.pushState({}, "", $new_url);
        }
    };
    remove_url_parameter = function (parameter, url, auto_change_url) {
        if (!url) {
            url = window.location.href;
        }
        //prefer to use l.search if you have a location/link object
        var urlparts = url.split('?');
        if (urlparts.length >= 2) {

            var prefix = encodeURIComponent(parameter) + '=';
            var pars = urlparts[1].split(/[&;]/g);

            //reverse iteration as may be destructive
            for (var i = pars.length; i-- > 0;) {
                //idiom for string.startsWith
                if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                    pars.splice(i, 1);
                }
            }

            url = urlparts[0] + '?' + pars.join('&');
            if (auto_change_url) {
                set_new_url(url);
            }
            else {
                return url;
            }
        }
        else {
            if (auto_change_url) {
                set_new_url(url);
            }
            else {
                return url;
            }
        }
    };
    get_url_values = function () {
        // It will return all query string variable names.
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for (var i = 0; i < hashes.length; i++) {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    };
    remove_query_string = function () {
        var uri = window.location.toString();
        if (uri.indexOf("?") > 0) {
            var clean_uri = uri.substring(0, uri.indexOf("?"));
            window.history.replaceState({}, document.title, clean_uri);
        }
    };
    set_url_parameter_value = function (key, val) {
        var all_vars = GET();
        all_vars[key] = val;

        var vars_string = "";
        jQuery.each(all_vars, function (k, v) {
            vars_string += encodeURI(k) + "=" + encodeURI(v) + "&";
        });

        if (count(all_vars) > 0) {
            if (vars_string.substr(-1) == "&") {
                vars_string = rtrim(vars_string, "&");
            }
            set_new_url("?" + vars_string);
        }
    };
    set_multi_url_parameters_value = function (params_array, remove_params_array) {
        var all_vars = GET();
        jQuery.each(params_array, function (key, val) {
            all_vars[key] = val;
        });

        if (remove_params_array) {
            jQuery.each(remove_params_array, function (i, v) {
                if (all_vars[v]) {
                    delete (
                        all_vars[v]
                    );
                }
            });
        }

        var vars_string = "";
        jQuery.each(all_vars, function (k, v) {
            vars_string += encodeURI(k) + "=" + encodeURI(v) + "&";
        });

        if (count(all_vars) > 0) {
            if (vars_string.substr(-1) == "&") {
                vars_string = rtrim(vars_string, "&");
            }
            set_new_url("?" + vars_string);
        }
    };
    UpdateConfigPrices = function (event) {
        jQuery("#spinner").show();
        var k = "action=wcap_requests&what=configurable_options_html&billingcycle=" +
            jQuery(".wcap_billingcycle").val() + "&pid=" + PID + "&" +
            jQuery(".configoption").serialize();
        jQuery.post(wcap_ajaxurl, k, function (data) {
            jQuery("#spinner").hide();
            if (is_json(data)) {
                data = JSON.parse(data);
                jQuery("#config_div").html(data.config_html);
                jQuery("#summary_order_div").html(data.order_summary_html);
                jQuery("#order_form_cart input[name=price]").val(data.prices.price);
                jQuery("#order_form_cart input[name=setup]").val(data.prices.setupfee);
            }
            else {
                alert(data);
            }
        });
    };

})
(jQuery);

(function ($) {
    "use strict";

    LoadData();

    jQuery(window).on("popstate", PopState);
    jQuery(document).on('submit', '#ask_domain_form', function (event) {
        event.preventDefault();
    });
    jQuery(document).on('click', '#domain_whois_check_btn', CheckDomainAvailability);
    jQuery(document).on('click', '.wcap_modal_opener', ModalOpener);
    jQuery(document).on('ready', DocumentReady);
    jQuery(document).on("submit", "#whmcs_validation_form", SubmitValidationForm);
    jQuery(document).on("submit", "#whmcs_reset_pwd_form", SubmitResetPassword);

    jQuery(document).on("submit", "#wcap_contactus_from", SubmitContactForm);

    jQuery(document).on("submit", "#updowngrade_form_final", function (event) {

        event.preventDefault();

        var k = jQuery("#updowngrade_form_final").serialize();

        var view_container = jQuery('.wcap_view_container');
        var view_content = view_container.find('.wcap_view_content');
        var view_response = view_container.find('.wcap_view_response');

        view_response.html(wcap_spinner_icon).show();
        jQuery.post(wcap_ajaxurl, k, function (data) {
            var res = JSON.parse(data);
            console.log(res);
            view_response.show().html(res.message);
            if (res.status === "OK") {
                view_content.hide();
            }
        });
    });

    // options upgrade finel : farooq
    jQuery(document).on("submit", "#updowngrade_options_form_final", function (event) {
        event.preventDefault();

        var k = jQuery("#updowngrade_options_form_final").serialize();

        var view_container = jQuery('.wcap_view_container');
        var view_content = view_container.find('.wcap_view_content');
        var view_response = view_container.find('.wcap_view_response');

        view_response.html(wcap_spinner_icon).show();
        jQuery.post(wcap_ajaxurl, k, function (data) {
            var res = JSON.parse(data);
            console.log(res);
            view_response.show().html(res.message);
            if (res.status === "OK") {
                view_content.hide();
            }
        });

    });

    jQuery(document).on("click", "#whmcs_logout_btn", Logout);
    jQuery(document).on("submit", "#domain_ns_form", function (event) {
        event.preventDefault();

        jQuery.post(wcap_ajaxurl, $("#domain_ns_form").serialize(), function (data) {
            if (data == "OK") {
                set_url_parameter_value("whmpca", "cart");
                LoadData();
            }
            else {
                alert(data);
            }
        });
    });
    jQuery(document).on("submit", "#mass_pay_form", function (event) {
        event.preventDefault();
        var mass_pay_form = $(this);
        var response_form = $('.wcap_mass_pay_container');
        var response_text = mass_pay_form.find('.wcap_mass_pay_response');
        jQuery.post(wcap_ajaxurl, $("#mass_pay_form").serialize(), function (data) {

	        var res = JSON.parse( data );
	        console.log(res);
	        response_text.show();
	        if ( res.status === "OK" ) {
		        response_form.html( res.response_html ).addClass( 'whcom_text_center whcom_form_field' );
		        $( '.whcom_op_view_invoice_button' ).trigger( 'click' );
	        }
	        else {
		        response_text.html( res.message );
	        }
        });
    });
    jQuery(document).on("click", "#load_invoices_link", LoadInvoiceLink);
    jQuery(document).on("click", "#load_tickets_link", LoadTicketsLink);
    jQuery(document).on("click", "#load_domains_link", LoadDomainsLink);
    jQuery(document).on("click", "#load_service_link", LoadServiceLink);
    //jQuery( document ).on( "click", ".add_product_link", AddProduct );
    jQuery(document).on("click", ".wcap_load_single_ticket", LoadSingleTicket);
    jQuery(document).on("click", ".no_load", NoLoad);
    jQuery(document).on("click", ".wcap_load_page", LoadPage);
    jQuery(document).on("submit", "#wcap_update_client_form", SubmitUpdateClient);
    jQuery(document).on("submit", "#wcap_update_password_form", SubmitUpdatePassword);
    jQuery(document).on("submit", "#register_client_form", SubmitRegisterClient);
    jQuery(document).on("submit", "#wcap_add_contact_form", SubmitAddAccount);
    jQuery(document).on("submit", "#wcap_choose_contact_form", SubmitSelectAccount);
    jQuery(document).on("submit", "#wcap_update_contact_form", SubmitUpdateAccount);
    jQuery(document).on("click", ".open_ticket", OpenTicket);
    //jQuery(document).on("submit", "#open_ticket_form", SubmitOpenTicketForm);
    jQuery(document).on("submit", "#reply_ticket_form", SubmitReplyTicket);
    jQuery(document).on("click", ".wcap_check", CheckOut1);
    jQuery(document).on("click", ".remove_item", RemoveCartTR);
    jQuery(document).on("submit", "#wcap_request_cancel", SubmitRequestCancel);

    jQuery(document).on("submit", "#security_question", SubmitUpdateSecurityQuestions);

    jQuery(document).on("submit", "#update_credit_card_form", SubmitUpdateUpdateCreditCard);

    jQuery(document).on("change", ".wcap_billingcycle", function () {
        var code = jQuery(this).val();
        var pid = jQuery(this).attr("data-pid");

        jQuery("#spinner").show();
        jQuery(".wcap_billingcycle").prop("disabled", true);
        jQuery("button#button1").prop("disabled", true).html("Wait...");
        jQuery.post(wcap_ajaxurl, {
            action: "wcap_requests",
            what: "configurable_options_html",
            pid: pid,
            billingcycle: code
        }, function (data) {
            jQuery("button#button1").prop("disabled", false).html("Continue <i class='whcom_icon_right-hand'></i>");
            jQuery(".wcap_billingcycle").prop("disabled", false);
            jQuery("#spinner").hide();
            if (is_json(data)) {
                data = JSON.parse(data);
                jQuery("#config_div").html(data.config_html);
                jQuery("#summary_order_div").html(data.order_summary_html);
            }
            else {
                alert(data);
            }

        });

        /*jQuery( "#price_td, #price_td2" ).html( Currencies[ cur_code ].prefix + Product[ "pricing" ][ cur_code ][ code ] + " " + Currencies[ cur_code ].suffix );
         jQuery( "#billing_cycle_td" ).html( BillingCycles[ code ] );
         jQuery( "#setup_td" ).html( Currencies[ cur_code ].prefix + Product[ "pricing" ][ cur_code ][ code.substr( 0, 1 ) + "setupfee" ] + " " + Currencies[ cur_code ].suffix );

         var fee = Number( Product[ "pricing" ][ cur_code ][ code ] );
         var setup_fee = Number( Product[ "pricing" ][ cur_code ][ code.substr( 0, 1 ) + "setupfee" ] );
         var total = fee + setup_fee;

         jQuery( "#order_form_cart input[name=price]" ).val( fee );
         jQuery( "#order_form_cart input[name=setup]" ).val( setup_fee );

         jQuery( "#total_td" ).html( Currencies[ cur_code ].prefix + total + " " + Currencies[ cur_code ].suffix )*/
    });
    jQuery(document).on("submit", "#order_form_cart", function (event) {
        event.preventDefault();

        jQuery("#button1").html("Adding ....");
        jQuery.post(wcap_ajaxurl, jQuery("#order_form_cart").serialize(), function (data) {
            if (data == "OK") {
                if ($("#order_form_cart input[name=service_with_domain]").length == 1) {
                    set_url_parameter_value("whmpca", "confdomains");
                    LoadData();
                }
                else {
                    var new_link = "<a style='display:none' class='wcap_load_page' data-page='cart' id='wcap_new_link'>Go</a>";
                    jQuery("#order_form_cart").append(new_link);
                    jQuery("#wcap_new_link").click();
                }
            }
            else {
                jQuery("#button1").html("<i class='fa fa-plus'></i> Add Order");
                alert(data);
            }
        });

        /*jQuery.post( wcap_ajaxurl, jQuery( this ).serialize(), function( data ) {
         if ( is_json( data ) ) {
         data = JSON.parse( data );
         if ( data.result == "success" ) {
         console.log( "remove_url_parameter" );
         new_link = "<a style='display:none' class='wcap_load_page' data-page='viewinvoice' id='invoice_link' href='invoiceid=" + data.invoiceid + "'>Go</a>";
         jQuery( "#order_form_cart" ).append( new_link );
         jQuery( "#invoice_link" ).click();
         } else if ( data.result ) {
         alert( "Error: " + data.result );
         } else {
         alert( "Unknown Error" );
         }
         } else {
         alert( "Error: ".data );
         }
         } );*/
    });
    jQuery(document).on("click", ".wcap_ifancybox", function (event) {
        event.preventDefault();
        var href = jQuery(this).attr("href");
        jQuery.fancybox({
            type: "iframe",
            href: href,
            minWidth: '90%',

            afterShow: function () {
                var customContent = '<a title="Close" class="whcom_op_thickbox_redirect_overlay" href="javascript:;">Close</a>';
                jQuery('.fancybox-outer').append(customContent);
            }
        });
    });
    jQuery(document).on('click', '.whcom_op_thickbox_redirect_overlay', function () {
        jQuery.fancybox.close();
    });
    jQuery(document).on("change", "#config_div select, #config_div input[type=radio], #config_div input[type=checkbox], #config_div input[type=number]", UpdateConfigPrices);
    jQuery(document).on("change", "#wcap_service_status", function (event) {
        set_url_parameter_value("status", jQuery(this).val());

        LoadData();
    });
    jQuery(document).on("click", "input[name=paytype]", function (event) {
        var val = jQuery(this).val();
        if (val == "domainown") {

            jQuery("#domain_check_form").hide();
            jQuery("#domain_own_check_div").show();

        }
        else {

            jQuery("#domain_own_check_div").hide();
            jQuery("#domain_check_form").show();

        }
    });
    jQuery(document).on("click", "#domain_own_check_btn", function (event) {
        event.preventDefault();
        jQuery("#continue_btn").hide();
        var val = jQuery("input[name=domain]").val();
        jQuery("input[name=domain]").prop("disabled", true);
        jQuery.post(wcap_ajaxurl + "?checkown_domain",
            {action: "wcap_requests", domain: val, what: "domain_own_check"},
            function (data) {
                jQuery("input[name=domain]").prop("disabled", false);
                if (data == "OK") {
                    LoadData();
                }
                else {
                    alert(data);
                }
            });
    });

    // This function is called
    function function123(data) {
        if (is_json(data)) {
            data = JSON.parse(data);
            if (data.status == "unavailable") {
                //jQuery(".wcap_op_domain_response").html(data.domain_price_html).show();
                jQuery("#continue_domain_transfer_btn_container").show();
            }
            else {
                jQuery(".wcap_op_domain_response").html(data.status).show();
            }
        }
        else {
            alert(data);
        }
    }

    jQuery(document).on("submit", "#transfer_domain_form", function (event) {
        event.preventDefault();

        // Ajax post request.
        jQuery.post(wcap_ajaxurl, jQuery("#transfer_domain_form").serialize(), function123);
    });


    jQuery(document).on("submit", "#domain_config_search_form", function (event) {
        event.preventDefault();

        jQuery("#domain_search_success").hide();
        jQuery("#continue_domain_register_btn_container").hide();
        jQuery("#domain_register").val($("#search_domain").val() + '' + $("#extension").val());

        var k = jQuery(this).serialize();
        jQuery(this).find("input[name=domain]").prop("disabled", true);
        jQuery("#domain_config_search_form button[type=submit]").html("<i class='whcom_icon_spinner-1 whcom_animate_spin'></i>");
        jQuery(".wcap_op_domain_response").html("");
        jQuery.post(wcap_ajaxurl, k, function (data) {
            jQuery("#domain_config_search_form input[name=domain]").prop("disabled", false);
            jQuery("#domain_config_search_form button[type=submit]").html("Check");
            if (is_json(data)) {
                data = JSON.parse(data);
                if (data.result == "success" && data.status == "available") {
                    jQuery("#wcap_html").html(data.domain_price_html).show();
                    jQuery("#domain_search_success").show();
                    jQuery("#continue_domain_register_btn").show();
                    jQuery("#continue_domain_register_btn_container").show();
                    jQuery("#domain_search_error").hide();

                }
                else {
                    jQuery("#continue_domain_register_btn_container").show();
                    jQuery("#domain_search_error").show();

                    jQuery("#domain_search_success").hide();
                    jQuery("#continue_domain_register_btn").hide();
                }
            }
            else {
                console.log(data);
            }
        });
    });

    jQuery(document).on("submit", "#domain_config_transfer", function (event) {
        event.preventDefault();
        jQuery("#continue_domain_transfer_btn_container").hide();
        var oldhtml = jQuery("#domain_config_transfer_button").html();

        jQuery("#domain_config_transfer_button").html("<i class='whcom_icon_spinner-1  whcom_animate_spin'></i>");
        jQuery("#domaint_transfer_text").val(jQuery("#search_transfer_domain").val() + '' + jQuery("#transfer_domain_ext").val());

        var k = jQuery("#domain_config_transfer").serialize();

        // Ajax post request.
        jQuery.post(wcap_ajaxurl, k, function (data) {
            if (is_json(data)) {
                data = JSON.parse(data);
                if (data.status == "unavailable") {
                    //jQuery(".wcap_op_domain_response").html(data.domain_price_html).show();
                    jQuery("#continue_domain_transfer_btn_container").show();
                    jQuery("#continue_domain_transfer_btn").show();
                    jQuery("#domain_config_transfer_success").show();
                    jQuery("#domain_config_transfer_error").hide();
                    jQuery("#domain_config_transfer_button").html(oldhtml);
                }
                else {
                    jQuery("#continue_domain_transfer_btn_container").show();
                    jQuery("#domain_config_transfer_error").show();
                    jQuery("#continue_domain_transfer_btn").hide();
                    jQuery("#domain_config_transfer_success").hide();
                    jQuery("#domain_config_transfer_button").html(oldhtml);
                }
            }
            else {
                alert(data);
                jQuery("#domain_config_transfer_button").html(oldhtml);
            }
        });
    });

    jQuery(document).on("submit", "#domain_search_form", function (event) {
        event.preventDefault();
        jQuery("#wcap_domain_register").val(jQuery("#wcap_search_domain").val() + '' + jQuery("#wcap_extension").val());
        var k = jQuery(this).serialize();
        jQuery(this).find("input[name=domain]").prop("disabled", true);
        jQuery(".whcom_alert.whcom_alert_success, .whcom_alert.whcom_alert_danger, #continue_domain_register_btn, #continue_domain_register_btn_container").hide();
        jQuery("#domain_search_form button[type=submit]").html("<i class='whcom_icon_spinner-1  whcom_animate_spin'></i> Checking");
        jQuery("#wcap_html").html("");

        jQuery.post(wcap_ajaxurl, k, function (data) {
            jQuery("#domain_search_form input[name=domain]").prop("disabled", false);
            jQuery("#domain_search_form button[type=submit]").html("Check");
            if (is_json(data)) {
                data = JSON.parse(data);

                if (data.result == "success" && data.status == "available") {
                    jQuery(".whcom_alert.whcom_alert_success").show();
                    jQuery("#continue_domain_register_btn").show();
                    jQuery("#continue_domain_register_btn_container").show();
                    jQuery("#wcap_html").html(data.domain_price_html);
                }
                else if (data.message) {
                    jQuery(".whcom_alert.whcom_alert_danger").html("Error: " + data.message).show();
                }
                else {
                    jQuery(".whcom_alert.whcom_alert_danger").html("Domain not available for registration").show();
                }
            }
            else {
                alert(data);
            }
        });
    });
    jQuery(document).on("click", "#continue_domain_transfer_btn", function (event) {
        event.preventDefault();
        var old_html = jQuery(this).html();
        jQuery(this).html(WCAP_Loading_text);

        //var k = "action=wcap_requests&what=transferdomain&domain=" + jQuery.trim(jQuery("#domain_attach").val()) + "." + jQuery.trim(jQuery("#domain_attach").val());
        var k = "action=wcap_requests&what=transferdomain&domain=" + jQuery.trim(jQuery("#search_transfer_domain").val()) + jQuery.trim(jQuery("#transfer_domain_ext").val());

        jQuery.post(wcap_ajaxurl, k, function (data) {
            if (data == "OK") {

                //set_url_parameter_value( "whmpca", "cart" );
                var params = GET();
                if (isset(params["pid"])) {
                    set_url_parameter_value("whmpca", "add_service_page");
                }
                else {
                    set_url_parameter_value("whmpca", "confdomains");
                }
                LoadData();
            }
            else {
                jQuery("#continue_domain_register_btn").html(old_html);
                alert(data);
            }
        });
    });
    jQuery(document).on("click", "#continue_domain_register_btn", function (event) {
        event.preventDefault();
        var old_html = jQuery(this).html();
        jQuery(this).html(WCAP_Loading_text);

        var k = "action=wcap_requests&what=registerdomain&billingcycle=" + jQuery(".wcap_billingcycle").val();
        k += "&currency=" + jQuery("input[name=currency]").val();
        jQuery.post(wcap_ajaxurl, k, function (data) {
            if (data == "OK") {
                //set_url_parameter_value( "whmpca", "cart" );
                var params = GET();
                if (isset(params["pid"])) {
                    set_url_parameter_value("whmpca", "add_service_page");
                }
                else {
                    set_url_parameter_value("whmpca", "confdomains");
                }
                LoadData();
            }
            else {
                jQuery("#continue_domain_register_btn").html(old_html);
                alert(data);
            }
        });
    });


    jQuery(document).on("change", "#domain_actions_select", function (event) {
        event.preventDefault();

        var val = jQuery(this).val();
        var domain = jQuery(this).attr("data-domain");
        if (val == "1") {
            jQuery.fancybox({
                type: "ajax",
                ajax: {
                    type: "POST",
                    data: {action: "wcap_requests", what: "domain_renew_modal", domain: domain, domainid: val}
                },
                href: wcap_ajaxurl
            });
        }

        jQuery(this).val(0);
    });
    jQuery(document).on("submit", "#domain_renew_form", function (event) {
        event.preventDefault();

        jQuery.fancybox.close();
        jQuery.post(wcap_ajaxurl, jQuery("#domain_renew_form").serialize(), function (data) {
            if (data == "OK") {
                alert("Domain renewed successfully");
            }
            else {
                alert(data);
            }
        });
    });

    jQuery(document).on("submit", "#domain_config_attach", function (event) {
        event.preventDefault();

        jQuery.post(wcap_ajaxurl, jQuery("#domain_config_attach").serialize(), function (data) {
            /*if (data == "OK") {
             $('.wcap_op_domain_response').html("Domain renewed successfully").show();
             }
             else {
             $('.wcap_op_domain_response').html(data).show();
             }*/
            /*if (data=="OK") {
             set_url_parameter_value("whmpca", "add_service_page");

             LoadData();
             } else {
             alert (data);
             }*/

            set_url_parameter_value("whmpca", "add_service_page");
            set_url_parameter_value("domain", jQuery.trim(jQuery("#domain_attach").val()) + "." + jQuery.trim(jQuery("#domain_attach_ext").val()));

            LoadData();
        });
    });
    jQuery(document).on("submit", "#domain_config_renew", function (event) {
        event.preventDefault();
        $("#domain_attach").val($("#domain_attach_ext").val() + '.' + $("#search_renew_ext").val());
        jQuery.post(wcap_ajaxurl, jQuery("#domain_config_renew").serialize(), function (data) {
            if (data == "OK") {
                $('.wcap_op_domain_response').html("Domain renewed successfully").show();
            }
            else {
                $('.wcap_op_domain_response').html(data).show();
            }
        });
    });

    jQuery(document).on("click", "#manage_domain_auto-renew_form", function (event) {

        event.preventDefault();

        var k = jQuery("#manage_domain_auto-renew_form").serialize();

        var view_container = jQuery('.wcap_view_container');
        var view_content = view_container.find('.wcap_view_content');
        var view_response = view_container.find('.wcap_view_response');

        view_response.html(wcap_spinner_icon).show();
        jQuery.post(wcap_ajaxurl, k, function (data) {
            var res = JSON.parse(data);
            console.log(res);
            view_response.show().html(res.message);
            if (res.status === "OK") {
                view_content.hide();
            }
        });


        /*
         var status = jQuery( this ).attr( "data-value" );
         var id = jQuery( this ).attr( "data-id" );
         var This = jQuery( this );

         jQuery( "#wcap_loading" ).show();
         jQuery.post( wcap_ajaxurl, {
         action: "wcap_requests",
         what: "update_donotrenew_status",
         domainid: id,
         status: status
         }, function ( data ) {
         jQuery( "#wcap_loading" ).hide();
         if ( data == "OK" ) {
         if ( status == "1" ) {
         jQuery( This ).attr( "data-value", "0" );
         jQuery( This ).html( "No" );
         }
         else {
         jQuery( This ).attr( "data-value", "1" );
         jQuery( This ).html( "Yes" );
         }
         }
         else {
         alert( data );
         }
         } );
         */
    });
    jQuery(document).on("submit", "#addon_form", function (event) {
        event.preventDefault();

        var Data = jQuery(this).serialize();
        jQuery.post(wcap_ajaxurl, Data, function (data) {
            if (data.substr(0, 2) == "OK") {
                set_url_parameter_value("whmpca", "cart");
                LoadData();
            }
            else {
                alert(data);
            }
        });
    });
    jQuery(document).on("click", "#manage_registrar_lock_form", function (event) {
        event.preventDefault();

        var k = jQuery("#manage_registrar_lock_form").serialize();

        var view_container = jQuery('.wcap_view_container');
        var view_content = view_container.find('.wcap_view_content');
        var view_response = view_container.find('.wcap_view_response');

        view_response.html(wcap_spinner_icon).show();
        jQuery.post(wcap_ajaxurl, k, function (data) {
            var res = JSON.parse(data);
            console.log(res);
            view_response.show().html(res.message);
            if (res.status === "OK") {
                view_content.hide();
            }
        });


    });

    jQuery(document).on("submit", "#update_dns_form", function (event) {
        event.preventDefault();

        var k = jQuery("#update_dns_form").serialize();

        var view_container = jQuery('.wcap_view_container');
        var view_content = view_container.find('.wcap_view_content');
        var view_response = view_container.find('.wcap_view_response');

        view_response.html(wcap_spinner_icon).show();
        jQuery.post(wcap_ajaxurl, k, function (data) {
            var res = JSON.parse(data);
            console.log(res);
            view_response.show().html(res.message);
            if (res.status === "OK") {
                view_content.hide();
            }
        });


        /*
         jQuery.post( wcap_ajaxurl, jQuery( "#update_dns_form" ).serialize(), function ( data ) {
         if ( data == "OK" ) {
         alert( "NS Servers Updated" );
         }
         else {
         alert( data );
         }
         } );
         */
    });


    jQuery(document).on("submit", "#update_whois_form", function (event) {
        event.preventDefault();

        var k = jQuery("#update_whois_form").serialize();


        var view_container = jQuery('.wcap_view_container');
        var view_content = view_container.find('.wcap_view_content');
        var view_response = view_container.find('.wcap_view_response');


        view_response.html(wcap_spinner_icon).show();
        jQuery.post(wcap_ajaxurl, k, function (data) {
            var res = JSON.parse(data);

            console.log(res);
            view_response.show().html(res.message);
            if (res.status === "OK") {
                view_content.hide();
            }
        });
    });


    jQuery(document).on("click", "#validate_promotion_code_btn", function (event) {
        event.preventDefault();

        var val = jQuery("#promotion_code").val();
        if (val) {
            jQuery("#validate_promotion_code_btn, #promotion_code").prop("disabled", true);
            jQuery.post(wcap_ajaxurl, {
                action: "wcap_requests",
                "what": "validate_coupon",
                code: val
            }, function (data) {
                jQuery("#validate_promotion_code_btn, #promotion_code").prop("disabled", false);
                if (data == "OK") {
                    LoadData();
                }
                else {
                    alert(data);
                }
            });
        }
    });
    jQuery(document).on("click", "#remove_promotion_btn", function (event) {
        event.preventDefault();

        jQuery.post(wcap_ajaxurl, {action: "wcap_requests", what: "remove_coupon"}, function (data) {
            LoadData();
        })
    });
    jQuery(document).on("click", "#domain_epp_btn", function (event) {
        event.preventDefault();
        var id = jQuery(this).attr("data-id");
        jQuery(this).hide();

        jQuery("#epp_code_div").html("Getting code ...");

        jQuery.post(wcap_ajaxurl, {action: "wcap_requests", what: "epp_code", domainid: id}, function (data) {
            jQuery("#epp_code_div").html(data);
        });
    });

    jQuery(document).on("submit", ".updowngrade_form", function (event) {
        event.preventDefault();

        var k = base64_encode(jQuery(this).serialize());

        set_url_parameter_value("whmpca", "updowngrade_final");
        set_url_parameter_value("k", k);
        LoadData();
    });

    //by farooq
    //todo: why not in post?
    jQuery(document).on("submit", "#updowngrade_options_form", function (event) {
        event.preventDefault();

        var k = base64_encode(jQuery(this).serialize());
        set_url_parameter_value("whmpca", "updowngrade_final");
        set_url_parameter_value("k", k);
        LoadData();
    });

    //filter services
    jQuery(document).on("click", ".wcap_services_filter", function (event) {
        event.preventDefault();

        var status = jQuery(this).attr("data-status");
        console.log(status);
        if (status === "") {
            jQuery(".data_table tbody tr").show();
        }
        else {
            jQuery(".data_table tbody tr").hide();
            jQuery(".data_table tbody tr").each(function () {
                console.log(jQuery(this).attr("data-status"));
                if (jQuery(this).attr("data-status") == status) {

                    jQuery(this).show();
                }
            });
        }
    });

    //filter domains

    //filter domains
    jQuery(document).on("click", ".wcap_domains_filter", function (event) {
        event.preventDefault();

        var status = jQuery(this).attr("data-status");
        console.log(status);
        if (status === "") {
            jQuery(".data_table tbody tr").show();
        }
        else {
            jQuery(".data_table tbody tr").hide();
            jQuery(".data_table tbody tr").each(function () {
                console.log(jQuery(this).attr("data-status"));
                if (jQuery(this).attr("data-status") == status) {

                    jQuery(this).show();
                }
            });
        }
    });

    //filter invoices
    jQuery(document).on("click", ".wcap_invoices_filter", function (event) {
        event.preventDefault();

        var status = jQuery(this).attr("data-status");
        console.log(status);
        if (status === "") {
            jQuery(".data_table tbody tr").show();
        }
        else {
            jQuery(".data_table tbody tr").hide();
            jQuery(".data_table tbody tr").each(function () {
                console.log(jQuery(this).attr("data-status"));
                if (jQuery(this).attr("data-status") == status) {

                    jQuery(this).show();
                }
            });
        }
    });

    //filter tickets
    jQuery(document).on("click", ".wcap_tickets_filter", function (event) {
        event.preventDefault();

        var status = jQuery(this).attr("data-status");
        if (status === "") {
            jQuery(".data_table tbody tr").show();
        }
        else {
            jQuery(".data_table tbody tr").hide();
            jQuery(".data_table tbody tr").each(function () {
                console.log(jQuery(this).attr("data-status"));
                if (jQuery(this).attr("data-status") == status) {

                    jQuery(this).show();
                }
            });
        }
    });

    jQuery(document).on("submit", "#wcap_update_password_form1", function (event) {
        event.preventDefault();

        jQuery("#success_message").hide();
        jQuery("#error_message").hide();
        var k = jQuery("#wcap_update_password_form1").serialize();
        jQuery("#new_password, #new_password_2").prop("disabled", true);
        jQuery.post(wcap_ajaxurl, k, function (data) {
            jQuery("#new_password, #new_password_2").prop("disabled", false);
            // var obj = JSON.parse(data);
            if (data === "OK") {
                jQuery("#wcap_update_password_form1").hide();
                jQuery("#error_message").hide();
                jQuery("#success_message").html("Changes Saved Successfully!").show();

                setTimeout(function () {
                    jQuery("#success_message").fadeOut();
                    var k = "?whmpca=dashboard";
                    set_new_url(k);
                    LoadData();
                }, 5000)

            }
            else {
                jQuery("#wcap_update_password_form1").show();
                jQuery("#error_message").html(data).show();
                jQuery("#success_message").hide();
            }
        });
    });

    /*
     @author Shakeel Ahmed Siddiqi <shakeel@shakeel.pk>
     Used in domain renewel page.
     */
    jQuery(document).on("submit", "#domain_renew_multiple_form", function (event) {
        event.preventDefault();

        if (jQuery("#domain_renew_multiple_form input[name*='domainrenewals[']:checked").length == 0) {
            alert("Please select 1 or more domains to renew");
            return false;
        }

        jQuery.post(wcap_ajaxurl, jQuery("#domain_renew_multiple_form").serialize(), function (data) {
            if (data == "OK") {
                set_url_parameter_value("whmpca", "cart");

                LoadData();
            }
            else {
                alert(data);
            }
        });
    });

    //Nadeem
    //Start function
    jQuery(document).on("click", "#wcap_domain_transfer_submit", function (event) {
        event.preventDefault();
        jQuery("#wcap_transfer_success").hide();
        jQuery("#wcap_transfer_unsuccess").hide();

        var oldhtml = jQuery(this).html();
        jQuery(this).html("<i class='whcom_icon_spinner-1  whcom_animate_spin'></i>");
        var i = jQuery("#wcap_transfer_domain").serialize();
        jQuery.post(wcap_ajaxurl, i, function (data) {
            if (is_json(data)) {
                data = JSON.parse(data);
                if (data.status == "unavailable") {
                    var k = "action=wcap_requests&what=transferdomain&domain=" + jQuery.trim(jQuery("#domain_name").val()) + "&auth_code=" + jQuery.trim(jQuery("#domain_epp_code").val());
                    //var k = jQuery("#wcap_transfer_domain").serialize();
                    jQuery.post(wcap_ajaxurl, k, function (data) {
                        if (data == "OK") {
                            //jQuery(".wcap_op_domain_response").html(data.domain_price_html).show();
                            jQuery("#wcap_transfer_success").show();
                            jQuery('#wcap_domain_transfer_submit').html(oldhtml);
                            set_url_parameter_value("whmpca", "confdomains");
                            setTimeout(LoadData(), 500);

                        }
                        else {
                            alert(data);
                        }

                    });
                }
                else {
                    jQuery("#wcap_transfer_unsuccess").show();
                    jQuery('#wcap_domain_transfer_submit').html(oldhtml);
                }

            }
            else {
                alert(data);
            }
        });

    });

    //End function
    //  login_test();
})(jQuery);

var t1 = performance.now();

//console.log( "Call to doSomething took " + (t1 - t0) + " milliseconds." )
function login_test() {
    setTimeout(function () {
        // Your code here
        var k = "action=wcap_requests&what=loggedin";
        jQuery.post(wcap_ajaxurl, k, function (data) {
            if (data == "RELOAD") {
                window.location.reload();
            }
            else {
                login_test();
            }
        });
    }, 5000);
}


// Order Process functionality starts from here (by Abdul Waheed)
var wcap_spinner_icon = '<i class="whcom_icon_spinner-1 whcom_animate_spin"></i>';
var wcap_spinner_block = '<div class="whcom_text_center_xs"><i class="whcom_icon_spinner-1 whcom_animate_spin"></i></div>';

(
    function ($) {

        // Main Repopulating Handler for Product and Domain Configuration pages
        $(document).on('change', '.wcap_op_main input, .wcap_op_main select', function () {
            var input = $(this);
            if (input.hasClass('wcap_op_input')) {
                wcap_op_update_product_summary();
                wcap_op_sp_update_product_summary();
            }
            if (input.hasClass('wcap_op_update_product_options')) {
                wcap_op_update_product_options();
            }
            if (input.hasClass('wcap_op_update_cart_summaries')) {
                wcap_op_update_cart_summaries();
            }
        });

        // Document Ready functions
        $(document).on('ready', function () {
            $('.wcap_op_submit_on_load').submit().removeClass('wcap_op_submit_on_load');
            wcap_op_update_cart_summaries();
            wcap_op_update_product_summary();
            wcap_op_sp_update_product_summary();
        });


        // Domain only related functions
        // Check Domain
        $(document).on('submit', '.wcap_op_check_domain', function (e) {
            e.preventDefault();
            var form = $(this);
            var submit = form.find('button[type="submit"]');
            var submit_html = submit.html();
            var response_text = $('.wcap_op_domain_action_response_text');
            var response_form = $('.wcap_op_domain_action_response_form');

            var data = $(this).serializeArray();

            submit.html(whcom_spinner_icon);
            response_text.empty().hide();
            response_form.empty().hide();

            jQuery.ajax({
                url: wcap_op_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    var res = JSON.parse(response);
                    console.log(res);
                    submit.html(submit_html);
                    response_text.html(res.message).slideDown(500);
                    if (res.status === "OK") {
                        response_form.html(res.response_form).slideDown(500);
                    }
                }
            });
        });
        // Select Domain action
        $(document).on('submit', '.wcap_op_domain_action_select', function (e) {
            e.preventDefault();
            var form = $(this);
            var submit = form.find('button[type="submit"]');
            var submit_html = submit.html();
            var response_text = $('.wcap_op_domain_action_response_text');
            var response_form = $('.wcap_op_domain_action_response_form');

            var data = $(this).serializeArray();
            submit.html(whcom_spinner_icon);

            jQuery.ajax({
                url: wcap_op_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    var res = JSON.parse(response);
                    console.log(res);
                    response_text.empty().hide();
                    response_form.empty().hide();
                    submit.html(submit_html);
                    response_text.html(res.message).slideDown(500);
                    if (res.status === "OK") {
                        $('.wcap_op_domain_search').slideUp(500).empty();
                        response_form.html(res.response_form).slideDown(500);
                    }
                }
            });
        });
        // Add Domain to local cart Form
        $(document).on('submit', '.wcap_op_add_domain_to_cart', function (e) {
            e.preventDefault();
            var $form = $(this);
            var response_field = $form.find('.wcap_op_domain_config_response_text');
            var redirect_url = $form.find('input[name="landing_page"]').val();


            var data = $(this).serializeArray();
            response_field.show();
            response_field.html(whcom_spinner_icon);
            jQuery.ajax({
                url: wcap_op_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    var res = JSON.parse(response);


                    console.log(res);
                    response_field.text(res.message);
                    if (res.status === "OK") {
                        window.location.href = redirect_url;
                    }
                    response_field.removeClass('alert-info');
                }
            });
        });


        // Product related functions
        // Select Product Domain Option
        $(document).on('change', 'input[name="wcap_op_product_domain_option_selector"]', function () {
            $('.whcom_product_domain_option_form').hide();
            $('#' + $(this).val()).show();
        });
        // Check Product Domain
        $(document).on('submit', '.wcap_op_check_product_domain', function (e) {
            e.preventDefault();
            var form = $(this);
            var response_container = $('.wcap_op_domain_response');
            var submit = form.find('button[type="submit"]');
            var submit_val = submit.html();

            var data = $(this).serializeArray();

            if (form.hasClass('domain_already_in_cart')) {
                var tld = form.find('select[name="domain"] :selected').data('domain-tld');
                var domain_type = form.find('select[name="domain"] :selected').data('domain-type');
                var cart_index = form.find('select[name="domain"] :selected').data('cart-index');
                data.push({'name': 'ext', 'value': tld});
                data.push({'name': 'cart_index', 'value': cart_index});
                data.push({'name': 'type', 'value': domain_type});
            }
            console.log(data);
            submit.html(whcom_spinner_icon);
            response_container.html(whcom_spinner_block);
            jQuery.ajax({
                url: wcap_op_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    var res = JSON.parse(response);
                    submit.html(submit_val);
                    console.log(res);
                    if (res.status === "OK") {
                        response_container.html(res.domain_attachment_form);
                        if (res.type === 'existing') {
                            $('.wcap_op_attach_product_domain').submit();
                        }
                        if (form.hasClass('domain_already_in_cart')) {
                            $('.wcap_op_attach_product_domain').submit();
                        }
                    }
                    else {
                        response_container.html(res.message);
                    }
                }
            });
        });
        // Attach Product Domain
        $(document).on('submit', '.wcap_op_attach_product_domain', function (e) {
            e.preventDefault();
            var form = $(this);
            var product_container = $('.wcap_op_product_container');
            var product_domain_container = $('.wcap_op_domain_container');
            var domain_options_container = $('.wcap_op_product_domain_config_container');
            var domain_free_tlds_info = $('.wcap_op_free_tlds');
            var submit = form.find('button[type="submit"]');
            var submit_val = submit.html();

            var data = $(this).serializeArray();
            console.log(data);
            submit.html(whcom_spinner_icon);
            domain_options_container.slideUp(300).html('');
            domain_free_tlds_info.hide();
            jQuery.ajax({
                url: wcap_op_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    var res = JSON.parse(response);
                    submit.html(submit_val);
                    console.log(res);
                    if (res.status === "OK") {
                        domain_options_container.html(res.domain_config_form).show();
                        product_container.slideDown(500);
                        domain_free_tlds_info.show();
                        product_domain_container.html(res.message).fadeOut(2000);
                        wcap_op_update_product_summary();
                    }
                    else {
                        form.html(res.message);
                        window.location.reload();
                    }
                }
            });
        });
        // Add Product to local cart Form
        $(document).on('submit', '.wcap_op_add_product', function (e) {
            e.preventDefault();
            var $form = $(this);
            var response_field = $form.find('.wcap_op_response');
            var submit_field = $form.find('.wcap_op_product_submit');
            var redirect_url = $form.find('input[name="landing_page"]').val();


            var data = $(this).serializeArray();
            response_field.show();
            response_field.html(whcom_spinner_icon);
            jQuery.ajax({
                url: wcap_op_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    var res = JSON.parse(response);
                    console.log(res);
                    response_field.text(res.message);
                    if (res.status === "OK") {
                        submit_field.find('button').text('Redirecting...');
                        if (redirect_url !== undefined) {
                            window.location.href = redirect_url;
                        }
                    }
                    else {

                    }
                    response_field.removeClass('alert-info');
                }
            });
        });


        // Client related functions
        // Login Form
        $(document).on('click', '.wcap_op_sp_nav > ul > li', function (e) {
            $(this).addClass('active').siblings('li').removeClass('active');
        });
        $(window).on('scroll', function () {
            var scrollPos = $(document).scrollTop();
            $('.wcap_op_sp_nav a.whcom_smooth_scroll').each(function () {
                var currLink = $(this);
                var refElement = $(currLink.attr("href"));
                var topGap = $('.wcap_op_sp_nav').data('scroll-top-gap') || 20;
                var elemPositionTop = refElement.position().top;
                var elemPositionBottom = refElement.position().top + parseInt(refElement.outerHeight(true)) - topGap;

                if (elemPositionTop <= scrollPos && elemPositionBottom > scrollPos) {
                    currLink.closest('li').trigger("click");
                }
            });
        });
        $(document).on('submit', '.wcap_op_login_form', function (e) {
            e.preventDefault();
            var $form = $(this);
            var response_field = $form.find('.wcap_op_response');


            var data = $(this).serializeArray();
            response_field.show();
            response_field.html(whcom_spinner_icon);
            response_field.addClass('alert-info');
            jQuery.ajax({
                url: wcap_op_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    console.log(response);
                    var res = JSON.parse(response);
                    console.log(res);
                    response_field.text(res.message);
                    response_field.removeClass('alert-info');
                    if (res.status === 'OK') {
                        $('.whcom_login_register_response_container').submit();
                    }
                }
            });
        });
        // Logout Form
        $(document).on('submit', '.wcap_op_logout_form', function (e) {
            e.preventDefault();
            var data = $(this).serializeArray();
            jQuery.ajax({
                url: wcap_op_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    var res = JSON.parse(response);

                    if (res.status === 'OK') {
                        window.location.reload();
                    }
                }
            });
        });
        // Registration Form
        $(document).on('submit', '.wcap_op_registration_form', function (e) {
            e.preventDefault();
            var $form = $(this);
            var response_field = $form.find('.wcap_op_response');


            var data = $(this).serializeArray();
            response_field.html(whcom_spinner_icon).show().removeClass('whcom_alert whcom_alert_success whcom_alert_danger');

            jQuery.ajax({
                url: wcap_op_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    var res = JSON.parse(response);

                    console.log(res);
                    response_field.html(res.message);
                    if (res.status === "OK") {
                        $('.whcom_login_register_response_container').submit();
                        response_field.addClass('whcom_alert whcom_alert_success');
                    }
                    else {
                        response_field.addClass('whcom_alert whcom_alert_danger');
                    }
                }
            });
        });

        // Cart related functions
        // Delete cart item
        $(document).on('click', '.wcap_op_delete_cart_item', function (e) {
            e.preventDefault();

            var confirm_delete = confirm('Are you sure you want to remove this item from cart?');

            if (!confirm_delete) {
                console.log('not deleting');
                return;
            }
            console.log('deleting');

            var button = $(this);


            var data = {};
            data.action = "wcap_op_delete_cart_item";
            data.cart_index = button.data('cart-index');

            button.html(whcom_spinner_icon);

            jQuery.ajax({
                url: wcap_op_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    var res = JSON.parse(response);
                    console.log(res);
                    if (res.status === "OK") {
                        wcap_op_update_cart_summaries();
                    }
                    else {
                        alert(res.message);
                        //window.location.reload();
                    }
                }
            });
        });
        // Empty Cart
        $(document).on('submit', '.wcap_op_reset_cart_form', function (e) {
            e.preventDefault();
            var $form = $(this);
            var response_field = $form.find('.wcap_op_response');
            var confirm_string = $form.find('input[name="confirm_string"]').val();
            var confirm = window.confirm(confirm_string);
            if (confirm === true) {
                var data = $(this).serializeArray();
                response_field.show();
                response_field.html(whcom_spinner_icon);
                response_field.addClass('alert-info');
                jQuery.ajax({
                    url: wcap_op_ajax.ajax_url,
                    type: 'post',
                    data: data,
                    success: function (response) {
                        var res = JSON.parse(response);


                        console.log(res);
                        response_field.text(res.message);
                        if (res.status === "OK") {
                            window.location.reload();
                        }
                    }
                });
            }
        });
        // Submit Order
        $(document).on('submit', '.wcap_op_submit_order', function (e) {
            e.preventDefault();
            var form = $(this);
            var response_text = form.find('.wcap_op_response');
            var response_form = $('.whcom_checkout_form');
            var submit_container = form.find('.wcap_op_submit_container');
            var submit = submit_container.find('button');
            var submit_val = submit.html();


            var data = $(this).serializeArray();
            submit.html(whcom_spinner_icon);
            jQuery.ajax({
                url: wcap_op_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    var res = JSON.parse(response);
                    console.log(res);
                    submit.html(submit_val);
                    response_text.show();
                    if (res.status === "OK") {
                        if (res.show_cc === 'yes') {
                            response_form.html(res.response_form);
                        }
                        else {
                            $('.whcom_page_heading').empty().removeClass('whcom_page_heading').addClass('whcom_margin_bottom_45');
                            response_form.html(res.redirect_link).addClass('whcom_text_center whcom_form_field').append(res.invoice_link);
                            $('.wcap_op_view_invoice_button').trigger('click');
                        }
                    }
                    else {
                        response_text.text(res.message);
                    }
                }
            });
        });
        // Capture Payment
        $(document).on('submit', '.wcap_op_capture_invoice_payment', function (e) {
            e.preventDefault();
            var form = $(this);
            var submit = form.find('button[type="submit"]');
            var submit_val = submit.html();
            var response_text = form.find('.wcap_op_response');
            var response_form = $('.whcom_checkout_form');
            var data = $(this).serializeArray();
            submit.html(whcom_spinner_icon);
            jQuery.ajax({
                url: wcap_op_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    var res = JSON.parse(response);
                    console.log(res);
                    submit.html(submit_val);
                    if (res.status === "OK") {
                        response_form.html(res.response_html);
                    }
                    else {
                        response_text.html(res.message);
                    }
                }
            });
        });
        // Apply Promo Code
        $(document).on('submit', '.wcap_op_apply_promo_code_form', function (e) {
            e.preventDefault();
            var $form = $(this);
            var response_field = $('.wcap_op_promo_response');
            response_field.slideUp().removeClass().addClass('wcap_op_promo_response whcom_alert');
            var data = $(this).serializeArray();
            jQuery.ajax({
                url: wcap_op_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    var res = JSON.parse(response);
                    console.log(res);
                    response_field.text(res.message).slideDown();
                    if (res.status === "OK") {
                        response_field.addClass('whcom_alert_success');
                        window.location.reload();
                    }
                    else {
                        response_field.addClass('whcom_alert_info');
                    }
                }
            });
        });
        // Remove Promo Code
        $(document).on('submit', '.wcap_op_remove_promo_code_form', function (e) {
            e.preventDefault();
            var $form = $(this);
            var response_field = $('.wcap_op_promo_response');
            response_field.slideUp().removeClass().addClass('wcap_op_promo_response whcom_alert');
            var data = $(this).serializeArray();
            jQuery.ajax({
                url: wcap_op_ajax.ajax_url,
                type: 'post',
                data: data,
                success: function (response) {
                    var res = JSON.parse(response);
                    console.log(res);
                    response_field.text(res.message).slideDown();
                    if (res.status === "OK") {
                        response_field.addClass('whcom_alert_success');
                        window.location.reload();
                    }
                    else {
                        response_field.addClass('whcom_alert_info');
                    }
                }
            });
        });


        window.wcap_op_update_cart_summaries = function () {
            var side_summaries = [];
            var short_summaries = [];
            var buttons_summaries = [];
            var detailed_summaries = [];
            $('.wcap_op_universal_cart_summary_side').each(function () {
                $(this).html(whcom_spinner_block);
                side_summaries.push($(this));
            });
            $('.wcap_op_universal_cart_summary_short').each(function () {
                $(this).html(whcom_spinner_block);
                short_summaries.push($(this));
            });
            $('.wcap_op_universal_cart_summary_button').each(function () {
                $(this).html(whcom_spinner_block);
                buttons_summaries.push($(this));
            });
            $('.wcap_op_universal_cart_summary_detailed').each(function () {
                $(this).html(whcom_spinner_block);
                detailed_summaries.push($(this));
            });
            if ((
                    buttons_summaries.length + short_summaries.length + detailed_summaries.length
                ) > 0) {
                console.log('Calculating Summaries');
                var data = {};
                data.action = "wcap_op_generate_cart_summaries";
                data.cart_index = $('input[name="cart_index"]').val();
                data.product_id = $('input[name="pid"]').val();
                data.billingcycle = $('[name="billingcycle"]').val();
                $.ajax({
                    url: wcap_op_ajax.ajax_url,
                    type: 'post',
                    data: data,
                    success: function (response) {
                        var res = JSON.parse(response);
                        console.log(res);
                        if (res.status === "OK") {
                            if (side_summaries.length) {
                                $(side_summaries).each(function () {
                                    $(this).html(res.side);
                                });
                            }
                            if (short_summaries.length) {
                                $(short_summaries).each(function () {
                                    $(this).html(res.short)
                                });
                            }
                            if (buttons_summaries.length) {
                                $(buttons_summaries).each(function () {
                                    $(this).html(res.button)
                                });
                            }
                            if (detailed_summaries.length) {
                                $(detailed_summaries).each(function () {
                                    $(this).html(res.detailed)
                                });
                            }
                            if (res.total_items > 0) {
                                $('.whcom_universal_checkout_button').prop('disabled', false);
                            }
                            else {
                                $('.whcom_universal_checkout_button').prop('disabled', true);
                            }
                            $('.whcom_summary_sidebar').whcom_sticky({
                                'parent': '.whcom_main',
                                'offset_top': 80,
                                'recalc_every': 1
                            });
                        }
                        else {
                        }
                    }
                });
            }
        };

        window.wcap_op_update_product_options = function () {
            var options_container = $('.wcap_op_product_options_container');
            if (options_container[0]) {
                var data = {};
                data.action = "wcap_op_get_product_config_options";
                data.cart_index = $('input[name="cart_index"]').val();
                data.product_id = $('input[name="pid"]').val();
                data.billingcycle = $('[name="billingcycle"]').val();
                options_container.html(whcom_spinner_block);
                $.ajax({
                    url: wcap_op_ajax.ajax_url,
                    type: 'post',
                    data: data,
                    success: function (response) {
                        var res = JSON.parse(response);
                        console.log(res);
                        if (res.status === "OK") {
                            options_container.html(res.options_html);
                        }
                        else {
                        }
                    }
                });
            }
        };

        window.wcap_op_update_product_summary = function () {
            var prd_form = $('form.wcap_op_add_product');
            if (prd_form[0]) {
                var prd_summary = $('.wcap_op_summary_sidebar');
                var prd_summary_spinner = $('.wcap_op_product_summary .whcom_icon_spinner-1');
                var prd_submit = $('.wcap_op_product_submit button');
                prd_submit.prop('disabled', true);
                prd_summary_spinner.show();
                if (prd_form) {
                    var data = prd_form.serializeArray();
                    data.push({'name': 'action', 'value': 'wcap_op_generate_current_product_summery'});
                    $.ajax({
                        url: wcap_op_ajax.ajax_url,
                        type: 'post',
                        data: data,
                        success: function (response) {
                            var res = JSON.parse(response);
                            console.log(res);
                            if (res.status === "OK") {
                                prd_submit.prop('disabled', false);
                                prd_summary_spinner.fadeOut(500);
                                prd_summary.html(res.summary_html.side);
                            }
                            else {
                                prd_summary.html(res.message);
                            }
                        }
                    });
                }
            }
        };

        window.wcap_op_sp_update_product_summary = function () {
            var prd_form = $('form.wcap_op_sp_add_product');
            if (prd_form[0]) {
                var prd_summary = $('.wcap_op_sp_order_summary');
                var prd_summary_spinner = $('.wcap_op_sp_product_summary_spinner');
                var prd_submit = $('.wcap_op_sp_product_submit');
                prd_submit.hide();
                prd_summary_spinner.show();
                if (prd_form) {
                    var data = prd_form.serializeArray();
                    data.push({'name': 'action', 'value': 'wcap_op_sp_process'});
                    data.push({'name': 'wcap_op_sp_what', 'value': 'wcap_op_sp_generate_summary'});
                    $.ajax({
                        url: wcap_op_ajax.ajax_url,
                        type: 'post',
                        data: data,
                        success: function (response) {
                            var res = JSON.parse(response);
                            console.log(res);
                            if (res.status === "OK") {
                                prd_submit.show();
                                prd_summary_spinner.fadeOut(500);
                                prd_summary.html(res.summary_html.side);
                                if (res.summary_html.free_domain) {
                                    console.log('Free Domain');
                                    $('[name="regperiod"]').prop('disabled', true).find('option').each(function () {
                                        $(this).prop('selected', true);
                                        return false;
                                    });
                                }
                                else {
                                    $('[name="regperiod"]').prop('disabled', false);
                                }
                                if (res.summary_html.no_options) {
                                    $('.wcap_op_sp_product_no_options').show();
                                }
                                else {
                                    $('.wcap_op_sp_product_no_options').hide();
                                }
                            }
                            else {
                                prd_summary.html(res.message);
                            }
                        }
                    });
                }
            }
        };

    }(jQuery)
);

