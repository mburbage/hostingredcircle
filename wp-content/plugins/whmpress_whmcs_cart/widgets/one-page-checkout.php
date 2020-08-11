<?php
/**
 * Created by PhpStorm.
 * User: zain
 * Date: 6/21/2019
 * Time: 5:42 PM
 */
namespace ElementorWCOP\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

## Widget for WCOP Store shortcode
class One_Page_Checkout extends Widget_Base
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
		return 'one page checkout';
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
		return __('WCOP One Page Checkout', 'whcom');
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
		return ['wcop'];
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
		return ['wcop'];
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

	    $all_wcop_templates = get_singlePageTemplates_list();

		$this->start_controls_section(
			'general',
			[
				'label' => __('General', 'whcom'),
			]
		);



		$this->add_control(
			'style',
			[
				'label' => __('Style', 'whcom'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '01_default',
				'options' => array_flip($all_wcop_templates),
			]
		);

		$this->add_control(
			'hide_navigation',
			[
				'label' => __('Hide Navigation', 'whcom'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'' => __('Default', 'ptsc'),
					'yes' => __('Yes',"ptsc"),
					'no' => __('No', 'ptsc'),
				],
			]
		);

		$this->add_control(
			'hide_domain',
			[
				'label' => __('Hide Domain', 'whcom'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'' => __('Default', 'ptsc'),
					'yes' => __('Yes',"ptsc"),
					'no' => __('No', 'ptsc'),
				],
			]
		);

		$this->add_control(
			'hide_product',
			[
				'label' => __('Hide Product', 'whcom'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'' => __('Default', 'ptsc'),
					'yes' => __('Yes',"ptsc"),
					'no' => __('No', 'ptsc'),
				],
			]
		);

		$this->add_control(
			'hide_additional_services',
			[
				'label' => __('Hide Additional Services', 'whcom'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'' => __('Default', 'ptsc'),
					'yes' => __('Yes',"ptsc"),
					'no' => __('No', 'ptsc'),
				],
			]
		);

		$this->add_control(
			'hide_promo',
			[
				'label' => __('Hide promo', 'whcom'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'' => __('Default', 'ptsc'),
					'yes' => __('Yes',"ptsc"),
					'no' => __('No', 'ptsc'),
				],
			]
		);



		$this->end_controls_section();

		$this->start_controls_section(
			'advance',
			[
				'label' => __('Advance', 'whcom'),
			]
		);

		$this->add_control(
			'group_id',
			[
				'label' => __('Group ID', 'whcom'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('', 'whcom'),
			]
		);

		$this->add_control(
			'product_id',
			[
				'label' => __('Product ID', 'whcom'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('', 'whcom'),
			]
		);

		$this->add_control(
			'domain_products',
			[
				'label' => __('Domains Product', 'whcom'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'' => __('Default', 'ptsc'),
					'yes' => __('Yes',"ptsc"),
					'no' => __('No', 'ptsc'),
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
		echo '<div class="wcop_store">';
		$style = $settings['style'];
		$hide_navigation = $settings['hide_navigation'];
		$hide_domain = $settings['hide_domain'];
		$hide_product = $settings['hide_product'];
		$hide_additional_services = $settings['hide_additional_services'];
		$hide_promo = $settings['hide_promo'];
		$domain_products = $settings['domain_products'];
		$group_id = $settings['group_id'];
		$product_id  = $settings['product_id'];



		echo do_shortcode('[whmpress_cart_single_page style="' . $style . '" hide_navigation="' . $hide_navigation . '"
		hide_domain="' . $hide_domain . '" hide_product="' . $hide_product . '" hide_additional_services="' . $hide_additional_services . '"
		hide_promo="' . $hide_promo . '" group_id="' . $group_id . '" domain_products="' . $domain_products . '" product_id="' . $product_id . '"  ]');
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
			{{{ settings.style }}}
			{{{ settings.hide_navigation }}}
			{{{ settings.hide_domain }}}
			{{{ settings.hide_product }}}
			{{{ settings.hide_additional_services }}}
			{{{ settings.group_id }}}
			{{{ settings.hide_promo }}}
			{{{ settings.product_id }}}
			{{{ settings.domain_products }}}
		</div>
		<?php
	}
}