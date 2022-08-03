<?php
/**
 * Template part for displaying site branding.
 *
 * @since Bosa Charity 1.0.1
 */

?>

<div class="site-branding">
	<?php
		if( ( is_front_page() || ( !get_theme_mod( 'disable_transparent_header_post', true ) && is_single() ) || ( !get_theme_mod( 'disable_transparent_header_page', true ) && is_page() ) ) && get_theme_mod( 'header_layout', 'header_two' ) == 'header_two' && get_theme_mod( 'header_separate_logo', '' ) ){ ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<img src="<?php echo esc_url( wp_get_attachment_url( get_theme_mod( 'header_separate_logo', '' ) ) ); ?>" id="headerLogo">
			</a>
		<?php
		} else{
			$the_custom_logo_url = bosa_get_custom_logo_url();
			if ( $the_custom_logo_url !== '' || get_theme_mod( 'fixed_header_separate_logo', '' ) ) {
	?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img src="<?php echo esc_url(  $the_custom_logo_url ); ?>" id="headerLogo">
				</a>
	<?php
			}	
		}
		if( !get_theme_mod( 'disable_site_title', false ) ){
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
		}
		$bosa_description = get_bloginfo( 'description', 'display' );
		if( !get_theme_mod( 'disable_site_tagline', false ) ){
			if ( $bosa_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo esc_html($bosa_description); /* WPCS: xss ok. */ ?></p>
			<?php endif;
		}
	?>
</div><!-- .site-branding -->