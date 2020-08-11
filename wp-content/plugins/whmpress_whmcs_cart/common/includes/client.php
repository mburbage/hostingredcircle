<?php defined('ABSPATH') or die("Cannot access pages directly.");


if (!function_exists('whcom_validate_client')) {
    function whcom_validate_client($credentials)
    {
        $response = [];
        if (isset($credentials)) {
            if (!isset($credentials['email'])) {
                $response['message'] = '<i class="whcom_icon_window-close"></i>' . esc_html__(" Email is required", "whcom");
                $response['status'] = 'ERROR';
            } else if (!is_email($credentials['email'])) {
                $response['message'] = '<i class="whcom_icon_window-close"></i>' . esc_html__(" Email is not valid", "whcom");
                $response['status'] = 'ERROR';
            } else if (!isset($credentials['pass'])) {
                $response['message'] = '<i class="whcom_icon_window-close"></i>' . esc_html__(" Password is required", "whcom");
                $response['status'] = 'ERROR';
            } else {

                $user = [
                    'action' => 'ValidateLogin',
                    'email' => esc_attr($credentials['email']),
                    'password2' => esc_attr($credentials['pass'])
                ];

                $res = whcom_process_api($user);

                $response['api_response'] = $res;


                if ($res['result'] != 'success') {
                    $response['message'] = $res['message'];
                    $response['status'] = 'ERROR';
                } else {
                    $user_array = whcom_get_client((int)$res["userid"]);
                    if (!empty($user_array["client"]) && is_array($user_array["client"])) {
                        $_SESSION['whcom_user'] = [];
                        whcom_update_current_currency($user_array['client']['currency']);
                        $_SESSION['whcom_user']['username'] = esc_attr($credentials['email']);
                        $_SESSION['whcom_user']['userid'] = $res["userid"];
                        $_SESSION['whcom_user']['passwordhash'] = $res["passwordhash"];
                        $_SESSION['whcom_user']['client'] = $user_array["client"];


                        $response['message'] = esc_html__("Success! your credentials are working, kindly proceed with order...", "whcom");
                        $response['status'] = 'OK';
                    } else {
                        $_SESSION['whcom_user'] = [];
                        $response['message'] = esc_html__("Something went wrong when trying to get client details from WHMCS", "whcom");;
                        $response['status'] = 'ERROR';
                    }
                }
            }
        } else {
            $response['message'] = esc_html__("Something went wrong, kindly try again later ...", "whcom");
            $response['status'] = 'ERROR';
        }

        return $response;
    }
}

if (!function_exists('whcom_get_client')) {
    function whcom_get_client($id = 0)
    {
        if ($id > 0) {
            $args = [
                'action' => 'GetClientsDetails',
                'clientid' => $id,
            ];
        } else {
            $args = [
                'action' => 'GetClients',
                'limitnum' => '1',
            ];
        }

        return whcom_process_api($args);
    }
}

if (!function_exists('whcom_get_current_client')) {
    function whcom_get_current_client()
    {

        if (whcom_is_client_logged_in()) {
            return $_SESSION['whcom_user']['client'];
        } else {
            return ['client' => []];
        }
    }
}

if (!function_exists('whcom_get_current_client_id')) {
    function whcom_get_current_client_id()
    {
        if (whcom_is_client_logged_in()) {
            return $_SESSION['whcom_user']['client']['id'];
        } else {
            return '0';
        }
    }
}

if (!function_exists('whcom_is_client_logged_in')) {
    function whcom_is_client_logged_in()
    {
        return (!empty($_SESSION['whcom_user']['userid']) && $_SESSION['whcom_user']['userid'] > 0);
    }
}

if (!function_exists('whcom_register_new_client')) {
    function whcom_register_new_client($user_data)
    {
        $response = [];
        $fields_labels = [
            'firstname' => esc_html__('You did not enter your first name'),
            'lastname' => esc_html__('You did not enter your last name'),
            'email' => esc_html__('You did not enter your email address'),
            'address1' => esc_html__('You did not enter your address (line 1)'),
            'city' => esc_html__('You did not enter your city'),
            'state' => esc_html__('You did not enter your state'),
            'postcode' => esc_html__('You did not enter your postcode'),
            'country' => esc_html__('You did not enter your country'),
            'phonenumber' => esc_html__('You did not enter your phone number'),
            'password' => esc_html__('You did not enter a password'),
            'password2' => esc_html__('You did not confirm your password'),
            'securityqid' => esc_html__('You are required to select a security question'),
            'securityqans' => esc_html__('You are required to enter a security answer'),
            'accepttos' => esc_html__('You must accept our Terms of Service'),
        ];

        $required_fields = whcom_get_client_required_fields();

        if (!empty($user_data)) {

            $user = [];
            $errors_array = [];
            foreach ($required_fields as $key => $field) {
                $response['status'] = 'info_invalid';
                $response['message'];
                if (!$field || !$key || $key == 'tos_link') {
                    continue;
                } else {
                    if ($field && empty($user_data[$key])) {
                        $errors_array[] = $fields_labels[$key];
                    } else if ($key == 'email' && (!is_email($user_data['email']))) {
                        $errors_array[] = esc_html__('The email address you entered was not valid');
                    } else if ($key == 'password2' && ($user_data['password'] != $user_data['password2'])) {
                        $errors_array[] = esc_html__('The passwords you entered did not match');
                    } else {
                        $user[$key] = esc_attr($user_data[$key]);
                    }
                }
            }
            if (empty($errors_array)) {

                $user = array_merge($user, $user_data);

                unset($user['password']);
                $user['action'] = 'AddClient';
                $user['clientip'] = whcom_get_user_ip();

                $customfields = ( isset( $user_data['customfields'] ) ) ? $user_data['customfields'] : [];
                $user['customfields'] = base64_encode( serialize( $customfields ) );

                $user['language'] = whcom_get_whmcs_relevant_language();
                $res = whcom_process_api($user);

                if ($res['result'] != 'success') {
                    $response['message'] = $res['message'] . ' API error';
                    $response['status'] = 'ERROR';
                } else {
                    $credentials = [
                        'email' => esc_attr($user_data['email']),
                        'pass' => $user_data['password2'],
                    ];
                    whcom_validate_client($credentials);
                    $response['message'] = esc_html__('New user has been created with your provided email and password');
                    $response['status'] = 'OK';
                    $response['user_id'] = $res;
                }
            } else {
                $response['message'] = '<div class=""><ul class="whcom_margin_bottom_5">';
                foreach ($errors_array as $error) {
                    $response['message'] .= '<li>' . $error . '</li>';
                }
                $response['message'] .= '</div></ul>';
            }

        } else {
            $response['message'] = esc_html__("Something went wrong, kindly try again later ...", "whcom");
            $response['status'] = 'ERROR';
        }

        return $response;
    }
}

if (!function_exists('whcom_client_log_out')) {
    function whcom_client_log_out()
    {
        $_SESSION['whcom_user'] = [];

        return true;
    }
}

if (!function_exists('whcom_get_client_custom_fields')) {
    function whcom_get_client_custom_fields()
    {
        if(!empty($_SESSION['whcom_client_custom_fields']))
        {
            $client_custom_fields = $_SESSION['whcom_client_custom_fields'];
        }else {
            $args = [
                "action" => "whcom_get_client_custom_fields",
            ];

            $client_custom_fields = $_SESSION['whcom_client_custom_fields'] = whcom_process_helper($args)['data'];
        }
        return $client_custom_fields;
    }
}

if (!function_exists('whcom_get_client_contacts')) {
    function whcom_get_client_contacts()
    {
        $response = [];
        $args = [
            "action" => "GetContacts",
            "userid" => whcom_get_current_client_id()
        ];
        $res = whcom_process_api($args);
        if ((!empty($res["result"])) && ($res["result"] == "success") && ($res['totalresults'] > 0)) {
            $response = $res['contacts']['contact'];
        }

        return $response;
    }
}

if (!function_exists('whcom_render_cc_form')) {
    function whcom_render_cc_form()
    {
        $whcom_whmcs_settings = whcom_get_whmcs_setting();
        $cc_types = (!empty($whcom_whmcs_settings) && !empty($whcom_whmcs_settings['AcceptedCardTypes'])) ? $whcom_whmcs_settings['AcceptedCardTypes'] : '';
        $cc_types = explode(',', $cc_types);
        ob_start();
        if (!empty($cc_types)) { ?>
            <!--Payment Options-->
            <div class="whcom_row">
                <div class="whcom_col_sm_6">
                    <!-- Card Type -->
                    <div class="whcom_form_field">
                        <label for="cardtype" class="main_label"><?php esc_html_e('Card Type', 'whcom') ?></label>
                        <select name="cardtype" id="cardtype">
                            <?php foreach ($cc_types as $cc_type) { ?>
                                <option value="<?php echo $cc_type ?>"><?php echo $cc_type ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="whcom_col_sm_6">
                    <!-- Card Number -->
                    <div class="whcom_form_field">
                        <label for="cardnum" class="main_label"><?php esc_html_e('Card Number', 'whcom') ?></label>
                        <input type="number" name="cardnum" id="cardnum" value="">
                    </div>
                </div>
                <div class="whcom_col_sm_6">
                    <!-- Expiry Date -->
                    <div class="whcom_form_field">
                        <label class="" for="exp_month"><?php esc_html_e('Expiry Date', 'whcom') ?></label>
                        <div class="whcom_checkbox_container">
                            <div class="whcom_row">
                                <div class="whcom_col_xs_6">
                                    <select name="exp_month" id="exp_month" title="Expiry Month">
                                        <option value="01"><?php esc_html_e('Jan', 'whcom') ?></option>
                                        <option value="02"><?php esc_html_e('Feb', 'whcom') ?></option>
                                        <option value="03"><?php esc_html_e('Mar', 'whcom') ?></option>
                                        <option value="04"><?php esc_html_e('Apr', 'whcom') ?></option>
                                        <option value="05"><?php esc_html_e('May', 'whcom') ?></option>
                                        <option value="06"><?php esc_html_e('Jun', 'whcom') ?></option>
                                        <option value="07"><?php esc_html_e('Jul', 'whcom') ?></option>
                                        <option value="08"><?php esc_html_e('Aug', 'whcom') ?></option>
                                        <option value="09"><?php esc_html_e('Sep', 'whcom') ?></option>
                                        <option value="10"><?php esc_html_e('Oct', 'whcom') ?></option>
                                        <option value="11"><?php esc_html_e('Nov', 'whcom') ?></option>
                                        <option value="12"><?php esc_html_e('Dec', 'whcom') ?></option>
                                    </select>
                                </div>
                                <div class="whcom_col_xs_6">
                                    <select name="exp_year" title="Expiry Year">
                                        <option value="17"><?php esc_html_e('2017', 'whcom') ?></option>
                                        <option value="18"><?php esc_html_e('2018', 'whcom') ?></option>
                                        <option value="19"><?php esc_html_e('2019', 'whcom') ?></option>
                                        <option value="20"><?php esc_html_e('2020', 'whcom') ?></option>
                                        <option value="21"><?php esc_html_e('2021', 'whcom') ?></option>
                                        <option value="22"><?php esc_html_e('2022', 'whcom') ?></option>
                                        <option value="23"><?php esc_html_e('2023', 'whcom') ?></option>
                                        <option value="24"><?php esc_html_e('2024', 'whcom') ?></option>
                                        <option value="25"><?php esc_html_e('2025', 'whcom') ?></option>
                                        <option value="26"><?php esc_html_e('2026', 'whcom') ?></option>
                                        <option value="27"><?php esc_html_e('2027', 'whcom') ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="whcom_col_sm_6">
                    <!-- Card CVV -->
                    <div class="whcom_form_field">
                        <label for="cvv" class="main_label"><?php esc_html_e('Card CVV', 'whcom') ?></label>
                        <input type="password" name="cvv" id="cvv" value="">
                    </div>
                </div>
            </div>
        <?php }

        return ob_get_clean();
    }
}

if (!function_exists('whcom_get_client_required_fields')) {
    function whcom_get_client_required_fields()
    {
        $settings = whcom_get_whmcs_setting();
        $optional_fields = (!empty($settings) && !empty($settings['ClientsProfileOptionalFields'])) ? explode(',', $settings['ClientsProfileOptionalFields']) : [];
        $accepttos = (!empty($settings) && !empty($settings['EnableTOSAccept']) && (string)$settings['EnableTOSAccept'] == 'on') ? true : false;
        $tos_link = (!empty($settings) && !empty($settings['TermsOfService'])) ? esc_url($settings['TermsOfService']) : '#';
        if (empty($tos_link)) {
            //$accepttos = false;
        }

        $required_fields = [
            'firstname' => true,
            'lastname' => true,
            'email' => true,
            'password' => true,
            'password2' => true,
            'address1' => true,
            'city' => true,
            'state' => true,
            'country' => true,
            'postcode' => true,
            'phonenumber' => true,
            'securityqid' => true,
            'securityqans' => true,
            'accepttos' => $accepttos,
            'tos_link' => $tos_link
        ];

        foreach ($required_fields as $key => $required_field) {
            if (in_array($key, $optional_fields)) {
                $required_fields[$key] = false;
            }
        }

        if (!empty($optional_fields['address1']) && $optional_fields['address1'] == 1) {
            $required_fields['country'] = false;
        }

        if(!empty($_SESSION['whcom_security_questions']))
        {
            $questions = $_SESSION['whcom_security_questions'];
        }else {
            $questions = $_SESSION['whcom_security_questions'] = whcom_process_helper(['action' => 'security_questions'])['data'];
        }
        if (empty($questions) || !is_array($questions)) {
            $required_fields['securityqid'] = false;
            $required_fields['securityqans'] = false;
        }


        return $required_fields;
    }
}

if (!function_exists('whcom_render_client_custom_fields')) {
    function whcom_render_client_custom_fields($name_prepend = '')
    {
        $custom_fields = whcom_get_client_custom_fields();
        ob_start(); ?>

        <?php if (!empty($custom_fields) && is_array($custom_fields)) { ?>
        <div class="whcom_sub_heading_style_1">
            <span><?php esc_html_e('Additional Required Information', 'whcom') ?></span>
        </div>
        <div class="whcom_row">

            <?php foreach ($custom_fields as $i => $custom_field) { ?>
                <div class="whcom_col_sm_6">
                    <div class="whcom_form_field">
                        <?php
                        $required = ($custom_field['required'] == 'on') ? 'required' : '';
                        switch ($custom_field['fieldtype']) {
                            case 'dropdown':
                                {
                                    // Case 1 represents <select> element
                                    $field_options = explode(',', $custom_field['fieldoptions']);
                                    echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field['fieldname'] . ':</label>';
                                    echo '<select class="" name="' . $name_prepend . 'customfields[' . $custom_field['id'] . ']" id="custom_field_[' . $custom_field['id'] . ']" ' . $required . '>';
                                    foreach ($field_options as $opt) {
                                        echo '<option value="' . $opt . '">' . $opt . '</option>';
                                    }
                                    echo '</select>';
                                    break;
                                }
                            case 'tickbox':
                                {
                                    // case 2 represents <input type="checkbox">
                                    echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field['fieldname'] . ':</label>';
                                    echo '<div class="whcom_checkbox_container">';
                                    echo '<label class="whcom_checkbox" for="custom_field_[' . $custom_field['id'] . ']">';
                                    echo '<input type="checkbox" class="" name="' . $name_prepend . 'customfields[' . $custom_field['id'] . ']" id="custom_field_[' . $custom_field['id'] . ']" ' . $required . '>';
                                    echo $custom_field['fieldname'] . ':</label>';
                                    echo '</div>';
                                    break;
                                }
                            case 'password':
                                {
                                    echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field['fieldname'] . ':</label>';
                                    echo '<input type="password" class="" name="' . $name_prepend . 'customfields[' . $custom_field['id'] . ']" id="custom_field_[' . $custom_field['id'] . ']" ' . $required . '>';
                                    break;
                                }
                            case 'text':
                                {
                                    // case 2 represents <input type="number">
                                    echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field['fieldname'] . ':</label>';
                                    echo '<input type="text" class="" name="' . $name_prepend . 'customfields[' . $custom_field['id'] . ']" id="custom_field_[' . $custom_field['id'] . ']" ' . $required . '>';
                                    break;
                                }
                            case 'link':
                                {
                                    // case 2 represents <input type="number">
                                    echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field['fieldname'] . ':</label>';
                                    echo '<input type="url" class="" name="' . $name_prepend . 'customfields[' . $custom_field['id'] . ']" id="custom_field_[' . $custom_field['id'] . ']" ' . $required . '>';
                                    break;
                                }
                            case 'textarea':
                                {
                                    // case 2 represents <input type="number">
                                    echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field['fieldname'] . ':</label>';
                                    echo '<textarea class="" name="' . $name_prepend . 'customfields[' . $custom_field['id'] . ']" id="custom_field_[' . $custom_field['id'] . ']" ' . $required . '></textarea>';
                                    break;
                                }
                            default :
                                {
                                }
                        }

                        ?>
                    </div>
                </div>
                <?php
                $customfields = array($custom_field['id'] => "");
            }
            $user['customfields'] = base64_encode(serialize($customfields));
            ?>
        </div>
    <?php } ?>

        <?php
        return ob_get_clean();
    }
}

if (!function_exists('whcom_get_client_security_questions')) {
    function whcom_get_client_security_questions()
    {
        $questions = whcom_process_helper(['action' => 'security_questions'])['data'];

        if (!empty($questions) && is_array($questions)) {
            foreach ($questions as $index => $question) {
                if (!empty($question['question'])) {
                    $decrypted_question = whcom_whmcs_decrypt($question['question']);
                    if (!empty($decrypted_question['result']) && (string)$decrypted_question['result'] == 'success') {
                        $questions[$index]['question'] = $decrypted_question['password'];
                    } else {
                        unset($questions[$index]);
                    }
                }
            }
        }

        return $questions;
    }
}

if (!function_exists('whcom_render_client_security_questions')) {
    function whcom_render_client_security_questions()
    {
        $questions = whcom_get_client_security_questions();

        ob_start();
        if (!empty($questions) && is_array($questions)) {
            ?>
            <div class="whcom_row">
                <div class="whcom_col_sm_6">
                    <div class="whcom_form_field">
                        <select name="securityqid" id="inputSecurityQId" class="">
                            <option value=""><?php esc_html_e("Please choose a security question", "whcom") ?></option>
                            <?php foreach ($questions as $question) { ?>
                                <option value="<?php echo $question['id']; ?>">
                                    <?php echo $question['question']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="whcom_col_sm_6">
                    <div class="whcom_form_field">
                        <input type="password"
                               name="securityqans"
                               placeholder="Please enter an answer"
                               autocomplete="off">
                    </div>
                </div>
            </div>

            <?php
        }

        return ob_get_clean();
    }
}

if (!function_exists('whcom_render_register_form_fields')) {
    function whcom_render_register_form_fields($custom_fields_name_prepend = '')
    {
        $currencies = whcom_get_all_currencies();
        $required_fields = whcom_get_client_required_fields();
        $countries = whcom_get_countries_array();
        $whmcs_settings = whcom_get_whmcs_setting();
        $default_country = (!empty($whmcs_settings) && !empty($whmcs_settings['DefaultCountry'])) ? esc_attr($whmcs_settings['DefaultCountry']) : 'US';

        ob_start(); ?>

        <!--Personal Information-->
        <div class="whcom_sub_heading_style_1">
            <span><?php esc_html_e('Personal Information', 'whcom') ?></span>
        </div>
        <div class="whcom_row">
            <div class="whcom_col_sm_6">
                <!-- First Name -->

                <div class="whcom_form_field">
                    <input type="text"
                           name="firstname"
                           id="firstname" <?php echo ($required_fields['firstname']) ? 'required="required"' : ''; ?>
                           placeholder="<?php esc_html_e('First Name', 'whcom') ?>"
                           title="<?php esc_html_e('First Name', 'whcom') ?>">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Last Name -->
                <div class="whcom_form_field">
                    <input type="text"
                           name="lastname"
                           id="lastname" <?php echo ($required_fields['lastname']) ? 'required="required"' : ''; ?>
                           placeholder="<?php esc_html_e('Last Name', 'whcom') ?>"
                           title="<?php esc_html_e('Last Name', 'whcom') ?>">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Email -->
                <div class="whcom_form_field">
                    <input type="email"
                           name="email"
                           id="email" <?php echo ($required_fields['email']) ? 'required="required"' : ''; ?>
                           placeholder="<?php esc_html_e('Email Address', 'whcom') ?>"
                           title="<?php esc_html_e('Email Address', 'whcom') ?>">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Phone Number -->
                <div class="whcom_form_field">
                    <input type="tel"
                           name="phonenumber"
                           id="phonenumber" <?php echo ($required_fields['phonenumber']) ? 'required="required"' : ''; ?>
                           placeholder="<?php esc_html_e('Phone Number', 'whcom') ?>"
                           title="<?php esc_html_e('Phone Number', 'whcom') ?>">
                </div>
            </div>
        </div>
        <!--Billing Address-->
        <div class="whcom_sub_heading_style_1"><span><?php esc_html_e('Billing Address', 'whcom') ?></span></div>
        <div class="whcom_row">
            <div class="whcom_col_sm_6">
                <!-- Company -->
                <div class="whcom_form_field">
                    <input type="text"
                           name="companyname"
                           id="companyname"
                           placeholder="<?php esc_html_e('Company Name', 'whcom') ?>"
                           title="<?php esc_html_e('Company Name', 'whcom') ?>">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Address -->
                <div class="whcom_form_field">
                    <input type="text"
                           name="address1"
                           id="address1" <?php echo ($required_fields['address1']) ? 'required="required"' : ''; ?>
                           placeholder="<?php esc_html_e('Address Line 1', 'whcom') ?>"
                           title="<?php esc_html_e('Address Line 1', 'whcom') ?>">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Address Line 2-->
                <div class="whcom_form_field">
                    <input type="text"
                           name="address2"
                           id="address2"
                           placeholder="<?php esc_html_e('Address Line 2', 'whcom') ?>"
                           title="<?php esc_html_e('Address Line 2', 'whcom') ?>">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Country -->
                <div class="whcom_form_field">
                    <select id="country"
                            name="country"
                            title="<?php esc_html_e('Country', 'whcom') ?>" <?php echo ($required_fields['country']) ? 'required="required"' : ''; ?>>
                        <?php
                        foreach ($countries as $code => $country) {
                            $selected = ($code == $default_country) ? 'selected="selected"' : '';
                            echo '<option value="' . $code . '" ' . $selected . '>' . $country . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="whcom_col_sm_4">
                <!-- State -->
                <div class="whcom_form_field">
                    <input type="text" id="stateinput" value="" style="display: none;"
                           placeholder="<?php esc_html_e('State/Region', 'whcom') ?>"
                           title="<?php esc_html_e('State/Region', 'whcom') ?>" <?php echo ($required_fields['state']) ? 'required="required"' : ''; ?>>
                    <select name="state"
                            id="stateselect"
                            title="<?php esc_html_e('State/Region', 'whcom') ?>" <?php echo ($required_fields['state']) ? 'required="required"' : ''; ?>>
                        <option value="">—</option>
                    </select>
                </div>
            </div>
            <div class="whcom_col_sm_4">
                <!-- City -->
                <div class="whcom_form_field">
                    <input type="text"
                           name="city"
                           id="city" <?php echo ($required_fields['city']) ? 'required="required"' : ''; ?>
                           placeholder="<?php esc_html_e('City', 'whcom') ?>"
                           title="<?php esc_html_e('City', 'whcom') ?>">
                </div>
            </div>
            <div class="whcom_col_sm_4">
                <!-- Post Code -->
                <div class="whcom_form_field">
                    <input type="text"
                           name="postcode"
                           id="postcode" <?php echo ($required_fields['postcode']) ? 'required="required"' : ''; ?>
                           placeholder="<?php esc_html_e('Zip Code', 'whcom') ?>"
                           title="<?php esc_html_e('Zip Code', 'whcom') ?>">
                </div>
            </div>
        </div>
        <?php if (is_array($currencies) && !empty($currencies)) {
        $selected = 'selected'; ?>
        <div class="whcom_form_field">
            <select name="currency" title="<?php esc_html_e('Currency', 'whcom') ?>">
                <?php foreach ($currencies as $i => $currency) { ?>
                    <option value="<?php echo $currency['id'] ?>" <?php echo $selected ?> ><?php echo $currency['code'] ?></option>
                    <?php
                    $selected = '';
                } ?>
            </select>
        </div>
    <?php } ?>
        <?php echo whcom_render_client_custom_fields($custom_fields_name_prepend); ?>
        <!--Account Security-->
        <div class="whcom_sub_heading_style_1">
            <span><?php esc_html_e('Account Security', 'whcom') ?></span>
        </div>
        <div class="whcom_row">
            <div class="whcom_col_sm_6">
                <div id="newPassword1" class="whcom_form_field">
                    <input type="password"
                           id="inputNewPassword1"
                           name="password"
                           autocomplete="off" <?php echo ($required_fields['password']) ? 'required="required"' : ''; ?>
                           placeholder="<?php esc_html_e('Password', 'whcom') ?>"
                           title="<?php esc_html_e('Password', 'whcom') ?>">
                    <label class="whcom_checkbox_container">
                        <div class="progress" id="passwordStrengthBar">
                            <div class="progress-bar" role="progressbar" style="width: 0;">
                                <span class="sr-only">New Password Rating: 0%</span>
                            </div>
                        </div>
                    </label>
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <div id="newPassword2" class="whcom_form_field">
                    <input type="password"
                           id="inputNewPassword2"
                           name="password2"
                           autocomplete="off" <?php echo ($required_fields['password2']) ? 'required="required"' : ''; ?>
                           placeholder="<?php esc_html_e('Confirm Password', 'whcom') ?>"
                           title="<?php esc_html_e('Confirm Password', 'whcom') ?>">
                    <div class="whcom_clearfix"></div>
                    <div id="inputNewPassword2Msg"></div>
                </div>
            </div>
        </div>
        <?php echo whcom_render_client_security_questions(); ?>
        <?php
        return ob_get_clean();
    }
}

if (!function_exists('whcom_render_login_form_fields')) {
    function whcom_render_login_form_fields()
    {
        $rand = '_' . rand(1111, 9999);
        ob_start(); ?>
        <div class="whcom_form_field whcom_form_field_horizontal">
            <label for="email<?php echo $rand; ?>">
                <?php esc_html_e('Email', "whcom") ?>
            </label>
            <input type="email" name="login_email" id="email<?php echo $rand; ?>"
                   placeholder="<?php esc_html_e('Email', "whcom") ?>">
        </div>
        <div class="whcom_form_field whcom_form_field_horizontal">
            <label for="pass<?php echo $rand; ?>">
                <?php esc_html_e('Password', "whcom") ?>
            </label>
            <input type="password" name="login_pass" id="pass<?php echo $rand; ?>"
                   placeholder="<?php esc_html_e('Password', "whcom") ?>">
        </div>
        <?php
        return ob_get_clean();
    }
}

if (!function_exists('whcom_gator_render_register_form_fields')) {
    function whcom_gator_render_register_form_fields($custom_fields_name_prepend = '')
    {
        $rand = '_' . rand(1111, 9999);
        $currencies = whcom_get_all_currencies();
        $required_fields = whcom_get_client_required_fields();
        $countries = whcom_get_countries_array();
        $whmcs_settings = whcom_get_whmcs_setting();
        $default_country = (!empty($whmcs_settings) && !empty($whmcs_settings['DefaultCountry'])) ? esc_attr($whmcs_settings['DefaultCountry']) : 'US';

        ob_start(); ?>

        <!--Personal Information-->
        <div class="whcom_sub_heading_style_1">
            <span><?php esc_html_e('Personal Information', 'whcom') ?></span>
        </div>
        <div class="whcom_row">
            <div class="whcom_col_sm_6">
                <!-- First Name -->

                <div class="whcom_form_field">
                    <label for="firstname<?php echo $rand; ?>">
                        <?php esc_html_e('First Name', "whcom") ?>
                    </label>
                    <input type="text"
                           name="firstname"
                           id="firstname" <?php echo ($required_fields['firstname']) ? '' : ''; ?>
                           title="<?php esc_html_e('First Name', 'whcom') ?>">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Last Name -->
                <div class="whcom_form_field">
                    <label for="lastname<?php echo $rand; ?>">
                        <?php esc_html_e('Last Name', "whcom") ?>
                    </label>
                    <input type="text"
                           name="lastname"
                           id="lastname" <?php echo ($required_fields['lastname']) ? '' : ''; ?>
                           title="<?php esc_html_e('Last Name', 'whcom') ?>">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Email -->
                <div class="whcom_form_field">
                    <label for="email<?php echo $rand; ?>">
                        <?php esc_html_e('Email', "whcom") ?>
                    </label>
                    <input type="email"
                           name="email"
                           id="email" <?php echo ($required_fields['email']) ? '' : ''; ?>
                           title="<?php esc_html_e('Email Address', 'whcom') ?>">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Phone Number -->
                <div class="whcom_form_field">
                    <label for="phonenumber<?php echo $rand; ?>">
                        <?php esc_html_e('Phone Number', "whcom") ?>
                    </label>
                    <input type="tel"
                           name="phonenumber"
                           id="phonenumber" <?php echo ($required_fields['phonenumber']) ? '' : ''; ?>
                           title="<?php esc_html_e('Phone Number', 'whcom') ?>">
                </div>
            </div>
        </div>
        <!--Billing Address-->
        <div class="whcom_sub_heading_style_1"><span><?php esc_html_e('Billing Address', 'whcom') ?></span></div>
        <div class="whcom_row">
            <div class="whcom_col_sm_6">
                <!-- Company -->
                <div class="whcom_form_field">
                    <label for="companyname<?php echo $rand; ?>">
                        <?php esc_html_e('Company Name', "whcom") ?>
                    </label>
                    <input type="text"
                           name="companyname"
                           id="companyname"
                           title="<?php esc_html_e('Company Name', 'whcom') ?>">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Address -->
                <div class="whcom_form_field">
                    <label for="address1<?php echo $rand; ?>">
                        <?php esc_html_e('Address Line 1', "whcom") ?>
                    </label>
                    <input type="text"
                           name="address1"
                           id="address1" <?php echo ($required_fields['address1']) ? '' : ''; ?>
                           title="<?php esc_html_e('Address Line 1', 'whcom') ?>">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Address Line 2-->
                <div class="whcom_form_field">
                    <label for="address2<?php echo $rand; ?>">
                        <?php esc_html_e('Address Line 2', "whcom") ?>
                    </label>
                    <input type="text"
                           name="address2"
                           id="address2"
                           title="<?php esc_html_e('Address Line 2', 'whcom') ?>">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Country -->
                <div class="whcom_form_field">
                    <select id="country"
                            name="country"
                            title="<?php esc_html_e('Country', 'whcom') ?>" <?php echo ($required_fields['country']) ? '' : ''; ?>>
                        <?php
                        foreach ($countries as $code => $country) {
                            $selected = ($code == $default_country) ? 'selected="selected"' : '';
                            echo '<option value="' . $code . '" ' . $selected . '>' . $country . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="whcom_row">
            <div class="whcom_col_sm_4">
                <!-- State -->
                <div class="whcom_form_field">
                    <label for="stateinput<?php echo $rand; ?>">
                        <?php esc_html_e('State/Region', "whcom") ?>
                    </label>
                    <input type="text" id="stateinput" value="" style="display: none;"
                           title="<?php esc_html_e('State/Region', 'whcom') ?>" <?php echo ($required_fields['state']) ? '' : ''; ?>>
                    <select name="state"
                            id="stateselect"
                            title="<?php esc_html_e('State/Region', 'whcom') ?>" <?php echo ($required_fields['state']) ? '' : ''; ?>>
                        <option value="">—</option>
                    </select>
                </div>
            </div>
            <div class="whcom_col_sm_4">
                <!-- City -->
                <div class="whcom_form_field">
                    <label for="city<?php echo $rand; ?>">
                        <?php esc_html_e('City', "whcom") ?>
                    </label>
                    <input type="text"
                           name="city"
                           id="city" <?php echo ($required_fields['city']) ? '' : ''; ?>
                           title="<?php esc_html_e('City', 'whcom') ?>">
                </div>
            </div>
            <div class="whcom_col_sm_4">
                <!-- Post Code -->
                <div class="whcom_form_field">
                    <label for="postcode<?php echo $rand; ?>">
                        <?php esc_html_e('Zip Code', "whcom") ?>
                    </label>
                    <input type="text"
                           name="postcode"
                           id="postcode" <?php echo ($required_fields['postcode']) ? '' : ''; ?>
                           title="<?php esc_html_e('Zip Code', 'whcom') ?>">
                </div>
            </div>
        </div>
        <?php if (is_array($currencies) && !empty($currencies)) {
        $selected = 'selected'; ?>
        <div class="whcom_form_field">
            <select name="currency" title="<?php esc_html_e('Currency', 'whcom') ?>">
                <?php foreach ($currencies as $i => $currency) { ?>
                    <option value="<?php echo $currency['id'] ?>" <?php echo $selected ?> ><?php echo $currency['code'] ?></option>
                    <?php
                    $selected = '';
                } ?>
            </select>
        </div>
    <?php } ?>
        <?php echo whcom_render_client_custom_fields($custom_fields_name_prepend); ?>
        <!--Account Security-->
        <div class="whcom_sub_heading_style_1">
            <span><?php esc_html_e('Account Security', 'whcom') ?></span>
        </div>
        <div class="whcom_row">
            <div class="whcom_col_sm_6">
                <div id="newPassword1" class="whcom_form_field">
                    <label for="password<?php echo $rand; ?>">
                        <?php esc_html_e('Password', "whcom") ?>
                    </label>
                    <input type="password"
                           id="inputNewPassword1"
                           name="password"
                           autocomplete="off" <?php echo ($required_fields['password']) ? '' : ''; ?>
                           title="<?php esc_html_e('Password', 'whcom') ?>">
                    <label class="whcom_checkbox_container">
                        <div class="progress" id="passwordStrengthBar">
                            <div class="progress-bar" role="progressbar" style="width: 0;">
                                <span class="sr-only">New Password Rating: 0%</span>
                            </div>
                        </div>
                    </label>
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <div id="newPassword2" class="whcom_form_field">
                    <label for="password2<?php echo $rand; ?>">
                        <?php esc_html_e('Confirm Password', "whcom") ?>
                    </label>
                    <input type="password"
                           id="inputNewPassword2"
                           name="password2"
                           autocomplete="off" <?php echo ($required_fields['password2']) ? '' : ''; ?>
                           title="<?php esc_html_e('Confirm Password', 'whcom') ?>">
                    <div class="whcom_clearfix"></div>
                    <div id="inputNewPassword2Msg"></div>
                </div>
            </div>
        </div>
        <?php echo whcom_render_client_security_questions(); ?>
        <?php
        return ob_get_clean();
    }
}

//login from gator
if (!function_exists('whcom_gator_render_login_form_fields')) {
    function whcom_gator_render_login_form_fields()
    {
        $rand = '_' . rand(1111, 9999);
        ob_start(); ?>
        <div class="whcom_form_field whcom_form_field_horizontal">
            <label for="email<?php echo $rand; ?>">
                <?php esc_html_e('Email', "whcom") ?>
            </label>
            <input type="email" name="login_email" id="email<?php echo $rand; ?>">
        </div>
        <div class="whcom_form_field whcom_form_field_horizontal">
            <label for="pass<?php echo $rand; ?>">
                <?php esc_html_e('Password', "whcom") ?>
            </label>
            <input type="password" name="login_pass" id="pass<?php echo $rand; ?>">
        </div>
        <?php
        return ob_get_clean();
    }
}

if (!function_exists('whcom_render_logged_in_client_info_fields')) {
    function whcom_render_logged_in_client_form()
    {
        $cur_client = whcom_get_current_client();
        global $countries;
        ob_start(); ?>
        <!--Personal Information-->
        <div class="whcom_sub_heading_style_1">
            <span><?php esc_html_e('Personal Information', 'whcom') ?></span>
        </div>
        <div class="whcom_row whcom_row_no_gap">
            <div class="whcom_col_sm_6">
                <!-- First Name -->
                <div class="whcom_form_field">
                    <label for="firstname"><?php esc_html_e('First Name', "whcom") ?></label>
                    <input type="text"
                           id="firstname"

                           value="<?php echo $cur_client['firstname']; ?>"
                           disabled="disabled">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Last Name -->
                <div class="whcom_form_field">
                    <label for="lastname"><?php esc_html_e('Last Name', "whcom") ?></label>
                    <input type="text" id="lastname" value="<?php echo $cur_client['lastname']; ?>" disabled="disabled">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Email -->
                <div class="whcom_form_field">
                    <label for="email"><?php esc_html_e('Email Address', "whcom") ?></label>
                    <input type="email" id="email" value="<?php echo $cur_client['email']; ?>" disabled="disabled">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Phone Number -->
                <div class="whcom_form_field">
                    <label for="phonenumber"><?php esc_html_e('Phone Number', "whcom") ?></label>
                    <input type="tel"
                           id="phonenumber"
                           value="<?php echo $cur_client['phonenumber']; ?>"
                           disabled="disabled">
                </div>
            </div>
        </div>
        <!--Billing Address-->
        <div class="whcom_sub_heading_style_1">
            <span><?php esc_html_e('Billing Address', 'whcom') ?></span>
        </div>
        <div class="whcom_row whcom_row_no_gap">
            <div class="whcom_col_sm_6">
                <!-- Company -->
                <div class="whcom_form_field">
                    <label for="companyname"><?php esc_html_e('Company Name', "whcom") ?></label>
                    <input type="text"
                           id="companyname"
                           value="<?php echo $cur_client['companyname']; ?>"
                           disabled="disabled">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Address -->
                <div class="whcom_form_field">
                    <label for="address1"><?php esc_html_e('Address Line 1', "whcom") ?></label>
                    <input type="text" id="address1" value="<?php echo $cur_client['address1']; ?>" disabled="disabled">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Address Line 2-->
                <div class="whcom_form_field">
                    <label for="address2"><?php esc_html_e('Address Line 2', "whcom") ?></label>
                    <input type="text" id="address2" value="<?php echo $cur_client['address2']; ?>" disabled="disabled">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Country -->
                <div class="whcom_form_field">
                    <label for="country"><?php esc_html_e('Country', "whcom") ?></label>
                    <input type="text"
                           id="country"
                           value="<?php echo isset($countries[$cur_client['country']]); ?>"
                           disabled="disabled">
                </div>
            </div>
            <div class="whcom_col_sm_4">
                <!-- State -->
                <div class="whcom_form_field">
                    <label for="state"><?php esc_html_e('State', "whcom") ?></label>
                    <input type="text" id="state" value="<?php echo $cur_client['state']; ?>" disabled="disabled">
                </div>
            </div>
            <div class="whcom_col_sm_4">
                <!-- City -->
                <div class="whcom_form_field">
                    <label for="city"><?php esc_html_e('City', "whcom") ?></label>
                    <input type="text" id="city" value="<?php echo $cur_client['city']; ?>" disabled="disabled">
                </div>
            </div>
            <div class="whcom_col_sm_4">
                <!-- Post Code -->
                <div class="whcom_form_field">
                    <label for="postcode"><?php esc_html_e('Post Code', "whcom") ?></label>
                    <input type="text" id="postcode" value="<?php echo $cur_client['postcode']; ?>" disabled="disabled">
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

if (!function_exists('whcom_render_update_client_custom_fields')) {
    function whcom_render_update_client_custom_fields($name_prepend = '')
    {
        $client_id = whcom_get_current_client_id();
        $client = whcom_get_client($client_id);
        $custom_fields = whcom_get_client_custom_fields();

        ob_start(); ?>

        <?php if (!empty($custom_fields) && is_array($custom_fields)) { ?>
        <div class="whcom_sub_heading_style_1">
            <span><?php esc_html_e('Additional Required Information', 'whcom') ?></span>
        </div>
        <div class="whcom_row">

            <?php
            foreach ($custom_fields as $i => $custom_field) { ?>
                <div class="whcom_col_sm_6">
                    <div class="whcom_form_field">
                        <?php
                        $required = ($custom_field['required'] == 'on') ? 'required' : '';
                        switch ($custom_field['fieldtype']) {
                            case 'dropdown':
                                {
                                    // Case 1 represents <select> element
                                    $field_options = explode(',', $custom_field['fieldoptions']);
                                    echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field['fieldname'] . ':</label>';
                                    echo '<select class="" name="' . $name_prepend . 'customfields[' . $custom_field['id'] . ']" id="custom_field_[' . $custom_field['id'] . ']" ' . $required . '>';
                                    foreach ($field_options as $opt) {
                                        echo '<option value="' . $opt . '">' . $opt . '</option>';
                                    }
                                    echo '</select>';
                                    break;
                                }
                            case 'tickbox':
                                {
                                    // case 2 represents <input type="checkbox">
                                    echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field['fieldname'] . ':</label>';
                                    echo '<div class="whcom_checkbox_container">';
                                    echo '<label class="whcom_checkbox" for="custom_field_[' . $custom_field['id'] . ']">';
                                    echo '<input type="checkbox" class="" name="' . $name_prepend . 'customfields[' . $custom_field['id'] . ']" id="custom_field_[' . $custom_field['id'] . ']" ' . $required . '>';
                                    echo $custom_field['fieldname'] . ':</label>';
                                    echo '</div>';
                                    break;
                                }
                            case 'password':
                                {
                                    echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field['fieldname'] . ':</label>';
                                    foreach($client['customfields'] as $customfield){
                                        if($custom_field['id'] == $customfield['id'] ){
                                            $result = $customfield['value'];
                                        }
                                    }
                                    echo '<input type="password" class="" value="'. $result . '" name="' . $name_prepend . 'customfields[' . $custom_field['id'] . ']" id="custom_field_[' . $custom_field['id'] . ']" ' . $required . '>';
                                    break;
                                }
                            case 'text':
                                {
                                    // case 2 represents <input type="number">
                                    echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field['fieldname'] . ':</label>';
                                   foreach($client['customfields'] as $customfield){
                                       if($custom_field['id'] == $customfield['id'] ){
                                           $result = $customfield['value'];
                                       }
                                   }
                                    echo '<input type="text" class="" value="'. $result . '" name="' . $name_prepend . 'customfields[' . $custom_field['id'] . ']" id="custom_field_[' . $custom_field['id'] . ']" ' . $required . '>';
                                    break;
                                }
                            case 'link':
                                {
                                    // case 2 represents <input type="number">
                                    echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field['fieldname'] . ':</label>';
                                    foreach($client['customfields'] as $customfield){
                                        if($custom_field['id'] == $customfield['id'] ){
                                            $result = $customfield['value'];
                                        }
                                    }
                                    echo '<input type="url" class="" value="'. $result . '"  name="' . $name_prepend . 'customfields[' . $custom_field['id'] . ']" id="custom_field_[' . $custom_field['id'] . ']" ' . $required . '>';
                                    break;
                                }
                            case 'textarea':
                                {
                                    // case 2 represents <input type="number">
                                    echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field['fieldname'] . ':</label>';
                                    foreach($client['customfields'] as $customfield){
                                        if($custom_field['id'] == $customfield['id'] ){
                                            $result = $customfield['value'];
                                        }
                                    }
                                    echo '<textarea class="" name="' . $name_prepend . 'customfields[' . $custom_field['id'] . ']" id="custom_field_[' . $custom_field['id'] . ']" ' . $required . '> ' .$result . ' </textarea>';
                                    break;
                                }
                            default :
                                {
                                }
                        }

                        ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php }  ?>

        <?php
        return ob_get_clean();
    }
}

if (!function_exists('whcom_render_update_client_form_fields')) {
    function whcom_render_update_client_form_fields()
    {
        $currencies = whcom_get_all_currencies();
        $required_fields = whcom_get_client_required_fields();
        $countries = whcom_get_countries_array();
        $client_id = whcom_get_current_client_id();
        $client = whcom_get_client($client_id);
        ob_start();


        ?>


        <!--Personal Information-->
        <div class="whcom_sub_heading_style_1">
            <span><?php esc_html_e('Personal Information', 'whcom') ?></span>
        </div>
        <div class="whcom_row">
            <div class="whcom_col_sm_6">
                <!-- First Name -->

                <div class="whcom_form_field">
                    <input type="text"
                           name="firstname"
                           id="firstname" value="<?php echo $client['firstname']; ?>"
                           placeholder="<?php esc_html_e('First Name', 'whcom') ?>"
                           title="<?php esc_html_e('First Name', 'whcom') ?>">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Last Name -->
                <div class="whcom_form_field">
                    <input type="text"
                           name="lastname"
                           id="lastname" value="<?php echo $client['lastname']; ?>"
                           placeholder="<?php esc_html_e('Last Name', 'whcom') ?>"
                           title="<?php esc_html_e('Last Name', 'whcom') ?>">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Email -->
                <div class="whcom_form_field">
                    <input type="email"
                           name="email"
                           id="email" value="<?php echo $client['email']; ?>"
                           placeholder="<?php esc_html_e('Email Address', 'whcom') ?>"
                           title="<?php esc_html_e('Email Address', 'whcom') ?>">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Phone Number -->
                <div class="whcom_form_field">
                    <input type="tel"
                           name="phonenumber"
                           id="phonenumber" value="<?php echo $client['phonenumber']; ?>"
                           placeholder="<?php esc_html_e('Phone Number', 'whcom') ?>"
                           title="<?php esc_html_e('Phone Number', 'whcom') ?>">
                </div>
            </div>
        </div>
        <!--Billing Address-->
        <div class="whcom_sub_heading_style_1"><span><?php esc_html_e('Billing Address', 'whcom') ?></span></div>
        <div class="whcom_row">
            <div class="whcom_col_sm_6">
                <!-- Company -->
                <div class="whcom_form_field">
                    <input type="text"
                           name="companyname"
                           id="companyname"
                           value="<?php echo $client['companyname']; ?>"
                           placeholder="<?php esc_html_e('Company Name', 'whcom') ?>"
                           title="<?php esc_html_e('Company Name', 'whcom') ?>">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Address -->
                <div class="whcom_form_field">
                    <input type="text"
                           name="address1"
                           id="address1" value="<?php echo $client['address1']; ?>"
                           placeholder="<?php esc_html_e('Address Line 1', 'whcom') ?>"
                           title="<?php esc_html_e('Address Line 1', 'whcom') ?>">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Address Line 2-->
                <div class="whcom_form_field">
                    <input type="text"
                           name="address2"
                           id="address2"
                           value="<?php echo $client['address2']; ?>"
                           placeholder="<?php esc_html_e('Address Line 2', 'whcom') ?>"
                           title="<?php esc_html_e('Address Line 2', 'whcom') ?>">
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <!-- Country -->
                <div class="whcom_form_field">
                    <select id="country"
                            name="country"
                            title="<?php esc_html_e('Country', 'whcom') ?>" <?php echo ($required_fields['country']) ? 'required="required"' : ''; ?>>
                        <?php
                        foreach ($countries as $code => $country) {
                            $selected = ($code == $client['country']) ? 'selected="selected"' : '';
                            echo '<option value="' . $code . '" ' . $selected . '>' . $country . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="whcom_col_sm_4">
                <!-- State -->
                <div class="whcom_form_field">
                    <input type="text" id="stateinput" value="<?php echo $client['state']; ?>" style="display: none;"
                           placeholder="<?php esc_html_e('State/Region', 'whcom') ?>"
                           title="<?php esc_html_e('State/Region', 'whcom') ?>" <?php echo ($required_fields['state']) ? 'required="required"' : ''; ?>>
                    <select name="state"
                            id="stateselect"
                            title="<?php esc_html_e('State/Region', 'whcom') ?>" <?php echo ($required_fields['state']) ? 'required="required"' : ''; ?>>
                        <option value="">—</option>
                    </select>
                </div>
            </div>
            <div class="whcom_col_sm_4">
                <!-- City -->
                <div class="whcom_form_field">
                    <input type="text"
                           name="city"
                           value="<?php echo $client['city']; ?>"
                           id="city" <?php echo ($required_fields['city']) ? 'required="required"' : ''; ?>
                           placeholder="<?php esc_html_e('City', 'whcom') ?>"
                           title="<?php esc_html_e('City', 'whcom') ?>">
                </div>
            </div>
            <div class="whcom_col_sm_4">
                <!-- Post Code -->
                <div class="whcom_form_field">
                    <input type="text"
                           name="postcode"
                           value="<?php echo $client['postcode']; ?>"
                           id="postcode" <?php echo ($required_fields['postcode']) ? 'required="required"' : ''; ?>
                           placeholder="<?php esc_html_e('Zip Code', 'whcom') ?>"
                           title="<?php esc_html_e('Zip Code', 'whcom') ?>">
                </div>
            </div>
        </div>
        <?php if (is_array($currencies) && !empty($currencies)) {
        $selected = 'selected' ?>
        <div class="whcom_form_field">
            <select name="currency" title="<?php esc_html_e('Currency', 'whcom') ?>">
                <?php foreach ($currencies as $i => $currency) { ?>
                    <option value="<?php echo $currency['id'] ?>" <?php echo $selected ?> ><?php echo $currency['code'] ?></option>
                    <?php
                    $selected = '';
                } ?>
            </select>
        </div>
    <?php } ?>
        <?php echo whcom_render_update_client_custom_fields(); ?>
        <!--Account Security-->
            <!--<div class="whcom_sub_heading_style_1">
            <span><?php /*esc_html_e( 'Account Security', 'whcom' ) */ ?></span>
        </div>
		--><?php /*echo whcom_render_client_security_questions(); */ ?>
        <?php if ($required_fields['accepttos'] && $required_fields['tos_link'] != '') { ?>
        <div class="whcom_row">
            <div class="whcom_col_sm_12">
                <div class="whcom_form_field">
                    <div class="whcom_panel whcom_panel_danger whcom_panel_fancy_1">
                        <div class="whcom_panel_header">
								<span class="panel-title"><i
                                            class="whcom_icon_attention"></i>
									&nbsp; <?php esc_html_e("Terms of Service", "whcom") ?></span>
                        </div>
                        <div class="whcom_panel_body">
                            <label class="checkbox whcom_checkbox">
                                <input type="checkbox"
                                       name="accepttos"
                                       class="accepttos" <?php echo ($required_fields['accepttos']) ? 'required="required"' : ''; ?>>
                                <?php esc_html_e("I have read and agree to the", "whcom") ?>
                                <a href="<?php echo $required_fields['tos_link']; ?>"
                                   target="_blank"><?php esc_html_e("Terms of Service", "whcom") ?></a>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>


        <?php

        return ob_get_clean();
    }
}

if (!function_exists('whcom_render_client_register_JS')) {
    function whcom_render_client_register_JS()
    {
        ob_start();
        ?>
        <script>
            /**
             * Below JS codes came from WHMCS for processing of registration form....
             */
            function changeState() {
                var a = "", i = 0;
                b = jQuery("input[name=state]").data("selectinlinedropdown");
                a = getStateSelectClass(b), a.length < 1 && (
                    b = jQuery("#stateinput").data("selectinlinedropdown"), a = getStateSelectClass(b)
                );
                var c = jQuery("#stateinput").val(),
                    d = jQuery("select[name=country]").val(),
                    e = jQuery("#stateinput").attr("tabindex"),
                    f = jQuery("#stateinput").attr("disabled"),
                    g = jQuery("#stateinput").attr("readonly");
                if (void 0 === e && (
                    e = ""
                ), void 0 === f && (
                    f = ""
                ), void 0 === g && (
                    g = ""
                ), states[d]) {
                    jQuery("#stateinput").hide().removeAttr("name").removeAttr("required"), jQuery("#inputStateIcon").hide(), jQuery("#stateselect").remove();
                    var h = "";
                    for (key in states[d]) {
                        if (stateval = states[d][key], "end" == stateval) {
                            break;
                        }
                        h += "<option", stateval == c && (
                            h += ' selected="selected"'
                        ), h += ">" + stateval + "</option>"
                    }
                    "" != e && (
                        e = ' tabindex="' + e + '"'
                    ), (
                        f || g
                    ) && (
                        f = " disabled"
                    ), jQuery("#stateinput").parent().append('<select name="state" class="' + jQuery("#stateinput").attr("class") + a + '" id="stateselect"' + e + f + '><option value="">&mdash;</option>' + h + "</select>");
                    i = !0;
                    "boolean" == typeof stateNotRequired && stateNotRequired && (
                        i = !1
                    ), jQuery("#stateselect").attr("required", i)
                }
                else {
                    i = !0;
                    "boolean" == typeof stateNotRequired && stateNotRequired && (
                        i = !1
                    ), jQuery("#stateselect").remove(), jQuery("#stateinput").show().attr("name", "state").attr("required", i), jQuery("#inputStateIcon").show()
                }
            }

            function getStateSelectClass(a) {
                var b = "";
                return a && (
                    b = " select-inline"
                ), b
            }

            function validatePassword2() {
                var a = jQuery("#inputNewPassword1").val(),
                    b = jQuery("#inputNewPassword2").val(),
                    c = jQuery("#newPassword2");
                b && a !== b ? (
                    c.removeClass("has-success").addClass("has-error"), jQuery("#inputNewPassword2").next(".whcom_form_control-feedback").removeClass("glyphicon-ok").addClass("glyphicon-remove"), jQuery("#inputNewPassword2Msg").html('<p class="help-block">The passwords entered do not match</p>'), jQuery('input[type="submit"]').attr("disabled", "disabled")
                ) : (
                    b ? (
                        c.removeClass("has-error").addClass("has-success"), jQuery("#inputNewPassword2").next(".whcom_form_control-feedback").removeClass("glyphicon-remove").addClass("glyphicon-ok"), jQuery('.main-content input[type="submit"]').removeAttr("disabled")
                    ) : (
                        c.removeClass("has-error has-success"), jQuery("#inputNewPassword2").next(".whcom_form_control-feedback").removeClass("glyphicon-remove glyphicon-ok")
                    ), jQuery("#inputNewPassword2Msg").html("")
                )
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
                    e > 5 && (
                        e = 5
                    );
                    var f = d.replace(/[0-9]/g, ""),
                        g = d.length - f.length;
                    g > 3 && (
                        g = 3
                    );
                    var h = d.replace(/\W/g, ""),
                        i = d.length - h.length;
                    i > 3 && (
                        i = 3
                    );
                    var j = d.replace(/[A-Z]/g, ""),
                        k = d.length - j.length;
                    k > 3 && (
                        k = 3
                    );
                    var l = 10 * e - 20 + 10 * g + 15 * i + 10 * k;
                    l < 0 && (
                        l = 0
                    ), l > 100 && (
                        l = 100
                    ), c.removeClass("has-error has-warning has-success"), jQuery("#inputNewPassword1").next(".whcom_form_control-feedback").removeClass("glyphicon-remove glyphicon-warning-sign glyphicon-ok"), jQuery("#passwordStrengthBar .progress-bar").removeClass("progress-bar-danger progress-bar-warning progress-bar-success").css("width", l + "%").attr("aria-valuenow", l), jQuery("#passwordStrengthBar .progress-bar .sr-only").html("New Password Rating: " + l + "%"), l < a ? (
                        c.addClass("has-error"), jQuery("#inputNewPassword1").next(".whcom_form_control-feedback").addClass("glyphicon-remove"), jQuery("#passwordStrengthBar .progress-bar").addClass("progress-bar-danger")
                    ) : l < b ? (
                        c.addClass("has-warning"), jQuery("#inputNewPassword1").next(".whcom_form_control-feedback").addClass("glyphicon-warning-sign"), jQuery("#passwordStrengthBar .progress-bar").addClass("progress-bar-warning")
                    ) : (
                        c.addClass("has-success"), jQuery("#inputNewPassword1").next(".whcom_form_control-feedback").addClass("glyphicon-ok"), jQuery("#passwordStrengthBar .progress-bar").addClass("progress-bar-success")
                    ), validatePassword2()
                }),
                jQuery(document).ready(function () {
                    jQuery('.using-password-strength input[type="submit"]').attr("disabled", "disabled"), jQuery("#inputNewPassword2").keyup(function () {
                        validatePassword2()
                    })
                });
        </script>
        <?php
        return ob_get_clean();
    }
}

if (!function_exists('whcom_login_client_in_whmcs_direct')) {
    function whcom_login_client_in_whmcs_direct()
    {
        $url = whcom_generate_auto_auth_link();
        $user_agent = (!empty($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36';

        var_dump($url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_POST, 0);
        $output = curl_exec($ch);
        if ($output === false) {
            echo 'Curl error: ' . curl_error($ch);
        } else {
            var_dump($output);
        }
        curl_close($ch);
        whcom_ppa($output);
    }
}

if (!function_exists('whcom_logout_client_from_whmcs_direct')) {
    function whcom_logout_client_from_whmcs_direct()
    {

    }
}








