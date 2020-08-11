<?php
/**
 * Copyright (c) 2014-2016 by creativeON.
 */

/**
 * WHMPress main class
 *
 * @Since   1.3.0
 */
class WHMPress
{

    /**
     * It will return array for html, image files.
     * It will return false if no files found.
     */
    function __construct()
    {
        if (!session_id()) {
            $cacheValue = get_option('whmpress_session_cache_limiter_value');
            session_cache_limiter($cacheValue);
            session_start();
        }
        if (!isset($_SESSION["whcom_currency"])) {
            $time = date("H:i:s");
            //$currenct_country = file_get_contents("http://api.hostip.info/get_json.php?ip=" . $_SERVER["REMOTE_ADDR"]);
            /*
            $response = wp_remote_get("http://api.hostip.info/get_json.php?ip=" . $_SERVER["REMOTE_ADDR"]);

            if (is_array($response)) {
                $currenct_country = $response['body'];
                $currenct_country = json_decode($currenct_country);
            } else {
                $currenct_country = json_decode(
                    array(
                        "country_name" => "(Private Address)",
                        "country_code" => "XX",
                        "city" => "(Private Address)",
                        "ip" => "::1"
                    )
                );
            }
            //echo "<!-- Response Time: $time > ".date("H:i:s")." -->";
            $countries = get_option("whmp_countries_currencies");

            if (isset($countries["country"]) && is_array($countries["country"])) {
                $__key = array_search($currenct_country->country_code, $countries["country"]);
            } else {
                $__key = false;
            }

            if ($__key!==false) {
                if ($countries["currency"][$__key]<>"") $_SESSION["currency"] = $countries["currency"][$__key];
                else $_SESSION["currency"] = whmp_get_default_currency_id('id');
            } else {
                $_SESSION["currency"] = whmp_get_default_currency_id('id');
            }*/
            $_SESSION["whcom_currency"] = $this->whmp_get_default_currency_id('id');
        }
    }

    public function whmp_get_default_currency_id()
    {
        if (!$this->WHMpress_synced()) {
            return '';
        }

        $currency = get_option("whmpress_default_currency");
        if (!empty($currency) && is_numeric($currency)) {
            return $currency;
        }

        global $wpdb;
        $Q = "SELECT `id` FROM `" . $this->whmp_get_currencies_table_name() . "` WHERE `default`='1'";

        return $wpdb->get_var($Q);
    }

    public function WHMpress_synced()
    {
        if (get_option("sync_run") <> "1") {
            return false;
        }

        global $wpdb;
        $Ts = $wpdb->get_results("SHOW TABLES LIKE '" . $this->whmp_get_configuration_table_name() . "'", ARRAY_A);
        if (sizeof($Ts) == 0) {
            return false;
        }

        return true;
    }

    public function whmp_get_configuration_table_name()
    {
        global $wpdb;

        return $wpdb->prefix . "whmpress_configuration";
    }

    public function whmp_get_currencies_table_name()
    {
        global $wpdb;

        return $wpdb->prefix . "whmpress_currencies";
    }

    function is_valid_domain_name($domain_name)
    {
        if (strpos($domain_name, " ") !== false) {
            return false;
        }
        if (strlen($domain_name) > 253) {
            return false;
        }


        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬]/', $domain_name)) {
            return false;
        }


        return true;

        /*return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) //valid chars check
                && preg_match("/^.{1,253}$/", $domain_name) //overall length check
                && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)   ); //length of each label*/
    }

    function is_valid_domain_pk($domain_name)
    {
        $domain = whmp_get_domain_clean($domain_name);

        if (strlen($domain["short"]) < 4 && $domain["ext"] == "pk") {

            return false;
        }

        return true;

        /*return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) //valid chars check
                && preg_match("/^.{1,253}$/", $domain_name) //overall length check
                && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)   ); //length of each label*/
    }

    /**
     * @param $shortcode_name
     *
     * @return array
     *
     * This function will return all template files.
     */
    public function get_all_template_files($shortcode_name)
    {
        $Files = [];
        $Path = WHMP_PLUGIN_DIR . "/themes/" . basename($this->whmp_get_template_directory()) . '/' . $shortcode_name;
        if (is_dir($Path)) {
            $files = scandir($Path);
            foreach ($files as $file) {
                $ext = $this->get_file_extension($file);
                if ($ext == "html" || $ext == "tpl") {
                    $Files[] = [
                        "file_path" => $Path . '/' . $file,
                        "description" => "By WHMPress Theme - " . basename($file),
                    ];
                }
            }
        }

        $Path = $this->whmp_get_template_directory() . "/whmpress/" . $shortcode_name;
        if (is_dir($Path)) {
            $files = scandir($Path);
            foreach ($files as $file) {
                $ext = $this->get_file_extension($file);
                if ($ext == "html" || $ext == "tpl") {
                    $Files[] = [
                        "file_path" => $Path . '/' . $file,
                        "description" => "By ThemeAuthor - " . basename($file),
                    ];
                }
            }
        }

        $Path = WHMP_PLUGIN_DIR . "/templates/" . $shortcode_name;
        if (is_dir($Path)) {
            $files = scandir($Path);
            foreach ($files as $file) {
                $ext = $this->get_file_extension($file);
                if ($ext == "html" || $ext == "tpl") {
                    $Files[] = [
                        "file_path" => $Path . '/' . $file,
                        "description" => " " . basename($file),
                    ];
                }
            }
        }

        return $Files;
    }

    /**
     * @return mixed
     *
     * This function will return path of active theme name.
     */
    public function whmp_get_template_directory()
    {
        return str_replace("\\", "/", get_stylesheet_directory());
    }

    /**
     * @param $filename
     *
     * @return string
     *
     * This function returns file extension
     */
    function get_file_extension($filename)
    {
        $f = pathinfo($filename);
        if (isset($f["extension"])) {
            return strtolower(trim($f["extension"]));
        } else {
            return "";
        }
    }

    /**
     * @param $html_template
     * @param $shortcode_name
     *
     * @return string
     *
     *
     */
    function check_template_file($html_template, $shortcode_name)
    {
        ## If file exists including path then return file path as it is.
        if (is_file($html_template)) {
            return $html_template;
        }

        $html_template = basename($html_template);

        if (get_option("load_sytle_orders") == "whmpress") {
            $html_template = basename($html_template);
            $Path = WHMP_PLUGIN_DIR . "/themes/" . basename($this->whmp_get_template_directory()) . '/' . $shortcode_name . '/' . $html_template;
        } elseif (get_option("load_sytle_orders") == "author") {
            $html_template = basename($html_template);
            $Path = $this->whmp_get_template_directory() . "/whmpress/" . $shortcode_name . '/' . $html_template;
        } else {
            //$Path = WHMP_PLUGIN_DIR . "/templates/" . $shortcode_name . '/' . $html_template;
            $Path = $html_template;
        }

        if (is_file($Path)) {
            return $Path;
        }

        $Path = WHMP_PLUGIN_DIR . "/templates/" . $shortcode_name . "/default.tpl";
        if (!is_file($Path)) {
            $Path = WHMP_PLUGIN_DIR . "/templates/" . $shortcode_name . "/default.html";
        }

        return $Path;

        /*$Path = $this->whmp_get_template_directory()."/whmpress/".$shortcode_name."/".$html_template;
        if (is_file($Path)) return $Path;

        $Path = WHMP_PLUGIN_DIR."/themes/". basename($this->whmp_get_template_directory()). "/". $shortcode_name."/".$html_template;
        if (is_file($Path)) return $Path;

        $Path = WHMP_PLUGIN_DIR."/templates/".$shortcode_name."/".$html_template;
        if (is_file($Path)) return $Path;

        $Path = $this->whmp_get_template_directory()."/whmpress/".$shortcode_name."/default.html";
        if (is_file($Path)) return $Path;

        $Path = WHMP_PLUGIN_DIR."/templates/".$shortcode_name."/default.html";
        return $Path;*/
    }

    /**
     * @param      $shortcode_name
     * @param bool $tiny_compatible
     *
     * @return array|bool
     *
     * This function will return list of files but by selected option from admin panel.
     */
    public function get_template_files($shortcode_name, $tiny_compatible = false)
    {
        $FilesList = $ImagesList = $CustomFields = [];
        $ThemeFiles = true;

        if (get_option("load_sytle_orders") == "whmpress") {
            $Dir = WHMP_PLUGIN_DIR . "/themes/" . basename($this->whmp_get_template_directory()) . "/" . $shortcode_name;
            $ThemeFiles = false;
        } elseif (get_option("load_sytle_orders") == "author") {
            $Dir = $this->whmp_get_template_directory() . "/whmpress/" . $shortcode_name;
            $ThemeFiles = false;
            /*if ( !is_dir($Dir) ) {
                $Dir = WHMP_PLUGIN_DIR."/templates/".$shortcode_name;
                $ThemeFiles = false;
            }*/
        } else {
            $Dir = WHMP_PLUGIN_DIR . "/templates/" . $shortcode_name;
            $ThemeFiles = false;
            /*if ( !is_dir($Dir) ) {
                $Dir = $this->whmp_get_template_directory()."/whmpress/".$shortcode_name;
                $ThemeFiles = true;
            }*/
        }


        if (is_dir($Dir)) {
            $Files = glob($Dir . "/*.{html,tpl}", GLOB_BRACE);

            foreach ($Files as $k => $file) {
                if ($tiny_compatible) {
                    $FilesList[] = ["value" => basename($file), "text" => substr(basename($file), 0, -5)];
                } else {
                    $FilesList[basename($file)] = basename($file);
                }
            }
            /*if (!$ThemeFiles) {
                $Dir = WHMP_PLUGIN_PATH."/themes/".basename($this->whmp_get_template_directory())."/".$shortcode_name;
                if (is_dir($Dir)) {
                    $Files = glob($Dir . "/*.html");
                    foreach($Files as $file) {
                        if ($tiny_compatible)
                            $FilesList[] = array("value"=>basename($file), "text"=>substr(basename($file),0,-5));
                        else
                            $FilesList[substr(basename($file),0,-5)] = basename($file);
                    }
                }
            }*/

            // Getting custom fields from CSV file.
            if (is_file($Dir . "/custom_fields.csv")) {
                $CustomFields = $this->read_csv_file($Dir . "/custom_fields.csv");
                //if ($shortcode_name=="whmpress_pricing_table") $this->debug($CustomFields);
            }

            if (is_dir($Dir . "/images/")) {
                $Files = glob($Dir . "/images/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
                foreach ($Files as $file) {
                    if ($ThemeFiles) {
                        if ($tiny_compatible) {
                            $ImagesList[] = [
                                "value" => get_stylesheet_directory_uri() . "/whmpress/$shortcode_name/images/" . basename($file),
                                "text" => basename($file),
                            ];
                        } else {
                            $ImagesList[basename($file)] = get_stylesheet_directory_uri() . "/whmpress/$shortcode_name/images/" . basename($file);
                        }
                    } else {
                        if ($tiny_compatible) {
                            $ImagesList[] = [
                                "value" => WHMP_PLUGIN_URL . "templates/$shortcode_name/images/" . basename($file),
                                "text" => basename($file),
                            ];
                        } else {
                            $ImagesList[basename($file)] = WHMP_PLUGIN_URL . "templates/$shortcode_name/images/" . basename($file);
                        }
                    }
                }
            }

            if (is_file($Dir . "/whmpress.css")) {
                $css_file = $Dir . "/whmpress.css";
            } else {
                $css_file = "-no-file-";
            }

            return [
                "html" => $FilesList,
                "images" => $ImagesList,
                "custom_fields" => $CustomFields,
                "css" => $css_file,
            ];
        } else {
            return false;
        }
    }

    public function read_csv_file($csv_file)
    {
        $rows = array_map('str_getcsv', file($csv_file));
        $header = array_shift($rows);
        $header = array_filter($header);
        $csv = [];
        foreach ($rows as $row) {
            $ar = [];
            foreach ($header as $x => $col) {
                if (!isset($row[$x])) {
                    $ar[$col] = null;
                } else if ($row[$x] == "NULL") {
                    $ar[$col] = null;
                } else {
                    $ar[$col] = isset($row[$x]) ? $row[$x] : null;
                }
            }
            $csv[] = $ar;
        }

        return $csv;
    }

    public function read_remote_url($url)
    {
        $response = wp_remote_post($url);

        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();

            return $error_message;
        } else {
            return $response["body"];
        }
    }

    public function read_local_file($filepath)
    {
        if (!is_file($filepath)) {
            return false;
        }
        global $wp_filesystem;
        if (empty($wp_filesystem)) {
            require_once(ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();
        }

        $data = $wp_filesystem->get_contents($filepath);
        if ($data === false) {
            $data = file_get_contents($filepath);
        }

        return $data;
    }

    public function font_awesome_icons()
    {
        include_once WHMP_PLUGIN_DIR . "/includes/font-awesome.class.php";
        $fa = new Smk_FontAwesome;
        $icons = $fa->getArray(WHMP_ADMIN_DIR . '/css/font-awesome.css');

        #$icons = $fa->sortByName($icons);   //Sort by key name. Alphabetically sort: from a to z
        $icons = $fa->onlyClass($icons);    //Only HTML class, no unicode. 'fa-calendar' => 'fa-calendar',
        #$icons = $fa->onlyUnicode($icons);  //Only unicode, no HTML class. '\f073' => '\f073',
        #$icons = $fa->readableName($icons); //Only HTML class, readable. 'fa-video-camera' => 'Video Camera',

        return $icons;
    }

    public function get_shortcode_parameters($shortcode)
    {
        /**
         * Explanation about parameters
         *
         * vc_hide = template_file, parameter will not show in VC editor if tempalte file exists.
         * "hide_in_editor"=>"yes" will hide from editor's combo list.
         */
        switch ($shortcode) {

            /*
			* --------------price_table------------------
			*/
            case "whmpress_pricing_table":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMpress Pricing Table", "whmpress"),
                    ),

                    "id" => array(
                        "vc_type" => "productids",
                        "heading" => esc_html__("Select Product/Service Package", "whmpress"),
                    ),

                    "html_template",
                    "image",

                    "billingcycle" => array(
                        "vc_type" => "dropdown",
                        "value" => "billing_cycle",
                        "heading" => esc_html__("Billing cycle", "whmpress"),
                    ),

                    "currency" => array(
                        "vc_type" => "currencies",
                        "heading" => esc_html__("Select currency", "whmpress"),

                    ),

                    //--------Section-------------
                    "section1" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("Advance", "whmpress"),
                        "classes" => "whmpress-custom-label",
                    ),

                    "show_price" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show Price", "whmpress"),
                        "description" => esc_html__("Weather to show service/package price or not.", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),


                    "process_description" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Process Description", "whmpress"),
                        "description" => esc_html__("Weather to Process Description or not.", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "show_description_icon" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show Description Icon", "whmpress"),
                        "description" => esc_html__("Weather to show Description Icon or not.", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "show_description_tooltip" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show Description Tooltip", "whmpress"),
                        "description" => esc_html__("Weather to show Description Tooltip or not.", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),


                    "show_combo" => array(
                        "vc_type" => "noyes",
                        "heading" => esc_html__("Show order combo", "whmpress"),
                        "description" => esc_html__("Weather to show billingcycle combo to select duration.", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "show_button" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show order button", "whmpress"),
                        "description" => esc_html__("Show Order Button > Weather to show order button or not.", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "button_text" => array(
                        "value" => "Buy Now",
                        "heading" => esc_html__("Button Text", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "override_order_url" => array(
                        "value" => "",
                        "heading" => esc_html__("Override Order URL", "whmpress"),
                        "description" => esc_html__("Use if you want to change order URL", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "override_order_combo_url" => array(
                        "value" => "",
                        "heading" => esc_html__("Override Order Combo URL", "whmpress"),
                        "description" => esc_html__("Use if you want to change order combo URL", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "append_order_url" => array(
                        "value" => "",
                        "heading" => esc_html__("Append Order URL", "whmpress"),
                        "description" => esc_html__("If you want to append some thing to order URL", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "show_discount" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show Discount", "whmpress"),
                        "description" => esc_html__("Weather to show auto calculate discount in dropdown/combon", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

//                    "discount_type" => array(
//                        "vc_type" => "dropdown",
//                        "value" => array(
//                            esc_html__("Default", "whmpress") => "",
//                            esc_html__("Yearly", "whmpress") => "yearly",
//                            esc_html__("Monthly", "whmpress") => "monthly",
//                        ),
//                        "heading" => esc_html__("Discount type (Monthly or Yearly)", "whmpress"),
//                        "description" => esc_html__("monthly: Additionally shows calculated monthly price with multiyear prices.<br />Yearly: Additionally shows calculated discount in % with multiyear prices.", "whmpress"),
//                        "group" => esc_html__("Advance", "whmpress"),
//                        'dependency' => array(
//                            'element' => 'show_discount',
//                            'value' => array('yes'),
//                        ),
//
//                    ),


                    "convert_monthly" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Convert to Monthly", "whmpress"),
                        "description" => esc_html__("Convert price to sudo monthly price", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

//                    "explain_convert_monthly" => array(
//                        "vc_type" => "yesno",
//                        "heading" => esc_html__("Explain Sudo monthly Price", "whmpress"),
//                        "group" => esc_html__("Advance", "whmpress"),
//                        'dependency' => array(
//                            'element' => 'convert_monthly',
//                            'value' => array('yes'),
//                        ),
//
//                    ),


                    //--------Section-------------
                    "section_colors" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("Colors", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "primary_color" => array(
                        "vc_type" => "colorpicker",
                        "heading" => esc_html__("Primary Color", "whmpress"),
                        "group" => esc_html__("Colors", "whmpress"),

                    ),

                    "secondary_color" => array(
                        "vc_type" => "colorpicker",
                        "heading" => esc_html__("Secondary Color", "whmpress"),
                        "group" => esc_html__("Colors", "whmpress"),

                    ),


                    //--------Section-------------
                    "section_html" => array(
                        "vc_type" => "label",
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "html_class" => array(
                        "value" => "whmpress whmpress_pricing_table",
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML Class", "whmpress"),
                        "description" => esc_html__("HTML class for container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "html_id" => array(
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML ID", "whmpress"),
                        "description" => esc_html__("HTML ID for for shortcode container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                );
                break;

            /*
			* --------------price_matrix------------------
			*/
            case "whmpress_price_table":
            case "whmpress_price_matrix":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMpress Price Matrix", "whmpress"),
                    ),

                    "html_template",
                    "image",

                    "name" => array(
                        "heading" => esc_html__("Names of services to include in price matrix", "whmpress"),
                        "description" => esc_html__("Enter coma separated names of services to include in price matrix, leaving it empty will show all services.", "whmpress"),
                    ),

                    "groups" => array(
                        "heading" => esc_html__("Enter group names/ids (comma separated)", "whmpress"),
                        "description" => esc_html__("Enter coma separated names of groups to include in price matrix, leaving it empty will show all services.", "whmpress"),
                    ),

                    "billingcycles" => array(
                        "heading" => esc_html__("Billing Cycles", "whmpress"),
                        "description" => esc_html__("Comma separated billing cycles, use from these (monthly,quarterly,semiannually,annually,biennially,triennially)", "whmpress"),
                    ),

                    "currency" => array(
                        "vc_type" => "currencies",
                        "hide_in_editor" => "yes",
                        "heading" => esc_html__("Select currency", "whmpress"),
                        "description" => esc_html__("You can override default currency here, use this option if you want to show your prices in any other currency.", "whmpress"),
                    ),

                    "order_link" => array(
                        "vc_type" => "noyes",
                        "heading" => esc_html__("Show order button", "whmpress"),
                        "description" => esc_html__("Show order button in table", "whmpress"),
                    ),

                    //--------Section-------------
                    "section1" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("Advance", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "hide_columns" => array(
                        "heading" => esc_html__("Hide Columns", "whmpress"),
                        "description" => esc_html__("Hide columns - comma seperated (e.g. sr,id,name,group)", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "decimals" => array(
                        "fb_type" => "decimals",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", 'whmpress'),
                            esc_html__("1", 'whmpress'),
                            esc_html__("2", 'whmpress'),
                            esc_html__("3", 'whmpress'),
                            esc_html__("4", 'whmpress'),
                        ),
                        "Heading" => esc_html__("Decimals", "whmpress"),
                        "description" => esc_html__("How many decimals to show with price", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "show_hidden" => array(
                        "vc_type" => "noyes",
                        "heading" => esc_html__("Show Hidden Services", "whmpress"),
                        "description" => esc_html__("If you want to force show services that are set as hidden in WHMCS, select YES", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "replace_zero" => array(
                        "value" => whmpress_get_option("pm_replace_zero"),
                        "heading" => esc_html__("Replace Zero With", "whmpress"),
                        "description" => esc_html__("You can replace (0) with (Free) or (-) or any thing.", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "replace_empty" => array(
                        "value" => whmpress_get_option("pm_replace_empty"),
                        "heading" => esc_html__("Replace empty with", "whmpress"),
                        "description" => esc_html__("If you have not set pricing for some billing cycle, you can set how to set it.", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "type" => array(
                        "value" => array(
                            esc_html__("Product", "whmpress") => "product",
                        ),
                        "fb_type" => "type",
                        "vc_type" => "dropdown",
                        "Heading" => esc_html__("Type", "whmpress"),
                        "description" => "",
                        "hide_in_editor" => "yes",
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "titles" => array(
                        "heading" => esc_html__("Change column headers with", "whmpress"),
                        "description" => esc_html__("Comma seperated new title name (Equals number of columns)", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    //--------Section-------------
                    "section2" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("Search Options", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "hide_search" => array(
                        "vc_type" => "noyes",
                        "heading" => esc_html__("Hide Search", "whmpress"),
                        "description" => esc_html__("Hide the search text box used to search in price matrix", "whmpress"),
                        "group" => esc_html__("Search", "whmpress"),
                    ),

                    "search_label" => array(
                        "value" => whmpress_get_option("pm_search_label"),
                        "heading" => esc_html__("Search Label", "whmpress"),
                        "description" => esc_html__("Label for search box", "whmpress"),
                        "group" => esc_html__("Search", "whmpress"),

                    ),

                    "search_placeholder" => array(
                        "value" => whmpress_get_option("pm_search_placeholder"),
                        "heading" => esc_html__("Search Placeholder", "whmpress"),
                        "description" => esc_html__("Text to show inside search option", "whmpress"),
                        "group" => esc_html__("Search", "whmpress"),

                    ),

                    "data_table" => array(
                        "vc_type" => "noyes",
                        "heading" => esc_html__("Apply DataTables", "whmpress"),
                        "description" => esc_html__("Apply DataTables on HTML table", "whmpress"),
                        "group" => esc_html__("Search", "whmpress"),

                    ),

                    "section_html" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("HTML", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "table_id" => array(
                        "hide_if_template_file" => "yes",
                        "hide_in_editor" => "yes",
                        "heading" => esc_html__("Table ID", "whmpress"),
                        "description" => esc_html__("HTML ID for table object", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),

                    ),

                    "html_id" => array(
                        "hide_if_template_file" => "yes",
                        "hide_in_editor" => "yes",
                        "heading" => esc_html__("HTML ID", "whmpress"),
                        "description" => esc_html__("ID for HTML wrapper", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "html_class" => array(
                        "value" => "whmpress whmpress_price_matrix",
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("CSS Class", "whmpress"),
                        "description" => esc_html__("CSS Class for HTML wrapper", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),
                );
                break;


            /*
        * --------------price_matrix_extended------------------
        */
            case "whmpress_price_table_extended":
            case "whmpress_price_matrix_extended":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMpress Price Matrix Extended", "whmpress"),
                    ),

                    "html_template",
                    "image",

                    "name" => array(
                        "heading" => esc_html__("Names of services to include in price matrix", "whmpress"),
                        "description" => esc_html__("Enter coma separated names of services to include in price matrix, leaving it empty will show all services.", "whmpress"),
                    ),

                    "groups" => array(
                        "heading" => esc_html__("Enter group names/ids (comma separated)", "whmpress"),
                        "description" => esc_html__("Enter coma separated names of groups to include in price matrix, leaving it empty will show all services.", "whmpress"),
                    ),

                    "show_price" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show Price", "whmpress"),
                        "description" => esc_html__("Weather to show service/package price(s) or not.", "whmpress"),
                    ),

                    "billingcycles" => array(
                        "heading" => esc_html__("Billing Cycles", "whmpress"),
                        "description" => esc_html__("Comma separated billing cycles, use from these (monthly,quarterly,semiannually,annually,biennially,triennially)", "whmpress"),
                        'dependency' => array(
                            'element' => 'show_price',
                            'value' => 'yes',
                        ),
                    ),

                    "description_columns" => array(
                        "heading" => esc_html__("Enter number of description column(s)", "whmpress"),
                        "description" => esc_html__("It will show your entered number of descriptions.", "whmpress"),
                    ),

                    "currency" => array(
                        "vc_type" => "currencies",
                        "hide_in_editor" => "yes",
                        "heading" => esc_html__("Select currency", "whmpress"),
                        "description" => esc_html__("You can override default currency here, use this option if you want to show your prices in any other currency.", "whmpress"),
                    ),

                    "order_link" => array(
                        "vc_type" => "noyes",
                        "heading" => esc_html__("Show order button", "whmpress"),
                        "description" => esc_html__("Show order button in table", "whmpress"),
                    ),

                    //--------Section-------------
                    "section1" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("Advance", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "hide_columns" => array(
                        "heading" => esc_html__("Hide Columns", "whmpress"),
                        "description" => esc_html__("Hide columns - comma seperated (e.g. sr,id,group)", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "decimals" => array(
                        "fb_type" => "decimals",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", 'whmpress'),
                            esc_html__("1", 'whmpress'),
                            esc_html__("2", 'whmpress'),
                            esc_html__("3", 'whmpress'),
                            esc_html__("4", 'whmpress'),
                        ),
                        "Heading" => esc_html__("Decimals", "whmpress"),
                        "description" => esc_html__("How many decimals to show with price", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "show_hidden" => array(
                        "vc_type" => "noyes",
                        "heading" => esc_html__("Show Hidden Services", "whmpress"),
                        "description" => esc_html__("If you want to force show services that are set as hidden in WHMCS, select YES", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "replace_zero" => array(
                        "value" => whmpress_get_option("pm_replace_zero"),
                        "heading" => esc_html__("Replace Zero With", "whmpress"),
                        "description" => esc_html__("You can replace (0) with (Free) or (-) or any thing.", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "replace_empty" => array(
                        "value" => whmpress_get_option("pm_replace_empty"),
                        "heading" => esc_html__("Replace empty with", "whmpress"),
                        "description" => esc_html__("If you have not set pricing for some billing cycle, you can set how to set it.", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "type" => array(
                        "value" => array(
                            esc_html__("Product", "whmpress") => "product",
                        ),
                        "fb_type" => "type",
                        "vc_type" => "dropdown",
                        "Heading" => esc_html__("Type", "whmpress"),
                        "description" => "",
                        "hide_in_editor" => "yes",
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    /*"titles" => array(
                        "heading" => esc_html__("Change column headers with", "whmpress"),
                        "description" => esc_html__("Comma seperated new title name (Equals number of columns)", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),*/

                    "append_order_url" => array(
                        "heading" => esc_html__("Append to Order URL", "whmpress"),
                        "description" => esc_html__("Append something to url separated by &", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    //--------Section-------------
                    "section2" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("Search Options", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "hide_search" => array(
                        "vc_type" => "noyes",
                        "heading" => esc_html__("Hide Search", "whmpress"),
                        "description" => esc_html__("Hide the search text box used to search in price matrix", "whmpress"),
                        "group" => esc_html__("Search", "whmpress"),
                    ),

                    "search_label" => array(
                        "value" => whmpress_get_option("pm_search_label"),
                        "heading" => esc_html__("Search Label", "whmpress"),
                        "description" => esc_html__("Label for search box", "whmpress"),
                        "group" => esc_html__("Search", "whmpress"),

                    ),

                    "search_placeholder" => array(
                        "value" => whmpress_get_option("pm_search_placeholder"),
                        "heading" => esc_html__("Search Placeholder", "whmpress"),
                        "description" => esc_html__("Text to show inside search option", "whmpress"),
                        "group" => esc_html__("Search", "whmpress"),

                    ),

                    /*"data_table" => array(
                        "vc_type" => "noyes",
                        "heading" => esc_html__("Apply DataTables", "whmpress"),
                        "description" => esc_html__("Apply DataTables on HTML table", "whmpress"),
                        "group" => esc_html__("Search", "whmpress"),

                    ),*/

                    "section_html" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("HTML", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "table_id" => array(
                        "hide_if_template_file" => "yes",
                        "hide_in_editor" => "yes",
                        "heading" => esc_html__("Table ID", "whmpress"),
                        "description" => esc_html__("HTML ID for table object", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),

                    ),

                    "html_id" => array(
                        "hide_if_template_file" => "yes",
                        "hide_in_editor" => "yes",
                        "heading" => esc_html__("HTML ID", "whmpress"),
                        "description" => esc_html__("ID for HTML wrapper", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "html_class" => array(
                        "value" => "whmpress whmpress_price_matrix",
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("CSS Class", "whmpress"),
                        "description" => esc_html__("CSS Class for HTML wrapper", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    //--------Section-------------
                    "section3" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("Detail Page Options", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "detail_page_billing_cycle" => array(
                        "heading" => esc_html__("Detail-page Billing Cycles", "whmpress"),
                        "description" => esc_html__("Comma separated billing cycles (use from these monthly,quarterly,semiannually,annually,biennially,triennially) will be show on detail page only", "whmpress"),
                        "group" => esc_html__("Detail Page Options", "whmpress"),
                    ),
                );
                break;

            /*
			* --------------currency_combo------------------
			*/
            case "whmpress_currency_combo":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMpress Currency Combo", "whmpress"),
                    ),

                    "html_template",
                    "image",

                    "prefix" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show prefix", "whmpress"),
                    ),

                    "combo_name" => array(
                        "heading" => esc_html__("Combo Name", "whmpress"),
                    ),

                    "append_type" => array(
                        "heading" => esc_html__("Append Type", "whmpress"),
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress")=>'numeric',
                            esc_html__("Numeric", "whmpress")=>'numeric',
                            esc_html__("Descriptive", "whmpress")=>'descriptive',
                        ),
                    ),


                    //--------Section-------------
                    "section_html" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("HTML", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "combo_class" => array(
                        "heading" => esc_html__("Combo Class", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "html_class" => array(
                        "value" => "whmpress whmpress_currency_combo",
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML Class", "whmpress"),
                        "description" => esc_html__("HTML class for container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "html_id" => array(
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML ID", "whmpress"),
                        "description" => esc_html__("HTML ID for for shortcode container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),
                );
                break;

            /*
			* --------------currency------------------
			*/
            case "whmpress_currency":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMpress Currency", "whmpress"),
                    ),

                    "html_template",
                    "image",

                    "show" => array(
                        "fb_type" => "currency_show",
                        "vc_type" => "dropdown",
                        "value" => array( //todo: will it imptect functionailly
                            esc_html__("Default", "whmpress"),
                            esc_html__("Prefix", "whmpress"),
                            esc_html__("Suffix", "whmpress"),
                            esc_html__("Code", "whmpress"),
                        ),
                        "Heading" => esc_html__("Show", "whmpress"),
                        "description" => esc_html__("Select weather you want to show prefix, postfix or code.", "whmpress"),
                    ),

                    //--------Section-------------
                    "section_html" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("HTML", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "html_class" => array(
                        "value" => "whmpress_currency",
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML Class", "whmpress"),
                        "description" => esc_html__("HTML class for container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "html_id" => array(
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML ID", "whmpress"),
                        "description" => esc_html__("HTML ID for for shortcode container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),
                );
                break;

            /*
			* --------------description------------------
			*/
            case "whmpress_description":
                return array(
                    "vc_options" => array(
                        "title" => "Description",
                    ),

                    "html_template",
                    "image",

                    "id" => array(
                        "vc_type" => "productids",
                        "heading" => esc_html__("Select Product/Service Package", "whmpress"),
                    ),

                    "show_as" => array(
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress") => "",
                            esc_html__("Unordered List", "whmpress") => "ul",
                            esc_html__("Ordered List", "whmpress") => "ol",
                            esc_html__("Simple", "whmpress") => "s",
                        ),
                        "heading" => esc_html__("Show As", "whmpress"),
                    ),

                    //--------Section-------------
                    "section_html" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("HTML", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "html_class" => array(
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML Class", "whmpress"),
                        "description" => esc_html__("HTML class for container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "html_id" => array(
                        "hide_if_template_file" => "yes",
                        "hide_in_editor" => "yes",
                        "heading" => esc_html__("HTML ID", "whmpress"),
                        "description" => esc_html__("HTML ID for for shortcode container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),
                );
                break;

            /*
			* --------------domain_search_ajax------------------
			*/
            case "whmpress_domain_search_ajax":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMpress Domain Search Ajax", "whmpress"),
                    ),

                    "html_template",
                    "image",

                    "show_price" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show price", "whmpress"),
                    ),

                    "show_years" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show years", "whmpress"),
                    ),

                    "whois_link" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show whois link", "whmpress"),
                    ),

                    "www_link" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show www link", "whmpress"),
                    ),

                    "enable_transfer_link" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show transfer link", "whmpress"),
                    ),

                    "placeholder" => array(
                        "value" => esc_html__("Type a domain to search", "whmpress"),
                        "heading" => esc_html__("Placeholder", "whmpress"),
                    ),

                    "button_text" => array(
                        "value" => esc_html__("Search", "whmpress"),
                        "heading" => esc_html__("Button text", "whmpress"),
                    ),

                    //--------Section-------------
                    "section1" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("Advance", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "disable_domain_spinning" => array(
                        "vc_type" => "noyes",
                        "heading" => esc_html__("Disable domain spinning", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "action" => array(
                        "heading" => esc_html__("Search result Div/URL", "whmpress"),
                        "description" => esc_html__("To show output in specific div, on the current page, Use #div-id<br>To show output on a different page e.g. Page-B, place same short-code on Page-B, and mentions B's URL in this field. You can use placeholder {wp-path} and it will be replaced with your site's homepage url...", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "order_landing_page" => array(
                        "fb_type" => "order_landing_page",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress") => "",
                            esc_html__("Select No of years & Additional domains first", "whmpress") => "0",
                            esc_html__("Go direct to domain settings", "whmpress") => "1",
                        ),
                        "heading" => esc_html__("Order landing page", "whmpress"),
                        "description" => esc_html__("What happens when user clicks Order button", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),

                    ),

                    "order_link_new_tab" => array(
                        "fb_type" => "order_link_new_tab",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress") => "",
                            esc_html__("Open domain link in same tab", "whmpress") => "0",
                            esc_html__("Open domain link in new tab", "whmpress") => "1",
                        ),
                        "heading" => esc_html__("Domain link in new tab", "whmpress"),
                        "description" => esc_html__("Select weather open domain link in same tab or new tab", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "search_extensions" => array(
                        "fb_type" => "search_extensions",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress") => "",
                            esc_html__("Only Listed in WHMCS", "whmpress") => "1",
                            esc_html__("All", "whmpress") => "0",
                        ),
                        "heading" => esc_html__("Search in Extensions", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "append_url" => array(
                        "value" => esc_html__("", "whmpress"),
                        "heading" => esc_html__("Append to URL", "whmpress"),
                        "description" => esc_html__("If you want to append some thing to domain order URL, for example package to add with domain registration", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),

                    ),


                    //--------Section-------------
                    "section_html" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("HTML", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "text_class" => array(
                        "heading" => esc_html__("Text class", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "button_class" => array(
                        "heading" => esc_html__("Button class", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "html_class" => array(
                        "value" => "whmpress whmpress_domain_search_ajax",
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML Class", "whmpress"),
                        "description" => esc_html__("HTML class for shortcode container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "html_id" => array(
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML ID", "whmpress"),
                        "description" => esc_html__("HTML ID for for shortcode container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                );
                break;

            /*
            * --------------domain_search_ajax_extended------------------
            */
            case "whmpress_domain_search_ajax_extended":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMpress Domain Search AJAX Extended", "whmpress"),
                    ),

                    "html_template",
                    "image",

                    "show_price" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show price", "whmpress"),
                    ),

                    "show_years" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show years", "whmpress"),
                    ),

                    "whois_link" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show whois link", "whmpress"),
                    ),

                    "www_link" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show www link", "whmpress"),
                    ),

                    "enable_transfer_link" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show transfer link", "whmpress"),
                    ),

                    "placeholder" => array(
                        "value" => esc_html__("Type a domain to search", "whmpress"),
                        "heading" => esc_html__("Placeholder", "whmpress"),
                    ),

                    "button_text" => array(
                        "value" => esc_html__("Search", "whmpress"),
                        "heading" => esc_html__("Button text", "whmpress"),
                    ),

                    //--------Section-------------
                    "section1" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("Advance", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "disable_domain_spinning" => array(
                        "vc_type" => "noyes",
                        "heading" => esc_html__("Disable domain spinning", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "filter_tlds" => array(
                        "heading" => esc_html__("Filter TLDs", "whmpress"),
                        "description" => esc_html__("Enter comma separated domains without dot (.) to show specific tlds in dropdown.", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "action" => array(
                        "heading" => esc_html__("Search result URL", "whmpress"),
                        "description" => esc_html__("To show output on a different page e.g. Page-B, place same short-code on Page-B, and mentions B's URL in this field.", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "order_link_new_tab" => array(
                        "fb_type" => "order_link_new_tab",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress") => "",
                            esc_html__("Open domain link in same tab", "whmpress") => "0",
                            esc_html__("Open domain link in new tab", "whmpress") => "1",
                        ),
                        "heading" => esc_html__("Domain link in new tab", "whmpress"),
                        "description" => esc_html__("Select weather open domain link in same tab or new tab", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),

                    ),


                    //--------Section-------------
                    "section_html" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("HTML", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "text_class" => array(
                        "heading" => esc_html__("Text class", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "button_class" => array(
                        "heading" => esc_html__("Button class", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "html_class" => array(
                        "value" => "whmpress whmpress_domain_search_ajax",
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML Class", "whmpress"),
                        "description" => esc_html__("HTML class for shortcode container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "html_id" => array(
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML ID", "whmpress"),
                        "description" => esc_html__("HTML ID for for shortcode container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                );
                break;

            /*
            * --------------domain_search_bulk------------------
            */
            case "whmpress_domain_search_bulk":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMpress Domain Search Bulk", "whmpress"),
                    ),

                    "html_template",
                    //todo how to fetch default values of search boxes to show
                    "button_text" => array(
                        "value" => esc_html__("Search", "whmpress"),
                    ),

                    "placeholder" => array(
                        "value" => "",
                        "heading" => esc_html__("Placeholder", "whmpress"),
                    ),

                    "show_price" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show price", "whmpress"),
                    ),

                    "show_years" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show years", "whmpress"),
                    ),

                    "whois_link" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show whois link", "whmpress"),
                    ),

                    "action" => array(
                        "heading" => esc_html__("Search result URL", "whmpress"),
                        "description" => esc_html__("To show output in specific div, on the current page, Use #div-id<br>To show output on a different page e.g. Page-B, place same short-code on Page-B, and mentions B's URL in this field. You can use placeholder {wp-path} and it will be replaced with your site's homepage url...", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "www_link" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show www link", "whmpress"),
                    ),

                    "order_link_new_tab" => array(
                        "fb_type" => "order_link_new_tab",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress") => "",
                            esc_html__("Open domain link in same tab", "whmpress") => "0",
                            esc_html__("Open domain link in new tab", "whmpress") => "1",
                        ),
                        "heading" => esc_html__("Domain link in new tab", "whmpress"),
                        "description" => esc_html__("Select weather open domain link in same tab or new tab", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),

                    ),

                    "enable_transfer_link" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show transfer link", "whmpress"),
                    ),

                    "append_url" => array(
                        "value" => esc_html__("", "whmpress"),
                        "heading" => esc_html__("Append to URL", "whmpress"),
                        "description" => esc_html__("If you want to append some thing to domain order URL, for example package to add with domain registration", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),

                    ),

                    //--------Section-------------
                    "section_html" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("HTML", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "text_class" => array(
                        "heading" => "Text class",
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "button_class" => array(
                        "heading" => esc_html__("Button class", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "html_id" => array(
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML ID", "whmpress"),
                        "description" => esc_html__("HTML ID for for shortcode container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "html_class" => array(
                        "value" => "whmpress whmpress_domain_search_bulk",
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML Class", "whmpress"),
                        "description" => esc_html__("HTML class for shortcode container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),
                );
                break;

            /*
			* --------------domain_search------------------
			*/
            case "whmpress_domain_search":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMpress Domain Search", "whmpress"),
                    ),

                    "html_template",
                    "image",

                    "show_combo" => array(
                        "vc_type" => "noyes",
                        "heading" => "Show combo",
                    ),

                    "placeholder" => array(
                        "heading" => esc_html__("Placeholder for domain search", "whmpress"),
                        "description" => esc_html__("Enter text to show as place holder in domain search box.", "whmpress"),
                    ),

                    "button_text" => array(
                        "value" => "",
                        "heading" => esc_html__("Button text", "whmpress"),
                    ),

                    //--------Section-------------
                    "section1" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("Advance", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "show_tlds" => array(
                        "value" => "",
                        "heading" => esc_html__("TLDs to show (comma separated)", "whmpress"),
                        "description" => esc_html__("Weather to show available TLDs in combo", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "show_tlds_wildcard" => array(
                        "heading" => esc_html__("TLDs to show (wildcard)", "whmpress"),
                        "description" => esc_html__("Provide tld search as wildcard, e.g. pk for all .pk domains or co for all com and .co domains", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "action" => array(
                        "hide_in_vc" => "yes",
                        "hide_in_editor" => "yes",
                        "heading" => esc_html__("Search result URL", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "token" => array(
                        "value" => "",
                        "heading" => esc_html__("Token code", "whmpress"),
                        "description" => esc_html__("This code is required if you have enabled Captcha on your WHMCS search, and you want to skip captcha using this form...", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),


                    //--------Section-------------
                    "section_html" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("HTML", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "text_class" => array(
                        "heading" => esc_html__("Text class", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "combo_class" => array(
                        "heading" => esc_html__("Combo class", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "button_class" => array(
                        "heading" => esc_html__("Button class", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "html_class" => array(
                        "value" => "whmpress whmpress_domain_search",
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML class", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "html_id" => array(
                        "hide_if_template_file" => "yes",
                        "hide_in_editor" => "yes",
                        "heading" => esc_html__("HTML id", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),
                );
                break;

            /*
			* --------------login_form------------------
			*/
            case "whmpress_login_form":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("Login Form", "whmpress"),
                    ),

                    "html_template",
                    "image",

                    "button_text" => array(
                        "value" => "",
                        "heading" => esc_html__("Button text", "whmpress"),
                        "description" => esc_html__("Text to show on login button", "whmpress"),
                    ),

                    //--------Section-------------
                    "section_html" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("HTML", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "button_class" => array(
                        "heading" => esc_html__("Button class", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "html_class" => array(
                        "value" => "whmpress whmpress_login_form",
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML Class", "whmpress"),
                        "description" => esc_html__("HTML class for shortcode container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),

                    ),

                    "html_id" => array(
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML ID", "whmpress"),
                        "description" => esc_html__("HTML ID for for shortcode container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),

                    ),
                );
                break;

            /*
			* --------------name------------------
			*/

            case "whmpress_name":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("Name", "whmpress"),
                    ),

                    "html_template",
                    "image",

                    "id" => array(
                        "vc_type" => "productids",
                        "heading" => esc_html__("Select Product/Service Package", "whmpress"),
                    ),

                    //--------Section-------------
                    "section_html" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("HTML", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "html_class" => array(
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML Class", "whmpress"),
                        "description" => esc_html__("HTML class for shortcode container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),

                    ),

                    "html_id" => array(
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML ID", "whmpress"),
                        "description" => esc_html__("HTML ID for for shortcode container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),
                );
                break;

            /*
			* --------------order_button------------------
			*/
            case "whmpress_order_button":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMpress Order Button", "whmpress"),
                    ),

                    "html_template",
                    "image",

                    "id" => array(
                        "vc_type" => "productids",
                        "heading" => esc_html__("Select Product/Service Package", "whmpress"),
                    ),

                    "billingcycle" => array(
                        "vc_type" => "dropdown",
                        "value" => "billing_cycle",
                        "heading" => esc_html__("Billing cycle", "whmpress"),
                        "description" => esc_html__("Order will be placed for selected billing cycle.", "whmpress"),
                    ),

                    "button_text" => array(
                        "value" => whmpress_get_option("ob_button_text"),
                    ),

                    //--------Section-------------
                    "section1" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("Advance", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "currency" => array(
                        "vc_type" => "currencies",
                        "hide_in_editor" => "yes",
                        "heading" => esc_html__("Currency Override", "whmpress"),
                        "description" => esc_html__("Used with multi currency, If you want to generate order button with a currency other than default.", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "params" => array(
                        "value" => "",
                        "heading" => esc_html__("Additional parameters for order URL", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    //--------Section-------------
                    "section1" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("HTML", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "html_class" => array(
                        "value" => "whmpress_order_button",
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML Class", "whmpress"),
                        "description" => esc_html__("HTML class for shortcode container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "html_id" => array(
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML ID", "whmpress"),
                        "description" => esc_html__("HTML ID for for shortcode container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),
                );
                break;

            /*
			* --------------order_combo------------------
			*/
            case "whmpress_order_combo":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMpress Order Combo", "whmpress"),
                    ),

                    "html_template",
                    "image",

                    "id" => array(
                        "vc_type" => "productids",
                        "heading" => esc_html__("Select Product/Service Package", "whmpress"),
                    ),

                    "show_button" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show Button", "whmpress"),
                        "description" => esc_html__("Weather to show order button or not.", "whmpress"),
                    ),

                    "button_text" => array(
                        "heading" => esc_html__("Button Text", "whmpress"),
                        "description" => esc_html__("Text to show on button", "whmpress"),
                        "value" => whmpress_get_option("combo_button_text"),
                    ),

                    //"rows" => array("hide_if_template_file"=>"yes","vc_type"=>"dropdown","value"=>array("Default","1","2")),
                    "show_discount" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show Discount", "whmpress"),
                        "description" => esc_html__("Weather to show auto calculate discount or not. Default is (yes)", "whmpress"),
                    ),

                    "discount_type" => array(
                        "fb_type" => "discount_type",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress") => "",
                            esc_html__("%age", "whmpress") => "yearly",
                            esc_html__("Calculated Monthly Price", "whmpress") => "monthly",
                        ),
                        "heading" => esc_html__("Discount type (in %age or Calculated Monthly Price)", "whmpress"),
                        "description" => esc_html__("monthly: Show discount as Calculated monthly Price.<br />Yearly: Show discount in %age.", "whmpress"),
                    ),

                    //todo:strrp html tags while passing to editor

                    "billingcycles" => array(
                        "heading" => esc_html__("Billing Cycles", "whmpress"),
                        "description" => esc_html__("Billing cycle to include in combo, comma separated with one of these, one-time, monthly, quarterly, semi-annually, annually, biennially, triennially. If skipped all will be included.", "whmpress"),
                    ),

                    "params" => array(
                        "value" => "",
                        "heading" => esc_html__("Additional parameters for order URL", "whmpress"),
                    ),

                    //--------Section-------------
                    "section1" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("Price Display Options", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "prefix" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show currency prefix", "whmpress"),
                        "description" => esc_html__("Weather to show currency prefix or not", "whmpress"),
                        "group" => esc_html__("Price Display Options", "whmpress"),
                    ),

                    "suffix" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show currency suffix", "whmpress"),
                        "description" => esc_html__("Weather to show currency suffix or not", "whmpress"),
                        "group" => esc_html__("Price Display Options", "whmpress"),
                    ),

                    "currency" => array(
                        "vc_type" => "currencies",
                        "heading" => esc_html__("Select currency", "whmpress"),
                        "hide_in_editor" => "yes",
                        "group" => esc_html__("Price Display Options", "whmpress"),
                    ),

                    "decimals" => array(
                        "fb_type" => "decimals",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", 'whmpress'),
                            esc_html__("1", 'whmpress'),
                            esc_html__("2", 'whmpress'),
                            esc_html__("3", 'whmpress'),
                            esc_html__("4", 'whmpress'),
                        ),
                        "Heading" => esc_html__("Decimals", "whmpress"),
                        "description" => esc_html__("How many decimals to show with price", "whmpress"),
                        "group" => esc_html__("Price Display Options", "whmpress"),
                    ),

                    //--------Section-------------
                    "section_html" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("HTML", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "combo_class" => array(
                        "hide_in_editor" => "yes",
                        "heading" => esc_html__("Combo Class", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "button_class" => array(
                        "heading" => esc_html__("Button Class", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "html_class" => array(
                        "value" => "whmpress whmpress_order_combo",
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML Class", "whmpress"),
                        "description" => esc_html__("HTML class for shortcode container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "html_id" => array(
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML ID", "whmpress"),
                        "description" => esc_html__("HTML ID for for shortcode container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),
                );
                break;

            /*
			* --------------order_link------------------
			*/
            case "whmpress_order_link":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMpress Order Link", "whmpress"),
                    ),

                    "html_template",
                    "image",

                    "id" => array(
                        "vc_type" => "productids",
                        "heading" => esc_html__("Select Product/Service Package", "whmpress"),
                    ),

                    "billingcycle" => array(
                        "vc_type" => "dropdown",
                        "value" => "billing_cycle",
                        "heading" => esc_html__("Billing cycle", "whmpress"),
                    ),

                    "link_text" => array(
                        "value" => whmpress_get_option("ol_link_text"),
                    ),

                    "currency" => array(
                        "vc_type" => "currencies",
                        "heading" => esc_html__("Select currency", "whmpress"),
                        "hide_in_editor" => "yes",
                    ),

                    //--------Section-------------
                    "section1" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("HTML", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "html_class" => array(
                        "value" => "whmpress_order_link",
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML Class", "whmpress"),
                        "description" => esc_html__("HTML class for shortcode container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),

                    ),

                    "html_id" => array(
                        "hide_if_template_file" => "yes",
                        "hide_in_editor" => "yes",
                        "heading" => esc_html__("HTML ID", "whmpress"),
                        "description" => esc_html__("HTML ID for for shortcode container", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),
                );
                break;

            /*
			* --------------order_url------------------
			*/
            case "whmpress_order_url":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMpress Order URL", "whmpress"),
                    ),
                    "html_template",

                    "id" => array(
                        "vc_type" => "productids",
                        "heading" => esc_html__("Select Product/Service Package", "whmpress"),
                    ),

                    "billingcycle" => array(
                        "vc_type" => "dropdown",
                        "value" => "billing_cycle",
                        "heading" => esc_html__("Billing cycle", "whmpress"),
                    ),

                    "currency" => array(
                        "vc_type" => "currencies",
                        "heading" => esc_html__("Select currency", "whmpress"),
                        "hide_in_editor" => "yes",
                    ),
                );
                break;

            /*
			* --------------price_box------------------
			*/
            // todo:can enable if needed, do not show in front end at the moment
            case "whmpress_price_box":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMpress Price Box", "whmpress"),
                    ),

                    "html_template",
                    "image",

                    "id" => array(
                        "vc_type" => "productids",
                        "heading" => esc_html__("Select Product/Service Package", "whmpress"),
                    ),

                    "billingcycle" => array(
                        "vc_type" => "dropdown",
                        "value" => "billing_cycle",
                        "heading" => esc_html__("Billing cycle", "whmpress"),
                    ),

                    "show_price" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show price", "whmpress"),
                        "description" => esc_html__("Weather to show service/package price or not.", "whmpress"),
                    ),

                    "show_combo" => array(
                        "vc_type" => "noyes",
                        "heading" => esc_html__("Show order combo", "whmpress"),
                        "description" => esc_html__("Weather to show billingcycle combo to select duration.", "whmpress"),
                    ),

                    //"button_html_template" => array("vc_type"=>"textfield"),
                    "show_description" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show Description", "whmpress"),
                        "description" => esc_html__("Show package details", "whmpress"),
                    ),

                    "show_button" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show order button", "whmpress"),
                        "description" => esc_html__("Show Order Button > Weather to show order button or not.", "whmpress"),
                    ),

                    "button_text" => array(
                        "value" => "",
                        "heading" => esc_html__("Button Text", "whmpress"),
                    ),

                    //--------Section-------------
                    "section1" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("Advance", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "currency" => array(
                        "vc_type" => "currencies",
                        "hide_in_editor" => "yes",
                        "heading" => esc_html__("Select currency", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "show_discount" => array(
                        "vc_type" => "yesno",
                        "hading" => esc_html__("Show Discount", "whmpress"),
                        "description" => esc_html__("Weather to show auto calculate discount or not. Default is <b>yes</b>", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "discount_type" => array(
                        "fb_type" => "price_box_discount_type",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress") => "",
                            esc_html__("Yearly", "whmpress") => "yearly",
                            esc_html__("Monthly", "whmpress") => "monthly",
                        ),
                        "heading" => esc_html__("Discount type (Monthly or Yearly)", "whmpress"),
                        "description" => esc_html__("monthly: Additionally shows calculated monthly price with multiyear prices.<br />Yearly: Additionally shows calculated discount in % with multiyear prices.", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    //--------Section-------------
                    "section_html" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("HTML", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "html_class" => array(
                        "value" => "whmpress whmpress_price_box",
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML Class", "whmpress"),
                        "description" => esc_html__("HTML class for shortcode container", "whmpress"),
                    ),

                    "html_id" => array(
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML ID", "whmpress"),
                        "description" => esc_html__("HTML ID for for shortcode container", "whmpress"),
                    ),
                );
                break;

            /*
			* --------------price------------------
			*/
            case "whmpress_price":
                return array(
                    "vc_options" => array("title" => "WHMpress Price"),
                    "html_template",
                    "image",

                    "id" => array(
                        "vc_type" => "productids",
                        "heading" => esc_html__("Product/Service Package", 'whmpress'),
                        "descripiton" => esc_html__(' Select WHMCS Product/Service', 'whmpress'),
                    ),

                    "billingcycle" => array(
                        "vc_type" => "dropdown",
                        "value" => "billing_cycle",
                        "heading" => esc_html__("Billing cycle", 'whmpress'),
                        "description" => esc_html__("Select a billing cycle to show price for", 'whmpress'),
                    ),

                    "currency" => array(
                        "vc_type" => "currencies",
                        "heading" => "Currency",
                    ),      // "hide_in_editor"=>"yes"


                    //--------Section-------------
                    "section1" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("Price Display Options", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "show_duration" => array(
                        "fb_type" => "show_duration",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress") => "",
                            esc_html__("Do not show duration", "whmpress") => "No",
                            esc_html__("==No Tag==", "whmpress") => "-",
                            esc_html__("Bold", "whmpress") => "b",
                            esc_html__("Italic", "whmpress") => "i",
                            esc_html__("Underline", "whmpress") => "u",
                            esc_html__("Superscript", "whmpress") => "sup",
                            esc_html__("Subscript", "whmpress") => "sub",
                        ),
                        "heading" => esc_html__("Show Duration/Billing Cycle", "whmpress"),
                        "description" => esc_html__("Select how you want to show duration (billing cycle) with price", "whmpress"),
                        "group" => esc_html__("Price Display Options", "whmpress"),
                    ),

                    "show_duration_as" => array(
                        "fb_type" => "duration_style",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress") => "",
                            esc_html__("Long (Year)", "whmpress") => "long",
                            esc_html__("Short (Yr)", "whmpress") => "short",
                            esc_html__(" Long 2 (1 Year)", "whmpress") => "duration2",
                            esc_html__(" In Months (12 Months)", "whmpress") => "monthly",

                        ),
                        "heading" => esc_html__("Duration Style", "whmpress"),
                        "description" => esc_html__("Long (Year) or Short(yr)", "whmpress"),
                    ),

                    "prefix" => array(
                        "fb_type" => "currency_prefix",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress") => "",
                            esc_html__("Do not show prefix", "whmpress") => "No",
                            esc_html__("==No Tag==", "whmpress") => "-",
                            esc_html__("Bold", "whmpress") => "b",
                            esc_html__("Italic", "whmpress") => "i",
                            esc_html__("Underline", "whmpress") => "u",
                            esc_html__("Superscript", "whmpress") => "sup",
                            esc_html__("Subscript", "whmpress") => "sub",
                        ),
                        "heading" => esc_html__("Show Currency Prefix", "whmpress"),
                        "description" => esc_html__("Select how you want currency symbol to show", "whmpress"),
                        "group" => esc_html__("Price Display Options", "whmpress"),
                    ),

                    "suffix" => array(
                        "fb_type" => "currency_sufix",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress") => "",
                            esc_html__("Do not show suffix", "whmpress") => "No",
                            esc_html__("==No Tag==", "whmpress") => "-",
                            esc_html__("Bold", "whmpress") => "b",
                            esc_html__("Italic", "whmpress") => "i",
                            esc_html__("Underline", "whmpress") => "u",
                            esc_html__("Superscript", "whmpress") => "sup",
                            esc_html__("Subscript", "whmpress") => "sub",
                        ),
                        "heading" => esc_html__("Show Currency Suffix", "whmpress"),
                        "description" => esc_html__("Select how you want currency symbol to show", "whmpress"),
                        "group" => esc_html__("Price Display Options", "whmpress"),
                    ),

                    "hide_decimal" => array(
                        "vc_type" => "noyes",
                        "heading" => esc_html__("Hide decimal symbol", 'whmpress'),
                        "description" => esc_html__("Show price decimal symbol or not", 'whmpress'),
                        "group" => esc_html__('Price Display Options', 'whmpress'),
                    ),

                    "decimals" => array(
                        "fb_type" => "decimals",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", 'whmpress'),
                            esc_html__("1", 'whmpress'),
                            esc_html__("2", 'whmpress'),
                            esc_html__("3", 'whmpress'),
                            esc_html__("4", 'whmpress'),
                        ),
                        "Heading" => esc_html__("Decimals", "whmpress"),
                        "description" => esc_html__("How many decimals to show with price", "whmpress"),
                        "group" => esc_html__("Price Display Options", "whmpress"),
                    ),

                    "decimals_tag" => array(
                        "fb_type" => "decimal_tag",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress") => "",
                            esc_html__("==No Tag==", "whmpress") => "-",
                            esc_html__("Bold", "whmpress") => "b",
                            esc_html__("Italic", "whmpress") => "i",
                            esc_html__("Underline", "whmpress") => "u",
                            esc_html__("Superscript", "whmpress") => "sup",
                            esc_html__("Subscript", "whmpress") => "sub",
                        ),
                        "heading" => esc_html__("Decimals value format", "whmpress"),
                        "description" => esc_html__("Select decimals value to show", "whmpress"),
                        "group" => esc_html__("Price Display Options", "whmpress"),
                    ),

                    //--------- Section ------------
                    "section2" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("Calculations..", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "price_type" => array(
                        "fb_type" => "price_type",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress") => "",
                            esc_html__("Price", "whmpress") => "price",
                            esc_html__("Setup Fee", "whmpress") => "setup",
                            esc_html__("Price + Setup Fee", "whmpress") => "total",
                        ),
                        "heading" => esc_html__("Setup", "whmpress"),
                        "group" => esc_html__("Calculations", "whmpress"),
                    ),

                    "configureable_options" => array(
                        "vc_type" => "noyes",
                        "heading" => esc_html__("Calculate configurable options", "whmpress"),
                        "description" => esc_html__("Calculate configureable options and addon price", "whmpress"),
                        "group" => esc_html__("Calculations", "whmpress"),
                    ),

                    "config_option_string" => array(
                        "value" => "",
                        "heading" => esc_html__("String for config price", "whmpress"),
                        "description" => esc_html__("Prefix text to add if price is from configurable options", "whmpress"),
                        "group" => esc_html__("Calculations", "whmpress"),
                    ),

                    "price_tax" => array(
                        "fb_type" => "price_tax",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress") => "",
                            esc_html__("WHMCS Default", "whmpress") => "default",
                            esc_html__("Inclusive Tax", "whmpress") => "inclusive",
                            esc_html__("Exclusive Tax", "whmpress") => "exclusive",
                            esc_html__("Tax Only", "whmpress") => "tax",
                        ),
                        "heading" => esc_html__("Tax", "whmpress"),
                        "description" => esc_html__("Retrun price inclusive of tax, or without tax ", "whmpress"),
                        "group" => esc_html__("Calculations", "whmpress"),
                    ),

                    "convert_monthly" => array(
                        "vc_type" => "noyes",
                        "heading" => esc_html__("Convert price into monthly price", "whmpress"),
                        "description" => esc_html__("convert price into monthly price > example: If you have selected yearly price and select this option as yes, it will return (yearly price/12)", "whmpress"),
                        "group" => esc_html__("Price Display Options", "whmpress"),
                    ),

                    "section3" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("Other", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "no_wrapper" => array(
                        "vc_type" => "noyes",
                        "heading" => esc_html__("No wrapper", "whmpress"),
                        "description" => esc_html__("If you want price without any html (usually used withing text/contents), choose Yes", "whmpress"),
                    ),

                    "html_class" => array(
                        "value" => "whmpress whmpress_price",
                        "description" => "HTML class for container",
                        "hide_if_template_file" => "yes",
                    ),

                    "html_id" => array(
                        "hide_if_template_file" => "yes",
                        "hide_in_editor" => "yes",
                    ),
                );
                break;

            /*
			* --------------domain_price------------------
			*/
            case "whmpress_domain_price":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMpress Domain Price", "whmpress"),
                    ),
                    "html_template",

                    "tld" => array(
                        "value" => ".com",
                        "heading" => esc_html__("Domain TLD", "whmpress"),
                        "descripiton" => esc_html__("Enter Domain extension/ TLD name to return price for", "whmpress"),
                    ),

                    "type" => array(
                        "fb_type" => "domain_type",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress") => "",
                            esc_html__("Domain Registration", "whmpress") => "domainregister",
                            esc_html__("Domain Renew", "whmpress") => "domainrenew",
                            esc_html__("Domain Transfer", "whmpress") => "domaintransfer",
                        ),
                        "description" => esc_html__("Return Registration/Renew or Domain Price", "whmpress"),
                    ),

                    "years" => array(
                        "fb_type" => "years",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress"),
                            esc_html__("1", "whmpress"),
                            esc_html__("2", "whmpress"),
                            esc_html__("3", "whmpress"),
                            esc_html__("4", "whmpress"),
                            esc_html__("5", "whmpress"),
                            esc_html__("6", "whmpress"),
                            esc_html__("7", "whmpress"),
                            esc_html__("8", "whmpress"),
                            esc_html__("9", "whmpress"),
                            esc_html__("10", "whmpress"),
                        ),
                    ),

                    "currency" => array(
                        "vc_type" => "currencies",
                        "heading" => esc_html__("Currency Override", "whmpress"),
                        "description" => esc_html__("Used with multi currency, If you want to generate order button with a currency other than default", "whmpress"),
                    ),

                    //--------Section-------------
                    "section1" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("Price Display Options", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "show_duration" => array(
                        "fb_type" => "show_duration",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress") => "",
                            esc_html__("Yes", "whmpress") => "Yes",
                            esc_html__("Do not show duration", "whmpress") => "No",
                            esc_html__("Bold", "whmpress") => "b",
                            esc_html__("Italic", "whmpress") => "i",
                            esc_html__("Underline", "whmpress") => "u",
                            esc_html__("Superscript", "whmpress") => "sup",
                            esc_html__("Subscript", "whmpress") => "sub",
                        ),
                        "heading" => esc_html__("Show number of years", "whmpress"),
                        "description" => esc_html__("Select how you want to show duration (billing cycle) with price", "whmpress"),
                        "group" => esc_html__("Price Display Options", "whmpress"),
                    ),

                    "prefix" => array(
                        "fb_type" => "currency_prefix",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress") => "",
                            esc_html__("Yes", "whmpress") => "Yes",
                            esc_html__("Do not show prefix", "whmpress") => "No",
                            esc_html__("Bold", "whmpress") => "b",
                            esc_html__("Italic", "whmpress") => "i",
                            esc_html__("Underline", "whmpress") => "u",
                            esc_html__("Superscript", "whmpress") => "sup",
                            esc_html__("Subscript", "whmpress") => "sub",
                        ),
                        "heading" => esc_html__("Show Currency Preffix", "whmpress"),
                        "description" => esc_html__("Select how you want currency symbol to show", "whmpress"),
                        "group" => esc_html__("Price Display Options", "whmpress"),
                    ),

                    "suffix" => array(
                        "fb_type" => "currency_sufix",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress") => "",
                            esc_html__("Do not show suffix", "whmpress") => "No",
                            esc_html__("Yes", "whmpress") => "Yes",
                            esc_html__("Bold", "whmpress") => "b",
                            esc_html__("Italic", "whmpress") => "i",
                            esc_html__("Underline", "whmpress") => "u",
                            esc_html__("Superscript", "whmpress") => "sup",
                            esc_html__("Subscript", "whmpress") => "sub",
                        ),
                        "heading" => esc_html__("Show Currency Suffix", "whmpress"),
                        "description" => esc_html__("Select how you want currency symbol to show", "whmpress"),
                        "group" => esc_html__("Price Display Options", "whmpress"),
                    ),

                    "decimals" => array(
                        "fb_type" => "decimals",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress"),
                            esc_html__("1", "whmpress"),
                            esc_html__("2", "whmpress"),
                            esc_html__("3", "whmpress"),
                            esc_html__("4", "whmpress"),
                        ),
                        "Heading" => esc_html__("Decimals", "whmpress"),
                        "description" => esc_html__("How many decimals to show with price", "whmpress"),
                        "group" => esc_html__("Price Display Options", "whmpress"),
                    ),

                    "duration_style" => array(
                        "fb_type" => "domain_duratin_style",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress") => "",
                            esc_html__("Long (Year)", "whmpress") => "long",
                            esc_html__("Short (Yr)", "whmpress") => "short",

                        ),
                        "heading" => esc_html__("Duration Style", "whmpress"),
                        "description" => esc_html__("Long (Year) or Short(yr)", "whmpress"),
                    ),

                    "hide_decimal" => array(
                        "vc_type" => "noyes",
                        "heading" => esc_html__("Hide decimal symbol", "whmpress"),
                        "description" => esc_html__("Show price decimal symbol or not", 'whmpress'),
                        "group" => esc_html__('Price Display Options', 'whmpress'),
                    ),

                    "decimals_tag" => array(
                        "fb_type" => "domain_decimal_tag",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress") => "",
                            esc_html__("Italic", "whmpress") => "i",
                            esc_html__("Underline", "whmpress") => "u",
                            esc_html__("Superscript", "whmpress") => "sup",
                            esc_html__("Subscript", "whmpress") => "sub",
                        ),
                        "heading" => esc_html__("Decimals value format", "whmpress"),
                        "description" => esc_html__("Select decimals value to show", "whmpress"),
                        "group" => esc_html__('Price Display Options', 'whmpress'),
                    ),

                    //--------Section-------------
                    "section2" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("Calculations", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "price_tax" => array(
                        "fb_type" => "price_tax",
                        "heading" => esc_html__("Price/Tax", "whmpress"),
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", "whmpress") => "",
                            esc_html__("WHMCS Default", "whmpress") => "default",
                            esc_html__("Inclusive Tax", "whmpress") => "inclusive",
                            esc_html__("Exclusive Tax", "whmpress") => "exclusive",
                            esc_html__("Tax Only", "whmpress") => "tax",
                        ),
                        "group" => esc_html__("Calculations", "whmpress"),
                    ),

                    //--------Section-------------
                    "section3" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("HTML", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "html_class" => array(
                        "value" => "whmpress whmpress_domain_price",
                        "Heading" => esc_html__("HTML Class", "whmpress"),
                        "description" => esc_html__("HTML class for container", "whmpress"),
                        "hide_if_template_file" => "yes",
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "html_id" => array(
                        "hide_if_template_file" => "yes",
                        "hide_in_editor" => "yes",
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                );
                break;

            /*
			 * --------------price_matrix_domain------------------
			 */
            case "whmpress_price_table_domain":
            case "whmpress_price_matrix_domain":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMpress Price Matrix Domain", "whmpress"),
                    ),

                    "html_template",
                    "image",


                    "currency" => array(
                        "vc_type" => "currencies",
                        "heading" => esc_html__("Select currency", 'whmpress'),
                        "description" => "",
                    ),

                    "show_renewel" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show Renewal Price", 'whmpress'),
                        "description" => esc_html__("Weather to show domain renewal price", 'whmpress'),
//                        'dependency' => array(
//                            'element' => 'style1',
//                            'value' => array('Default'),
//                        ),

                    ),

                    "show_transfer" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show Transfer Price", 'whmpress'),
                        "description" => esc_html__("Weather to show domain transfer price", 'whmpress'),
//                        'dependency' => array(
//                            'element' => 'style1',
//                            'value' => array('Default'),
//                        ),
                    ),


                    //--------Section-------------
                    "section1" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("Styles", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "style1" => array(
                        "heading" => esc_html__("Style", "whmpress"),
                        "vc_type" => "dropdown",
                        "description" => esc_html__("Style Default: offers you extended control on how you want to show prices, New settings will appear in Extended Tab. Other styles: offers you specific set of data, you may choose one to suit your needs. NOTE: Options in Advance section only work with default style.", "whmpress"),
                        "value" => array(
                            esc_html__("Default", "whmpress"),
                            esc_html__("style_1", "whmpress"),
                            esc_html__("style_2", "whmpress"),
                            esc_html__("Muliti_year_register", "whmpress"),
                            esc_html__("Muliti_year_renew", "whmpress"),
                            esc_html__("Muliti_year_transfer", "whmpress"),
                        ),
                        "group" => esc_html__("Style", "whmpress"),
                    ),

                    "show_addons" => array(
                        "heading" => esc_html__("Show addon prices", "whmpress"),
                        "vc_type" => "noyes",
//                        'dependency' => array(
//                            'element' => 'style1',
//                            'value' => array(
//                                "style_1",
//                                "style_2",
//                                "Muliti_year_register",
//                                "Muliti_year_renew",
//                                "Muliti_year_transfer",
//                            ),
//                        ),
                        "group" => esc_html__("Style", "whmpress"),
                    ),

                    "show_type" => array(
                        "heading" => esc_html__("Show category/type", "whmpress"),
                        "vc_type" => "noyes",
                        "group" => esc_html__("Style", "whmpress"),
                    ),

                    "show_restore" => array(
                        "heading" => esc_html__("Show Restore Price", "whmpress"),
                        "vc_type" => "noyes",
                        "group" => esc_html__("Style", "whmpress"),
                    ),

                    // Removed from 1.5.4
                    //"cols" => array("heading"=>"Number of columns","vc_type"=>"dropdown","value"=>array("1","2","3","4","5","6"),"description"=>"","hide_if_template_file"=>"yes"),


                    //--------Section-------------
                    "section2" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("Search", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "hide_search" => array(
                        "heading" => "Show Search Box",
                        "vc_type" => "yesno",
                        "description" => esc_html__("Check this option to show search box", 'whmpress'),
                        "group" => esc_html__("Search", "whmpress"),
                    ),

                    "search_label" => array(
                        "value" => whmpress_get_option("pmd_search_label"),
                        "heading" => esc_html__("Search Label", 'whmpress'),
                        "description" => "",

//                        'dependency' => array(
//                            'element' => 'hide_search',
//                            'value' => array('yes'),
//                        ),
                        "group" => esc_html__("Search", "whmpress"),
                    ),

                    "search_placeholder" => array(
                        "value" => whmpress_get_option("pmd_search_placeholder"),
                        "description" => "",
                        "heading" => esc_html__("Search placeholder", 'whmpress'),
//                        'dependency' => array(
//                            'element' => 'hide_search',
//                            'value' => array('yes'),
//                        ),
                        "group" => esc_html__("Search", "whmpress"),
                    ),

                    "data_table" => array(
                        "vc_type" => "noyes",
                        "heading" => esc_html__("Apply DataTables", 'whmpress'),
                        "description" => esc_html__("Apply DataTables on HTML table", 'whmpress'),
                        "group" => esc_html__("Extended", 'whmpress'),
//                        'dependency' => array(
//                            'element' => 'style1',
//                            'value' => array('Default'),
//                        ),
                        "group" => esc_html__("Search", "whmpress"),
                    ),

                    //--------Section-------------
                    "section_advance" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("Advance", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "show_tlds" => array(
                        "heading" => esc_html__("Show TLDs", 'whmpress'),
                        "description" => esc_html__("comma separated values of tlds to to list in table. Only tlds that exists in WHMCS will be added. No spaces in comma separated values.", 'whmpress'),
                        "group" => esc_html__("Extended", 'whmpress'),
//                        'dependency' => array(
//                            'element' => 'style1',
//                            'value' => array('Default'),
//                        ),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "show_tlds_wildcard" => array(
                        "heading" => esc_html__("Show TLDs Wildcard", 'whmpress'),
                        "description" => esc_html__("Show only tlds matching with given string. Very useful if you want to show only tlds related to your country, e.g. .in", 'whmpress'),
                        "group" => esc_html__("Extended", 'whmpress'),
//                        'dependency' => array(
//                            'element' => 'style1',
//                            'value' => array('Default'),
//                        ),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "show_disabled" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show Disabled Domains", 'whmpress'),
                        "description" => esc_html__("If you want to force show domains that are set as hidden in WHMCS, select YES", 'whmpress'),
                        "group" => esc_html__("Extended", 'whmpress'),
//                        'dependency' => array(
//                            'element' => 'style1',
//                            'value' => array('Default'),
//                        ),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "decimals" => array(
                        "fb_type" => "decimals",
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("Default", 'whmpress'),
                            esc_html__("0", 'whmpress'),
                            esc_html__("1", 'whmpress'),
                            esc_html__("2", 'whmpress'),
                            esc_html__("3", 'whmpress'),
                            esc_html__("4", 'whmpress'),
                        ),
                        "description" => "",
//                        'dependency' => array(
//                            'element' => 'style1',
//                            'value' => array('Default'),
//                        ),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "num_of_rows" => array(
                        "fb_type" => "num_of_rows",
                        "heading" => esc_html__("No of rows", 'whmpress'),
                        "vc_type" => "dropdown",
                        "description" => esc_html__("No of rows to show per page for data-tables", 'whmpress'),
                        "value" => array(
                            esc_html__("Default", 'whmpress'),
                            esc_html__("10", 'whmpress'),
                            esc_html__("25", 'whmpress'),
                            esc_html__("50", 'whmpress'),
                            esc_html__("100", 'whmpress'),
                        ),
//                        'dependency' => array(
//                            'element' => 'style1',
//                            'value' => array('Default'),
//                        ),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "replace_empty" => array(
                        "heading" => esc_html__("Replace empty value with", 'whmpress'),
                        "value" => "-",
//                        'dependency' => array(
//                            'element' => 'style1',
//                            'value' => array('Default'),
//                        ),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "titles" => array(
                        "heading" => esc_html__("Change column headers with", 'whmpress'),
                        "description" => esc_html__("Change table column headers with", 'whmpress'),
//                        'dependency' => array(
//                            'element' => 'style1',
//                            'value' => array('Default'),
//                        ),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "pricing_slab" => array(
                        "heading" => esc_html__("Enter pricing slab Number", 'whmpress'),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),


                    //--------Section-------------
                    "section_html" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("HTML", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "table_id" => array(
                        "hide_if_template_file" => "yes",
//                        'dependency' => array(
//                            'element' => 'style1',
//                            'value' => array('Default'),
//                        ),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    //todo: what is purpose of "first two elements (image and another)
                    "html_id" => array(
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML ID", 'whmpress'),
                        "description" => esc_html__("ID for HTML wrapper around shortcode", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "html_class" => array(
                        "hide_if_template_file" => "yes",
                        "value" => "whmpress whmpress_price_matrix",
                        "description" => esc_html__("HTML class for container", "whmpress"),
                        "heading" => esc_html__(esc_html__("HTML class", "whmpress"), 'whmpress'),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                );
                break;

            /*
			 * --------------price_domain_list------------------
			 */
            case "whmpress_price_domain_list":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMPress Domain Price List", "whmpress"),
                    ),

                    "html_template",

                    "currency" => array(
                        "vc_type" => "currencies",
                        "heading" => esc_html__("Select currency", 'whmpress'),
                        "description" => "",
                    ),

                    "show_renewel" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show Renewal Price", 'whmpress'),
                        "description" => esc_html__("Weather to show domain renewal price", 'whmpress'),
                    ),

                    "show_transfer" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Show Transfer Price", 'whmpress'),
                        "description" => esc_html__("Weather to show domain transfer price", 'whmpress'),
                        'dependency' => array(
                            'element' => 'style1',
                            'value' => array('Default'),
                        ),
                    ),

                    //--------Section-------------
                    "section_advance" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("Advance", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "show_tlds" => array(
                        "heading" => esc_html__("Show TLDs", 'whmpress'),
                        "description" => esc_html__("comma separated values of tlds to to list in table. Only tlds that exists in WHMCS will be added. No spaces in comma separated values.", 'whmpress'),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "show_tlds_wildcard" => array(
                        "heading" => esc_html__("Show TLDs Wildcard", 'whmpress'),
                        "description" => esc_html__("Show only tlds matching with given string. Very useful if you want to show only tlds related to your country, e.g. .in", 'whmpress'),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    "action_url" => array(
                        "heading" => esc_html__("Action URL", 'whmpress'),
                        "description" => esc_html__("A page where user will be redirected upon clicking any domain in list...", 'whmpress'),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),


                    //--------Section-------------
                    "section_html" => array(
                        "hide_if_template_file" => "yes",
                        "vc_type" => "label",
                        "heading" => esc_html__("HTML", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "html_id" => array(
                        "hide_if_template_file" => "yes",
                        "heading" => esc_html__("HTML ID", 'whmpress'),
                        "description" => esc_html__("ID for HTML wrapper around shortcode", "whmpress"),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                    "html_class" => array(
                        "hide_if_template_file" => "yes",
                        "value" => "whmpress whmpress_price_matrix",
                        "description" => esc_html__("HTML class for container", "whmpress"),
                        "heading" => esc_html__(esc_html__("HTML class", "whmpress"), 'whmpress'),
                        "group" => esc_html__("HTML", "whmpress"),
                    ),

                );
                break;

            /*
			* ------------------whois-----------------
			*/
            case "whmpress_whois":
            case "whmpress_domain_whois":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMpress Domain Whois", "whmpress"),
                    ),
                    "html_template",
                    "image",

                    "button_text" => array(
                        "value" => esc_html__("Search", "whmpress"),
                    ),

                    "placeholder" => array(
                        "value" => esc_html__("Enter domain name to search whois", "whmpress"),
                    ),

                    "action" => array(
                        "heading" => esc_html__("Search result URL", "whmpress"),
                        "description" => esc_html__("To show output in specific div, on the current page, Use #div-id<br>To show output on a different page e.g. Page-B, place same short-code on Page-B, and mentions B's URL in this field. You can use placeholder {wp-path} and it will be replaced with your site's homepage url...", "whmpress"),
                        "group" => esc_html__("Advance", "whmpress"),
                    ),

                    //--------Section-------------
                    "html" => array(
                        "vc_type" => "label",
                        "heading" => esc_html__("HTML", "whmpress"),
                        "classes" => "whmpress-custom-label",
                        "style" => "",
                    ),

                    "result_text_class" => array(
                        "heading" => "Whois result class",
                    ),

                    "text_class" => array(),

                    "button_class" => array(),

                    "html_id" => array(
                        "hide_if_template_file" => "yes",

                    ),

                    "html_class" => array(
                        "value" => "whmpress whmpress_domain_whois",
                        "hide_if_template_file" => "yes",
                    ),
                );
                break;

            /*
			* ------------------url-----------------
			*/
            case "whmpress_url":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMpress URL", "whmpress"),
                    ),
                    "type" => array(
                        "heading" => esc_html__("URL type", "whmpress"),
                        "vc_type" => "dropdown",
                        "value" => array(
                            "client_area",
                            "announcements",
                            "submit_ticket",
                            "downloads",
                            "support_tickets",
                            "knowledgebase",
                            "affiliates",
                            "order",
                            "contact_url",
                            "server_status",
                            "network_issues",
                            "whmcs_login",
                            "whmcs_register",
                            "whmcs_forget_password",
                        ),
                    ),
                );
                break;

            /*
			* ------------------client_area-----------------
			*/
            case "whmpress_client_area":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMpress Client Area", "whmpress"),
                    ),

                    "whmcs_template" => array(
                        "value" => "",
                        "heading" => esc_html__("WHMCS template", "whmpress"),
                        "description" => esc_html__("Leave it blank, if you are not sure", "whmpress"),
                    ),

                    "carttpl" => array(
                        "value" => "",
                        "heading" => esc_html__("WHMCS Cart template", "whmpress"),
                        "description" => esc_html__("Leave it blank, if you are not sure", "whmpress"),
                    ),
                );
                break;

            /*
			* ------------------whmcs_page-----------------
			* todo: how to convert values here? and above too
			*/
            case "whmpress_whmcs_page":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMpress WHMCS Page", "whmpress"),
                    ),

                    "page" => array(
                        "heading" => esc_html__("WHMCS page", "whmpress"),
                        "vc_type" => "dropdown",
                        "value" => array(
                            "Home" => "index",
                            "View Cart" => "cart",
                            "Announcements" => "announcements",
                            "Knowledge Base" => "knowledgebase",
                            "Server Status" => "serverstatus",
                            "Contact Page" => "contact",
                            "Submit Ticket" => "submitticket",
                            "Client Area" => "clientarea",
                            "Register Account" => "register",
                            "Forget Password" => "pwreset",
                        ),
                    ),

                    "return" => array(
                        "vc_type" => "dropdown",
                        "value" => array(
                            esc_html__("URL", "whmpress") => "url",
                            esc_html__("Link", "whmpress") => "link",
                        ),
                        "heading" => esc_html__("Output return type", "whmpress"),
                    ),
                );
                break;

            /*
			* ------------------whmcs_cart-----------------
			*/
            case "whmpress_whmcs_cart":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMCS Cart Items", "whmpress"),
                    ),
                    "link_text" => array(
                        "heading" => esc_html__("Link Text", "whmpress"),
                        "value" => "",
                    ),
                );
                break;

            /*
			* ------------------whmcs_if_loggedin-----------------
			*/
            case "whmpress_whmcs_if_loggedin":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMCS Logged In", "whmpress"),
                    ),
                );
                break;

            /*
			* ------------------whmcs_if_not_loggedin-----------------
			*/
            case "whmpress_whmcs_if_not_loggedin":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMCS Not Logged In", "whmpress"),
                    ),
                );
                break;

            /*
			* ------------------announcements-----------------
			*/
            case "whmpress_announcements":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("WHMpress Announcements", "whmpress"),
                    ),
                    "count" => array(
                        "heading" => esc_html__("How many announcements to show?", "whmpress"),
                        "value" => "3",
                    ),

                    "words" => array(
                        "heading" => esc_html__("Number of words to show", "whmpress"),
                        "value" => "25",
                    ),
                );
                break;

            /*
			* ------------------bundle_price-----------------
			*/
            case "whmpress_bundle_price":

                return array(
                    "vc_options" => array(
                        "title" => esc_html__("Bundle Price", "whmpress"),
                    ),

                    "id" => array(
                        "heading" => esc_html__("Bundle ID", "whmpress"),
                    ),
                );
                break;

            /*
			* ------------------bundle_name-----------------
			*/
            case "whmpress_bundle_name":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("Bundle Name", "whmpress"),
                    ),

                    "id" => array(
                        "heading" => esc_html__("Bundle ID", "whmpress"),
                    ),
                );
                break;

            /*
			* ------------------bundle_name-----------------
			*/
            case "whmpress_bundle_description":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("Bundle Description", "whmpress"),
                    ),
                );
                break;

            /*
			* ------------------bundle_pricing_table-----------------
			*/
            case "whmpress_bundle_pricing_table":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("Bundle Pricing Table", "whmpress"),
                    ),

                    "html_template",
                    "image",

                    "id" => array(
                        "heading" => esc_html__("Bundle ID", "whmpress"),
                    ),

                    "itemdata" => array(
                        "vc_type" => "yesno",
                        "heading" => esc_html__("Item Data", "whmpress"),
                    ),

                    "button_text" => array(
                        "heading" => esc_html__("Button Text", "whmpress"),
                    ),
                );
                break;

            /*
			* ------------------bundle_pricing_table-----------------
			*/
            case "whmpress_bundle_order_button":
                return array(
                    "vc_options" => array(
                        "title" => esc_html__("Bundle Order Button", "whmpress"),
                    ),

                    "html_template",
                    "image",

                    "id" => array(
                        "heading" => esc_html__("Bundle ID", "whmpress"),
                    ),

                    "button_text" => array(
                        "heading" => esc_html__("Button Text", "whmpress"),
                    ),
                );
                break;


            /*
			* ------------------else-----------------
			*/
            default:
                return array();
        }
    }

    public function get_product_types($vc_compatible = false)
    {
        $WHMPress = new WHMPress();
        if (!$WHMPress->WHMpress_synced()) {
            return [];
        }
        $Q = "SELECT DISTINCT `type` FROM `" . whmp_get_products_table_name() . "` WHERE `type`<>''";
        global $wpdb;
        $rows = $wpdb->get_results($Q, ARRAY_A);
        if ($vc_compatible) {
            $Out = [];
            foreach ($rows as $row) {
                $Out[$row["type"]] = $row["type"];
            }

            return $Out;
        } else {
            return $rows;
        }
    }

    public function get_currencies($vc_compatible = false)
    {
        $WHMPress = new WHMpress();
        if (!$WHMPress->WHMpress_synced()) {
            return [];
        }
        $Q = "SELECT * FROM `" . whmp_get_currencies_table_name() . "`";
        global $wpdb;
        $rows = $wpdb->get_results($Q, ARRAY_A);
        if ($vc_compatible) {
            $Out["Default"] = "0";
            foreach ($rows as $row) {
                $Out[$row['prefix'] . " " . $row['suffix']] = $row['id'];
            }

            return $Out;
        } else {
            if (is_object($rows)) {
                die("Here!");
                $rows = (array)$rows;
            }

            return $rows;
        }
    }

    public function get_template_array($shortcode)
    {
        if (get_option("load_sytle_orders") == "whmpress") {
            $file_path = WHMP_PLUGIN_DIR . "/themes/" . basename($this->whmp_get_template_directory()) . "/" . $shortcode . "/custom_fields.csv";
        } elseif (get_option("load_sytle_orders") == "author") {
            $file_path = $this->whmp_get_template_directory() . "/whmpress/" . $shortcode . "/custom_fields.csv";
        } else {
            $file_path = WHMP_PLUGIN_DIR . "/templates/" . $shortcode . "/custom_fields.csv";
        }

        /*
        $Dir1 = $this->whmp_get_template_directory()."/whmpress/".$shortcode;
        if (!is_dir($Dir1)) {
            $Dir2 = WHMP_PLUGIN_DIR."/templates/".$shortcode;
            if (!is_dir($Dir2)) return array();
            $file_path = $Dir2 . "/custom_fields.csv";
        } else {
            $file_path = $Dir1 . "/custom_fields.csv";
        }
        */
        if (!is_file($file_path)) {
            return [];
        }
        $CustomFields = array_map('str_getcsv', file($file_path));

        $field_names = [];
        foreach ($CustomFields as $custom_field) {
            $field_names[] = @$custom_field[0];
        }

        return $field_names;
    }

    public function is_json($json_value)
    {
        json_decode($json_value);

        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function send_info_to_author()
    {
        if (!$this->verified_purchase()) {
            echo "Your product purchase is not verified.\n\nPurchase your product from Dashboard of WHMpress";

            return;
        }
        global $wpdb;
        $wp_upload_max = wp_max_upload_size();
        $server_upload_max = intval(str_replace('M', '', ini_get('upload_max_filesize'))) * 1024 * 1024;

        $String = "<table border='1' cellpadding='5' cellspacing='0'>
        <tr><th colspan='2'>WordPressInfo</th></tr>
        <tr><td>Site URL</td><td>" . site_url() . "</td></tr>
        <tr><td>Site Home</td><td>" . home_url() . "</td></tr>
        <tr><td>WP Version</td><td>" . get_bloginfo('version') . "</td></tr>
        <tr><td>Is Multi Site</td><td>" . (is_multisite() ? "Yes" : "No") . "</td></tr>
        <tr><td>WordPress Language</td><td>" . get_locale() . "</td></tr>
        <tr><td>WordPress Debug Mode</td><td>" . (defined('WP_DEBUG') && WP_DEBUG ? "Yes" : "No") . "</td></tr>
        <tr><td>WordPress Active Plugins</td><td>" . (count((array)get_option('active_plugins'))) . "</td></tr>
        <tr><td>WordPress Max Upload Size</td><td>" . ($wp_upload_max <= $server_upload_max ? size_format($wp_upload_max) : size_format($wp_upload_max) . " but server allows " . size_format($server_upload_max)) . "</td></tr>
        <tr><td>WordPress Memory Limit</td><td>" . (WP_MEMORY_LIMIT) . "</td></tr>
        
        <tr><th colspan='2'>Server Info</th></tr>
        <tr><td>PHP Version</td><td>" . (function_exists('phpversion') ? phpversion() : "-") . "</td></tr>
        <tr><td>Server Software</td><td>" . (esc_html(@$_SERVER['SERVER_SOFTWARE'])) . "</td></tr>
        <tr><td>MySQLi Extension</td><td>" . (function_exists('mysqli_connect') ? "Yes" : "No") . "</td></tr>
        <tr><td>cURL Extension</td><td>" . (function_exists('curl_version') ? "Yes" : "No") . "</td></tr>

        <tr><th colspan='2'>WHMpress Info</th></tr>
        <tr><td>Version</td><td>" . (WHMP_VERSION) . "</td></tr>
        <tr><td>Last Synced</td><td>" . (get_option("sync_time")) . "</td></tr>
        <tr><td>WHMCS Version</td><td>" . $wpdb->get_var("SELECT `value` FROM `" . whmp_get_configuration_table_name() . "` WHERE `setting`='Version'") . "</td></tr>
        <tr><td>Company Name</td><td>" . $wpdb->get_var("SELECT `value` FROM `" . whmp_get_configuration_table_name() . "` WHERE `setting`='CompanyName'") . "</td></tr>
        <tr><td>Email Address</td><td>" . $wpdb->get_var("SELECT `value` FROM `" . whmp_get_configuration_table_name() . "` WHERE `setting`='email'") . "</td></tr>
        <tr><td>Domains</td><td>" . $wpdb->get_var("SELECT COUNT(*) FROM `" . whmp_get_domain_pricing_table_name() . "`") . "</td></tr>
        <tr><td>Products</td><td>" . $wpdb->get_var("SELECT COUNT(*) FROM `" . whmp_get_products_table_name() . "`") . "</td></tr>
        <tr><td>Product Groups</td><td>" . $wpdb->get_var("SELECT COUNT(*) FROM `" . whmp_get_product_group_table_name() . "`") . "</td></tr>
        <tr><td>Currencies</td><td>" . $wpdb->get_var("SELECT COUNT(*) FROM `" . whmp_get_currencies_table_name() . "`") . "</td></tr>
        <tr><td>WHMCS URL</td><td>" . whmp_get_installation_url() . "</td></tr>";

        if (is_active_cap()) {
            $uurl = get_option('client_area_page_url');
            if (is_numeric($uurl)) {
                $uurl = get_page_link($uurl);
            }
            if (substr($uurl, 0, 4) <> "http") {
                $uurl = get_bloginfo("url") . "/" . $uurl;
            }
            $String .= "<tr><td>Client Area URL</td><td>" . $uurl . "</td></tr>";
        }

        $String .= "<tr><th colspan='2'>Addons</th></tr>";
        if (is_active_cap()) {
            global $plugin_data_ca;
            $String .= "<tr><td>" . @$plugin_data_ca["Name"] . "</td><td>" . @$plugin_data_ca["Version"] . "</td></tr>";
        } else {
            $String .= "<tr><td></td><td>No Addon installed</td></tr>";
        }

        $String .= "<tr><th colspan='2'>Plugins</th></tr>
        <tr><td>Installed</td>";
        $active_plugins = (array)get_option('active_plugins', []);

        if (is_multisite()) {
            $active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', []));
        }

        $wp_plugins = [];

        foreach ($active_plugins as $plugin) {

            $plugin_data = @get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin);
            $dirname = dirname($plugin);
            $version_string = '';

            if (!empty($plugin_data['Name'])) {

                // link the plugin name to the plugin url if available
                $plugin_name = $plugin_data['Name'];
                if (!empty($plugin_data['PluginURI'])) {
                    $plugin_name = '<a target="_blank" href="' . esc_url($plugin_data['PluginURI']) . '" title="Visit plugin homepage">' . $plugin_name . '</a>';
                }

                $wp_plugins[] = $plugin_name . ' by ' . $plugin_data['Author'] . ' version ' . $plugin_data['Version'] . $version_string;

            }
        }
        if (sizeof($wp_plugins) == 0) {
            $String .= "<td>-</td>";
        } else {
            $String .= "<td>" . implode(', <br/>', $wp_plugins) . "</td>";
        }

        $active_theme = wp_get_theme();
        $String .= "<tr><th colspan='2'>Theme</th></tr>
        <tr><td>Theme Name</td><td>" . $active_theme->Name . "</td></tr>
        <tr><td>Theme Version</td><td>" . $active_theme->Version . "</td></tr>
        <tr><td>Theme Author URL</td><td>" . $active_theme->{'Author URI'} . "</td></tr>
        <tr><td>Is Child Theme</td><td>" . (is_child_theme() ? "Yes" : "No") . "</td></tr>";
        if (is_child_theme()) {
            $parent_theme = wp_get_theme($active_theme->Template);
            $String .= "<tr><td>Parent Theme Name</td><td>" . $parent_theme->Name . "</td></tr>
            <tr><td>Parent Theme Version</td><td>" . $parent_theme->Version . "</td></tr>
            <tr><td>Parent Theme Author URL</td><td>" . $parent_theme->{'Author URI'} . "</td></tr>";
        }
        $String .= "</table><br /><br />
        From IP: " . $this->ip_address();

        $headers = "Content-type: text/html";
        $response = wp_mail("shakeel@shakeel.pk,farooqomer@gmail.com", "WHMPress Debug Info", $String, $headers);
        if ($response === true) {
            echo "OK";
        } else {
            "Email not sent.";
        }
    }

    public function verified_purchase()
    {
        return get_option("whmp_verified") == "1";
//        if ($this->is_vhost_active()) {
//            ## Check if vHost is verified or not.
//            return true;
//        } else {
//            return get_option("whmp_verified") == "1";
//        }
    }

    public function is_nexum_active()
    {
        $my_theme = wp_get_theme();

        if (($my_theme->get('Name') == "nexum") || ($my_theme->get('Name') == "nexum Child") || ($my_theme->get('Name') == "neXum")) {
            return true;
        } else {
            return false;
        }
    }

    public function ip_address()
    {
        $ip_keys = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR',
        ];
        foreach ($ip_keys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    // trim for safety measures
                    $ip = trim($ip);
                    // attempt to validate IP
                    if ($this->validate_ip($ip)) {
                        return $ip;
                    }
                }
            }
        }

        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
    }

    public function validate_ip($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return false;
        }

        return true;
    }

    function debug($string)
    {
        if ($_SERVER["HTTP_HOST"] == "whmpress.pk") {
            if (is_object($string) || is_array($string)) {
                $string = print_r($string, true);
            }
            file_put_contents("D:\\whmpress_logs.txt", $string . "\n", FILE_APPEND);
        }
    }

    public function unverify_purchase($vars = [])
    {
        $url = "http://plugins.creativeon.com/envato/unverify.php";
        $vars["purchase_code"] = get_option("whmp_purchase_code");
        $vars["email2"] = get_option("whmp_purchase_email");
        $vars["registered_url"] = parse_url(get_bloginfo("url"), PHP_URL_HOST);
        $vars["registered_url"] = str_replace("www.", "", $vars["registered_url"]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        #curl_setopt($ch, CURLOPT_COOKIE, $cookies);
        curl_setopt($ch, CURLOPT_POST, count($vars));
        #curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        #curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $data = $vars;
        if (is_array($vars)) {
            $vars = http_build_query($vars);
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $output = curl_exec($ch);

        if ($output == "OK") {
            update_option("whmp_purchase_code", '');
            update_option("whmp_purchase_email", '');
            update_option("whmp_verified", "0");
        }

        echo $output;
    }

    public function verify_purchase($vars = [])
    {
        $url = "http://plugins.creativeon.com/envato/";

        $vars["registered_url"] = parse_url(get_bloginfo("url"), PHP_URL_HOST);
        if ($vars["registered_url"] == "") {
            $vars["registered_url"] = parse_url(get_bloginfo("url"), PHP_URL_PATH);
        }
        $vars["registered_url"] = str_replace("www.", "", $vars["registered_url"]);

        $vars["item_name"] = "WHMpress - WHMCS WordPress Integration Plugin";
        $vars["version"] = WHMP_VERSION;

        if (!isset($vars["email"])) {
            $vars["email"] = get_option("whmp_purchase_email");
        }
        if ($vars["email"] == "") {
            $vars["email"] = get_option("admin_email");
        }

        if (!isset($vars["purchase_code"])) {
            $vars["purchase_code"] = get_option("whmp_purchase_code");
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_POST, count($vars));
        #curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        #curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $data = $vars;
        if (is_array($vars)) {
            $vars = http_build_query($vars);
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $output = curl_exec($ch);

        if ($errno = curl_errno($ch)) {
            $error_message = curl_error($ch);
            echo "cURL error:\n {$error_message}<br />Fetching: $fetch_url";

            return;
        }


        if ($output == "OK") {
            update_option("whmp_purchase_code", $data["purchase_code"]);
            update_option("whmp_purchase_email", $data["email"]);
            update_option("whmp_verified", "1");
        } else {
            update_option("whmp_verified", "0");
        }
        echo $output;
    }

    /**
     * @param $ar
     *
     * Diplay array data as human friendly
     */
    public function show_array($ar)
    {
        echo "<pre>";
        if (is_object($ar) || is_array($ar)) {
            print_r($ar);
        } else {
            var_dump($ar);
        }
        echo "</pre>";
    }

    /**
     * @param $tld
     *
     * @return array
     *
     * This method will return categories against a tld
     */
    public function get_tld_categories($tld)
    {
        if (!$this->WHMpress_synced()) {
            return [];
        }

        $tld = ltrim($tld, ".");
        global $wpdb, $Tables;

        $tld_table = $wpdb->prefix . "whmpress_tlds";
        $cats_table = $wpdb->prefix . "whmpress_tld_categories";
        $cats_pivot_table = $wpdb->prefix . "whmpress_tld_category_pivot";

        ## If any one about MySQL table missing then return blank array
        if (!whmp_is_table_exists($tld_table) || !whmp_is_table_exists($cats_table) || !whmp_is_table_exists($cats_pivot_table)) {
            return [];
        }

        $Q = "SELECT c.`category`
		FROM `$cats_table` c, `$cats_pivot_table` cp WHERE
		cp.category_id=c.id AND cp.tld_id IN (SELECT `id` tld_id FROM `$tld_table` WHERE `tld`='$tld')
		";

        $rows = $wpdb->get_results($Q, ARRAY_A);

        if (is_null($rows)) {
            return [];
        }

        $cats = [];
        foreach ($rows as $row) {
            $cats[] = $row['category'];
        }

        return $cats;
    }

    public function get_domain_price($args)
    {
        $defaults = [
            "extension" => "",
            "years" => "1",
            "price_type" => "register",
            "currency" => "",
            "process_tax" => "0",
        ];
        $tmp = wp_parse_args($args, $defaults);
        extract($tmp);

        $years = (int)$years;

        if ($years > 10) {
            $years = 10;
        }
        if ($years < 1) {
            $years = 1;
        }

        if (empty($currency)) {
            $currency = whmp_get_currency();
        }

        $price_type = strtolower($price_type);
        if ($price_type == "renew" || $price_type == "domainrenew" || $price_type == "new") {
            $price_type = "domainrenew";
        } else if ($price_type == "transfer" || $price_type == "domaintransfer") {
            $price_type = "domaintransfer";
        } else {
            $price_type = "domainregister";
        }


        $YearColumn = [
            "1" => "msetupfee",
            "2" => "qsetupfee",
            "3" => "ssetupfee",
            "4" => "asetupfee",
            "5" => "bsetupfee",
            "6" => "monthly",
            "7" => "quarterly",
            "8" => "semiannually",
            "9" => "annually",
            "10" => "biennially",
        ];

        global $wpdb;

        $extension = "." . (ltrim($extension, "."));

        $Q = "SELECT `{$YearColumn[$years]}` FROM `" . whmp_get_pricing_table_name() . "` pt, `" . whmp_get_domain_pricing_table_name() . "` dpt WHERE dpt.id=`relid`
			AND `extension`='$extension'
			AND `type`='$price_type' AND `currency`='$currency'";

        $price = $wpdb->get_var($Q);
        //	echo "<br>years.".$years."price.".$price;

        if (is_null($price) || $price === false) {
            return "0";
        }

        if (!isset($price_tax)) {
            $price_tax = "";
        }

        if ($process_tax == "1" || $process_tax === true || strtolower($process_tax) == "yes") {
            # Calculating tax.
            $TaxEnabled = $wpdb->get_var("SELECT `value` FROM " . whmp_get_configuration_table_name() . " WHERE `setting`='TaxEnabled'");
            $TaxDomains = $wpdb->get_var("SELECT `value` FROM " . whmp_get_configuration_table_name() . " WHERE `setting`='TaxDomains'");

            $tax_amount = $base_price = $price;
            if (strtolower($TaxEnabled) == "on" && strtolower($TaxDomains) == "on") {
                $taxes = whmpress_calculate_tax($price);
                $base_price = $taxes["base_price"];
                $tax_amount = $taxes["tax_amount"];

                if ($price_tax == "default") {
                    $price_tax = "";
                }
                $price_tax = trim(strtolower($price_tax));

                if ($price_tax == "exclusive") {
                    $price = $base_price;
                } elseif ($price_tax == "inclusive") {
                    $price = $base_price + $tax_amount;
                } elseif ($price_tax == "tax") {
                    $price = $tax_amount;
                }
            }
        }

        return $price;
    }

    public function get_domain_addon_price($args = "")
    {
        $defaults = [
            "currency" => "",
            "process_tax" => "0",
        ];
        extract(wp_parse_args($args, $defaults));

        if (empty($currency)) {
            $currency = whmp_get_currency();
        }

        $price_type = "domainaddons";

        global $wpdb;


        $Q = "SELECT `msetupfee`, `qsetupfee`, `ssetupfee` FROM `" . whmp_get_pricing_table_name() . "` WHERE
			 `type`='$price_type' AND `currency`='$currency'";

        //echo $Q;

        $price = $wpdb->get_row($Q, 'ARRAY_A');

        //$this->show_array($price);

        if (is_null($price) || $price === false) {
            return "0";
        }

        //todo:make a function to process tax.

        if ($process_tax == "1" || $process_tax === true || strtolower($process_tax) == "yes") {
            # Calculating tax.
            $TaxEnabled = $wpdb->get_var("SELECT `value` FROM " . whmp_get_configuration_table_name() . " WHERE `setting`='TaxEnabled'");
            $TaxDomains = $wpdb->get_var("SELECT `value` FROM " . whmp_get_configuration_table_name() . " WHERE `setting`='TaxDomains'");

            $tax_amount = $base_price = $price;
            if (strtolower($TaxEnabled) == "on" && strtolower($TaxDomains) == "on") {
                $taxes = whmpress_calculate_tax($price);
                $base_price = $taxes["base_price"];
                $tax_amount = $taxes["tax_amount"];

                if ($price_tax == "default") {
                    $price_tax = "";
                }
                $price_tax = trim(strtolower($price_tax));

                if ($price_tax == "exclusive") {
                    $price = $base_price;
                } elseif ($price_tax == "inclusive") {
                    $price = $base_price + $tax_amount;
                } elseif ($price_tax == "tax") {
                    $price = $tax_amount;
                }
            }
        }

        return $price;
    }

    public function get_domain_additional_data($extension_id, $lang = "")
    {
        if (empty($lang)) {
            $lang = $this->get_current_language();
        }

        $promo = get_option("whmpress_domain_promo_" . $extension_id);
        if (!isset($promo) || empty($promo)) {
            $promo = "";
        }

        $restore_data = whmp_domain_price_restore_i($extension_id);
        $data = [
            "grace_period" => $restore_data["grace_period"],
            "grace_period_fee" => $restore_data["grace_period_fee"],
            "redemption_grace_period" => $restore_data["redemption_grace_period"],
            "restore_price" => $restore_data["redemption_grace_period_fee"],
            "promo" => $promo,
            "promo_text" => get_option("whmpress_domain_promo_text_" . $extension_id . $lang),
            "promo_details" => get_option("whmpress_domain_promo_details_" . $extension_id . $lang),
            "promo_register_off" => get_option("whmpress_domain_promo_register_off_price_" . $extension_id),
            "promo_renew_off" => get_option("whmpress_domain_promo_renew_off_price_" . $extension_id),
            "promo_transfer_off" => get_option("whmpress_domain_promo_transfer_off_price_" . $extension_id),
            "apply_all" => get_option("whmpress_domain_promo_apply_all_" . $extension_id),
        ];

        foreach ($data as $d) {
            if (!isset($d)) {
                $d = "";
            }
        }

        return $data;
    }

    function get_current_language()
    {
        if (defined('ICL_LANGUAGE_CODE')) {
            return ICL_LANGUAGE_CODE;
        } elseif (function_exists('pll_current_language')) {
            return pll_current_language();
        } elseif (isset($_GET["lang"])) {
            return $_GET["lang"];
        } else {
            return get_locale();
        }
    }

    /*
	 * Get Addon Price, returns array of all addon types.
	 */

    public function whmpress_sync($data = [], $show_full_result = true)
    {
        whmp_fetch_data([], true);
    }

    public function get_all_prices($args = "")
    {
        $defaults = [
            "currency" => "",
            "product_id" => "",
            "prefix_required" => "",
        ];
        extract(wp_parse_args($args, $defaults));


        if (empty($product_id)) {
            return esc_html__("No product ID provided", "whmpress");
        }

        if (empty($currency)) {
            $currency = $this->whmp_get_default_currency_id();
        }

        $prefix = $prefix_required == 'yes' ? whmp_get_currency_prefix($currency) : '';

        $billing_cycles = ["monthly", "quarterly", "semiannually", "annually", "biennially", "triennially"];

        $all_prices = [];
        foreach ($billing_cycles as $billing_cycle) {
            $price = whmpress_price_function([
                "id" => $product_id,
                "billingcycle" => $billing_cycle,
                "currency" => $currency,
                "prefix" => "no",
                "suffix" => "no",
                "show_duration" => "no",
                "no_wrapper" => "1",
                "price_type" => "total",
            ]);
            if ($price >= 0) {
                $all_prices[$billing_cycle]["package"] = $prefix . $price;

                $price = whmpress_price_function([
                    "id" => $product_id,
                    "billingcycle" => $billing_cycle,
                    "currency" => $currency,
                    "prefix" => $prefix_required,
                    "suffix" => "no",
                    "show_duration" => "no",
                    "no_wrapper" => "1",
                    "price_type" => "setup",
                ]);
                $all_prices[$billing_cycle]["setup"] = $price;
            }
        }

        return $all_prices;
    }

    public function get_configuration_options($args = "")
    {
        $defaults = [
            "currency" => "",
            "product_id" => "",
            "billingcycle" => "",
        ];
        extract(wp_parse_args($args, $defaults));

        if (empty($product_id)) {
            return esc_html__("No product ID provided", "whmpress");
        }

        if (empty($billingcycle)) {
            return esc_html__("No billing cycle provided", "whmpress");
        }

        if (empty($currency)) {
            $currency = $this->whmp_get_default_currency_id();
        }


        $Q = "SELECT SUM(`price`) FROM
        (SELECT MIN(`{$billingcycle}`) price, abc.configid  FROM `" . get_mysql_table_name("tblpricing") . "`,
        
        
        (SELECT tpcos.`configid`, tpcos.id id FROM `" . get_mysql_table_name("tblpricing") . "` p, `" . get_mysql_table_name("tblproductconfiglinks") . "` pcl, `" . get_mysql_table_name("tblproductconfigoptions") . "` tpco, 
        `" . get_mysql_table_name("tblproductconfigoptionssub") . "` tpcos WHERE 
        (tpco.optiontype='1' OR tpco.optiontype='2') AND
        p.`type`='product' AND p.relid=pid AND pcl.gid=tpco.gid AND tpco.id=tpcos.configid AND p.currency='{$currency}') abc
        
        WHERE `type`='configoptions' AND `currency`='{$currency}' AND `relid` IN
        (SELECT tpcos.id relid FROM `" . get_mysql_table_name("tblpricing") . "` p, `" . get_mysql_table_name("tblproductconfiglinks") . "` pcl, `" . get_mysql_table_name("tblproductconfigoptions") . "` tpco, `" . get_mysql_table_name("tblproductconfigoptionssub") . "` tpcos WHERE `relid`='{$product_id}' AND p.`type`='product' AND p.relid=pid AND pcl.gid=tpco.gid AND tpco.id=tpcos.configid AND p.currency='{$currency}')
        
        AND abc.id=`relid`
        GROUP BY `configid`) theR";

        echo $Q;
    }

    public function get_config_groups($product_id)
    {
        global $wpdb;
        $Q = "SELECT cg.id, cg.`name` FROM `" . get_mysql_table_name('tblproductconfiglinks') . "` cl, `" . get_mysql_table_name('tblproductconfiggroups') . "` cg
		WHERE cl.pid='$product_id' AND cl.gid=cg.id";
        $group = $wpdb->get_row($Q);

        if (!isset($group->id)) {
            return [];
        }

        $Q = "
		SELECT *,'{$group->name}' group_name FROM `" . get_mysql_table_name('tblproductconfigoptions') . "` WHERE `gid`='{$group->id}'";

        $groups = $wpdb->get_results($Q, ARRAY_A);

        return $groups;
    }

    public function get_bundle_data($id)
    {
        global $wpdb;
        global $Tables;

        $TableName = $wpdb->prefix . "whmpress_" . $Tables["tblbundles"];

        $query = "SELECT * FROM `$TableName` WHERE `id`='$id'";

        $row = $wpdb->get_row($query, ARRAY_A);

        if (isset($row["id"])) {
            $row["order_link"] = $this->get_order_url($row["id"], "product_type=bid&currency=1");
        }

        return $row;
    }

    /**
     * @param        $id
     * @param string $args
     *
     * @return array|string
     *
     * This function will return Order URL after using all options.
     */
    public function get_order_url($id, $args = "")
    {
        $default = [
            "product_type" => "pid",
            "currency" => "",
            "billingcycle" => "",
        ];
        $args = wp_parse_args($args, $default);
        extract($args);

        $url = $this->get_whmcs_url("order");

        $url .= "&a=add&$product_type=$id";

        foreach ($args as $k => $v) {
            if ($v == "" || $k == "product_type" || $k == "a") {
                continue;
            }
            $url .= "&{$k}={$v}";
        }

        return $url;
    }

    public function get_whmcs_url($url_type = 'order')
    {

        $url = "";
        if (function_exists('whcom_get_current_language')) {
            $lang = whcom_get_current_language();
        } else {
            $lang = $this->get_current_language();
        }

        $base_url = '';
        if (is_active_cop()) {
            $field = 'configure_product' . $lang;
            $base_url = get_option($field, '') . '?';
        } else if (is_active_cap()) {
            $field = 'wcapfield_client_area_url' . $lang;
            $base_url = get_option($field, '') . '?';
        } else {
            $url = whmpress_get_option('order_url');
            if ($url == "") {
                $url = rtrim(whmp_get_installation_url(), "/") . "/cart.php?extra=0&";
            }
        }

        switch ($url_type) {
            case "order":
                if (is_active_cop()) {
                    $url = $base_url . 'a=add&';
                } else if (is_active_cap()) {
                    $url = $base_url . 'whmpca=order_process&a=add&';
                } else {
                    $url = whmpress_get_option('order_url');
                    if ($url == "") {
                        $url = rtrim(whmp_get_installation_url(), "/") . "/cart.php?extra=0&";
                    }
                }

                if (substr($url, -2) == "//") {
                    $url = substr($url, 0, -1);
                }
                break;
            case "domainchecker":
                if (is_active_cop()) {
                    $url = $base_url . '&a=add&domain=register';
                } else if (is_active_cap()) {
                    $url = $base_url . 'whmpca=order_process&a=add&domain=register';
                } else {
                    $url = whmpress_get_option('domain_checker_url');
                    if ($url == "") {
                        $url = rtrim(whmp_get_installation_url(), "/") . "/cart.php?&a=add&domain=register";
                    }
                }
                break;
            case "confdomains":
                if (is_active_cop()) {
                    $url = $base_url . 'a=confdomains';
                } else if (is_active_cap()) {
                    $url = $base_url . 'whmpca=order_process&a=confdomains';
                } else {
                    $url = whmpress_get_option('domain_checker_url');
                    if ($url == "") {
                        $url = rtrim(whmp_get_installation_url(), "/") . "/cart.php?extra=0";
                    }
                }
                break;
            case "loginurl":
                $url = whmpress_get_option('whmcs_login_url');
                if ($url == "") {
                    $url = rtrim(get_option("whmcs_url"), "/") . "/dologin.php";
                }
                break;
        }

        return $url;

    }

    function get_current_client_area_page()
    {
        if (is_active_cap()) {
            //$WHMCS    = new WHMPress_Client_Area();
            $blog_url = get_option('wcapfield_client_area_url' . $this->get_current_language());
        } else {
            $blog_url = get_option("client_area_page_url");
        }

        if (is_numeric($blog_url)) {
            $blog_url = get_page_link($blog_url);
        } else {
            if (substr($blog_url, 0, 4) != "http") {
                $blog_url = get_bloginfo("url") . "/" . $blog_url;
            }
        }
        $blog_url = rtrim($blog_url, "/");

        return $blog_url;
    }

    public function is_client_area_activated()
    {
        return is_active_cap();
    }

    public function update_db()
    {
        global $Tables;
        global $wpdb;

        /*$table_name = get_mysql_table_name("tblcurrencies");
		$column_name_to_update = "decimal";
		$Q = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
			WHERE table_name = '{$table_name}' AND column_name = '{$column_name_to_update}'";
		$row = $wpdb->get_results($Q);
		if (empty($row)) {
			$Q = "ALTER TABLE `{$table_name}` ADD `{$column_name_to_update}` VARCHAR(5) NOT NULL DEFAULT '.'";
			$wpdb->query($Q);
		}

		$column_name_to_update = "thousand";
		$Q = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
			WHERE table_name = '{$table_name}' AND column_name = '{$column_name_to_update}'";
		$row = $wpdb->get_results($Q);
		if (empty($row)) {
			$Q = "ALTER TABLE `{$table_name}` ADD `{$column_name_to_update}` VARCHAR(5) NOT NULL DEFAULT ','";
			$wpdb->query($Q);
		}*/

    }

    public function get_currency_decimal_separator($currency_id = "")
    {
        if (empty($currency_id)) {
            $currency_id = $this->whmp_get_default_currency_id();
        }

        $field = "whmpress_currencies_" . $currency_id . "_decimal_" . $this->get_current_language();
        $decimal_sep = get_option($field);

        if (empty($decimal_sep)) {
            $decimal_sep = ".";
        }

        return $decimal_sep;
    }

    public function whmpress_currency_decimal_separator( $currency_id=""){
        global $wpdb;
        if (empty($currency_id)) {
            $currency_id = $this->whmp_get_default_currency_id();
        }
        //==Get currency format which is set in WHMCS.
        $Q   = "SELECT `format` FROM `" . whmp_get_currencies_table_name() . "` WHERE (`id`='$currency_id')";
        $row = $wpdb->get_row( $Q, ARRAY_A );

        $field = "whmpress_currencies_" . $currency_id . "_decimal_" . $this->get_current_language();
        $whmp_decimal_sep = get_option($field);
        if (empty($whmp_decimal_sep)) {
            if ($row["format"] == "1") {
                $whmp_decimal_sep = ".";
            } elseif ($row["format"] == "2") {
                $whmp_decimal_sep = ".";
            } elseif ($row["format"] == "3") {
                $whmp_decimal_sep = ",";
            } elseif ($row["format"] == "4") {
                $whmp_decimal_sep = ".";
            } else {
                $whmp_decimal_sep = ".";
            }
        }
        return $whmp_decimal_sep;
    }

    public function get_currency_decimal()
    {

/*        global $wpdb;

        $currency = whmp_get_current_currency_id_i();

        $Q = "SELECT * FROM `" . whmp_get_currencies_table_name() . "`WHERE `id`=".$currency;
        $row_currency = $wpdb->get_results($Q);
        $decimal = '2';
        foreach ($row_currency as $row) {
            if ($row->format == '4') {
                $decimal = 0;
            } elseif ($row->format == '1') {
                $decimal = 1;
            } elseif ($row->format == '3') {
                $decimal = 1;
            } elseif ($row->format == '2') {
                $decimal = 1;
            }
        }

        ppa($decimal,"dedimal places----------------");*/

        return intval(esc_attr(get_option('default_decimal_places', "2")));;
    }

    //returns price for all years

    public function get_currency_thousand_separator($currency_id = "")
    {
        if (empty($currency_id)) {
            $currency_id = $this->whmp_get_default_currency_id();
        }

        $field = "whmpress_currencies_" . $currency_id . "_thousand_" . $this->get_current_language();
        $thousand_sep = get_option($field);
        if (empty($thousand_sep)) {
            $thousand_sep = "";
        }

        return $thousand_sep;
    }

    public function whmpress_currency_thousand_separator( $currency_id=""){

        global $wpdb;
        if (empty($currency_id)) {
            $currency_id = $this->whmp_get_default_currency_id();
        }

        //==Get currency format which is set in WHMCS.
        $Q   = "SELECT `format` FROM `" . whmp_get_currencies_table_name() . "` WHERE (`id`='$currency_id')";
        $row = $wpdb->get_row( $Q, ARRAY_A );

        $field = "whmpress_currencies_" . $currency_id . "_thousand_" . $this->get_current_language();
        $whmp_thousand_sep = get_option($field);
        if (empty($whmp_thousand_sep)) {
            if ($row["format"] == "1") {
                $whmp_thousand_sep = ",";
            } elseif ($row["format"] == "2") {
                $whmp_thousand_sep = ",";
            } elseif ($row["format"] == "3") {
                $whmp_thousand_sep = ".";
            } elseif ($row["format"] == "4") {
                $whmp_thousand_sep = ",";
            } else {
                $whmp_thousand_sep = ",";
            }
        }
        return $whmp_thousand_sep;
    }

    public function get_domain_price_bulk($args)
    {
        $defaults = [
            "extension" => "",
            "currency" => "",
            "process_tax" => "0",
            "pricing_slab" => "0"
        ];
        $tmp = wp_parse_args($args, $defaults);
        extract($tmp);
        $pricing_slab = $tmp['pricing_slab'];
        if (empty($currency)) {
            $currency = whmp_get_currency();
        }

//        		if ( $price_type == "renew" || $price_type == "domainrenew" || $price_type == "new" ) {
//					$price_type = "domainrenew";
//				} else if ( $price_type == "transfer" || $price_type == "domaintransfer" ) {
//					$price_type = "domaintransfer";
//				} else {
//					$price_type = "domainregister";
//				}


        $years_q = "`msetupfee`,`qsetupfee`,`ssetupfee`,`asetupfee`,`bsetupfee`,`monthly`,`quarterly`,`semiannually`,`annually`,`biennially`";

        global $wpdb;

        $extension = "." . (ltrim($extension, "."));

        $Q = "SELECT * FROM `" . whmp_get_pricing_table_name() . "` pt, `" . whmp_get_domain_pricing_table_name() . "` dpt WHERE dpt.id=`relid`
				AND `extension`='$extension'
				AND `currency`='$currency'
				AND `tsetupfee`='$pricing_slab'
				AND (`type`='domainregister' OR `type`='domaintransfer' OR `type`='domainrenew');";

        $tmp = $wpdb->get_results($Q, ARRAY_A);

        if (is_null($tmp) || $tmp === false) {
            return "0";
        }
        $price = array();
        foreach ($tmp as $row) {
            if ($row["type"] == "domainregister") {
                $price['registration'][1] = $row['msetupfee'];
                $price['registration'][2] = $row['qsetupfee'];
                $price['registration'][3] = $row['ssetupfee'];
                $price['registration'][4] = $row['asetupfee'];
                $price['registration'][5] = $row['bsetupfee'];
                $price['registration'][6] = $row['monthly'];
                $price['registration'][7] = $row['quarterly'];
                $price['registration'][8] = $row['semiannually'];
                $price['registration'][9] = $row['annually'];
                $price['registration'][10] = $row['biennially'];
            }

            if ($row["type"] == "domainrenew") {
                $price['renewal'][1] = $row['msetupfee'];
                $price['renewal'][2] = $row['qsetupfee'];
                $price['renewal'][3] = $row['ssetupfee'];
                $price['renewal'][4] = $row['asetupfee'];
                $price['renewal'][5] = $row['bsetupfee'];
                $price['renewal'][6] = $row['monthly'];
                $price['renewal'][7] = $row['quarterly'];
                $price['renewal'][8] = $row['semiannually'];
                $price['renewal'][9] = $row['annually'];
                $price['renewal'][10] = $row['biennially'];
            }

            if ($row["type"] == "domaintransfer") {
                $price['transfer'][1] = $row['msetupfee'];
                $price['transfer'][2] = $row['qsetupfee'];
                $price['transfer'][3] = $row['ssetupfee'];
                $price['transfer'][4] = $row['asetupfee'];
                $price['transfer'][5] = $row['bsetupfee'];
                $price['transfer'][6] = $row['monthly'];
                $price['transfer'][7] = $row['quarterly'];
                $price['transfer'][8] = $row['semiannually'];
                $price['transfer'][9] = $row['annually'];
                $price['transfer'][10] = $row['biennially'];
            }
        }

        /*	if ( ! isset( $price_tax ) ) {
				$price_tax = "";
			}

			if ( $process_tax == "1" || $process_tax === true || strtolower( $process_tax ) == "yes" ) {
				# Calculating tax.
				$TaxEnabled = $wpdb->get_var( "SELECT `value` FROM " . whmp_get_configuration_table_name() . " WHERE `setting`='TaxEnabled'" );
				$TaxDomains = $wpdb->get_var( "SELECT `value` FROM " . whmp_get_configuration_table_name() . " WHERE `setting`='TaxDomains'" );

				$tax_amount = $base_price = $price;
				if ( strtolower( $TaxEnabled ) == "on" && strtolower( $TaxDomains ) == "on" ) {
					$taxes      = whmpress_calculate_tax( $price );
					$base_price = $taxes["base_price"];
					$tax_amount = $taxes["tax_amount"];

					if ( $price_tax == "default" ) {
						$price_tax = "";
					}
					$price_tax = trim( strtolower( $price_tax ) );

					if ( $price_tax == "exclusive" ) {
						$price = $base_price;
					} elseif ( $price_tax == "inclusive" ) {
						$price = $base_price + $tax_amount;
					} elseif ( $price_tax == "tax" ) {
						$price = $tax_amount;
					}
				}
			}*/


        return $price;
    }

    public function add_tooltips_table()
    {
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $charset_collate = $wpdb->get_charset_collate();

        $table_name = whmp_get_tooltips_table_name();

        $Q = "CREATE TABLE {$table_name} (
              tooltip_id int(11) NOT NULL AUTO_INCREMENT,
              match_string varchar(50) NOT NULL,
              tooltip_text text NOT NULL,
              icon_class varchar(50) NOT NULL,
              UNIQUE KEY id (tooltip_id)
            ) " . $charset_collate;
        $response = dbDelta($Q);

    }

    public function add_ip2country_table()
    {
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $charset_collate = $wpdb->get_charset_collate();

        $table_name = whmp_get_ip2country_table_name();


        $Q = "CREATE TABLE {$table_name} (
                `ip_from` INT(10) UNSIGNED,
                `ip_to` INT(10) UNSIGNED,
                `country_code` CHAR(2),
                `country_name` VARCHAR(64),
                INDEX `idx_ip_from` (`ip_from`),
                INDEX `idx_ip_to` (`ip_to`),
                INDEX `idx_ip_from_to` (`ip_from`, `ip_to`)
                ) " . $charset_collate;
        $response = dbDelta($Q);

    }

    public function whmp_delete_tooltip($tooltip_id)
    {
        global $wpdb;
        $Q = "DELETE FROM `" . whmp_get_tooltips_table_name() . "` WHERE `tooltip_id`='$tooltip_id'";
        $wpdb->query($Q);
    }

    function return_tooltip($match_string)
    {
        global $wpdb;
        $row = $wpdb->get_row("SELECT * FROM `" . whmp_get_tooltips_table_name() . "` WHERE `match_string` LIKE '%" . $match_string . "%'", ARRAY_A);

        $return_data = [
            'tooltip_text' => (!empty($row['tooltip_text'])) ? $row['tooltip_text'] : '',
            'icon_class' => (!empty($row['icon_class'])) ? $row['icon_class'] : '',
        ];
        return $return_data;

    }

    function Description2Array($description, $rows, $sep, $return, $strip_sections = false)
    {

        if (isset($description)) {
            $description = preg_split("/\r\n|\n|\r/", strip_tags($description));
            //$description = explode( "\n", strip_tags( $description ) );
        } else {
            $description = [];
        }


        //~~if there are empty elements in array, remove those.
        $description = array_diff($description, ['']);

        //~~ define array to convert current array into associatve array
        $features = [];
        $values = [];
        $simple_description = [];
        $features_values = [];
        $section_features_values = [];

        $x = 0;
        $rows_c = 0;
        foreach ($description as $line) {
            If ($strip_sections == 1 && strpos($line, "--") !== false && strpos($line, "--", 3) == true) {

            } else {

                $simple_description[$x] = $line;

                $strpos = strpos($line, $sep);
                if ($strpos === false) {
                    $description[$line] = "";
                } else {
                    $features[$x] = trim(substr($line, 0, $strpos));
                    $values[$x] = trim(substr($line, $strpos + 1));
                    $features_values[$features[$x]] = [
                        "value" => $values[$x],
                    ];
                    $rows_c++;
                }

                $x++;
                if ($rows_c == $rows) {
                    break;
                }
            }
        }


        if ($return == 0) {
            return $features;
        }
        if ($return == 1) {
            return $values;
        }
        if ($return == 3) {
            return $simple_description;
        }
        if ($return == 4) {
            return $features_values;
        }

    }

    public function whmpress_price_discount($billingcycle,$all_prices_array){

        $monthly_price      = isset($all_prices_array['monthly']) ? $all_prices_array["monthly"]["package"] - $all_prices_array["monthly"]["setup"] : '';
        $quarterly_price    = isset($all_prices_array['quarterly']) ? $all_prices_array["quarterly"]["package"] - $all_prices_array["quarterly"]["setup"] : '';
        $semiannually_price = isset($all_prices_array['semiannually']) ? $all_prices_array["semiannually"]["package"] - $all_prices_array["semiannually"]["setup"] : '';
        $anually_price      = isset($all_prices_array['annually']) ? $all_prices_array["annually"]["package"] - $all_prices_array["annually"]["setup"] : '';
        $biennially_price   = isset($all_prices_array['biennially']) ? $all_prices_array["biennially"]["package"] - $all_prices_array["biennially"]["setup"] : '';
        $triennially_price  = isset($all_prices_array['triennially']) ? $all_prices_array["triennially"]["package"] - $all_prices_array["triennially"]["setup"] : '';
        //== Actual price when monthly price is multiplied with relative billingcycle price
        $total_price_according_month = "";
        $per = "";

        //== calculate discount for quarterly billingcycle
        if ($billingcycle == "quarterly"){
            if ($monthly_price > 0) {
                $total_price_according_month = $monthly_price * 3;
                $per = round(100 - ($quarterly_price / ($monthly_price * 3) * 100), 0);
            } else {
                $per = "";
                $total_price_according_month = '';
            }
        }

        //== calculate discount for semi-annually billingcycle
        if ($billingcycle == 'semiannually'){
            if ($monthly_price > 0) {
                $total_price_according_month = $monthly_price * 6;
                $per = round(100 - ($semiannually_price / ($monthly_price * 6) * 100), 0);
            } else if ($quarterly_price > 0) {
                $total_price_according_month = '';
                $per = round(100 - ($semiannually_price / ($quarterly_price * 2) * 100), 0);
            } else {
                $per = "";
                $total_price_according_month = '';
            }
        }

        //== calculate discount for annually billingcycle
        if ($billingcycle == 'annually'){
            if ($monthly_price > 0) {
                $total_price_according_month = $monthly_price * 12;
                $per = round(100 - ($anually_price / ($monthly_price * 12) * 100), 0);
            } else if ($quarterly_price > 0) {
                $total_price_according_month = '';
                $per = round(100 - ($anually_price / ($quarterly_price * 4) * 100), 0);
            } else if ($semiannually_price > 0) {
                $total_price_according_month = '';
                $per = round(100 - ($anually_price / ($semiannually_price * 2) * 100), 0);
            } else {
                $total_price_according_month = '';
                $per = "0";
            }
        }

        //== calculate discount for bi-annually billingcycle
        if ($billingcycle == 'biennially'){
            if ($monthly_price > 0) {
                $total_price_according_month = $monthly_price * 24;
                $per = round(100 - ($biennially_price / ($monthly_price * 24) * 100), 0);
            } else if ($quarterly_price > 0) {
                $total_price_according_month = '';
                $per = round(100 - ($biennially_price/ ($quarterly_price * 8) * 100), 0);
            } else if ($semiannually_price > 0) {
                $total_price_according_month = '';
                $per = round(100 - ($biennially_price / ($semiannually_price * 4) * 100), 0);
            } else if ($anually_price > 0) {
                $total_price_according_month = '';
                $per = round(100 - ($biennially_price / ($anually_price * 2) * 100), 0);
            } else {
                $total_price_according_month = '';
                $per = "";
            }
        }

        //== calculate discount for tri-annually billingcycle
        if ($billingcycle == 'triennially'){
            if ($monthly_price > 0) {
                $total_price_according_month = $monthly_price * 36;
                $per = round(100 - ($triennially_price / ($monthly_price * 36) * 100), 0);
            } else if ($quarterly_price > 0) {
                $total_price_according_month = '';
                $per = round(100 - ($triennially_price / ($quarterly_price * 12) * 100), 0);
            } else if ($semiannually_price > 0) {
                $total_price_according_month = '';
                $per = round(100 - ($triennially_price / ($semiannually_price * 6) * 100), 0);
            } else if ($anually_price > 0) {
                $total_price_according_month = '';
                $per = round(100 - ($triennially_price / ($anually_price * 3) * 100), 0);
            } else {
                $per = "";
                $total_price_according_month = '';
            }
        }

        //== Combining both return values in one array
        $discount_price_array = [
            'percentage_discount'=> $per,
            'actual_price_according_monthly' => $total_price_according_month
        ];

        return $discount_price_array;
    }

    function return_all_tooltip()
    {
        global $wpdb;
        $Q = "SELECT * FROM `" . whmp_get_tooltips_table_name() . "`";

        $all_tooltip_data = $wpdb->get_results($Q, ARRAY_A);

        return $all_tooltip_data;

    }

    function detect_free_domain($product_id,$billingcycle){

        global $wpdb;
        $Q = "SELECT `name`,`description`,`freedomain`,`freedomainpaymentterms`,`freedomaintlds` FROM`" . get_mysql_table_name("tblproducts") . "`WHERE `id`=" . $product_id;
        $row = $wpdb->get_row($Q, ARRAY_A);

        //== check the free domain is attached with the product
        $free_domain_billingcycles = explode( ',', $row['freedomainpaymentterms'] );
        if ( ( (string) $row['freedomain'] == 'on' ) && ( in_array( $billingcycle, $free_domain_billingcycles ) )) {
            $free_domain = true;
        }else{
            $free_domain = false;
        }

        return $free_domain;
    }
}