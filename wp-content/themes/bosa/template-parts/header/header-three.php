<header id="masthead" class="site-header header-three">
	<div class="top-header">
		<?php if( !get_theme_mod( 'disable_top_header_section', false ) ){ ?>
			<?php if( ( !get_theme_mod( 'disable_header_social_links', false ) && bosa_has_social() ) || has_nav_menu( 'menu-3') ){ ?>
				<div class="top-header-inner">
					<div class="container">
						<div class="row align-items-center">
							<div class="col-lg-7 d-none d-lg-block">
								<?php if( has_nav_menu( 'menu-3') ){ ?>
									<nav id="secondary-navigation" class="header-navigation">
										<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'bosa' ); ?></button>
										<?php
										wp_nav_menu( array(
											'theme_location' => 'menu-3',
											'menu_id'        => 'secondary-menu',
										) );
										?>
									</nav><!-- #site-navigation -->
								<?php } ?>
							</div>
							<div class="col-lg-5 d-none d-lg-block">
								<div class="header-icons">
									<?php if( !get_theme_mod( 'disable_header_social_links', false ) && bosa_has_social() ){
									echo '<div class="social-profile">';
										bosa_social();
									echo '</div>'; 
									} ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
		<?php if( !get_theme_mod( 'disable_mobile_top_header', false ) ){ ?>
			<?php if( ( !get_theme_mod( 'disable_header_social_links', false ) && bosa_has_social() ) || has_nav_menu( 'menu-3') || !get_theme_mod( 'disable_search_icon', false ) || is_active_sidebar( 'menu-sidebar' ) ){ ?>
				<div class="alt-menu-icon d-lg-none">
					<a class="offcanvas-menu-toggler" href="#">
						<span class="icon-bar-wrap">
							<span class="icon-bar"></span>
						</span>
						<span class="iconbar-label d-lg-none"><?php echo esc_html( get_theme_mod( 'top_bar_name', 'TOP MENU' ) ); ?></span>
					</a>
				</div>
			<?php } ?>
		<?php } ?>
	</div>
	<div class="mid-header header-image-wrap">
		<?php if( bosa_has_header_media() ){ bosa_header_media(); } ?>
		<div class="container">
			<?php get_template_part( 'template-parts/site', 'branding' ); ?>
		</div>
		<div class="overlay"></div>
	</div>
	<div class="bottom-header fixed-header">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-10 d-none d-lg-block">
					<nav id="site-navigation" class="main-navigation d-none d-lg-flex">
						<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'bosa' ); ?></button>
						<?php if ( has_nav_menu( 'menu-1' ) ) :
							wp_nav_menu( 
								array(
									'container'      => '',
									'theme_location' => 'menu-1',
									'menu_id'        => 'primary-menu',
									'menu_class'     => 'menu nav-menu',
								)
							);
						?>
						<?php else :
							wp_page_menu(
								array(
									'menu_class' => 'menu-wrap',
				                    'before'     => '<ul id="primary-menu" class="menu nav-menu">',
				                    'after'      => '</ul>',
								)
							);
						?>
						<?php endif; ?>
					</nav><!-- #site-navigation -->
				</div>
				<div class="col-lg-2 d-none d-lg-block">
					<div class="header-icons">
						<!-- Search form structure -->
						<?php if( !get_theme_mod( 'disable_search_icon', false ) ): ?>
							<div id="search-form" class="header-search-wrap ">
								<button class="search-icon">
									<span class="fas fa-search"></span>
								</button>
							</div>
						<?php endif; ?>
						<?php if( !get_theme_mod( 'disable_hamburger_menu_icon', false ) && is_active_sidebar( 'menu-sidebar' ) ){ ?>
							<div class="alt-menu-icon">
								<a class="offcanvas-menu-toggler" href="#">
									<span class="icon-bar"></span>
								</a>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>	
		<!-- header search form -->
		<div class="header-search">
			<div class="container">
				<?php get_search_form(); ?>
				<button class="close-button">
					<span class="fas fa-times"></span>
				</button>
			</div>
		</div>
		<!-- header search form end-->
		<div class="mobile-menu-container"></div>
	</div>
	<?php get_template_part( 'template-parts/offcanvas', 'menu' ); ?>
</header><!-- #masthead -->