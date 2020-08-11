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
class Domain_Search extends Widget_Base
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
        return 'domain-search';
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
        return __('Whmpress Domain Search', 'whmpress');
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
            'show_combo',
            [
                'label' => __('Show Combo', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'no',
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
                'default' => __('Search', 'whmpress'),
                'placeholder' => __('Button Text', 'whmpress'),
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
            'show_tlds',
            [
                'label' => __('TLDs to show (comma separated)', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
                'placeholder' => __('Weather to show available TLDs in combo', 'whmpress'),
            ]
        );

        $this->add_control(
            'show_tlds_wildcard',
            [
                'label' => __('TLDs to show (wildcard)', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
                'placeholder' => __('Provide tld search as wildcard, e.g. 
                 pk for all .pk domains or co for all com and .co domains', 'whmpress'),
            ]
        );

        $this->add_control(
            'token',
            [
                'label' => __('Token code', 'whmpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'whmpress'),
                'placeholder' => __('This code is required if you
                 have enabled Captcha on your WHMCS search, and you
                 want to skip captcha using this form...', 'whmpress'),
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
            'combo_class',
            [
                'label' => __('Combo class', 'whmpress'),
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
                'default' => __('whmpress whmpress_domain_search', 'whmpress'),
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
        $show_combo = $settings['show_combo'];
        $placeholder = $settings['placeholder'];
        $button_text = $settings['button_text'];
        $show_tlds = $settings['show_tlds'];
        $show_tlds_wildcard = $settings['show_tlds_wildcard'];
        $token = $settings['token'];
        $textclass = $settings['textclass'];
        $combo_class = $settings['combo_class'];
        $button_class = $settings['button_class'];
        $html_class = $settings['html_class'];
        echo do_shortcode('[whmpress_domain_search show_combo="' . $show_combo . '" 
        placeholder="' . $placeholder . '" button_text="' . $button_text . '"
        show_tlds="' . $show_tlds . '" show_tlds_wildcard="' . $show_tlds_wildcard . '"
        token="' . $token . '" textclass="' . $textclass . '" combo_class="' . $combo_class . '"
        button_class="' . $button_class . '" html_class="' . $html_class . '" ]');
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
            WHMPress Domain Search
        </div>
        <?php
    }
}