<div class="bottom-footer">
	<div class="container">
		<div class="row align-items-center">
			<!-- social links area -->
			<?php 
			$socialEmptyClass = 'col-lg-12 text-center';
			if( !get_theme_mod( 'disable_footer_social_links', false ) && bosa_has_social() ){
				$socialEmptyClass = 'col-lg-8';
				echo '<div class="col-lg-4">';
					echo '<div class="social-profile">';
						bosa_social();
					echo '</div>'; 
				echo '</div>'; 
			} ?> <!-- social links area -->
			<div class="<?php echo esc_attr( $socialEmptyClass ) ?>">
				<div class="footer-desc-wrap">
					<?php get_template_part( 'template-parts/site', 'info' ); ?>
					<?php if ( has_nav_menu( 'menu-2' ) && !get_theme_mod( 'disable_footer_menu', false )){ ?>
						<div class="footer-menu"><!-- Footer Menu-->
							<?php
							wp_nav_menu( array(
								'theme_location' => 'menu-2',
								'menu_id'        => 'footer-menu',
								'depth'          => 1,
							) );
							?>
						</div><!-- footer Menu-->
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>