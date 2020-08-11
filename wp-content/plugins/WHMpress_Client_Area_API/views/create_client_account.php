<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar("create_client_account", FALSE);


//show front menu where applicable
if (wcap_show_front_menu()) {
    include_once $this->Path . "/views/top_links_front.php";
}
?>
<script>
    /**
     * Below JS codes came from WHMCS for processing of registration form....
     */
    function changeState() {
        var a = "",
            b = jQuery("input[name=state]").data("selectinlinedropdown");
        a = getStateSelectClass(b), a.length < 1 && (b = jQuery("#stateinput").data("selectinlinedropdown"), a = getStateSelectClass(b));
        var c = jQuery("#stateinput").val(),
            d = jQuery("select[name=country]").val(),
            e = jQuery("#stateinput").attr("tabindex"),
            f = jQuery("#stateinput").attr("disabled"),
            g = jQuery("#stateinput").attr("readonly");
        if (void 0 === e && (e = ""), void 0 === f && (f = ""), void 0 === g && (g = ""), states[d]) {
            jQuery("#stateinput").hide().removeAttr("name").removeAttr("required"), jQuery("#inputStateIcon").hide(), jQuery("#stateselect").remove();
            var h = "";
            for (key in states[d]) {
                if (stateval = states[d][key], "end" == stateval) {
                    break;
                }
                h += "<option", stateval == c && (h += ' selected="selected"'), h += ">" + stateval + "</option>"
            }
            "" != e && (e = ' tabindex="' + e + '"'), (f || g) && (f = " disabled"), jQuery("#stateinput").parent().append('<select name="state" class="' + jQuery("#stateinput").attr("class") + a + '" id="stateselect"' + e + f + '><option value="">&mdash;</option>' + h + "</select>");
            var i = !0;
            "boolean" == typeof stateNotRequired && stateNotRequired && (i = !1), jQuery("#stateselect").attr("required", i)
        }
        else {
            var i = !0;
            "boolean" == typeof stateNotRequired && stateNotRequired && (i = !1), jQuery("#stateselect").remove(), jQuery("#stateinput").show().attr("name", "state").attr("required", i), jQuery("#inputStateIcon").show()
        }
    }

    function getStateSelectClass(a) {
        var b = "";
        return a && (b = " select-inline"), b
    }

    function validatePassword2() {
        var a = jQuery("#inputNewPassword1").val(),
            b = jQuery("#inputNewPassword2").val(),
            c = jQuery("#newPassword2");
        b && a !== b ? (c.removeClass("has-success").addClass("has-error"), jQuery("#inputNewPassword2").next(".wcap_form_control-feedback").removeClass("glyphicon-ok").addClass("glyphicon-remove"), jQuery("#inputNewPassword2Msg").html('<p class="help-block">The passwords entered do not match</p>'), jQuery('input[type="submit"]').attr("disabled", "disabled")) : (b ? (c.removeClass("has-error").addClass("has-success"), jQuery("#inputNewPassword2").next(".wcap_form_control-feedback").removeClass("glyphicon-remove").addClass("glyphicon-ok"), jQuery('.main-content input[type="submit"]').removeAttr("disabled")) : (c.removeClass("has-error has-success"), jQuery("#inputNewPassword2").next(".wcap_form_control-feedback").removeClass("glyphicon-remove glyphicon-ok")), jQuery("#inputNewPassword2Msg").html(""));
    }

    var states = {
        AU: [
            "Australian Capital Territory",
            "New South Wales",
            "Northern Territory",
            "Queensland",
            "South Australia",
            "Tasmania",
            "Victoria",
            "Western Australia",
            "end"
        ],
        BR: [
            "AC",
            "AL",
            "AP",
            "AM",
            "BA",
            "CE",
            "DF",
            "ES",
            "GO",
            "MA",
            "MT",
            "MS",
            "MG",
            "PA",
            "PB",
            "PR",
            "PE",
            "PI",
            "RJ",
            "RN",
            "RS",
            "RO",
            "RR",
            "SC",
            "SP",
            "SE",
            "TO",
            "end"
        ],
        CA: [
            "Alberta",
            "British Columbia",
            "Manitoba",
            "New Brunswick",
            "Newfoundland",
            "Northwest Territories",
            "Nova Scotia",
            "Nunavut",
            "Ontario",
            "Prince Edward Island",
            "Quebec",
            "Saskatchewan",
            "Yukon Territory",
            "end"
        ],
        FR: [
            "Ain",
            "Aisne",
            "Allier",
            "Alpes-de-Haute-Provence",
            "Hautes-Alpes",
            "Alpes-Maritimes",
            "ArdÃ¨che",
            "Ardennes",
            "AriÃ¨ge",
            "Aube",
            "Aude",
            "Aveyron",
            "Bouches-du-RhÃ´ne",
            "Calvados",
            "Cantal",
            "Charente",
            "Charente-Maritime",
            "Cher",
            "CorrÃ¨ze",
            "Corse-du-Sud",
            "Haute-Corse",
            "CÃ´te-d'Or",
            "CÃ´tes-d'Armor",
            "Creuse",
            "Dordogne",
            "Doubs",
            "DrÃ´me",
            "Eure",
            "Eure-et-Loir",
            "FinistÃ¨re",
            "Gard",
            "Haute-Garonne",
            "Gers",
            "Gironde",
            "HÃ©rault",
            "Ille-et-Vilaine",
            "Indre",
            "Indre-et-Loire",
            "IsÃ¨re",
            "Jura",
            "Landes",
            "Loir-et-Cher",
            "Loire",
            "Haute-Loire",
            "Loire-Atlantique",
            "Loiret",
            "Lot",
            "Lot-et-Garonne",
            "LozÃ¨re",
            "Maine-et-Loire",
            "Manche",
            "Marne",
            "Haute-Marne",
            "Mayenne",
            "Meurthe-et-Moselle",
            "Meuse",
            "Morbihan",
            "Moselle",
            "NiÃ¨vre",
            "Nord",
            "Oise",
            "Orne",
            "Pas-de-Calais",
            "Puy-de-DÃ´me",
            "PyrÃ©nÃ©es-Atlantiques",
            "Hautes-PyrÃ©nÃ©es",
            "PyrÃ©nÃ©es-Orientales",
            "Bas-Rhin",
            "Haut-Rhin",
            "RhÃ´ne",
            "Haute-SaÃ´ne",
            "SaÃ´ne-et-Loire",
            "Sarthe",
            "Savoie",
            "Haute-Savoie",
            "Paris",
            "Seine-Maritime",
            "Seine-et-Marne",
            "Yvelines",
            "Deux-SÃ¨vres",
            "Somme",
            "Tarn",
            "Tarn-et-Garonne",
            "Var",
            "Vaucluse",
            "VendÃ©e",
            "Vienne",
            "Haute-Vienne",
            "Vosges",
            "Yonne",
            "Territoire de Belfort",
            "Essonne",
            "Hauts-de-Seine",
            "Seine-Saint-Denis",
            "Val-de-Marne",
            "Val-d'Oise",
            "Guadeloupe",
            "Martinique",
            "Guyane",
            "La RÃ©union",
            "Mayotte",
            "end"
        ],
        DE: [
            "Baden-Wuerttemberg",
            "Bayern",
            "Berlin",
            "Brandenburg",
            "Bremen",
            "Hamburg",
            "Hessen",
            "Mecklenburg-Vorpommern",
            "Niedersachsen",
            "Nordrhein-Westfalen",
            "Rheinland-Pfalz",
            "Saarland",
            "Sachsen",
            "Sachsen-Anhalt",
            "Schleswig-Holstein",
            "Thueringen",
            "end"
        ],
        ES: [
            "ARABA",
            "ALBACETE",
            "ALICANTE",
            "ALMERIA",
            "AVILA",
            "BADAJOZ",
            "ILLES BALEARS",
            "BARCELONA",
            "BURGOS",
            "CACERES",
            "CADIZ",
            "CASTELLON",
            "CIUDAD REAL",
            "CORDOBA",
            "CORUÃ‘A, A",
            "CUENCA",
            "GIRONA",
            "GRANADA",
            "GUADALAJARA",
            "GIPUZKOA",
            "HUELVA",
            "HUESCA",
            "JAEN",
            "LEON",
            "LLEIDA",
            "RIOJA, LA",
            "LUGO",
            "MADRID",
            "MALAGA",
            "MURCIA",
            "NAVARRA",
            "OURENSE",
            "ASTURIAS",
            "PALENCIA",
            "PALMAS, LAS",
            "PONTEVEDRA",
            "SALAMANCA",
            "SANTA CRUZ DE TENERIFE",
            "CANTABRIA",
            "SEGOVIA",
            "SEVILLA",
            "SORIA",
            "TARRAGONA",
            "TERUEL",
            "TOLEDO",
            "VALENCIA",
            "VALLADOLID",
            "BIZKAIA",
            "ZAMORA",
            "ZARAGOZA",
            "CEUTA",
            "MELILLA",
            "end"
        ],
        IN: [
            "Andaman and Nicobar Islands",
            "Andhra Pradesh",
            "Arunachal Pradesh",
            "Assam",
            "Bihar",
            "Chandigarh",
            "Chattisgarh",
            "Dadra and Nagar Haveli",
            "Daman and Diu",
            "Delhi",
            "Goa",
            "Gujarat",
            "Haryana",
            "Himachal Pradesh",
            "Jammu and Kashmir",
            "Jharkhand",
            "Karnataka",
            "Kerala",
            "Lakshadweep",
            "Madhya Pradesh",
            "Maharashtra",
            "Manipur",
            "Meghalaya",
            "Mizoram",
            "Nagaland",
            "Orissa",
            "Puducherry",
            "Punjab",
            "Rajasthan",
            "Sikkim",
            "Tamil Nadu",
            "Telangana",
            "Tripura",
            "Uttaranchal",
            "Uttar Pradesh",
            "West Bengal",
            "end"
        ],
        IT: [
            "AG",
            "AL",
            "AN",
            "AO",
            "AR",
            "AP",
            "AQ",
            "AT",
            "AV",
            "BA",
            "BT",
            "BL",
            "BN",
            "BG",
            "BI",
            "BO",
            "BZ",
            "BS",
            "BR",
            "CA",
            "CL",
            "CB",
            "CI",
            "CE",
            "CT",
            "CZ",
            "CH",
            "CO",
            "CS",
            "CR",
            "KR",
            "CN",
            "EN",
            "FM",
            "FE",
            "FI",
            "FG",
            "FC",
            "FR",
            "GE",
            "GO",
            "GR",
            "IM",
            "IS",
            "SP",
            "LT",
            "LE",
            "LC",
            "LI",
            "LO",
            "LU",
            "MB",
            "MC",
            "MN",
            "MS",
            "MT",
            "ME",
            "MI",
            "MO",
            "NA",
            "NO",
            "NU",
            "OT",
            "OR",
            "PD",
            "PA",
            "PR",
            "PV",
            "PG",
            "PU",
            "PE",
            "PC",
            "PI",
            "PT",
            "PN",
            "PZ",
            "PO",
            "RG",
            "RA",
            "RC",
            "RE",
            "RI",
            "RN",
            "RM",
            "RO",
            "SA",
            "VS",
            "SS",
            "SV",
            "SI",
            "SR",
            "SO",
            "TA",
            "TE",
            "TR",
            "TO",
            "OG",
            "TP",
            "TN",
            "TV",
            "TS",
            "UD",
            "VA",
            "VE",
            "VB",
            "VC",
            "VR",
            "VS",
            "VV",
            "VI",
            "VT",
            "end"
        ],
        NL: [
            "Drenthe",
            "Flevoland",
            "Friesland",
            "Gelderland",
            "Groningen",
            "Limburg",
            "Noord-Brabant",
            "Noord-Holland",
            "Overijssel",
            "Utrecht",
            "Zeeland",
            "Zuid-Holland",
            "end"
        ],
        NZ: [
            "Northland",
            "Auckland",
            "Waikato",
            "Bay of Plenty",
            "Gisborne",
            "Hawkes Bay",
            "Taranaki",
            "Manawatu-Wanganui",
            "Wellington",
            "Tasman",
            "Nelson",
            "Marlborough",
            "West Coast",
            "Canterbury",
            "Otago",
            "Southland",
            "end"
        ],
        GB: [
            "Avon",
            "Aberdeenshire",
            "Angus",
            "Argyll and Bute",
            "Barking and Dagenham",
            "Barnet",
            "Barnsley",
            "Bath and North East Somerset",
            "Bedfordshire",
            "Berkshire",
            "Bexley",
            "Birmingham",
            "Blackburn with Darwen",
            "Blackpool",
            "Blaenau Gwent",
            "Bolton",
            "Bournemouth",
            "Bracknell Forest",
            "Bradford",
            "Brent",
            "Bridgend",
            "Brighton and Hove",
            "Bromley",
            "Buckinghamshire",
            "Bury",
            "Caerphilly",
            "Calderdale",
            "Cambridgeshire",
            "Camden",
            "Cardiff",
            "Carmarthenshire",
            "Ceredigion",
            "Cheshire",
            "Cleveland",
            "City of Bristol",
            "City of Edinburgh",
            "City of Kingston upon Hull",
            "City of London",
            "Clackmannanshire",
            "Conwy",
            "Cornwall",
            "Coventry",
            "Croydon",
            "Cumbria",
            "Darlington",
            "Denbighshire",
            "Derby",
            "Derbyshire",
            "Devon",
            "Doncaster",
            "Dorset",
            "Dudley",
            "Dumfries and Galloway",
            "Dundee City",
            "Durham",
            "Ealing",
            "East Ayrshire",
            "East Dunbartonshire",
            "East Lothian",
            "East Renfrewshire",
            "East Riding of Yorkshire",
            "East Sussex",
            "Eilean Siar (Western Isles)",
            "Enfield",
            "Essex",
            "Falkirk",
            "Fife",
            "Flintshire",
            "Gateshead",
            "Glasgow City",
            "Gloucestershire",
            "Greenwich",
            "Gwynedd",
            "Hackney",
            "Halton",
            "Hammersmith and Fulham",
            "Hampshire",
            "Haringey",
            "Harrow",
            "Hartlepool",
            "Havering",
            "Herefordshire",
            "Hertfordshire",
            "Highland",
            "Hillingdon",
            "Hounslow",
            "Inverclyde",
            "Isle of Anglesey",
            "Isle of Wight",
            "Islington",
            "Kensington and Chelsea",
            "Kent",
            "Kingston upon Thames",
            "Kirklees",
            "Knowsley",
            "Lambeth",
            "Lancashire",
            "Leeds",
            "Leicester",
            "Leicestershire",
            "Lewisham",
            "Lincolnshire",
            "Liverpool",
            "London",
            "Luton",
            "Manchester",
            "Medway",
            "Merthyr Tydfil",
            "Merton",
            "Merseyside",
            "Middlesbrough",
            "Middlesex",
            "Midlothian",
            "Milton Keynes",
            "Monmouthshire",
            "Moray",
            "Neath Port Talbot",
            "Newcastle upon Tyne",
            "Newham",
            "Newport",
            "Norfolk",
            "North Ayrshire",
            "North East Lincolnshire",
            "North Lanarkshire",
            "North Lincolnshire",
            "North Somerset",
            "North Tyneside",
            "North Yorkshire",
            "Northamptonshire",
            "Northumberland",
            "North Humberside",
            "Nottingham",
            "Nottinghamshire",
            "Oldham",
            "Orkney Islands",
            "Oxfordshire",
            "Pembrokeshire",
            "Perth and Kinross",
            "Peterborough",
            "Plymouth",
            "Poole",
            "Portsmouth",
            "Powys",
            "Reading",
            "Redbridge",
            "Renfrewshire",
            "Rhondda Cynon Taff",
            "Richmond upon Thames",
            "Rochdale",
            "Rotherham",
            "Rutland",
            "Salford",
            "Sandwell",
            "Sefton",
            "Sheffield",
            "Shetland Islands",
            "Shropshire",
            "Slough",
            "Solihull",
            "Somerset",
            "South Ayrshire",
            "South Humberside",
            "South Gloucestershire",
            "South Lanarkshire",
            "South Tyneside",
            "Southampton",
            "Southend-on-Sea",
            "Southwark",
            "South Yorkshire",
            "St. Helens",
            "Staffordshire",
            "Stirling",
            "Stockport",
            "Stockton-on-Tees",
            "Stoke-on-Trent",
            "Suffolk",
            "Sunderland",
            "Surrey",
            "Sutton",
            "Swansea",
            "Swindon",
            "Tameside",
            "Telford and Wrekin",
            "The Scottish Borders",
            "The Vale of Glamorgan",
            "Thurrock",
            "Torbay",
            "Torfaen",
            "Tower Hamlets",
            "Trafford",
            "Tyne and Wear",
            "Wakefield",
            "Walsall",
            "Waltham Forest",
            "Wandsworth",
            "Warrington",
            "Warwickshire",
            "West Midlands",
            "West Dunbartonshire",
            "West Lothian",
            "West Sussex",
            "West Yorkshire",
            "Westminster",
            "Wigan",
            "Wiltshire",
            "Windsor and Maidenhead",
            "Wirral",
            "Wokingham",
            "Wolverhampton",
            "Worcestershire",
            "Wrexham",
            "York",
            "Co. Antrim",
            "Co. Armagh",
            "Co. Down",
            "Co. Fermanagh",
            "Co. Londonderry",
            "Co. Tyrone",
            "end"
        ],
        US: [
            "Alabama",
            "Alaska",
            "Arizona",
            "Arkansas",
            "California",
            "Colorado",
            "Connecticut",
            "Delaware",
            "District of Columbia",
            "Florida",
            "Georgia",
            "Hawaii",
            "Idaho",
            "Illinois",
            "Indiana",
            "Iowa",
            "Kansas",
            "Kentucky",
            "Louisiana",
            "Maine",
            "Maryland",
            "Massachusetts",
            "Michigan",
            "Minnesota",
            "Mississippi",
            "Missouri",
            "Montana",
            "Nebraska",
            "Nevada",
            "New Hampshire",
            "New Jersey",
            "New Mexico",
            "New York",
            "North Carolina",
            "North Dakota",
            "Ohio",
            "Oklahoma",
            "Oregon",
            "Pennsylvania",
            "Rhode Island",
            "South Carolina",
            "South Dakota",
            "Tennessee",
            "Texas",
            "Utah",
            "Vermont",
            "Virginia",
            "Washington",
            "West Virginia",
            "Wisconsin",
            "Wyoming",
            "end"
        ]
    };
    jQuery(document).ready(function () {
        jQuery("input[name=state]").attr("id", "stateinput"), jQuery("select[name=country]").change(function () {
            changeState()
        }), changeState()
    }),
        jQuery("#inputNewPassword1").keyup(function () {
            var a = 50,
                b = 75,
                c = jQuery("#newPassword1"),
                d = jQuery("#inputNewPassword1").val(),
                e = d.length;
            e > 5 && (e = 5);
            var f = d.replace(/[0-9]/g, ""),
                g = d.length - f.length;
            g > 3 && (g = 3);
            var h = d.replace(/\W/g, ""),
                i = d.length - h.length;
            i > 3 && (i = 3);
            var j = d.replace(/[A-Z]/g, ""),
                k = d.length - j.length;
            k > 3 && (k = 3);
            var l = 10 * e - 20 + 10 * g + 15 * i + 10 * k;
            l < 0 && (l = 0), l > 100 && (l = 100), c.removeClass("has-error has-warning has-success"), jQuery("#inputNewPassword1").next(".wcap_form_control-feedback").removeClass("glyphicon-remove glyphicon-warning-sign glyphicon-ok"), jQuery("#passwordStrengthBar .progress-bar").removeClass("progress-bar-danger progress-bar-warning progress-bar-success").css("width", l + "%").attr("aria-valuenow", l), jQuery("#passwordStrengthBar .progress-bar .sr-only").html("New Password Rating: " + l + "%"), l < a ? (c.addClass("has-error"), jQuery("#inputNewPassword1").next(".wcap_form_control-feedback").addClass("glyphicon-remove"), jQuery("#passwordStrengthBar .progress-bar").addClass("progress-bar-danger")) : l < b ? (c.addClass("has-warning"), jQuery("#inputNewPassword1").next(".wcap_form_control-feedback").addClass("glyphicon-warning-sign"), jQuery("#passwordStrengthBar .progress-bar").addClass("progress-bar-warning")) : (c.addClass("has-success"), jQuery("#inputNewPassword1").next(".wcap_form_control-feedback").addClass("glyphicon-ok"), jQuery("#passwordStrengthBar .progress-bar").addClass("progress-bar-success")), validatePassword2()
        }),
        jQuery(document).ready(function () {
            jQuery('.using-password-strength input[type="submit"]').attr("disabled", "disabled"), jQuery("#inputNewPassword2").keyup(function () {
                validatePassword2()
            })
        });

    changeState();
</script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<?php

//    $url = 'https://www.google.com/recaptcha/api/siteverify';
//    $secretkey = "6LcE13kUAAAAAPNjxpCat1rJZrd4Hdt-j5QMSupU";
//
//    $response = file_get_contents($url . "?secret=" . $secretkey . "&response=" . $_POST['g-recaptcha-response'] . "&remoteip" . $_SERVER['REMOTE_ADDR']);
//    $data = json_decode($response);
//
//    if (isset($data->success) AND $data->success == true) {
//        //code
//    } else {
//        $captchaerror = "The reCAPTCHA wasn't entered correctly. Try it again." . "(reCAPTCHA said: " . $resp->error . ")";
//    }


?>

<div class="wcap_create_client_account wcap_view_container">
    <div class="whcom_row">
        <?php if ($show_sidebar) { ?>
            <div class="whcom_col_sm_3">
                <?php //side bar content ?>
                <?php wcap_render_register_panel(); ?>
            </div>
        <?php } ?>
        <div class="<?php echo ($show_sidebar) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
            <div class="whcom_page_heading">
                <span><?php esc_html_e("Register", "whcom") ?></span>
            </div>

            <?php //main content ?>
            <div class="whcom_margin_bottom_15 whcom_text_left wcap_view_container">
                <div id="register_account">
                    <form id="register_client_form">
                        <input type="hidden" name="action" value="wcap_requests">
                        <input type="hidden" name="what" value="register_new_client"

                        <?php echo whcom_render_register_form_fields(); ?>

                        <?php echo whcom_render_tos_fields(); ?>

                        <?php if (get_option("whcom_recaptcha_on_off") == "yes") {
                            $sitekey = 'whcom_sitekey';
                            ?>

                            <div style="display:block; width:320px; margin:10px auto 0 auto;">
                                <div class="g-recaptcha" data-sitekey="<?php echo get_option($sitekey) ?>"
                                     data-callback="recaptcha_callback"></div>
                            </div>
                        <?php } ?>
                        <div class="wcap_view_response wcap_response_div">

                        </div>
                        <div class="wcop_response" style="display: none"></div>
                        <?php if (get_option("whcom_recaptcha_on_off") == "yes") { ?>
                            <div class="whcom_form_field whcom_form_field_horizontal whcom_text_center_xs">
                                <button id="register_form_button" type="submit"
                                        disabled><?php esc_html_e('Register', 'wcop') ?></button>
                            </div>
                        <?php } else { ?>
                            <div class="whcom_form_field whcom_form_field_horizontal whcom_text_center_xs">
                                <button id="register_form_button"
                                        type="submit"><?php esc_html_e('Register', 'wcop') ?></button>
                            </div>
                        <?php } ?>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    function recaptcha_callback() {
        var registerBTN = document.querySelector('#register_form_button');
        registerBTN.removeAttribute('disabled');
    }
</script>



