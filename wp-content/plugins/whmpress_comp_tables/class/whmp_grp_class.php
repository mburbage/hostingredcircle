<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class WHMPress_Group_Class {

    function __construct() {
        // Don't run anything else in the plugin, if WHMPress is not activated.
        if ( ! $this->is_whmpress_activated() ) {
            /*deactivate_plugins( plugin_basename( WPCT_GRP_FILE ) );*/
            add_action( 'admin_notices', [ $this, 'disbled_notice' ] );
            if ( isset( $_GET['activate'] ) ) {
                unset( $_GET['activate'] );
            }

            return;
        }

        if ( is_admin() ) {
            add_action( 'admin_menu', [ $this, 'whmp_add_pages' ] );
        }

        // Adding shortcodes.
        $this->shortcodes();

        // Add styles and scripts on front-end only.
        if ( ! is_admin() ) {
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles_scripts' ] );
        }

        // Add Styles and Scripts on admin-pages
        if ( is_admin() ) {
            add_action( 'admin_enqueue_scripts', [ $this, 'wpct_enqueue_admin_styles_scripts' ] );
        }

        ## Add functions.php
        require_once( WPCT_GRP_PATH . '/inc/functions.php' );

        add_action( 'admin_init', [ $this, 'register_setting' ] );
        add_action( 'admin_init', [ $this, 'default_settings' ] );
    }



    /**
     * Set all fields used in Settings page in Admin panel.
     */
    public function register_setting() {
        register_setting( 'wpct', 'wpct_load_style_orders' );
        register_setting( 'wpct', 'wpct_cost_string1_' . $this->get_current_language() );
        register_setting( 'wpct', 'wpct_cost_string2_' . $this->get_current_language() );
        register_setting( 'wpct', 'wpct_discount_string1_' . $this->get_current_language() );
        register_setting( 'wpct', 'wpct_discount_string2_' . $this->get_current_language() );
        register_setting( 'wpct', 'wpct_feature_string1_' . $this->get_current_language() );
        register_setting( 'wpct', 'wpct_feature_string2_' . $this->get_current_language() );
    }

    /**
     * Set default values for all fields used in Settings page in Admin panel.
     */
    public function default_settings() {
        add_option( 'wpct_load_style_orders', '' );
        add_option( 'wpct_cost_string1_' . $this->get_current_language(), '' );
        add_option( 'wpct_cost_string2_' . $this->get_current_language(), '' );
        add_option( 'wpct_discount_string1_' . $this->get_current_language(), 'Switch {duration} and save {discount}' );
        add_option( 'wpct_discount_string2_' . $this->get_current_language(), 'You saved {discount}' );
        add_option( 'wpct_feature_string1_' . $this->get_current_language(), 'Switch {duration}<br>Save {discount}' );
        add_option( 'wpct_feature_string2_' . $this->get_current_language(), 'Saved<br> {discount}' );
    }

    // Function to check if WHMPress is active or not
    function is_whmpress_activated() {
        if ( ! function_exists( 'is_plugin_active' ) ) {
            return false;
        } else {
            return is_plugin_active( 'whmpress/whmpress.php' );
        }
    }

    // Notice html if WHMPress is not active
    function disbled_notice() {
        $class   = 'notice notice-error';
        $message = __( 'WHMpress is not activated. Please activate WHMpress', 'wpct' );

        printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
    }

    // Register and enqueue a custom stylesheet in the front-end.
    function enqueue_styles_scripts() {
        // Enqueue Slick Carousel Plugin.
        wp_enqueue_style( 'whmp_grp_slick', '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.css' );
        wp_enqueue_script( 'whmp_grp_slick', '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js', [ 'jquery' ] );

        // Enqueue jQuery UI on front-end
        wp_enqueue_style( 'whmp_grp_jQuery_UI_CSS', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' );
        wp_enqueue_script( 'whmp_grp_jQuery_UI_JS', WPCT_GRP_URL . '/js/jquery-ui.min.js', 'jquery' );

        // Enqueue Plugins Styles and Scripts
        wp_enqueue_style( 'whmp_grp_styles', WPCT_GRP_URL . '/css/styles.css' );
        wp_enqueue_script( 'whmp_grp_scripts', WPCT_GRP_URL . '/js/scripts.js', 'jquery', '', true);
    }

    // Register and enqueue a custom stylesheet in the WordPress admin.
    function wpct_enqueue_admin_styles_scripts() {
        wp_register_style( 'custom_wp_admin_css', WPCT_GRP_URL . '/admin/css/admin-styles.css', false, '1.0.0' );
        wp_enqueue_script( 'whmp_grp_admin_scripts', WPCT_GRP_URL . '/admin/js/admin.js', 'jquery' );
        wp_register_style( 'custom_wp_admin_icons', '//cdn.linearicons.com/free/1.0.0/icon-font.min.css', false, '1.0.0' );

        wp_enqueue_style( 'custom_wp_admin_css' );
        wp_enqueue_style( 'custom_wp_admin_icons' );

        //jQuery UI for admin pages...
        wp_enqueue_script( 'jquery-ui-dialog' );
    }


    // Register Short-Codes for plugin
    function shortcodes() {
        add_shortcode( 'whmpress_comparison_table', [ $this, 'group_shortcode' ] );
        add_shortcode( 'whmpress_order_slider', [ $this, 'order_slider' ] );
        add_shortcode( 'whmpress_pricing_table_group', [ $this, 'pricing_table_group' ] );
    }

    // Function for Comparison Tables short-code
    function pricing_table_group( $atts ) {
        $OutputString = include( WPCT_GRP_PATH . "/shortcodes/whmpress_pricing_table_group.php" );
        return $OutputString;
    }

    // Function for Slider short-code
    function order_slider( $atts ) {
        $OutputString = include( WPCT_GRP_PATH . "/shortcodes/whmpress_order_slider.php" );
        return $OutputString;
    }

    // Function for Pricing Tables Group short-code
    function group_shortcode( $atts ) {
        $OutputString = include( WPCT_GRP_PATH . "/shortcodes/whmpress_comparison_table.php" );
        return $OutputString;
    }

    // Function(s) for adding Admin menu and pages in wp-admin
    function whmp_add_pages() {
        add_menu_page( __( 'Slider & Comparison', 'whmpress' ), __( 'Slider & Comparison', 'whmpress' ), 'manage_options', 'wpct-sliders-n-comparison', [
            $this,
            'whmp_load_plugin_page',
        ], WPCT_GRP_URL . "/admin/images/whitelogo-16.png", '81.89856' );

        add_submenu_page( 'wpct-sliders-n-comparison', __( 'Slider & Comparison - ShortCodes', 'whmpress' ), __( 'List Groups', 'whmpress' ), 'manage_options', 'wpct-groups', [
            $this,
            'whmp_load_groups_page',
        ] );

        //        add_submenu_page('wpct-sliders-n-comparison',__('Add New', 'wpct'), __('Add New', 'wpct'), 'manage_options',
        //            'wpct-groups', array($this, 'whmp_load_add_page'), WPCT_GRP_URL . "/admin/images/whitelogo-16.png" ,'81.89856');


        add_submenu_page( 'wpct-sliders-n-comparison', __( 'Slider & Comparison - ToolTips', 'whmpress' ), __( 'Tooltips', 'whmpress' ), 'manage_options', 'wpct-tooltips', [
            $this,
            'whmp_load_tooltips_page',
        ] );

        add_submenu_page( 'wpct-sliders-n-comparison', __( 'Slider & Comparison - Settings', 'whmpress' ), __( 'Settings', 'whmpress' ), 'manage_options', 'wpct-settings', [
            $this,
            'whmp_load_settings_page',
        ] );

    }

    function whmp_load_plugin_page() {
        require_once( WPCT_GRP_PATH . "/admin/admin-pages/slider-comparison.php" );
    }

    function whmp_load_groups_page() {
        require_once( WPCT_GRP_PATH . "/admin/admin-pages/groups.php" );
    }

    function whmp_load_add_page() {
        require_once( WPCT_GRP_PATH . "/admin/admin-pages/groups/group-add.php" );
    }

    function whmp_load_settings_page() {
        require_once( WPCT_GRP_PATH . "/admin/admin-pages/settings.php" );
    }

    function whmp_load_tooltips_page() {
        require_once( WPCT_GRP_PATH . "/admin/admin-pages/tooltips.php" );
    }

    // Function to and create/update database tables
    function activation_check() {
        if ( ! $this->is_whmpress_activated() ) {
            ## Deactivate plugin if WHMPress is not activated.
            /*deactivate_plugins( plugin_basename( WPCT_GRP_FILE ) );*/
            if ( isset( $_GET['activate'] ) ) {
                unset( $_GET['activate'] );
            }
            echo '<div class="error"><p><b>Error:</b> ' . esc_html__( 'Please install and active WHMPress plugin for using', 'whmp_grp' ) . '<b>WHMpress Addon - Slider and Comparision Tables</b></p></div>';
            die;
        } else if ( version_compare( WHMP_VERSION, '2.5.15', '<' ) ) {
            ## Deactivate plugin is WHMPress version is less then 2.5.15
            /*deactivate_plugins( plugin_basename( WPCT_GRP_FILE ) );*/
            if ( isset( $_GET['activate'] ) ) {
                unset( $_GET['activate'] );
            }
            echo '<div class="error"><p><b>Error:</b> ' . esc_html__( 'WHMPress is older version. Please install at least WHMpress 2.5.15', 'whmp_grp' ) . '</p></div>';
            die;
        } else {
            ## Install DB table on activation
            global $wpdb;
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            $charset_collate = $wpdb->get_charset_collate();

            $table_name = $this->get_table_name();
            // removed from below. rows int(11) NOT NULL DEFAULT 6,

            $Q          = "CREATE TABLE {$table_name} (
              id int(11) NOT NULL AUTO_INCREMENT,
              name varchar(255) NOT NULL,
              description text(500),
              important int(11) NOT NULL,
              currency int(11) NOT NULL,
              color varchar(10) NOT NULL,
              ribbon_text varchar(50) NOT NULL DEFAULT 'Most Important',
              billingcycle varchar(50) NOT NULL DEFAULT 'monthly',
              billingcycle2 varchar(50) NOT NULL DEFAULT 'none',
              html_class varchar(50) NOT NULL,
              html_id varchar(50) NOT NULL,
              decimals int(11) NOT NULL DEFAULT '2',
              decimals_tag varchar(50) NOT NULL,
              hide_decimal varchar(5) NOT NULL DEFAULT 'no',
              prefix varchar(10) NOT NULL,
              suffix varchar(10) NOT NULL,
              show_duration varchar(3) NOT NULL,
              show_duration_as varchar(10) NOT NULL DEFAULT 'long',
              duration_style varchar(10) NOT NULL DEFAULT 'duration',
              duration_connector varchar(10) NOT NULL DEFAULT '/',
              convert_monthly varchar(3) NOT NULL,
              alternate_rows BOOLEAN NOT NULL DEFAULT FALSE,
              button_text varchar(50) NOT NULL,
              template_file varchar(100) NOT NULL DEFAULT 'default.tpl',
              slider_template_file varchar(100) NOT NULL DEFAULT 'default.tpl',
              description_separator varchar(10) NOT NULL DEFAULT ':',
              pricing_table_template_file varchar(100) NOT NULL DEFAULT 'default.tpl',
              rows_comparison int(11) NOT NULL DEFAULT 50,
              rows_slider int(11) NOT NULL DEFAULT 4,
              rows_table int(11) NOT NULL DEFAULT 7,
              hide_width_comparison int(11) NOT NULL DEFAULT 0,
              hide_width_slider int(11) NOT NULL DEFAULT 0,
              hide_width_table int(11) NOT NULL DEFAULT 0,
              convert_to_symbol BOOLEAN NOT NULL DEFAULT TRUE,
              convert_yes_with varchar(50) NOT NULL DEFAULT 'fa-check',
              convert_no_with varchar(50) NOT NULL DEFAULT 'fa-close',
              swipe_scroll  BOOLEAN NOT NULL DEFAULT TRUE,
              enable_tooltips  BOOLEAN NOT NULL DEFAULT TRUE,
              enable_table_dots  BOOLEAN NOT NULL DEFAULT FALSE,
              enable_table_carousel  BOOLEAN NOT NULL DEFAULT TRUE,
              show_discount varchar(15) NOT NULL DEFAULT 'no',
              show_discount_secondary varchar(15) NOT NULL DEFAULT 'no',
              show_discount_banner varchar(3) NOT NULL DEFAULT 'no',
              UNIQUE KEY id (id)
            ) " . $charset_collate;

            $response=dbDelta( $Q );

            $table_name = $this->get_table_name( "group_detail" );
            $Q          = "CREATE TABLE {$table_name} (
              group_id int(11) NOT NULL,
              product_id int(11) NOT NULL,
              comp_append text(500),
              order_by int(11) NOT NULL,
              font_awesome varchar(100) NOT NULL DEFAULT ''
            ) " . $charset_collate;
            $response   = dbDelta( $Q );

            $table_name = $this->get_table_name( "group_tooltips" );

            $Q        = "CREATE TABLE {$table_name} (
              tooltip_id int(11) NOT NULL AUTO_INCREMENT,
              match_string varchar(50) NOT NULL,
              tooltip_text text NOT NULL,
              UNIQUE KEY id (tooltip_id)
            ) " . $charset_collate;
            $response = dbDelta( $Q );

        }
    }

    // Function to return database table name
    function get_table_name( $table = "group" ) {
        $table = strtolower( $table );
        global $wpdb;
        switch ( $table ) {
            case "group":
                return $wpdb->prefix . "whmpress_groups";
            case "group_detail":
            case "group_details":
                return $wpdb->prefix . "whmpress_groups_details";
            case "group_tooltips":
                return $wpdb->prefix . "whmpress_groups_tooltips";
            default:
                return $wpdb->prefix . "whmpress_groups";
        }
    }

    /**~~
     * @param $id = Group Id
     *
     * @return array = Array of plans in group with name, description
     */
    function whmp_get_group_full( $id ) {
        $WHMPress = new WHMPress;
        if ( ! $WHMPress->WHMpress_synced() ) {
            return __( "WHMPRess is not synced and no data available.", "whmp_grp" );
        }
        global $wpdb;
        $result = [];
        $Q      = "SELECT * FROM `" . $this->get_table_name( "group" ) . "` WHERE `id`='" . $id . "' ORDER BY `name`";
        $result = $wpdb->get_row( $Q, ARRAY_A );
        if ( count( $result ) == "0" ) {
            return __( "No data available for id ($id)", "whmp_grp" );
        }

        if ( $result["billingcycle"] == "" ) {
            $result["billingcycle"] = "monthly";
        }

        if ( $result["billingcycle2"] == "" ) {
            $result["billingcycle2"] = "annually";
        }

        $Q    = "SELECT * FROM `" . $this->get_table_name( 'group_detail' ) . "` WHERE `group_id`='" . $id . "' ORDER BY `order_by`";
        $rows = $wpdb->get_results( $Q, ARRAY_A );

        foreach ( $rows as &$row ) {
            /*$Q = "SELECT `name`,`description` FROM `".whmp_get_products_table_name()."` WHERE `id`=".$row["product_id"];
            $R = $wpdb->get_row($Q,ARRAY_A);*/
            $R['cdescription'] = whmpress_cdescription_function( [ "id" => $row["product_id"], "no_wrapper" => "1" ] );
            $R['description']  = whmpress_description_function( [
                "id"           => $row["product_id"],
                "with_section" => "Yes",
                "show_as" => "",
            ] );
            $R['description'] = trim( strip_tags( $R['description'] ), "\n" );
            $R['name']         = whmpress_name_function( [
                "id"         => $row["product_id"],
                "no_wrapper" => "1",
            ] );
            $row               = array_merge( $row, $R );
        }
        $result["plans"] = $rows;

        return $result;
    }

    function whmp_is_product_in_group( $product_id, $group_id ) {
        $Q = "SELECT COUNT(*) FROM `" . $this->get_table_name( "group_detail" ) . "` WHERE `product_id`='$product_id' AND `group_id`='$group_id'";
        global $wpdb;

        return $wpdb->get_var( $Q ) > 0;
    }

    function whmp_append_to_comparison( $product_id, $group_id ) {
        $Q = "SELECT `comp_append` FROM `" . $this->get_table_name( "group_detail" ) . "` WHERE `product_id`='$product_id' AND `group_id`='$group_id'";
        global $wpdb;
        $comp_append = $wpdb->get_var( $Q );
        if ( is_null( $comp_append ) || empty( $comp_append ) ) {
            return "";
        }

        return $comp_append;

    }

    function whmp_order_by_in_group( $product_id, $group_id ) {
        $Q = "SELECT `order_by` FROM `" . $this->get_table_name( "group_detail" ) . "` WHERE `product_id`='$product_id' AND `group_id`='$group_id'";
        global $wpdb;
        $order = $wpdb->get_var( $Q );
        if ( is_null( $order ) || empty( $order ) ) {
            return "0";
        }

        return $order;
    }

    function whmp_font_awesome_in_group( $product_id, $group_id ) {
        $Q = "SELECT `font_awesome` FROM `" . $this->get_table_name( "group_detail" ) . "` WHERE `product_id`='$product_id' AND `group_id`='$group_id'";
        global $wpdb;
        $order = $wpdb->get_var( $Q );
        if ( is_null( $order ) || empty( $order ) ) {
            return "";
        }

        return $order;
    }

    function whmp_delete_group( $group_id ) {
        global $wpdb;
        $Q = "DELETE FROM `" . $this->get_table_name() . "` WHERE `id`='$group_id'";
        $wpdb->query( $Q );
        $Q = "DELETE FROM `" . $this->get_table_name( "group_detail" ) . "` WHERE `group_id`='$group_id'";
        $wpdb->query( $Q );
    }

    function whmp_delete_tooltip( $tooltip_id ) {
        global $wpdb;
        $Q = "DELETE FROM `" . whmp_get_group_tooltips_table_name() . "` WHERE `tooltip_id`='$tooltip_id'";
        $wpdb->query( $Q );
    }


    public function whmp_get_template_directory() {
        return str_replace( "\\", "/", get_stylesheet_directory() );
    }

    public function get_template_file( $html_template, $shortcode_name ) {
        if ( is_file( $html_template ) ) {

            return $html_template;
        }

        $html_template = basename( $html_template );


        if ( get_option( "wpct_load_style_orders" ) == "wpct" ) {
            $Path = WPCT_GRP_PATH . "/themes/" . basename( $this->whmp_get_template_directory() ) . "/" . $shortcode_name . "/" . $html_template;
        } elseif ( get_option( "wpct_load_style_orders" ) == "author" ) {
            $Path = $this->whmp_get_template_directory() . "/wpct/" . $shortcode_name . "/" . $html_template;
        } else {
            $Path = WPCT_GRP_PATH . "/templates/" . $shortcode_name . "/" . $html_template;
        }

        if ( is_file( $Path ) ) {
            return $Path;
        }

        return $Path;
    }

    public function get_all_template_files( $shortcode_name ) {
        $Files = [];
        $Path  = WPCT_GRP_PATH . "/themes/" . basename( $this->whmp_get_template_directory() ) . '/' . $shortcode_name;
        if ( is_dir( $Path ) ) {
            $files = scandir( $Path );
            foreach ( $files as $file ) {
                $ext = $this->get_file_extension( $file );
                if ( $ext == "html" || $ext == "tpl" ) {
                    $Files[] = [
                        "file_path"   => $Path . '/' . $file,
                        "description" => "By WHMPress Theme - " . basename( $file ),
                    ];
                }
            }
        }

        $Path = $this->whmp_get_template_directory() . "/wpct/" . $shortcode_name;
        if ( is_dir( $Path ) ) {
            $files = scandir( $Path );
            foreach ( $files as $file ) {
                $ext = $this->get_file_extension( $file );
                if ( $ext == "html" || $ext == "tpl" ) {
                    $Files[] = [
                        "file_path"   => $Path . '/' . $file,
                        "description" => "By Theme Author - " . basename( $file ),
                    ];
                }
            }
        }

        $Path = WPCT_GRP_PATH . "/templates/" . $shortcode_name;
        if ( is_dir( $Path ) ) {
            $files = scandir( $Path );
            foreach ( $files as $file ) {
                $ext = $this->get_file_extension( $file );
                if ( $ext == "html" || $ext == "tpl" ) {
                    $Files[] = [
                        "file_path"   => $Path . '/' . $file,
                        "description" => "By WHMPress Templates - " . basename( $file ),
                    ];
                }
            }
        }

        return $Files;
    }

    /**
     * @param $filename
     *
     * @return string
     *
     * This function returns file extension
     */
    function get_file_extension( $filename ) {
        $f = pathinfo( $filename );
        if ( isset( $f["extension"] ) ) {
            return strtolower( trim( $f["extension"] ) );
        } else {
            return "";
        }
    }

    /**
     * @param $shortcode_name
     *
     * @return array
     *
     * Return template files according to settings.
     */
    public function get_template_files( $shortcode_name ) {
        if ( get_option( "wpct_load_style_orders" ) == "wpct" ) {
            $Path = WPCT_GRP_PATH . "/themes/" . basename( $this->whmp_get_template_directory() ) . '/' . $shortcode_name . '/';
        } elseif ( get_option( "wpct_load_style_orders" ) == "author" ) {
            $Path = $this->whmp_get_template_directory() . "/wpct/" . $shortcode_name . '/';
        } else {
            $Path = WPCT_GRP_PATH . "/templates/" . $shortcode_name . '/';
        }

        if ( ! is_dir( $Path ) ) {
            return [];
        }
        $files = scandir( $Path );

        $return_files = [];
        foreach ( $files as $file ) {
            $file = basename( $file );
            if ( substr( $file, - 5 ) == ".html" || substr( $file, - 4 ) == ".tpl" ) {
                $return_files[] = $file;
            }
        }

        return $return_files;
    }

    public function get_info_file_content( $shortcode_name, $file ) {
        if ( get_option( "wpct_load_style_orders" ) == "wpct" ) {
            $Path = WPCT_GRP_PATH . "/themes/" . basename( $this->whmp_get_template_directory() ) . '/' . $shortcode_name . '/';
        } elseif ( get_option( "wpct_load_style_orders" ) == "author" ) {
            $Path = $this->whmp_get_template_directory() . "/wpct/" . $shortcode_name . '/';
        } else {
            $Path = WPCT_GRP_PATH . "/templates/" . $shortcode_name . '/';
        }

        if ( ! is_dir( $Path ) ) {
            return "";
        }
        $filePath = $Path .= $file;

        if ( ! is_file( $filePath ) ) {
            return "";
        }

        $content = file_get_contents( $filePath );

        return $content;
    }

    public function get_info_files( $shortcode_name ) {
        if ( get_option( "wpct_load_style_orders" ) == "wpct" ) {
            $Path = WPCT_GRP_PATH . "/themes/" . basename( $this->whmp_get_template_directory() ) . '/' . $shortcode_name . '/';
        } elseif ( get_option( "wpct_load_style_orders" ) == "author" ) {
            $Path = $this->whmp_get_template_directory() . "/wpct/" . $shortcode_name . '/';
        } else {
            $Path = WPCT_GRP_PATH . "/templates/" . $shortcode_name . '/';
        }

        if ( ! is_dir( $Path ) ) {
            return [];
        }
        $files = scandir( $Path );

        $return_files = [];
        foreach ( $files as $file ) {
            $file = basename( $file );
            if ( substr( $file, - 5 ) == ".info" ) {
                $return_files[] = $file;
            }
        }

        return $return_files;
    }

    /**
     * @return mixed
     *
     * This method will return current language.
     */
    public function get_current_language() {
        if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
            return ICL_LANGUAGE_CODE;
        } elseif ( function_exists( 'pll_current_language' ) ) {
            return pll_current_language();
        } elseif ( isset( $_GET["lang"] ) ) {
            return $_GET["lang"];
        } else {
            return get_locale();
        }
    }
}