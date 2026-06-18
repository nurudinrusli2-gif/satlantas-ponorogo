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
					<em>Akses Layanan <span aria-hidden="true">&rarr;</span></em>
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
			array(
				'title'       => 'e-TBPKB',
				'description' => 'Cek & Pendaftaran BPKB Kendaraan',
				'icon'        => '<svg viewBox="0 0 48 48" aria-hidden="true"><path d="M18 10h10l6 6v22H18z"/><path d="M28 10v8h6"/><path d="M22 22h8M22 27h8M22 32h8"/><rect x="13" y="16" width="4" height="16" rx="1.5"/></svg>',
				'url'         => satlantas_page_url_by_slug( 'stnk-bpkb' ),
				'cta'         => 'Buka Layanan BPKB',
				'steps'       => array( 'Siapkan identitas pemilik kendaraan.', 'Siapkan STNK dan dokumen kendaraan.', 'Lihat persyaratan BPKB sebelum mengajukan.' ),
			),
			array(
				'title'       => 'Pengecekan Pajak',
				'description' => 'Cek Pajak Kendaraan Bermotor',
				'icon'        => '<svg viewBox="0 0 48 48" aria-hidden="true"><rect x="13" y="12" width="22" height="24" rx="3"/><path d="M19 17h10M19 22h10M19 27h6"/><path d="M25 30h8"/><path d="M29 12v24"/></svg>',
				'url'         => satlantas_page_url_by_slug( 'stnk-bpkb' ),
				'cta'         => 'Lihat Info Pajak',
				'steps'       => array( 'Siapkan nomor polisi kendaraan.', 'Periksa masa berlaku STNK.', 'Lihat informasi pembayaran dan pengesahan.' ),
			),
			array(
				'title'       => 'Info Tilang',
				'description' => 'Informasi Tilang dan ETLE',
				'icon'        => '<svg viewBox="0 0 48 48" aria-hidden="true"><rect x="16" y="11" width="16" height="24" rx="3"/><path d="M24 18v7"/><circle cx="24" cy="30" r="1.4"/><path d="M12 36h24"/></svg>',
				'url'         => satlantas_page_url_by_slug( 'tilang-etle' ),
				'cta'         => 'Buka Info Tilang',
				'steps'       => array( 'Periksa informasi pelanggaran.', 'Pelajari prosedur konfirmasi ETLE.', 'Ikuti petunjuk penyelesaian tilang.' ),
			),
			array(
				'title'       => 'Jadwal SIM Keliling',
				'description' => 'Jadwal dan Lokasi SIM Keliling',
				'icon'        => '<svg viewBox="0 0 48 48" aria-hidden="true"><path d="M10 29h26"/><path d="M14 29v-7h12l4 4h6v3"/><circle cx="18" cy="33" r="3"/><circle cx="31" cy="33" r="3"/><path d="M22 17v8"/></svg>',
				'url'         => get_post_type_archive_link( 'sim_keliling' ) ?: home_url( '/sim-keliling/' ),
				'cta'         => 'Lihat Jadwal',
				'steps'       => array( 'Pilih jadwal yang masih aktif.', 'Periksa lokasi dan jam pelayanan.', 'Bawa SIM lama serta identitas diri.' ),
			),
			array(
				'title'       => 'Bantuan Kendaraan',
				'description' => 'Bantuan Kendaraan di Jalan',
				'icon'        => '<svg viewBox="0 0 48 48" aria-hidden="true"><circle cx="17" cy="32" r="4"/><circle cx="31" cy="32" r="4"/><path d="M17 32h8l4-8h4"/><path d="M22 20h6l3 4"/><circle cx="23" cy="16" r="2.5"/><path d="M20 24l5-3 3 3"/></svg>',
				'url'         => satlantas_page_url_by_slug( 'kontak' ),
				'cta'         => 'Minta Bantuan',
				'steps'       => array( 'Amankan diri dan kendaraan terlebih dahulu.', 'Catat lokasi serta kondisi kendaraan.', 'Hubungi petugas melalui halaman kontak.' ),
			),
			array(
				'title'       => 'Bantuan Polisi',
				'description' => 'Layanan Bantuan Polisi 24 Jam',
				'icon'        => '<svg viewBox="0 0 48 48" aria-hidden="true"><circle cx="24" cy="15" r="4"/><path d="M17 22c1.5-3 12.5-3 14 0"/><path d="M13 26h22"/><path d="M16 26v9M32 26v9"/><path d="M19 35h10"/></svg>',
				'url'         => satlantas_page_url_by_slug( 'kontak' ),
				'cta'         => 'Hubungi Petugas',
				'steps'       => array( 'Jelaskan jenis bantuan yang dibutuhkan.', 'Sampaikan lokasi kejadian dengan jelas.', 'Ikuti arahan petugas dan tetap tenang.' ),
			),
		);
		foreach ( $public_services as $index => $service ) :
			?>
			<button class="public-card public-service-trigger" type="button" data-service-index="<?php echo esc_attr( $index ); ?>" aria-haspopup="dialog">
				<b><?php echo esc_html( $index + 1 ); ?></b>
				<span class="public-icon"><?php echo $service['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<strong><?php echo esc_html( $service['title'] ); ?></strong>
				<small><?php echo esc_html( $service['description'] ); ?></small>
				<em>Lihat Layanan</em>
			</button>
		<?php endforeach; ?>
	</div>

	<dialog class="public-service-dialog" id="public-service-dialog" aria-labelledby="public-service-dialog-title">
		<button class="public-service-dialog__close" type="button" aria-label="<?php esc_attr_e( 'Tutup panel layanan', 'satlantas-ponorogo' ); ?>">&times;</button>
		<div class="public-service-dialog__icon" aria-hidden="true"></div>
		<p class="public-service-dialog__eyebrow"><?php esc_html_e( 'Layanan Publik', 'satlantas-ponorogo' ); ?></p>
		<h3 id="public-service-dialog-title"></h3>
		<p class="public-service-dialog__description"></p>
		<ol class="public-service-dialog__steps"></ol>
		<a class="public-service-dialog__action" href="#"><?php esc_html_e( 'Buka Layanan', 'satlantas-ponorogo' ); ?></a>
	</dialog>

	<style>
		.public-service-trigger {
			width: 100%;
			font: inherit;
			border: 0;
			cursor: pointer;
		}
		.public-service-trigger:focus-visible {
			outline: 3px solid rgba(15, 141, 244, .3);
			outline-offset: 4px;
		}
		.public-service-dialog {
			width: min(520px, calc(100% - 32px));
			padding: 34px;
			color: #243142;
			background: linear-gradient(145deg, #fff, #f4f9ff);
			border: 1px solid rgba(15, 141, 244, .16);
			border-radius: 24px;
			box-shadow: 0 30px 80px rgba(19, 42, 68, .28);
		}
		.public-service-dialog[open] {
			animation: public-service-in .22s ease-out;
		}
		.public-service-dialog::backdrop {
			background: rgba(11, 24, 39, .62);
			backdrop-filter: blur(5px);
		}
		.public-service-dialog__close {
			position: absolute;
			top: 16px;
			right: 16px;
			display: grid;
			place-items: center;
			width: 38px;
			height: 38px;
			color: #516173;
			background: #edf4fb;
			border: 0;
			border-radius: 50%;
			font-size: 25px;
			cursor: pointer;
		}
		.public-service-dialog__icon {
			display: grid;
			place-items: center;
			width: 68px;
			height: 68px;
			margin-bottom: 20px;
			color: #fff;
			background: linear-gradient(135deg, #0f8df4, #086dcc);
			border-radius: 20px;
			box-shadow: 0 14px 30px rgba(15, 141, 244, .28);
		}
		.public-service-dialog__icon svg {
			width: 38px;
			height: 38px;
			fill: none;
			stroke: currentColor;
			stroke-width: 1.8;
			stroke-linecap: round;
			stroke-linejoin: round;
		}
		.public-service-dialog__eyebrow {
			margin: 0 0 5px;
			color: #0f8df4;
			font-size: 12px;
			font-weight: 800;
			letter-spacing: .12em;
			text-transform: uppercase;
		}
		.public-service-dialog h3 {
			margin: 0;
			font-size: clamp(25px, 5vw, 34px);
			line-height: 1.1;
		}
		.public-service-dialog__description {
			margin: 10px 0 22px;
			color: #657386;
			line-height: 1.6;
		}
		.public-service-dialog__steps {
			display: grid;
			gap: 10px;
			padding: 0;
			margin: 0 0 26px;
			list-style: none;
			counter-reset: service-step;
		}
		.public-service-dialog__steps li {
			display: grid;
			grid-template-columns: 30px 1fr;
			align-items: center;
			gap: 11px;
			padding: 10px 12px;
			background: rgba(255, 255, 255, .78);
			border: 1px solid #e0ebf5;
			border-radius: 12px;
			color: #435267;
			font-size: 14px;
			text-align: left;
			counter-increment: service-step;
		}
		.public-service-dialog__steps li::before {
			display: grid;
			place-items: center;
			width: 30px;
			height: 30px;
			color: #0872d3;
			background: #e4f3ff;
			border-radius: 9px;
			font-size: 12px;
			font-weight: 800;
			content: counter(service-step);
		}
		.public-service-dialog__action {
			display: flex;
			align-items: center;
			justify-content: center;
			min-height: 48px;
			padding: 0 22px;
			color: #fff;
			background: linear-gradient(135deg, #0f8df4, #0872d3);
			border-radius: 13px;
			font-size: 14px;
			font-weight: 800;
			box-shadow: 0 12px 24px rgba(15, 141, 244, .22);
		}
		@keyframes public-service-in {
			from { opacity: 0; transform: translateY(18px) scale(.97); }
			to { opacity: 1; transform: translateY(0) scale(1); }
		}
		@media (max-width: 560px) {
			.public-service-dialog { padding: 28px 20px 22px; border-radius: 20px; }
		}
	</style>

	<script>
		(function () {
			'use strict';

			var services = <?php echo wp_json_encode( array_values( $public_services ) ); ?>;
			var dialog = document.getElementById('public-service-dialog');
			var triggers = document.querySelectorAll('.public-service-trigger');

			if (!dialog || typeof dialog.showModal !== 'function') {
				return;
			}

			var title = dialog.querySelector('#public-service-dialog-title');
			var description = dialog.querySelector('.public-service-dialog__description');
			var icon = dialog.querySelector('.public-service-dialog__icon');
			var steps = dialog.querySelector('.public-service-dialog__steps');
			var action = dialog.querySelector('.public-service-dialog__action');
			var closeButton = dialog.querySelector('.public-service-dialog__close');

			triggers.forEach(function (trigger) {
				trigger.addEventListener('click', function () {
					var service = services[Number(trigger.dataset.serviceIndex)];

					if (!service) {
						return;
					}

					title.textContent = service.title;
					description.textContent = service.description;
					icon.innerHTML = service.icon;
					steps.replaceChildren();

					service.steps.forEach(function (step) {
						var item = document.createElement('li');
						item.textContent = step;
						steps.appendChild(item);
					});

					action.href = service.url;
					action.textContent = service.cta;
					dialog.showModal();
				});
			});

			closeButton.addEventListener('click', function () {
				dialog.close();
			});

			dialog.addEventListener('click', function (event) {
				var bounds = dialog.getBoundingClientRect();
				var isOutside = event.clientX < bounds.left || event.clientX > bounds.right ||
					event.clientY < bounds.top || event.clientY > bounds.bottom;

				if (isOutside) {
					dialog.close();
				}
			});
		}());
	</script>
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
		<div class="vehicle-search" role="search">
			<label class="screen-reader-text" for="vehicle-search-input">Cari kendaraan berdasarkan nomor polisi</label>
			<input id="vehicle-search-input" type="search" placeholder="Cari nomor polisi, contoh: AE 1234 AB" autocomplete="off" aria-controls="vehicle-search-results">
			<a class="button-primary" href="<?php echo esc_url( get_post_type_archive_link( 'kendaraan_temuan' ) ); ?>">Lihat Semua</a>
		</div>
		<p id="vehicle-search-status" class="vehicle-search-status screen-reader-text" aria-live="polite"></p>
		<h2 id="vehicle-title" class="screen-reader-text">Database Kendaraan</h2>
		<div id="vehicle-search-results" class="vehicle-grid">
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
						$service_label = satlantas_get_keliling_service_label( get_the_ID() );
						?>
						<article <?php post_class( 'schedule-card' ); ?>>
							<div class="schedule-card__rail">
								<span class="schedule-card__icon"><?php satlantas_icon( 'clock' ); ?></span>
								<strong><?php echo esc_html( $service_label ); ?></strong>
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
						$summary       = wp_trim_words( wp_strip_all_tags( satlantas_get_informasi_lalu_lintas_description( get_the_ID() ) ), 24, '...' );
						$meta_date     = get_the_date( 'd M Y' );
						?>
						<article <?php post_class( 'traffic-item' ); ?>>
							<div class="traffic-item__top">
								<span
									class="traffic-status traffic-title <?php echo esc_attr( $traffic_badge['class'] ); ?>"
									title="<?php echo esc_attr( $traffic_badge['label'] ); ?>"
								><?php the_title(); ?></span>
								<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( $meta_date ); ?></time>
							</div>
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
