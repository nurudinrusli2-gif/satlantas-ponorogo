<?php
/**
 * Satlantas Ponorogo theme functions.
 *
 * @package Satlantas_Ponorogo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SATLANTAS_VERSION', '1.0.0' );

if ( ! function_exists( 'satlantas_setup' ) ) {
	/**
	 * Sets up theme defaults and registers WordPress features.
	 */
	function satlantas_setup() {
		load_theme_textdomain( 'satlantas-ponorogo', get_template_directory() . '/languages' );

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 72,
				'width'       => 220,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary Menu', 'satlantas-ponorogo' ),
				'footer'  => esc_html__( 'Footer Menu', 'satlantas-ponorogo' ),
			)
		);
	}
}
add_action( 'after_setup_theme', 'satlantas_setup' );

/**
 * Enqueue theme styles and scripts.
 */
function satlantas_scripts() {
	wp_enqueue_style( 'satlantas-style', get_stylesheet_uri(), array(), SATLANTAS_VERSION );
	wp_enqueue_script( 'satlantas-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), SATLANTAS_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'satlantas_scripts' );

/**
 * Returns a theme asset URL.
 *
 * @param string $path Asset path relative to the theme root.
 * @return string
 */
function satlantas_asset( $path ) {
	return esc_url( get_template_directory_uri() . '/' . ltrim( $path, '/' ) );
}

/**
 * Outputs a compact inline icon.
 *
 * @param string $name Icon name.
 */
function satlantas_icon( $name ) {
	$icons = array(
		'sim'      => '<svg viewBox="0 0 48 48" aria-hidden="true"><rect x="8" y="13" width="32" height="22" rx="3"/><circle cx="18" cy="24" r="4"/><path d="M26 21h8M26 27h6M14 31c1.4-2.2 6.6-2.2 8 0"/></svg>',
		'paper'    => '<svg viewBox="0 0 48 48" aria-hidden="true"><path d="M15 7h13l7 7v27H15z"/><path d="M28 7v9h7M20 24h10M20 30h12M20 36h8"/></svg>',
		'plate'    => '<svg viewBox="0 0 48 48" aria-hidden="true"><path d="M24 6 37 12v10c0 8-5.4 14.6-13 18-7.6-3.4-13-10-13-18V12z"/><circle cx="23" cy="22" r="5"/><path d="m27 26 6 6"/></svg>',
		'phone'    => '<svg viewBox="0 0 48 48" aria-hidden="true"><path d="M9 12h30v20H21l-8 6v-6H9z"/><path d="M24 18v7M24 29h.1"/></svg>',
		'info'     => '<svg viewBox="0 0 48 48" aria-hidden="true"><circle cx="24" cy="24" r="16"/><path d="M24 22v11M24 15h.1"/></svg>',
		'map'      => '<svg viewBox="0 0 48 48" aria-hidden="true"><path d="M24 42s13-12 13-24a13 13 0 0 0-26 0c0 12 13 24 13 24z"/><circle cx="24" cy="18" r="5"/></svg>',
		'clock'    => '<svg viewBox="0 0 48 48" aria-hidden="true"><circle cx="24" cy="24" r="17"/><path d="M24 13v12l8 5"/></svg>',
		'call'     => '<svg viewBox="0 0 48 48" aria-hidden="true"><path d="M16 10 9 17c2 12 10 20 22 22l7-7-9-7-4 4c-5-2-8-5-10-10l4-4z"/></svg>',
		'bot'      => '<svg viewBox="0 0 48 48" aria-hidden="true"><path d="M12 18h24v16H12z"/><path d="M20 18v-6h8v6M18 25h.1M30 25h.1M20 32h8"/></svg>',
	);

	echo $icons[ $name ] ?? $icons['info']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Trimmed excerpt helper.
 *
 * @param int $length Word count.
 * @return string
 */
function satlantas_excerpt( $length = 18 ) {
	return esc_html( wp_trim_words( get_the_excerpt(), $length, '...' ) );
}

/**
 * Fallback primary navigation.
 */
function satlantas_fallback_menu() {
	$items = array(
		'Beranda'  => home_url( '/' ),
		'Profil'   => home_url( '/profil/' ),
		'Layanan'  => home_url( '/layanan/' ),
		'Publikasi' => home_url( '/publikasi/' ),
		'Berita'   => home_url( '/berita/' ),
		'Regulasi' => home_url( '/regulasi/' ),
		'Kontak'   => home_url( '/kontak/' ),
	);

	echo '<ul id="primary-menu" class="menu nav-menu">';
	foreach ( $items as $label => $url ) {
		printf(
			'<li class="menu-item"><a href="%1$s">%2$s</a></li>',
			esc_url( $url ),
			esc_html( $label )
		);
	}
	echo '</ul>';
}
