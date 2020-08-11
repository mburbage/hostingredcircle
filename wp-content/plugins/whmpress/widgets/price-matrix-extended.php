<?php
/**
 * Created by PhpStorm.
 * User: zain
 * Date: 6/13/2019
 * Time: 8:17 PM
 */

namespace ElementorWhmpress\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class Price_Matrix_Exended extends Widget_Base
{
    /**
     * Retrieve the widget name.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'price-matrix-extended';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('Whmpress Price Matrix Extended', 'whmpress');
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-posts-ticker';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ['WHMpress'];
    }

    /**
     * Retrieve the list of scripts the widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends()
    {
        return ['whmpress'];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _register_controls()
    {
        $WHMPress = new \WHMPress();
        $Files = $WHMPress->get_template_files("whmpress_price_matrix_extended");

        $FilesList = $ImagesList = [];
        $FilesList["Default"] = "";
        $ImagesList["Default"] = "";

        if (get_option("load_sytle_orders") == "author" || get_option("load_sytle_orders") == "whmpress") {
            if (isset($Files["html"]) && is_array($Files["html"])) {
                foreach ($Files["html"] as $name => $filename) {
                    $FilesList["Template: " . $name] = $filename;
                }
            }
        } else {
            $AllTemplateFiles = $WHMPress->get_all_template_files("whmpress_price_matrix_extended");
            foreach ($AllTemplateFiles as $FILE) {
                $FilesList[$FILE['description']] = $FILE['file_path'];
            }
        }

        $Currencies = $WHMPress->get_currencies(true);
        $Currencies = array_flip($Currencies);

        $this->start_controls_section(
            'general',
            [
                'label' => __('General', 'whmpress'),
            ]
        );

        $this->add_control(
            'html_template',
            [
                'label' => __('Select Template File', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => array_flip($FilesList),
            ]
        );

        $this->add_control(
            'name_of_services',
            [
                'label' => __('Names of services to include in price matrix', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
            ]
        );

        $this->add_control(
            'group_name_ids',
            [
                'label' => __('Enter group names/ids (comma separated)', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
            ]
        );

        $this->add_control(
            'show_price',
            [
                'label' => __('Show Price', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => __('yes', 'whmpress'),
                'options' => [
                    '' => __('Default', 'whmpress'),
                    'yes' => __('Yes', 'whmpress'),
                    'no' => __('No', 'whmpress'),
                ],
            ]
        );

        $this->add_control(
            'billing_cycle',
            [
                'label' => __('Billing Cycles', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
                'condition' => [
                    'show_price' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'description_columns',
            [
                'label' => __('Enter number of description column(s)', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
            ]
        );

        $this->add_control(
            'currency',
            [
                'label' => __('Select currency', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => $Currencies,
            ]
        );

        $this->add_control(
            'show_order_button',
            [
                'label' => __('Show order button', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    'yes' => __('Yes', 'whmpress'),
                    'no' => __('No', 'whmpress'),
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'advance',
            [
                'label' => __('Advance', 'whmpress'),
            ]
        );

        $this->add_control(
            'hide_columns',
            [
                'label' => __('Hide Columns', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
            ]
        );


        $this->add_control(
            'decimals',
            [
                'label' => __('Decimals', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => __('Default', 'whmpress'),
                    '1' => __('1', 'whmpress'),
                    '2' => __('2', 'whmpress'),
                    '3' => __('3', 'whmpress'),
                    '4' => __('4', 'whmpress'),
                ],
            ]
        );

        $this->add_control(
            'show_hidden_services',
            [
                'label' => __('Show Hidden Services', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'no',
                'options' => [
                    '' => __('Default', 'whmpress'),
                    'yes' => __('Yes', 'whmpress'),
                    'no' => __('No', 'whmpress'),
                ],
            ]
        );


        $this->add_control(
            'replace_empty_with',
            [
                'label' => __('Replace Empty With', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('-', 'whmpress'),
            ]
        );

        $this->add_control(
            'replace_zero_with',
            [
                'label' => __('Replace Zero With', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('x', 'whmpress'),
            ]
        );

        $this->add_control(
            'product_type',
            [
                'label' => __('Type', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    'product' => __('Products', 'whmpress'),
                ],
            ]
        );

        /*$this->add_control(
            'titles',
            [
                'label' => __('Change column headers with', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
            ]
        );*/

        $this->add_control(
            'append_url',
            [
                'label' => __('Append to Order URL', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'search',
            [
                'label' => __('Search', 'whmpress'),
            ]
        );

        $this->add_control(
            'hide_search',
            [
                'label' => __('Hide Search', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => __('no', 'whmpress'),
                'options' => [
                    'no' => __('No', 'whmpress'),
                    'yes' => __('YES', 'whmpress'),
                ],
            ]
        );

        $this->add_control(
            'search_label',
            [
                'label' => __('Search Label', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('search:', 'whmpress'),
            ]
        );

        $this->add_control(
            'search_placeholder',
            [
                'label' => __('Search Placeholder', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('search', 'whmpress'),
            ]
        );

        /*$this->add_control(
            'apply_data_tables',
            [
                'label' => __('Apply Data Tabels', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => __('no', 'whmpress'),
                'options' => [
                    'no' => __('No', 'whmpress'),
                    'yes' => __('YES', 'whmpress'),
                ],
            ]
        );*/

        $this->end_controls_section();

        $this->start_controls_section(
            'detail_Page_Options',
            [
                'label' => __('Detail Page Options', 'whmpress'),
            ]
        );

        $this->add_control(
            'detail_page_billing_cycle',
            [
                'label' => __('Detail-page Billing Cycles', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->end_controls_section();

    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $html_template = $settings['html_template'];
        $name_of_services = $settings['name_of_services'];
        $group_name_ids = $settings['group_name_ids'];
        $show_price = $settings['show_price'];
        $description_columns = $settings['description_columns'];
        $billing_cycle = $settings['billing_cycle'];
        $currency = $settings['currency'];
        $show_order_button = $settings['show_order_button'];
        $hide_columns = $settings['hide_columns'];
        $decimals = $settings['decimals'];
        $show_hidden_services = $settings['show_hidden_services'];
        $replace_zero_with = $settings['replace_zero_with'];
        $replace_empty_with = $settings['replace_empty_with'];
        $type = $settings['product_type'];
        /*$title = $settings['titles'];*/
        $append_url = $settings['append_url'];
        $hide_search = $settings['hide_search'];
        $search_label = $settings['search_label'];
        $search_placeholder = $settings['search_placeholder'];
        /*$apply_data_tables = $settings['apply_data_tables'];*/
        $detail_page_billing_cycle = $settings['detail_page_billing_cycle'];


        echo '<div class="oembed-elementor-widget">';

        echo do_shortcode('
        [whmpress_price_matrix_extended html_template="' . $html_template . '" 
         name="' . $name_of_services . '" 
         groups="' . $group_name_ids . '"
         billingcycles="' . $billing_cycle . '" 
         currency="' . $currency . '" 
         order_link="' . $show_order_button . '" 
         hide_columns="' . $hide_columns . '"  
         decimals="' . $decimals . '" 
         show_hidden="' . $show_hidden_services . '"
         replace_zero="' . $replace_zero_with . '" 
         replace_empty="' . $replace_empty_with . '" 
         type="' . $type . '"
         append_order_url="' . $append_url . '" 
         hide_search="' . $hide_search . '"  
         search_label="' . $search_label . '"  
         search_placeholder="' . $search_placeholder . '" 
         show_price="' . $show_price . '"
         description_columns="' . $description_columns . '"
         detail_page_billing_cycle="'. $detail_page_billing_cycle .'"
         ]');
        echo '</div>';
    }

    /**
     * Render the widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _content_template()
    {
        ?>
        <div class="title">
            WHMPress Price Matrix Extended
        </div>
        <?php
    }
}