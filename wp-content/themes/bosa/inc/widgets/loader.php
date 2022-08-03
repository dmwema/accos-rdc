<?php
/**
* Load widget components
*
* @since Bosa 1.0.0
*/
require_once get_parent_theme_file_path( '/inc/widgets/class-base-widget.php' );
require_once get_parent_theme_file_path( '/inc/widgets/latest-posts.php' );
require_once get_parent_theme_file_path( '/inc/widgets/author.php' );
/**
 * Register widgets
 *
 * @since Bosa 1.0.0
 */
/**
* Load all the widgets
* @since Bosa 1.0.0
*/
function bosa_register_widget() {

	$widgets = array(
		'Bosa_Latest_Posts_Widget',
		'Bosa_Author_Widget',
	);

	foreach ( $widgets as $key => $value) {
    	register_widget( $value );
	}
}
add_action( 'widgets_init', 'bosa_register_widget' );