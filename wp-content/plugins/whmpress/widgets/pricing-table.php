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
class Pricing_Table extends Widget_Base
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
        return 'pricing-table';
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
        return __('Whmpress Pricing Table', 'whmpress');
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

        $Files = $WHMPress->get_template_files("whmpress_pricing_table");

        $FilesList = $ImagesList = [];
        $FilesList["Default"] = "";
        $ImagesList["Default"] = "";

        $BillingCycles["Default"] = "";
        $BillingCycles["Monthly/One Time"] = "monthly";
        $BillingCycles["Quarterly"] = "quarterly";
        $BillingCycles["Semi Annually"] = "semiannually";
        $BillingCycles["Annually"] = "annually";
        $BillingCycles["Biennially"] = "biennially";
        $BillingCycles["Triennially"] = "triennially";
        $Currencies = $WHMPress->get_currencies(true);

        if (get_option("load_sytle_orders") == "author" || get_option("load_sytle_orders") == "whmpress") {
            if (isset($Files["html"]) && is_array($Files["html"])) {
                foreach ($Files["html"] as $name => $filename) {
                    $FilesList["Template: " . $name] = $filename;
                }
            }
        } else {
            $AllTemplateFiles = $WHMPress->get_all_template_files("whmpress_pricing_table");
            foreach ($AllTemplateFiles as $FILE) {
                $FilesList[$FILE['description']] = $FILE['file_path'];
            }
        }

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
            'html_template',
            [
                'label' => __('Select Template Files', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => array_flip($FilesList),
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
            'currency',
            [
                'label' => __('Select currency', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => array_flip($Currencies),
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
            'show_price',
            [
                'label' => __('Show Price', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => __('', 'whmpress'),
                'options' => [
                    '' => __('Default', 'whmpress'),
                    'yes' => __('Yes', 'whmpress'),
                    'no' => __('No', 'whmpress'),
                ],
            ]
        );

        $this->add_control(
            'process_description',
            [
                'label' => __('Process Description', 'whmpress'),
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
            'show_description_icon',
            [
                'label' => __('Show Description Icon', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => __('', 'whmpress'),
                'options' => [
                    '' => __('Default', 'whmpress'),
                    'yes' => __('Yes', 'whmpress'),
                    'no' => __('No', 'whmpress'),
                ],
            ]
        );

        $this->add_control(
            'show_description_tooltip',
            [
                'label' => __('Show Description Tooltip', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => __('', 'whmpress'),
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
                'default' => __('', 'whmpress'),
                'options' => [
                    '' => __('Default', 'whmpress'),
                    'no' => __('No', 'whmpress'),
                    'yes' => __('YES', 'whmpress'),
                ],
            ]
        );

        $this->add_control(
            'show_button',
            [
                'label' => __('Show Order Button', 'whmpress'),
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
            'button_text',
            [
                'label' => __('Button Text', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
            ]
        );

        $this->add_control(
            'override_order_url',
            [
                'label' => __('Override Order URL', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
            ]
        );

        $this->add_control(
            'override_order_combo_url',
            [
                'label' => __('Override Order combo URL', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
            ]
        );

        $this->add_control(
            'append_order_url',
            [
                'label' => __('Append Order URL', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
            ]
        );

        $this->add_control(
            'show_discount',
            [
                'label' => __('Show Discount', 'whmpress'),
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
            'convert_monthly',
            [
                'label' => __('Convert to Monthly', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => __('', 'whmpress'),
                'options' => [
                    '' => __('Default', 'whmpress'),
                    'yes' => __('Yes', 'whmpress'),
                    'no' => __('No', 'whmpress'),
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'colors',
            [
                'label' => __('Colors', 'whmpress'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'primary_color',
            [
                'label' => __( 'Primary Color', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'secondary_color',
            [
                'label' => __( 'Secondary Color', 'plugin-domain' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .title' => 'color: {{VALUE}}',
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
            'html_class',
            [
                'label' => __('HTML class', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'html_id',
            [
                'label' => __('HTML ID', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'whmpress',
            [
                'label' => __('whmpress', 'whmpress'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'featured',
            [
                'label' => __('Featured Product', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => __('normal', 'whmpress'),
                'options' => [
                    '' => __('Default', 'whmpress'),
                    'normal' => __('normal', 'whmpress'),
                    'featured' => __('featured', 'whmpress'),
                ],
            ]
        );

        $this->add_control(
            'featured_text',
            [
                'label' => __('Featured Text', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'custom_text_1',
            [
                'label' => __('Custom Text 1', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'custom_text_2',
            [
                'label' => __('Custom Text 2', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'custom_text_3',
            [
                'label' => __('Custom Text 3', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'product_detail',
            [
                'label' => __('Product Detail', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'sub_icon',
            [
                'label' => __('Icon', 'whmpress'),
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
        echo '<div class="whmpress_pricing_table">';
        $id = $settings['product_id'];
        $html_template = $settings['html_template'];
        $billingcycle = $settings['billingcycle'];
        $currency = $settings['currency'];
        $show_price = $settings['show_price'];
        $process_description = $settings['process_description'];
        $show_description_tooltip = $settings['show_description_tooltip'];
        $show_combo = $settings['show_combo'];
        $show_button = $settings['show_button'];
        $button_text = $settings['button_text'];
        $override_order_url = $settings['override_order_url'];
        $override_order_combo_url = $settings['override_order_combo_url'];
        $append_order_url = $settings['append_order_url'];
        $show_discount = $settings['show_discount'];
        $convert_monthly = $settings['convert_monthly'];
        $primary_color = $settings['primary_color'];
        $secondary_color = $settings['secondary_color'];
        $html_class = $settings['html_class'];
        $html_id  = $settings['html_id'];
        $featured  = $settings['featured'];
        $featured_text  = $settings['featured_text'];
        $custom_text_1  = $settings['custom_text_1'];
        $custom_text_2  = $settings['custom_text_2'];
        $custom_text_3  = $settings['custom_text_3'];
        $product_detail  = $settings['product_detail'];
        $sub_icon  = $settings['sub_icon'];

        echo do_shortcode('[whmpress_pricing_table 
        id="' . $id . '" 
        override_order_url="' . $override_order_url . '" 
        show_combo="' . $show_combo . '" 
        html_template="' . $html_template . '" 
        button_text="' . $button_text . '"
        billingcycle="' . $billingcycle . '" 
        currency="' . $currency . '"
        show_price="' . $show_price . '" 
        process_description="' . $process_description . '" 
        show_description_tooltip="' . $show_description_tooltip . '"
        show_button="' . $show_button . '" 
        html_class="' . $html_class . '" 
        html_id="' . $html_id . '" 
        override_order_combo_url="' . $override_order_combo_url . '" 
        append_order_url="' . $append_order_url . '" 
        show_discount="' . $show_discount . '" 
        convert_monthly="' . $convert_monthly . '" 
        primary_color="' . $primary_color . '" 
        secondary_color="' . $secondary_color . '" 
        featured="' . $featured . '" 
        featured_text="' . $featured_text . '" 
        custom_text_1="' . $custom_text_1 . '" 
        custom_text_2="' . $custom_text_2 . '" 
        custom_text_3="' . $custom_text_3 . '" 
        product_detail="' . $product_detail . '" 
        sub_icon="' . $sub_icon . '" 
        
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
            WHMPress Pricing Table
        </div>
        <?php
    }
}