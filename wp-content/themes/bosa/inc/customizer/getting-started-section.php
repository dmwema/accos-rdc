<?php
/**
 * Custom Customizer Controls.
 *
 * @package Bosa
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * Getting Started customizer section.
 *
 * @since  1.2.7
 * @access public
 */
if ( ! class_exists( 'Bosa_Customize_Getting_Started' ) ) {
	class Bosa_Customize_Getting_Started extends WP_Customize_Section {

		/**
		 * The type of customize section being rendered.
		 *
		 * @since  1.2.7
		 * @access public
		 * @var    string
		 */
		public $type = 'getting_started';

		/**
		 * Custom button text to output.
		 *
		 * @since  1.2.7
		 * @access public
		 * @var    string
		 */
		public $gs_text = '';

		/**
		 * Custom button URL.
		 *
		 * @since  1.2.7
		 * @access public
		 * @var    string
		 */
		public $gs_url = '';

		/**
		 * Add custom parameters to pass to the JS via JSON.
		 *
		 * @since  1.2.7
		 * @access public
		 * @return void
		 */
		public function json() {
			$json = parent::json();

			$json['gs_text'] = $this->gs_text;
			$json['gs_url'] = esc_url( $this->gs_url );
			return $json;
		}

		/**
		 * Outputs the Underscore.js template.
		 *
		 * @since  1.2.7
		 * @access public
		 * @return void
		 */
		protected function render_template() { ?>

			<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
				<h3 class="accordion-section-title">
					{{ data.title }}

					<# if ( data.gs_text && data.gs_url ) { #>
						<a href="{{ data.gs_url }}" class="bosa-install-plugins button button-primary">{{ data.gs_text }}</a>
					<# } #>
				</h3>
			</li>
		<?php }
	}
}