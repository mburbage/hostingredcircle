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
class Domain_Price_List extends Widget_Base
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
        return 'domain-price-list';
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
        return __('Whmpress Domain Price List', 'whmpress');
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

        $Files = $WHMPress->get_template_files("whmpress_price_domain_list");

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
            $AllTemplateFiles = $WHMPress->get_all_template_files("whmpress_price_domain_list");
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
            'currency',
            [
                'label' => __('Select Currency', 'whmpress'),
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
                    '' => __('Default','whmpress'),
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
                    '' => __('Default','whmpress'),
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
            'action_url',
            [
                'label' => __('Action URL', 'whmpress'),
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
        $html_template = $settings['html_template'];
        $currency = $settings['currency'];
        $show_renewal_price = $settings['show_renewal_price'];
        $show_transfer_price = $settings['show_transfer_price'];
        $show_tlds = $settings['show_tld'];
        $show_tld_wildcard =$settings['show_tld_wildcard'];
        $action_url = $settings['action_url'];

        echo do_shortcode('[whmpress_price_domain_list html_template="' . $html_template . '" currency="' . $currency . '" show_renewel="' . $show_renewal_price . '"
         show_transfer="' . $show_transfer_price . '" show_tlds="' . $show_tlds . '" 
         show_tlds_wildcard="' . $show_tld_wildcard . '"  action_url="' . $action_url . '" ]');
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
            WHMPress Domain Price List
        </div>
        <?php
    }
}