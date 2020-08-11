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
class Domain_Whois extends Widget_Base
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
        return 'domain-whois';
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
        return __('Whmpress Domain Whois', 'whmpress');
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
            'button_text',
            [
                'label' => __('Button Text', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Get Whois', 'whmpress'),
            ]
        );

        $this->add_control(
            'placeholder',
            [
                'label' => __('Placeholder', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
                'placeholder' => __('Enter domain name to search whois', 'whmpress'),
            ]
        );

        $this->add_control(
            'whois_result_class',
            [
                'label' => __('Whois Result Class', 'whmpress'),
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
                'label' => __('HTML Class', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('whmpress whmpress_domain_whois', 'whmpress'),
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
            'search_result_url',
            [
                'label' => __('Search Result URL', 'whmpress'),
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
        echo '<div class="whmpress_domain_whois">';
        $placeholder = $settings['placeholder'];
        $button_text = $settings['button_text'];
        $html_id = $settings['html_id'];
        $whois_result_class = $settings['whois_result_class'];
        $search_result_url = $settings['search_result_url'];
        $textclass = $settings['textclass'];
        $button_class = $settings['button_class'];
        $html_class = $settings['html_class'];
        echo do_shortcode('[whmpress_domain_whois  placeholder="' . $placeholder . '" button_text="' . $button_text . '"
        html_id="' . $html_id . '" whois_result_class="' . $whois_result_class . '"
        search_result_url="' . $search_result_url . '" textclass="' . $textclass . '" button_class="' . $button_class . '" html_class="' . $html_class . '" ]');
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
            WHMPress Domain Whois
        </div>
        <?php
    }
}