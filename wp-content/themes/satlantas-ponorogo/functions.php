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
 * @param stdClass  $menu  Menu object.
 * @param array     $args  Menu args.
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
 * Renders location address, maps, hours, phone, and status fields.
 *
 * @param WP_Post $post Current Lokasi Layanan post.
 */
function satlantas_render_lokasi_layanan_meta_box( $post ) {
	wp_nonce_field( 'satlantas_save_lokasi_layanan_meta', 'satlantas_lokasi_layanan_nonce' );

	$alamat          = get_post_meta( $post->ID, 'alamat', true );
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
				'title'      => 'ASC',
			),
			'order'          => 'ASC',
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
			'title'      => 'ASC',
		)
	);
	$query->set( 'order', 'ASC' );
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
