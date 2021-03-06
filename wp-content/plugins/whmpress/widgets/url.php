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
class URL extends Widget_Base
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
        return 'url';
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
        return __('Whmpress URL', 'whmpress');
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
            'url_type',
            [
                'label' => __('URL Type', 'whmpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'client_area',
                'options' => [
                    'client_area' => __('client_area', 'whmpress'),
                    'announcements' => __('announcements', 'whmpress'),
                    'submit_ticket' => __('submit_ticket', 'whmpress'),
                    'downloads' => __('downloads', 'whmpress'),
                    'support_tickets' => __('support_tickets', 'whmpress'),
                    'knowledgebase' => __('knowledgebase', 'whmpress'),
                    'affiliates' => __('affiliates', 'whmpress'),
                    'order' => __('order', 'whmpress'),
                    'contact_url' => __('contact_url', 'whmpress'),
                    'server_status' => __('server_status', 'whmpress'),
                    'network_issues' => __('network_issues', 'whmpress'),
                    'whmcs_login' => __('whmcs_login', 'whmpress'),
                    'whmcs_register' => __('whmcs_register', 'whmpress'),
                    'whmcs_forget_password' => __('whmcs_forget_password', 'whmpress'),
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

        $type = $settings['url_type'];

        echo do_shortcode('[whmpress_url type="' . $type . '" ]');
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
            WHMPress WHMCS URL
        </div>
        <?php
    }
}