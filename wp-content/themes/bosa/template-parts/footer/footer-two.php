<div class="bottom-footer">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-3">
				<!-- social links area -->
				<?php 
				if( !get_theme_mod( 'disable_footer_social_links', false ) && bosa_has_social() ){
					echo '<div class="social-profile">';
						bosa_social();
					echo '</div>'; 	
				} ?> <!-- social links area -->
			</div>
			<div class="col-lg-6">
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
				<?php }
				get_template_part( 'template-parts/site', 'info' ); ?>
			</div>
			<div class="col-lg-3">
				<?php bosa_footer_image(); ?>
			</div>
		</div>
	</div>
</div>