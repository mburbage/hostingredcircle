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
class Domain_Price extends Widget_Base
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
        return 'domain-price';
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
        return __('Whmpress Domain Price', 'whmpress');
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
            'domain_tld',
            [
                'label' => __('Domain TLD', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('.com', 'whmpress'),
            ]
        );

        $this->add_control(
            'price_type',
            [
                'label' => __('Price Type', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'domainregister',
                'options' => [
                    '' => __('Default', 'whmpress'),
                    'domainregister' => __('Domain Registration', 'whmpress'),
                    'domainrenew' => __('Domain Renew', 'whmpress'),
                    'domaintransfer' => __('Domain Transfer', 'whmpress'),
                ],
            ]
        );

        $this->add_control(
            'years',
            [
                'label' => __('Years', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '' => __('Default', 'whmpress'),
                    '1' => __('1', 'whmpress'),
                    '2' => __('2', 'whmpress'),
                    '3' => __('3', 'whmpress'),
                    '4' => __('4', 'whmpress'),
                    '5' => __('5', 'whmpress'),
                    '6' => __('6', 'whmpress'),
                    '7' => __('7', 'whmpress'),
                    '8' => __('8', 'whmpress'),
                    '9' => __('9', 'whmpress'),
                    '10'=> __('10', 'whmpress'),
                ],
            ]
        );

        $this->add_control(
            'currency_override',
            [
                'label' => __('Currency Override', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => $Currencies,
            ]
        );

        $this->add_control(
            'duration_style',
            [
                'label' => __('Duration Style', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    "" => __("Default", "whmpress"),
                    "long" => __("Long (Year)", "whmpress"),
                    "short" =>__("Short (Yr)", "whmpress") ,
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
            'price_display_options',
            [
                'label' => __('Price Display Options', 'whmpress'),
            ]
        );

        $this->add_control(
            'show_no_of_years',
            [
                'label' => __('Show Number of Years', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    "" =>__("Default", "whmpress"),
                    "No" =>__("Do not show suffix", "whmpress"),
                    "Yes" =>__("Yes", "whmpress"),
                    "b" => __("Bold", "whmpress") ,
                    "i" => __("Italic", "whmpress"),
                    "u" =>__("Underline", "whmpress"),
                    "sup" =>__("Superscript", "whmpress"),
                    "sub" =>__("Subscript", "whmpress"),
                ],
            ]
        );

        $this->add_control(
            'show_currency_prefix',
            [
                'label' => __('Show Currency Prefix', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    "" =>__("Default", "whmpress"),
                    "No" =>__("Do not show suffix", "whmpress"),
                    "Yes" =>__("Yes", "whmpress"),
                    "b" => __("Bold", "whmpress") ,
                    "i" => __("Italic", "whmpress"),
                    "u" =>__("Underline", "whmpress"),
                    "sup" =>__("Superscript", "whmpress"),
                    "sub" =>__("Subscript", "whmpress"),
                ],
            ]
        );

        $this->add_control(
            'show_currency_suffix',
            [
                'label' => __('Show Currency Suffix', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    "" =>__("Default", "whmpress"),
                    "No" =>__("Do not show suffix", "whmpress"),
                    "Yes" =>__("Yes", "whmpress"),
                    "b" => __("Bold", "whmpress") ,
                    "i" => __("Italic", "whmpress"),
                    "u" =>__("Underline", "whmpress"),
                    "sup" =>__("Superscript", "whmpress"),
                    "sub" =>__("Subscript", "whmpress"),
                ],
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
            'hide_decimal_symbol',
            [
                'label' => __('Hide Decimal Symbol', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => __('', 'whmpress'),
                'options' => [
                    '' => __('Default', 'whmpress'),
                    'no' => __('No', 'whmpress'),
                    'yes' => __('YES', 'whmpress'),
                ],
            ]
        );

        $this->add_control(
            'decimal_value_format',
            [
                'label' => __('Decimal Value Format', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => __('', 'whmpress'),
                'options' => [
                    '' => __('Default', 'whmpress'),
                    "i" => __("Italic", "whmpress"),
                    "u" =>__("Underline", "whmpress"),
                    "sup" =>__("Superscript", "whmpress"),
                    "sub" =>__("Subscript", "whmpress"),
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'calculation',
            [
                'label' => __('Calculation', 'whmpress'),
            ]
        );

        $this->add_control(
            'price_tax',
            [
                'label' => __('Price/Tax', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => __('', 'whmpress'),
                'options' => [
                    '' => __('Default', 'whmpress'),
                    "default" => __("WHMCS Default", "whmpress"),
                    "inclusive" =>__("Inclusive Tax", "whmpress"),
                    "exclusive" =>__("Exclusive Tax", "whmpress"),
                    "tax" =>__("Tax Only", "whmpress"),
                ],
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
            'html_class',
            [
                'label' => __('HTML Class', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('whmpress whmpress_domain_price', 'whmpress'),
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
        echo '<div class="whmpress_domain_search">';
        $domain_tld = $settings['domain_tld'];
        $type = $settings['price_type'];
        $years  =$settings['years'];
        $currency_override = $settings['currency_override'];
        $duration_style = $settings['duration_style'];
        $html_id = $settings['html_id'];
        $show_no_of_years  = $settings['show_no_of_years'];
        $show_currency_prefix = $settings['show_currency_prefix'];
        $show_currency_suffix = $settings['show_currency_suffix'];
        $decimals  = $settings['decimals'];
        $hide_decimal_symbol = $settings['hide_decimal_symbol'];
        $decimal_value_format = $settings['decimal_value_format'];
        $price_tax  = $settings['price_tax'];
        $html_class = $settings['html_class'];



        echo do_shortcode('[whmpress_domain_price tld="' . $domain_tld . '" type="' . $type . '" years="' . $years . '"
         show_duration="' . $show_no_of_years . '" currency="' . $currency_override . '" html_id="' . $html_id . '" 
         duration_syle="' . $duration_style . '"  prefix="' . $show_currency_prefix . '" suffix="' . $show_currency_suffix . '"
         decimals="' . $decimals . '" hide_decimal="' . $hide_decimal_symbol . '" decimal_tag="' . $decimal_value_format . '"
         price_tax="' . $price_tax . '" html_class="' . $html_class . '"]');
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
            WHMPress Domain Price : {{{ settings.price_type }}}
        </div>
        <?php
    }
}