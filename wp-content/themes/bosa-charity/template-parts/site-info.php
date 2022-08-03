<?php
/**
 * Template part for displaying site info
 *
 * @package Bosa Charity
 */

?>

<div class="site-info">
	<?php echo wp_kses_post( html_entity_decode( esc_html__( 'Copyright &copy; ' , 'bosa-charity' ) ) );
		echo esc_html( date( 'Y' ) );
		printf( esc_html__( ' Bosa Charity. Powered by', 'bosa-charity' ) );
	?>
	<a href="<?php echo esc_url( __( '//bosathemes.com', 'bosa-charity' ) ); ?>" target="_blank">
		<?php
			printf( esc_html__( 'Bosa Themes', 'bosa-charity' ) );
		?>
	</a>
</div><!-- .site-info -->