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
	if ( is_front_page() && function_exists( 'satlantas_get_active_location_layanan_data' ) ) {
		$location_data = satlantas_get_active_location_layanan_data( -1, false );
		if ( ! empty( $location_data ) ) {
			wp_enqueue_script(
				'satlantas-locations-map',
				get_template_directory_uri() . '/assets/js/locations-map.js',
				array(),
				SATLANTAS_VERSION,
				true
			);

			wp_localize_script(
				'satlantas-locations-map',
				'satlantasLocationsMap',
				array(
					'locations' => $location_data,
				)
			);
		}
	}

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
		'map'      => '<svg viewBox="0 0 48 48" aria-hidden="true"><path d="M8 31h32"/><path d="M13 31v-8l6-4 7 2 8-5 4 2v13"/><circle cx="18" cy="16" r="4"/><path d="M18 20v8"/></svg>',
		'clock'    => '<svg viewBox="0 0 48 48" aria-hidden="true"><circle cx="24" cy="24" r="17"/><path d="M24 13v12l8 5"/></svg>',
		'call'     => '<svg viewBox="0 0 48 48" aria-hidden="true"><path d="M17 31c5-1 10-5 13-10"/><path d="M19 37c8 0 15-6 15-14 0-2-1-5-2-7l-6 4 2 5-5 4-5-2-4 6c2 2 3 4 5 4z"/><path d="M27 14c3 0 6 2 7 5"/></svg>',
		'support'  => '<svg viewBox="0 0 48 48" aria-hidden="true"><circle cx="24" cy="18" r="6"/><path d="M14 36c1.5-5 18.5-5 20 0"/><path d="M12 20c0-7 24-7 24 0v6"/><path d="M36 27h3v7h-3"/><path d="M9 27h3v7H9"/></svg>',
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
 * Returns a URL for a page by slug, or the expected permalink pattern.
 *
 * @param string $slug Page slug.
 * @return string
 */
function satlantas_page_url_by_slug( $slug ) {
	$page = get_page_by_path( $slug );

	return $page ? get_permalink( $page ) : home_url( '/' . trim( $slug, '/' ) . '/' );
}

/**
 * Returns the canonical main menu mapping.
 *
 * @return array
 */
function satlantas_primary_nav_map() {
	return array(
		'Beranda'   => home_url( '/' ),
		'Profil'    => satlantas_page_url_by_slug( 'profil' ),
		'Layanan'   => satlantas_page_url_by_slug( 'info-layanan' ),
		'Publikasi' => get_post_type_archive_link( 'pengumuman' ),
		'Berita'    => get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/berita/' ),
		'Regulasi'  => satlantas_regulasi_url(),
		'Kontak'    => satlantas_page_url_by_slug( 'kontak' ),
	);
}

/**
 * Returns the canonical regulations URL.
 *
 * @return string
 */
function satlantas_regulasi_url() {
	$page = get_page_by_path( 'regulasi' );

	return $page ? get_permalink( $page ) : ( get_post_type_archive_link( 'regulasi' ) ?: home_url( '/regulasi/' ) );
}

/**
 * Fallback primary navigation.
 */
function satlantas_fallback_menu() {
	$items = satlantas_primary_nav_map();

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
 * Normalizes primary navigation items so assigned menus follow the canonical mapping.
 *
 * @param array    $items Nav menu items.
 * @param stdClass $menu  Menu object.
 * @param array    $args  Menu args.
 * @return array
 */
function satlantas_normalize_primary_menu_items( $items, $menu, $args ) {
	if ( empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $items;
	}

	$map = satlantas_primary_nav_map();

	foreach ( $items as $item ) {
		$label = trim( wp_strip_all_tags( $item->title ) );

		if ( isset( $map[ $label ] ) ) {
			$item->url = $map[ $label ];
		}
	}

	return $items;
}
add_filter( 'wp_nav_menu_objects', 'satlantas_normalize_primary_menu_items', 10, 3 );

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
	satlantas_register_pengumuman_post_type();
	satlantas_register_informasi_lalu_lintas_post_type();
	satlantas_register_kendaraan_temuan_post_type();
	satlantas_register_lokasi_layanan_post_type();
	satlantas_register_struktur_organisasi_post_type();
	satlantas_register_regulasi_post_type();
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

/**
 * Registers public announcements managed from the WordPress dashboard.
 */
function satlantas_register_pengumuman_post_type() {
	register_post_type(
		'pengumuman',
		array(
			'labels'       => array(
				'name'               => esc_html__( 'Pengumuman', 'satlantas-ponorogo' ),
				'singular_name'      => esc_html__( 'Pengumuman', 'satlantas-ponorogo' ),
				'menu_name'          => esc_html__( 'Pengumuman', 'satlantas-ponorogo' ),
				'add_new_item'       => esc_html__( 'Tambah Pengumuman', 'satlantas-ponorogo' ),
				'edit_item'          => esc_html__( 'Edit Pengumuman', 'satlantas-ponorogo' ),
				'new_item'           => esc_html__( 'Pengumuman Baru', 'satlantas-ponorogo' ),
				'view_item'          => esc_html__( 'Lihat Pengumuman', 'satlantas-ponorogo' ),
				'search_items'       => esc_html__( 'Cari Pengumuman', 'satlantas-ponorogo' ),
				'not_found'          => esc_html__( 'Belum ada pengumuman.', 'satlantas-ponorogo' ),
				'not_found_in_trash' => esc_html__( 'Tidak ada pengumuman di sampah.', 'satlantas-ponorogo' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'menu_icon'    => 'dashicons-megaphone',
			'rewrite'      => array( 'slug' => 'pengumuman' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'satlantas_register_pengumuman_post_type' );

/**
 * Flushes rewrite rules once after Pengumuman is registered.
 */
function satlantas_maybe_flush_pengumuman_rewrites() {
	$rewrite_version = 'pengumuman-1';

	if ( get_option( 'satlantas_pengumuman_rewrite_version' ) === $rewrite_version ) {
		return;
	}

	flush_rewrite_rules();
	update_option( 'satlantas_pengumuman_rewrite_version', $rewrite_version );
}
add_action( 'init', 'satlantas_maybe_flush_pengumuman_rewrites', 20 );

/**
 * Adds announcement detail fields to the admin editor.
 */
function satlantas_add_pengumuman_meta_box() {
	add_meta_box(
		'satlantas_pengumuman_details',
		esc_html__( 'Detail Pengumuman', 'satlantas-ponorogo' ),
		'satlantas_render_pengumuman_meta_box',
		'pengumuman',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'satlantas_add_pengumuman_meta_box' );

/**
 * Renders announcement schedule, status, and priority fields.
 *
 * @param WP_Post $post Current Pengumuman post.
 */
function satlantas_render_pengumuman_meta_box( $post ) {
	wp_nonce_field( 'satlantas_save_pengumuman_meta', 'satlantas_pengumuman_nonce' );

	$tanggal_mulai    = get_post_meta( $post->ID, 'tanggal_mulai', true );
	$tanggal_berakhir = get_post_meta( $post->ID, 'tanggal_berakhir', true );
	$status           = get_post_meta( $post->ID, 'status', true ) ?: 'aktif';
	$prioritas        = get_post_meta( $post->ID, 'prioritas', true ) ?: 'normal';
	?>
	<p>
		<label for="satlantas-pengumuman-tanggal-mulai"><strong><?php esc_html_e( 'Tanggal Mulai', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-pengumuman-tanggal-mulai" type="date" name="satlantas_pengumuman[tanggal_mulai]" value="<?php echo esc_attr( $tanggal_mulai ); ?>" class="widefat">
	</p>
	<p>
		<label for="satlantas-pengumuman-tanggal-berakhir"><strong><?php esc_html_e( 'Tanggal Berakhir', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-pengumuman-tanggal-berakhir" type="date" name="satlantas_pengumuman[tanggal_berakhir]" value="<?php echo esc_attr( $tanggal_berakhir ); ?>" class="widefat">
	</p>
	<p>
		<label for="satlantas-pengumuman-status"><strong><?php esc_html_e( 'Status', 'satlantas-ponorogo' ); ?></strong></label><br>
		<select id="satlantas-pengumuman-status" name="satlantas_pengumuman[status]" class="widefat">
			<option value="aktif" <?php selected( $status, 'aktif' ); ?>><?php esc_html_e( 'Aktif', 'satlantas-ponorogo' ); ?></option>
			<option value="nonaktif" <?php selected( $status, 'nonaktif' ); ?>><?php esc_html_e( 'Nonaktif', 'satlantas-ponorogo' ); ?></option>
		</select>
	</p>
	<p>
		<label for="satlantas-pengumuman-prioritas"><strong><?php esc_html_e( 'Prioritas', 'satlantas-ponorogo' ); ?></strong></label><br>
		<select id="satlantas-pengumuman-prioritas" name="satlantas_pengumuman[prioritas]" class="widefat">
			<option value="tinggi" <?php selected( $prioritas, 'tinggi' ); ?>><?php esc_html_e( 'Tinggi', 'satlantas-ponorogo' ); ?></option>
			<option value="normal" <?php selected( $prioritas, 'normal' ); ?>><?php esc_html_e( 'Normal', 'satlantas-ponorogo' ); ?></option>
		</select>
	</p>
	<?php
}

/**
 * Saves announcement metadata.
 *
 * @param int $post_id Current post ID.
 */
function satlantas_save_pengumuman_meta( $post_id ) {
	if (
		! isset( $_POST['satlantas_pengumuman_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['satlantas_pengumuman_nonce'] ) ), 'satlantas_save_pengumuman_meta' )
	) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$fields = isset( $_POST['satlantas_pengumuman'] ) ? (array) wp_unslash( $_POST['satlantas_pengumuman'] ) : array();

	$tanggal_mulai    = isset( $fields['tanggal_mulai'] ) ? sanitize_text_field( $fields['tanggal_mulai'] ) : '';
	$tanggal_berakhir = isset( $fields['tanggal_berakhir'] ) ? sanitize_text_field( $fields['tanggal_berakhir'] ) : '';
	$status           = ( isset( $fields['status'] ) && 'nonaktif' === $fields['status'] ) ? 'nonaktif' : 'aktif';
	$prioritas        = ( isset( $fields['prioritas'] ) && 'tinggi' === $fields['prioritas'] ) ? 'tinggi' : 'normal';
	$priority_order   = 'tinggi' === $prioritas ? 1 : 0;

	update_post_meta( $post_id, 'tanggal_mulai', $tanggal_mulai );
	update_post_meta( $post_id, 'tanggal_berakhir', $tanggal_berakhir );
	update_post_meta( $post_id, 'status', $status );
	update_post_meta( $post_id, 'prioritas', $prioritas );
	update_post_meta( $post_id, 'prioritas_order', $priority_order );
}
add_action( 'save_post_pengumuman', 'satlantas_save_pengumuman_meta' );

/**
 * Returns the active announcement meta query.
 *
 * @return array
 */
function satlantas_get_active_pengumuman_meta_query() {
	$today = current_time( 'Y-m-d' );

	return array(
		'relation' => 'AND',
		array(
			'key'     => 'status',
			'value'   => 'aktif',
			'compare' => '=',
		),
		array(
			'relation' => 'OR',
			array(
				'key'     => 'tanggal_mulai',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'     => 'tanggal_mulai',
				'value'   => '',
				'compare' => '=',
			),
			array(
				'key'     => 'tanggal_mulai',
				'value'   => $today,
				'compare' => '<=',
				'type'    => 'DATE',
			),
		),
		array(
			'relation' => 'OR',
			array(
				'key'     => 'tanggal_berakhir',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'     => 'tanggal_berakhir',
				'value'   => '',
				'compare' => '=',
			),
			array(
				'key'     => 'tanggal_berakhir',
				'value'   => $today,
				'compare' => '>=',
				'type'    => 'DATE',
			),
		),
	);
}

/**
 * Returns active announcements ordered by priority and newest publish date.
 *
 * @param int $posts_per_page Number of announcements to fetch.
 * @return WP_Query
 */
function satlantas_get_active_pengumuman( $posts_per_page = 3 ) {
	return new WP_Query(
		array(
			'post_type'      => 'pengumuman',
			'posts_per_page' => $posts_per_page,
			'meta_key'       => 'prioritas_order',
			'orderby'        => array(
				'meta_value_num' => 'DESC',
				'date'           => 'DESC',
			),
			'meta_query'     => satlantas_get_active_pengumuman_meta_query(),
		)
	);
}

/**
 * Formats announcement dates.
 *
 * @param string $date Date in Y-m-d format.
 * @return string
 */
function satlantas_format_pengumuman_date( $date ) {
	if ( empty( $date ) ) {
		return '';
	}

	$timestamp = strtotime( $date );

	return $timestamp ? date_i18n( 'd M Y', $timestamp ) : $date;
}

/**
 * Returns a traffic status badge from announcement content.
 *
 * @param int|WP_Post|null $post Optional post object or ID. Defaults to current post.
 * @return array
 */
function satlantas_get_traffic_status_badge( $post = null ) {
	$post = get_post( $post );

	if ( ! $post || 'pengumuman' !== $post->post_type ) {
		return array(
			'label' => esc_html__( 'Informasi', 'satlantas-ponorogo' ),
			'class' => 'traffic-status--neutral',
		);
	}

	$source = strtolower(
		wp_strip_all_tags(
			$post->post_title . ' ' . $post->post_content . ' ' . get_post_meta( $post->ID, 'prioritas', true )
		)
	);

	if ( false !== strpos( $source, 'padat merayap' ) ) {
		return array(
			'label' => esc_html__( 'Padat Merayap', 'satlantas-ponorogo' ),
			'class' => 'traffic-status--warning',
		);
	}

	if ( false !== strpos( $source, 'macet' ) ) {
		return array(
			'label' => esc_html__( 'Macet', 'satlantas-ponorogo' ),
			'class' => 'traffic-status--danger',
		);
	}

	if ( false !== strpos( $source, 'lancar' ) ) {
		return array(
			'label' => esc_html__( 'Lancar', 'satlantas-ponorogo' ),
			'class' => 'traffic-status--success',
		);
	}

	if ( false !== strpos( $source, 'pengalihan' ) ) {
		return array(
			'label' => esc_html__( 'Pengalihan Arus', 'satlantas-ponorogo' ),
			'class' => 'traffic-status--info',
		);
	}

	if ( false !== strpos( $source, 'perbaikan' ) || false !== strpos( $source, 'pekerjaan' ) ) {
		return array(
			'label' => esc_html__( 'Pekerjaan Jalan', 'satlantas-ponorogo' ),
			'class' => 'traffic-status--warning',
		);
	}

	if ( 'tinggi' === get_post_meta( $post->ID, 'prioritas', true ) ) {
		return array(
			'label' => esc_html__( 'Informasi Penting', 'satlantas-ponorogo' ),
			'class' => 'traffic-status--info',
		);
	}

	return array(
		'label' => esc_html__( 'Informasi', 'satlantas-ponorogo' ),
		'class' => 'traffic-status--neutral',
	);
}

/**
 * Makes the Pengumuman archive show active announcements first.
 *
 * @param WP_Query $query Current query object.
 */
function satlantas_order_pengumuman_archive( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'pengumuman' ) ) {
		return;
	}

	$query->set( 'posts_per_page', 10 );
	$query->set( 'meta_key', 'prioritas_order' );
	$query->set(
		'orderby',
		array(
			'meta_value_num' => 'DESC',
			'date'           => 'DESC',
		)
	);
	$query->set( 'meta_query', satlantas_get_active_pengumuman_meta_query() );
}
add_action( 'pre_get_posts', 'satlantas_order_pengumuman_archive' );

/**
 * Registers traffic information managed from the WordPress dashboard.
 */
function satlantas_register_informasi_lalu_lintas_post_type() {
	register_post_type(
		'informasi_lalu_lintas',
		array(
			'labels'       => array(
				'name'               => esc_html__( 'Informasi Lalu Lintas', 'satlantas-ponorogo' ),
				'singular_name'      => esc_html__( 'Informasi Lalu Lintas', 'satlantas-ponorogo' ),
				'menu_name'          => esc_html__( 'Informasi Lalu Lintas', 'satlantas-ponorogo' ),
				'add_new_item'       => esc_html__( 'Tambah Informasi Lalu Lintas', 'satlantas-ponorogo' ),
				'edit_item'          => esc_html__( 'Edit Informasi Lalu Lintas', 'satlantas-ponorogo' ),
				'new_item'           => esc_html__( 'Informasi Lalu Lintas Baru', 'satlantas-ponorogo' ),
				'view_item'          => esc_html__( 'Lihat Informasi Lalu Lintas', 'satlantas-ponorogo' ),
				'search_items'       => esc_html__( 'Cari Informasi Lalu Lintas', 'satlantas-ponorogo' ),
				'not_found'          => esc_html__( 'Belum ada informasi lalu lintas.', 'satlantas-ponorogo' ),
				'not_found_in_trash' => esc_html__( 'Tidak ada informasi lalu lintas di sampah.', 'satlantas-ponorogo' ),
			),
			'public'       => true,
			'show_ui'      => true,
			'show_in_menu' => true,
			'publicly_queryable' => true,
			'has_archive'  => true,
			'menu_icon'    => 'dashicons-warning',
			'rewrite'      => array( 'slug' => 'informasi-lalu-lintas' ),
			'supports'     => array( 'title', 'editor' ),
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'satlantas_register_informasi_lalu_lintas_post_type' );

/**
 * Flushes rewrite rules once after traffic information is added.
 */
function satlantas_maybe_flush_informasi_lalu_lintas_rewrites() {
	$rewrite_version = 'informasi-lalu-lintas-1';

	if ( get_option( 'satlantas_informasi_lalu_lintas_rewrite_version' ) === $rewrite_version ) {
		return;
	}

	flush_rewrite_rules();
	update_option( 'satlantas_informasi_lalu_lintas_rewrite_version', $rewrite_version );
}
add_action( 'init', 'satlantas_maybe_flush_informasi_lalu_lintas_rewrites', 20 );

/**
 * Adds traffic information fields to the admin editor.
 */
function satlantas_add_informasi_lalu_lintas_meta_box() {
	add_meta_box(
		'satlantas_informasi_lalu_lintas_details',
		esc_html__( 'Detail Informasi Lalu Lintas', 'satlantas-ponorogo' ),
		'satlantas_render_informasi_lalu_lintas_meta_box',
		'informasi_lalu_lintas',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'satlantas_add_informasi_lalu_lintas_meta_box' );

/**
 * Renders traffic information metadata fields.
 *
 * @param WP_Post $post Current Informasi Lalu Lintas post.
 */
function satlantas_render_informasi_lalu_lintas_meta_box( $post ) {
	wp_nonce_field( 'satlantas_save_informasi_lalu_lintas_meta', 'satlantas_informasi_lalu_lintas_nonce' );

	$kategori      = get_post_meta( $post->ID, 'kategori', true ) ?: 'informasi';
	$deskripsi     = get_post_meta( $post->ID, 'deskripsi', true );
	$urutan_tampil = get_post_meta( $post->ID, 'urutan_tampil', true );
	$status        = get_post_meta( $post->ID, 'status', true ) ?: 'aktif';
	?>
	<p>
		<label for="satlantas-informasi-kategori"><strong><?php esc_html_e( 'Kategori', 'satlantas-ponorogo' ); ?></strong></label><br>
		<select id="satlantas-informasi-kategori" name="satlantas_informasi_lalu_lintas[kategori]" class="widefat">
			<option value="macet" <?php selected( $kategori, 'macet' ); ?>><?php esc_html_e( 'Macet', 'satlantas-ponorogo' ); ?></option>
			<option value="padat_merayap" <?php selected( $kategori, 'padat_merayap' ); ?>><?php esc_html_e( 'Padat Merayap', 'satlantas-ponorogo' ); ?></option>
			<option value="hati_hati" <?php selected( $kategori, 'hati_hati' ); ?>><?php esc_html_e( 'Hati-hati', 'satlantas-ponorogo' ); ?></option>
			<option value="informasi" <?php selected( $kategori, 'informasi' ); ?>><?php esc_html_e( 'Informasi', 'satlantas-ponorogo' ); ?></option>
		</select>
	</p>
	<p>
		<label for="satlantas-informasi-deskripsi"><strong><?php esc_html_e( 'Deskripsi', 'satlantas-ponorogo' ); ?></strong></label><br>
		<textarea id="satlantas-informasi-deskripsi" name="satlantas_informasi_lalu_lintas[deskripsi]" class="widefat" rows="6"><?php echo esc_textarea( $deskripsi ); ?></textarea>
	</p>
	<p>
		<label for="satlantas-informasi-urutan"><strong><?php esc_html_e( 'Urutan Tampil', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-informasi-urutan" type="number" min="0" step="1" name="satlantas_informasi_lalu_lintas[urutan_tampil]" value="<?php echo esc_attr( $urutan_tampil ); ?>" class="small-text" placeholder="1">
	</p>
	<p>
		<label for="satlantas-informasi-status"><strong><?php esc_html_e( 'Status', 'satlantas-ponorogo' ); ?></strong></label><br>
		<select id="satlantas-informasi-status" name="satlantas_informasi_lalu_lintas[status]" class="widefat">
			<option value="aktif" <?php selected( $status, 'aktif' ); ?>><?php esc_html_e( 'Aktif', 'satlantas-ponorogo' ); ?></option>
			<option value="nonaktif" <?php selected( $status, 'nonaktif' ); ?>><?php esc_html_e( 'Nonaktif', 'satlantas-ponorogo' ); ?></option>
		</select>
	</p>
	<?php
}

/**
 * Saves traffic information metadata.
 *
 * @param int $post_id Current post ID.
 */
function satlantas_save_informasi_lalu_lintas_meta( $post_id ) {
	if (
		! isset( $_POST['satlantas_informasi_lalu_lintas_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['satlantas_informasi_lalu_lintas_nonce'] ) ), 'satlantas_save_informasi_lalu_lintas_meta' )
	) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$fields = isset( $_POST['satlantas_informasi_lalu_lintas'] ) ? (array) wp_unslash( $_POST['satlantas_informasi_lalu_lintas'] ) : array();

	$sanitized = array(
		'kategori'      => isset( $fields['kategori'] ) ? sanitize_key( $fields['kategori'] ) : 'informasi',
		'deskripsi'     => isset( $fields['deskripsi'] ) ? wp_kses_post( $fields['deskripsi'] ) : '',
		'urutan_tampil' => isset( $fields['urutan_tampil'] ) ? absint( $fields['urutan_tampil'] ) : 0,
		'status'        => ( isset( $fields['status'] ) && 'nonaktif' === $fields['status'] ) ? 'nonaktif' : 'aktif',
	);

	$allowed_categories = array( 'macet', 'padat_merayap', 'hati_hati', 'informasi' );

	if ( ! in_array( $sanitized['kategori'], $allowed_categories, true ) ) {
		$sanitized['kategori'] = 'informasi';
	}

	foreach ( $sanitized as $key => $value ) {
		update_post_meta( $post_id, $key, $value );
	}
}
add_action( 'save_post_informasi_lalu_lintas', 'satlantas_save_informasi_lalu_lintas_meta' );

/**
 * Returns the formatted traffic information category badge.
 *
 * @param string $kategori Category key.
 * @return array
 */
function satlantas_get_informasi_lalu_lintas_category_badge( $kategori ) {
	$badges = array(
		'macet'          => array(
			'label' => esc_html__( 'Macet', 'satlantas-ponorogo' ),
			'class' => 'traffic-status--danger',
		),
		'padat_merayap'  => array(
			'label' => esc_html__( 'Padat Merayap', 'satlantas-ponorogo' ),
			'class' => 'traffic-status--warning',
		),
		'hati_hati'      => array(
			'label' => esc_html__( 'Hati-hati', 'satlantas-ponorogo' ),
			'class' => 'traffic-status--info',
		),
		'informasi'      => array(
			'label' => esc_html__( 'Informasi', 'satlantas-ponorogo' ),
			'class' => 'traffic-status--neutral',
		),
	);

	return $badges[ $kategori ] ?? $badges['informasi'];
}

/**
 * Returns the display description for a traffic information item.
 *
 * @param int|WP_Post|null $post Optional post object or ID. Defaults to current post.
 * @return string
 */
function satlantas_get_informasi_lalu_lintas_description( $post = null ) {
	$post = get_post( $post );

	if ( ! $post || 'informasi_lalu_lintas' !== $post->post_type ) {
		return '';
	}

	$deskripsi = get_post_meta( $post->ID, 'deskripsi', true );

	if ( $deskripsi ) {
		return wp_kses_post( $deskripsi );
	}

	return wp_kses_post( get_the_content( null, false, $post ) );
}

/**
 * Returns active traffic information ordered by newest publish date.
 *
 * @param int $posts_per_page Number of items to fetch.
 * @return WP_Query
 */
function satlantas_get_active_informasi_lalu_lintas( $posts_per_page = 4 ) {
	return new WP_Query(
		array(
			'post_type'      => 'informasi_lalu_lintas',
			'posts_per_page' => $posts_per_page,
			'orderby'        => array(
				'date' => 'DESC',
			),
			'meta_query'     => array(
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
 * Makes the traffic information archive show active items first.
 *
 * @param WP_Query $query Current query object.
 */
function satlantas_order_informasi_lalu_lintas_archive( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'informasi_lalu_lintas' ) ) {
		return;
	}

	$query->set( 'posts_per_page', 10 );
	$query->set(
		'orderby',
		array(
			'date' => 'DESC',
		)
	);
	$query->set(
		'meta_query',
		array(
			array(
				'key'     => 'status',
				'value'   => 'aktif',
				'compare' => '=',
			),
		)
	);
}
add_action( 'pre_get_posts', 'satlantas_order_informasi_lalu_lintas_archive' );

/**
 * Registers found vehicles managed from the WordPress dashboard.
 */
function satlantas_register_kendaraan_temuan_post_type() {
	register_post_type(
		'kendaraan_temuan',
		array(
			'labels'       => array(
				'name'               => esc_html__( 'Kendaraan Temuan', 'satlantas-ponorogo' ),
				'singular_name'      => esc_html__( 'Kendaraan Temuan', 'satlantas-ponorogo' ),
				'menu_name'          => esc_html__( 'Kendaraan Temuan', 'satlantas-ponorogo' ),
				'add_new_item'       => esc_html__( 'Tambah Kendaraan Temuan', 'satlantas-ponorogo' ),
				'edit_item'          => esc_html__( 'Edit Kendaraan Temuan', 'satlantas-ponorogo' ),
				'new_item'           => esc_html__( 'Kendaraan Temuan Baru', 'satlantas-ponorogo' ),
				'view_item'          => esc_html__( 'Lihat Kendaraan Temuan', 'satlantas-ponorogo' ),
				'search_items'       => esc_html__( 'Cari Kendaraan Temuan', 'satlantas-ponorogo' ),
				'not_found'          => esc_html__( 'Belum ada kendaraan temuan.', 'satlantas-ponorogo' ),
				'not_found_in_trash' => esc_html__( 'Tidak ada kendaraan temuan di sampah.', 'satlantas-ponorogo' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'menu_icon'    => 'dashicons-car',
			'rewrite'      => array( 'slug' => 'kendaraan-temuan' ),
			'supports'     => array( 'title', 'thumbnail' ),
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'satlantas_register_kendaraan_temuan_post_type' );

/**
 * Flushes rewrite rules once after vehicle findings are added.
 */
function satlantas_maybe_flush_kendaraan_temuan_rewrites() {
	$rewrite_version = 'kendaraan-temuan-1';

	if ( get_option( 'satlantas_kendaraan_temuan_rewrite_version' ) === $rewrite_version ) {
		return;
	}

	flush_rewrite_rules();
	update_option( 'satlantas_kendaraan_temuan_rewrite_version', $rewrite_version );
}
add_action( 'init', 'satlantas_maybe_flush_kendaraan_temuan_rewrites', 20 );

/**
 * Adds vehicle finding fields to the admin editor.
 */
function satlantas_add_kendaraan_temuan_meta_box() {
	add_meta_box(
		'satlantas_kendaraan_temuan_details',
		esc_html__( 'Detail Kendaraan Temuan', 'satlantas-ponorogo' ),
		'satlantas_render_kendaraan_temuan_meta_box',
		'kendaraan_temuan',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'satlantas_add_kendaraan_temuan_meta_box' );

/**
 * Renders vehicle finding metadata fields.
 *
 * @param WP_Post $post Current Kendaraan Temuan post.
 */
function satlantas_render_kendaraan_temuan_meta_box( $post ) {
	wp_nonce_field( 'satlantas_save_kendaraan_temuan_meta', 'satlantas_kendaraan_temuan_nonce' );

	$nomor_polisi   = get_post_meta( $post->ID, 'nomor_polisi', true );
	$merk_kendaraan = get_post_meta( $post->ID, 'merk_kendaraan', true );
	$jenis_kendaraan = get_post_meta( $post->ID, 'jenis_kendaraan', true );
	$warna          = get_post_meta( $post->ID, 'warna', true );
	$lokasi_temuan  = get_post_meta( $post->ID, 'lokasi_temuan', true );
	$tanggal_temuan = get_post_meta( $post->ID, 'tanggal_temuan', true );
	$status         = get_post_meta( $post->ID, 'status', true ) ?: 'diamankan';
	$kontak_petugas = get_post_meta( $post->ID, 'kontak_petugas', true );
	$nomor_telepon  = get_post_meta( $post->ID, 'nomor_telepon', true );
	?>
	<p>
		<label for="satlantas-kendaraan-nomor-polisi"><strong><?php esc_html_e( 'Nomor Polisi', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-kendaraan-nomor-polisi" type="text" name="satlantas_kendaraan_temuan[nomor_polisi]" value="<?php echo esc_attr( $nomor_polisi ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Contoh: W 1234 AB', 'satlantas-ponorogo' ); ?>">
	</p>
	<p>
		<label for="satlantas-kendaraan-merk"><strong><?php esc_html_e( 'Merk Kendaraan', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-kendaraan-merk" type="text" name="satlantas_kendaraan_temuan[merk_kendaraan]" value="<?php echo esc_attr( $merk_kendaraan ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Contoh: Honda', 'satlantas-ponorogo' ); ?>">
	</p>
	<p>
		<label for="satlantas-kendaraan-jenis"><strong><?php esc_html_e( 'Jenis Kendaraan', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-kendaraan-jenis" type="text" name="satlantas_kendaraan_temuan[jenis_kendaraan]" value="<?php echo esc_attr( $jenis_kendaraan ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Contoh: Sepeda Motor', 'satlantas-ponorogo' ); ?>">
	</p>
	<p>
		<label for="satlantas-kendaraan-warna"><strong><?php esc_html_e( 'Warna', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-kendaraan-warna" type="text" name="satlantas_kendaraan_temuan[warna]" value="<?php echo esc_attr( $warna ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Contoh: Hitam', 'satlantas-ponorogo' ); ?>">
	</p>
	<p>
		<label for="satlantas-kendaraan-lokasi"><strong><?php esc_html_e( 'Lokasi Temuan', 'satlantas-ponorogo' ); ?></strong></label><br>
		<textarea id="satlantas-kendaraan-lokasi" name="satlantas_kendaraan_temuan[lokasi_temuan]" class="widefat" rows="3"><?php echo esc_textarea( $lokasi_temuan ); ?></textarea>
	</p>
	<p>
		<label for="satlantas-kendaraan-tanggal"><strong><?php esc_html_e( 'Tanggal Temuan', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-kendaraan-tanggal" type="date" name="satlantas_kendaraan_temuan[tanggal_temuan]" value="<?php echo esc_attr( $tanggal_temuan ); ?>" class="widefat">
	</p>
	<p>
		<label for="satlantas-kendaraan-status"><strong><?php esc_html_e( 'Status', 'satlantas-ponorogo' ); ?></strong></label><br>
		<select id="satlantas-kendaraan-status" name="satlantas_kendaraan_temuan[status]" class="widefat">
			<option value="diamankan" <?php selected( $status, 'diamankan' ); ?>><?php esc_html_e( 'Diamankan', 'satlantas-ponorogo' ); ?></option>
			<option value="dikembalikan" <?php selected( $status, 'dikembalikan' ); ?>><?php esc_html_e( 'Dikembalikan', 'satlantas-ponorogo' ); ?></option>
		</select>
	</p>
	<p>
		<label for="satlantas-kendaraan-kontak"><strong><?php esc_html_e( 'Kontak Petugas', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-kendaraan-kontak" type="text" name="satlantas_kendaraan_temuan[kontak_petugas]" value="<?php echo esc_attr( $kontak_petugas ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Contoh: AIPTU Nama Petugas', 'satlantas-ponorogo' ); ?>">
	</p>
	<p>
		<label for="satlantas-kendaraan-telepon"><strong><?php esc_html_e( 'Nomor Telepon', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-kendaraan-telepon" type="text" name="satlantas_kendaraan_temuan[nomor_telepon]" value="<?php echo esc_attr( $nomor_telepon ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Contoh: 0812-3456-7890', 'satlantas-ponorogo' ); ?>">
	</p>
	<?php
}

/**
 * Saves vehicle finding metadata.
 *
 * @param int $post_id Current post ID.
 */
function satlantas_save_kendaraan_temuan_meta( $post_id ) {
	if (
		! isset( $_POST['satlantas_kendaraan_temuan_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['satlantas_kendaraan_temuan_nonce'] ) ), 'satlantas_save_kendaraan_temuan_meta' )
	) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$fields = isset( $_POST['satlantas_kendaraan_temuan'] ) ? (array) wp_unslash( $_POST['satlantas_kendaraan_temuan'] ) : array();

	$sanitized = array(
		'nomor_polisi'    => isset( $fields['nomor_polisi'] ) ? sanitize_text_field( $fields['nomor_polisi'] ) : '',
		'merk_kendaraan'  => isset( $fields['merk_kendaraan'] ) ? sanitize_text_field( $fields['merk_kendaraan'] ) : '',
		'jenis_kendaraan' => isset( $fields['jenis_kendaraan'] ) ? sanitize_text_field( $fields['jenis_kendaraan'] ) : '',
		'warna'           => isset( $fields['warna'] ) ? sanitize_text_field( $fields['warna'] ) : '',
		'lokasi_temuan'   => isset( $fields['lokasi_temuan'] ) ? sanitize_textarea_field( $fields['lokasi_temuan'] ) : '',
		'tanggal_temuan'  => isset( $fields['tanggal_temuan'] ) ? sanitize_text_field( $fields['tanggal_temuan'] ) : '',
		'status'          => ( isset( $fields['status'] ) && 'dikembalikan' === $fields['status'] ) ? 'dikembalikan' : 'diamankan',
		'kontak_petugas'  => isset( $fields['kontak_petugas'] ) ? sanitize_text_field( $fields['kontak_petugas'] ) : '',
		'nomor_telepon'   => isset( $fields['nomor_telepon'] ) ? sanitize_text_field( $fields['nomor_telepon'] ) : '',
	);

	foreach ( $sanitized as $key => $value ) {
		update_post_meta( $post_id, $key, $value );
	}
}
add_action( 'save_post_kendaraan_temuan', 'satlantas_save_kendaraan_temuan_meta' );

/**
 * Returns the formatted vehicle finding status badge.
 *
 * @param string $status Status key.
 * @return array
 */
function satlantas_get_kendaraan_temuan_status_badge( $status ) {
	$badges = array(
		'diamankan'    => array(
			'label' => esc_html__( 'Diamankan', 'satlantas-ponorogo' ),
			'class' => 'cpt-badge--success',
		),
		'dikembalikan' => array(
			'label' => esc_html__( 'Dikembalikan', 'satlantas-ponorogo' ),
			'class' => 'cpt-badge--warning',
		),
	);

	return $badges[ $status ] ?? $badges['diamankan'];
}

/**
 * Returns active vehicle findings ordered by newest finding date.
 *
 * @param int $posts_per_page Number of items to fetch.
 * @return WP_Query
 */
function satlantas_get_active_kendaraan_temuan( $posts_per_page = 4 ) {
	return new WP_Query(
		array(
			'post_type'      => 'kendaraan_temuan',
			'post_status'    => 'publish',
			'posts_per_page' => $posts_per_page,
			'meta_key'       => 'tanggal_temuan',
			'orderby'        => array(
				'meta_value' => 'DESC',
				'date'       => 'DESC',
			),
			'meta_type'      => 'DATE',
			'meta_query'     => array(
				array(
					'key'     => 'status',
					'value'   => 'diamankan',
					'compare' => '=',
				),
			),
		)
	);
}

/**
 * Formats vehicle finding dates.
 *
 * @param string $date Date in Y-m-d format.
 * @return string
 */
function satlantas_format_kendaraan_temuan_date( $date ) {
	if ( empty( $date ) ) {
		return '';
	}

	$timestamp = strtotime( $date );

	return $timestamp ? date_i18n( 'd M Y', $timestamp ) : $date;
}

/**
 * Makes the vehicle findings archive show active items first.
 *
 * @param WP_Query $query Current query object.
 */
function satlantas_order_kendaraan_temuan_archive( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'kendaraan_temuan' ) ) {
		return;
	}

	$query->set( 'posts_per_page', 12 );
	$query->set( 'meta_key', 'tanggal_temuan' );
	$query->set(
		'orderby',
		array(
			'meta_value' => 'DESC',
			'date'       => 'DESC',
		)
	);
	$query->set( 'meta_type', 'DATE' );
	$query->set(
		'meta_query',
		array(
			array(
				'key'     => 'status',
				'value'   => 'diamankan',
				'compare' => '=',
			),
		)
	);
}
add_action( 'pre_get_posts', 'satlantas_order_kendaraan_temuan_archive' );

/**
 * Redirects non-public singles to the relevant archive.
 */
function satlantas_redirect_hidden_cpt_singles() {
	if ( ! is_singular( array( 'informasi_lalu_lintas', 'kendaraan_temuan' ) ) ) {
		return;
	}

	$post = get_queried_object();

	if ( ! $post instanceof WP_Post ) {
		return;
	}

	if ( current_user_can( 'edit_post', $post->ID ) ) {
		return;
	}

	$status = get_post_meta( $post->ID, 'status', true );
	$archive_url = '';

	if ( 'informasi_lalu_lintas' === $post->post_type ) {
		if ( 'aktif' === $status ) {
			return;
		}

		$archive_url = get_post_type_archive_link( 'informasi_lalu_lintas' );
	} elseif ( 'kendaraan_temuan' === $post->post_type ) {
		if ( 'diamankan' === $status ) {
			return;
		}

		$archive_url = get_post_type_archive_link( 'kendaraan_temuan' );
	}

	if ( $archive_url ) {
		wp_safe_redirect( $archive_url, 302 );
		exit;
	}
}
add_action( 'template_redirect', 'satlantas_redirect_hidden_cpt_singles' );

/**
 * Registers service locations managed from the WordPress dashboard.
 */
function satlantas_register_lokasi_layanan_post_type() {
	register_post_type(
		'lokasi_layanan',
		array(
			'labels'       => array(
				'name'               => esc_html__( 'Lokasi Layanan', 'satlantas-ponorogo' ),
				'singular_name'      => esc_html__( 'Lokasi Layanan', 'satlantas-ponorogo' ),
				'menu_name'          => esc_html__( 'Lokasi Layanan', 'satlantas-ponorogo' ),
				'add_new_item'       => esc_html__( 'Tambah Lokasi Layanan', 'satlantas-ponorogo' ),
				'edit_item'          => esc_html__( 'Edit Lokasi Layanan', 'satlantas-ponorogo' ),
				'new_item'           => esc_html__( 'Lokasi Layanan Baru', 'satlantas-ponorogo' ),
				'view_item'          => esc_html__( 'Lihat Lokasi Layanan', 'satlantas-ponorogo' ),
				'search_items'       => esc_html__( 'Cari Lokasi Layanan', 'satlantas-ponorogo' ),
				'not_found'          => esc_html__( 'Belum ada lokasi layanan.', 'satlantas-ponorogo' ),
				'not_found_in_trash' => esc_html__( 'Tidak ada lokasi layanan di sampah.', 'satlantas-ponorogo' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'menu_icon'    => 'dashicons-location',
			'rewrite'      => array( 'slug' => 'lokasi-layanan' ),
			'supports'     => array( 'title', 'thumbnail', 'page-attributes' ),
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'satlantas_register_lokasi_layanan_post_type' );

/**
 * Flushes rewrite rules once after Lokasi Layanan is registered.
 */
function satlantas_maybe_flush_lokasi_layanan_rewrites() {
	$rewrite_version = 'lokasi-layanan-1';

	if ( get_option( 'satlantas_lokasi_layanan_rewrite_version' ) === $rewrite_version ) {
		return;
	}

	flush_rewrite_rules();
	update_option( 'satlantas_lokasi_layanan_rewrite_version', $rewrite_version );
}
add_action( 'init', 'satlantas_maybe_flush_lokasi_layanan_rewrites', 20 );

/**
 * Adds service location details to the admin editor.
 */
function satlantas_add_lokasi_layanan_meta_box() {
	add_meta_box(
		'satlantas_lokasi_layanan_details',
		esc_html__( 'Detail Lokasi Layanan', 'satlantas-ponorogo' ),
		'satlantas_render_lokasi_layanan_meta_box',
		'lokasi_layanan',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'satlantas_add_lokasi_layanan_meta_box' );

/**
 * Renders location address, coordinates, maps, hours, phone, and status fields.
 *
 * @param WP_Post $post Current Lokasi Layanan post.
 */
function satlantas_render_lokasi_layanan_meta_box( $post ) {
	wp_nonce_field( 'satlantas_save_lokasi_layanan_meta', 'satlantas_lokasi_layanan_nonce' );

	$alamat          = get_post_meta( $post->ID, 'alamat', true );
	$latitude        = get_post_meta( $post->ID, 'latitude', true );
	$longitude       = get_post_meta( $post->ID, 'longitude', true );
	$maps_url        = get_post_meta( $post->ID, 'maps_url', true );
	$jam_operasional = get_post_meta( $post->ID, 'jam_operasional', true );
	$nomor_telepon   = get_post_meta( $post->ID, 'nomor_telepon', true );
	$status          = get_post_meta( $post->ID, 'status', true ) ?: 'aktif';
	?>
	<p>
		<label for="satlantas-lokasi-alamat"><strong><?php esc_html_e( 'Alamat', 'satlantas-ponorogo' ); ?></strong></label><br>
		<textarea id="satlantas-lokasi-alamat" name="satlantas_lokasi_layanan[alamat]" rows="3" class="widefat"><?php echo esc_textarea( $alamat ); ?></textarea>
	</p>
	<p>
		<label for="satlantas-lokasi-latitude"><strong><?php esc_html_e( 'Latitude', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-lokasi-latitude" type="text" inputmode="decimal" name="satlantas_lokasi_layanan[latitude]" value="<?php echo esc_attr( $latitude ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Contoh: -7.8654', 'satlantas-ponorogo' ); ?>">
	</p>
	<p>
		<label for="satlantas-lokasi-longitude"><strong><?php esc_html_e( 'Longitude', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-lokasi-longitude" type="text" inputmode="decimal" name="satlantas_lokasi_layanan[longitude]" value="<?php echo esc_attr( $longitude ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Contoh: 111.4680', 'satlantas-ponorogo' ); ?>">
	</p>
	<p>
		<label for="satlantas-lokasi-maps-url"><strong><?php esc_html_e( 'Link Google Maps', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-lokasi-maps-url" type="url" name="satlantas_lokasi_layanan[maps_url]" value="<?php echo esc_url( $maps_url ); ?>" class="widefat" placeholder="https://maps.google.com/...">
	</p>
	<p>
		<label for="satlantas-lokasi-jam"><strong><?php esc_html_e( 'Jam Operasional', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-lokasi-jam" type="text" name="satlantas_lokasi_layanan[jam_operasional]" value="<?php echo esc_attr( $jam_operasional ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Contoh: Senin - Jumat, 08.00 - 14.00 WIB', 'satlantas-ponorogo' ); ?>">
	</p>
	<p>
		<label for="satlantas-lokasi-telepon"><strong><?php esc_html_e( 'Nomor Telepon', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-lokasi-telepon" type="text" name="satlantas_lokasi_layanan[nomor_telepon]" value="<?php echo esc_attr( $nomor_telepon ); ?>" class="widefat">
	</p>
	<p>
		<label for="satlantas-lokasi-status"><strong><?php esc_html_e( 'Status', 'satlantas-ponorogo' ); ?></strong></label><br>
		<select id="satlantas-lokasi-status" name="satlantas_lokasi_layanan[status]" class="widefat">
			<option value="aktif" <?php selected( $status, 'aktif' ); ?>><?php esc_html_e( 'Aktif', 'satlantas-ponorogo' ); ?></option>
			<option value="nonaktif" <?php selected( $status, 'nonaktif' ); ?>><?php esc_html_e( 'Nonaktif', 'satlantas-ponorogo' ); ?></option>
		</select>
	</p>
	<?php
}

/**
 * Sanitizes a coordinate meta value for frontend map usage.
 *
 * Keeps signed decimal values only; out-of-range or non-numeric values are saved
 * as empty strings so frontend templates can safely handle incomplete coordinates.
 *
 * @param mixed  $value Coordinate value from the admin form.
 * @param string $type  Coordinate type: latitude or longitude.
 * @return string
 */
function satlantas_sanitize_location_coordinate( $value, $type ) {
	$value = str_replace( ',', '.', sanitize_text_field( $value ) );

	if ( '' === $value || ! is_numeric( $value ) ) {
		return '';
	}

	$coordinate = (float) $value;
	$min        = 'latitude' === $type ? -90 : -180;
	$max        = 'latitude' === $type ? 90 : 180;

	if ( $coordinate < $min || $coordinate > $max ) {
		return '';
	}

	return rtrim( rtrim( number_format( $coordinate, 8, '.', '' ), '0' ), '.' );
}

/**
 * Saves service location metadata.
 *
 * @param int $post_id Current post ID.
 */
function satlantas_save_lokasi_layanan_meta( $post_id ) {
	if (
		! isset( $_POST['satlantas_lokasi_layanan_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['satlantas_lokasi_layanan_nonce'] ) ), 'satlantas_save_lokasi_layanan_meta' )
	) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$fields = isset( $_POST['satlantas_lokasi_layanan'] ) ? (array) wp_unslash( $_POST['satlantas_lokasi_layanan'] ) : array();

	$sanitized = array(
		'alamat'          => isset( $fields['alamat'] ) ? sanitize_textarea_field( $fields['alamat'] ) : '',
		'latitude'        => isset( $fields['latitude'] ) ? satlantas_sanitize_location_coordinate( $fields['latitude'], 'latitude' ) : '',
		'longitude'       => isset( $fields['longitude'] ) ? satlantas_sanitize_location_coordinate( $fields['longitude'], 'longitude' ) : '',
		'maps_url'        => isset( $fields['maps_url'] ) ? esc_url_raw( $fields['maps_url'] ) : '',
		'jam_operasional' => isset( $fields['jam_operasional'] ) ? sanitize_text_field( $fields['jam_operasional'] ) : '',
		'nomor_telepon'   => isset( $fields['nomor_telepon'] ) ? sanitize_text_field( $fields['nomor_telepon'] ) : '',
		'status'          => ( isset( $fields['status'] ) && 'nonaktif' === $fields['status'] ) ? 'nonaktif' : 'aktif',
	);

	foreach ( $sanitized as $key => $value ) {
		update_post_meta( $post_id, $key, $value );
	}
}
add_action( 'save_post_lokasi_layanan', 'satlantas_save_lokasi_layanan_meta' );

/**
 * Returns normalized Lokasi Layanan metadata for frontend templates.
 *
 * Use this helper before rendering map views so templates have one stable
 * shape for address, coordinates, maps URL, hours, phone, and status.
 *
 * @param int|WP_Post|null $post Optional post object or ID. Defaults to current post.
 * @return array
 */
function satlantas_get_location_layanan_meta( $post = null ) {
	$post = get_post( $post );

	if ( ! $post || 'lokasi_layanan' !== $post->post_type ) {
		return array();
	}

	$latitude  = get_post_meta( $post->ID, 'latitude', true );
	$longitude = get_post_meta( $post->ID, 'longitude', true );

	return array(
		'alamat'          => get_post_meta( $post->ID, 'alamat', true ),
		'latitude'        => $latitude,
		'longitude'       => $longitude,
		'has_coordinates' => '' !== $latitude && '' !== $longitude,
		'maps_url'        => get_post_meta( $post->ID, 'maps_url', true ),
		'jam_operasional' => get_post_meta( $post->ID, 'jam_operasional', true ),
		'nomor_telepon'   => get_post_meta( $post->ID, 'nomor_telepon', true ),
		'status'          => get_post_meta( $post->ID, 'status', true ) ?: 'aktif',
	);
}

/**
 * Returns active service locations ordered for public display.
 *
 * @param int $posts_per_page Number of locations to fetch.
 * @return WP_Query
 */
function satlantas_get_active_locations( $posts_per_page = -1 ) {
	return new WP_Query(
		array(
			'post_type'      => 'lokasi_layanan',
			'posts_per_page' => $posts_per_page,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'date'       => 'DESC',
			),
			'meta_query'     => array(
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
 * Returns active service locations as normalized data for map templates.
 *
 * This keeps the WP_Query helper intact for archives/cards while giving map
 * views a ready-to-encode array with address and coordinate data included.
 *
 * @param int  $posts_per_page      Number of locations to fetch.
 * @param bool $coordinates_only    Whether to return only locations with both coordinates.
 * @return array
 */
function satlantas_get_active_location_layanan_data( $posts_per_page = -1, $coordinates_only = false ) {
	$locations_query = satlantas_get_active_locations( $posts_per_page );
	$locations       = array();

	foreach ( $locations_query->posts as $location ) {
		$meta = satlantas_get_location_layanan_meta( $location );

		if ( $coordinates_only && empty( $meta['has_coordinates'] ) ) {
			continue;
		}

		$locations[] = array(
			'id'        => $location->ID,
			'title'     => get_the_title( $location ),
			'permalink' => get_permalink( $location ),
			'meta'      => $meta,
		);
	}

	wp_reset_postdata();

	return $locations;
}

/**
 * Makes the Lokasi Layanan archive show active locations in dashboard order.
 *
 * @param WP_Query $query Current query object.
 */
function satlantas_order_lokasi_layanan_archive( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'lokasi_layanan' ) ) {
		return;
	}

	$query->set( 'posts_per_page', 12 );
	$query->set(
		'orderby',
		array(
			'menu_order' => 'ASC',
			'date'       => 'DESC',
		)
	);
	$query->set(
		'meta_query',
		array(
			array(
				'key'     => 'status',
				'value'   => 'aktif',
				'compare' => '=',
			),
		)
	);
}
add_action( 'pre_get_posts', 'satlantas_order_lokasi_layanan_archive' );

/**
 * Registers organizational structure managed from the WordPress dashboard.
 */
function satlantas_register_struktur_organisasi_post_type() {
	register_post_type(
		'struktur_organisasi',
		array(
			'labels'       => array(
				'name'               => esc_html__( 'Struktur Organisasi', 'satlantas-ponorogo' ),
				'singular_name'      => esc_html__( 'Struktur Organisasi', 'satlantas-ponorogo' ),
				'menu_name'          => esc_html__( 'Struktur Organisasi', 'satlantas-ponorogo' ),
				'add_new_item'       => esc_html__( 'Tambah Struktur Organisasi', 'satlantas-ponorogo' ),
				'edit_item'          => esc_html__( 'Edit Struktur Organisasi', 'satlantas-ponorogo' ),
				'new_item'           => esc_html__( 'Struktur Organisasi Baru', 'satlantas-ponorogo' ),
				'view_item'          => esc_html__( 'Lihat Struktur Organisasi', 'satlantas-ponorogo' ),
				'search_items'       => esc_html__( 'Cari Struktur Organisasi', 'satlantas-ponorogo' ),
				'not_found'          => esc_html__( 'Belum ada data struktur organisasi.', 'satlantas-ponorogo' ),
				'not_found_in_trash' => esc_html__( 'Tidak ada data struktur organisasi di sampah.', 'satlantas-ponorogo' ),
			),
			'public'       => true,
			'has_archive'  => false,
			'menu_icon'    => 'dashicons-groups',
			'rewrite'      => array( 'slug' => 'struktur-organisasi' ),
			'supports'     => array( 'title', 'thumbnail' ),
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'satlantas_register_struktur_organisasi_post_type' );

/**
 * Adds organization structure fields to the admin editor.
 */
function satlantas_add_struktur_organisasi_meta_box() {
	add_meta_box(
		'satlantas_struktur_organisasi_details',
		esc_html__( 'Detail Struktur Organisasi', 'satlantas-ponorogo' ),
		'satlantas_render_struktur_organisasi_meta_box',
		'struktur_organisasi',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'satlantas_add_struktur_organisasi_meta_box' );

/**
 * Renders organizational role, officer name, order, status, and photo note.
 *
 * @param WP_Post $post Current Struktur Organisasi post.
 */
function satlantas_render_struktur_organisasi_meta_box( $post ) {
	wp_nonce_field( 'satlantas_save_struktur_organisasi_meta', 'satlantas_struktur_organisasi_nonce' );

	$nama_jabatan = get_post_meta( $post->ID, 'nama_jabatan', true );
	$nama_pejabat = get_post_meta( $post->ID, 'nama_pejabat', true );
	$urutan       = get_post_meta( $post->ID, 'urutan', true );
	$status       = get_post_meta( $post->ID, 'status', true ) ?: 'aktif';
	?>
	<p>
		<label for="satlantas-struktur-jabatan"><strong><?php esc_html_e( 'Nama Jabatan', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-struktur-jabatan" type="text" name="satlantas_struktur_organisasi[nama_jabatan]" value="<?php echo esc_attr( $nama_jabatan ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Contoh: Kasat Lantas', 'satlantas-ponorogo' ); ?>">
	</p>
	<p>
		<label for="satlantas-struktur-pejabat"><strong><?php esc_html_e( 'Nama Pejabat', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-struktur-pejabat" type="text" name="satlantas_struktur_organisasi[nama_pejabat]" value="<?php echo esc_attr( $nama_pejabat ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Contoh: AKP Nama Lengkap', 'satlantas-ponorogo' ); ?>">
	</p>
	<p>
		<label for="satlantas-struktur-urutan"><strong><?php esc_html_e( 'Urutan', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-struktur-urutan" type="number" min="0" step="1" name="satlantas_struktur_organisasi[urutan]" value="<?php echo esc_attr( $urutan ); ?>" class="small-text" placeholder="1">
	</p>
	<p>
		<label for="satlantas-struktur-status"><strong><?php esc_html_e( 'Status Aktif', 'satlantas-ponorogo' ); ?></strong></label><br>
		<select id="satlantas-struktur-status" name="satlantas_struktur_organisasi[status]" class="widefat">
			<option value="aktif" <?php selected( $status, 'aktif' ); ?>><?php esc_html_e( 'Aktif', 'satlantas-ponorogo' ); ?></option>
			<option value="nonaktif" <?php selected( $status, 'nonaktif' ); ?>><?php esc_html_e( 'Nonaktif', 'satlantas-ponorogo' ); ?></option>
		</select>
	</p>
	<p>
		<strong><?php esc_html_e( 'Foto', 'satlantas-ponorogo' ); ?></strong><br>
		<span class="description"><?php esc_html_e( 'Gunakan Featured Image untuk foto pejabat. Foto akan ditampilkan otomatis di halaman Profil.', 'satlantas-ponorogo' ); ?></span>
	</p>
	<?php
}

/**
 * Saves organizational structure metadata.
 *
 * @param int $post_id Current post ID.
 */
function satlantas_save_struktur_organisasi_meta( $post_id ) {
	if (
		! isset( $_POST['satlantas_struktur_organisasi_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['satlantas_struktur_organisasi_nonce'] ) ), 'satlantas_save_struktur_organisasi_meta' )
	) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$fields = isset( $_POST['satlantas_struktur_organisasi'] ) ? (array) wp_unslash( $_POST['satlantas_struktur_organisasi'] ) : array();

	$sanitized = array(
		'nama_jabatan' => isset( $fields['nama_jabatan'] ) ? sanitize_text_field( $fields['nama_jabatan'] ) : '',
		'nama_pejabat' => isset( $fields['nama_pejabat'] ) ? sanitize_text_field( $fields['nama_pejabat'] ) : '',
		'urutan'       => isset( $fields['urutan'] ) ? absint( $fields['urutan'] ) : 0,
		'status'       => ( isset( $fields['status'] ) && 'nonaktif' === $fields['status'] ) ? 'nonaktif' : 'aktif',
	);

	foreach ( $sanitized as $key => $value ) {
		update_post_meta( $post_id, $key, $value );
	}
}
add_action( 'save_post_struktur_organisasi', 'satlantas_save_struktur_organisasi_meta' );

/**
 * Returns active organizational structure items ordered by custom order.
 *
 * @param int $posts_per_page Number of items to fetch.
 * @return WP_Query
 */
function satlantas_get_active_struktur_organisasi( $posts_per_page = -1 ) {
	return new WP_Query(
		array(
			'post_type'      => 'struktur_organisasi',
			'posts_per_page' => $posts_per_page,
			'meta_key'       => 'urutan',
			'orderby'        => array(
				'meta_value_num' => 'ASC',
				'title'          => 'ASC',
			),
			'meta_query'     => array(
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
 * Registers regulations managed from the WordPress dashboard.
 */
function satlantas_register_regulasi_post_type() {
	register_post_type(
		'regulasi',
		array(
			'labels'       => array(
				'name'               => esc_html__( 'Regulasi', 'satlantas-ponorogo' ),
				'singular_name'      => esc_html__( 'Regulasi', 'satlantas-ponorogo' ),
				'menu_name'          => esc_html__( 'Regulasi', 'satlantas-ponorogo' ),
				'add_new_item'       => esc_html__( 'Tambah Regulasi', 'satlantas-ponorogo' ),
				'edit_item'          => esc_html__( 'Edit Regulasi', 'satlantas-ponorogo' ),
				'new_item'           => esc_html__( 'Regulasi Baru', 'satlantas-ponorogo' ),
				'view_item'          => esc_html__( 'Lihat Regulasi', 'satlantas-ponorogo' ),
				'search_items'       => esc_html__( 'Cari Regulasi', 'satlantas-ponorogo' ),
				'not_found'          => esc_html__( 'Belum ada regulasi.', 'satlantas-ponorogo' ),
				'not_found_in_trash' => esc_html__( 'Tidak ada regulasi di sampah.', 'satlantas-ponorogo' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'menu_icon'    => 'dashicons-media-document',
			'rewrite'      => array( 'slug' => 'arsip-regulasi' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'satlantas_register_regulasi_post_type' );

/**
 * Flushes rewrite rules after the regulations archive is registered.
 */
function satlantas_flush_regulasi_rewrites() {
	satlantas_register_regulasi_post_type();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'satlantas_flush_regulasi_rewrites' );

/**
 * Flushes rewrite rules once after the regulations feature is added.
 */
function satlantas_maybe_flush_regulasi_rewrites() {
	$rewrite_version = 'regulasi-1';

	if ( get_option( 'satlantas_regulasi_rewrite_version' ) === $rewrite_version ) {
		return;
	}

	flush_rewrite_rules();
	update_option( 'satlantas_regulasi_rewrite_version', $rewrite_version );
}
add_action( 'init', 'satlantas_maybe_flush_regulasi_rewrites', 20 );

/**
 * Adds regulation details to the admin editor.
 */
function satlantas_add_regulasi_meta_box() {
	add_meta_box(
		'satlantas_regulasi_details',
		esc_html__( 'Detail Regulasi', 'satlantas-ponorogo' ),
		'satlantas_render_regulasi_meta_box',
		'regulasi',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'satlantas_add_regulasi_meta_box' );

/**
 * Renders regulation metadata fields.
 *
 * @param WP_Post $post Current Regulasi post.
 */
function satlantas_render_regulasi_meta_box( $post ) {
	wp_nonce_field( 'satlantas_save_regulasi_meta', 'satlantas_regulasi_nonce' );

	$nomor_regulasi   = get_post_meta( $post->ID, 'nomor_regulasi', true );
	$tanggal_regulasi = get_post_meta( $post->ID, 'tanggal_regulasi', true );
	$kategori_regulasi = get_post_meta( $post->ID, 'kategori_regulasi', true );
	$file_pdf         = get_post_meta( $post->ID, 'file_pdf', true );
	$status           = get_post_meta( $post->ID, 'status', true ) ?: 'aktif';
	?>
	<p>
		<label for="satlantas-regulasi-nomor"><strong><?php esc_html_e( 'Nomor Regulasi', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-regulasi-nomor" type="text" name="satlantas_regulasi[nomor_regulasi]" value="<?php echo esc_attr( $nomor_regulasi ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Contoh: 12/2026', 'satlantas-ponorogo' ); ?>">
	</p>
	<p>
		<label for="satlantas-regulasi-tanggal"><strong><?php esc_html_e( 'Tanggal Regulasi', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-regulasi-tanggal" type="date" name="satlantas_regulasi[tanggal_regulasi]" value="<?php echo esc_attr( $tanggal_regulasi ); ?>" class="widefat">
	</p>
	<p>
		<label for="satlantas-regulasi-kategori"><strong><?php esc_html_e( 'Kategori Regulasi', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-regulasi-kategori" type="text" name="satlantas_regulasi[kategori_regulasi]" value="<?php echo esc_attr( $kategori_regulasi ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Contoh: Surat Edaran', 'satlantas-ponorogo' ); ?>">
	</p>
	<p>
		<label for="satlantas-regulasi-pdf"><strong><?php esc_html_e( 'File PDF', 'satlantas-ponorogo' ); ?></strong></label><br>
		<input id="satlantas-regulasi-pdf" type="url" name="satlantas_regulasi[file_pdf]" value="<?php echo esc_url( $file_pdf ); ?>" class="widefat" placeholder="https://.../dokumen.pdf">
	</p>
	<p>
		<label for="satlantas-regulasi-status"><strong><?php esc_html_e( 'Status Aktif', 'satlantas-ponorogo' ); ?></strong></label><br>
		<select id="satlantas-regulasi-status" name="satlantas_regulasi[status]" class="widefat">
			<option value="aktif" <?php selected( $status, 'aktif' ); ?>><?php esc_html_e( 'Aktif', 'satlantas-ponorogo' ); ?></option>
			<option value="nonaktif" <?php selected( $status, 'nonaktif' ); ?>><?php esc_html_e( 'Nonaktif', 'satlantas-ponorogo' ); ?></option>
		</select>
	</p>
	<?php
}

/**
 * Saves regulation metadata.
 *
 * @param int $post_id Current post ID.
 */
function satlantas_save_regulasi_meta( $post_id ) {
	if (
		! isset( $_POST['satlantas_regulasi_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['satlantas_regulasi_nonce'] ) ), 'satlantas_save_regulasi_meta' )
	) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$fields = isset( $_POST['satlantas_regulasi'] ) ? (array) wp_unslash( $_POST['satlantas_regulasi'] ) : array();

	$sanitized = array(
		'nomor_regulasi'   => isset( $fields['nomor_regulasi'] ) ? sanitize_text_field( $fields['nomor_regulasi'] ) : '',
		'tanggal_regulasi' => isset( $fields['tanggal_regulasi'] ) ? sanitize_text_field( $fields['tanggal_regulasi'] ) : '',
		'kategori_regulasi' => isset( $fields['kategori_regulasi'] ) ? sanitize_text_field( $fields['kategori_regulasi'] ) : '',
		'file_pdf'         => isset( $fields['file_pdf'] ) ? esc_url_raw( $fields['file_pdf'] ) : '',
		'status'           => ( isset( $fields['status'] ) && 'nonaktif' === $fields['status'] ) ? 'nonaktif' : 'aktif',
	);

	foreach ( $sanitized as $key => $value ) {
		update_post_meta( $post_id, $key, $value );
	}
}
add_action( 'save_post_regulasi', 'satlantas_save_regulasi_meta' );

/**
 * Returns active regulations ordered by newest regulation date.
 *
 * @param int $posts_per_page Number of items to fetch.
 * @return WP_Query
 */
function satlantas_get_active_regulasi( $posts_per_page = 10 ) {
	return new WP_Query(
		array(
			'post_type'      => 'regulasi',
			'posts_per_page' => $posts_per_page,
			'meta_key'       => 'tanggal_regulasi',
			'orderby'        => array(
				'meta_value' => 'DESC',
				'date'       => 'DESC',
			),
			'meta_type'      => 'DATE',
			'meta_query'     => array(
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
 * Formats regulation dates.
 *
 * @param string $date Date in Y-m-d format.
 * @return string
 */
function satlantas_format_regulasi_date( $date ) {
	if ( empty( $date ) ) {
		return '';
	}

	$timestamp = strtotime( $date );

	return $timestamp ? date_i18n( 'd M Y', $timestamp ) : $date;
}

/**
 * Makes the regulations archive show active items first.
 *
 * @param WP_Query $query Current query object.
 */
function satlantas_order_regulasi_archive( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'regulasi' ) ) {
		return;
	}

	$query->set( 'posts_per_page', 10 );
	$query->set( 'meta_key', 'tanggal_regulasi' );
	$query->set(
		'orderby',
		array(
			'meta_value' => 'DESC',
			'date'       => 'DESC',
		)
	);
	$query->set( 'meta_type', 'DATE' );
	$query->set(
		'meta_query',
		array(
			array(
				'key'     => 'status',
				'value'   => 'aktif',
				'compare' => '=',
			),
		)
	);
}
add_action( 'pre_get_posts', 'satlantas_order_regulasi_archive' );
