<?php
/**
 * Template Name: Pengaduan
 * Template Post Type: page
 *
 * @package Satlantas_Ponorogo
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

<main id="primary" class="site-main pengaduan-page">
	<!-- Hero section. -->
	<section class="pengaduan-hero" aria-labelledby="pengaduan-title">
		<div class="pengaduan-hero__content">
			<p class="section-eyebrow">Pelayanan Masyarakat</p>
			<h1 id="pengaduan-title">Pengaduan Masyarakat</h1>
			<p>Sampaikan keluhan, laporan, saran, dan masukan terkait pelayanan lalu lintas dan angkutan jalan di wilayah Polres Ponorogo.</p>
			<a class="button-primary pengaduan-cta" href="#form-pengaduan">Buat Pengaduan</a>
		</div>
	</section>

	<!-- Complaint type cards. -->
	<section class="pengaduan-section" aria-labelledby="pengaduan-services-title">
		<div class="section-head">
			<div>
				<p class="section-eyebrow">Kategori Laporan</p>
				<h2 id="pengaduan-services-title">Jenis Pengaduan</h2>
			</div>
		</div>
		<div class="pengaduan-card-grid">
			<article class="pengaduan-card">
				<span class="service-icon"><?php satlantas_icon( 'phone' ); ?></span>
				<h3>Keluhan Pelayanan</h3>
				<p>Laporkan kendala dalam proses pelayanan.</p>
			</article>
			<article class="pengaduan-card">
				<span class="service-icon"><?php satlantas_icon( 'plate' ); ?></span>
				<h3>Pelanggaran Lalu Lintas</h3>
				<p>Laporkan pelanggaran yang terjadi di lapangan.</p>
			</article>
			<article class="pengaduan-card">
				<span class="service-icon"><?php satlantas_icon( 'map' ); ?></span>
				<h3>Sarana dan Prasarana</h3>
				<p>Laporkan kerusakan fasilitas lalu lintas.</p>
			</article>
			<article class="pengaduan-card">
				<span class="service-icon"><?php satlantas_icon( 'info' ); ?></span>
				<h3>Saran dan Masukan</h3>
				<p>Berikan masukan untuk peningkatan pelayanan.</p>
			</article>
		</div>
	</section>

	<!-- Complaint guidance and response time. -->
	<section class="pengaduan-section pengaduan-info-layout" aria-label="<?php esc_attr_e( 'Informasi pengaduan masyarakat', 'satlantas-ponorogo' ); ?>">
		<article class="pengaduan-panel">
			<p class="section-eyebrow">Informasi</p>
			<h2>Cara Menyampaikan Pengaduan</h2>
			<ol class="pengaduan-flow-list">
				<li>Siapkan informasi yang lengkap.</li>
				<li>Sertakan lokasi kejadian.</li>
				<li>Sertakan foto atau bukti pendukung jika tersedia.</li>
				<li>Cantumkan nomor kontak yang dapat dihubungi.</li>
				<li>Tunggu proses verifikasi petugas.</li>
			</ol>
		</article>

		<article class="pengaduan-panel">
			<p class="section-eyebrow">SLA</p>
			<h2>Waktu Tindak Lanjut</h2>
			<ul class="pengaduan-list">
				<li>Verifikasi laporan: maksimal 1x24 jam.</li>
				<li>Tindak lanjut awal: maksimal 3 hari kerja.</li>
				<li>Penyelesaian disesuaikan jenis laporan.</li>
			</ul>
		</article>
	</section>

	<!-- Future dynamic complaint form area. -->
	<section id="form-pengaduan" class="pengaduan-section" aria-labelledby="pengaduan-form-title">
		<div class="pengaduan-panel pengaduan-form-placeholder">
			<p class="section-eyebrow">Form Pengaduan</p>
			<h2 id="pengaduan-form-title">Area Form Pengaduan</h2>
			<p>Placeholder untuk form pengaduan WordPress dinamis, shortcode plugin form, atau integrasi layanan pengaduan resmi.</p>
		</div>
	</section>

	<!-- Contact CTA. -->
	<section class="pengaduan-section pengaduan-contact">
		<div>
			<p class="section-eyebrow">Mulai Laporan</p>
			<h2>Siap Menyampaikan Laporan?</h2>
		</div>
		<a class="button-primary pengaduan-cta" href="#form-pengaduan">Buat Pengaduan</a>
	</section>
</main>

<?php

endwhile;

get_footer();
