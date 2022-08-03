<?php if ( is_active_sidebar( 'footer-sidebar-1' ) ) : ?>
	<div class="col-sm-6 col-12 col-lg-3 footer-widget-item">
		<?php dynamic_sidebar( 'footer-sidebar-1' ); ?>
	</div>
<?php endif;
if ( is_active_sidebar( 'footer-sidebar-2' ) ) : ?>
	<div class="col-sm-6 col-12 col-lg-3 footer-widget-item">
		<?php dynamic_sidebar( 'footer-sidebar-2' ); ?>
	</div>
<?php endif;
if ( is_active_sidebar( 'footer-sidebar-3' ) ) : ?>
	<div class="col-sm-6 col-12 col-lg-3 footer-widget-item">
		<?php dynamic_sidebar( 'footer-sidebar-3' ); ?>
	</div>
<?php endif;
if ( is_active_sidebar( 'footer-sidebar-4' ) ) : ?>
	<div class="col-sm-6 col-12 col-lg-3 footer-widget-item">
		<?php dynamic_sidebar( 'footer-sidebar-4' ); ?>
	</div>
<?php endif; ?>