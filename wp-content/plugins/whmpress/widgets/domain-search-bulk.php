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
class Domain_Search_Bulk extends Widget_Base
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
        return 'domain-search-bulk';
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
        return __('Whmpress Domain Search Bulk', 'whmpress');
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

        $Files = $WHMPress->get_template_files("whmpress_domain_search_bulk");

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
            $AllTemplateFiles = $WHMPress->get_all_template_files("whmpress_domain_search_bulk");
            foreach ($AllTemplateFiles as $FILE) {
                $FilesList[$FILE['description']] = $FILE['file_path'];
            }
        }

        $YesNo["Default"] = "";
        $YesNo["Yes"] = "yes";
        $YesNo["No"] = "no";

        $this->start_controls_section(
            'general',
            [
                'label' => __('General', 'whmpress'),
            ]
        );

        $this->add_control(
            'html_template',
            [
                'label' => __('Select template file', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => array_flip($FilesList),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Search', 'whmpress'),
                'placeholder' => __('Button Text', 'whmpress'),
            ]
        );

        $this->add_control(
            'placeholder',
            [
                'label' => __('Placeholder', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
                'placeholder' => __('Write your placeholder', 'whmpress'),
            ]
        );

        $this->add_control(
            'show_price',
            [
                'label' => __('Show price', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => array_flip($YesNo),
            ]
        );

        $this->add_control(
            'show_years',
            [
                'label' => __('Show years', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => array_flip($YesNo),
            ]
        );

        $this->add_control(
            'whois_link',
            [
                'label' => __('Show whois link', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => array_flip($YesNo),
            ]
        );

        $this->add_control(
            'www_link',
            [
                'label' => __('Show www link', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => array_flip($YesNo),
            ]
        );

        $this->add_control(
            'enable_transfer_link',
            [
                'label' => __('Show transfer link', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => array_flip($YesNo),
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
            'action',
            [
                'label' => __('Search result URL', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
                'placeholder' => __("", 'whmpress'),
            ]
        );

        $this->add_control(
            'order_link_new_tab',
            [
                'label' => __('Domain link in new tab', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '0',
                'options' => [
                    '' => __('Default', 'whmpress'),
                    '0' => __('Open domain link in same tab', 'whmpress'),
                    '1' => __('Open domain link in new tab', 'whmpress'),
                ],
            ]
        );

        $this->add_control(
            'append_url',
            [
                'label' => __('Append to URL', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
                'placeholder' => __("", 'whmpress'),
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
            'textclass',
            [
                'label' => __('Text Class', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
            ]
        );

        $this->add_control(
            'button_class',
            [
                'label' => __('Button class', 'whmpress'),
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
        $placeholder = $settings['placeholder'];
        $button_text = $settings['button_text'];
        $show_price = $settings['show_price'];
        $show_years = $settings['show_years'];
        $whois_link = $settings['whois_link'];
        $www_link = $settings['www_link'];
        $action = $settings['action'];
        $enable_transfer_link = $settings['enable_transfer_link'];
        $order_link_new_tab = $settings['order_link_new_tab'];
        $append_url = $settings['append_url'];
        $textclass = $settings['textclass'];
        $button_class = $settings['button_class'];
        echo do_shortcode('[whmpress_domain_search_bulk html_template="' . $html_template . '"
        placeholder="' . $placeholder . '" button_text="' . $button_text . '" show_price="' . $show_price . '"
        show_years="' . $show_years . '" whois_link="' . $whois_link . '"
        www_link="' . $www_link . '" enable_transfer_link="' . $enable_transfer_link . '"
        action="' . $action . '" order_link_new_tab="' . $order_link_new_tab . '"
        append_url="' . $append_url . '"
        textclass="' . $textclass . '" button_class="' . $button_class . '" ]');
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
            WHMPress Domain Search Bulk
        </div>
        <?php
    }
}