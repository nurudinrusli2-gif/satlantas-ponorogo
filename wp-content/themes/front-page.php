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
					<em>Akses Layanan <span aria-hidden="true">→</span></em>
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
			<a class="button-primary" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/berita/' ) ); ?>">Lihat Semua</a>
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
							<h3><a href="#"><?php echo esc_html( $item['title'] ); ?></a></h3>
							<p>Kegiatan patroli rutin untuk menjaga keamanan dan ketertiban lalu lintas.</p>
							<a class="read-more" href="#">Selengkapnya</a>
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
		<p class="section-eyebrow">Layanan</p>
		<h2 id="public-title">Publik</h2>
		<div class="public-grid">
			<?php
			$public_services = array(
				array( 'e-TBPKB', 'Cek & Pendaftaran BPKB Kendaraan', 'paper' ),
				array( 'Pengecekan Pajak', 'Cek Pajak Kendaraan Bermotor', 'plate' ),
				array( 'Info Tilang', 'Informasi terkait tilang', 'info' ),
				array( 'Jadwal SIM Keliling', 'Jadwal dan Lokasi SIM Keliling', 'clock' ),
				array( 'Bantuan Polisi', 'Layanan Bantuan Bermotor', 'call' ),
				array( 'Bantuan Polisi', 'Layanan Bantuan Polisi 24 Jam', 'phone' ),
			);
			foreach ( $public_services as $index => $service ) :
				$public_url = 'Jadwal SIM Keliling' === $service[0] ? get_post_type_archive_link( 'sim_keliling' ) : '#';
				?>
				<a class="public-card" href="<?php echo esc_url( $public_url ); ?>">
					<b><?php echo esc_html( $index + 1 ); ?></b>
					<span class="public-icon"><?php satlantas_icon( $service[2] ); ?></span>
					<strong><?php echo esc_html( $service[0] ); ?></strong>
					<small><?php echo esc_html( $service[1] ); ?></small>
					<em>Selengkapnya</em>
				</a>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="section sim-keliling-section" aria-labelledby="home-sim-keliling-title">
		<div class="section-head">
			<div>
				<p class="section-eyebrow">Layanan Mobile</p>
				<h2 id="home-sim-keliling-title">Jadwal SIM Keliling</h2>
				<p>Jadwal aktif berikutnya untuk layanan SIM Keliling Satlantas Polres Ponorogo.</p>
			</div>
			<a class="button-primary" href="<?php echo esc_url( get_post_type_archive_link( 'sim_keliling' ) ); ?>">Lihat Semua</a>
		</div>
		<div class="sim-keliling-grid">
			<?php
			// Homepage only shows the next three active schedules.
			$home_sim_keliling_query = satlantas_get_upcoming_sim_keliling( 3 );
			?>
			<?php if ( $home_sim_keliling_query->have_posts() ) : ?>
				<?php while ( $home_sim_keliling_query->have_posts() ) : $home_sim_keliling_query->the_post(); ?>
					<?php
					$tanggal  = get_post_meta( get_the_ID(), 'tanggal', true );
					$jam      = get_post_meta( get_the_ID(), 'jam', true );
					$alamat   = get_post_meta( get_the_ID(), 'alamat', true );
					$maps_url = get_post_meta( get_the_ID(), 'maps_url', true );
					?>
					<article <?php post_class( 'sim-keliling-card sim-keliling-card--home' ); ?>>
						<time datetime="<?php echo esc_attr( $tanggal ); ?>"><?php echo esc_html( satlantas_format_sim_keliling_date( $tanggal ) ); ?></time>
						<div class="sim-keliling-card__body">
							<h3><?php the_title(); ?></h3>
							<?php if ( $jam ) : ?>
								<p><strong>Jam:</strong> <?php echo esc_html( $jam ); ?></p>
							<?php endif; ?>
							<?php if ( $alamat ) : ?>
								<p><strong>Alamat:</strong> <?php echo esc_html( $alamat ); ?></p>
							<?php endif; ?>
						</div>
						<?php if ( $maps_url ) : ?>
							<a class="button-primary sim-keliling-map" href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener">Lihat Maps</a>
						<?php endif; ?>
					</article>
				<?php endwhile; wp_reset_postdata(); ?>
			<?php else : ?>
				<article class="sim-keliling-empty">
					<p><?php esc_html_e( 'Belum ada jadwal SIM Keliling aktif.', 'satlantas-ponorogo' ); ?></p>
				</article>
			<?php endif; ?>
		</div>
	</section>

	<section class="section locations-section" aria-labelledby="locations-title">
		<p class="section-eyebrow">Peta</p>
		<h2 id="locations-title">Lokasi Layanan</h2>
		<div class="locations-layout">
			<img class="map-image" src="<?php echo satlantas_asset( 'assets/images/service-map.jpg' ); ?>" alt="<?php esc_attr_e( 'Peta lokasi layanan', 'satlantas-ponorogo' ); ?>">
			<div class="location-list">
				<div class="list-head">
					<h3>Daftar Lokasi Pelayanan</h3>
					<a class="button-primary" href="#">Lihat Semua</a>
				</div>
				<?php
				$locations = array(
					'Kantor Satlantas Polres Ponorogo',
					'SAMSAT Ponorogo',
					'Gerai SIM Keliling (Senin-Selasa)',
					'Gerai SAMSAT Keliling (Senin-Selasa)',
					'Gerai SIM Keliling (Senin-Selasa)',
				);
				foreach ( $locations as $location ) :
					?>
					<div class="location-item">
						<div>
							<strong><?php echo esc_html( $location ); ?></strong>
							<p>Jl. Bhayangkara No. 60, Bangunsari, Kec. Ponorogo, Kabupaten Ponorogo, Jawa Timur 63413</p>
						</div>
						<a href="#">Lihat Peta</a>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="section vehicle-section" aria-labelledby="vehicle-title">
		<img class="ilmu-banner" src="<?php echo satlantas_asset( 'assets/images/ilmu-semeru.jpg' ); ?>" alt="<?php esc_attr_e( 'ILMU SEMERU', 'satlantas-ponorogo' ); ?>">
		<div class="vehicle-search">
			<label class="screen-reader-text" for="vehicle-search-input">Cari kendaraan</label>
			<input id="vehicle-search-input" type="search" placeholder="Cari">
			<a class="button-primary" href="#">Lihat Semua</a>
		</div>
		<h2 id="vehicle-title" class="screen-reader-text">Database Kendaraan</h2>
		<div class="vehicle-grid">
			<?php
			$vehicles = array(
				array( 'image' => 'vehicle-motor.jpg', 'number' => 'W 503 GC', 'model' => 'HONDA - Roda Dua' ),
				array( 'image' => 'vehicle-car.jpg', 'number' => 'W 503 DC', 'model' => 'TOYOTA - Roda Empat' ),
				array( 'image' => 'vehicle-red.jpg', 'number' => 'W 501 DC', 'model' => 'HONDA - Roda Empat' ),
				array( 'image' => 'vehicle-motor.jpg', 'number' => 'W 503 GC', 'model' => 'HONDA - Roda Dua' ),
				array( 'image' => 'vehicle-car.jpg', 'number' => 'W 503 DC', 'model' => 'TOYOTA - Roda Empat' ),
			);
			foreach ( $vehicles as $vehicle ) :
				?>
				<article class="vehicle-card">
					<img src="<?php echo satlantas_asset( 'assets/images/' . $vehicle['image'] ); ?>" alt="">
					<strong><?php echo esc_html( $vehicle['number'] ); ?></strong>
					<small><?php echo esc_html( $vehicle['model'] ); ?></small>
					<div class="vehicle-meta">
						<span><b>Lokasi Temuan</b>Polres Ponorogo</span>
						<span><b>Tanggal Temuan</b>24 Mei 2026</span>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="info-center" aria-labelledby="info-title">
		<div class="info-panel">
			<p class="section-eyebrow">Jadwal Layanan</p>
			<h2 id="info-title">Hari ini</h2>
			<div class="schedule-item"><span>SIM Keliling</span><strong>Alun - Alun Ponorogo</strong><p>Jl. Alun-alun Utara, Ponorogo. Jam layanan 08.00 - 12.00 WIB</p></div>
			<div class="schedule-item"><span>Samsat Keliling</span><strong>Terminal Ponorogo</strong><p>Jl. Ir. H Juanda, Ponorogo. Jam layanan 08.00 - 12.00 WIB</p></div>
			<p class="section-eyebrow">Informasi Lalu lintas</p>
			<h2>Terkini</h2>
			<div class="traffic-tags"><span class="tag-red">Macet</span><span class="tag-yellow">Padat Merayap</span><span class="tag-blue">Informasi</span></div>
			<p>Arus kendaraan tetap terpantau. Pengguna jalan diimbau mematuhi rambu dan arahan petugas.</p>
		</div>
		<div class="cctv-panel">
			<div class="section-head compact">
				<div>
					<p class="section-eyebrow">CCTV</p>
					<h2>Lalu lintas</h2>
				</div>
				<a class="button-primary" href="#">Lihat Semua</a>
			</div>
			<div class="cctv-grid">
				<?php for ( $i = 1; $i <= 6; $i++ ) : ?>
					<figure>
						<img src="<?php echo satlantas_asset( 'assets/images/cctv.jpg' ); ?>" alt="<?php echo esc_attr( 'CCTV lalu lintas ' . $i ); ?>">
						<figcaption>Jl. Sudirman</figcaption>
					</figure>
				<?php endfor; ?>
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
			<a class="wide-cta" href="#">Layanan Pengaduan & Info Kecelakaan Lalu Lintas</a>
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
