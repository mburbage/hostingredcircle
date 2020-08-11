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
class Price_Matrix_Domain extends Widget_Base
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
        return 'price-matrix-domain';
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
        return __('Whmpress Price Matrix Domain', 'whmpress');
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

        $Currencies = $WHMPress->get_currencies(true);
        $Currencies = array_flip($Currencies);

        $this->start_controls_section(
            'general',
            [
                'label' => __('General', 'whmpress'),
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
                'show_renewal_price',
                [
                    'label' => __('Show Renewal Price', 'whmpress'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'yes',
                    'options' => [
                        'yes' => __('Yes', 'whmpress'),
                        'no' => __('No', 'whmpress'),
                    ],
                ]
            );

            $this->add_control(
                'show_transfer_price',
                [
                    'label' => __('Show Transfer Price', 'whmpress'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'yes',
                    'options' => [
                        'yes' => __('Yes', 'whmpress'),
                        'no' => __('No', 'whmpress'),
                    ],
                ]
            );

            $this->add_control(
                'html_id',
                [
                    'label' => __('HTML ID', 'whmpress'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __('', 'whmpress'),
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'Display Styles',
            [
                'label' => __('Styles', 'whmpress'),
            ]
        );

            $this->add_control(
                'display_style',
                [
                    'label' => __('Style', 'whmpress'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => '',
                    'options' => [
                        '' => __('Default', 'whmpress'),
                        'style_1' => __('style_1', 'whmpress'),
                        'style_2' => __('style_2', 'whmpress'),
                        'Muliti_year_register' => __('Muliti year register', 'whmpress'),
                        'Muliti_year_renew' => __('Muliti year renew', 'whmpress'),
                        'Muliti_year_transfer' => __('Muliti year transfer', 'whmpress'),
                    ],
                ]
            );

            $this->add_control(
                'show_addon_price',
                [
                    'label' => __('Show Addon Price', 'whmpress'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'no',
                    'options' => [
                        '' => __('Default','whmpress'),
                        'yes' => __('Yes', 'whmpress'),
                        'no' => __('No', 'whmpress'),
                    ],
                ]
            );

            $this->add_control(
                'show_catagory_type',
                [
                    'label' => __('Show category/type', 'whmpress'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'no',
                    'options' => [
                        '' => __('Default','whmpress'),
                        'yes' => __('Yes', 'whmpress'),
                        'no' => __('No', 'whmpress'),
                    ],
                ]
            );

            $this->add_control(
                'show_restore_price',
                [
                    'label' => __('Show Restore Price', 'whmpress'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'no',
                    'options' => [
                        '' => __('Default','whmpress'),
                        'yes' => __('Yes', 'whmpress'),
                        'no' => __('No', 'whmpress'),
                    ],
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
                'show_search_box',
                [
                    'label' => __('Show Search Box', 'whmpress'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => __('yes', 'whmpress'),
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

            $this->add_control(
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
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'advance',
            [
                'label' => __('Advance', 'whmpress'),
            ]
        );

        $this->add_control(
            'show_tld',
            [
                'label' => __('Show Tlds', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
            ]
        );

        $this->add_control(
            'show_tld_wildcard',
            [
                'label' => __('Show TLDs Wildcard', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
            ]
        );

        $this->add_control(
            'show_disable_domains',
            [
                'label' => __('Show Disabled Domains', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => __('yes', 'whmpress'),
                'options' => [
                    'no' => __('No', 'whmpress'),
                    'yes' => __('YES', 'whmpress'),
                ],
            ]
        );

        $this->add_control(
            'decimals',
            [
                'label' => __('Decimals', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '0',
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
            'no_of_rows',
            [
                'label' => __('No of rows', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => __('Default', 'whmpress'),
                    '10' => __('1', 'whmpress'),
                    '25' => __('22', 'whmpress'),
                    '50' => __('50', 'whmpress'),
                    '100' => __('100', 'whmpress'),
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
            'column_title',
            [
                'label' => __('Change column headers with', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
            ]
        );

        $this->add_control(
            'pricing_slab',
            [
                'label' => __('Enter pricing slab Number', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '0',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'html',
            [
                'label' => __('HTML', 'whmpress'),
            ]
        );

            $this->add_control(
                'table_id',
                [
                    'label' => __('Table ID', 'whmpress'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __('', 'whmpress'),
                ]
            );

            $this->add_control(
                'html_class',
                [
                    'label' => __('HTML Class', 'whmpress'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => __('whmpress whmpress_price_matrix_domain', 'whmpress'),
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
        $show_renewal_price = $settings['show_renewal_price'];
        $show_transfer_price = $settings['show_transfer_price'];
        $html_id = $settings['html_id'];
        $style = $settings['display_style'];
        $currency = $settings['currency'];
        $show_addon_price = $settings['show_addon_price'];
        $show_catagory_type = $settings['show_catagory_type'];
        $decimals = $settings['decimals'];
        $show_restore_price = $settings['show_restore_price'];
        $show_search_box = $settings['show_search_box'];
        $replace_empty_with = $settings['replace_empty_with'];
        $show_tlds = $settings['show_tld'];
        $show_tld_wildcard =$settings['show_tld_wildcard'];
        $show_disable_domains =$settings['show_disable_domains'];
        $no_of_rows = $settings["no_of_rows"];
        $title = $settings['column_title'];
        $pricing_slab = $settings['pricing_slab'];
        $table_id = $settings['table_id'];

        $html_class = $settings['html_class'];
        $search_label = $settings['search_label'];
        $search_placeholder = $settings['search_placeholder'];
        $apply_data_tables = $settings['apply_data_tables'];

        ob_start();
        echo '<div class="oembed-elementor-widget">';
        echo do_shortcode('
        [whmpress_price_matrix_domain show_renewel="' . $show_renewal_price . '" 
        show_transfer="' . $show_transfer_price . '"
         currency="' . $currency . '" 
         style1="' . $style . '" 
         show_addons="' . $show_addon_price . '"  
         decimals="' . $decimals . '" 
         hide_search="' . $show_search_box . '"
         show_disabled="' . $show_disable_domains . '" 
         replace_empty="' . $replace_empty_with . '"
         titles="' . $title . '" 
         show_restore="' . $show_restore_price . '"  
         search_label="' . $search_label . '"  
         search_placeholder="' . $search_placeholder . '" 
         data_table="' . $apply_data_tables . '" 
         show_tlds="' . $show_tlds . '" 
         show_tlds_wildcard="' . $show_tld_wildcard . '" 
         num_of_rows="' . $no_of_rows . '" 
         pricing_slab="' . $pricing_slab . '" 
         table_id="' . $table_id . '" 
         html_class="' . $html_class . '" 
         html_id="' . $html_id . '" 
         show_type="' . $show_catagory_type . '" ]
         ');
        echo '</div>';
        ob_end_flush();

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
            WHMPress Price Matrix Domain
        </div>
        <?php
    }
}