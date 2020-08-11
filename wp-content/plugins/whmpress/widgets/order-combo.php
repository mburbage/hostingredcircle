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
class Order_Combo extends Widget_Base
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
        return 'order-combo';
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
        return __('Whmpress Order Combo', 'whmpress');
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
        $WHMPress = new \WHMPress;
        $Products = whmp_get_products(true);
        $Products = array_reverse($Products, true);
        $Products = array_reverse($Products, true);


        $Currencies = $WHMPress->get_currencies(true);



        $this->start_controls_section(
            'general',
            [
                'label' => __('General', 'whmpress'),
            ]
        );
        $this->add_control(
            'product_id',
            [
                'label' => __('Select Product/Service Package', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => array_flip($Products),
            ]
        );

        $this->add_control(
            'show_button',
            [
                'label' => __('Show Button', 'whmpress'),
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
            'billingcycle',
            [
                'label' => __('Billing Cycle', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Order Now', 'whmpress'),
            ]
        );

        $this->add_control(
            'show_discount',
            [
                'label' => __('Show Discount', 'whmpress'),
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
            'discount_type',
            [
                'label' => __('Discount type (in %age or Calculated Monthly Price)', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => __('yes', 'whmpress'),
                'options' => [
                    '' => __('Default', 'whmpress'),
                    'yearly' => __('%age', 'whmpress'),
                    'monthly' => __('Calculated Monthly Price', 'whmpress'),
                ],
            ]
        );

        $this->add_control(
            'additional_parameter',
            [
                'label' => __('Additional parameters for order URL', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
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
            'price_display_option',
            [
                'label' => __('Price Display Option', 'whmpress'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'prefix',
            [
                'label' => __('Show Currency Prefix', 'whmpress'),
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
            'suffix',
            [
                'label' => __('Show Currency Suffix', 'whmpress'),
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
            'currency',
            [
                'label' => __('Select currency', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => array_flip($Currencies),
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


        $this->end_controls_section();

        $this->start_controls_section(
            'html',
            [
                'label' => __('HTML', 'whmpress'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'combo_class',
            [
                'label' => __('Combo Class', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
            ]
        );

        $this->add_control(
            'button_class',
            [
                'label' => __('Button Class', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
            ]
        );

        $this->add_control(
            'html_class',
            [
                'label' => __('HTML Class', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
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
        $id = $settings['product_id'];
        $show_button = $settings['show_button'];
        $button_text = $settings['button_text'];
        $show_discount = $settings['show_discount'];
        $discount_type = $settings['discount_type'];
        $billingcycle = $settings['billingcycle'];
        $additional_parameter = $settings['additional_parameter'];
        $html_id  = $settings['html_id'];
        $prefix = $settings['prefix'];
        $suffix = $settings['suffix'];
        $currency = $settings['currency'];
        $decimals = $settings['decimals'];
        $combo_class = $settings['combo_class'];
        $button_class  = $settings["button_class"];
        $html_class = $settings['html_class'];


        echo do_shortcode('[whmpress_order_combo id="' . $id . '" show_button="' . $show_button . '"  
        button_text="' . $button_text . '" billingcycles="' . $billingcycle . '" currency="' . $currency . '" discount_type="' . $discount_type . '" 
        params = "' . $additional_parameter . '" html_class="' . $html_class . '" 
        show_discount="' . $show_discount . '" prefix="' . $prefix . '" suffix="' . $suffix . '" decimals="' . $decimals . '" combo_class="' . $combo_class . '"
       button_class="' . $button_class . '" ]');
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
            WHMPress Order Combo
        </div>
        <?php
    }
}