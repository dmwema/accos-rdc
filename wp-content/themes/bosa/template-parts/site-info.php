<?php
/**
 * Template part for displaying site info
 *
 * @package Bosa
 */

?>

<div class="site-info">
	<?php echo wp_kses_post( html_entity_decode( esc_html__( 'Copyright &copy; ' , 'bosa' ) ) );
		echo esc_html( date('Y') );
		printf( esc_html__( ' Bosa. Powered by', 'bosa' ) );
	?>
	<a href="<?php echo esc_url( __( '//bosathemes.com', 'bosa' ) ); ?>" target="_blank">
		<?php
			printf( esc_html__( 'Bosa Themes', 'bosa' ) );
		?>
	</a>
</div><!-- .site-info -->