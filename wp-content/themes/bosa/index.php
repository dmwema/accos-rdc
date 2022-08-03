<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bosa
 */

get_header();
?>
	<?php
	if( is_home() && !get_theme_mod( 'disable_main_slider', false ) ){
		if ( get_theme_mod( 'main_slider_controls', 'slider' ) == 'slider' ){
			if ( get_theme_mod( 'display_main_slider_on', 'below_header' ) == 'below_header' ){
				?>
				<section class="section-banner">
					<?php 
						get_template_part( 'template-parts/slider/slider', '' ); 
					?>
				</section>
				<?php
			}
		}elseif( get_theme_mod( 'main_slider_controls', 'slider' ) == 'banner' ){
			if ( get_theme_mod( 'display_banner_on', 'below_header' ) == 'below_header' ){
				bosa_banner();
			}
		}
	} ?>
	<div id="content" class="site-content">
		<div class="container">
			<?php
			//Feature Posts Section
			if( get_theme_mod( 'feature_posts_section_layouts', 'feature_one' ) == '' || get_theme_mod( 'feature_posts_section_layouts', 'feature_one' ) == 'feature_one' ){
				get_template_part( 'template-parts/feature-posts/feature-posts', 'one' );
			} ?>

			<?php
			if( is_home() && !get_theme_mod( 'disable_main_slider', false ) ){
				if ( get_theme_mod( 'main_slider_controls', 'slider' ) == 'slider' ){
					if ( get_theme_mod( 'display_main_slider_on', 'below_header' ) == 'below_featured_posts' ){
						?>
						<section class="section-banner">
							<?php 
								get_template_part( 'template-parts/slider/slider', '' ); 
							?>
						</section>
						<?php
					}
				}elseif( get_theme_mod( 'main_slider_controls', 'slider' ) == 'banner' ){
					if ( get_theme_mod( 'display_banner_on', 'below_header' ) == 'below_featured_posts' ){
						bosa_banner();
					}
				}
			} ?>

			<!-- Latest Posts Section -->
			<?php 
				$latest_posts_category = get_theme_mod( 'latest_posts_category', '' );
				$archive_post_per_page = get_theme_mod( 'archive_post_per_page', 10 );
				$query = new WP_Query( apply_filters( 'bosa_blog_args', array(
					'post_type'           => 'post',
					'post_status'         => 'publish',
					'cat'                 => $latest_posts_category,
					'paged'          	  => get_query_var( 'paged', 1 ), 
					'posts_per_page'      => $archive_post_per_page,
				)));
				$posts_array = $query->get_posts();
				$show_latest_posts = count( $posts_array ) > 0;
				if( !get_theme_mod( 'disable_latest_posts_section', false ) && $show_latest_posts ){
					$latest_title_desc_align = get_theme_mod( 'latest_posts_section_title_desc_alignment', 'left' );
				if ( $latest_title_desc_align == 'left' ){
					$latest_title_desc_align = 'text-left';
				}else if ( $latest_title_desc_align == 'center' ){
					$latest_title_desc_align = 'text-center';
				}else{
					$latest_title_desc_align = 'text-right';
				} ?>
				<section class="section-post-area">
					<div class="row">
						<?php
							$sidebarClass = 'col-lg-8';
							$sidebarColumnClass = 'col-lg-4';
							$masonry_class = '';

							if( get_theme_mod( 'archive_post_layout', 'list' ) == 'grid'){
								$masonry_class = 'masonry-wrapper';
							}
							if( get_theme_mod( 'archive_post_layout', 'list' ) == 'grid' ){
								$layout_class = 'grid-post-wrap';
							}elseif( get_theme_mod( 'archive_post_layout', 'list' ) == 'single' ){
								$layout_class = 'single-post';
							}
							if ( get_theme_mod( 'sidebar_settings', 'right' ) == 'right' ){
								if( get_theme_mod( 'archive_post_layout', 'list' ) == 'grid'){
									if( !is_active_sidebar( 'right-sidebar') ){
										$sidebarClass = "col-12";
									}	
								}else{
									if( !is_active_sidebar( 'right-sidebar') ){
										$sidebarClass = "col-lg-8 offset-lg-2";
									}
								}
							}elseif ( get_theme_mod( 'sidebar_settings', 'right' ) == 'left' ){
								if( get_theme_mod( 'archive_post_layout', 'list' ) == 'grid'){
									if( !is_active_sidebar( 'left-sidebar') ){
										$sidebarClass = "col-12";
									}	
								}else{
									if( !is_active_sidebar( 'left-sidebar') ){
										$sidebarClass = "col-lg-8 offset-lg-2";
									}
								}
							}elseif ( get_theme_mod( 'sidebar_settings', 'right' ) == 'right-left' ){
								$sidebarClass = 'col-lg-6';
								$sidebarColumnClass = 'col-lg-3';
								if( get_theme_mod( 'archive_post_layout', 'list' ) == 'grid'){
									if( !is_active_sidebar( 'left-sidebar') && !is_active_sidebar( 'right-sidebar') ){
										$sidebarClass = "col-12";
									}	
								}else{
									if(!is_active_sidebar( 'left-sidebar') && !is_active_sidebar( 'right-sidebar') ){
										$sidebarClass = "col-lg-8 offset-lg-2";
									}
								}
							}
							if ( get_theme_mod( 'sidebar_settings', 'right' ) == 'no-sidebar' || get_theme_mod( 'disable_sidebar_blog_page', false ) ){
								if( get_theme_mod( 'archive_post_layout', 'list' ) == 'grid'){
									$sidebarClass = "col-12";	
								}else{
									$sidebarClass = 'col-lg-8 offset-lg-2';
								}
							}
							if( !get_theme_mod( 'disable_sidebar_blog_page', false ) ){
								if ( get_theme_mod( 'sidebar_settings', 'right' ) == 'left' ){ 
									if( is_active_sidebar( 'left-sidebar') ){ ?>
										<div id="secondary" class="sidebar left-sidebar <?php echo esc_attr( $sidebarColumnClass ); ?>">
											<?php dynamic_sidebar( 'left-sidebar' ); ?>
										</div>
								<?php }
								}elseif ( get_theme_mod( 'sidebar_settings', 'right' ) == 'right-left' ){
									if( is_active_sidebar( 'left-sidebar') || is_active_sidebar( 'right-sidebar') ){ ?>
										<div id="secondary" class="sidebar left-sidebar <?php echo esc_attr( $sidebarColumnClass ); ?>">
											<?php dynamic_sidebar( 'left-sidebar' ); ?>
										</div>
									<?php
									}
								}
							} ?>
						
						<div id="primary" class="content-area <?php echo esc_attr( $sidebarClass ); ?>">
							<?php if( ( !get_theme_mod( 'disable_latest_posts_section_title', true ) && get_theme_mod( 'latest_posts_section_title', '' ) ) || ( !get_theme_mod( 'disable_latest_posts_section_description', true ) && get_theme_mod( 'latest_posts_section_description', '' ) ) ){ ?>
								<div class="section-title-wrap <?php echo esc_attr( $latest_title_desc_align ); ?>">
									<?php if( !get_theme_mod( 'disable_latest_posts_section_title', true ) && get_theme_mod( 'latest_posts_section_title', '' ) ){ ?>
										<h2 class="section-title"><?php echo esc_html( get_theme_mod( 'latest_posts_section_title', '' ) ); ?></h2>
									<?php } 
									if( !get_theme_mod( 'disable_latest_posts_section_description', true ) && get_theme_mod( 'latest_posts_section_description', '' ) ){ ?>
										<p><?php echo esc_html( get_theme_mod( 'latest_posts_section_description', '' ) ); ?></p>
									<?php } ?>
								</div>
							<?php } ?>
							<div class="row <?php echo esc_attr( $masonry_class ); ?>">
							<?php
							if ( $query->have_posts() ) :

								if ( is_home() && !is_front_page() ) :
									?>
									<header>
										<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
									</header>
									<?php
								endif;

								/* Start the Loop */
								while ( $query->have_posts() ) :
									$query->the_post();

									/*
									 * Include the Post-Type-specific template for the content.
									 * If you want to override this in a child theme, then include a file
									 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
									 */
									get_template_part( 'template-parts/content', get_post_type() );

								endwhile;

							elseif ( !is_sticky() && ! $query->have_posts() ):
								get_template_part( 'template-parts/content', 'none' );
							endif;
							?>
							</div><!-- #main -->
							<?php
								if( !get_theme_mod( 'disable_pagination', false ) ):
									the_posts_pagination( array(
										'total'        => $query->max_num_pages,
										'next_text' => '<span>'.esc_html__( 'Next', 'bosa' ) .'</span><span class="screen-reader-text">' . esc_html__( 'Next page', 'bosa' ) . '</span>',
										'prev_text' => '<span>'.esc_html__( 'Prev', 'bosa' ) .'</span><span class="screen-reader-text">' . esc_html__( 'Previous page', 'bosa' ) . '</span>',
										'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'bosa' ) . ' </span>',
									));
								endif;
								wp_reset_postdata();
							?>
						</div><!-- #primary -->
						<?php
							if( !get_theme_mod( 'disable_sidebar_blog_page', false ) ){
								if ( get_theme_mod( 'sidebar_settings', 'right' ) == 'right' ){ 
									if( is_active_sidebar( 'right-sidebar') ){ ?>
										<div id="secondary" class="sidebar right-sidebar <?php echo esc_attr( $sidebarColumnClass ); ?>">
											<?php dynamic_sidebar( 'right-sidebar' ); ?>
										</div>
								<?php }
								}elseif ( get_theme_mod( 'sidebar_settings', 'right' ) == 'right-left' ){
									if( is_active_sidebar( 'left-sidebar') || is_active_sidebar( 'right-sidebar') ){ ?>
										<div id="secondary-sidebar" class="sidebar right-sidebar <?php echo esc_attr( $sidebarColumnClass ); ?>">
											<?php dynamic_sidebar( 'right-sidebar' ); ?>
										</div>
									<?php
									}
								}
							}
						?>
					</div>
				</section>
			<?php } ?>

			<?php 
			//Highlight Posts Section
			if( get_theme_mod( 'highlight_posts_section_layouts', 'highlighted_one' ) == '' || get_theme_mod( 'highlight_posts_section_layouts', 'highlighted_one' ) == 'highlighted_one' ){ 
				get_template_part( 'template-parts/highlight-posts/highlight-posts', 'one' ); 
			} ?>
		</div><!-- #container -->
	</div><!-- #content -->
<?php
get_footer();