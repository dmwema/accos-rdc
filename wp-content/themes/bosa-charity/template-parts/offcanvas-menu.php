<?php
/** 
* Template for Off canvas Menu
* @since Bosa Charity 1.0.1
*/
?>
<div id="offcanvas-menu" class="offcanvas-menu-wrap">
	<div class="close-offcanvas-menu">
		<button class="fas fa-times"></button>
	</div>
	<div class="offcanvas-menu-inner">
		<div class="offcanvas-menu-content">
			<!-- header secondary menu -->
			<?php if( !get_theme_mod( 'disable_secondary_menu', false ) ){ ?>
				<?php if( get_theme_mod( 'header_layout', 'header_two' ) == 'header_three' ){ ?>
					<?php if( has_nav_menu( 'menu-3') ){ ?>
						<nav class="header-navigation d-lg-none">
							<?php
							wp_nav_menu( array(
								'theme_location' => 'menu-3',
								'menu_id'        => 'secondary-menu',
							) );
							?>
						</nav><!-- #site-navigation -->
					<?php } ?>
				<?php } ?>
			<?php } ?>
			<!-- header search field -->
			<?php if( !get_theme_mod( 'disable_search_icon', false ) && !get_theme_mod( 'disable_mobile_search_icon', false ) ) { ?>
				<div class="header-search-wrap d-lg-none">
			 		<?php get_search_form();  ?>
				</div>
			<?php } ?>
			<!-- header callback button -->
			<?php
			if ( !get_theme_mod( 'disable_header_button', false ) && !get_theme_mod( 'disable_mobile_header_buttons', false ) ){
				if( get_theme_mod( 'header_layout', 'header_two' ) == 'header_one' ){ 
					$header_btn_defaults = array(
						array(
							'header_btn_type' 			=> 'button-outline',
							'header_btn_bg_color'		=> '#EB5A3E',
							'header_btn_border_color'	=> '#1a1a1a',
							'header_btn_text_color'		=> '#1a1a1a',
							'header_btn_hover_color'	=> '#086abd',
							'header_btn_text' 			=> '',
							'header_btn_link' 			=> '',
							'header_btn_target'			=> true,
							'header_btn_radius'			=> 0,
						),	
					);
				
					$header_buttons = get_theme_mod( 'header_button_repeater', $header_btn_defaults );
					$has_header_btn = false;
					if ( is_array( $header_buttons ) ){
						foreach( $header_buttons as $value ){
							if( !empty( $value['header_btn_text'] ) ){
								$has_header_btn = true;
								break;
							}
						}
					}
					if( $has_header_btn ){ ?>
						<div class="header-btn-wrap d-lg-none">
							<div class="header-btn">
								<?php	
									$i = 1;
					            	foreach( $header_buttons as $value ){
					            		if( !empty( $value['header_btn_text'] ) ){
					            			$link_target = '';
											if( $value['header_btn_target'] ){
												$link_target = '_blank';
											}else {
												$link_target = '';
											} ?>
											<a href="<?php echo esc_url( $value['header_btn_link'] ); ?>" target="<?php echo esc_attr( $link_target ); ?>" class="header-btn-<?php echo $i.' '.esc_attr( $value['header_btn_type'] ); ?>">
												<?php echo esc_html( $value['header_btn_text'] ); ?>
											</a>
										<?php
					            		}
					            		$i++;
					            	}
					            ?>
					        </div>
		            	 </div>
		            <?php	 
		            }
		    	} 
		    	if( get_theme_mod( 'header_layout', 'header_two' ) == 'header_two' ){
					$transparent_header_btn_defaults = array(
						array(
							'transparent_header_btn_type' 				=> 'button-outline',
							'transparent_header_home_btn_bg_color'		=> '#EB5A3E',
							'transparent_header_home_btn_border_color'	=> '#ffffff',
							'transparent_header_home_btn_text_color'	=> '#ffffff',
							'transparent_header_btn_bg_color'			=> '#EB5A3E',
							'transparent_header_btn_border_color'		=> '#1a1a1a',
							'transparent_header_btn_text_color'			=> '#1a1a1a',
							'transparent_header_btn_hover_color'		=> '#086abd',
							'transparent_header_btn_text' 				=> '',
							'transparent_header_btn_link' 				=> '',
							'transparent_header_btn_target'				=> true,
							'transparent_header_btn_radius'				=> 0,
						),	
					);
				
					$transparent_header_buttons = get_theme_mod( 'transparent_header_button_repeater', $transparent_header_btn_defaults );
					$has_header_btn = false;
					if ( is_array( $transparent_header_buttons ) ){
						foreach( $transparent_header_buttons as $value ){
							if( !empty( $value['transparent_header_btn_text'] ) ){
								$has_header_btn = true;
								break;
							}
						}
					}
					if( $has_header_btn ){ ?>
						<div class="header-btn-wrap d-lg-none">
							<div class="header-btn">
								<?php	
									$i = 1;
					            	foreach( $transparent_header_buttons as $value ){
					            		if( !empty( $value['transparent_header_btn_text'] ) ){
					            			$link_target = '';
											if( $value['transparent_header_btn_target'] ){
												$link_target = '_blank';
											}else {
												$link_target = '';
											} ?>
											<a href="<?php echo esc_url( $value['transparent_header_btn_link'] ); ?>" target="<?php echo esc_attr( $link_target ); ?>" class="header-btn-<?php echo $i.' '.esc_attr( $value['transparent_header_btn_type'] ); ?>">
												<?php echo esc_html( $value['transparent_header_btn_text'] ); ?>
											</a>
										<?php
					            		}
					            		$i++;
					            	}
					            ?>
					        </div>
		            	 </div>
		            <?php	 
		            }
		   	 	}
		   	} ?>

		    <!-- header contact details -->
		    <?php if ( !get_theme_mod( 'disable_contact_detail', false ) && !get_theme_mod( 'disable_mobile_contact_details', false ) && ( get_theme_mod( 'contact_phone', '' )  || get_theme_mod( 'contact_email', '' )  || get_theme_mod( 'contact_address', '' ) ) ){ ?>
			    <?php if( get_theme_mod( 'header_layout', 'header_two' ) == 'header_one' || get_theme_mod( 'header_layout', 'header_two' ) == 'header_two' ){ ?>
					<div class="d-lg-none">
						<?php get_template_part( 'template-parts/header', 'contact' ); ?>
					</div>
				<?php } ?>
			<?php } ?>
			<!-- header social icons -->
			<?php 
	        $social_defaults = array(
				array(
					'icon' 		=> '',
					'link' 		=> '',
					'target' 	=> true,
				)			
			);
			$social_icons = get_theme_mod( 'social_media_links', $social_defaults );
			$has_social_icon = false;
			if ( is_array( $social_icons ) ){
				foreach( $social_icons as $value ){
					if( !empty( $value['icon'] ) ){
						$has_social_icon = true;
						break;
					}
				}
			}
	        if( !get_theme_mod( 'disable_header_social_links', false ) && !get_theme_mod( 'disable_mobile_social_icons_header', false ) && $has_social_icon ){ ?>
	        	<div class="social-profile d-lg-none">
		        	<?php
			            echo '<ul class="social-group">';
			            $count = 0.2;
			            $link_target = '';
			            foreach( $social_icons as $value ){
			                if ( $value['target'] ){
				        		$link_target = '_blank';
				        	}else{
				        		$link_target = '';
				        	}
				            if( !empty( $value['icon'] ) ){
					            echo '<li><a href="' . esc_url( $value['link'] ) . '" target="' .esc_html( $link_target ). '"><i class=" ' . esc_attr( $value['icon'] ) . '"></i></a></li>';
					            $count = $count + 0.2;
					        }
			            }
			            echo '</ul>'; 
			        ?>
	            </div>
			<?php } ?>			
		</div>
		<!-- header sidebar -->
		<?php if( is_active_sidebar( 'menu-sidebar' ) ){ ?>
			<div class="header-sidebar">
				<?php dynamic_sidebar( 'menu-sidebar' ); ?>
			</div>
		<?php } ?>	
	</div>
</div>
