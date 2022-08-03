<?php
$width_control = '';
if( get_theme_mod( 'slider_width_controls', 'full' ) == 'boxed' ){
	$width_control = 'container boxed';
}

$slider_layout = 'slider-layout-one';
$posts_per_page_count = get_theme_mod( 'slider_posts_number', 6 );
$slider_id = get_theme_mod( 'slider_category', '' );

$query = new WP_Query( apply_filters( 'bosa_blog_args', array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => $posts_per_page_count,
	'cat'                 => $slider_id,
	'offset'              => 0,
	'ignore_sticky_posts' => 1
)));

$posts_array = $query->get_posts(); ?>

<div class="main-slider-wrap <?php echo esc_attr( $slider_layout ); ?> <?php echo esc_attr( $width_control ); ?>">
	<div class="main-slider">
		<?php
			while ( $query->have_posts() ) : $query->the_post();
			$render_slider_image 	= get_theme_mod( 'render_slider_image_size', 'bosa-1370-550' );
			$image 					= get_the_post_thumbnail_url( get_the_ID(), $render_slider_image );
		?>
			<div class="slide-item">
				<div class="banner-img" style="background-image: url( <?php echo esc_url( $image ); ?> );">
					<?php
					$alignmentClass = 'text-center';
					if ( get_theme_mod( 'main_slider_content_alignment' , 'center' ) == 'left' ){
						$alignmentClass = 'text-left';
					}elseif ( get_theme_mod( 'main_slider_content_alignment' , 'center' ) == 'right' ){
						$alignmentClass = 'text-right';
					}
					?>
					<div class="slide-inner">
						<div class="banner-content <?php echo esc_attr( $alignmentClass ); ?>">
						    <div class="entry-content">
						    	<header class="entry-header">
									<?php
									if( !get_theme_mod( 'hide_slider_category', false ) ){
										bosa_entry_header();
									}
									if ( is_singular() ) :
										the_title( '<h1 class="entry-title">', '</h1>' );
									else :
										if ( !get_theme_mod( 'hide_slider_title', false ) ){
											the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
										}
									endif; 
									
									?>
								</header><!-- .entry-header -->
								<div class="entry-meta">
									<?php
										if( !get_theme_mod( 'hide_slider_date', false ) ): ?>
											<span class="posted-on">
												<a href="<?php echo esc_url( bosa_get_day_link() ); ?>" >
													<?php echo esc_html(get_the_date('M j, Y')); ?>
												</a>
											</span>
										<?php endif; 
										if( !get_theme_mod( 'hide_slider_author', false ) ): ?>
											<span class="byline">
												<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
													<?php echo get_the_author(); ?>
												</a>
											</span>
										<?php endif; 
										if( !get_theme_mod( 'hide_slider_comment', false ) ):
											echo '<span class="comments-link">';
											comments_popup_link(
												sprintf(
													wp_kses(
														/* translators: %s: post title */
														__( 'Comment<span class="screen-reader-text"> on %s</span>', 'bosa' ),
														array(
															'span' => array(
																'class' => array(),
															),
														)
													),
													get_the_title()
												)
											);
											echo '</span>';
										endif;
									?>
						        </div><!-- .entry-meta -->
								
								<?php if ( !get_theme_mod( 'hide_slider_excerpt', false ) || !get_theme_mod( 'hide_slider_button', false ) ){ ?>
						        	<div class="entry-text">
										<?php
											if ( !get_theme_mod( 'hide_slider_excerpt', false ) ){
												$excerpt_length = get_theme_mod( 'slider_excerpt_length', 25 );
												bosa_excerpt( $excerpt_length , true );
											}
											if( !get_theme_mod( 'hide_slider_button', false ) ){
												$slider_btn_defaults = array(
													array(
														'slider_btn_type' 			=> 'button-outline',
														'slider_btn_bg_color' 		=> '#EB5A3E',
														'slider_btn_border_color' 	=> '#ffffff',
														'slider_btn_text_color' 	=> '#ffffff',
														'slider_btn_hover_color' 	=> '#086abd',
														'slider_btn_text' 			=> '',
														'slider_btn_radius' 		=> 0,
													),		
												);
										        $slider_button = get_theme_mod( 'main_slider_button_repeater', $slider_btn_defaults );
										        
										        if( !empty( $slider_button ) && is_array( $slider_button ) ){ ?>
										        	<div class="button-container">
										        		<?php
												            $count = 0.2;
												            foreach( $slider_button as $value ){
												            	if( !empty( $value['slider_btn_text'] ) ){ ?>
																	<a href="<?php the_permalink(); ?>" class="<?php echo esc_attr( $value['slider_btn_type'] ); ?>">
																		<?php
																			echo esc_html( $value['slider_btn_text'] );
																		?>
																	</a>
																	<?php
												                	$count = $count + 0.2;
												                }
												            }
												        ?>
												    </div>
												    <?php  
												}
											} 
										?>
									</div>
								<?php } ?>
							</div><!-- .entry-content -->
						</div>
					</div>
					<div class="overlay"></div>
				</div>
			</div>
		<?php
		endwhile; 
		wp_reset_postdata();
		?>
	</div>
	<?php if( !get_theme_mod( 'disable_slider_arrows', false ) ) { ?>
		<ul class="slick-control">
	        <li class="main-slider-prev">
	        	<span></span>
	        </li>
	        <li class="main-slider-next">
	        	<span></span>
	        </li>
	    </ul>
	<?php } ?>
	<?php if ( !get_theme_mod( 'disable_slider_dots', false ) ){ ?>
		<div class="main-slider-dots"></div>
	<?php } ?>
</div>