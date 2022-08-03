<?php
/**
 * Template part for displaying slider section
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since Bosa 1.0.0
 */

if( get_theme_mod( 'main_slider_layout', 'main_slider_one' ) == '' || get_theme_mod( 'main_slider_layout', 'main_slider_one' ) == 'main_slider_one' ){
	get_template_part( 'template-parts/slider/slider', 'one' );
}
