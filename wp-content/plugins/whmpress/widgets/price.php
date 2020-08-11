<?php
/**
 * Created by PhpStorm.
 * User: Fakhir
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
class Price extends Widget_Base
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
        return 'price';
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
        return __('Whmpress Price', 'whmpress');
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

        $Products = whmp_get_products(true);
        $Products = array_reverse($Products, true);
        $Products = array_flip($Products);

        $BillingCycles["Default"] = "annually";
        $BillingCycles["Monthly/One Time"] = "monthly";
        $BillingCycles["Quarterly"] = "quarterly";
        $BillingCycles["Semi Annually"] = "semiannually";
        $BillingCycles["Annually"] = "annually";
        $BillingCycles["Biennially"] = "biennially";
        $BillingCycles["Triennially"] = "triennially";
        $BillingCycles = array_flip($BillingCycles);

        $Currencies = $WHMPress->get_currencies(true);
        $Currencies = array_flip($Currencies);

        $this->start_controls_section(
            'whmpress',
            [
                'label' => __('General', 'whmpress'),
            ]
        );

        $this->add_control(
            'product_id',
            [
                'label' => __('Product/Service Package', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => $Products,
            ]
        );

        $this->add_control(
            'billingcycle',
            [
                'label' => __('Billing cycle', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'monthly',
                'options' => $BillingCycles,
            ]
        );

        $this->add_control(
            'currency',
            [
                'label' => __('Currency', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => $Currencies,
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'price display options',
            [
                'label' => __('Price Display Options', 'whmpress'),
            ]
        );

        $this->add_control(
            'show_duration',
            [
                'label' => __('Show Duration/ Billing Cycles', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    "" =>__("Default", "whmpress"),
                    "No" =>__("Do not show duration", "whmpress"),
                    "-" =>__("==No Tag==", "whmpress"),
                    "b" => __("Bold", "whmpress") ,
                    "i" => __("Italic", "whmpress"),
                    "u" =>__("Underline", "whmpress"),
                    "sup" =>__("Superscript", "whmpress"),
                    "sub" =>__("Subscript", "whmpress"),
                ],
            ]
        );

        $this->add_control(
            'prefix',
            [
                'label' => __('Show Currency Prefix', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    "" =>__("Default", "whmpress"),
                    "No" =>__("Do not show prefix", "whmpress"),
                    "-" =>__("==No Tag==", "whmpress"),
                    "b" => __("Bold", "whmpress") ,
                    "i" => __("Italic", "whmpress"),
                    "u" =>__("Underline", "whmpress"),
                    "sup" =>__("Superscript", "whmpress"),
                    "sub" =>__("Subscript", "whmpress"),
                ],
            ]
        );

        $this->add_control(
            'suffix',
            [
                'label' => __('Show Currency Suffix', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    "" =>__("Default", "whmpress"),
                    "No" =>__("Do not show suffix", "whmpress"),
                    "-" =>__("==No Tag==", "whmpress"),
                    "b" => __("Bold", "whmpress") ,
                    "i" => __("Italic", "whmpress"),
                    "u" =>__("Underline", "whmpress"),
                    "sup" =>__("Superscript", "whmpress"),
                    "sub" =>__("Subscript", "whmpress"),
                ],
            ]
        );

        $this->add_control(
            'hide_decimal',
            [
                'label' => __('Hide Decimal Symbol', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => __('no', 'whmpress'),
                'options' => [
                    '' => __('Default', 'whmpress'),
                    'yes' => __('Yes', 'whmpress'),
                    'no' => __('No', 'whmpress'),
                ],
            ]
        );

        $this->add_control(
            'decimals',
            [
                'label' => __('Decimals', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => __('2', 'whmpress'),
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
            'decimals_tag',
            [
                'label' => __('Decimals value format', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '-',
                'options' => [
                    "" =>__("Default", "whmpress"),
                    "-" =>__("==No Tag==", "whmpress"),
                    "b" => __("Bold", "whmpress") ,
                    "i" => __("Italic", "whmpress"),
                    "u" =>__("Underline", "whmpress"),
                    "sup" =>__("Superscript", "whmpress"),
                    "sub" =>__("Subscript", "whmpress"),
                ],
            ]
        );

        $this->add_control(
            'convert_monthly',
            [
                'label' => __('Convert Price into Monthly Price', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => __('no', 'whmpress'),
                'options' => [
                    '' => __('Default', 'whmpress'),
                    'yes' => __('Yes', 'whmpress'),
                    'no' => __('No', 'whmpress'),
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'calculations',
            [
                'label' => __('Calculations', 'whmpress'),
            ]
        );

        $this->add_control(
            'price_type',
            [
                'label' => __('Setup', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'price',
                'options' => [
                    "" =>__("Default", "whmpress"),
                    "price" =>__("price", "whmpress"),
                    "setup" => __("Setup Fee", "whmpress") ,
                    "total" => __("Price + Setup Fee", "whmpress"),
                ],
            ]
        );

        $this->add_control(
            'configureable_options',
            [
                'label' => __('Calculate configurable options', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => __('no', 'whmpress'),
                'options' => [
                    '' => __('Default', 'whmpress'),
                    'no' => __('No', 'whmpress'),
                    'yes' => __('Yes', 'whmpress'),
                ],
            ]
        );

        $this->add_control(
            'config_option_string',
            [
                'label' => __('String for config price', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
            ]
        );

        $this->add_control(
            'price_tax',
            [
                'label' => __('Tax', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    "" =>__("Default", "whmpress"),
                    "default" =>__("WHMCS Default", "whmpress"),
                    "inclusive" => __("Inclusive Tax", "whmpress") ,
                    "exclusive" => __("Exclusive Tax", "whmpress"),
                    "tax" => __("Tax Only", "whmpress"),
                ],
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

        $product_id = $settings['product_id'];
        $billingcycle = $settings['billingcycle'];
        $currency = $settings['currency'];
        $show_duration = $settings['show_duration'];
        $prefix = $settings['prefix'];
        $suffix = $settings['suffix'];
        $hide_decimal = $settings['hide_decimal'];
        $decimals = $settings['decimals'];
        $decimals_tag = $settings['decimals_tag'];
        $convert_monthly = $settings['convert_monthly'];
        $price_type = $settings['price_type'];
        $configureable_options = $settings['configureable_options'];
        $config_option_string = $settings['config_option_string'];
        $price_tax = $settings['price_tax'];

        ob_start();
        echo '<div class="oembed-elementor-widget">';
            echo do_shortcode('
                [whmpress_price id   =  "' . $product_id . '"
                    billingcycle    =   "' . $billingcycle . '" 
                    currency    =   "' . $currency . '" 
                    show_duration    =   "' . $show_duration . '" 
                    prefix    =   "' . $prefix . '" 
                    suffix    =   "' . $suffix . '" 
                    hide_decimal    =   "' . $hide_decimal . '" 
                    decimals    =   "' . $decimals . '" 
                    decimals_tag    =   "' . $decimals_tag . '" 
                    convert_monthly    =   "' . $convert_monthly . '" 
                    price_type    =   "' . $price_type . '" 
                    configureable_options    =   "' . $configureable_options . '" 
                    config_option_string    =   "' . $config_option_string . '" 
                    price_tax    =   "' . $price_tax . '" 
                ]'
            );
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
            WHMPress Order Price
        </div>
        <?php
    }
}