<?php
/**
 * Theme header.
 *
 * @package Satlantas_Ponorogo
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php echo esc_attr( get_bloginfo( 'description' ) ); ?>">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'satlantas-ponorogo' ); ?></a>

<header class="site-header" id="masthead">
	<div class="site-header__inner">
		<div class="site-branding">
			<a class="brand-fallback" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php bloginfo( 'name' ); ?>">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<img src="<?php echo satlantas_asset( 'assets/images/logo-polres.png' ); ?>" alt="<?php esc_attr_e( 'Polres Ponorogo', 'satlantas-ponorogo' ); ?>">
					<img src="<?php echo satlantas_asset( 'assets/images/logo-satlantas.png' ); ?>" alt="<?php esc_attr_e( 'Satlantas Ponorogo', 'satlantas-ponorogo' ); ?>">
				<?php endif; ?>
			</a>
		</div>

		<nav class="main-navigation" aria-label="<?php esc_attr_e( 'Primary navigation', 'satlantas-ponorogo' ); ?>">
			<button class="menu-toggle" type="button" aria-controls="primary-menu" aria-expanded="false">
				<span></span><span></span><span></span>
				<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'satlantas-ponorogo' ); ?></span>
			</button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'container'      => false,
					'fallback_cb'    => 'satlantas_fallback_menu',
				)
			);
			?>
		</nav>
	</div>
</header>
