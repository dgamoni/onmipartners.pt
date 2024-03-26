<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package pizzaro
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php
	do_action( 'pizzaro_before_header' ); ?>

	<?php $header_bg_version = pizzaro_get_header_bg_version(); ?>

	<header id="masthead" class="site-header header-v2 <?php echo esc_attr( $header_bg_version ); ?>" role="banner" style="<?php pizzaro_header_styles(); ?>">
		<div class="site-header-wrap">
		<div class="col-full">

			<?php
			/**
			 * Functions hooked into pizzaro_header_v1 action
			 *
			 * @hooked pizzaro_skip_links                       - 0
			 * @hooked pizzaro_primary_navigation               - 20
			 * @hooked pizzaro_site_branding                    - 30
			 * @hooked pizzaro_header_navigation_link           - 40
			 * @hooked pizzaro_header_cart                      - 50
			 */
			do_action( 'pizzaro_header_v2' ); 
			if ( is_user_logged_in() ) { ?>
				<a class="user_icon_area" href="<?php echo get_edit_user_link( $user_id ); ?>">
					<!-- <img src="<?php //echo esc_url( get_avatar_url( $user->ID ) ); ?>"> -->
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/account-icon.svg">
				</a>
				<a class="user_icon_area" href="<?php echo get_bloginfo('url'); ?>/cart/">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/cart-icon.svg">
				</a>
			<?php } else { ?>
			<a class="user_icon_area" href="<?php echo wp_login_url(); ?>">
				<!-- <img src="<?php //echo  get_bloginfo('template_url') . '/assets/images/mystery.jpg'; ?>"> -->
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/account-icon.svg">
			</a>
		<?php } ?>
		</div>
		</div>
	</header><!-- #masthead -->

	<?php if( !is_front_page() ) { pizza_header_tabs(); } ?>

	<?php
	/**
	 * Functions hooked in to pizzaro_before_content
	 *
	 * @hooked pizzaro_header_widget_region - 10
	 */
	do_action( 'pizzaro_before_content' ); ?>

	<div id="content" class="site-content" tabindex="-1" <?php pizzaro_site_content_style(); ?>>
		<div class="col-full">

		<?php
		/**
		 * Functions hooked in to pizzaro_content_top
		 *
		 * @hooked woocommerce_breadcrumb - 10
		 */
		do_action( 'pizzaro_content_top' );
