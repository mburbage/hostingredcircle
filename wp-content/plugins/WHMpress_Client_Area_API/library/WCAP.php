<?php

class WCAP
{

    var $Path;
    var $URL;
    var $ShortCodes = [
        "whmcs_client_area",
        "wcap_logged_in_content",
        "wcap_logged_out_content",
        "wcap_whmcs_nav_menu",
        "wcap_login_form",
    ];
    var $shortcodeTitles = [
        "Client Area",
        "Logged in Content",
        "Logged out Content",
        "Navigation Menu",
    ];
    public $BillingCycleStrings = [
        "monthly" => "Monthly",
        "quarterly" => "Quarterly",
        "semiannually" => "6 Months",
        "annually" => "Yearly",
        "biennially" => "Bi Annually",
        "triennially" => "Tri Annually",
    ];
    public $YearPeriods = [
        "msetupfee",
        "qsetupfee",
        "ssetupfee",
        "asetupfee",
        "bsetupfee",
        "monthly",
        "quarterly",
        "semiannually",
        "annually",
        "biennially",
    ];
    var $Currencies;
    var $InvoiceAuthKey;
    var $AdminURL;
    var $AdminUser;
    var $AdminPass;
    var $PageURL;

    public function __construct()
    {
        $this->Path = WCAP_PATH;
        $this->URL = WCAP_URL;
        $this->Unique = "wcap_";            // It will use with get_option.
        $this->Currencies = $this->get_currencies2();

        $this->AutoAuthKey = get_option("whcom_whmcs_admin_api_key");
        $this->InvoiceAuthKey = get_option("whcom_whmcs_admin_auth_key");
        $this->AdminURL = get_option("whcom_whmcs_admin_url");
        $this->AdminUser = get_option("whcom_whmcs_admin_user");
        $this->AdminPass = get_option("whcom_whmcs_admin_pass");

        ## If session is not started then start a new PHP session.
        if (!session_id()) {
            session_start();
        }

        //add_action( 'init', [ $this, 'init' ] );

        if (is_admin()) {
            add_action('admin_menu', [$this, 'wcap_add_pages']);
            add_action('admin_enqueue_scripts', [$this, 'wcap_enqueue_admin_styles_scripts']);
            add_action('wp_ajax_wcap_admin_requests', [$this, 'admin_ajax']);
        }

        //$this->register_settings();

        foreach ($this->ShortCodes as $shortCode) {
            $path = $this->Path . "/library/shortcodes/{$shortCode}.php";
            if (!is_file($path)) {
                @touch($path);
            }

            if (is_file($path)) {
                add_shortcode($shortCode, [$this, 'shortcode']);
            }
        }

        ## Setting CSS and JS files for front-end
        add_action("wp_head", [$this, "use_my_styles"]);
        add_action('wp_enqueue_scripts', [$this, 'use_my_scripts']);

        add_action('wp_ajax_wcap_requests', [$this, 'ajax']);
        add_action('wp_ajax_nopriv_wcap_requests', [$this, 'ajax']);

        ## This hook executes before WP user authentication.

        //add_action( 'wp_authenticate', [ $this, 'whmcs_authentication' ], 30, 2 );
        //add_action( 'wp_authenticate_user', [ $this, 'whmcs_authentication_user' ], 10, 2 );

        ## This hook executes when WP user is logged in.
        add_action('wp_login', [$this, 'wp_login'], 40, 2);

        ## This hook is executes when new WP user registered.
        add_action('user_register', [$this, 'wp_user_register'], 40, 2);

        add_action('wp_logout', [$this, 'whmcs_logout_on_hook']);

        if (!empty(get_option("wcapfield_after_login_redirect_url"))) {
            add_filter('login_redirect', [$this, 'login_redirect'], 10, 3);
        }

        if (get_option("wcapfield_hide_wp_admin_bar") == "1") {
            show_admin_bar(false);
        }

        add_action('admin_enqueue_scripts', [$this, 'my_deregister_heartbeat']);
        add_action('admin_init', [$this, 'register_settings']);

        add_action('edit_user_profile', [$this, 'custom_user_profile_fields']);
    }

    /**
     * @author Shakeel Ahmed Siddiqi <shakeel@shakeel.pk>
     *
     * @param $user_id
     *
     * This function executes on new WP user registration and performs Sync options.
     */
    function wp_user_register($user_id)
    {
        /*
		 * If "Enable WHMCS SSO" option is not checked then do not perform WCAP Sync.
		 */
        if (!$this->is_sso_on()) {
            return;
        }

        ## Getting WP_User object
        $user = get_user_by("id", $user_id);

        ## Calling wp_login function
        $this->wp_login($user->data->user_login, $user);
    }

    /**
     * @author Shakeel Ahmed <shakeel@shakeel.pk>
     *
     * @param $user_login
     * @param $user
     *
     * This is called on WordPress login hook.
     */
    function wp_login($user_login, $user)
    {
        /*
		 * If "Enable WHMCS SSO" option is not checked then do not perform WCAP Sync.
		 */
        if (!$this->is_sso_on()) {
            return;
        }

        $data = [
            "email" => $user->data->user_email,
            "password" => $user->data->user_pass,
            "firstname" => get_user_meta($user->ID, "first_name", true),
            "lastname" => get_user_meta($user->ID, "last_name", true),
        ];

        if ($this->is_sync_address_on()) {
            $fields = $this->get_whmcs_record_array();
            foreach ($fields as $field) {
                $data[$field] = get_user_meta($user->ID, "whcom_" . $field, true);
            }

            $fields = $this->get_client_custom_fields()['data'];
            $customfields = [];
            $wcapfield_new_user_fields = get_option('wcapfield_new_user_fields');

            foreach ($fields as $field) {
                $field_name = $wcapfield_new_user_fields['wcapfield_new_user_' . $field["id"]];
                if (empty($field_name)) {
                    $field_name = "whcom_" . $field["id"];
                }

                $customfields[$field["id"]] = get_user_meta($user->ID, $field_name, true);
                if ($field["fieldtype"] == "link") {
                    $customfields[$field["id"]] = strip_tags($customfields[$field["id"]]);
                }
            }
            $data['customfields'] = $customfields;
        }

        $response = "";
        if (!$this->is_wp_user_restricted($user)) {
            ## Updating WHMCS user.
            //			$response = $this->update_whmcs_user_by_custom_api( $data );
            $data["remove_blank"] = 1;
            $response = $this->update_client($data);
        }

        if (substr($response, 0, 2) == "OK") {
            if (!session_id()) {
                session_start();
            }
            $user_array = json_decode(substr($response, 2), true);

            if (!$this->is_wp_user_restricted($user)) {
                ## Logging in WHMCS user.
                whcom_validate_client(["email" => $user->data->user_email, "pass" => $_POST["pwd"]]);
            }

            /*
						$_SESSION["whmcs_user"]["username"]     = $user->data->user_email;
						$_SESSION["whmcs_user"]["password"]     = $user->data->user_pass;
						$_SESSION["whmcs_user"]["userid"]       = $user_array["id"];
						$_SESSION["whmcs_user"]["passwordhash"] = $user->data->user_pass;
						$_SESSION["whmcs_user"]["client"]       = $user_array;*/
            //$this->show_array( $_SESSION); die;
        }


        ## If SSO enabled and URL available in settings then system will redirect.
        $redirect_url = get_option("wcapfield_after_login_redirect_url");
        if (!empty($redirect_url)) {
            wp_redirect($redirect_url);
        }
    }

    function update_whmcs_user_by_custom_api($user_array)
    {
        $args = [
            "wcap_db_request" => "",
            "action" => "update_client",
            "hash" => md5($this->AutoAuthKey . "creativeON"),
            "currency" => "",
            "postdata" => $user_array,
        ];

        $postdata = $args["postdata"];
        unset($args["postdata"]);
        $response = $this->curl_get_file_contents($args, $postdata);

        return $response;
    }

    function my_deregister_heartbeat()
    {
        /*        global $pagenow;

                if ('post.php' != $pagenow && 'post-new.php' != $pagenow) {
                    wp_deregister_script('heartbeat');
                    wp_register_script('heartbeat', false);
                }*/
    }

    function get_currencies2()
    {
        $currs = $this->get_currencies();

        if (!is_array($currs)) {
            return [];
        }

        $return_array = [];
        foreach ($currs as $curr) {
            if (isset($curr["code"])) {
                $return_array[$curr["code"]] = $curr;
            }
        }

        return $return_array;
    }

    function get_currencies()
    {
        return whcom_get_all_currencies();
    }

    /**
     * @param string $args
     *
     * @return mixed|string
     *
     * This method will return data after executing WHMCS API.
     */
    public function run_whmcs_api($args = "")
    {
        $default = [
            "action" => "",
        ];

        $args = wp_parse_args($args, $default);
        extract($args);

        //---wcapsetting
        $args['username'] = $this->AdminUser;
        $args['password'] = md5($this->AdminPass);
        $args['responsetype'] = 'json';
        $args['clientip'] = $this->get_ip();

        $url = trim($this->AdminURL);


        if (empty($url)) {
            return "Error!\n\nWHMCS url is not provided.\nPlease visit settings page in admin panel and provide valid WHMCS URL";
        }

        if (substr($url, "0", 4) <> "http") {
            $url = "http://" . $url;
        }

        if (!$this->is_url($url)) {
            return "WHMCS url is not valid.\n\n\"$url\"";
        }

        $url = rtrim($url, "/") . "/";

        if ($this->is_developer_machine()) {

        }

        //---wcapsetting
        $args['accesskey'] = $this->AutoAuthKey;
        $args["whmp_ip"] = $_SERVER["REMOTE_ADDR"];

        // Call the API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . 'includes/api.php');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($args));
        $response = curl_exec($ch);

        if (curl_error($ch)) {
            return (esc_html__('Unable to connect: ', "whcom") . curl_errno($ch) . ' - ' . curl_error($ch));
        }
        curl_close($ch);

        $jsonData = json_decode($response, true);

        /*if ($this->is_json($jsonData)) {
			$jsonData = json_decode( $jsonData, true);
		}*/

        return $jsonData;
    }

    /*function whmcs_authentication_user( $user, $password ) {
		## If Sync option is not enabled then skip this function.
		if ( get_option( "wcapfield_enable_sync" ) <> "1" ) {
			return $user;
		}

		if ( ! empty( $_SESSION["whmpress_authentication_error"] ) ) {
			$user_error = new WP_Error( '100', $_SESSION["whmpress_authentication_error"] );
			unset( $_SESSION["whmpress_authentication_error"] );

			return $user_error;
		}

		unset( $_SESSION["whmpress_authentication_error"] );

		return $user;
	}*/

    function get_ip()
    {
        foreach (
            [
                'HTTP_CLIENT_IP',
                'HTTP_X_FORWARDED_FOR',
                'HTTP_X_FORWARDED',
                'HTTP_X_CLUSTER_CLIENT_IP',
                'HTTP_FORWARDED_FOR',
                'HTTP_FORWARDED',
                'REMOTE_ADDR',
            ] as $key
        ) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                        return $ip;
                    }
                }
            }
        }

        return "";
    }

    public function is_url($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
            return true;
        } else {
            return false;
        }
    }

    function is_developer_machine()
    {
        return is_dir("D:/games");
    }

    function register_settings()
    {

        /*register_setting( 'whmpress_common', 'whmcs_admin_url' );
		register_setting( 'whmpress_common', 'whmcs_admin_user' );
		register_setting( 'whmpress_common', 'whmcs_admin_pass' );
		register_setting( 'whmpress_common', 'whmcs_admin_api_key' );
		register_setting( 'whmpress_common', 'whmcs_admin_auth_key' );*/

        register_setting('wcap_sso', 'wcapfield_enable_sync');
        register_setting('wcap_sso', 'wcapfield_sync_direction');
        register_setting('wcap_sso', 'wcapfield_new_user_role');
        register_setting('wcap_sso', 'wcapfield_new_user_username');
        register_setting('wcap_sso', 'wcapfield_new_user_profile_fields');
        register_setting('wcap_sso', 'wcapfield_new_user_address_phone_fields');
        register_setting('wcap_sso', 'wcapfield_exclude_sync_roles');
        register_setting('wcap_sso', 'wcapfield_sync_priority');
        register_setting('wcap_sso', 'wcapfield_last_sync_performed_on');
        register_setting('wcap_sso', 'wcapfield_perform_one_time_sync');
        register_setting('wcap_sso', 'wcapfield_enable_sso');
        register_setting('wcap_sso', 'wcapfield_hide_wp_admin_bar');
        register_setting('wcap_sso', 'wcapfield_new_user_fields');

        //-- after login menu
        register_setting('wcap_general', 'wcapfield_hide_whmcs_menu');
        register_setting('wcap_general', 'wcapfield_hide_whmcs_menu_sections');
        //-- frontend menu
        register_setting('wcap_general', 'wcapfield_hide_whmcs_menu_front');
        register_setting('wcap_general', 'wcapfield_hide_whmcs_menu_sections_front');
        //-- order process menu
        register_setting('wcap_general', 'wcapfield_hide_whmcs_menu_op');

        register_setting('wcap_general', 'wcapfield_client_area_url' . whcom_get_current_language());
        register_setting('wcap_general', 'wcapfield_whmcs_redirect_url');
        register_setting('wcap_general', 'wcapfield_after_login_redirect_url' . whcom_get_current_language());
        register_setting('wcap_general', 'wcapfield_after_logout_redirect_url' . whcom_get_current_language());
        register_setting('wcap_general', 'wcapfield_show_invoice_as');
        register_setting('wcap_general', 'wcapfield_enable_sidebar');
        register_setting('wcap_general', 'wcapfield_curl_timeout');


        register_setting('wcap_registration', 'wcap_registration_email');
        register_setting('wcap_registration', 'wcap_registration_code');
        register_setting('wcap_registration', 'wcap_registration_status');
    }

    function is_sync_on()
    {
        return get_option("wcapfield_enable_sync") == "1";
    }

    function logout_redirect($logout_url, $redirect)
    {
        return get_option("wcapfield_after_logout_redirect_url");
    }

    function login_redirect($redirect_to, $request, $user)
    {
        return get_option("wcapfield_after_login_redirect_url");
    }


    function whmcs_logout_on_hook()
    {
        if ($this->is_sso_on()) {
            if (is_email(@$wp_user->data->user_email)) {
                whcom_client_log_out();

                if (!empty(get_option("wcapfield_after_logout_redirect_url"))) {
                    wp_redirect(get_option("wcapfield_after_logout_redirect_url"));
                    exit;
                }
            }
        }
    }

    function is_sso_on()
    {
        return get_option("wcapfield_enable_sso") == "1";
    }

    function whmcs_authentication($username, $password)
    {
        unset($_SESSION["whmpress_authentication_error"]);

        if (get_option("wcapfield_sync_direction") == "wp_to_whmcs") {
            if (!$this->is_wp_user_valid($username, $password)) {
                return false;
            }

            if (is_email($username)) {
                $email = $username;
            } else {
                $user = get_user_by("login", $username);
                if (!$user) {
                    $user = get_user_by("email", $username);
                }
                $email = $user->email;
            }

            $whmcs_user = $this->get_clients_details("email=" . $email);

            if (isset($whmcs_user["client"]["userid"])) {
                $whmcs_user = $whmcs_user["client"];
                if (!password_verify($password, $whmcs_user["password"])) {
                    // Update WHMCS password
                    $this->update_client("email={$email}&password2=$password");
                }
            } else {
                // Create WHMCS account.
                $response = $this->create_whmcs_user_by_wp($email, $password);
                if ($response <> "OK") {
                    return $response;
                }
            }

            if ($this->is_sso_on()) {
                whcom_validate_client([
                    "email" => $email,
                    "pass" => $password,
                ]);

                /*if ( is_array( $whmcs_user["client"] ) ) {
					$whmcs_user                       = $whmcs_user["client"];
					$_SESSION["whmcs_user"]["client"] = $whmcs_user;
				}*/
            }
        } else {
            if (is_email($username)) {
                $email = $username;
            } else {
                $user = get_user_by('login', $username);
                if (!$user) {
                    $user = get_user_by('email', $username);
                }

                if (!$user) {
                    return false;
                }
            }

            ## If direction is WHMCS to WordPress
            $response = $this->run_whmcs_api([
                "action" => "ValidateLogin",
                "email" => $username,
                "password2" => $password,
            ]);

            if (!isset($response["result"])) {
                echo print_r($response, true);
                die;
                $user_error = new WP_Error('100', print_r($response, true));

                return $user_error;
            } else if ($response["result"] == "success") {
                if ($this->is_sso_on()) {
                    whcom_validate_client([
                        "email" => $email,
                        "pass" => $password,
                    ]);

                    /*$user_array = $this->get_clients_details( "clientid=" . $response["userid"] );
					if ( is_array( $user_array["client"] ) ) {
						$user_array                       = $user_array["client"];
						$_SESSION["whmcs_user"]["client"] = $user_array;
					}*/
                }
            } else {
                echo $response["message"];
                die;
                $user_error = new WP_Error('authentication_failed', $response["message"]);

                return $user_error;
                /*echo $_SESSION["whmpress_authentication_error"] = $response["message"];

				return false;*/
            }

            if (!$this->is_wp_user($email)) {
                ## If WordPress user doesn't exists, then create it.
                $this->create_wp_user_from_whmcs($email, $password);
            } else if (!$this->is_wp_user_valid($email, $password)) {
                ## If password doesn't match with wordpress then set WordPress password.
                $this->wp_update_password($email, $password);
            }
        }
    }

    function is_wp_user_valid($username, $password)
    {
        $user = get_user_by("login", $username);
        if (!$user) {
            $user = get_user_by("email", $username);
        }
        if (!$user) {
            return false;
        }
        if (wp_check_password($password, $user->data->user_pass, $user->ID)) {
            return true;
        } else {
            return false;
        }
    }

    //todo: update this functions, and make sepcial if helper
    function is_whmcs_user_exists($email)
    {
        $args = [
            "email" => $email,
            "stats" => true,
            "set_currency" => "0",
            "action" => "GetClientsDetails",
        ];
        extract($args);


        $response = $this->run_whmcs_api($args);

        if (!isset($response["result"])) {
            return print_r($response, true);
        } else if ($response["result"] == "success") {
            return "success";
        } else {
            return $response["message"];
        }

    }

    public function get_clients_details($args = "")
    {
        $default = [
            "clientid" => "",
            "email" => "",
            "stats" => true,
            "set_currency" => "0",
        ];

        $args = wp_parse_args($args, $default);
        $args["action"] = "GetClientsDetails";
        extract($args);

        if (empty($clientid)) {
            $clientid = whcom_get_current_client_id();
        }

        if ($args["clientid"] == "") {
            unset($args["clientid"]);
        }
        if ($args["email"] == "") {
            unset($args["email"]);
        }

        $response = $this->run_whmcs_api($args);
        if (!isset($response["result"])) {
            return print_r($response, true);
        } else if ($response["result"] == "success") {
            if (!isset($response["invoices"]["invoice"])) {
                $response["invoices"]["invoice"] = [];
            }
            if ((!empty($set_currency)) && $set_currency == "1" && isset($response["client"]["currency"])) {
                $currencies = $this->get_currencies();
                foreach ($currencies as $cur) {
                    if ($response["client"]["currency"] == $cur["id"]) {
                        $_SESSION["wcap_currency"] = $cur;
                    }
                }
            }

            return $response;
        } else {
            return $response["message"];
        }
    }

    public function get_clients_accounts($args = "")
    {
        $default = [
            "clientid" => "",
            "email" => "",
            "stats" => true,
        ];
        $args = wp_parse_args($args, $default);
        $args["action"] = "GetContacts";
        extract($args);

        if (empty($clientid)) {
            $clientid = whcom_get_current_client_id();
        }

        if ($args["clientid"] == "") {
            unset($args["clientid"]);
        }
        if ($args["email"] == "") {
            unset($args["email"]);
        }

        $response = $this->run_whmcs_api($args);

        if (!isset($response["result"])) {
            return print_r($response, true);
        } else if ($response["result"] == "success") {
            return $response;
        } else {
            return $response["message"];
        }
    }

    public function add_clients_contact($args = "")
    {
        $default = [
            "clientid" => '',
            "permissions" => [],
        ];
        $args = wp_parse_args($args, $default);

        $args['clientid'] = whcom_get_current_client_id();
        $args['permissions'] = implode(',', $args['permissions']);
        $args["action"] = "AddContact";

        $response = $this->run_whmcs_api($args);

        if (isset($response["result"]) && $response["result"] == "success") {
            $response["message"] = esc_html__('Changes Saved Successfully!', "whcom");
        }

        echo json_encode($response, JSON_FORCE_OBJECT);
        die();
    }

    public function update_contact($args = "")
    {
        $default = [
            "clientid" => '',
            "permissions" => [],
        ];
        $args = wp_parse_args($args, $default);

        $args['clientid'] = whcom_get_current_client_id();
        $args['permissions'] = implode(',', $args['permissions']);
        $args["action"] = "UpdateContact";

        $res = whcom_process_api($args);

        $response = [
            'status' => 'ERROR',
            'errors' => [],
            'message' => esc_html__("Something went wrong", "whcom"),
        ];

        // process api
        $res = whcom_process_api($args);
        $response["api_response"] = $res;

        if (isset($res["result"]) && $res["result"] == "error") {
            $title = esc_html__("Error", "whcom");
            $response["message"] = wcap_render_message(
                $title,
                wcap_translate_api_respone($res["message"]),
                "danger");

        } else if (isset($res["result"]) && $res["result"] == "success") {
            $response["status"] = "OK";
            $message = esc_html__("Changes Saved Successfully!", "whcom");
            $response["message"] = wcap_render_message("", $message, "success");

        } else {
            $response["errors"] = $res;
        }

        return json_encode($response, JSON_FORCE_OBJECT);
    }

    public function delete_contact($args = "")
    {
        $default = [
            "clientid" => '',
            "permissions" => [],
        ];
        $args = wp_parse_args($args, $default);

        $args['clientid'] = whcom_get_current_client_id();
        $args['permissions'] = implode(',', $args['permissions']);
        $args["action"] = "DeleteContact";

        $response = [
            'status' => 'ERROR',
            'errors' => [],
            'message' => esc_html__("Something went wrong", "whcom"),
        ];

        // process api
        $res = whcom_process_api($args);
        $response["api_response"] = $res;

        if (isset($res["result"]) && $res["result"] == "error") {
            $title = esc_html__("Error", "whcom");
            $response["message"] = wcap_render_message(
                $title,
                wcap_translate_api_respone($res["message"]),
                "danger");

        } else if (isset($res["result"]) && $res["result"] == "success") {
            $response["status"] = "OK";
            $message = esc_html__("Contact Deleted Successfully!", "whcom");
            $response["message"] = wcap_render_message("", $message, "success");
            $response["action_dont_hide"] = "YES";
            $response["action_refresh"] = "YES";

        } else {
            $response["errors"] = $res;
        }

        echo json_encode($response, JSON_FORCE_OBJECT);
        die();
    }

    function get_whmcs_users($args = "")
    {
        $default = [
            "wcap_db_request" => "",
            "action" => "get_clients",
            "hash" => md5($this->AutoAuthKey . "creativeON"),
            "currency" => "",
            "id" => "",
        ];

        $args = wp_parse_args($args, $default);

        $response = $this->curl_get_file_contents($args);
        if ($this->is_json($response)) {
            $response = json_decode($response, true);
        } else {
            $response = [];
        }

        return $response;
    }

    /**
     * @param string $field
     *
     * This will return whmcs logged in data user.
     */
    function get_user_data($field = "")
    {
        $client_row = whcom_get_client(whcom_get_current_client_id());


        if (empty($field)) {
            if (!isset($client_row["client"])) {
                return [];
            } else {
                return $client_row["client"];
            }
        } else {
            if ($field == "id") {
                $field = "userid";
            }
            $fields = explode("_", $field);

            if (count($fields) == 1) {
                if (!isset($client_row["client"][$field])) {
                    return "";
                } else {

                    return $client_row["client"][$field];

                }
            } else {
                if (!isset($client_row["client"][$fields[0]][$fields[1]])) {
                    return "";
                } else {
                    return $client_row["client"][$fields[0]][$fields[1]];
                }
            }
        }
    }

    public function update_client($args = "")
    {
        $default = [
            "clientid" => "",
            "firstname" => "",
            "lastname" => "",
            "companyname" => "",
            "email" => "",
            "address1" => "",
            "address2" => "",
            "city" => "",
            "state" => "",
            "phonenumber" => "",
            "postcode" => "",
            "country" => "",
            "password2" => "",
            "remove_blank" => "0",
            "currency" => whcom_get_current_currency_id(),
            "customfields" => "",
        ];

        $args = wp_parse_args($args, $default);


        if ($args["password2"] == "") {
            unset($args["password2"]);
        }

        if (empty($args["clientid"]) && is_email($args["email"])) {
            unset($args["clientid"]);
            $args["clientemail"] = $args["email"];
        }

        if ($args["remove_blank"] == "1") {
            foreach ($args as $k => $v) {
                if ($v == "") {
                    unset($args[$k]);
                }
            }
        }
        unset($args["remove_blank"]);

        if (isset($args["password2"]) && $args["password2"] == "") {
            unset($args["password2"]);
        }

        $args["action"] = "UpdateClient";
        if (!empty($args['customfields'])) {
            $customfields = $args['customfields'];
            $args['customfields'] = base64_encode(serialize($customfields));
        }

        $response = whcom_process_api($args);

        return json_encode($response);
    }

    function create_whmcs_user_by_wp($wp_user, $password)
    {
        $user = get_user_by("login", $wp_user);
        if (!$user) {
            $user = get_user_by("email", $wp_user);
        }
        if (!$user) {
            return esc_html__("Invalid WordPress user info", "whcom");
        }

        $firstname = get_the_author_meta("first_name", $user->ID);
        $lastname = get_the_author_meta("last_name", $user->ID);

        $country = $this->get_country();

        if (empty($firstname)) {
            $firstname = "FirstName";
        }
        if (empty($lastname)) {
            $lastname = "LastName";
        }

        $data = [
            "firstname" => $firstname,
            "lastname" => $lastname,
            "email" => $user->data->user_email,
            "country" => $country,
            "password1" => $password,
            "password2" => $password,
        ];

        $data["address1"] = (get_the_author_meta("address1", $user->ID) == "" ? "Address 1" : get_the_author_meta("address1", $user->ID));
        $data["address2"] = (get_the_author_meta("address2", $user->ID) == "" ? "Address 2" : get_the_author_meta("address2", $user->ID));
        $data["city"] = (get_the_author_meta("city", $user->ID) == "" ? "Enter City" : get_the_author_meta("city", $user->ID));
        $data["state"] = (get_the_author_meta("state", $user->ID) == "" ? "Enter State" : get_the_author_meta("state", $user->ID));
        $data["postcode"] = (get_the_author_meta("postcode", $user->ID) == "" ? "012345" : get_the_author_meta("postcode", $user->ID));
        $data["phonenumber"] = (get_the_author_meta("phonenumber", $user->ID) == "" ? "12345678" : get_the_author_meta("phonenumber", $user->ID));

        return $this->register_new_client($data);
    }

    function get_country()
    {
        $json = @file_get_contents('http://getcitydetails.geobytes.com/GetCityDetails?fqcn=' . $this->get_ip());
        $data = json_decode($json, true);
        $country = @$data['geobytesinternet'];
        if (strlen($country) <> "2") {
            $country = "US";
        }

        return $country;
    }

    public function register_new_client($args = "")
    {
        $default = [
            "firstname" => "",
            "lastname" => "",
            "companyname" => "",
            "email" => "",
            "password" => "",
            "password2" => "",
            "address1" => "",
            "address2" => "",
            "city" => "",
            "state" => "",
            "postcode" => "",
            "country" => "",
            "phonenumber" => "",
        ];
        $args = wp_parse_args($args, $default);

        $response = [
            "status" => "ERROR",
            "message" => "Nothing done yet!"
        ];
        $args["action"] = "AddClient";
        $customfields = (isset($_POST['customfields'])) ? $_POST['customfields'] : [];

        $args['customfields'] = base64_encode(serialize($customfields));

        if ($args["password"] <> $args["password2"]) {
            $response["message"] = "Password confirmation is not OK";
        } else if ($args["password"] == "") {
            $response["message"] = "Password missing";
        } else {
            $response = whcom_register_new_client($args);

        }

        if ($this->is_json($response)) {
            return $response;
        }

        return json_encode($response);

    }

    function is_wp_user($username)
    {
        $user = get_user_by("login", $username);
        if (!$user) {
            $user = get_user_by("email", $username);
        }
        if (!$user) {
            return false;
        }

        return true;
    }

    //	function wcap_load_help_page() {
    //		require_once( $this->Path . "/admin/pages/help.php" );
    //	}

    function update_wp_user_from_whmcs($whmcs_row)
    {
        if (!is_array($whmcs_row) && is_email($whmcs_row)) {
            $whmcs_row = $this->get_whmcs_users("email=" . $whmcs_row);
            if (isset($whmcs_row[0]["id"])) {
                $whmcs_row = $whmcs_row[0];
            } else {
                $whmcs_row = [];
            }
        }
        //$this->show_array( $whmcs_row); die;

        if (!isset($whmcs_row["email"]) || !isset($whmcs_row["password"])) {
            return "Please provide valid WHMCS data";
        }
        $user = get_user_by("email", $whmcs_row["email"]);
        if (!$user) {
            return "WP user not found.";
        }
        $skip_roles = get_option("wcapfield_exclude_sync_roles");
        if (is_array($skip_roles)) {
            foreach ($skip_roles as $role) {
                if (is_array($user->roles) && in_array($role, $user->roles)) {
                    return $role . " is not allowed to update.";
                }
            }
        }

        $data = [
            "user_pass" => $whmcs_row["password"],
        ];

        global $wpdb;
        $response = $wpdb->update($wpdb->prefix . "users", $data, ["ID" => $user->ID]);

        if ($response === false) {
            return $wpdb->last_error;
        }

        update_user_meta($user->ID, "first_name", $whmcs_row["firstname"]);
        update_user_meta($user->ID, "last_name", $whmcs_row["lastname"]);
        update_user_meta($user->ID, "display_name", $whmcs_row["firstname"] . " " . $whmcs_row["lastname"]);

        if ($this->is_sync_address_on()) {
            $wcapfield_new_user_fields = get_option('wcapfield_new_user_fields');
            $fields_array = $this->get_whmcs_record_array();
            foreach ($fields_array as $field) {
                $field_name = @$wcapfield_new_user_fields["wcapfield_new_user_" . $field];
                if (empty($field_name)) {
                    $field_name = "whcom_" . $field;
                }
                update_user_meta($user->ID, $field_name, @$whmcs_row[$field]);
            }

            $customfields = $this->get_clients_details("clientid=" . $whmcs_row["id"]);
            if (isset($customfields["client"]["customfields"]) && is_array($customfields["client"]["customfields"])) {
                $customfields = $customfields["client"]["customfields"];
            } else {
                $customfields = [];
            }

            $custom_fields = $this->get_client_custom_fields()['data'];
            foreach ($custom_fields as $custom_field) {
                $field_name = $wcapfield_new_user_fields['wcapfield_new_user_' . $custom_field["id"]];
                if (empty($field_name)) {
                    $field_name = "whcom_" . $custom_field["id"];
                }

                $val = "";
                foreach ($customfields as $customfield) {
                    if ($custom_field["id"] == $customfield["id"]) {
                        $val = $customfield["value"];
                        continue;
                    }
                }
                update_user_meta($user->ID, $field_name, $val);
            }
        }

        return "OK";
    }

    /**
     * @author Shakeel Ahmed Siddiqi <shakeel@shakeel.pk>
     * @return bool
     *
     * Returns true if Sync Address option is enabled in SSO Settings page in Admin Panel.
     */
    function is_sync_address_on()
    {
        return get_option("wcapfield_new_user_profile_fields") == "1";
    }

    function create_wp_user_from_whmcs_row($whmcs_row)
    {
        //todo: check user row using email field
        if (!isset($whmcs_row["firstname"])) {
            return esc_html__("Provide valid WHMCS user row", "whcom");
        }
        $role = get_option("wcapfield_new_user_role");
        if (empty($role)) {
            $role = "subscriber";
        }

        if (get_option("wcapfield_new_user_username") == "first_last") {
            $new_username = strtolower(trim($whmcs_row["firstname"] . " " . $whmcs_row["lastname"]));
        } else {
            $new_username = strtolower(trim($whmcs_row["email"]));
        }

        $userdata = [
            'user_login' => $new_username,
            'user_email' => strtolower(trim($whmcs_row["email"])),
            'user_pass' => "Testing123**",
            'first_name' => $whmcs_row['firstname'],
            'last_name' => $whmcs_row['lastname'],
            'display_name' => $whmcs_row['firstname'] . " " . $whmcs_row['lastname'],
            'description' => esc_html__("User created by WHMCS Client Area", "whmpress"),
            'role' => $role,
        ];

        $user_id = wp_insert_user($userdata);

        $user = get_user_by("email", $whmcs_row["email"]);
        global $wpdb;
        if (!is_wp_error($user_id)) {
            $wpdb->update($wpdb->prefix . "users", ["user_pass" => $whmcs_row["password"]], ["ID" => $user_id]);

            if ($this->is_sync_address_on()) {
                $wcapfield_new_user_fields = get_option('wcapfield_new_user_fields');
                $fields_array = $this->get_whmcs_record_array();

                foreach ($fields_array as $field) {
                    $field_name = @$wcapfield_new_user_fields["wcapfield_new_user_" . $field];
                    if (empty($field_name)) {
                        $field_name = "whcom_" . $field;
                    }
                    update_user_meta($user->ID, $field_name, @$whmcs_row[$field]);
                }

                $customfields = $this->get_clients_details("clientid=" . $whmcs_row["id"]);
                if (isset($customfields["client"]["customfields"]) && is_array($customfields["client"]["customfields"])) {
                    $customfields = $customfields["client"]["customfields"];
                } else {
                    $customfields = [];
                }

                $custom_fields = $this->get_client_custom_fields()['data'];
                foreach ($custom_fields as $custom_field) {
                    $field_name = $wcapfield_new_user_fields['wcapfield_new_user_' . $custom_field["id"]];
                    if (empty($field_name)) {
                        $field_name = "whcom_" . $custom_field["id"];
                    }

                    $val = "";
                    foreach ($customfields as $customfield) {
                        if ($custom_field["id"] == $customfield["id"]) {
                            $val = $customfield["value"];
                            continue;
                        }
                    }
                    update_user_meta($user->ID, $field_name, $val);
                }
            }

            return "OK";
        }

        return esc_html__("Can't create WP user", "whmpress");
    }


    function custom_user_profile_fields($user)
    {
        $whmcs_fields = get_option('wcapfield_new_user_fields');
        $user_data = get_user_meta($user->ID);
        ?>
        <?php if (!empty($whmcs_fields) && is_array($whmcs_fields)) { ?>
        <h3 class="heading"><?php esc_html_e('WHMCS Fields', 'whcom') ?></h3>
        <table class="form-table">
            <?php foreach ($whmcs_fields as $whmcs_field) { ?>
                <?php if (!empty($user_data[$whmcs_field])) { ?>
                    <tr>
                        <th><label><?php echo $whmcs_field ?></label></th>
                        <td><input type="text" class="regular-text"
                                   value="<?php echo esc_html($user_data[$whmcs_field][0]); ?>" disabled placeholder="">
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </table>
    <?php } ?>

        <?php
    }

    function create_wp_user_from_whmcs($whmcs_username, $password)
    {
        if (empty($role)) {
            $role = '';
        }

        if (empty($role)) {
            $role = get_option("wcapfield_new_user_role");
        }
        if (empty($role)) {
            $role = "subscriber";
        }

        $w_user = $this->get_clients_details("email=" . $whmcs_username);


        if (!isset($w_user['client']['firstname'])) {
            return esc_html__("WHMCS user not found", "whcom");
        }
        $w_user = $w_user['client'];

        $userdata = [
            'user_login' => $whmcs_username,
            'user_email' => $whmcs_username,
            'user_pass' => $password,
            'first_name' => $w_user['firstname'],
            'last_name' => $w_user['lastname'],
            'display_name' => $w_user['fullname'],
            'description' => esc_html__("User created by WHMCS Client Area", "whmpress"),
            'role' => $role,
        ];

        $user_id = wp_insert_user($userdata);
        if (!is_wp_error($user_id)) {


            if ($this->is_sync_address_on()) {

                $user = get_user_by("email", $w_user["email"]);
                $wcapfield_new_user_fields = get_option('wcapfield_new_user_fields');
                $fields_array = $this->get_whmcs_record_array();

                foreach ($fields_array as $field) {
                    $field_name = @$wcapfield_new_user_fields["wcapfield_new_user_" . $field];
                    if (empty($field_name)) {
                        $field_name = "whcom_" . $field;
                    }
                    update_user_meta($user->ID, $field_name, @$w_user[$field]);
                }

                $customfields = $this->get_clients_details("clientid=" . $w_user["id"]);
                if (isset($customfields["client"]["customfields"]) && is_array($customfields["client"]["customfields"])) {
                    $customfields = $customfields["client"]["customfields"];
                } else {
                    $customfields = [];
                }

                $custom_fields = $this->get_client_custom_fields()['data'];
                foreach ($custom_fields as $custom_field) {
                    $field_name = $wcapfield_new_user_fields['wcapfield_new_user_' . $custom_field["id"]];
                    if (empty($field_name)) {
                        $field_name = "whcom_" . $custom_field["id"];
                    }

                    $val = "";
                    foreach ($customfields as $customfield) {
                        if ($custom_field["id"] == $customfield["id"]) {
                            $val = $customfield["value"];
                            continue;
                        }
                    }
                    update_user_meta($user->ID, $field_name, $val);
                }
            }

            return "OK";
        }

        return esc_html__("Can't create WP user", "whmpress");
    }

    function wp_update_password($email_or_user, $password)
    {
        $user = get_user_by("login", $email_or_user);
        if (!$user) {
            $user = get_user_by("email", $email_or_user);
        }
        if (!$user) {
            return false;
        }

        wp_set_password($password, $user->ID);

        return true;
    }

    function get_option($key_name)
    {
        return get_option($this->Unique . $key_name);
    }

    function array_to_xml($data, &$xml_data)
    {
        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                $key = 'item' . $key; //dealing with <0/>..<n/> issues
            }
            if (is_array($value)) {
                $subnode = $xml_data->addChild($key);
                $this->array_to_xml($value, $subnode);
            } else {
                $xml_data->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }

    //logged in menu
    public function get_menu_array()
    {

        $WCAP_Menu[0] = [
            "label" => esc_html_x("Home", "menu", "whcom"),
            "page" => "dashboard",
            "class" => "wcap_load_page",
            "show" => true,
        ];

        $WCAP_Menu[10] = [
            "label" => esc_html_x("Services", "menu", "whcom"),
            "page" => "#",
            "class" => "no_load",
            "show" => true,
        ];
        $WCAP_Menu[10]["sub"]['my_services'] = [
            "label" => esc_html_x("My Services", "menu", "whcom"),
            "page" => "services",
            "class" => "wcap_load_page",
            "show" => true,
        ];
        $WCAP_Menu[10]["sub"]['my_services_separator'] = [
            "label" => "Separator",
            "show" => true,
        ];


        //todo: wcom links should open in new windows
        $wcop_active = wcap_is_wcop_active();
        if ($wcop_active) {
            $class = "";
            $field = 'configure_product' . whcom_get_current_language();
            $base_url = esc_attr(get_option($field, ''));

            $services_data = "";
            $services_url = $base_url . "?order_type=order_product";

            $domains_register_data = "";
            $domains_register_url = $base_url . "?a=add&domain=register";

            $domains_transfer_data = "";
            $domains_transfer_url = $base_url . "?a=add&domain=transfer";

        } else {
            $class = "wcap_load_page";

            $services_data = "order_new_service";
            $services_url = "";

            /*            "page" => "order_process",
                        "href"  => "a=add&domain=register"*/
            $domains_register_data = "order_process";
            $domains_register_url = "a=add&domain=register";

            /*            "page" => "order_process",
                        "href"  => "a=add&domain=transfer"*/

            $domains_transfer_data = "order_process";
            $domains_transfer_url = "a=add&domain=transfer";
        }


        $WCAP_Menu[10]["sub"]['order_new_services'] = [
            "label" => esc_html_x("Order New Services", "menu", "whcom"),
            "page" => $services_data,
            "class" => $class,
            "href" => $services_url,
            "icon" => "whcom_icon_basket-1",
            "show" => true,

        ];

        $WCAP_Menu[10]["sub"]['addons'] = [
            "label" => esc_html_x("View Available Addons", "menu", "whcom"),
            "page" => "addons",
            "class" => "wcap_load_page",
            "icon" => "whcom_icon_puzzle",
            "show" => true,
        ];

        //-----------domains------------
        $WCAP_Menu[20] = [
            "label" => esc_html_x("Domains", "menu", "whcom"),
            "page" => "#",
            "class" => "no_load",
            "show" => true,
        ];
        $WCAP_Menu[20]["sub"]['my_domains'] = [
            "label" => esc_html_x("My Domains", "menu", "whcom"),
            "page" => "domains",
            "class" => "wcap_load_page",
            "show" => true,
        ];
        $WCAP_Menu[20]["sub"]['my_domains_separator'] = [
            "label" => "Separator",
            "show" => true,
        ];


        $WCAP_Menu[20]["sub"]['domain_renewals'] = [
            "label" => esc_html_x("Renew Domains", "menu", "whcom"),
            "page" => "domain_renewals",
            "class" => "wcap_load_page",
            "icon" => "whcom_icon_arrows-cw",
            "show" => true,
        ];


        $WCAP_Menu[20]["sub"]['domain_register'] = [
            "label" => esc_html_x("Register a new Domain", "menu", "whcom"),
            "class" => $class,

            "page" => $domains_register_data,
            "href" => $domains_register_url,
            "icon" => "whcom_icon_globe-1",
            "show" => true,
        ];

        //?whmpca=order_process&a=add&domain=register

        $WCAP_Menu[20]["sub"]['domain_transfer'] = [
            "label" => esc_html_x("Transfer Domains to Us", "menu", "whcom"),
            "class" => $class,

            "page" => $domains_transfer_data,
            "href" => $domains_transfer_url,
            "icon" => "whcom_icon_forward",
            "show" => true,
        ];

        //todo: enable when defaults are implimented
        //todo: default value will be of domain search page of (we may ask in settings)
        /*        $WCAP_Menu[20]["sub"]['search_separator'] = [ "label" => "Separator" ];

				$WCAP_Menu[20]["sub"]['search'] = [
					"label" => esc_html_x( "Domain Search", "menu", "whcom" ),
					"page"  => "",
					"class" => "",
					"href"  => "",
				];*/
        //$WCAP_Menu[20]["sub"][] = [ "label" => esc_html__( "Separator" ) ];
        //$WCAP_Menu[20]["sub"][] = [ "label" => esc_html_x( "Domain Search","menu","whcom" ), "page" => "#", "class" => "no_load" ];

        //-----------------billing----------------
        $WCAP_Menu[30] = [
            "label" => esc_html_x("Billing", "menu", "whcom"),
            "page" => "",
            "class" => "no_load",
            "show" => true,
        ];
        $WCAP_Menu[30]["sub"]['my_invoices'] = [
            "label" => esc_html_x("My Invoices", "menu", "whcom"),
            "page" => "my_invoices",
            "class" => "wcap_load_page",
            "show" => true,
        ];
        $WCAP_Menu[30]["sub"]['my_quotes'] = [
            "label" => esc_html_x("My Quotes", "menu", "whcom"),
            "page" => "my_quotes",
            "class" => "wcap_load_page",
            "show" => true,
        ];
        $WCAP_Menu[30]["sub"]['my_qoutes_separator'] = [
            "label" => "Separator",
            "show" => true,
        ];

        $WCAP_Menu[30]["sub"]['mass_pay'] = [
            "label" => esc_html_x("Mass Payment", "menu", "whcom"),
            "page" => "mass_pay",
            "class" => "wcap_load_page",
            "show" => true,
        ];
        $WCAP_Menu[30]["sub"]['credit_card'] = [
            "label" => esc_html_x("Manage Credit Card", "menu", "whcom"),
            "page" => "credit_card",
            "class" => "wcap_load_page",
            "show" => true,
        ];

        //----------------support-------------

        $WCAP_Menu[40] = [
            "label" => esc_html_x("Support", "menu", "whcom"),
            "page" => "#",
            "class" => "no_load",
            "icon" => "",
            "show" => true,
        ];
        $WCAP_Menu[40]["sub"]["tickets"] = [
            "label" => esc_html_x("Tickets", "menu", "whcom"),
            "page" => "tickets",
            "class" => "wcap_load_page",
            "icon" => "whcom_icon_arrows-cw",
            "show" => true,
        ];
        $WCAP_Menu[40]["sub"]['announcements'] = [
            "label" => esc_html_x("Announcements", "menu", "whcom"),
            "page" => "announcements",
            "class" => "wcap_load_page",
            "icon" => "whcom_icon_list",
            "show" => true,
        ];
        $WCAP_Menu[40]["sub"]['knowledgebase'] = [
            "label" => esc_html_x("Knowledgebase", "menu", "whcom"),
            "page" => "knowledgebase",
            "class" => "wcap_load_page",
            "icon" => "whcom_icon_info-circled",
            "show" => true,
        ];
        $WCAP_Menu[40]["sub"]['downloads'] = [
            "label" => esc_html_x("Downloads", "menu", "whcom"),
            "page" => "downloads",
            "class" => "wcap_load_page",
            "icon" => "whcom_icon_download",
            "show" => true,
        ];
        $WCAP_Menu[40]["sub"]['network_status'] = [
            "label" => esc_html_x("Network Status", "menu", "whcom"),
            "page" => "network_status",
            "class" => "wcap_load_page",
            "icon" => "whcom_icon_rocket-1",
            "show" => true,
        ];


        $WCAP_Menu[50] = [
            "label" => esc_html_x("Open Ticket", "menu", "whcom"),
            "page" => "submitticket",
            "class" => "wcap_load_page",
            "icon" => "whcom_icon_chat",
            "show" => true,
        ];

        $WCAP_Menu[60] = [
            "label" => esc_html_x("Affiliates", "menu", "whcom"),
            "page" => "affiliates",
            "class" => "wcap_load_page",
            "show" => true,
        ];

        $WCAP_Menu[70] = [
            "label" => esc_html_x("Hello", "menu", "whcom") . " " . $this->get_user_data("firstname"),
            "page" => "",
            "class" => "no_load",
            "show" => true,
        ];
        $WCAP_Menu[70]["sub"]['edit_account_details'] = [
            "label" => esc_html_x("Edit Account Details", "menu", "whcom"),
            "page" => "profile",
            "class" => "wcap_load_page",
            "show" => true,
        ];

        $WCAP_Menu[70]["sub"]['credit_card'] = [
            "label" => esc_html_x("Manage Credit Card", "menu", "whcom"),
            "page" => "credit_card",
            "class" => "wcap_load_page",
            "show" => true,
        ];
        $WCAP_Menu[70]["sub"]['contacts_subaccounts'] = [
            "label" => esc_html_x("Contacts/Sub-Accounts", "menu", "whcom"),
            "page" => "contacts",
            "class" => "wcap_load_page",
            "show" => true,
        ];
        $WCAP_Menu[70]["sub"]['change_password'] = [
            "label" => esc_html_x("Change Password", "menu", "whcom"),
            "page" => "change_password",
            "class" => "wcap_load_page",
            "show" => true,
        ];
        $WCAP_Menu[70]["sub"]['security_settings'] = [
            "label" => esc_html_x("Security Settings", "menu", "whcom"),
            "page" => "security_settings",
            "class" => "wcap_load_page",
            "show" => true,
        ];
        $WCAP_Menu[70]["sub"]['email_history'] = [
            "label" => esc_html_x("Email History", "menu", "whcom"),
            "page" => "email_history",
            "class" => "wcap_load_page",
            "show" => true,
        ];
        $WCAP_Menu[70]["sub"][] = [
            "label" => "Separator",
            "show" => true,
        ];


        $client_area_url = get_option("wcapfield_after_logout_redirect_url", '');

        $WCAP_Menu[70]["sub"]['logout'] = [
            "label" => esc_html_x("Logout", "menu", "whcom"),
            "href" => $client_area_url,
            //"id" => "whmcs_logout_btn",
            "page" => "process_logout",
            "class" => "whcom_client_logout",
            "show" => true,
        ];

        //$WCAP_Menu[80] = [ "label" => esc_html_x( "Cart","menu","whcom" ), "page" => "cart", "class" => "wcap_load_page", ];
        if ($this->is_developer_machine()) {
            $WCAP_Menu[100] = [
                "label" => esc_html_x("A", "menu", "whcom"),
                "page" => "a",
                "class" => "wcap_load_page",
                "show" => true,
            ];
        }

        $all_config = whcom_process_helper(["action" => "configurations"])['data'];

        $AffiliateEnabled = $all_config["AffiliateEnabled"];
        $EnableMassPay = $all_config["EnableMassPay"];
        $SupportModule = $all_config["SupportModule"];

        $WCAP_Menu[60]['show'] = ($AffiliateEnabled != "on") ? false : true;
        $WCAP_Menu[30]["sub"]['mass_pay']['show'] = ($EnableMassPay <> "on") ? false : true;
        $WCAP_Menu[30]["sub"]['credit_card'] ['show'] = (CC_SAVEABLE == false) ? false : true;
        $WCAP_Menu[70]["sub"]['credit_card'] ['show'] = (CC_SAVEABLE == false) ? false : true;

        return $WCAP_Menu;
    }


    //Open menu
    public function get_front_menu_array()
    {
        /* 0 - home
		 * 10 - store
		 * 20 - Announcements
		 * 30 - Knowledgebase
		 * 40 - Contact us
		 * 50 - Account
		 * * Login
		 * * register
		 * * forget password
		 */


        $wcop_active = wcap_is_wcop_active();
        $lang = whcom_get_current_language();
        $field = get_option("configure_product" . $lang);

        if ($wcop_active) {
            $class = "";
            $services_data = "";
            $services_url = $field . "?order_type=order_product";
        } else {
            $class = "wcap_load_page";
            $services_data = "order_new_service";
            $services_url = "";
        }

        $WCAP_Menu[0] = [
            "label" => esc_html_x("Home", "menu", "whcom"),
            "page" => "dashboard",
            "class" => "wcap_load_page",
            "show" => true,
        ];

        $wcop_active = wcap_is_wcop_active();
        if ($wcop_active) {
            $class = "";
            $field = 'configure_product' . whcom_get_current_language();
            $base_url = esc_attr(get_option($field, ''));

            $services_data = "";
            $services_url = $base_url . "?order_type=order_product";

            $domains_register_data = "";
            $domains_register_url = $base_url . "?order_type=order_domain";

            $domains_transfer_data = "";
            $domains_transfer_url = $base_url . "?order_type=order_domain&domain=transfer";

        } else {
            $class = "wcap_load_page";

            $services_data = "order_new_service";
            $services_url = "";

            /*            "page" => "order_process",
                        "href"  => "a=add&domain=register"*/
            $domains_register_data = "order_process";
            $domains_register_url = "a=add&domain=register";

            /*            "page" => "order_process",
                        "href"  => "a=add&domain=transfer"*/

            $domains_transfer_data = "order_process";
            $domains_transfer_url = "a=add&domain=transfer";
        }
        $WCAP_Menu[10] = [
            "label" => esc_html_x("Store", "menu", "whcom"),
            "page" => $services_data,
            "class" => $class,
            "href" => $services_url,
            "show" => true,
        ];
        /*        $WCAP_Menu[10]["sub"][] = [
					"label" => esc_html_x( "My Services","menu", "whcom" ),
					"page"  => "services",
					"class" => "wcap_load_page",
				];*/

        $WCAP_Menu[20] = [
            "label" => esc_html_x("Announcements", "menu", "whcom"),
            "page" => "announcements",
            "class" => "wcap_load_page",
            "show" => true,
        ];
        $WCAP_Menu[30] = [
            "label" => esc_html_x("Knowledgebase", "menu", "whcom"),
            "page" => "knowledgebase",
            "class" => "wcap_load_page",
            "show" => true,
        ];
        $WCAP_Menu[40] = [
            "label" => esc_html_x("Network Status", "menu", "whcom"),
            "page" => "network_status",
            "class" => "wcap_load_page",
            "show" => true,
        ];


        $WCAP_Menu[50] = [
            "label" => esc_html_x("Contact Us", "menu", "whcom"),
            "page" => "contact",
            "class" => "wcap_load_page",
            "show" => true,
        ];

        $WCAP_Menu[60] = [
            "label" => esc_html_x("Affiliates", "menu", "whcom"),
            "page" => "affiliates",
            "class" => "wcap_load_page",
            "show" => true,
        ];


        $WCAP_Menu[70] = [
            "label" => esc_html_x("Account", "menu", "whcom"),
            "page" => "",
            "class" => "no_load",
            "show" => true,
        ];
        $WCAP_Menu[70]["sub"]['login'] = [
            "label" => esc_html_x("Login", "menu", "whcom"),
            "page" => "login",
            "class" => "wcap_load_page",
            "show" => true,
        ];
        $WCAP_Menu[70]["sub"]['create_client_account'] = [
            "label" => esc_html_x("Register", "menu", "whcom"),
            "page" => "create_client_account",
            "class" => "wcap_load_page",
            "show" => true,
        ];
        $WCAP_Menu[70]["sub"]['password_reset'] = [
            "label" => esc_html_x("Forgot Password?", "menu", "whcom"),
            "page" => "password_reset",
            "class" => "wcap_load_page",
            "show" => true,
        ];

        //$WCAP_Menu[80] = [ "label" => esc_html_x( "Cart" ,"menu","whcom" ), "page" => "cart", "class" => "wcap_load_page", ];
        if ($this->is_developer_machine()) {
            $WCAP_Menu[100] = [
                "label" => esc_html_x("A", "menu", "whcom"),
                "page" => "a",
                "class" => "wcap_load_page",
            ];
        }

        $all_config = whcom_get_whmcs_setting();
        $AffiliateEnabled = $all_config["AffiliateEnabled"];
        $SupportModule = $all_config["SupportModule"];

        $WCAP_Menu[60]['show'] = ($AffiliateEnabled != "on") ? false : true;


        return $WCAP_Menu;
    }

    function use_my_scripts()
    {
        wp_register_script('wcap_dataTables', '//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js', 'jquery', false, true);
        //wp_register_script('wcap_dataTablesResponsive', '//cdn.datatables.net/responsive/1.0.4/js/dataTables.responsive.js', 'jquery', false, true);
        wp_register_script('wcap_dataTablesResponsive', $this->URL . '/assets/js/dataTables.responsive.js', 'jquery', false, true);
        wp_register_script('wcap_circleiful', $this->URL . '/assets/js/circles/jquery.circliful.min.js', 'jquery', false, true);
        wp_register_script('whcom_tablesaw', $this->URL . '/assets/js/tablesaw/tablesaw.jquery.js', 'jquery', false, true);
        wp_register_script('whcom_tablesaw_init', $this->URL . '/assets/js/tablesaw/tablesaw-init.js', 'jquery', false, true);
        wp_register_script('wcap_fancybox', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.6/js/jquery.fancybox.min.js', 'jquery', false, true);
        //wp_register_script( 'wcap_summernote', 'https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.6/summernote.min.js', 'jquery', false, true );
        wp_register_script('wcap_validation', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js', 'jquery', false, true);
        wp_register_script('wcap_validation_additional', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js', 'wcap_validation', false, true);

        wp_register_script('wcap_file_upload', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js', 'jquery', false, true);

        $hash = md5_file($this->Path . "/assets/js/scripts.js");
        wp_register_script('wcap_scripts', $this->URL . '/assets/js/scripts.js', [
            'jquery',
            'whcom_scripts',
        ], $hash, true);
        wp_register_script('wcap_md_edit', $this->URL . '/assets/js/simplemde.js', ['jquery']);

        wp_enqueue_script("jquery-ui");
        wp_enqueue_script("wcap_md_edit");
        wp_enqueue_script('wcap_dataTables');
        wp_enqueue_script('wcap_dataTablesResponsive');
        wp_enqueue_script('wcap_circleiful');
        wp_enqueue_script('whcom_tablesaw');
        wp_enqueue_script('whcom_tablesaw_init');
        //wp_enqueue_script( 'wcap_summernote' );
        wp_enqueue_script('wcap_fancybox');
        wp_enqueue_script('wcap_validation');
        wp_enqueue_script('wcap_validation_additional');

        wp_enqueue_script('wcap_scripts');
        wp_enqueue_script('wcap_file_upload');

        //wp_enqueue_media();

        //wp_localize_script( 'wcap-ajax-script', 'wcap_ajax', [ 'ajax_url' => admin_url( 'admin-ajax.php' ) ] );
    }

    function use_my_styles()
    {
        echo PHP_EOL . '<script type="text/javascript">
			/* <![CDATA[ */
            var wcap_ajaxurl = "' . admin_url('admin-ajax.php') . '";
            /* ]]> */
         </script>' . PHP_EOL;

        echo '<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">' . PHP_EOL;
        echo '<link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">' . PHP_EOL;
        echo '<link rel="stylesheet" href="//cdn.datatables.net/responsive/1.0.4/css/dataTables.responsive.css">' . PHP_EOL;
        echo '<link rel="stylesheet" href="' . $this->URL . '/assets/js/tablesaw/tablesaw.css">' . PHP_EOL;
        echo '<link rel="stylesheet" href="' . $this->URL . '/assets/js/simplemde.css">' . PHP_EOL;
        echo '<link rel="stylesheet" href="' . $this->URL . '/assets/css/jquery.circliful.css">' . PHP_EOL;
        echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.6/css/jquery.fancybox.min.css">' . PHP_EOL;
        //echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.6/summernote.css">' . PHP_EOL;

        $hash = md5_file($this->Path . "/assets/css/styles.css");
        echo "<link rel='stylesheet' href='" . $this->URL . "/assets/css/styles.css?{$hash}'>" . PHP_EOL;
        //$redirect = empty(get_option("wcapfield_after_login_redirect_url")) ? 0 : get_option("wcapfield_after_login_redirect_url");
        $redirect = wcap_get_login_redirect_url();
        $logout_redirect = empty(get_option("wcapfield_after_logout_redirect_url")) ? 0 : get_option("wcapfield_after_logout_redirect_url");
        global $post;
        $page_url = (is_object($post)) ? urlencode(get_permalink($post->ID)) : esc_url(home_url('/'));
        //== client area URL for wcap login form redirection
        $client_area_url = get_option("wcapfield_client_area_url" . whcom_get_current_language());

        ob_start(); ?>

        <script>
            var Currencies = "<?php echo json_encode($this->Currencies); ?>";
            var WCAP_Loading_text = "<?php esc_html_e("Loading...", "whcom") ?>";
            var WCAP_Working_text = "<?php esc_html_e("Working...", "whcom") ?>";
            //		    var BillingCycles = "<?php echo json_encode($this->BillingCycleStrings); ?>";
            var dataTablesConfig = {
                "destroy": "true",
                "dom": '<"whcom_table_header"if <"whcom_clearfix">><"whcom_table_content"t><"whcom_table_footer"lp <"whcom_clearfix">><"whcom_clearfix">',
                "oLanguage": {
                    "sEmptyTable": "<?php esc_html_e("No Records Found", "whcom") ?>",
                    "sInfo": "<?php esc_html_e("Showing _START_ to _END_ of _TOTAL_ entries", "whcom") ?>",
                    "sInfoEmpty": "<?php esc_html_e("Showing 0 to 0 of 0 entries", "whcom") ?>",
                    "sInfoFiltered": "<?php esc_html_e("(filtered from _MAX_ total entries)", "whcom") ?>",
                    "sInfoPostFix": "<?php esc_html_e("", "whcom") ?>",
                    "sInfoThousands": "<?php esc_html_e(",", "whcom") ?>",
                    "sLengthMenu": "<?php esc_html_e("Show _MENU_ entries", "whcom") ?>",
                    "sLoadingRecords": "<?php esc_html_e("Loading...", "whcom") ?>",
                    "sProcessing": "<?php esc_html_e("Processing...", "whcom") ?>",
                    "sSearch": "<?php esc_html_e("", "whcom") ?>",
                    "sZeroRecords": "<?php esc_html_e("No Records Found", "whcom") ?>",
                    "oPaginate": {
                        "sFirst": "<?php esc_html_e("..", "whcom") ?>",
                        "sLast": "<?php esc_html_e("Last", "whcom") ?>",
                        "sNext": "<?php esc_html_e("Next", "whcom") ?>",
                        "sPrevious": "<?php esc_html_e("Previous", "whcom") ?>",
                    }
                }
            };
            var redirect_login = '<?php echo $redirect;?>';
            var redirect_logout = '<?php echo $logout_redirect;?>';
            var page_url = '<?php echo $page_url; ?>';
            //== pass client area URL to validation form JS
            var client_area_url = '<?php echo $client_area_url ?>'
        </script>
        <?php echo ob_get_clean();
    }

    function shortcode($atts, $content = null, $shortCode)
    {
        $path = $this->Path . "/library/shortcodes/{$shortCode}.php";
        if (is_file($path)) {
            ob_start();
            include($path);
            $content = ob_get_clean();

            return $content;
        } else {
            return "ShortCode file missing.";
        }
    }

    function admin_ajax()
    {
        include($this->Path . "/admin/ajax.php");
        wp_die();
    }

    function ajax()
    {
        include($this->Path . "/library/ajax.php");
        wp_die();
    }

    function order_process_ajax()
    {
        include($this->Path . "/library/order_process_ajax.php");
        wp_die();
    }

    function init()
    {

    }

    function wcap_enqueue_admin_styles_scripts()
    {
        wp_register_style('wcap_admin_styles', $this->URL . '/admin/assets/css/wca_api_admin_styles.css', false, WCAP_VERSION);
        wp_register_script('wcap_admin_scripts', $this->URL . '/admin/assets/js/wca_api_admin_scripts.js', 'jquery', WCAP_VERSION);

        // Linear Icons
        wp_register_style('custom_wp_admin_icons', '//cdn.linearicons.com/free/1.0.0/icon-font.min.css', false, '1.0.0');
        wp_enqueue_style('custom_wp_admin_icons');

        wp_enqueue_style('wcap_admin_styles');
        wp_enqueue_script('wcap_admin_scripts');
    }

    function wcap_add_pages()
    {
        add_menu_page(esc_html__('WCAP - WHMCS Client Area', "whcom"), esc_html__('WCAP ', "whcom"), 'manage_options', 'wcap', [
            $this,
            'wcap_load_plugin_dashboard',
        ], $this->URL . "/admin/assets/images/logo-16.png", '82.99850');

        add_submenu_page('wcap', esc_html__('WCAP Dashboard', "whcom"), esc_html__('WCAP Dashboard', "whcom"), 'manage_options', 'wcap', [
            $this,
            'wcap_load_plugin_dashboard',
        ]);
        add_submenu_page('wcap', esc_html__('WHMCS Config', "whcom"), esc_html__('WHMCS Config', "whcom"), 'manage_options', 'whcom-settings', [
            $this,
            'wcap_load_config_page',
        ]);
        add_submenu_page('wcap', esc_html__('Settings', "whcom"), esc_html__('Settings', "whcom"), 'manage_options', 'wcap-settings', [
            $this,
            'wcap_load_settings_page',
        ]);
        add_submenu_page('wcap', esc_html__('Styles', "whcom"), esc_html__('Styles', "whcom"), 'manage_options', 'whcom-styles', [
            $this,
            'wcap_load_dummy_admin_page',
        ]);
        add_submenu_page('wcap', esc_html_x('Advanced Settings', "whcom"), esc_html__('Advanced Settings', "whcom"), 'manage_options', 'wcap-advanced-settings', [
            $this,
            'wcap_load_advanced_settings_page',
        ]);


        add_submenu_page('wcap', esc_html__('Debug Info', "whcom"), esc_html__('Debug Info', "whcom"), 'manage_options', 'whcom-debug', [
            $this,
            'wcap_load_dummy_admin_page',
        ]);

        //		add_submenu_page( 'wcap', esc_html__( 'WCAP Help', "whcom" ), esc_html__( 'WCAP Help', "whcom" ), 'manage_options', 'wcap-help', [
        //			$this,
        //			'wcap_load_help_page',
        //		] );
    }

    function wcap_load_plugin_dashboard()
    {
        require_once($this->Path . "/admin/pages/dashboard.php");
    }

    function wcap_load_settings_page()
    {
        require_once($this->Path . "/admin/pages/settings.php");
    }

    function wcap_load_advanced_settings_page()
    {
        require_once($this->Path . "/admin/pages/advanced.php");
    }

    function wcap_load_dummy_admin_page()
    {
    }

    /**
     * @return string
     *
     * Get version of this plugin.
     */

    public function get_version()
    {
        return get_plugin_data(WCAP_FILE)['Version'];
    }

    /**
     * @param string $args
     *
     * @return string
     *
     * This method will authenticate WHMCS username and password.
     */
    function whmcs_autenticated($args = "")
    {
        $default = [
            "username" => "",
            "password" => "",
            "url" => "",
        ];

        $args = wp_parse_args($args, $default);
        extract($args);

        if (empty($url)) {
            return esc_html__("Invalid WHMCS URL", "whcom");
        }
        if (empty($username) || empty($password)) {
            return esc_html__("Username/Password is missing.");
        }

        $url = rtrim($url, "/") . "/";

        $postfields['username'] = $username;
        $postfields['password'] = md5($password);
        $postfields['action'] = 'getadmindetails';
        $postfields['responsetype'] = 'json';

        if ($this->is_developer_machine()) {
            $postfields['accesskey'] = 'Farash..88';
        } else {
            $postfields['accesskey'] = $this->AutoAuthKey;
            //get_option( "whcom_whmcs_admin_api_key" );
        }

        // Call the API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . 'includes/api.php');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
        $response = curl_exec($ch);

        if (curl_error($ch)) {
            return (esc_html__('Unable to connect: ', "whcom") . curl_errno($ch) . ' - ' . curl_error($ch));
        }
        curl_close($ch);
        $jsonData = json_decode($response, true);

        if (isset($jsonData['result']) && $jsonData['result'] == 'error') {
            return $jsonData['message'];
        } else {
            return "OK";
        }
    }

    /**
     * @return bool
     */
    function is_client_whmcs_validated()
    {
        return whcom_is_client_logged_in();
        //		return isset( $_SESSION["whmcs_user"] );
    }

    /**
     * @author Shakeel Ahmed Siddiqi <shakeel@shakeel.pk>
     *
     * @param string $args
     *
     * @return mixed|string
     *
     * This method is used to logging in WHMCS.
     */


    function validate_whmcs_user($args = "")
    {
        $default = [
            "action" => "",
            "hash" => md5($this->AutoAuthKey . "creativeON"),
            "email" => "",
            "password" => "",
        ];

        $args = wp_parse_args($args, $default);
        $args["action"] = "validate_login";
        extract($args);

        ## If direction is WHMCS to WordPress
        /*$response = whcom_process_api( [
            "action"    => "ValidateLogin",
            "email"     => $email,
            "password2" => $password2,
        ] );*/

        $postdata["email"] = $args["email"];
        $postdata["pass"] = $args["password"];
        //$postdata['action']="validate_login";
        unset($args["email"], $args["password"]);

        $response = whcom_validate_client($postdata);
        if ($response['status'] == "OK") {
            //$response = substr($response, 2);
            ## If SSO is enabled.
            if ($this->is_sso_on()) {
                ## Getting WP_User object
                $wp_user = get_user_by("email", $email);

                ## If WP user is not restricted for Sync.
                if (!$this->is_wp_user_restricted($wp_user)) {
                    if (!$this->is_wp_user($email)) {
                        ## If WordPress user doesn't exists, then create it.
                        $this->create_wp_user_from_whmcs($email, $password);
                    } else if (!$this->is_wp_user_valid($email, $password)) {
                        ## If password doesn't match with wordpress then set WordPress password.
                        $this->wp_update_password($email, $password);
                    }
                    $this->update_wp_user_from_whmcs($email);
                    ## Setting session data for WP user.
                    wp_set_auth_cookie($wp_user->ID);

                }
            }
        }

        return $response;

        /*	## If sync is not enabled.
            $response = $this->run_whmcs_api( [
                "action"    => "ValidateLogin",
                "email"     => $email,
                "password2" => $password2,
            ] );*/

    }

    /**
     * @author Shakeel Ahmed <shakeel@shakeel.pk>
     *
     * @param $wp_user
     *
     * @return bool
     *
     * Check if WP user is checked for skip (exclude check) for sync or not.
     * WP_User Object is required for parameter.
     */
    public function is_wp_user_restricted($wp_user)
    {
        $skip_roles = get_option("wcapfield_exclude_sync_roles");
        if (!is_array($skip_roles)) {
            $skip_roles = [];
        }

        if (!isset($wp_user->roles)) {
            return false;
        }

        foreach ($wp_user->roles as $role) {
            if (in_array($role, $skip_roles)) {
                return true;
            }
        }

        return false;
    }

    public function get_announcements($args = "")
    {
        $default = [
            "limitstart" => "0",
            "limitnum" => "25",
        ];

        $args = wp_parse_args($args, $default);
        $args["action"] = "GetAnnouncements";

        $response = $this->run_whmcs_api($args);

        return $response;
    }

    function curl_get_file_contents($URL, $postdata = [])
    {
        $url = trim($this->AdminURL);

        if (!isset($URL["wcap_db_request"])) {
            $URL["wcap_db_request"] = "";
        }
        $url .= "/index.php?" . http_build_query($URL);

        if (empty($postdata)) {
            $c = curl_init();
            curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($c, CURLOPT_URL, $url);

            /*if ( ! empty( $postdata ) ) {
				curl_setopt( $c, CURLOPT_POST, true );
				curl_setopt( $c, CURLOPT_POSTFIELDS, http_build_query( $postdata ) );
			}*/

            $contents = curl_exec($c);
            curl_close($c);

            if ($contents) {
                return $contents;
            } else {
                return false;
            }
        } else {

            $response = wp_remote_post($url, [
                'method' => 'POST',
                'body' => ["data" => base64_encode(json_encode($postdata))],
                'cookies' => [],
            ]);
            if (is_wp_error($response)) {
                return $response->get_error_message();
            } else {
                return $response["body"];
            }
        }
    }

    function is_json($string)
    {
        if (is_numeric($string)) {
            return false;
        }
        if (is_bool($string)) {
            return false;
        }
        if (is_null($string)) {
            return false;
        }
        if (!is_string($string)) {
            return false;
        }
        if ($string == "" || $string == " ") {
            return false;
        }
        @json_decode($string);

        return (json_last_error() == JSON_ERROR_NONE);
    }


    /**
     * @param string $args
     *
     * @return mixed|string
     *
     * GetClientServices.. This will return client's services.
     */
    function get_client_products($args = "")
    {
        ## Get services
        $default = [
            /*            "limitstart" => "0",
                        "limitnum" => "100",*/
            "clientid" => "0",
            "serviceid" => "0",
            "pid" => "0",
            "domain" => "",
            "username2" => "",
            "status" => "",
        ];

        $args = wp_parse_args($args, $default);
        $args["action"] = "GetClientsProducts";
        extract($args);

        /*if (!whcom_is_client_logged_in()) {
			return "You'r not logged in";
		}*/

        /*if (whcom_is_client_logged_in()) {
			$args["username2"] = $_SESSION["whmcs_user"]["username"];
		}*/
        if (empty($args["clientid"])) {
            unset($args["clientid"]);
        }
        if (empty($args["serviceid"])) {
            unset($args["serviceid"]);
        }
        if (empty($args["pid"])) {
            unset($args["pid"]);
        }
        if (empty($args["domain"])) {
            unset($args["domain"]);
        }
        if (empty($args["username2"])) {
            unset($args["username2"]);
        }

        $response = $this->run_whmcs_api($args);

        if (!isset($response["result"])) {
            return print_r($response, true);
        } else if ($response["result"] == "success") {
            $response["active_services"] = 0;

            if (isset($response["products"]["product"]) && is_array($response["products"]["product"])) {
                foreach ($response["products"]["product"] as $key => &$product) {
                    if ($product["status"] == "Active") {
                        $response["active_services"]++;
                    }

                    if (!empty($status) && $product["status"] <> $status) {
                        unset($response["products"]["product"][$key]);
                        $response["totalresults"]--;
                    }
                }
            }

            return $response;
        } else {
            return $response["message"];
        }
    }


    function get_all_products_x()
    {
        $response = whcom_process_helper(['action' => 'whcom_get_all_products']);

        return $response;
    }


    /**
     * @param string $args
     *
     * @return mixed|string
     *
     * Get client's domains.
     */
    function get_client_domains($args = "")
    {
        $default = [
            "limitstart" => "0",
            "limitnum" => "25",
            "clientid" => "",
            "domainid" => "",
            "domain" => "",
        ];

        $args = wp_parse_args($args, $default);
        $args["action"] = "GetClientsDomains";
        extract($args);

        if (empty($args["clientid"])) {
            unset($args["clientid"]);
        }
        if (empty($args["domainid"])) {
            unset($args["domainid"]);
        }
        if (empty($args["domain"])) {
            unset($args["domain"]);
        }

        $response = $this->run_whmcs_api($args);

        if (!isset($response["result"])) {
            return print_r($response, true);
        } else if ($response["result"] == "success") {
            return $response;

            return $response;
        } else {
            return $response["message"];
        }
    }

    /**
     * @author Shakeel Ahmed Siddiqi <shakeel@shakeel.pk>
     * @return bool
     *
     * Logout on WHMCS.
     */
    function whmcs_logout()
    {
        $email = whcom_get_current_client()["email"];
        $wp_user = get_user_by("email", $email);

        whcom_client_log_out();

        if ($this->is_sso_on() && !$this->is_wp_user_restricted($wp_user)) {
            wp_destroy_current_session();
            wp_clear_auth_cookie();
        }

        return true;
    }

    function my_date($date, $format = "")
    {
        if (empty($format)) {
            $format = get_option("date_format");
        }

        return date($format, strtotime($date));
    }

    function my_datetime($date, $format = "")
    {
        if (empty($format)) {
            $format = get_option("date_format") . " " . get_option("time_format");
        }

        return date($format, strtotime($date));
    }

    public function reply_ticket($args = "")
    {
        $default = [
            "ticketid" => "",
            "message" => "",
            "useMarkdown" => "",
            "userid" => "",
            "contactid" => "",
            "name" => "",
            "email" => "",
            "status" => "",
            "noemail" => false,
            "markdown" => true,
        ];

        $args = wp_parse_args($args, $default);

        $args["action"] = "AddTicketReply";

        $response = [
            "status" => "ERROR",
            "message" => "Nothing done yet!"
        ];
        foreach ($args as $k => $v) {
            if ($v == "") {
                unset($args[$k]);
            }
        }

        $response = $this->run_whmcs_api($args);

        if (isset($response["result"]) && $response["result"] == "success") {
            $response["status"] = "OK";
        }
        if ($this->is_json($response)) {
            return $response;
        }

        return json_encode($response);
    }

    public function get_ticket($args = "")
    {
        $default = [
            "ticketnum" => "",
            "ticketid" => "",
            "repliessort" => "DESC",
        ];

        $args = wp_parse_args($args, $default);

        $args["action"] = "GetTicket";

        $response = $this->run_whmcs_api($args);

        if (isset($response["result"]) && $response["result"] == "error") {
            return @$response["message"];
        } else {
            return $response;
        }
    }

    function get_tickets($args = "")
    {

        $default = [
            /*            "limitstart" => "0",
                        "limitnum" => "25",*/
            "deptid" => "",
            "clientid" => whcom_get_current_client_id(),
            "email" => "",
            "status" => "",
            "subject" => "",
            //"ignore_dept_assignments" => true,
        ];


        $args = wp_parse_args($args, $default);
        $args["action"] = "GetTickets";

        extract($args);

        if ($args["deptid"] == "") {
            unset($args["deptid"]);
        }
        if ($args["clientid"] == "") {
            unset($args["clientid"]);
        }
        if ($args["email"] == "") {
            unset($args["email"]);
        }
        if ($args["status"] == "") {
            unset($args["status"]);
        }
        if ($args["subject"] == "") {
            unset($args["subject"]);
        }
        if ($args["ignore_dept_assignments"] == "") {
            unset($args["ignore_dept_assignments"]);
        }

        $response = $this->run_whmcs_api($args);

        if (!isset($response["result"])) {
            return print_r($response, true);
        } else if ($response["result"] == "success") {
            if (!isset($response["tickets"]["ticket"])) {
                $response["tickets"]["ticket"] = [];
            }

            return $response;
        } else {
            return $response["message"];
        }
    }

    function get_invoices($args = "")
    {
        $default = [
            "userid" => "",
            "status" => "",
        ];

        $args = wp_parse_args($args, $default);
        $args["action"] = "GetInvoices";
        extract($args);

        if ($args["userid"] == "") {
            unset($args["userid"]);
        }
        if ($args["status"] == "") {
            unset($args["status"]);
        }

        $response = $this->run_whmcs_api($args);

        if (!isset($response["result"])) {
            return print_r($response, true);
        } else if ($response["result"] == "success") {
            if (!isset($response["invoices"]["invoice"])) {
                $response["invoices"]["invoice"] = [];
            }

            return $response;
        } else {
            return $response["message"];
        }
    }


    function get_invoice($invoice_id)
    {
        $args = [
            "invoiceid" => $invoice_id,
            "action" => "GetInvoice",
        ];

        $response = $this->run_whmcs_api($args);

        if (!isset($response["result"])) {
            return $response;
        } else {
            return $response;
        }
    }


    function get_affiliate($affiliate_id)
    {
        $args = [
            "userid" => $affiliate_id,
            "action" => "GetAffiliates",
        ];

        $response = $this->run_whmcs_api($args);

        if (!isset($response["result"])) {
            return $response;
        } else {
            return $response;
        }
    }


    function yesno($var)
    {
        if ($var) {
            return "Yes";
        } else {
            return "No";
        }
    }

    /**
     * @param string $args
     *
     * This method is used when customer resets password.
     */
    function reset_client_password($args = "")
    {
        $default = [
            "password1" => "",
            "password2" => "",
            "token" => "",
            "email" => "",
        ];
        $args = wp_parse_args($args, $default);
        extract($args);

        if (!$this->validate_reset_password_url($args)) {
            return __("Invalid token validation", "whcom");
        }

        if ($password1 <> $password2) {
            return __("Invalid password confirmation", "whcom");
        }

        if (strlen($password1) < 8) {
            return __("Password length 8 characters required.");
        }

        $args["action"] = "UpdateClient";
        $args["clientemail"] = $args["email"];
        unset($args["token"], $args["password1"], $args["what"], $args["email"]);

        $response = $this->run_whmcs_api($args);

        if (@$response["result"] == "error" && isset($response["message"])) {
            return $response["message"];
        }

        return "OK";
    }

    /**
     * @author Shakeel Ahmed <shakeel@shakeel.pk>
     *
     * @param string $args
     *
     * @return string
     *
     * This function reset security answers.
     */
    public function update_security_questions($args = "")
    {
        $default = [
            "clientid" => "",
            "securityqid" => "",
            "securityqans" => "",
            "securityqans2" => "",
        ];
        $args = wp_parse_args($args, $default);

        if (empty($args["clientid"])) {
            $args["clientid"] = whcom_get_current_client_id();
        }

        if ($args["securityqans"] <> $args["securityqans2"]) {
            return "Security answers not matched.";
        }
        if (trim($args["securityqans"]) == "") {
            return "Security answers missing.";
        }

        $args["action"] = "UpdateClient";

        unset($args["securityqans2"]);
        unset($args["what"]);

        $response = $this->run_whmcs_api($args);

        if (isset($response["result"]) && $response["result"] == "success") {
            return "OK";
        }

        if (isset($response["result"]) && isset($response["message"]) && $response["result"] == "error") {
            return $response["message"];
        }

        return "Unknown error";
    }

    public function update_credit_card($args = "")
    {
        if (empty($args["clientid"])) {
            $args["clientid"] = whcom_get_current_client_id();
        }
        $args["action"] = "UpdateClient";
        $args["expdate"] = $args["exp_month"] . $args["exp_year"];

        $fields = [
            'clientid' => esc_html__('Client ID'),
            'cardtype' => esc_html__('Card Type'),
            'cardnum' => esc_html__('Card Number'),
            'exp_month' => esc_html__('Card Expiry Month'),
            'exp_year' => esc_html__('Card Expiry Year'),
            'cvv' => esc_html__('Card CVV'),
        ];


        $response = [
            'status' => 'ERROR',
            'errors' => [],
            'message' => esc_html__("Something went wrong", "whcom"),
        ];

        //check if all fields are filled
        $info_filled = true;
        $errors = "";
        foreach ($fields as $field => $title) {
            if (empty($args[$field])) {
                $errors = "<li>" . $title . ' ' . esc_html__('is required') . "</li>";
                $info_filled = false;
            }
        }
        $response['response'] = $errors;
        $errors = ($errors <> "") ? "<ul>" . $errors . "</ul>" : "";

        $response['api_response'] = $args;
        $response['message'] = $errors;
        $response['message'] = wcap_render_message(
            esc_html__("The following errors occurred:", "whcom"),
            $response['message'],
            "danger");

        // process api
        if ($info_filled) {
            $res = whcom_process_api($args);
            $response["api_response"] = $res;

            if (isset($res["result"]) && $res["result"] == "error") {
                $title = esc_html__("Error", "whcom");
                $response["message"] = wcap_render_message(
                    $title,
                    wcap_translate_api_respone($res["message"]),
                    "danger");

            } else if (isset($res["result"]) && $res["result"] == "success") {
                $response["status"] = "OK";
                $message = esc_html__("Changes Saved Successfully!", "whcom");
                $response["message"] = wcap_render_message("", $message, "success");

            } else {
                $response["errors"] = $response;
            }

        }

        return json_encode($response);
    }


    public
    function update_client_password(
        $args = ""
    )
    {
        $response = [
            'status' => 'ERROR',
            'message' => 'Nothing done yet!',
            'data' => []
        ];
        $default = [
            "clientid" => "",
            "password1" => "",
            "password2" => "",
            "old_password" => "",
        ];
        $args = wp_parse_args($args, $default);

        if (empty($args["clientid"])) {
            $args["clientid"] = whcom_get_current_client_id();
        }

        $client_row = whcom_get_client(whcom_get_current_client_id())['email'];

        $verify = whcom_validate_client([
            "email" => $client_row,
            "pass" => $args['old_password']
        ]);


        if ($verify['status'] != 'OK') {
            $wrong_password = "<strong>" . esc_html__("The following errors occurred:", "whcom") . "</strong><br>";
            $wrong_password .= esc_html__("Your existing password was not correct", "whcom");
            $response['message'] = $wrong_password;

        } else if ($args["password1"] <> $args["password2"]) {
            $message = esc_html__("The passwords entered do not match", "whcom");
            $response['message'] = $message;
        } else if (empty($args["password1"])) {
            $message = esc_html__("Please provide new password.", "whcom");
            $response['message'] = $message;
        } else {
            $data = [
                "password2" => $args["password1"],
                "clientid" => $args["clientid"],
                "remove_blank" => "1",
            ];
            $response = $this->update_client($data);
            if ($response['result'] == "success") {
                $_SESSION['whmcs_user']['password'] = $args["password1"];
            }
        }
        if (!$this->is_json($response)) {
            $response = json_encode($response, JSON_FORCE_OBJECT);
        }

        return $response;
    }

    public
    function get_countries()
    {
        $countries = [
            'AF' => 'Afghanistan',
            'AX' => 'Aland Islands',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua And Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia And Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory',
            'BN' => 'Brunei Darussalam',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos (Keeling) Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros',
            'CG' => 'Congo',
            'CD' => 'Congo, Democratic Republic',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'CI' => 'Cote D\'Ivoire',
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FK' => 'Falkland Islands (Malvinas)',
            'FO' => 'Faroe Islands',
            'FJ' => 'Fiji',
            'FI' => 'Finland',
            'FR' => 'France',
            'GF' => 'French Guiana',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'GA' => 'Gabon',
            'GM' => 'Gambia',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HM' => 'Heard Island & Mcdonald Islands',
            'VA' => 'Holy See (Vatican City State)',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran, Islamic Republic Of',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IM' => 'Isle Of Man',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JE' => 'Jersey',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'KR' => 'Korea',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyzstan',
            'LA' => 'Lao People\'s Democratic Republic',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libyan Arab Jamahiriya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macao',
            'MK' => 'Macedonia',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia, Federated States Of',
            'MD' => 'Moldova',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'NL' => 'Netherlands',
            'AN' => 'Netherlands Antilles',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestinian Territory, Occupied',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RE' => 'Reunion',
            'RO' => 'Romania',
            'RU' => 'Russian Federation',
            'RW' => 'Rwanda',
            'BL' => 'Saint Barthelemy',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts And Nevis',
            'LC' => 'Saint Lucia',
            'MF' => 'Saint Martin',
            'PM' => 'Saint Pierre And Miquelon',
            'VC' => 'Saint Vincent And Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome And Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia And Sandwich Isl.',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard And Jan Mayen',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'SY' => 'Syrian Arab Republic',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad And Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks And Caicos Islands',
            'TV' => 'Tuvalu',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States',
            'UM' => 'United States Outlying Islands',
            'UY' => 'Uruguay',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VE' => 'Venezuela',
            'VN' => 'Viet Nam',
            'VG' => 'Virgin Islands, British',
            'VI' => 'Virgin Islands, U.S.',
            'WF' => 'Wallis And Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe',
        ];

        return $countries;
    }

    function get_support_depts()
    {
        $args["action"] = "GetSupportDepartments";
        $args["ignore_dept_assignments"] = false;

        $response = $this->run_whmcs_api($args);

        if (isset($response["result"]) && $response["result"] == "success") {
            if (isset($response["departments"]["department"]) && is_array($response["departments"]["department"])) {
                return $response["departments"]["department"];
            } else {
                return [];
            }
        }

        if (isset($response["result"]) && isset($response["message"]) && $response["result"] == "error") {
            return $response["message"];
        }

        return "Unknown error";
    }

    public
    function open_ticket(
        $args = ""
    )
    {

        if (isset($_FILES['upload'])) {
            if ($_FILES['upload']['error'] > 0) {
                $file_error = '<br />Error: ' . $_FILES['upload']['error'] . '<br />';
            } else {
                $filename = $_FILES['upload']['name'];
                $filecontent = file_get_contents($_FILES['upload']['tmp_name']);
            }

        }

        $default = [
            "deptid" => "",
            "subject" => "",
            "message" => "",
            "clientid" => "",
            "contactid" => "",
            "name" => "",
            "email" => "",
            "priority" => "",
            "serviceid" => "",
            "domainid" => "",
            "relatedservice" => "",
            'markdown' => true,
            'attachments' => base64_encode(json_encode([['name' => "$filename", 'data' => base64_encode("$filecontent")]])),
        ];
        $args = wp_parse_args($args, $default);

        if ($args["relatedservice"] <> "") {
            if (substr($args["relatedservice"], 0, 1) == "S") {
                $args["serviceid"] = substr($args["relatedservice"], 1);
            } elseif (substr($args["relatedservice"], 0, 1) == "D") {
                $args["domainid"] = substr($args["relatedservice"], 1);
            }
        }

        $args["action"] = "OpenTicket";

        $response = $this->run_whmcs_api($args);

        $_SESSION['response_id'] = $response['id'];

        if (isset($response["result"]) && $response["result"] == "error") {
            return @$response["message"];
        } else {
            $response_html = '<div>';

            $response_html .= '<div class="whcom_alert whcom_alert_success whcom_text_large">';
            $response_html .= '<span class="whcom_icon_ok-circled"></span> <span>' . esc_html__("New ticket has been created, Ticket # ", "whcom") . $response['tid'] . '</span>';
            $response_html .= '</div>';
            $response_html .= '<div class="whcom_text_center">';
            $response_html .= '<button class="whcom_button whcom_button_primary wcap_load_page" data-page="tickets">' . esc_html__("View All Ticket", "whcom") . '</button>';
            $response_html .= '</div>';


            $response_html .= '</div>';


            $response['response_html'] = $response_html;


            return json_encode($response);
        }
    }


    public
    function submit_contact_form(
        $args
    )
    {
        $response = [
            'status' => 'ERROR',
            'errors' => [],
            'message' => esc_html__("Something Went Wrong", "whcom"),
        ];
        $whmcs_settings = whcom_get_whmcs_setting();
        if (!empty($args)) {
            if (empty($args['name'])) {
                $response['errors'][] = esc_html__("You did not enter your name", "whcom");
            }
            if (empty($args['email'])) {
                $response['errors'][] = esc_html__("You did not enter your email address", "whcom");
            } else if (!is_email($args['email'])) {
                $response['errors'][] = esc_html__("You did not enter a valid email address", "whcom");
            }
            if (empty($args['subject'])) {
                $response['errors'][] = esc_html__("You did not enter a subject", "whcom");
            }
            if (empty($args['message'])) {
                $response['errors'][] = esc_html__("You did not enter a message", "whcom");
            }
            if (empty($response['errors'])) {
                if (!empty($whmcs_settings) && !empty($whmcs_settings['ContactFormDept']) && (int)$whmcs_settings['ContactFormDept'] > 0) {
                    $req = [
                        'action' => 'OpenTicket',
                        'deptid' => esc_attr($args['deptid']),
                        'priority' => esc_attr($args['priority']),
                        'subject' => esc_attr($args['subject']),
                        'message' => esc_attr($args['message']),
                        'name' => esc_attr($args['name']),
                        'email' => esc_attr($args['email']),

                    ];
                    $res = whcom_process_api($req);
                    if (!empty($res['result'])) {
                        if ($res['result'] == 'success') {
                            $tmp = '<div class="whcom_text_center">' . esc_html__("Ticket Created", "whcom") . " <strong>#" . $res['tid'] . '</strong></div>';
                            $msg = wcap_render_message("", $tmp, "success");

                            $tmp = esc_html__("Your ticket has been successfully created. An email has been sent to your address with the ticket information. If you would like to view this ticket now you can do so.", "wcap");
                            $msg2 = wcap_render_message("", $tmp, "");

                            $tmp = '<div class="whcom_text_center">' . wcap_render_continue_button("dashboard", "") . '</div>';

                            $response['message'] = $msg . $msg2 . $tmp;
                            $response['status'] = 'OK';
                            //$response['debug'] = $res;
                        } else {
                            $response['message'] = esc_html__("Something went wrong 3", "whcom");
                        }
                    } else {
                        $response['message'] = esc_html__("Something went wrong 2", "whcom");
                    }
                } else {
                    $to = (!empty($whmcs_settings['ContactFormTo']) && is_email($whmcs_settings['ContactFormTo'])) ? esc_attr($whmcs_settings['ContactFormTo']) : '';
                    $subject = 'Contact Form: ' . esc_attr($args['subject']);
                    $body = '<strong>' . esc_html__("Sender Name", "whcom") . '</strong>' . esc_attr($args['name']) . '<br>';
                    $body .= '<strong>' . esc_html__("Sender Email", "whcom") . '</strong>' . esc_attr($args['name']) . '<br>';
                    $body .= '<strong>' . esc_html__("Subject", "whcom") . '</strong>' . esc_attr($args['name']) . '<br>';
                    $body .= esc_attr($args['message']);
                    $headers = array('Content-Type: text/html; charset=UTF-8');

                    if (wp_mail($to, $subject, $body, $headers)) {
                        $response['message'] = esc_html__("Your Message has been Sent", "whcom");
                    } else {
                        $response['message'] = esc_html__("Something went wrong 4 Or Presales Contact Form Email is empty in WHMCS", "whcom");
                    }
                }
            }
        }

        /*		if ($response['status'] == 'OK') {
                    $response['message'] = '<div class="whcom_alert whcom_alert_success">' . $response['message'] . '</div>' ;
                }
                else {
                    if (!empty($response['errors'])) {
                        $response['message'] = '<div class="whcom_alert whcom_alert_danger">';
                        $response['message'] .= '<div class="whcom_margin_bottom_15"> ' . esc_html__( "The following errors occurred:", "whcom" ) . ' </div>' ;
                        $response['message'] .= '<ul class="whcom_list_padded_narrow">' ;
                        foreach ($response['errors'] as $error) {
                            $response['message'] .= '<li>' .$error. '</li>' ;
                        }
                        $response['message'] .= '</ul>' ;
                        $response['message'] .= '</div>';
                    }
                    else {
                        $response['message'] = '<div class="whcom_alert whcom_alert_danger">' . $response['message'] . '</div>';
                    }
                }*/

        return $response;
    }

    public
    function get_client_groups(
        $args = ""
    )
    {
        $default = [
            "action" => "GetClientGroups",
        ];
        $args = wp_parse_args($args, $default);

        $response = $this->run_whmcs_api($args);

        if (isset($response["result"]) && $response["result"] == "error") {
            return @$response["message"];
        } else if (isset($response["groups"]["group"])) {
            return $response["groups"]["group"];
        } else {
            return $response;
        }
    }

    function get_products($args = "")
    {
        $default = [
            "pid" => "",            // Can be comma separated
            "gid" => "",            // Group ID
            "module" => ""          //
        ];
        $args = wp_parse_args($args, $default);

        $args["action"] = "GetProducts";

        $response = $this->run_whmcs_api($args);
        $default_currency = $this->get_default_currency();
        //wcap_ppa($default_currency);


        if (isset($response["result"]) && $response["result"] == "error") {
            return @$response["message"];
        } else if (isset($response["products"]["product"])) {
            $Output["total"] = $response["totalresults"];
            foreach ($response["products"]["product"] as $product) {
                if (isset($product["pricing"]) && is_array($product["pricing"])) {
                    $price_array = $price_array2 = $price_setup_array = [];
                    foreach ($product["pricing"] as $currency_code => $currency_array) {
                        $price_string = "";
                        if ($currency_array["monthly"] > 0) {
                            $price_array[$currency_code]["monthly"] = $currency_array["prefix"] . $currency_array["monthly"] . " " . trim($currency_array["suffix"]);
                            $price_array2[$currency_code]["monthly"] = $currency_array["monthly"];
                            $price_string = $price_array[$currency_code]["monthly"] . "\n" . esc_html__("Monthly", "whcom");
                        }
                        $price_setup_array[$currency_code]["msetupfee"] = $currency_array["msetupfee"];
                        if ($currency_array["quarterly"] > 0) {
                            $price_array[$currency_code]["quarterly"] = $currency_array["prefix"] . $currency_array["quarterly"] . " " . trim($currency_array["suffix"]);
                            $price_array2[$currency_code]["quarterly"] = $currency_array["quarterly"];
                            if (empty($price_string)) {
                                $price_string = $price_array[$currency_code]["quarterly"] . "\n" . esc_html__("Quarterly", "whcom");
                            }
                        }
                        $price_setup_array[$currency_code]["qsetupfee"] = $currency_array["qsetupfee"];
                        if ($currency_array["semiannually"] > 0) {
                            $price_array[$currency_code]["semiannually"] = $currency_array["prefix"] . $currency_array["semiannually"] . " " . trim($currency_array["suffix"]);
                            $price_array2[$currency_code]["semiannually"] = $currency_array["semiannually"];
                            if (empty($price_string)) {
                                $price_string = $price_array[$currency_code]["semiannually"] . "\n" . esc_html__("Semi Annually", "whcom");
                            }
                        }
                        $price_setup_array[$currency_code]["ssetupfee"] = $currency_array["ssetupfee"];
                        if ($currency_array["annually"] > 0) {
                            $price_array[$currency_code]["annually"] = $currency_array["prefix"] . $currency_array["annually"] . " " . trim($currency_array["suffix"]);
                            $price_array2[$currency_code]["annually"] = $currency_array["annually"];
                            if (empty($price_string)) {
                                $price_string = $price_array[$currency_code]["annually"] . "\n" . esc_html__("Annually", "whcom");
                            }
                        }
                        $price_setup_array[$currency_code]["asetupfee"] = $currency_array["asetupfee"];
                        if ($currency_array["biennially"] > 0) {
                            $price_array[$currency_code]["biennially"] = $currency_array["prefix"] . $currency_array["biennially"] . " " . trim($currency_array["suffix"]);
                            $price_array2[$currency_code]["biennially"] = $currency_array["biennially"];
                            if (empty($price_string)) {
                                $price_string = $price_array[$currency_code]["biennially"] . "\n" . esc_html__("Bi Annually", "whcom");
                            }
                        }
                        $price_setup_array[$currency_code]["bsetupfee"] = $currency_array["bsetupfee"];
                        if ($currency_array["triennially"] > 0) {
                            $price_array[$currency_code]["triennially"] = $currency_array["prefix"] . $currency_array["triennially"] . " " . trim($currency_array["suffix"]);
                            $price_array2[$currency_code]["triennially"] = $currency_array["triennially"];
                            if (empty($price_string)) {
                                $price_string = $price_array[$currency_code]["triennially"] . "\n" . esc_html__("Tri Annually", "whcom");
                            }
                        }
                        $price_setup_array[$currency_code]["tsetupfee"] = $currency_array["tsetupfee"];
                        if ($default_currency == $currency_code) {
                            $product["price_string"] = $price_string;
                        }
                    }
                    $product["price_info"] = $price_array;
                    $product["price_info2"] = $price_array2;
                    $product["price_setup_info"] = $price_setup_array;
                }
                $Output[$product["gid"]][] = $product;
            }

            return $Output;
        } else {
            return $response;
        }
    }

    function get_default_currency($get_field = "code")
    {
        $currencies = $this->get_currencies();
        if (isset($currencies[0][$get_field])) {
            return trim($currencies[0][$get_field]);
        } else {
            return "";
        }
    }

    function load_data($args = "")
    {
        $args = wp_parse_args($args, []);

        if (!isset($args["whmpca"]) || (isset($args["whmpca"]) && $args["whmpca"] == 'clientarea')) {
            $page = "dashboard";
        } else {
            $page = $args["whmpca"];
        }

        $found_path = $this->Path . "/views/{$page}.php";

        if (!is_file($found_path)) {
            $found_path = $this->Path . "/views/404.php";
        }

        include_once($found_path);
    }

    function get_payment_methods()
    {
        return whcom_get_payment_gateways();
    }

    function add_order_from_cart($args = "")
    {
        $default = [
            "paymentmethod" => "",
        ];
        $args = wp_parse_args($args, $default);

        $cart = $this->get_cart();

        $final_array = [
            "clientid" => whcom_get_current_client_id(),
        ];
        $pids = $addons = $billingcycles = $domains = $configoptions = [];
        //		$this->show_array( $cart);

        foreach ($cart as $cart_item) {
            ## If domain is renewel.
            if (isset($cart_item["type"]) && $cart_item["type"] == "domainrenew") {
                $final_array["domainrenewals"][$cart_item["name"]] = $cart_item["years"];
                continue;
            }
            if (!empty($cart_item["hostname"])) {
                $final_array["hostname"][] = $cart_item["hostname"];
            }
            if (!empty($cart_item["rootpw"])) {
                $final_array["rootpw"][] = $cart_item["rootpw"];
            }
            if (!empty($cart_item["ns1prefix"])) {
                $final_array["ns1prefix"][] = $cart_item["ns1prefix"];
            }
            if (!empty($cart_item["ns2prefix"])) {
                $final_array["ns2prefix"][] = $cart_item["ns2prefix"];
            }

            if (isset($cart_item["type"]) && $cart_item["type"] == "addon") {
                $final_array["addonids"][] = $cart_item["addonid"];
                $final_array["serviceids"][] = $cart_item["serviceid"];
            } else if (isset($cart_item["type"]) && $cart_item["type"] == "domain") {
                $final_array["domain"][] = $cart_item["name"];
                if (@$cart_item["paytype"] == "domaintransfer") {
                    $final_array["domaintype"][] = "transfer";
                } else {
                    $final_array["domaintype"][] = "register";
                }
                $final_array["regperiod"][] = array_search($cart_item["billingcycle"], $this->YearPeriods) + 1;
                $final_array["dnsmanagement"][] = $cart_item["dnsmanagement"] ? true : false;
                $final_array["emailforwarding"][] = $cart_item["emailforwarding"] ? true : false;
                $final_array["idprotection"][] = $cart_item["idprotection"] ? true : false;
            } else {
                $pids[] = $cart_item["pid"];
                $billingcycles[] = $cart_item["billingcycle"];

                if (!empty($cart_item["configoption"])) {
                    $configoptions[] = base64_encode(serialize($cart_item["configoption"]));
                } else {
                    $configoptions[] = "";
                }
                if ($cart_item["domain_item"] && is_array($cart_item["domain_item"])) {
                    $final_array["domain"][] = $cart_item["domain_item"]["name"];
                    if ($cart_item["domain_item"]["paytype"] == "domainregister") {
                        $final_array["domaintype"][] = "register";
                    } else if ($cart_item["domain_item"]["paytype"] == "domaintransfer") {
                        $final_array["domaintype"][] = "transfer";
                    } else {
                        $final_array["domaintype"][] = "register";
                    }
                    $final_array["regperiod"][] = array_search($cart_item["domain_item"]["billingcycle"], $this->YearPeriods) + 1;
                    if (!empty($cart_item["domain"])) {
                        unset($cart_item["domain"]);
                    }
                } else {
                    if (isset($cart_item["is_attach"]) && !empty($cart_item["domain"])) {
                        $final_array["domain"][] = $cart_item["domain"];
                    }
                }

                if (isset($cart_item["addons"]) && is_array($cart_item["addons"])) {
                    $final_array["addons"][] = implode(",", $cart_item["addons"]);
                } else {
                    $final_array["addons"][] = "";
                }
            }

            if (!empty($cart_item["nameserver1"])) {
                $final_array["nameserver1"] = $cart_item["nameserver1"];
            }
            if (!empty($cart_item["nameserver2"])) {
                $final_array["nameserver2"] = $cart_item["nameserver2"];
            }
            if (!empty($cart_item["nameserver3"])) {
                $final_array["nameserver3"] = $cart_item["nameserver3"];
            }
            if (!empty($cart_item["nameserver4"])) {
                $final_array["nameserver4"] = $cart_item["nameserver4"];
            }
            if (!empty($cart_item["nameserver5"])) {
                $final_array["nameserver5"] = $cart_item["nameserver5"];
            }

            $final_array["pid"] = $pids;
            $final_array["billingcycle"] = $billingcycles;
            $final_array["paymentmethod"] = $args["paymentmethod"];
            $final_array["configoptions"] = $configoptions;
        }

        if (!isset($final_array["paymentmethod"])) {
            $final_array["paymentmethod"] = $args["paymentmethod"];
        }

        //		mail("shakeel@shakeel.pk", "Test debug", print_r($cart,true).print_r($final_array, true)."</pre>");
        //				print_r($final_array);
        return $this->add_order($final_array);
    }

    function get_cart()
    {
        if (!isset($_SESSION["wcap_cart"])) {
            return [];
        }

        if (!is_array($_SESSION["wcap_cart"])) {
            return [];
        }

        return $_SESSION["wcap_cart"];
    }

    /**
     * @author Shakeel Ahmed Siddiqi <shakeel@shakeel.pk>
     * @return boolean
     *
     *
     */
    function empty_cart()
    {
        if (!isset($_SESSION["wcap_cart"])) {
            return true;
        }

        unset($_SESSION["wcap_cart"]);

        return !isset($_SESSION["wcap_cart"]);
    }

    function add_order($args = "")
    {
        $default = [
            "clientid" => "",
            "paymentmethod" => "",
            "pid" => [],
            "domain" => [],
            "billingcycle" => [],
            "domaintype" => [],
            "regperiod" => [],
            "eppcode" => [],
            "nameserver1" => "",
            "nameserver2" => "",
            "nameserver3" => "",
            "nameserver4" => "",
            "nameserver5" => "",
            "customfields" => [],
            "configoptions" => [],
            "priceoverride" => [],
            "promocode" => "",
            "promooverride" => false,
            "affid" => "",
            "noinvoice" => false,
            "noinvoiceemail" => false,
            "noemail" => false,
            "addons" => [],
            "hostname" => [],
            "ns1prefix" => [],
            "ns2prefix" => [],
            "rootpw" => [],
            "contactid" => "",
            "dnsmanagement" => [],
            "domainfields" => [],
            "emailforwarding" => [],
            "idprotection" => [],
            "domainpriceoverride" => [],
            "domainrenewoverride" => [],
            "domainrenewals" => [],
            "clientip" => "",
            "addonid" => "",
            "serviceid" => "",
            "addonids" => [],
            "serviceids" => [],
        ];

        $args = wp_parse_args($args, $default);

        $args["action"] = "AddOrder";

        if (empty($args["clientid"])) {
            $args["clientid"] = whcom_get_current_client_id();
        }

        if (is_array($args["addons"])) {
            $args["addons"] = [implode(",", $args["addons"])];
        }
        /*print_r ($args);
        return;*/

        if (!empty($_SESSION["wcap_coupon"])) {
            $args["promocode"] = $_SESSION["wcap_coupon"];
            unset($_SESSION["wcap_coupon"]);
        }

        $response = $this->run_whmcs_api($args);

        if (isset($response["result"]) && $response["result"] == "success") {
            return $response;
        } else if (isset($response["message"])) {
            return $response["message"];
        } else {
            return $response;
        }
    }

    function generate_auto_auth_url($goto = "")
    {
        # Codes from http://docs.whmcs.com/AutoAuth

        $whmcsurl = trim($this->AdminURL, "/") . "/dologin.php";

        whcom_get_current_client();

        $timestamp = time(); # Get current timestamp
        $user = whcom_get_current_client();
        $email = ($user["email"]);

        //        $email     = $this->get_user_data( "email" ); # Clients Email Address to Login
        if (empty($goto)) {
            $goto = "clientarea.php";
        }
        $hash = sha1($email . $timestamp . $this->InvoiceAuthKey); # Generate Hash

        return $whmcsurl . "?email=$email&timestamp=$timestamp&hash=$hash&goto=" . urlencode($goto);
    }

    function add_to_cart($args = "")
    {
        /*
         * type == "addon" required ["serviceid", "addonid", "name", "descript", "price"
         */
        $default = [
            "type" => "product",
            "pid" => "",
            "billingcycle" => "",
            "name" => "",
            "description" => "",
            "price" => "0",
            "suffix" => "",
            "prefix" => "",
            "setup" => "0",
            "configoption" => [],
            "add_domain" => "0",              // Add domain with order if domain is not free.
            "paytype" => "domainregister",
            "product_row" => [],
            "addons" => [],
            "domain" => "",
            "group_name" => "",
            "serviceid" => "",
            "addonid" => "",
        ];
        $args = wp_parse_args($args, $default);
        extract($args);

        if ($this->is_64encoded($product_row)) {
            $product_row = base64_decode($product_row);
            $product_row = json_decode($product_row, true);
        }

        if ($type == "product" && empty($pid)) {
            return "PID missing.";
        }
        if ($type == "addon" && (empty($serviceid) || empty($addonid) || empty($name))) {
            return "Service ID, Addon ID and name required";
        }
        if (empty($billingcycle)) {
            return "Billing cycle missing.";
        }

        $old_cart = $this->get_cart();

        if ($type == "addon") {
            $cart = [
                "type" => "addon",
                "name" => $name,
                "price" => $price,
                "setup" => $setup,
                "addonid" => $addonid,
                "serviceid" => $serviceid,
                "billingcycle" => $billingcycle,
                "description" => $description,
            ];
        } else {
            $cart = [
                "pid" => $pid,
                "billingcycle" => $billingcycle,
                "name" => $name,
                "description" => $description,
                "price" => $price,
                "suffix" => $suffix,
                "prefix" => $prefix,
                "setup" => $setup,
                "group_name" => $group_name,
            ];
        }

        if (!empty($is_attach)) {
            $cart["is_attach"] = 1;
        }

        if (!empty($hostname)) {
            $cart["hostname"] = $hostname;
        }
        if (!empty($rootpw)) {
            $cart["rootpw"] = $rootpw;
        }
        if (!empty($ns1prefix)) {
            $cart["ns1prefix"] = $ns1prefix;
        }
        if (!empty($ns2prefix)) {
            $cart["ns2prefix"] = $ns2prefix;
        }

        if (!empty($domain)) {
            $cart["domain"] = $domain;
            //$_SESSION["last_checked_domain"];
        }

        if (!empty($configoption)) {
            $cart["configoption"] = $configoption;
        }

        if (!empty($_SESSION["last_checked_domain_paytype"]) && !empty($domain)) {
            $paytype = $_SESSION["last_checked_domain_paytype"];
        }

        if ($add_domain == "1" && !empty($domain) && @$_SESSION["last_checked_domain_paytype"] <> "domainown" && !$this->is_domain_free($product_row, $billingcycle, @$_SESSION["last_checked_domain"])) {
            $ext = $this->get_domain_extension($cart["domain"]);
            $dom_price = $this->get_whmcs_domains("extension=$ext");

            $cart["domain_item"] = [
                "paytype" => $paytype,
                "billingcycle" => "msetupfee",
                "name" => $cart["domain"],
                "price" => $dom_price[$ext][$paytype]["msetupfee"],
            ];
        }

        if (is_array($addons) && !empty($addons)) {
            foreach ($addons as $addon) {
                $cart["addons"][] = $addon;
            }
        }

        $old_cart[] = $cart;

        $_SESSION["wcap_cart"] = $old_cart;
        unset($_SESSION["last_checked_domain"]);
        unset($_SESSION["last_checked_domain_paytype"]);

        return "OK";
    }

    private
    function is_64encoded(
        $string
    )
    {
        return base64_encode(base64_decode($string)) === $string;
    }

    function is_domain_free($product_row, $billingcycle, $domain)
    {
        if (empty($product_row["freedomain"])) {
            return false;
        }
        if (empty($product_row["freedomainpaymentterms"])) {
            return false;
        }
        if (empty($product_row["freedomaintlds"])) {
            return false;
        }

        $freedomainpaymentterms = $this->make_array($product_row["freedomainpaymentterms"]);
        $freedomaintlds = $this->make_array($product_row["freedomaintlds"]);

        if (!in_array($billingcycle, $freedomainpaymentterms)) {
            return false;
        }

        if (!in_array($this->get_domain_extension($domain), $freedomaintlds)) {
            return false;
        }


        return true;
    }

    private
    function make_array(
        $arr, $sep = ",", $considerLineBreaks = false
    )
    {
        if (is_string($arr) && trim($arr) == "") {
            return [];
        }
        if (is_array($arr)) {
            return $arr;
        }
        if ($this->is_json($arr)) {
            $arr = json_decode($arr, true);

            return $arr;
        }
        if ($considerLineBreaks) {
            $arr = str_replace("\n", $sep, $arr);
        }
        //$arr = str_replace("'", "''", $arr);            // To avoid error MySQL insertion/update.
        $arr = explode($sep, $arr);
        $arr = array_map('trim', $arr);
        $arr = array_filter($arr);

        return $arr;
    }

    function get_domain_extension($domain_name)
    {
        $domain = substr($domain_name, 0, strpos($domain_name, "."));

        return substr($domain_name, strpos($domain_name, "."), (strlen($domain_name) - strlen($domain)));
    }

    function get_whmcs_domains($args = "")
    {
        $default = [
            "wcap_db_request" => "",
            "action" => "domains",
            "hash" => md5($this->AutoAuthKey . "creativeON"),
            "currency" => "",
            "extension" => "",
        ];
        $args = wp_parse_args($args, $default);

        $response = $this->curl_get_file_contents($args);
        if ($this->is_json($response)) {
            return json_decode($response, true);
        } else {
            return $response;
        }
    }

    function remove_cart_item($cart_key)
    {
        $cart = $this->get_cart();

        unset($cart[$cart_key]);

        $total = 0;
        foreach ($cart as $key => $item) {
            if ($key == $cart_key) {
                unset($cart[$cart_key]);
            } else {
                $total += $item["price"];
                $total += $item["setup"];
            }
        }
        $_SESSION["wcap_cart"] = $cart;

        return $total;
    }

    function run_whmcs_query($query)
    {
        $args = [
            "wcap_db_request" => "",
            "action" => "mysql_query",
            "hash" => md5($this->AutoAuthKey . "creativeON"),
            "query" => base64_encode($query),
        ];

        $args = wp_parse_args($args, $default);

        $response = $this->curl_get_file_contents($args);

        if ($this->is_json($response)) {
            return json_decode($response, true);
        } else {
            return false;
        }

        //return $response;
    }

    function get_whmcs_products($args = "")
    {
        $default = [
            "wcap_db_request" => "",
            "action" => "products",
            "hash" => md5($this->AutoAuthKey . "creativeON"),
            "currency" => "",
        ];
        if (isset($_SESSION["wcap_currency"]["id"])) {
            $default["currency"] = $_SESSION["wcap_currency"]["id"];
        }

        $args = wp_parse_args($args, $default);

        $response = $this->curl_get_file_contents($args);

        if ($this->is_json($response)) {

            return json_decode($response, true);
        } else {
            return $response;
        }
    }

    function get_product_groups($args = "")
    {
        $default = [
            "wcap_db_request" => "",
            "action" => "groups",
            "hash" => md5($this->AutoAuthKey . "creativeON"),
            "currency" => "",
        ];

        $args = wp_parse_args($args, $default);

        $response = $this->curl_get_file_contents($args);

        if ($this->is_json($response)) {
            return json_decode($response, true);
        } else {
            return $response;
        }
    }

    function get_billing_cycles($product_row)
    {
        $final_array = [];
        $array = ["monthly", "quarterly", "semiannually", "annually", "biennially", "triennially"];
        foreach ($array as $bcycle) {
            if (isset($product_row[$bcycle]) && $product_row[$bcycle] >= 0) {
                if ($product_row["paytype"] == "onetime") {
                    $final_array["onetime"] = [
                        "fee" => $product_row["monthly"],
                        "setupfee" => $product_row["msetupfee"],
                    ];
                    break;
                }
                $final_array[$bcycle] = [
                    "fee" => $product_row[$bcycle],
                    "setupfee" => $product_row[substr($bcycle, 0, 1) . "setupfee"],
                ];
            }
        }

        return $final_array;
    }

    function check_domain_whois($args = "")
    {
        $default = [
            "domain" => "",
        ];

        $args = wp_parse_args($args, $default);

        $args["action"] = "DomainWhois";

        $response = $this->run_whmcs_api($args);

        if (isset($response["result"]) && $response["result"] == "success") {
            return $response;
            /*} else if ( isset( $response["message"] ) ) {
                return $response["message"];*/
        } else {
            if (!is_array($response)) {
                $response["message"] = $response;
                $response["result"] = "error";
            }

            return $response;
        }
    }

    function calculate_prices_by_product_row($product, $billingcycle = "", $config_options = [])
    {
        $price = $this->get_price_array($product, $billingcycle, $config_options);
        $currency = $this->get_currency();

        if ($price["configurable"] == 1) {
            foreach ($price["config_prices"] as $config_price) {
                $price["price"] += $config_price["price"];
            }
        }

        return [
            "price" => $price["price"],
            "setupfee" => $price["setupfee"],
        ];
    }

    function get_price_array($product_row, $billingcycle = "", $config_options = [])
    {
        // Configurable options types
        // 1 = DropDown, 2 = Radio, 3 = Checkbox(Yes/No), 4 = TextBox(Qty)

        $price = $setup_fee = 0;

        if ($billingcycle == "") {

            if ($product_row["paytype"] == "recurring") {
                if ($product_row["monthly"] > 0) {
                    $price = $product_row["monthly"];
                    $setup_fee = $product_row["msetupfee"];
                    $billingcycle = "monthly";
                } elseif ($product_row["quarterly"] > 0) {
                    $price = $product_row["quarterly"];
                    $setup_fee = $product_row["qsetupfee"];
                    $billingcycle = "quarterly";
                } elseif ($product_row["semiannually"] > 0) {
                    $price = $product_row["semiannually"];
                    $setup_fee = $product_row["ssetupfee"];
                    $billingcycle = "semiannually";
                } elseif ($product_row["annually"] > 0) {
                    $price = $product_row["annually"];
                    $setup_fee = $product_row["asetupfee"];
                    $billingcycle = "annually";
                } elseif ($product_row["biennially"] > 0) {
                    $price = $product_row["biennially"];
                    $setup_fee = $product_row["bsetupfee"];
                    $billingcycle = "biennially";
                } elseif ($product_row["triennially"] > 0) {
                    $price = $product_row["triennially"];
                    $setup_fee = $product_row["tsetupfee"];
                    $billingcycle = "triennially";
                }
            } else if ($product_row["paytype"] == "onetime") {
                $price = $product_row["monthly"];
                $setup_fee = $product_row["msetupfee"];
                $billingcycle = "monthly";
            } else if ($product_row["paytype"] == "free") {
                $price = 0;
                $setup_fee = 0;
                $billingcycle = "";
            }
        } else {
            if ($product_row["paytype"] == "recurring") {
                $price = $product_row[$billingcycle];
                $setup_fee = $product_row[substr($billingcycle, 0, 1) . "setupfee"];
            } else if ($product_row["paytype"] == "onetime") {
                $price = $product_row["monthly"];
                $setup_fee = $product_row["msetupfee"];
            } else if ($product_row["paytype"] == "free") {
                $price = 0;
                $setup_fee = 0;
            }
        }

        $additional_price = 0;
        $config_array = [];
        if (count($product_row["configoptions"]) > 0) {
            foreach ($product_row["configoptions"] as $configoption) {
                $index = 0;
                if ($configoption["type"] == "1" || $configoption["type"] == "2") {
                    if (isset($config_options[$configoption["id"]])) {
                        foreach ($configoption["options"] as $k => $conf) {
                            if ($conf["id"] == $config_options[$configoption["id"]]) {
                                $index = $k;
                                break;
                            }
                        }
                    }

                    $config_array[$configoption["id"]] = [
                        "name" => $configoption["optionname"] . ": " . $configoption["options"][$index]["optionname"],
                        "price" => $configoption["options"][$index]["pricing"][$billingcycle],
                    ];
                    $additional_price += $configoption["options"][$index]["pricing"][$billingcycle];
                } else if ($configoption["type"] == "3") {
                    if (isset($config_options[$configoption["id"]])) {
                        $config_array[$configoption["id"]] = [
                            "name" => $configoption["optionname"] . ": " . esc_html__("Yes", "whcom"),
                            "price" => $configoption["options"][0]["pricing"][$billingcycle],
                        ];

                        $additional_price += $configoption["options"][0]["pricing"][$billingcycle];
                    } else {
                        $config_array[$configoption["id"]] = [
                            "name" => $configoption["optionname"] . ": " . esc_html__("No", "whcom"),
                            "price" => 0,
                        ];

                        $additional_price += 0;
                    }

                } else if ($configoption["type"] == "4") {
                    if (isset($config_options[$configoption["id"]])) {
                        $min = $config_options[$configoption["id"]];
                    } else {
                        $min = $configoption["min"];
                    }

                    $config_array[$configoption["id"]] = [
                        "name" => $configoption["optionname"] . ": " . $min,
                        "price" => $min * $configoption["options"][$index]["pricing"][$billingcycle],
                    ];
                    $additional_price += $min * $configoption["options"][$index]["pricing"][$billingcycle];
                }
            }
        }

        return [
            "config_options" => $config_options,
            "db_options" => $product_row["configoptions"],
            "price" => $price,
            "setupfee" => $setup_fee,
            "configurable_fee" => $additional_price,
            "billingcycle" => $billingcycle,
            "configurable" => count($product_row["configoptions"]) > 0 ? "1" : "0",
            "pricetype" => $product_row["paytype"],
            "config_prices" => $config_array,
        ];
    }

    function get_currency()
    {
        if (!isset($_SESSION["wcap_currency"])) {
            $currencies = $this->get_currencies();
            $_SESSION["wcap_currency"] = $currencies[0];
        }

        return $_SESSION["wcap_currency"];
    }

    function display_order_summary_html($product, $billingcycle = "", $config_options = [])
    {
        $price = $this->get_price_array($product, $billingcycle, $config_options);
        $currency = $this->get_currency();
        $HTML = "";
        $HTML .= "<div class='wcap_summary_panel' id='producttotal'>
				<div class='wcap_summary_panel_header whcom_text_center'>
				" . esc_html__("Order Summary", "whcom") . "</div>
				<div class='wcap_summary_panel_body'>				
				<div class='whcom_clearfix'></div>
				    <div class='whcom_pull_left'><strong>" . ucfirst($product['name']) . "</strong></div><div class='whcom_clearfix'></div>
				    <div class='whcom_pull_left'><i>" . ucfirst($product['group_name']) . "</i></div><div class='whcom_clearfix'></div>
				    <div class='whcom_pull_left'>" . ucfirst($product['name']) . "</div>
				    <div class='whcom_pull_right' id='price_td'>" . $currency['prefix'] . ($price['configurable_fee'] + $price['price'] + $price['setupfee']) . "</div>
				<div class='whcom_clearfix'></div>
				";
        if ($price["configurable"] == 1) {
            foreach ($price["config_prices"] as $config_price) {
                $HTML .= "<div class='whcom_pull_left'><i class='whcom_icon_angle-double-right'></i>&nbsp;" . ucfirst($config_price["name"]) . "</div>
					<div class='whcom_pull_right'>" . $currency["prefix"] . $config_price["price"] . "</div>
					<div class='whcom_clearfix'></div>";
            }
        }
        $HTML .= "<div class='wcap_hr_separator'></div><div class='whcom_pull_left'>" . esc_html__('Setup Fee') . "</div>
			     <div class='whcom_pull_right' id='setup_td'>" . $currency["prefix"] . $price["setupfee"] . "</div>
			     <div class='whcom_clearfix'></div>
			     <div class='whcom_pull_left'>" . ucfirst($price["billingcycle"]) . "</div>
			     <div class='whcom_pull_right' id='billing_cycle_td'>" . $currency["prefix"] . $price["price"] . "</div>
			     <div class='whcom_clearfix'></div>
			       ";
        $HTML .= "<div class='whcom_clearfix'></div>
								<div class='wcap_hr_separator'></div>
			                <div class='whcom_pull_right wcap_text_total' id='total_td'>" . $currency['prefix'] . ($price['configurable_fee'] + $price['price'] + $price['setupfee']) . "</div>
			            	<div class='whcom_clearfix'></div>
			            	<div class='whcom_pull_right'>Total Due Today</div>
			            <div class='whcom_clearfix'></div></div></div></div>";

        return $HTML;
    }

    function display_order_configurable_options_html($product, $billingcycle, $config_options = [])
    {
        $price = $this->get_price_array($product, $billingcycle);
        $currency = $this->get_currency();
        $HTML = "";
        $HTML .= '<div class="wcap_config_title">';
        $HTML .= '<div class="whcom_sub_heading_style_1">';
        $HTML .= '<span>' . esc_html__('Configurable Options', "whcom") . '</span>';
        $HTML .= '</div>';
        $HTML .= '</div>';


        //$HTML     = print_r( $config_options, true );
        foreach ($product["configoptions"] as $configoption) {
            $HTML .= "<div class='whcom_form_field whcom_form_field_horizontal'>";
            if ($configoption["type"] == "1") {
                $HTML .= "<label class='main_label'>" . $configoption["optionname"] . "</label>";
                $HTML .= "<select name='configoption[{$configoption['id']}]' class='configoption'>";
                foreach ($configoption["options"] as $row) {
                    if (isset($config_options[$configoption['id']]) && $row['id'] == $config_options[$configoption['id']]) {
                        $S = "selected=selected";
                    } else {
                        $S = "";
                    }
                    $HTML .= "<option $S value='{$row['id']}'>" . $row["optionname"] . " " . $currency["prefix"] . $row["pricing"][$price["billingcycle"]] . "</option>";
                }
                $HTML .= "</select>";
            } else if ($configoption["type"] == "2") {
                $HTML .= "<label class='main_label'>" . $configoption["optionname"] . "</label>";
                $HTML .= "<div class='whcom_radio_container 777'>";
                foreach ($configoption["options"] as $k2 => $row) {
                    if (!isset($config_options[$configoption['id']]) && $k2 == 0) {
                        $S = "checked=checked";
                        $S2 = "whcom_checked";
                    } else if (isset($config_options[$configoption['id']]) && $row['id'] == $config_options[$configoption['id']]) {
                        $S = "checked=checked";
                        $S2 = "whcom_checked";
                    } else {
                        $S = "";
                        $S2 = "";
                    }
                    $HTML .= "<label class='whcom_radio " . $S2 . "'>";
                    $HTML .= "<input class='configoption' {$S} name='configoption[{$configoption['id']}]' type='radio' value='{$row['id']}'> ";
                    $HTML .= $row["optionname"];
                    $HTML .= " " . $currency["prefix"] . $row["pricing"][$price["billingcycle"]];
                    $HTML .= "</label>";
                }
                $HTML .= "</div>";
            } else if ($configoption["type"] == "3") {
                if (isset($config_options[$configoption['id']])) {
                    $S = "checked=checked";
                    $S2 = "whcom_checked";
                } else {
                    $S = "";
                    $S2 = "";
                }

                $HTML .= "<label class='main_label'>" . $configoption["optionname"] . "</label>";
                $HTML .= "<label class='whcom_checkbox " . $S2 . "'>";
                $HTML .= "<input $S type='checkbox' name='configoption[{$configoption['id']}]' value='1' class='configoption'>";
                $HTML .= $configoption["options"][0]["optionname"];
                $HTML .= " " . $currency["prefix"] . $configoption["options"][0]["pricing"][$price["billingcycle"]];;
                $HTML .= "</label>";
            } else if ($configoption["type"] == "4") {
                if (isset($config_options[$configoption['id']])) {
                    $val = $config_options[$configoption['id']];
                } else {
                    $val = $configoption['min'];
                }
                $HTML .= "<label class='main_label'>" . $configoption["optionname"] . "</label>";
                $max = ($configoption['max'] > $configoption['min']) ? "max='{$configoption['max']}'" : "";
                $HTML .= '<span class="whcom_minus">-</span>';
                $HTML .= "<input name='configoption[{$configoption['id']}]' type='number' min='{$configoption['min']}' value='{$val}' $max class='configoption whcom_plus_minus'>";
                $HTML .= '<span class="whcom_plus">+</span>';
                $HTML .= "<label> x " . $configoption["options"][0]["optionname"] . " " . $currency["prefix"] . $configoption["options"][0]["pricing"][$price["billingcycle"]] . '</label>';
            }
            $HTML .= "</div>";
        }

        return $HTML;
    }

    /**
     * @author Shakeel Ahmed Siddiqi <shakeel@shakeel.pk>
     *
     * @param $domain_name
     *
     * @return bool
     */
    function is_domain_valid($domain_name)
    {
        if (strpos($domain_name, ".") === false) {
            return false;
        }

        return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) //valid chars check
            && preg_match("/^.{1,253}$/", $domain_name) //overall length check
            && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)); //length of each label
    }


    function domain_renewal_order($args = [])
    {
        if (!isset($args["domainrenewals"])) {
            return "Domains missing";
        }
        if (!is_array($args["domainrenewals"])) {
            return "Domains missing";
        }
        $output_array = [];
        foreach ($args["domainrenewals"] as $domain => $val) {
            if (!isset($args["domain-years"][$domain])) {
                $output_array[$domain] = 1;
            } else {
                $output_array[$domain] = $args["domain-years"][$domain];
            }
        }

        if (empty($output_array)) {
            return "No domain added in cart.";
        }

        $carts = $this->get_cart();
        foreach ($output_array as $domain => $renew_years) {
            $tmp = explode(",", $renew_years);
            $cart = [
                "type" => "domainrenew",
                "name" => $domain,
                "years" => $tmp[0],
                "price" => $tmp[1],
            ];

            $carts[] = $cart;
        }

        $_SESSION["wcap_cart"] = $carts;

        return "OK";
    }

    function renew_domain($args = "")
    {
        $default = [
            "domainid" => "",
            "domain" => "",
            "regperiod" => "1",
        ];

        $args = wp_parse_args($args, $default);

        $args["action"] = "DomainRenew";

        $response = $this->run_whmcs_api($args);

        if (isset($response["result"]) && $response["result"] == "error") {
            return $response["error"];
        } else if (isset($response["result"]) && $response["result"] == "success") {
            return "OK";
        } else {
            return $response;
        }

    }

    function update_auto_renew_status($args)
    {
        $donotrenew = !($args["newvalue"]);

        $args = [
            "donotrenew" => $donotrenew,
            "domainid" => $args["domainid"],
            "action" => "UpdateClientDomain",
        ];

        $res = whcom_process_api($args);

        $response = [
            'status' => 'ERROR',
            'errors' => [],
            'message' => esc_html__("Something Went Wrong", "whcom"),
        ];

        if (!empty($res["error"])) {
            $title = esc_html__("Error", "whcom");
            $response["message"] = wcap_render_message($title, $res["error"], "danger");
        } else if (isset($res["result"]) && $res["result"] == "success") {
            $response["status"] = "OK";
            $response["message"] = wcap_render_message("", esc_html__("Changes Saved Successfully!", "whcom"), "success");
        } else {
            $response["errors"] = $response;
        }

        return json_encode($response);

    }

    function update_registrar_lock_status($args)
    {

        if ($args["newvalue"] == "1") {
            $lockstatus = false;
        } else {
            $lockstatus = true;
        }

        $args = [
            "lockstatus" => $args["newvalue"],
            "domainid" => $args["domainid"],
            "action" => "DomainUpdateLockingStatus",
        ];

        $res = whcom_process_api($args);

        $response = [
            'status' => 'ERROR',
            'errors' => [],
            'message' => esc_html__("Something Went Wrong", "whcom"),
        ];

        if (!empty($res["error"])) {
            $title = esc_html__("Error", "whcom");
            $response["message"] = wcap_render_message($title, $res["error"], "danger");
        } else if (isset($res["result"]) && $res["result"] == "success") {
            $response["status"] = "OK";
            $response["message"] = wcap_render_message("", esc_html__("Changes Saved Successfully!", "whcom"), "success");
        } else {
            $response["errors"] = $response;
        }

        return json_encode($response);

    }

    function get_client_addons($args = "")
    {
        $default = [
            "action" => "GetClientsAddons",
            "clientid" => "",
            "serviceid" => "",
            "addonid" => "",
        ];

        $args = wp_parse_args($args, $default);

        $response = $this->run_whmcs_api($args);

        return $response;
    }


    function set_domain_locking_status($args = "")
    {
        $default = [
            "domainid" => "",
            "lockstatus" => "",
        ];

        $args = wp_parse_args($args, $default);
        $args["action"] = "DomainUpdateLockingStatus";

        if ($args["lockstatus"] == "true") {
            $args["lockstatus"] = true;
        } else {
            $args["lockstatus"] = false;
        }
        //return json_encode( $args);

        $response = $this->run_whmcs_api($args);

        if (isset($response["result"]) && $response["result"] == "success") {
            return "OK";
        } else if (isset($response["message"])) {
            return "Error: " . $response["message"];
        } else if (isset($response["error"])) {
            return "Error: " . $response["error"];
        } else {
            if (is_array($response)) {
                $response = json_encode($response);
            }

            return "Error: " . $response;
        }
    }

    function get_domain_nameservers($args = "")
    {
        $default = [
            "domainid" => "",
        ];

        $args = wp_parse_args($args, $default);

        //wcap_ppa( $args );

        $args["action"] = "DomainGetNameservers";

        $response = $this->run_whmcs_api($args);

        if (isset($response["ns1"])) {
            return $response;
        } else if (isset($response["error"])) {
            return $response["error"];
        } else {
            if (is_array($response)) {
                $response = json_encode($response);
            }

            return "Error: " . $response;
        }
    }

    function update_domain_nameservers_i($args = "")
    {

        $default = [
            "domainid" => "",
            "ns1" => "",
            "ns2" => "",
            "ns3" => "",
            "ns4" => "",
            "ns5" => "",
        ];

        $args = wp_parse_args($args, $default);
        $args["action"] = "DomainUpdateNameservers";

        $response = [
            'status' => 'ERROR',
            'errors' => [],
            'message' => esc_html__("Something Went Wrong", "whcom"),
        ];


        $res = $this->run_whmcs_api($args);

        if (!empty($res["error"])) {
            $title = esc_html__("Error", "whcom");

            $response["message"] = wcap_render_message($title, $res["error"], "danger");
        } else if (isset($res["result"]) && $res["result"] == "success") {
            $response["status"] = "OK";
            $response["message"] = wcap_render_message("", esc_html__("Changes Saved Successfully!", "whcom"), "success");
        } else {
            $response["errors"] = $response;
        }

        return json_encode($response);
    }

    function get_domain_whois_info($args = "")
    {
        $default = [
            "domainid" => "",
        ];

        $args = wp_parse_args($args, $default);
        $args["action"] = "DomainGetWhoisInfo";

        $xml = new SimpleXMLElement('<contactdetails/>');

        $response = $this->run_whmcs_api($args);

        return $response;
    }

    function set_domain_whois_info($args = "")
    {
        $default = [
            "domainid" => "",
            "xml" => "",
        ];

        $args = wp_parse_args($args, $default);
        $args["action"] = "DomainUpdateWhoisInfo";

        /*$xml = new SimpleXMLElement( '<contactdetails/>' );
        $this->array_to_xml( $data, $xml );
        $args["xml"] = $xml->asXML();*/

        $xml = " < contactdetails>";
        if (isset($args["Registrant"]) && is_array($args["Registrant"])) {
            $xml .= " < Registrant>";
            foreach ($args["Registrant"] as $k => $v) {
                $xml .= " < " . $k . ">" . $v . " </" . $k . " > ";
            }
            $xml .= "</Registrant > ";
            unset($args["Registrant"]);
        }
        if (isset($args["Admin"]) && is_array($args["Admin"])) {
            $xml .= " < Admin>";
            foreach ($args["Admin"] as $k => $v) {
                $xml .= " < " . $k . ">" . $v . " </" . $k . " > ";
            }
            $xml .= "</Admin > ";
        }
        if (isset($args["Tech"]) && is_array($args["Tech"])) {
            $xml .= " < Tech>";
            foreach ($args["Tech"] as $k => $v) {
                $xml .= " < " . $k . ">" . $v . " </" . $k . " > ";
            }
            $xml .= "</Tech > ";
        }
        if (isset($args["Billing"]) && is_array($args["Billing"])) {
            $xml .= " < Billing>";
            foreach ($args["Billing"] as $k => $v) {
                $xml .= " < " . $k . ">" . $v . " </" . $k . " > ";
            }
            $xml .= "</Billing > ";
        }
        unset($args["Admin"]);
        unset($args["Tech"]);
        unset($args["Billing"]);
        $xml .= " </contactdetails > ";
        file_put_contents("D:/abc . txt", $xml);

        $args["xml"] = $xml;
        unset($args["what"]);

        //file_put_contents("D:/abc2 . txt", print_r($args, true));

        $res = $this->run_whmcs_api($args);

        if (!empty($res["error"])) {
            $title = esc_html__("Error", "whcom");

            $response["message"] = wcap_render_message($title, $res["error"], "danger");
        } else if (isset($res["result"]) && $res["result"] == "success") {
            $response["status"] = "OK";
            $response["message"] = wcap_render_message("", esc_html__("Changes Saved Successfully!", "whcom"), "success");
        } else {
            $response["errors"] = $res;
        }

        return json_encode($response);

    }

    function validate_code_from_cart()
    {
        if (isset($_SESSION["wcap_coupon"])) {
            $code = $_SESSION["wcap_coupon"];
        } else {
            $code = "";
        }
        $code = strtolower(trim($code));
        $codes = $this->get_promotions(["code" => $code]);

        if (!isset($codes["promotions"]["promotion"][0]["code"])) {
            unset($_SESSION["wcap_coupon"]);

            return esc_html__("Invalid promotion code . ", "whcom");
        }
        if ($codes["promotions"]["promotion"][0]["code"] <> $code) {
            unset($_SESSION["wcap_coupon"]);

            return esc_html__("Invalid promotion code . ", "whcom");
        }
        $code = $codes["promotions"]["promotion"][0];

        ## Expired promotion code check.
        if ($code["startdate"] <> "0000 - 00 - 00" && $code["expirationdate"] <> "0000 - 00 - 00") {
            if (time() < strtotime($code["startdate"]) || time() > strtotime($code["expirationdate"])) {
                unset($_SESSION["wcap_coupon"]);

                return esc_html__("Promotion Code expired", "whcom");
            }
        }

        if ($code["uses"] > 0 && $code["maxuses"] > 0 && $code["uses"] >= $code["maxuses"]) {
            unset($_SESSION["wcap_coupon"]);

            return esc_html__("Promotion code used . ", "whcom");
        }

        $appliesto = $this->make_array($code["appliesto"]);

        $cart = $this->get_cart();
        $addons = $this->get_addons();

        $is_discount_available = false;
        foreach ($cart as &$item) {
            $total_price = 0;
            $setup_fee = 0;
            if ($item["type"] == "domain") {
                $ext = "D" . $this->get_domain_extension($item["name"]);
                if (in_array($ext, $appliesto)) {
                    $total_price = $item["price"];
                    $setup_fee = $item["setup"];
                }
            } else if (isset($item["pid"]) && in_array($item["pid"], $appliesto)) {
                if ($item["cycles"] <> "") {
                    $cycles = $this->make_array($item["cycles"]);
                }

                $total_price = $item["price"] + $item["setup"];
                $setup_fee = $item["setup"];
                foreach ($item["addons"] as $addon) {
                    foreach ($addons as $addon1) {
                        if ($addon1["id"] == $addon) {
                            $total_price += $addon1["msetupfee"];
                            $setup_fee += $addon1["msetupfee"];
                            $total_price += $addon1["monthly"];
                            break;
                        }
                    }
                }

                if (isset($item["domain_item"]["price"])) {
                    $total_price += $item["domain_item"]["price"];
                }

            } else {
                $total_price = 0;
            }

            if (empty($total_price) && empty($setup_fee)) {
                $item["discount"] = null;
            } else if ($code["type"] == "Free Setup") {
                $item["discount"] = [
                    "code" => $code["code"],
                    "discount" => $setup_fee,
                    "description" => "Free Setup",
                ];
                $is_discount_available = true;
            } else if ($code["type"] == "Fixed Amount" && $code["value"] > 0) {
                $item["discount"] = [
                    "code" => $code["code"],
                    "discount" => $code["value"],
                    "description" => "Fixed Discount",
                ];
                $is_discount_available = true;
            } else if ($code["type"] == "Price Override" && $code["value"] > 0) {
                $item["discount"] = [
                    "code" => $code["code"],
                    "discount" => $total_price - $code["value"],
                    "description" => "Override value",
                ];
                $is_discount_available = true;
            } else if ($code["type"] == "Percentage" && $code["value"] > 0) {
                $item["discount"] = [
                    "code" => $code["code"],
                    "discount" => $total_price * ($code["value"] / 100),
                    "description" => $code["value"] . " % ",
                ];
                $is_discount_available = true;
            } else {
                $item["discount"] = null;
            }
        }

        if (!$is_discount_available) {
            return esc_html__("No discount available . ", "whcom");
        }
        $_SESSION["wcap_cart"] = $cart;

        return "OK";
    }

    function get_promotions($args = "")
    {
        $default = [
            "code" => "",
        ];

        $args = wp_parse_args($args, $default);
        $args["action"] = "GetPromotions";

        $response = $this->run_whmcs_api($args);

        return $response;
    }

    function get_addons($args = "")
    {
        $default = [
            "action" => "addons",
            "pid" => "",
            "clientid" => "",
            "adminuser" => $this->AdminUser,
        ];

        $args = wp_parse_args($args, $default);

        if (empty($args["pid"])) {
            unset($args["pid"]);
        }
        extract($args);

        $response = whcom_process_helper($args);
        //$this->curl_get_file_contents($args);

        //$response['args'] = $args;
        if ($this->is_json($response)) {
            foreach ($response as $k => &$prd) {
                $prd["packages"] = $this->make_array($prd["packages"]);
                if ($pid == "" && !in_array($pid, $prd["packages"])) {
                    unset($response[$k]);
                }
            }

            return json_decode($response, true);
        } else {
            return $response;
        }
    }

    function show_array($ar)
    {
        echo " < pre>";
        print_r($ar);
        echo " </pre > ";
    }

    function remove_coupon_from_cart()
    {
        $carts = $this->get_cart();
        foreach ($carts as &$cart) {
            if (isset($cart["discount"])) {
                unset($cart["discount"]);
            }
        }

        unset($_SESSION["wcap_coupon"]);
        $_SESSION["wcap_cart"] = $carts;
    }

    function get_domain_epp_code($args = "")
    {
        $default = [
            "domainid" => "",
        ];

        $args = wp_parse_args($args, $default);
        $args["action"] = "DomainRequestEPP";


        $response = [
            'status' => 'ERROR',
            'errors' => [],
            'message' => esc_html__("Something Went Wrong", "whcom"),
        ];


        $res = whcom_process_api($args);

        if (!empty($res["error"])) {
            $response["message"] = $res["error"];
        } else if (isset($res["eppcode"])) {
            $response["status"] = "OK";
            $response["message"] = $res["eppcode"];
        } else {
            $response["errors"] = $response;
        }

        return $response;
    }

    function updowngrade_service($args = "")
    {
        $default = [
            "serviceid" => "",
            "calconly" => "1",
            "paymentmethod" => "",
            "type" => "product",
            "newproductid" => "",
            "newproductbillingcycle" => "",
            "promocode" => "",
            "configoptions" => [],
        ];

        $args = wp_parse_args($args, $default);
        if ($args["calconly"] == "1") {
            $args["calconly"] = true;
        } else {
            $args["calconly"] = false;
        }
        $args["action"] = "UpgradeProduct";

        $response = $this->run_whmcs_api($args);

        if (isset($response["result"]) && $response["result"] == "error" && isset($response["message"])) {
            return $response["message"];
        } else if (isset($response["result"]) && $response["result"] == "success") {

            if ($args["calconly"]) {
                return $response;
            } else {
                if (is_array($response)) {
                    $response = json_encode($response);
                }

                return "OK" . $response;
            }
        } else {
            return json_encode($response);
        }
    }

    function updowngrade_options($args = "")
    {

        $default = [
            "serviceid" => "",
            "calconly" => "1",
            "paymentmethod" => "",
            "type" => "configoptions",
            "configoptions" => [],
        ];

        $args = wp_parse_args($args, $default);
        if ($args["calconly"] == "1") {
            $args["calconly"] = true;
        } else {
            $args["calconly"] = false;
        }
        $args["action"] = "UpgradeProduct";


        $response = $this->run_whmcs_api($args);

        if (isset($response["result"]) && $response["result"] == "error" && isset($response["message"])) {
            return $response["message"];
        } else if (isset($response["result"]) && $response["result"] == "success") {
            if ($args["calconly"]) {
                return $response;
            } else {
                return $response;
            }
        } else {
            return json_encode($response);
        }
    }

    function get_upgradable_products($args = "")
    {
        $default = [
            "pid" => "",
        ];

        $args = wp_parse_args($args, $default);
        $rows = $this->get_whmcs_table_data("name = tblproduct_upgrade_products");
        $pids = [];
        foreach ($rows as $k => $row) {
            if ($row["product_id"] == $args["pid"]) {
                $pids[] = $row["upgrade_product_id"];
            }
        }

        return $pids;
    }

    function get_whmcs_table_data($args = "")
    {
        $default = [
            "wcap_db_request" => "",
            "action" => "table",
            "hash" => md5($this->AutoAuthKey . "creativeON"),
            "name" => "",
        ];

        $args = wp_parse_args($args, $default);

        $response = $this->curl_get_file_contents($args);

        if ($this->is_json($response)) {
            return json_decode($response, true);
        } else {
            return $response;
        }
    }

    function is_whmcs_user($username, $password)
    {
        if (!is_email($username)) {
            $user = get_user_by("login", $username);
            $username = $user->data->user_email;
        }

        return password_verify($password, $this->whmcs_password_hash($username));
    }

    function whmcs_password_hash($email_or_user)
    {
        $response = $this->run_whmcs_api([
            "action" => "GetClientPassword",
            "email" => $email_or_user,
        ]);

        if (isset($response["password"])) {
            return $response["password"];
        } else if (isset($response["message"])) {
            return $response["message"];
        } else {
            return $response;
        }
    }

    function get_helper_version($args = "")
    {
        $default = [
            "wcap_db_request" => "",
            "action" => "wcap_helper_version",
            "hash" => md5($this->AutoAuthKey . "creativeON"),
            "currency" => "",
        ];

        $args = wp_parse_args($args, $default);

        $response = $this->curl_get_file_contents($args);

        return $response;
    }

    function get_whmcs_version($args = "")
    {
        $default = [
            "wcap_db_request" => "",
            "action" => "wcap_whmcs_version",
            "hash" => md5($this->AutoAuthKey . "creativeON"),
            "currency" => "",
        ];

        $args = wp_parse_args($args, $default);

        $response = $this->curl_get_file_contents($args);

        return $response;
    }


    function get_whmcs_settings($args = "")
    {
        $default = [
            "wcap_db_request" => "",
            "action" => "whcom_whmcs_settings",
            "hash" => md5($this->AutoAuthKey . "creativeON"),
            "currency" => "",
        ];

        $args = wp_parse_args($args, $default);
        $response = $this->curl_get_file_contents($args);
        if ($this->is_json($response)) {
            return json_decode($response, true);
        } else {
            return $response;
        }

    }


    function get_client_custom_fields($args = "")
    {
        $default = [
            "wcap_db_request" => "",
            "action" => "whmpress_cart_get_custom_fields",
            "hash" => md5($this->AutoAuthKey . "creativeON"),
        ];

        $args = wp_parse_args($args, $default);

        $response = $this->curl_get_file_contents($args);

        if ($this->is_json($response)) {
            return json_decode($response, true);
        } else {
            return $response;
        }
    }

    function add_request_cancel($args = "")
    {
        $default = [
            "serviceid" => "",
            "type" => "",
            "reason" => "",
        ];
        $args = wp_parse_args($args, $default);
        $args["action"] = "AddCancelRequest";

        $response = $this->run_whmcs_api($args);

        return $response;
    }

    function send_reset_password_email($email, $link)
    {
        if (!is_email($email)) {
            return __("Invalid email address", "whcom");
        }
        $field = 'whcom_custom_email_message_' . whcom_get_current_language();
        $c_subject = 'whcom_custom_email_message_subject_' . whcom_get_current_language();
        if (!empty(get_option($field, ''))) {
            $subject = get_option($c_subject, '');
            $c_email = get_option($field, '');
            $query_string = parse_url($link, PHP_URL_QUERY);

            if (empty($query_string)) {
                $link .= "?";
            } else {
                $link .= "&";
            }
            $link .= "whmpca=password_reset_final&token=" . password_hash($email . date("dMY"), PASSWORD_DEFAULT) . "&email={$email}";
            $link = '<a href="' . $link . '">' . $link . '</a>';
            $message = $c_email . "<br>" . $link;
        } else {
            $email_file = $this->Path . "/assets/forget_password.html";

            $lines = file($email_file);
            $subject = $lines[0];
            unset($lines[0]);
            $message = implode("", $lines);


            $query_string = parse_url($link, PHP_URL_QUERY);

            if (empty($query_string)) {
                $link .= "?";
            } else {
                $link .= "&";
            }
            $link .= "whmpca=password_reset_final&token=" . password_hash($email . date("dMY"), PASSWORD_DEFAULT) . "&email={$email}";
            $link = '<a href="' . $link . '">' . $link . '</a>';
        }
        $message = str_ireplace("{reset_link}", $link, $message);
        $headers = $this->get_email_headers();

        $response = wp_mail($email, $subject, $message, $headers);

        if ($response === false) {
            return esc_html__($GLOBALS['phpmailer']->ErrorInfo, "wcap");
        } else {
            return "OK";
        }
    }

    function get_email_headers()
    {
        $headers[] = "Content-Type: text/html; charset=UTF-8";
        $headers[] = "From: " . get_bloginfo("name") . " <noreply@" . parse_url(get_site_url(), PHP_URL_HOST) . "> ";

        return $headers;
    }

    function validate_reset_password_url($args = "")
    {
        $default = [
            "token" => "",
            "email" => "",
        ];
        $args = wp_parse_args($args, $default);

        return password_verify($args["email"] . date("dMY"), $args["token"]);
    }

    function get_whmcs_record_array()
    {
        $fields_array = [
            "address1",
            "address2",
            "city",
            "state",
            "postcode",
            "country",
            "phonenumber",
            "companyname",
            /*"securityqid",
            "securityqans",*/
        ];

        return $fields_array;
    }

    function get_wp_users()
    {
        global $wpdb;
        $Q = "SELECT ID,`user_login`,`user_email`,`user_pass` FROM `{$wpdb->prefix}users` WHERE LEFT(`user_pass`, 2) = '$2'";
        $rows = $wpdb->get_results($Q, ARRAY_A);
        $fields_array = $this->get_whmcs_record_array();

        $skip_roles = get_option("wcapfield_exclude_sync_roles");
        //$this->show_array($skip_roles);

        foreach ($rows as $key => &$row) {
            $user_info = get_userdata($row["ID"]);
            $row["roles"] = $user_info->roles;

            if (is_array($skip_roles)) {
                foreach ($skip_roles as $role) {
                    if (is_array($user_info->roles) && in_array($role, $row["roles"])) {
                        unset($rows[$key]);
                        continue;
                    }
                }
            }

            $row["firstname"] = get_user_meta($row["ID"], "first_name", true);
            $row["lastname"] = get_user_meta($row["ID"], "last_name", true);
            foreach ($fields_array as $field) {
                $row[$field] = get_user_meta($row["ID"], "whcom_" . $field, true);
            }
        }

        $rows = array_values($rows);

        return $rows;

        //echo (int)(str_replace('M', '', ini_get('post_max_size')) * 1024 * 1024);
        //		echo ini_get('max_input_vars')." < br>";
        //		echo $this->get_array_size_in_bytes($rows);
    }

    function update_whmcs_users($args = "")
    {
        $default = [
            "wcap_db_request" => "",
            "action" => "update_clients",
            "hash" => md5($this->AutoAuthKey . "creativeON"),
            "currency" => "",
            "postdata" => [],
        ];

        $args = wp_parse_args($args, $default);

        $postdata = $args["postdata"];
        unset($args["postdata"]);
        $response = $this->curl_get_file_contents($args, $postdata);

        return $response;
        if ($this->is_json($response)) {
            $response = json_decode($response, true);
        } else {
            $response = [];
        }

        return $response;
    }

    function get_array_size_in_bytes($array)
    {
        $array_str = json_encode($array);

        if (function_exists('mb_strlen')) {
            $size = mb_strlen($array_str, '8bit');
        } else {
            $size = strlen($array_str);
        }

        return $size;
    }

    /**
     * @author Shakeel Ahmed Siddiqi <shakeel@shakeel.pk>
     *
     * @param  [security_questions] string $args
     *
     * @return mixed|string
     *
     * Decrypt security questions.
     */

    function get_client_payment_method()
    {
        $client = whcom_get_current_client();
        if (empty($client["defaultgateway"])) {
            $payment_methods = $this->get_payment_methods();

            return empty($payment_methods[0]["module"]) ? "" : $payment_methods[0]["module"];
        }

        return $client["defaultgateway"];
    }

    function get_upgrade_options_status($productid)
    {

        $tmp = whcom_get_product_details($productid);

        $return = ($tmp["configoptionsupgrade"] == 1) ? true : false;

        return $return;
    }

    function pay_mass_payment($args = "")
    {
        $default = [
            "ids" => "",
            "amount" => "",
        ];

        $args = wp_parse_args($args, $default);

        $args["ids"] = $this->make_array($args["ids"]);
        $args["amount"] = $this->make_array($args["amount"]);
        $args ["userid"] = whcom_get_current_client_id();
        $args ["action"] = "CreateInvoice";

        foreach ($args["ids"] as $k => $id) {
            $args["itemdescription" . ($k + 1)] = "Invoice # " . $id;
            $args["itemamount" . ($k + 1)] = $args["amount"][$k];
            //todo:pay invoices here

        }

        $response = whcom_process_api($args);


        if (!empty($response['result'])) {
            if ($response['result'] == 'success') {
                $response['status'] = 'OK';
                $response['message'] = esc_html__('Invoice is generated');
                $response['redirect_link'] = $response['response_form'] = $response['invoice_link'] = $response['show_cc'] = '';
                # Generate AutoAuth URL & Redirect
                $args = [
                    'goto' => "viewinvoice.php?wcap_no_redirect=1&id=" . $response['invoiceid'],
                ];
                $url = whcom_generate_auto_auth_link($args);


                $response['redirect_link'] = '<a href="?whmpca=dashboard" class="whcom_button">' . esc_html__('Dashboard', 'whcom') . '</a> ';
                $order_complete_url = get_option('wcapfield_client_area_url' . whcom_get_current_language(), '?whmpca=dashboard');
                if (get_option('wcapfield_show_invoice_as', 'popup') == 'minimal') {
                    $response['invoice_link'] = '<a href="' . $url . '" class="whcom_button wcop_view_invoice_button">' . esc_html__('Review Invoice & Pay', "whcom") . '</a> ';
                } else if (get_option('wcapfield_show_invoice_as', 'popup') == 'same_tab') {
                    $response['invoice_link'] = '<a href="?whmpca=order_process&a=viewinvoice&id=' . $response['invoiceid'] . '" class="whcom_button wcop_view_invoice_button">' . esc_html__('Review Invoice & Pay', "whcom") . '</a> ';
                } else if (get_option('wcapfield_show_invoice_as', 'popup') == 'new_tab') {
                    $response['invoice_link'] = '<a target="_blank" href="?whmpca=order_process&a=viewinvoice&id=' . $response['invoiceid'] . '" class="whcom_button wcop_view_invoice_button">' . esc_html__('Review Invoice & Pay', "whcom") . '</a> ';
                } else {
                    $redirect_link = '<a class="whcom_op_thickbox_redirect_overlay" href="' . $order_complete_url . '">' . esc_html__('Close', 'whcom') . '</a> ';
                    $invoice_div = '<div id="invoice_' . $response['invoiceid'] . '" style="display:none;"><iframe style="width: 100%; height: 100%; overflow: auto;" src="' . $url . '"></iframe>' . $redirect_link . '</div>';
                    $invoice_anchor = '<a href="#TB_inline?width=1050&height=550&inlineId=invoice_' . $response['invoiceid'] . '" class="thickbox whcom_button whcom_op_view_invoice_button">' . esc_html__('Review Invoice & Pay', 'whcom') . '</a> ';
                    $response['invoice_link'] = $invoice_anchor . $invoice_div;
                }


                ob_start(); ?>
                <div style="padding: 6%; max-width: 680px; margin: 0 auto 40px">

                    <div class="whcom_row">
                        <div class="whcom_col_sm_6 whcom_text_center whcom_text_right_sm whcom_margin_bottom_15">
                            <?php echo $response['redirect_link']; ?>
                        </div>
                        <div class="whcom_col_sm_6 whcom_text_center whcom_text_left_sm whcom_margin_bottom_15">
                            <?php echo $response['invoice_link']; ?>
                        </div>
                    </div>

                </div>

                <?php
                $response['response_html'] = ob_get_clean();
            } else {
                $response['status'] = 'ERROR';
                $response['message'] = '<div class="whcom_alert whcom_alert_danger">' . $response['message'] . '</div>';
            }
        } else {
            $response['status'] = 'ERROR';
            $response['message'] = '<div class="whcom_alert whcom_alert_danger">' . esc_html__('Something went wrong.', 'whcom') . '</div>';
        }

        return $response;
    }

    function service_pending_invoice($user_id, $service_id)
    {
        $invoice_pending = "";

        $args = [
            "userid" => $user_id,
            "status" => "Unpaid",
        ];

        $response = $this->get_invoices($args);
        foreach ($response["invoices"]["invoice"] as $invoice) {

            $invoice_items = $this->get_invoice($invoice["id"]);

            foreach ($invoice_items["items"]["item"] as $item) {

                $invoice_pending = ((int)($item["relid"]) == (int)$service_id) ? true : false;
                if ($invoice_pending) {
                    break;
                }
            }
            if ($invoice_pending) {
                break;
            }
        }

        return $invoice_pending;
    }
}