<?php
/**
 * Created by PhpStorm.
 * User: zain
 * Date: 10/24/2019
 * Time: 1:43 PM
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
class Pricing_Table_Horizontal extends Widget_Base
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
        return 'pricing-table-horizontal';
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
        return __('Whmpress Price Box', 'whmpress');
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

        $BillingCycles["Default"] = "";
        $BillingCycles["Monthly/One Time"] = "monthly";
        $BillingCycles["Quarterly"] = "quarterly";
        $BillingCycles["Semi Annually"] = "semiannually";
        $BillingCycles["Annually"] = "annually";
        $BillingCycles["Biennially"] = "biennially";
        $BillingCycles["Triennially"] = "triennially";
        $Currencies = $WHMPress->get_currencies(true);

        $this->start_controls_section(
            'general',
            [
                'label' => __('General', 'whmpress'),
            ]
        );
        $this->add_control(
            'id',
            [
                'label' => __('Select Product/Service Package', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => array_flip($Products),
            ]
        );


        $this->add_control(
            'billingcycle',
            [
                'label' => __('Billing cycle', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'monthly',
                'options' => array_flip($BillingCycles),
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
            'show_combo',
            [
                'label' => __('Show Order Combo', 'whmpress'),
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
            'show_description',
            [
                'label' => __('Show Description', 'whmpress'),
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
            'show_button',
            [
                'label' => __('Show Order Button', 'whmpress'),
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
            'button_text',
            [
                'label' => __('Button Text', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'advance',
            [
                'label' => __('Advance', 'whmpress'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
                'label' => __('Discount Type', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => __('yearly', 'whmpress'),
                'options' => [
                    '' => __('Default', 'whmpress'),
                    'yearly' => __('Yearly', 'whmpress'),
                    'monthly' => __('Monthly', 'whmpress'),
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
        echo '<div class="whmpress_domain_search">';
        $id = $settings['id'];
        $billingcycle = $settings['billingcycle'];
        $currency = $settings['currency'];
        $show_price = $settings['show_price'];
        $show_combo = $settings['show_combo'];
        $show_button = $settings['show_button'];
        $button_text = $settings['button_text'];
        $show_discount = $settings['show_discount'];
        $discount_type = $settings['discount_type'];
        $show_description = $settings['show_description'];

        echo do_shortcode('[whmpress_price_box  id="' . $id . '" show_combo="' . $show_combo . '" 
        button_text="' . $button_text . '" billingcycle="' . $billingcycle . '" currency="' . $currency . '"
        show_price="' . $show_price . '" show_description="' . $show_description . '" discount_type="' . $discount_type . '"
        show_button="' . $show_button . '"  show_discount="' . $show_discount . '" ]');
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
            WHMPress Price Box
        </div>
        <?php
    }
}