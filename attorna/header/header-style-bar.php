<?php
	/* a template for displaying the header area */

	// header container
	$body_layout = attorna_get_option('general', 'layout', 'full');
	$body_margin = attorna_get_option('general', 'body-margin', '0px');
	$header_width = attorna_get_option('general', 'header-width', 'boxed');
	$header_style = attorna_get_option('general', 'header-bar-navigation-align', 'center');
	$header_background_style = attorna_get_option('general', 'header-background-style', 'solid');

	$header_wrap_class = '';
	if( $header_style == 'center-logo' ){
		$header_wrap_class .= ' attorna-style-center';
	}else{
		$header_wrap_class .= ' attorna-style-left';
	}

	$header_container_class = '';
	if( $header_width == 'boxed' ){
		$header_container_class .= ' attorna-container';
	}else if( $header_width == 'custom' ){
		$header_container_class .= ' attorna-header-custom-container';
	}else{
		$header_container_class .= ' attorna-header-full';
	}

	$navigation_wrap_class  = ' attorna-style-' . $header_background_style;
	$navigation_wrap_class .= ' attorna-sticky-navigation attorna-sticky-navigation-height';
	if( $header_style == 'center' || $header_style == 'center-logo' ){
		$navigation_wrap_class .= ' attorna-style-center';
	}else{
		$navigation_wrap_class .= ' attorna-style-left';
	}
	if( $body_layout == 'boxed' || $body_margin != '0px' ){
		$navigation_wrap_class .= ' attorna-style-slide';
	}else{
		$navigation_wrap_class .= '  attorna-style-fixed';
	}
	if( $header_background_style == 'transparent' ){
		$navigation_wrap_class .= ' attorna-without-placeholder';
	}

?>	
<header class="attorna-header-wrap attorna-header-style-bar attorna-header-background <?php echo esc_attr($header_wrap_class); ?>" >
	<div class="attorna-header-container clearfix <?php echo esc_attr($header_container_class); ?>">
		<div class="attorna-header-container-inner">
		<?php
			
			if( is_page() ){
				$post_option = attorna_get_post_option(get_the_ID());
			}
			if( empty($post_option['enable-logo']) ){
				$enable_logo = attorna_get_option('general', 'enable-logo', 'enable');
			}else if( $post_option['enable-logo'] == 'disable' ){
				$enable_logo = 'disable';
			}else{
				$enable_logo = 'enable';
			}
			if( $enable_logo == 'enable' ){
				echo attorna_get_logo();
			}

			$logo_right_text = attorna_get_option('general', 'logo-right-text');
			if( !empty($logo_right_text) ){
				echo '<div class="attorna-logo-right-text attorna-item-pdlr" >';
				echo gdlr_core_content_filter($logo_right_text);
				echo '</div>';
			}
		?>
		</div>
	</div>
</header><!-- header -->
<div class="attorna-navigation-bar-wrap <?php echo esc_attr($navigation_wrap_class); ?>" >
	<div class="attorna-navigation-background" ></div>
	<div class="attorna-navigation-container clearfix <?php echo esc_attr($header_container_class); ?>">
		<?php
			$navigation_class = '';
			if( attorna_get_option('general', 'enable-main-navigation-submenu-indicator', 'disable') == 'enable' ){
				$navigation_class .= 'attorna-navigation-submenu-indicator ';
			}
		?>
		<div class="attorna-navigation attorna-item-pdlr clearfix <?php echo esc_attr($navigation_class); ?>" >
		<?php
			// print main menu
			if( has_nav_menu('main_menu') ){
				echo '<div class="attorna-main-menu" id="attorna-main-menu" >';
				wp_nav_menu(array(
					'theme_location'=>'main_menu', 
					'container'=> '', 
					'menu_class'=> 'sf-menu',
					'walker' => new attorna_menu_walker()
				));
				$slide_bar = attorna_get_option('general', 'navigation-slide-bar', 'enable');
				if( $slide_bar == 'enable' ){
					echo '<div class="attorna-navigation-slide-bar" id="attorna-navigation-slide-bar" ></div>';
				}
				echo '</div>';
			}

			// menu right side
			$menu_right_class = '';
			if( $header_style == 'center' || $header_style == 'center-logo' ){
				$menu_right_class = ' attorna-item-mglr attorna-navigation-top';
			}

			// menu right side
			$enable_search = (attorna_get_option('general', 'enable-main-navigation-search', 'enable') == 'enable')? true: false;
			$enable_cart = (attorna_get_option('general', 'enable-main-navigation-cart', 'enable') == 'enable' && class_exists('WooCommerce'))? true: false;
			$enable_right_button = (attorna_get_option('general', 'enable-main-navigation-right-button', 'disable') == 'enable')? true: false;
			if( has_nav_menu('right_menu') || $enable_search || $enable_cart || $enable_right_button ){
				echo '<div class="attorna-main-menu-right-wrap clearfix ' . esc_attr($menu_right_class) . '" >';

				// search icon
				if( $enable_search ){
					echo '<div class="attorna-main-menu-search" id="attorna-top-search" >';
					echo '<i class="fa fa-search" ></i>';
					echo '</div>';
					attorna_get_top_search();
				}

				// cart icon
				if( $enable_cart ){
					echo '<div class="attorna-main-menu-cart" id="attorna-main-menu-cart" >';
					echo '<i class="fa fa-shopping-cart" data-attorna-lb="top-bar" ></i>';
					attorna_get_woocommerce_bar();
					echo '</div>';
				}

				// menu right button
				if( $enable_right_button ){
					$button_class = 'attorna-style-' . attorna_get_option('general', 'main-navigation-right-button-style', 'default');
					$button_link = attorna_get_option('general', 'main-navigation-right-button-link', '');
					$button_link_target = attorna_get_option('general', 'main-navigation-right-button-link-target', '_self');
					echo '<a class="attorna-main-menu-right-button ' . esc_attr($button_class) . '" href="' . esc_url($button_link) . '" target="' . esc_attr($button_link_target) . '" >';
					echo attorna_get_option('general', 'main-navigation-right-button-text', '');
					echo '</a>';
				}

				// print right menu
				if( has_nav_menu('right_menu') ){
					attorna_get_custom_menu(array(
						'container-class' => 'attorna-main-menu-right',
						'button-class' => 'attorna-right-menu-button attorna-top-menu-button',
						'icon-class' => 'fa fa-bars',
						'id' => 'attorna-right-menu',
						'theme-location' => 'right_menu',
						'type' => attorna_get_option('general', 'right-menu-type', 'right')
					));
				}

				echo '</div>'; // attorna-main-menu-right-wrap
			}
		?>
		</div><!-- attorna-navigation -->

	</div><!-- attorna-header-container -->
</div><!-- attorna-navigation-bar-wrap -->