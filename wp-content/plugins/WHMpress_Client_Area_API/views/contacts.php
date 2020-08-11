<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar("contacts_subaccounts", true);

//show front menu where applicable
if (wcap_show_front_menu()) {
    include_once $this->Path . "/views/top_links_front.php";
}

$client_row   = wcap_get_clients_accounts( "userid=" . whcom_get_current_client_id() );
$all_contacts = $client_row['contacts']['contact'];
if ( ( ! isset( $_POST['contact_action'] ) ) || ( ! isset( $_POST['contact_id'] ) ) || ( $_POST['contact_id'] < 1 ) ) {
    $_POST['contact_action'] = 'add_new';
    $_POST['contact_id'] = '0';
}
$contact_action = $_POST['contact_action'];

$current_contact = [];
if ( is_string( $client_row ) ) {
    echo "<h1>" . $client_row . "</h1>";
    return;
}

?>

<script>
    /**
     * Below JS codes came from WHMCS for processing of registration form....
     */
    function changeState() {
        var a = "",
            b = jQuery( "input[name=state]" ).data( "selectinlinedropdown" );
        a = getStateSelectClass( b ), a.length < 1 && (b = jQuery( "#stateinput" ).data( "selectinlinedropdown" ), a = getStateSelectClass( b ));
        var c = jQuery( "#stateinput" ).val(),
            d = jQuery( "select[name=country]" ).val(),
            e = jQuery( "#stateinput" ).attr( "tabindex" ),
            f = jQuery( "#stateinput" ).attr( "disabled" ),
            g = jQuery( "#stateinput" ).attr( "readonly" );
        if ( void 0 === e && (e = ""), void 0 === f && (f = ""), void 0 === g && (g = ""), states[d] ) {
            jQuery( "#stateinput" ).hide().removeAttr( "name" ).removeAttr( "required" ), jQuery( "#inputStateIcon" ).hide(), jQuery( "#stateselect" ).remove();
            var h = "";
            for ( key in states[d] ) {
                if ( stateval = states[d][key], "end" == stateval ) {
                    break;
                }
                h += "<option", stateval == c && (h += ' selected="selected"'), h += ">" + stateval + "</option>"
            }
            "" != e && (e = ' tabindex="' + e + '"'), (f || g) && (f = " disabled"), jQuery( "#stateinput" ).parent().append( '<select name="state" class="' + jQuery( "#stateinput" ).attr( "class" ) + a + '" id="stateselect"' + e + f + '><option value="">&mdash;</option>' + h + "</select>" );
            var i = ! 0;
            "boolean" == typeof stateNotRequired && stateNotRequired && (i = ! 1), jQuery( "#stateselect" ).attr( "required", i )
        }
        else {
            var i = ! 0;
            "boolean" == typeof stateNotRequired && stateNotRequired && (i = ! 1), jQuery( "#stateselect" ).remove(), jQuery( "#stateinput" ).show().attr( "name", "state" ).attr( "required", i ), jQuery( "#inputStateIcon" ).show()
        }
    }

    function getStateSelectClass( a ) {
        var b = "";
        return a && (b = " select-inline"), b
    }

    function validatePassword2() {
        var a = jQuery( "#inputNewPassword1" ).val(),
            b = jQuery( "#inputNewPassword2" ).val(),
            c = jQuery( "#newPassword2" );
        b && a !== b ? (c.removeClass( "has-success" ).addClass( "has-error" ), jQuery( "#inputNewPassword2" ).next( ".wcap_form_control-feedback" ).removeClass( "glyphicon-ok" ).addClass( "glyphicon-remove" ), jQuery( "#inputNewPassword2Msg" ).html( '<p class="help-block">The passwords entered do not match</p>' ), jQuery( '#wcap_add_contact_form_submit' ).attr( "disabled", "disabled" )) : (b ? (c.removeClass( "has-error" ).addClass( "has-success" ), jQuery( "#inputNewPassword2" ).next( ".wcap_form_control-feedback" ).removeClass( "glyphicon-remove" ).addClass( "glyphicon-ok" ), jQuery( '#wcap_add_contact_form_submit' ).removeAttr( "disabled" )) : (c.removeClass( "has-error has-success" ), jQuery( "#inputNewPassword2" ).next( ".wcap_form_control-feedback" ).removeClass( "glyphicon-remove glyphicon-ok" )), jQuery( "#inputNewPassword2Msg" ).html( "" ));
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
    jQuery( document ).ready( function () {
        jQuery( "input[name=state]" ).attr( "id", "stateinput" ), jQuery( "select[name=country]" ).change( function () {
            changeState()
        } ), changeState()
    } ),
        jQuery( "#inputNewPassword1" ).keyup( function () {
            var a = 50,
                b = 75,
                c = jQuery( "#newPassword1" ),
                d = jQuery( "#inputNewPassword1" ).val(),
                e = d.length;
            e > 5 && (e = 5);
            var f = d.replace( /[0-9]/g, "" ),
                g = d.length - f.length;
            g > 3 && (g = 3);
            var h = d.replace( /\W/g, "" ),
                i = d.length - h.length;
            i > 3 && (i = 3);
            var j = d.replace( /[A-Z]/g, "" ),
                k = d.length - j.length;
            k > 3 && (k = 3);
            var l = 10 * e - 20 + 10 * g + 15 * i + 10 * k;
            l < 0 && (l = 0), l > 100 && (l = 100), c.removeClass( "has-error has-warning has-success" ), jQuery( "#inputNewPassword1" ).next( ".wcap_form_control-feedback" ).removeClass( "glyphicon-remove glyphicon-warning-sign glyphicon-ok" ), jQuery( "#passwordStrengthBar .progress-bar" ).removeClass( "progress-bar-danger progress-bar-warning progress-bar-success" ).css( "width", l + "%" ).attr( "aria-valuenow", l ), jQuery( "#passwordStrengthBar .progress-bar .sr-only" ).html( "New Password Rating: " + l + "%" ), l < a ? (c.addClass( "has-error" ), jQuery( "#inputNewPassword1" ).next( ".wcap_form_control-feedback" ).addClass( "glyphicon-remove" ), jQuery( "#passwordStrengthBar .progress-bar" ).addClass( "progress-bar-danger" )) : l < b ? (c.addClass( "has-warning" ), jQuery( "#inputNewPassword1" ).next( ".wcap_form_control-feedback" ).addClass( "glyphicon-warning-sign" ), jQuery( "#passwordStrengthBar .progress-bar" ).addClass( "progress-bar-warning" )) : (c.addClass( "has-success" ), jQuery( "#inputNewPassword1" ).next( ".wcap_form_control-feedback" ).addClass( "glyphicon-ok" ), jQuery( "#passwordStrengthBar .progress-bar" ).addClass( "progress-bar-success" )), validatePassword2()
        } ),
        jQuery( document ).ready( function () {
            jQuery( 'wcap_add_contact_form_submit' ).attr( "disabled", "disabled" ), jQuery( "#inputNewPassword2" ).keyup( function () {
                validatePassword2()
            } )
        } );

    jQuery( "#inputSubaccountActivate" ).on( 'change', function () {
        var sub_account_container = jQuery( "#subacct-container" );
        var sub_account_check = jQuery( this );
        var sub_account_val = sub_account_check.prop( 'checked' );
        if ( sub_account_val ) {
            sub_account_container.slideDown( 500 );
            jQuery( '#inputNewPassword1' ).prop( 'required', true );
        }
        else {
            sub_account_container.slideUp( 500 );
            jQuery( '#inputNewPassword1' ).prop( 'required', false );
        }

    } );

    jQuery( "#wcap_choose_contact" ).on( 'change', function () {
        jQuery('#wcap_choose_contact_submit').click();
    });

    jQuery( "#wcap_delete_contact_button" ).on( 'change', function () {
        if (jQuery(this).prop('checked')) {
            jQuery('#wcap_update_contact_form_submit').click();
        }
    });

</script>

<div class="wcap_contacts_subaccounts wcap_view_container">
    <div class="whcom_row">
        <?php if ($show_sidebar) { ?>
            <div class="whcom_col_sm_3">
                <?php //side bar content ?>
                <?php wcap_render_support_panel(); ?>
            </div>
        <?php } ?>
        <div class="<?php echo ($show_sidebar) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
            <div class="whcom_page_heading">
                <span><?php esc_html_e("Contacts/Sub-Accounts", "whcom" ) ?></span>
            </div>

            <?php //main content ?>
            <div class="wcap_view_response"></div>
            <div class="whcom_margin_bottom_15 wcap_view_content">
                <form method="post" id="wcap_choose_contact_form">
                    <div class="whcom_alert wcap_response_text" style="display:none;"></div>
                    <input type="hidden" name="action" value="wcap_requests">
                    <input type="hidden" name="what" value="choose_contact">
                    <input type="hidden" name="contact_action" value="edit_contact">
                    <div class="whcom_form_field">
                        <label for="wcap_choose_contact" class="main_label"><?php esc_html_e( 'Choose Contact', "whcom" ) ?></label>
                        <select name="contact_id" id="wcap_choose_contact">
                            <option value="0"><?php esc_html_e( 'Add New Contact', "whcom" ) ?></option>
                            <?php
                            if ( ! empty( $all_contacts ) && is_array( $all_contacts ) ) {
                                foreach ( $all_contacts as $contact ) {
                                    $selected = '';
                                    if ($contact['id'] == $_POST['contact_id']) {
                                        $current_contact = $contact;
                                        $selected = 'selected';
                                    }
                                    echo "<option value='" . $contact['id'] . "' " . $selected . ">" . $contact['firstname'] . " " . $contact['lastname'] . " - " . $contact['email'] . "</option>";
                                }
                            }
                            ?>
                        </select>

                        <input type="submit" style="display: none !important;" id="wcap_choose_contact_submit">

                    </div>
                </form>

                <?php if ( $contact_action == "edit_contact" ) { ?>
                    <form id="wcap_update_contact_form">
                        <input type="hidden" name="what" value="update_contact">
                        <input type="hidden" name="action" value="wcap_requests">
                        <input type="hidden" name="contactid" value="<?php echo $current_contact['id']; ?>">
                        <input type="hidden">

                        <div class="whcom_form_field">
                            <label for="inputFirstName" class="main_label"><?php esc_html_e("First Name","whcom")?></label>
                            <input type="text" name="firstname" id="inputFirstName" value="<?php echo $current_contact['firstname']; ?>" class="form-control"
                                   style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;);">
                        </div>

                        <div class="whcom_form_field">
                            <label for="inputLastName" class="main_label"><?php esc_html_e("Last Name","whcom")?></label>
                            <input type="text" name="lastname" id="inputLastName" value="<?php echo $current_contact['lastname']; ?>" class="form-control">
                        </div>

                        <div class="whcom_form_field">
                            <label for="inputCompanyName" class="main_label"><?php esc_html_e("Company Name","whcom")?></label>
                            <input type="text" name="companyname" id="inputCompanyName" value="<?php echo $current_contact['companyname']; ?>" class="form-control">
                        </div>

                        <div class="whcom_form_field">
                            <label for="inputEmail" class="main_label"><?php esc_html_e("Email Address","whcom")?></label>
                            <input type="email" name="email" id="inputEmail" value="<?php echo $current_contact['email']; ?>" class="form-control">
                        </div>

                        <div class="whcom_form_field">
                            <label for="inputPhone" class="main_label"><?php esc_html_e("Phone Number","whcom")?></label>
                            <input type="tel" name="phonenumber" id="inputPhone" value="<?php echo $current_contact['phonenumber']; ?>" class="form-control">
                        </div>

                        <div class="whcom_form_field">
                            <label for="inputAddress1" class="main_label"><?php esc_html_e("Address 1","whcom")?></label>
                            <input type="text" name="address1" id="inputAddress1" value="<?php echo $current_contact['address1']; ?>" class="form-control">
                        </div>

                        <div class="whcom_form_field">
                            <label for="inputAddress2" class="main_label"><?php esc_html_e("Address 2","whcom")?></label>
                            <input type="text" name="address2" id="inputAddress2" value="<?php echo $current_contact['address2']; ?>" class="form-control">
                        </div>

                        <div class="whcom_form_field">
                            <label for="inputCity" class="main_label"><?php esc_html_e("City","whcom")?></label>
                            <input type="text" name="city" id="inputCity" value="<?php echo $current_contact['city']; ?>" class="form-control">
                        </div>

                        <div class="whcom_form_field">
                            <label for="inputState" class="main_label"><?php esc_html_e("State/Region","whcom")?></label>
                            <input type="text" id="stateinput" value="<?php echo $current_contact['state']; ?>" class="form-control" style="display: none;">
                            <select name="state" class="form-control" id="stateselect">
                                <option value="">—</option>
                            </select>
                        </div>

                        <div class="whcom_form_field">
                            <label for="inputPostcode" class="main_label"><?php esc_html_e("Zip Code","whcom")?></label>
                            <input type="text" name="postcode" id="inputPostcode" value="<?php echo $current_contact['postcode']; ?>" class="form-control">
                        </div>

                        <div class="whcom_form_field">
                            <label class="main_label" for="country"><?php esc_html_e("Country","whcom")?></label>
                            <select name="country" id="country" class="form-control">
                                <?php foreach(wcap_get_countries() as $k=>$country) { ?>
                                    <?php $selected = ( $k == $current_contact['country'] ) ? 'selected="selected"' : ''; ?>
                                    <option value="<?php echo $k ?>" <?php echo $selected ?>><?php echo $country ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="whcom_form_field">
                            <label class="main_label" for="inputSubaccountActivate">Activate Sub-Account</label>
                            <div class="wcap_checkbox_container">
                                <?php
                                $permissions = explode(',', $current_contact['permissions']);
                                $checked = '';
                                if ($current_contact['subaccount'] == '1') {
                                    $checked = 'checked';
                                } ?>
                                <label><input type="checkbox" name="subaccount" id="inputSubaccountActivate" <?php echo $checked;?>> <?php esc_html_e("Tick to configure as a sub-account with client area access","whcom")?></label>
                            </div>
                        </div>

                        <div id="subacct-container" style="display: <?php echo ($checked == 'checked') ? 'block' : 'none'; ?>">
                            <div class="whcom_form_field">
                                <label class="main_label"><?php esc_html_e("Sub-Account Permissions","whcom")?></label>
                                <div class="wcap_checkbox_container">
                                    <label class="wcap_display_block">
                                        <?php $checked = '';
                                        if (in_array('profile', $permissions)) {
                                            $checked = 'checked';
                                        } ?>
                                        <input type="checkbox" name="permissions[]" value="profile" <?php echo $checked;?>>
                                        <span><?php esc_html_e("Modify Master Account Profile","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <?php $checked = '';
                                        if (in_array('contacts', $permissions)) {
                                            $checked = 'checked';
                                        } ?>
                                        <input type="checkbox" name="permissions[]" value="contacts" <?php echo $checked;?>>
                                        <span><?php esc_html_e("View & Manage Contacts","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <?php $checked = '';
                                        if (in_array('products', $permissions)) {
                                            $checked = 'checked';
                                        } ?>
                                        <input type="checkbox" name="permissions[]" value="products" <?php echo $checked;?>>
                                        <span><?php esc_html_e("View Products & Services","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <?php $checked = '';
                                        if (in_array('manageproducts', $permissions)) {
                                            $checked = 'checked';
                                        } ?>
                                        <input type="checkbox" name="permissions[]" value="manageproducts" <?php echo $checked;?>>
                                        <span><?php esc_html_e("View & Modify Product Passwords","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <?php $checked = '';
                                        if (in_array('productsso', $permissions)) {
                                            $checked = 'checked';
                                        } ?>
                                        <input type="checkbox" name="permissions[]" value="productsso" <?php echo $checked;?>>
                                        <span><?php esc_html_e("Perform Single Sign-On","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <?php $checked = '';
                                        if (in_array('domains', $permissions)) {
                                            $checked = 'checked';
                                        } ?>
                                        <input type="checkbox" name="permissions[]" value="domains" <?php echo $checked;?>>
                                        <span><?php esc_html_e("View Domains","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <?php $checked = '';
                                        if (in_array('managedomains', $permissions)) {
                                            $checked = 'checked';
                                        } ?>
                                        <input type="checkbox" name="permissions[]" value="managedomains" <?php echo $checked;?>>
                                        <span><?php esc_html_e("Manage Domain Settings","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <?php $checked = '';
                                        if (in_array('invoices', $permissions)) {
                                            $checked = 'checked';
                                        } ?>
                                        <input type="checkbox" name="permissions[]" value="invoices" <?php echo $checked;?>>
                                        <span><?php esc_html_e("View & Pay Invoices","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <?php $checked = '';
                                        if (in_array('quotes', $permissions)) {
                                            $checked = 'checked';
                                        } ?>
                                        <input type="checkbox" name="permissions[]" value="quotes" <?php echo $checked;?>>
                                        <span><?php esc_html_e("View & Accept Quotes","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <?php $checked = '';
                                        if (in_array('tickets', $permissions)) {
                                            $checked = 'checked';
                                        } ?>
                                        <input type="checkbox" name="permissions[]" value="tickets" <?php echo $checked;?>>
                                        <span><?php esc_html_e("View & Open Support Tickets","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <?php $checked = '';
                                        if (in_array('affiliates', $permissions)) {
                                            $checked = 'checked';
                                        } ?>
                                        <input type="checkbox" name="permissions[]" value="affiliates" <?php echo $checked;?>>
                                        <span><?php esc_html_e("View & Manage Affiliate Account","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <?php $checked = '';
                                        if (in_array('emails', $permissions)) {
                                            $checked = 'checked';
                                        } ?>
                                        <input type="checkbox" name="permissions[]" value="emails" <?php echo $checked;?>>
                                        <span><?php esc_html_e("View Emails","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <?php $checked = '';
                                        if (in_array('orders', $permissions)) {
                                            $checked = 'checked';
                                        } ?>
                                        <input type="checkbox" name="permissions[]" value="orders" <?php echo $checked;?>>
                                        <span><?php esc_html_e("Place New Orders/Upgrades/Cancellations","whcom")?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="whcom_form_field" id="newPassword1">
                                <label for="inputNewPassword1"
                                       class="main_label whcom_text_right"><?php esc_html_e( 'Password', "whcom" ) ?> *</label>
                                <input name="password1" type="password" id="inputNewPassword1">
                                <div class="whcom_clearfix"></div>
                                <label for="" class="main_label whcom_text_right"></label>
                                <div class="wcap_checkbox_container" style="max-width: 480px; padding-top: 10px">
                                    <div class="progress" id="passwordStrengthBar">
                                        <div class="progress-bar" role="progressbar" style="width: 0;">
                                            <span class="sr-only">New Password Rating: 0%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="whcom_clearfix"></div>
                                <label for="" class="main_label whcom_text_right"></label>
                                <div class="wcap_checkbox_container" style="font-weight: normal">
                                    <div class="alert alert-info">
                                        <strong><?php esc_html_e("Tips for a good password","whcom")?></strong><br><?php esc_html_e("Use both upper and lowercase characters","whcom")?><br><?php esc_html_e("Include at least one symbol (# $ ! % & etc...)","whcom")?><br><?php esc_html_e("Don't use dictionary words","whcom")?>
                                    </div>
                                </div>
                            </div>
                            <div class="whcom_form_field" id="newPassword2">
                                <label for="inputNewPassword2"
                                       class="main_label whcom_text_right"><?php esc_html_e( 'Confirm Password', "whcom" ) ?> *</label>
                                <input name="password2" type="password" id="inputNewPassword2">
                                <div class="whcom_clearfix"></div>
                                <label for="" class="main_label whcom_text_right"></label>
                                <div class="wcap_checkbox_container" style="font-weight: normal">
                                    <div id="inputNewPassword2Msg"></div>
                                </div>
                            </div>
                        </div>

                        <div class="whcom_form_field">
                            <label class="main_label"><?php esc_html_e("Email Preferences","whcom")?></label>
                            <div class="wcap_checkbox_container">
                                <label class="wcap_display_block">
                                    <?php
                                    $checked = '';
                                    if ($current_contact['generalemails'] == '1') {
                                        $checked = 'checked';
                                    } ?>
                                    <input type="checkbox" name="generalemails" id="generalemails" value="1" <?php echo $checked; ?>>
                                    <?php esc_html_e("General Emails - General Announcements & Password Reminders","whcom")?>
                                </label>
                                <label class="wcap_display_block">
                                    <?php
                                    $checked = '';
                                    if ($current_contact['productemails'] == '1') {
                                        $checked = 'checked';
                                    } ?>
                                    <input type="checkbox" name="productemails" id="productemails" value="1" <?php echo $checked; ?>>
                                    <?php esc_html_e("Product Emails - Order Details, Welcome Emails, etc...","whcom")?>
                                </label>
                                <label class="wcap_display_block">
                                    <?php
                                    $checked = '';
                                    if ($current_contact['domainemails'] == '1') {
                                        $checked = 'checked';
                                    } ?>
                                    <input type="checkbox" name="domainemails" id="domainemails" value="1" <?php echo $checked; ?>>
                                    <?php esc_html_e("Domain Emails - Renewal Notices, Registration Confirmations, etc...","whcom")?>
                                </label>
                                <label class="wcap_display_block">
                                    <?php
                                    $checked = '';
                                    if ($current_contact['invoiceemails'] == '1') {
                                        $checked = 'checked';
                                    } ?>
                                    <input type="checkbox" name="invoiceemails" id="invoiceemails" value="1" <?php echo $checked; ?>>
                                    <?php esc_html_e("Invoice Emails - Invoices & Billing Reminders","whcom")?>
                                </label>
                                <label class="wcap_display_block">
                                    <?php
                                    $checked = '';
                                    if ($current_contact['supportemails'] == '1') {
                                        $checked = 'checked';
                                    } ?>
                                    <input type="checkbox" name="supportemails" id="supportemails" value="1" <?php echo $checked; ?>>
                                    <?php esc_html_e("Support Emails - Allow this user to open tickets in your account","whcom")?>
                                </label>
                            </div>
                        </div>

                        <div class="whcom_text_center">
                            <input class="whcom_button" type="submit" name="save" value="<?php esc_html_e("Save Changes","whcom")?>" id="wcap_update_contact_form_submit">
                            <input class="whcom_button whcom_button_secondary" type="reset" value="<?php esc_html_e("Cancel","whcom")?>">
                            <label class="whcom_button whcom_button_danger">
                                <?php esc_html_e("Delete Contact","whcom")?>
                                <input type="checkbox" name="delete_contact" value="yes" style="display: none !important;" id="wcap_delete_contact_button">
                            </label>
                        </div>

                    </form>
                <?php }
                else { ?>
                    <form id="wcap_add_contact_form">
                        <input type="hidden" name="what" value="add_new_contact">
                        <input type="hidden" name="action" value="wcap_requests">
                        <input type="hidden">
                        <div class="whcom_alert wcap_response_text" style="display: none;"></div>
                        <div class="whcom_form_field">
                            <label for="inputFirstName" class="main_label"><?php esc_html_e("First Name","whcom")?></label>
                            <input type="text" name="firstname" id="inputFirstName" value="" class="form-control"
                                   style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;);">
                        </div>

                        <div class="whcom_form_field">
                            <label for="inputLastName" class="main_label"><?php esc_html_e("Last Name","whcom")?></label>
                            <input type="text" name="lastname" id="inputLastName" value="" class="form-control">
                        </div>

                        <div class="whcom_form_field">
                            <label for="inputCompanyName" class="main_label"><?php esc_html_e("Company Name","whcom")?></label>
                            <input type="text" name="companyname" id="inputCompanyName" value="" class="form-control">
                        </div>

                        <div class="whcom_form_field">
                            <label for="inputEmail" class="main_label"><?php esc_html_e("Email Address","whcom")?></label>
                            <input type="email" name="email" id="inputEmail" value="" class="form-control">
                        </div>

                        <div class="whcom_form_field">
                            <label for="inputPhone" class="main_label"><?php esc_html_e("Phone Number","whcom")?></label>
                            <input type="tel" name="phonenumber" id="inputPhone" value="" class="form-control">
                        </div>

                        <div class="whcom_form_field">
                            <label for="inputAddress1" class="main_label"><?php esc_html_e("Address 1","whcom")?></label>
                            <input type="text" name="address1" id="inputAddress1" value="" class="form-control">
                        </div>

                        <div class="whcom_form_field">
                            <label for="inputAddress2" class="main_label"><?php esc_html_e("Address 2","whcom")?></label>
                            <input type="text" name="address2" id="inputAddress2" value="" class="form-control">
                        </div>

                        <div class="whcom_form_field">
                            <label for="inputCity" class="main_label"><?php esc_html_e("City","whcom")?></label>
                            <input type="text" name="city" id="inputCity" value="" class="form-control">
                        </div>

                        <div class="whcom_form_field">
                            <label for="inputState" class="main_label"><?php esc_html_e("State/Region","whcom")?></label>
                            <input type="text" id="stateinput" value="" class="form-control" style="display: none;">
                            <select name="state" class="form-control" id="stateselect">
                                <option value="">—</option>
                            </select>
                        </div>

                        <div class="whcom_form_field">
                            <label for="inputPostcode" class="main_label"><?php esc_html_e("Zip Code","whcom")?></label>
                            <input type="text" name="postcode" id="inputPostcode" value="" class="form-control">
                        </div>

                        <div class="whcom_form_field">
                            <label class="main_label" for="country"><?php esc_html_e("Country","whcom")?></label>
                            <select name="country" id="country" class="form-control">
                                <?php foreach(wcap_get_countries() as $k=>$country) { ?>
                                    <?php $selected = ( $k == 'US' ) ? 'selected="selected"' : ''; ?>
                                    <option value="<?php echo $k ?>" <?php echo $selected ?>><?php echo $country ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="whcom_form_field">
                            <label class="main_label" for="inputSubaccountActivate"><?php esc_html_e("Activate Sub-Account","whcom")?></label>
                            <div class="wcap_checkbox_container">
                                <label><input type="checkbox" name="subaccount"
                                              id="inputSubaccountActivate">
                                    <?php esc_html_e("Tick to configure as a sub-account with client area access","whcom")?></label>
                            </div>
                        </div>

                        <div id="subacct-container" style="display: none">
                            <div class="whcom_form_field">
                                <label class="main_label"><?php esc_html_e("Sub-Account Permission","whcom")?>s</label>
                                <div class="wcap_checkbox_container">
                                    <label class="wcap_display_block">
                                        <input type="checkbox" name="permissions[]" value="profile">
                                        <span><?php esc_html_e("Modify Master Account Profile","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <input type="checkbox" name="permissions[]" value="contacts">
                                        <span><?php esc_html_e("View & Manage Contacts","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <input type="checkbox" name="permissions[]" value="products">
                                        <span><?php esc_html_e("View Products & Services","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <input type="checkbox" name="permissions[]" value="manageproducts">
                                        <span><?php esc_html_e("View Modify Product Passwords","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <input type="checkbox" name="permissions[]" value="productsso">
                                        <span><?php esc_html_e("Perform Single Sign-On","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <input type="checkbox" name="permissions[]" value="domains">
                                        <span><?php esc_html_e("View Domains","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <input type="checkbox" name="permissions[]" value="managedomains">
                                        <span><?php esc_html_e("Manage Domain Settings","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <input type="checkbox" name="permissions[]" value="invoices">
                                        <span><?php esc_html_e("View & Pay Invoices","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <input type="checkbox" name="permissions[]" value="quotes">
                                        <span><?php esc_html_e("View & Accept Quotes","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <input type="checkbox" name="permissions[]" value="tickets">
                                        <span><?php esc_html_e("View & Open Support Tickets","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <input type="checkbox" name="permissions[]" value="affiliates">
                                        <span><?php esc_html_e("View & Manage Affiliate Account","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <input type="checkbox" name="permissions[]" value="emails">
                                        <span><?php esc_html_e("View Emails","whcom")?></span>
                                    </label>
                                    <label class="wcap_display_block">
                                        <input type="checkbox" name="permissions[]" value="orders">
                                        <span><?php esc_html_e("Place New Orders/Upgrades/Cancellations","whcom")?></span>
                                    </label>
                                </div>
                            </div>
                            <div class="whcom_form_field" id="newPassword1">
                                <label for="inputNewPassword1"
                                       class="main_label whcom_text_right"><?php esc_html_e( 'Password', "whcom" ) ?> *</label>
                                <input name="password1" type="password" id="inputNewPassword1">
                                <div class="whcom_clearfix"></div>
                                <label for="" class="main_label whcom_text_right"></label>
                                <div class="wcap_checkbox_container" style="max-width: 480px; padding-top: 10px">
                                    <div class="progress" id="passwordStrengthBar">
                                        <div class="progress-bar" role="progressbar" style="width: 0;">
                                            <span class="sr-only">New Password Rating: 0%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="whcom_clearfix"></div>
                                <label for="" class="main_label whcom_text_right"></label>
                                <div class="wcap_checkbox_container" style="font-weight: normal">
                                    <div class="alert alert-info">
                                        <strong><?php esc_html_e("Tips for a good password","whcom")?></strong>
                                        <br><?php esc_html_e("Use both upper and lowercase characters","whcom")?><br>
                                        <?php esc_html_e("Include at least one symbol (# $ ! % &; etc...)","whcom")?><br>
                                        <?php esc_html_e("Don't use dictionary words","whcom")?>
                                    </div>
                                </div>
                            </div>
                            <div class="whcom_form_field" id="newPassword2">
                                <label for="inputNewPassword2"
                                       class="main_label whcom_text_right"><?php esc_html_e( 'Confirm Password', "whcom" ) ?> *</label>
                                <input name="password2" type="password" id="inputNewPassword2">
                                <div class="whcom_clearfix"></div>
                                <label for="" class="main_label whcom_text_right"></label>
                                <div class="wcap_checkbox_container" style="font-weight: normal">
                                    <div id="inputNewPassword2Msg"></div>
                                </div>
                            </div>
                        </div>

                        <div class="whcom_form_field">
                            <label class="main_label"><?php esc_html_e("Email Preferences","whcom")?></label>
                            <div class="wcap_checkbox_container">
                                <label class="wcap_display_block">
                                    <input type="checkbox" name="generalemails" id="generalemails" value="1">
                                    <?php esc_html_e("General Emails - General Announcements & Password Reminders","whcom")?>
                                </label>
                                <label class="wcap_display_block">
                                    <input type="checkbox" name="productemails" id="productemails" value="1">
                                    <?php esc_html_e("Product Emails - Order Details, Welcome Emails, etc...","whcom")?>
                                </label>
                                <label class="wcap_display_block">
                                    <input type="checkbox" name="domainemails" id="domainemails" value="1">
                                    <?php esc_html_e("Domain Emails - Renewal Notices, Registration Confirmations, etc...","whcom")?>
                                </label>
                                <label class="wcap_display_block">
                                    <input type="checkbox" name="invoiceemails" id="invoiceemails" value="1">
                                    <?php esc_html_e("Invoice Emails - Invoices & Billing Reminders","whcom")?>
                                </label>
                                <label class="wcap_display_block">
                                    <input type="checkbox" name="supportemails" id="supportemails" value="1">
                                    <?php esc_html_e("Support Emails - Allow this user to open tickets in your account","whcom")?>
                                </label>
                            </div>
                        </div>

                        <div class="whcom_text_center">
                            <input class="whcom_button" type="submit" name="save" value="<?php esc_html_e("Save Changes","whcom")?>"
                                   id="wcap_add_contact_form_submit">
                            <input class="whcom_button whcom_button_secondary" type="reset" value="<?php esc_html_e("Cancel","whcom")?>">
                        </div>

                    </form>
                <?php } ?>


            </div>


        </div>
    </div>
</div>







