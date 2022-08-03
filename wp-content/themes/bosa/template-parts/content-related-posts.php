<?php
/**
 * Template part for displaying related posts in single.php
 *
 * @since Bosa 1.0.0
 */

?>

<?php
	$post_ids[] = get_the_ID();
	$posts_count = get_theme_mod( 'related_posts_count', 4 );
	$args = bosa_get_related_posts( array( 'category', 'post_tag' ), $posts_count, true  );
	$query = new WP_Query( apply_filters( 'bosa_related_posts_args', $args ) );
	if( $query->have_posts() ) {
		while ( $query->have_posts() ){
			$query->the_post();
			array_push( $post_ids, get_the_ID() );		
			?>
			<div class="col-12 col-md-6 col-lg-3">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
				        <figure class="featured-image">
				            <a href="<?php the_permalink(); ?>">
				                <?php 
				                $render_related_post_image_size = get_theme_mod( 'render_related_post_image_size', 'bosa-420-300' );
				                bosa_image_size( $render_related_post_image_size ); ?>
				            </a>
				        </figure>
				   <?php endif; ?>
				    <div class="entry-content">
						<header class="entry-header">
							<?php
								the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
							?>
						</header><!-- .entry-header -->
					</div><!-- .entry-content -->
				</article><!-- #post-->
			</div>
		<?php
		}
		wp_reset_postdata();
	}
	else {
		echo '<div class="col-12">';
		echo '<p class="not-found">';
		esc_html_e( 'No Related Post', 'bosa' );
		echo '</p>';
		echo '</div>';
	}
?>

