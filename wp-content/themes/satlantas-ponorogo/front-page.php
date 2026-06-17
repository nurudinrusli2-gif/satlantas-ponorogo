<?php
/**
 * Front page template.
 *
 * @package Satlantas_Ponorogo
 */

get_header();


$news_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 4,
		'ignore_sticky_posts' => true,
	)
);

$fallback_news = array(
	array( 'title' => 'Satlantas Polres Ponorogo Gelar Patroli Rutin', 'image' => 'news-traffic.jpg' ),
	array( 'title' => 'Satlantas Polres Ponorogo Edukasi Tertib Lalu Lintas di Sekolah', 'image' => 'news-group.jpg' ),
	array( 'title' => 'Pelayanan SIM Keliling di Beberapa Titik', 'image' => 'news-sim.jpg' ),
	array( 'title' => 'Satlantas Polres Ponorogo Gelar Patroli Rutin', 'image' => 'news-traffic.jpg' ),
);

$posts_page_id = (int) get_option( 'page_for_posts' );
$news_url      = $posts_page_id ? get_permalink( $posts_page_id ) : '';
$news_url      = $news_url ?: home_url( '/berita/' );
?>

<main id="primary" class="site-main front-page">
	<section class="hero-section" aria-labelledby="hero-title">
		<div class="hero-content">
			<p class="hero-kicker">Selamat Datang di</p>
			<h1 id="hero-title">Portal Layanan Satlantas</h1>
			<p class="hero-badge">Polres Ponorogo</p>
			<p class="hero-subtitle">Layanan terintegrasi dengan profesional dan terpercaya untuk masyarakat.</p>
		</div>
		<img class="hero-art" src="<?php echo satlantas_asset( 'assets/images/hero-reog-primary.jpg' ); ?>" alt="<?php esc_attr_e( 'Ilustrasi ikon Ponorogo', 'satlantas-ponorogo' ); ?>">
	</section>

	<section class="section services-section" aria-labelledby="services-title">
		<p class="section-eyebrow">Menu</p>
		<h2 id="services-title">Layanan</h2>
		<div class="service-grid main-service-grid">
			<?php
			$services = array(
				array( 'SIM', 'Pembuatan SIM Baru & Perpanjangan SIM', 'sim', 'sim' ),
				array( 'STNK & BPKB', 'Pengesahan STNK Tahunan', 'paper', 'stnk-bpkb' ),
				array( 'Tilang & ETLE', 'Pengecekan Tilang Elektronik', 'plate', 'tilang-etle' ),
				array( 'Pengaduan', 'Sampaikan Keluhan Anda', 'phone', 'pengaduan' ),
				array( 'Info & Layanan', 'Informasi Lalu Lintas & Layanan Lainnya', 'info', 'info-layanan' ),
			);
			foreach ( $services as $service ) :
				$service_page = get_page_by_path( $service[3] );
				$service_url  = $service_page ? get_permalink( $service_page ) : home_url( '/' . $service[3] . '/' );
				?>
				<a class="service-card" href="<?php echo esc_url( $service_url ); ?>">
					<span class="service-icon"><?php satlantas_icon( $service[2] ); ?></span>
					<strong><?php echo esc_html( $service[0] ); ?></strong>
					<span><?php echo esc_html( $service[1] ); ?></span>
					<em>Akses Layanan <span aria-hidden="true">Ã¢â€ â€™</span></em>
				</a>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="section news-section" aria-labelledby="news-title">
		<div class="section-head">
			<div>
				<p class="section-eyebrow">Berita & Kegiatan</p>
				<h2 id="news-title">Satlantas Polres Ponorogo</h2>
				<p>Hadir dengan informasi, edukasi, dan pelayanan untuk Masyarakat</p>
			</div>
			<a class="button-primary" href="<?php echo esc_url( $news_url ); ?>">Lihat Semua</a>
		</div>
		<div class="news-grid">
			<?php if ( $news_query->have_posts() ) : ?>
				<?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
					<article <?php post_class( 'news-card' ); ?>>
						<a href="<?php the_permalink(); ?>" class="news-thumb">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'medium_large' ); ?>
							<?php else : ?>
								<img src="<?php echo satlantas_asset( 'assets/images/news-traffic.jpg' ); ?>" alt="">
							<?php endif; ?>
						</a>
						<div class="news-body">
							<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date( 'd M Y' ) ); ?></time>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p><?php echo satlantas_excerpt( 15 ); ?></p>
							<a class="read-more" href="<?php the_permalink(); ?>">Selengkapnya</a>
						</div>
					</article>
				<?php endwhile; wp_reset_postdata(); ?>
			<?php else : ?>
				<?php foreach ( $fallback_news as $item ) : ?>
					<article class="news-card">
						<img class="news-thumb" src="<?php echo satlantas_asset( 'assets/images/' . $item['image'] ); ?>" alt="">
						<div class="news-body">
							<time datetime="2026-05-22">22 Mei 2026</time>
							<h3><a href="<?php echo esc_url( $news_url ); ?>"><?php echo esc_html( $item['title'] ); ?></a></h3>
							<p>Kegiatan patroli rutin untuk menjaga keamanan dan ketertiban lalu lintas.</p>
							<a class="read-more" href="<?php echo esc_url( $news_url ); ?>">Selengkapnya</a>
						</div>
					</article>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</section>

	<section class="section announcement-section" aria-labelledby="announcement-title">
		<div class="section-head">
			<div>
				<p class="section-eyebrow">Informasi Resmi</p>
				<h2 id="announcement-title">Pengumuman</h2>
				<p>Informasi terbaru dan pemberitahuan resmi Satlantas Polres Ponorogo.</p>
			</div>
			<a class="button-primary" href="<?php echo esc_url( get_post_type_archive_link( 'pengumuman' ) ); ?>">Lihat Semua</a>
		</div>
		<div class="announcement-grid">
			<?php
			$home_pengumuman_query = satlantas_get_active_pengumuman( 3 );
			?>
			<?php if ( $home_pengumuman_query->have_posts() ) : ?>
				<?php while ( $home_pengumuman_query->have_posts() ) : $home_pengumuman_query->the_post(); ?>
					<?php
					$tanggal_mulai = get_post_meta( get_the_ID(), 'tanggal_mulai', true );
					$prioritas     = get_post_meta( get_the_ID(), 'prioritas', true );
					?>
					<article <?php post_class( 'announcement-card' ); ?>>
						<div class="announcement-card__meta">
							<time datetime="<?php echo esc_attr( $tanggal_mulai ? $tanggal_mulai : get_the_date( 'Y-m-d' ) ); ?>">
								<?php echo esc_html( $tanggal_mulai ? satlantas_format_pengumuman_date( $tanggal_mulai ) : get_the_date( 'd M Y' ) ); ?>
							</time>
							<?php if ( 'tinggi' === $prioritas ) : ?>
								<span><?php esc_html_e( 'Prioritas', 'satlantas-ponorogo' ); ?></span>
							<?php endif; ?>
						</div>
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p><?php echo satlantas_excerpt( 18 ); ?></p>
						<a class="read-more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Selengkapnya', 'satlantas-ponorogo' ); ?></a>
					</article>
				<?php endwhile; wp_reset_postdata(); ?>
			<?php else : ?>
				<article class="announcement-empty">
					<p><?php esc_html_e( 'Belum ada pengumuman aktif saat ini.', 'satlantas-ponorogo' ); ?></p>
				</article>
			<?php endif; ?>
		</div>
	</section>

	<section class="public-services" aria-labelledby="public-title">
		<div class="public-services__header">
			<p class="section-eyebrow">Layanan</p>
			<h2 id="public-title">Publik</h2>
		</div>
		<div class="public-grid">
			<?php
			$public_services = array(
				array( 'e-TBPKB', 'Cek & Pendaftaran BPKB Kendaraan', 'paper', satlantas_page_url_by_slug( 'stnk-bpkb' ) ),
				array( 'Pengecekan Pajak', 'Cek Pajak Kendaraan Bermotor', 'plate', satlantas_page_url_by_slug( 'stnk-bpkb' ) ),
				array( 'Info Tilang', 'Informasi terkait tilang', 'info', satlantas_page_url_by_slug( 'tilang-etle' ) ),
				array( 'Jadwal SIM Keliling', 'Jadwal dan Lokasi SIM Keliling', 'map', get_post_type_archive_link( 'sim_keliling' ) ?: home_url( '/sim-keliling/' ) ),
				array( 'Bantuan Polisi', 'Layanan Bantuan Bermotor', 'call', satlantas_page_url_by_slug( 'kontak' ) ),
				array( 'Bantuan Polisi', 'Layanan Bantuan Polisi 24 Jam', 'support', satlantas_page_url_by_slug( 'kontak' ) ),
			);
			foreach ( $public_services as $index => $service ) :
				?>
				<a class="public-card" href="<?php echo esc_url( $service[3] ); ?>">
					<b><?php echo esc_html( $index + 1 ); ?></b>
					<span class="public-icon"><?php satlantas_icon( $service[2] ); ?></span>
					<strong><?php echo esc_html( $service[0] ); ?></strong>
					<small><?php echo esc_html( $service[1] ); ?></small>
					<em>Selengkapnya</em>
				</a>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="section locations-section" aria-labelledby="locations-title">
		<h2 id="locations-title">Lokasi Layanan</h2>
		<p class="locations-intro">Temukan lokasi layanan Satlantas Polres Ponorogo yang tersedia untuk masyarakat.</p>
		<?php
		$locations         = satlantas_get_active_location_layanan_data( -1, false );
		$selected_location = $locations ? $locations[0] : null;
		$selected_title    = $selected_location ? trim( (string) $selected_location['title'] ) : '';
		$selected_address  = $selected_location && ! empty( $selected_location['meta']['alamat'] ) ? trim( (string) $selected_location['meta']['alamat'] ) : '';
		$selected_heading  = $selected_title ? $selected_title : ( $selected_address ? $selected_address : esc_html__( 'Lokasi Layanan', 'satlantas-ponorogo' ) );
		$selected_summary  = $selected_address && $selected_address !== $selected_heading ? $selected_address : '';
		?>
		<?php if ( $selected_location ) : ?>
			<div class="locations-layout locations-layout--interactive">
				<article class="location-hero-card">
					<div class="location-hero-media">
						<div id="satlantas-service-map" class="location-service-map" role="region" aria-label="<?php esc_attr_e( 'Peta lokasi layanan Satlantas Polres Ponorogo', 'satlantas-ponorogo' ); ?>"></div>
					</div>

					<div class="location-hero-content" data-location-hero>
						<span class="location-hero-label" data-location-field="label"><?php esc_html_e( 'Lokasi Utama', 'satlantas-ponorogo' ); ?></span>
						<h3 data-location-field="title"><?php echo esc_html( $selected_heading ); ?></h3>
						<?php if ( $selected_summary ) : ?>
							<p data-location-field="address"><?php echo esc_html( $selected_summary ); ?></p>
						<?php else : ?>
							<p data-location-field="address" hidden></p>
						<?php endif; ?>
						<div class="location-hero-meta">
							<?php if ( ! empty( $selected_location['meta']['jam_operasional'] ) ) : ?>
								<span data-location-field="hours-wrap">
									<strong><?php esc_html_e( 'Jam Operasional', 'satlantas-ponorogo' ); ?></strong>
									<span data-location-field="hours"><?php echo esc_html( $selected_location['meta']['jam_operasional'] ); ?></span>
								</span>
							<?php else : ?>
								<span data-location-field="hours-wrap" hidden>
									<strong><?php esc_html_e( 'Jam Operasional', 'satlantas-ponorogo' ); ?></strong>
									<span data-location-field="hours"></span>
								</span>
							<?php endif; ?>
							<?php if ( ! empty( $selected_location['meta']['nomor_telepon'] ) ) : ?>
								<span data-location-field="phone-wrap">
									<strong><?php esc_html_e( 'Telepon', 'satlantas-ponorogo' ); ?></strong>
									<span data-location-field="phone"><?php echo esc_html( $selected_location['meta']['nomor_telepon'] ); ?></span>
								</span>
							<?php else : ?>
								<span data-location-field="phone-wrap" hidden>
									<strong><?php esc_html_e( 'Telepon', 'satlantas-ponorogo' ); ?></strong>
									<span data-location-field="phone"></span>
								</span>
							<?php endif; ?>
						</div>
						<?php if ( ! empty( $selected_location['meta']['maps_url'] ) ) : ?>
							<a class="button-primary location-hero-button" data-location-field="maps-link" href="<?php echo esc_url( $selected_location['meta']['maps_url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Lihat Peta', 'satlantas-ponorogo' ); ?></a>
						<?php else : ?>
							<a class="button-primary location-hero-button" data-location-field="maps-link" href="<?php echo esc_url( $selected_location['permalink'] ); ?>"><?php esc_html_e( 'Lihat Peta', 'satlantas-ponorogo' ); ?></a>
						<?php endif; ?>
					</div>
				</article>

				<?php if ( $locations ) : ?>
					<div class="location-list" aria-label="<?php esc_attr_e( 'Lokasi layanan lainnya', 'satlantas-ponorogo' ); ?>">
						<?php foreach ( $locations as $index => $location ) : ?>
							<?php
							$is_active = 0 === $index;
							$meta      = $location['meta'];
							$title     = trim( (string) $location['title'] );
							$address   = ! empty( $meta['alamat'] ) ? trim( (string) $meta['alamat'] ) : '';
							$heading   = $title ? $title : ( $address ? $address : sprintf( esc_html__( 'Lokasi %d', 'satlantas-ponorogo' ), $index + 1 ) );
							$summary   = $address && $address !== $heading ? $address : '';
							?>
							<button
								type="button"
								class="location-item<?php echo $is_active ? ' is-active' : ''; ?>"
								data-location-id="<?php echo esc_attr( $location['id'] ); ?>"
								aria-pressed="<?php echo $is_active ? 'true' : 'false'; ?>"
							>
								<div class="location-item__content">
									<strong><?php echo esc_html( $heading ); ?></strong>
									<?php if ( $summary ) : ?>
										<p><?php echo esc_html( wp_trim_words( $summary, 14, '...' ) ); ?></p>
									<?php endif; ?>
									<?php if ( ! empty( $meta['jam_operasional'] ) ) : ?>
										<small><?php echo esc_html( $meta['jam_operasional'] ); ?></small>
									<?php endif; ?>
								</div>
								<span class="location-item__action"><?php esc_html_e( 'Lihat Peta', 'satlantas-ponorogo' ); ?></span>
							</button>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php else : ?>
			<div class="location-empty location-empty--section">
				<p><?php esc_html_e( 'Data lokasi layanan belum tersedia.', 'satlantas-ponorogo' ); ?></p>
			</div>
		<?php endif; ?>
	</section>

	<section class="section vehicle-section" aria-labelledby="vehicle-title">
		<img class="ilmu-banner" src="<?php echo satlantas_asset( 'assets/images/ilmu-semeru.jpg' ); ?>" alt="<?php esc_attr_e( 'ILMU SEMERU', 'satlantas-ponorogo' ); ?>">
		<div class="vehicle-search">
			<label class="screen-reader-text" for="vehicle-search-input">Cari kendaraan</label>
			<input id="vehicle-search-input" type="search" placeholder="Cari">
			<a class="button-primary" href="<?php echo esc_url( get_post_type_archive_link( 'kendaraan_temuan' ) ); ?>">Lihat Semua</a>
		</div>
		<h2 id="vehicle-title" class="screen-reader-text">Database Kendaraan</h2>
		<div class="vehicle-grid">
			<?php
			$kendaraan_query = satlantas_get_active_kendaraan_temuan( 5 );
			?>
			<?php if ( $kendaraan_query->have_posts() ) : ?>
				<?php while ( $kendaraan_query->have_posts() ) : $kendaraan_query->the_post(); ?>
					<?php
					$nomor_polisi    = get_post_meta( get_the_ID(), 'nomor_polisi', true );
					$merk_kendaraan  = get_post_meta( get_the_ID(), 'merk_kendaraan', true );
					$jenis_kendaraan = get_post_meta( get_the_ID(), 'jenis_kendaraan', true );
					$lokasi_temuan   = get_post_meta( get_the_ID(), 'lokasi_temuan', true );
					$tanggal_temuan  = get_post_meta( get_the_ID(), 'tanggal_temuan', true );
					$status_badge    = satlantas_get_kendaraan_temuan_status_badge( get_post_meta( get_the_ID(), 'status', true ) ?: 'diamankan' );
					$vehicle_title   = $nomor_polisi ? $nomor_polisi : get_the_title();
					$vehicle_model   = trim( $merk_kendaraan . ( $jenis_kendaraan ? ' - ' . $jenis_kendaraan : '' ) );
					?>
					<article <?php post_class( 'vehicle-card' ); ?>>
						<a class="vehicle-card__image" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Lihat detail kendaraan %s', 'satlantas-ponorogo' ), $vehicle_title ) ); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'medium_large' ); ?>
							<?php else : ?>
								<span class="vehicle-card__placeholder"><?php esc_html_e( 'Foto belum tersedia', 'satlantas-ponorogo' ); ?></span>
							<?php endif; ?>
							<span class="vehicle-card__badge <?php echo esc_attr( $status_badge['class'] ); ?>"><?php echo esc_html( $status_badge['label'] ); ?></span>
						</a>
						<strong><a href="<?php the_permalink(); ?>"><?php echo esc_html( $vehicle_title ); ?></a></strong>
						<?php if ( $vehicle_model ) : ?>
							<small><?php echo esc_html( $vehicle_model ); ?></small>
						<?php endif; ?>
						<div class="vehicle-meta">
							<?php if ( $lokasi_temuan ) : ?>
								<span><b><?php esc_html_e( 'Lokasi Temuan', 'satlantas-ponorogo' ); ?></b><?php echo esc_html( wp_trim_words( $lokasi_temuan, 4, '...' ) ); ?></span>
							<?php endif; ?>
							<?php if ( $tanggal_temuan ) : ?>
								<span><b><?php esc_html_e( 'Tanggal Temuan', 'satlantas-ponorogo' ); ?></b><?php echo esc_html( satlantas_format_kendaraan_temuan_date( $tanggal_temuan ) ); ?></span>
							<?php endif; ?>
						</div>
					</article>
				<?php endwhile; wp_reset_postdata(); ?>
			<?php else : ?>
				<article class="kendaraan-empty cpt-empty">
					<span class="cpt-empty__icon"><?php esc_html_e( 'DATA', 'satlantas-ponorogo' ); ?></span>
					<h2><?php esc_html_e( 'Belum ada kendaraan temuan aktif', 'satlantas-ponorogo' ); ?></h2>
					<p><?php esc_html_e( 'Belum ada kendaraan temuan berstatus diamankan saat ini.', 'satlantas-ponorogo' ); ?></p>
				</article>
			<?php endif; ?>
		</div>
	</section>

	<section class="info-center info-center--dashboard" aria-labelledby="info-title">
		<div class="info-panel info-panel--schedule">
			<div class="info-panel__header">
				<p class="section-eyebrow">Jadwal Layanan</p>
				<h2 id="info-title">Hari ini</h2>
				<p>Jadwal aktif SIM Keliling Satlantas Polres Ponorogo yang ditampilkan dari data layanan terbaru.</p>
			</div>
			<div class="schedule-grid">
				<?php
				$home_sim_keliling_query = satlantas_get_upcoming_sim_keliling( 4 );
				?>
				<?php if ( $home_sim_keliling_query->have_posts() ) : ?>
					<?php while ( $home_sim_keliling_query->have_posts() ) : $home_sim_keliling_query->the_post(); ?>
						<?php
						$tanggal  = get_post_meta( get_the_ID(), 'tanggal', true );
						$jam      = get_post_meta( get_the_ID(), 'jam', true );
						$alamat   = get_post_meta( get_the_ID(), 'alamat', true );
						$maps_url = get_post_meta( get_the_ID(), 'maps_url', true );
						$label    = $tanggal && current_time( 'Y-m-d' ) === $tanggal ? 'Hari Ini' : satlantas_format_sim_keliling_date( $tanggal );
						?>
						<article <?php post_class( 'schedule-card' ); ?>>
							<div class="schedule-card__rail">
								<span class="schedule-card__icon"><?php satlantas_icon( 'clock' ); ?></span>
								<strong>SIM Keliling</strong>
							</div>
							<div class="schedule-card__body">
								<div class="schedule-card__top">
									<div>
										<h3><?php the_title(); ?></h3>
										<span class="schedule-card__date"><?php echo esc_html( $label ); ?></span>
									</div>
									<?php if ( $jam ) : ?>
										<time datetime="<?php echo esc_attr( $tanggal ); ?>"><?php echo esc_html( $jam ); ?></time>
									<?php endif; ?>
								</div>
								<?php if ( $alamat ) : ?>
									<p class="schedule-card__address"><?php echo esc_html( $alamat ); ?></p>
								<?php endif; ?>
								<div class="schedule-card__meta">
									<?php if ( $jam ) : ?>
										<span class="schedule-card__chip"><?php echo esc_html( $jam ); ?></span>
									<?php endif; ?>
									<?php if ( $maps_url ) : ?>
										<a class="schedule-card__link" href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener noreferrer">
											<?php esc_html_e( 'Lihat Rute', 'satlantas-ponorogo' ); ?>
											<?php satlantas_icon( 'map' ); ?>
										</a>
									<?php endif; ?>
								</div>
							</div>
						</article>
					<?php endwhile; wp_reset_postdata(); ?>
				<?php else : ?>
					<article class="info-empty">
						<p><?php esc_html_e( 'Belum ada jadwal SIM Keliling aktif.', 'satlantas-ponorogo' ); ?></p>
					</article>
				<?php endif; ?>
			</div>
		</div>
		<div class="info-panel info-panel--traffic">
			<div class="info-panel__header">
				<p class="section-eyebrow">Informasi Lalu Lintas</p>
				<h2>Terkini</h2>
				<p>Ringkasan kondisi dan pengumuman aktif yang siap dipindai cepat oleh masyarakat.</p>
			</div>
			<div class="traffic-list">
				<?php
				$home_traffic_query = satlantas_get_active_informasi_lalu_lintas( 4 );
				?>
				<?php if ( $home_traffic_query->have_posts() ) : ?>
					<?php while ( $home_traffic_query->have_posts() ) : $home_traffic_query->the_post(); ?>
						<?php
						$kategori      = get_post_meta( get_the_ID(), 'kategori', true );
						$urutan_tampil = get_post_meta( get_the_ID(), 'urutan_tampil', true );
						$traffic_badge = satlantas_get_informasi_lalu_lintas_category_badge( $kategori );
						$summary       = wp_trim_words( wp_strip_all_tags( get_the_content( null, false, get_the_ID() ) ), 24, '...' );
						$meta_date     = get_the_date( 'd M Y' );
						?>
						<article <?php post_class( 'traffic-item' ); ?>>
							<div class="traffic-item__top">
								<span class="traffic-status <?php echo esc_attr( $traffic_badge['class'] ); ?>"><?php echo esc_html( $traffic_badge['label'] ); ?></span>
								<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( $meta_date ); ?></time>
							</div>
							<h3><?php the_title(); ?></h3>
							<?php if ( $summary ) : ?>
								<p><?php echo esc_html( $summary ); ?></p>
							<?php endif; ?>
							<?php if ( $urutan_tampil ) : ?>
								<span class="traffic-item__order"><?php echo esc_html( sprintf( __( 'Urutan tampil %s', 'satlantas-ponorogo' ), $urutan_tampil ) ); ?></span>
							<?php endif; ?>
						</article>
					<?php endwhile; wp_reset_postdata(); ?>
				<?php else : ?>
					<article class="info-empty">
						<p><?php esc_html_e( 'Belum ada informasi lalu lintas aktif saat ini.', 'satlantas-ponorogo' ); ?></p>
					</article>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<section class="help-center section" aria-labelledby="help-title">
		<div class="help-cards">
			<p class="section-eyebrow">Informasi</p>
			<h2 id="help-title">Lainnya</h2>
			<div class="help-card-row">
				<div class="help-card"><?php satlantas_icon( 'call' ); ?><strong>110</strong><span>Call Center</span><small>Layanan Polisi 24 Jam Bebas Pulsa</small></div>
				<div class="help-card"><?php satlantas_icon( 'bot' ); ?><strong>Sakti</strong><span>Chat Bot</span><small>Layanan terkait lalu lintas</small></div>
			</div>
			<a class="wide-cta" href="<?php echo esc_url( satlantas_page_url_by_slug( 'pengaduan' ) ); ?>">Layanan Pengaduan & Info Kecelakaan Lalu Lintas</a>
		</div>
		<div class="faq-list">
			<?php
			$faqs = array(
				'Bagaimana cara untuk membuat SIM Baru?',
				'Apa saja syarat untuk memperpanjang SIM?',
				'Apa saja syarat untuk pengurusan STNK Tahunan',
				'Bagaimana jika STNK atau BPKB saya hilang?',
				'Cara konfirmasi ETLE',
				'Apakah perpanjangan STNK tahunan dapat dilakukan selain di Kantor Samsat?',
				'Apa bedanya perpanjangan STNK tahunan dan 5 tahunan?',
				'Apakah bisa memperpanjang SIM yang sudah lewat masa berlakunya?',
			);
			foreach ( $faqs as $faq ) :
				?>
				<details>
					<summary><?php echo esc_html( $faq ); ?></summary>
					<p>Silakan datang ke loket layanan terdekat dengan membawa dokumen identitas dan berkas kendaraan yang diperlukan.</p>
				</details>
			<?php endforeach; ?>
		</div>
	</section>
</main>

<?php
get_footer();
