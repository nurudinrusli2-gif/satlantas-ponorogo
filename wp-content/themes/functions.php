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

/**
 * Registers the SIM Keliling schedule post type used by the public schedule pages.
 */
function satlantas_register_sim_keliling_post_type() {
	register_post_type(
		'sim_keliling',
		array(
			'labels'       => array(
				'name'               => esc_html__( 'SIM Keliling', 'satlantas-ponorogo' ),
				'singular_name'      => esc_html__( 'SIM Keliling', 'satlantas-ponorogo' ),
				'menu_name'          => esc_html__( 'SIM Keliling', 'satlantas-ponorogo' ),
				'add_new_item'       => esc_html__( 'Tambah Jadwal SIM Keliling', 'satlantas-ponorogo' ),
				'edit_item'          => esc_html__( 'Edit Jadwal SIM Keliling', 'satlantas-ponorogo' ),
				'new_item'           => esc_html__( 'Jadwal SIM Keliling Baru', 'satlantas-ponorogo' ),
				'view_item'          => esc_html__( 'Lihat Jadwal SIM Keliling', 'satlantas-ponorogo' ),
				'search_items'       => esc_html__( 'Cari Jadwal SIM Keliling', 'satlantas-ponorogo' ),
				'not_found'          => esc_html__( 'Belum ada jadwal SIM Keliling.', 'satlantas-ponorogo' ),
				'not_found_in_trash' => esc_html__( 'Tidak ada jadwal SIM Keliling di sampah.', 'satlantas-ponorogo' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'menu_icon'    => 'dashicons-location-alt',
			'rewrite'      => array( 'slug' => 'sim-keliling' ),
			'supports'     => array( 'title', 'editor' ),
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'satlantas_register_sim_keliling_post_type' );

/**
 * Refreshes rewrite rules after the theme registers the SIM Keliling archive URL.
 */
function satlantas_flush_rewrite_rules() {
	satlantas_register_sim_keliling_post_type();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'satlantas_flush_rewrite_rules' );

/**
 * Flushes rewrite rules once after this feature is added to an already-active theme.
 */
function satlantas_maybe_flush_sim_keliling_rewrites() {
	$rewrite_version = 'sim-keliling-1';

	if ( get_option( 'satlantas_sim_keliling_rewrite_version' ) === $rewrite_version ) {
		return;
	}

	flush_rewrite_rules();
	update_option( 'satlantas_sim_keliling_rewrite_version', $rewrite_version );
}
add_action( 'init', 'satlantas_maybe_flush_sim_keliling_rewrites', 20 );

/**
 * Adds schedule fields to the SIM Keliling admin editor.
 */
function satlantas_add_sim_keliling_meta_box() {
	add_meta_box(
		'satlantas_sim_keliling_details',
		esc_html__( 'Detail Jadwal SIM Keliling', 'satlantas-ponorogo' ),
		'satlantas_render_sim_keliling_meta_box',
		'sim_keliling',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'satlantas_add_sim_keliling_meta_box' );

/**
 * Renders native custom fields for schedule date, time, address, maps URL, and status.
 *
 * @param WP_Post $post Current SIM Keliling post.
 */
function satlantas_render_sim_keliling_meta_box( $post ) {
	wp_nonce_field( 'satlantas_save_sim_keliling_meta', 'satlantas_sim_keliling_nonce' );

	$tanggal  = get_post_meta( $post->ID, 'tanggal', true );
	$jam      = get_post_meta( $post->ID, 'jam', true );
	$alamat   = get_post_meta( $post->ID, 'alamat', true );
	$maps_url = get_post_meta( $post->ID, 'maps_url', true );
	$status   = get_post_meta( $post->ID, 'status', true ) ?: 'aktif';
	?>
	<p>
		<label for="satlantas-sim-tanggal"><strong><?php esc_html_e( 'Tanggal', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-sim-tanggal" type="date" name="satlantas_sim_keliling[tanggal]" value="<?php echo esc_attr( $tanggal ); ?>" class="widefat">
	</p>
	<p>
		<label for="satlantas-sim-jam"><strong><?php esc_html_e( 'Jam', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-sim-jam" type="text" name="satlantas_sim_keliling[jam]" value="<?php echo esc_attr( $jam ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Contoh: 08.00 - 12.00 WIB', 'satlantas-ponorogo' ); ?>">
	</p>
	<p>
		<label for="satlantas-sim-alamat"><strong><?php esc_html_e( 'Alamat', 'satlantas-ponorogo' ); ?></strong></label><br>
		<textarea id="satlantas-sim-alamat" name="satlantas_sim_keliling[alamat]" rows="3" class="widefat"><?php echo esc_textarea( $alamat ); ?></textarea>
	</p>
	<p>
		<label for="satlantas-sim-maps-url"><strong><?php esc_html_e( 'Maps URL', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-sim-maps-url" type="url" name="satlantas_sim_keliling[maps_url]" value="<?php echo esc_url( $maps_url ); ?>" class="widefat" placeholder="https://maps.google.com/...">
	</p>
	<p>
		<label for="satlantas-sim-status"><strong><?php esc_html_e( 'Status', 'satlantas-ponorogo' ); ?></strong></label><br>
		<select id="satlantas-sim-status" name="satlantas_sim_keliling[status]" class="widefat">
			<option value="aktif" <?php selected( $status, 'aktif' ); ?>><?php esc_html_e( 'Aktif', 'satlantas-ponorogo' ); ?></option>
			<option value="nonaktif" <?php selected( $status, 'nonaktif' ); ?>><?php esc_html_e( 'Nonaktif', 'satlantas-ponorogo' ); ?></option>
		</select>
	</p>
	<?php
}

/**
 * Saves SIM Keliling schedule fields with native post meta APIs.
 *
 * @param int $post_id Current post ID.
 */
function satlantas_save_sim_keliling_meta( $post_id ) {
	if (
		! isset( $_POST['satlantas_sim_keliling_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['satlantas_sim_keliling_nonce'] ) ), 'satlantas_save_sim_keliling_meta' )
	) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$fields = isset( $_POST['satlantas_sim_keliling'] ) ? (array) wp_unslash( $_POST['satlantas_sim_keliling'] ) : array();

	$sanitized = array(
		'tanggal'  => isset( $fields['tanggal'] ) ? sanitize_text_field( $fields['tanggal'] ) : '',
		'jam'      => isset( $fields['jam'] ) ? sanitize_text_field( $fields['jam'] ) : '',
		'alamat'   => isset( $fields['alamat'] ) ? sanitize_textarea_field( $fields['alamat'] ) : '',
		'maps_url' => isset( $fields['maps_url'] ) ? esc_url_raw( $fields['maps_url'] ) : '',
		'status'   => ( isset( $fields['status'] ) && 'nonaktif' === $fields['status'] ) ? 'nonaktif' : 'aktif',
	);

	foreach ( $sanitized as $key => $value ) {
		update_post_meta( $post_id, $key, $value );
	}
}
add_action( 'save_post_sim_keliling', 'satlantas_save_sim_keliling_meta' );

/**
 * Returns active SIM Keliling schedules ordered from the nearest date.
 *
 * @param int $posts_per_page Number of schedules to fetch.
 * @return WP_Query
 */
function satlantas_get_upcoming_sim_keliling( $posts_per_page = 3 ) {
	return new WP_Query(
		array(
			'post_type'      => 'sim_keliling',
			'posts_per_page' => $posts_per_page,
			'meta_key'       => 'tanggal',
			'orderby'        => 'meta_value',
			'order'          => 'ASC',
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'     => 'tanggal',
					'value'   => current_time( 'Y-m-d' ),
					'compare' => '>=',
					'type'    => 'DATE',
				),
				array(
					'key'     => 'status',
					'value'   => 'aktif',
					'compare' => '=',
				),
			),
		)
	);
}

/**
 * Formats the stored SIM Keliling date for display.
 *
 * @param string $date Date in Y-m-d format.
 * @return string
 */
function satlantas_format_sim_keliling_date( $date ) {
	if ( empty( $date ) ) {
		return esc_html__( 'Tanggal menyusul', 'satlantas-ponorogo' );
	}

	$timestamp = strtotime( $date );

	return $timestamp ? date_i18n( 'd M Y', $timestamp ) : $date;
}

/**
 * Makes the SIM Keliling archive show active upcoming schedules first.
 *
 * @param WP_Query $query Current query object.
 */
function satlantas_order_sim_keliling_archive( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'sim_keliling' ) ) {
		return;
	}

	$query->set( 'posts_per_page', 12 );
	$query->set( 'meta_key', 'tanggal' );
	$query->set( 'orderby', 'meta_value' );
	$query->set( 'order', 'ASC' );
	$query->set(
		'meta_query',
		array(
			'relation' => 'AND',
			array(
				'key'     => 'tanggal',
				'value'   => current_time( 'Y-m-d' ),
				'compare' => '>=',
				'type'    => 'DATE',
			),
			array(
				'key'     => 'status',
				'value'   => 'aktif',
				'compare' => '=',
			),
		)
	);
}
add_action( 'pre_get_posts', 'satlantas_order_sim_keliling_archive' );
