<?php
/**
 * Template Name: Layanan SIM
 * Template Post Type: page
 *
 * @package Satlantas_Ponorogo
 */
get_header();

while ( have_posts() ) :
	the_post();
?>

<main id="primary" class="site-main sim-page">
	<section class="sim-hero" aria-labelledby="sim-title">
		<div class="sim-hero__content">
			<p class="section-eyebrow">Layanan Satlantas</p>
			<h1 id="sim-title">Layanan SIM</h1>
			<p>Pembuatan SIM baru, perpanjangan SIM, persyaratan, biaya PNBP, dan jadwal pelayanan Satlantas Polres Ponorogo.</p>
			<a class="button-primary sim-cta" href="<?php echo esc_url( home_url( '/kontak/' ) ); ?>">Hubungi Petugas</a>
		</div>
	</section>

	<section class="sim-section" aria-labelledby="sim-services-title">
		<div class="section-head">
			<div>
				<p class="section-eyebrow">Jenis Layanan</p>
				<h2 id="sim-services-title">SIM Baru & Perpanjangan SIM</h2>
			</div>
		</div>
		<div class="sim-card-grid">
			<article class="sim-card">
				<span class="service-icon"><?php satlantas_icon( 'sim' ); ?></span>
				<h3>SIM Baru</h3>
				<p>Layanan penerbitan SIM untuk pemohon yang telah memenuhi persyaratan administrasi, kesehatan, psikologi, dan ujian.</p>
			</article>
			<article class="sim-card">
				<span class="service-icon"><?php satlantas_icon( 'clock' ); ?></span>
				<h3>Perpanjangan SIM</h3>
				<p>Layanan perpanjangan masa berlaku SIM sebelum tanggal kedaluwarsa sesuai ketentuan yang berlaku.</p>
			</article>
		</div>
	</section>

	<section class="sim-section sim-info-layout" aria-label="<?php esc_attr_e( 'Informasi layanan SIM', 'satlantas-ponorogo' ); ?>">
		<article class="sim-panel">
			<p class="section-eyebrow">Dokumen</p>
			<h2>Persyaratan</h2>
			<ul class="sim-list">
				<li>KTP asli dan fotokopi yang masih berlaku.</li>
				<li>Surat keterangan sehat jasmani.</li>
				<li>Surat keterangan psikologi.</li>
				<li>SIM lama untuk layanan perpanjangan.</li>
				<li>Mengisi formulir permohonan di loket pelayanan.</li>
			</ul>
		</article>

		<article class="sim-panel">
			<p class="section-eyebrow">Tarif Resmi</p>
			<h2>Biaya PNBP</h2>
			<div class="sim-fee-list">
				<div><span>SIM A Baru</span><strong>Rp120.000</strong></div>
				<div><span>SIM C Baru</span><strong>Rp100.000</strong></div>
				<div><span>SIM A Perpanjangan</span><strong>Rp80.000</strong></div>
				<div><span>SIM C Perpanjangan</span><strong>Rp75.000</strong></div>
			</div>
		</article>
	</section>

	<section class="sim-section" aria-labelledby="sim-schedule-title">
		<div class="sim-schedule">
			<div>
				<p class="section-eyebrow">Jam Operasional</p>
				<h2 id="sim-schedule-title">Jadwal Pelayanan</h2>
				<p>Datang sesuai jam layanan dan pastikan seluruh berkas sudah lengkap sebelum mengambil nomor antrean.</p>
			</div>
			<div class="sim-schedule__items">
				<div><span>Senin - Jumat</span><strong>08.00 - 14.00 WIB</strong></div>
				<div><span>Sabtu</span><strong>08.00 - 10.30 WIB</strong></div>
				<div><span>Minggu / Hari Libur</span><strong>Tutup</strong></div>
			</div>
		</div>
	</section>

	<section class="sim-section" aria-labelledby="sim-keliling-title">
		<div class="section-head">
			<div>
				<p class="section-eyebrow">Layanan Mobile</p>
				<h2 id="sim-keliling-title">Jadwal SIM Keliling Terdekat</h2>
			</div>
			<a class="button-primary" href="<?php echo esc_url( get_post_type_archive_link( 'sim_keliling' ) ); ?>">Lihat Semua</a>
		</div>
		<div class="sim-keliling-list sim-keliling-list--compact">
			<?php
			// Fetch five active schedules nearest to today for the SIM service page.
			$sim_keliling_query = satlantas_get_upcoming_sim_keliling( 5 );
			?>
			<?php if ( $sim_keliling_query->have_posts() ) : ?>
				<?php while ( $sim_keliling_query->have_posts() ) : $sim_keliling_query->the_post(); ?>
					<?php
					$tanggal  = get_post_meta( get_the_ID(), 'tanggal', true );
					$jam      = get_post_meta( get_the_ID(), 'jam', true );
					$alamat   = get_post_meta( get_the_ID(), 'alamat', true );
					$maps_url = get_post_meta( get_the_ID(), 'maps_url', true );
					?>
					<article <?php post_class( 'sim-keliling-card' ); ?>>
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

	<section class="sim-section sim-contact">
		<div>
			<p class="section-eyebrow">Butuh Bantuan?</p>
			<h2>Petugas siap membantu proses layanan SIM Anda.</h2>
		</div>
		<a class="button-primary sim-cta" href="<?php echo esc_url( home_url( '/kontak/' ) ); ?>">Hubungi Petugas</a>
	</section>
</main>

<?php

endwhile;

get_footer();
