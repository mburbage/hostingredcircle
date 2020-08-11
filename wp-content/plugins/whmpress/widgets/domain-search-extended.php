<?php
/**
 * Created by PhpStorm.
 * User: zain
 * Date: 6/21/2019
 * Time: 6:11 PM
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
class Domain_Search_Extended extends Widget_Base
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
        return 'domain-search-extended';
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
        return __('Whmpress Domain Search Ajax Extended', 'whmpress');
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
        $this->start_controls_section(
            'general',
            [
                'label' => __('General', 'whmpress'),
            ]
        );
        $this->add_control(
            'show_price',
            [
                'label' => __('Show Price', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => __('Default', 'whmpress'),
                    'yes' => __('Yes', 'whmpress'),
                    'no' => __('No', 'whmpress'),
                ],
            ]
        );

        $this->add_control(
            'show_years',
            [
                'label' => __('Show years', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => __('Default', 'whmpress'),
                    'yes' => __('Yes', 'whmpress'),
                    'no' => __('No', 'whmpress'),
                ],
            ]
        );

        $this->add_control(
            'show_whois',
            [
                'label' => __('Show Whois Link', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => __('Default', 'whmpress'),
                    'yes' => __('Yes', 'whmpress'),
                    'no' => __('No', 'whmpress'),
                ],
            ]
        );

        $this->add_control(
            'show_www',
            [
                'label' => __('Show www Link', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => __('Default', 'whmpress'),
                    'yes' => __('Yes', 'whmpress'),
                    'no' => __('No', 'whmpress'),
                ],
            ]
        );

        $this->add_control(
            'show_transfer',
            [
                'label' => __('Show Transfer Link', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => __('Default', 'whmpress'),
                    'yes' => __('Yes', 'whmpress'),
                    'no' => __('No', 'whmpress'),
                ],
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
            'button_text',
            [
                'label' => __('Button Text', 'whmpress'),
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
            'advance',
            [
                'label' => __('Advance', 'whmpress'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'disable_domain_spinning',
            [
                'label' => __('Disable Domain Spinning', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => __('Default', 'whmpress'),
                    'no' => __('No', 'whmpress'),
                    'yes' => __('Yes', 'whmpress'),
                ],
            ]
        );

        $this->add_control(
            'filter_tlds',
            [
                'label' => __('Filter TLDs', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
                'placeholder' => __('Enter comma separated domains without dot (.) to show specific tlds in dropdown.', 'whmpress')
            ]
        );

        $this->add_control(
            'search_result_div',
            [
                'label' => __('Search Result Div/URL', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
            ]
        );

        $this->add_control(
            'domain_link_new_tab',
            [
                'label' => __('Domain Link in New Tab', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => __('Default', 'whmpress'),
                    '0' => __('Open domain link in same tab', 'whmpress'),
                    '1' => __('Open domain link in new tab', 'whmpress'),
                ],
            ]
        );

        $this->add_control(
            'search_in_extentions',
            [
                'label' => __('Search in Extentions', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => __('Default', 'whmpress'),
                    '1' => __('Only Listed in WHMCS', 'whmpress'),
                    '0' => __('All', 'whmpress'),
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

        $this->add_control(
            'html_class',
            [
                'label' => __('HTML class', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('whmpress whmpress_domain_search_ajax', 'whmpress'),
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
        echo '<div class="whmpress_domain_search_ajax">';
        $show_price = $settings['show_price'];
        $show_years = $settings['show_years'];
        $show_whois = $settings['show_whois'];
        $show_www = $settings['show_www'];
        $show_transfer = $settings['show_transfer'];
        $placeholder = $settings['placeholder'];
        $button_text = $settings['button_text'];
        $html_id = $settings['html_id'];
        $disable_domain_spinning = $settings['disable_domain_spinning'];
        $search_result_div = $settings['search_result_div'];
        $filter_tlds = $settings['filter_tlds'];
        $domain_link_new_tab = $settings['domain_link_new_tab'];
        $search_in_extentions = $settings['search_in_extentions'];
        $textclass = $settings['textclass'];
        $button_class = $settings['button_class'];
        $html_class = $settings['html_class'];
        echo do_shortcode('[whmpress_domain_search_ajax_extended show_price="' . $show_price . '" 
        show_years="' . $show_years . '" show_whois="' . $show_whois . '" show_www="' . $show_www . '" 
        show_transfer="' . $show_transfer . '" placeholder="' . $placeholder . '" button_text="' . $button_text . '"
        html_id="' . $html_id . '" disable_domain_spinning="' . $disable_domain_spinning . '"
        search_result_div="' . $search_result_div . '" textclass="' . $textclass . '" 
        button_class="' . $button_class . '" filter_tlds="' . $filter_tlds . '" html_class="' . $html_class . '" domain_link_new_tab="' . $domain_link_new_tab . '"
        search_in_extentions="' . $search_in_extentions . '"]');
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
            WHMPress Domain Search Extended
        </div>
        <?php
    }
}