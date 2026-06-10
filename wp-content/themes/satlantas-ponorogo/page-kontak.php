<?php
/**
 * Template Name: Kontak
 * Template Post Type: page
 *
 * @package Satlantas_Ponorogo
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

<main id="primary" class="site-main kontak-page info-page">
	<section class="info-hero" aria-labelledby="kontak-title">
		<div class="info-hero__content">
			<p class="section-eyebrow">Hubungi Kami</p>
			<h1 id="kontak-title">Kontak Satlantas Polres Ponorogo</h1>
			<p>Gunakan informasi kontak berikut untuk kebutuhan layanan, informasi lalu lintas, dan pengaduan masyarakat.</p>
		</div>
	</section>

	<section class="info-section" aria-labelledby="kontak-info-title">
		<div class="section-head">
			<div>
				<p class="section-eyebrow">Informasi Kontak</p>
				<h2 id="kontak-info-title">Kontak Utama</h2>
			</div>
		</div>
		<div class="info-card-grid">
			<article class="info-card">
				<span class="service-icon"><?php satlantas_icon( 'map' ); ?></span>
				<h3>Alamat</h3>
				<p>Jl. Bhayangkara No. 60, Bangunsari, Kec. Ponorogo, Kabupaten Ponorogo, Jawa Timur 63413.</p>
			</article>
			<article class="info-card">
				<span class="service-icon"><?php satlantas_icon( 'call' ); ?></span>
				<h3>Telepon</h3>
				<p>0352-000-000<br>Placeholder nomor layanan.</p>
			</article>
			<article class="info-card">
				<span class="service-icon"><?php satlantas_icon( 'info' ); ?></span>
				<h3>Email</h3>
				<p>satlantasponorogo@gmail.com<br>Placeholder email resmi.</p>
			</article>
			<article class="info-card">
				<span class="service-icon"><?php satlantas_icon( 'clock' ); ?></span>
				<h3>Jam Operasional</h3>
				<p>Senin-Jumat 08.00-14.00 WIB.<br>Sabtu 08.00-10.30 WIB.</p>
			</article>
		</div>
	</section>

	<section class="info-section info-info-layout" aria-label="<?php esc_attr_e( 'Peta dan jam operasional', 'satlantas-ponorogo' ); ?>">
		<article class="info-panel">
			<p class="section-eyebrow">Google Maps</p>
			<h2>Lokasi Kantor</h2>
			<div class="kontak-map-placeholder" role="img" aria-label="<?php esc_attr_e( 'Placeholder embed Google Maps Satlantas Polres Ponorogo', 'satlantas-ponorogo' ); ?>">
				<span>Google Maps Embed Placeholder</span>
				<small>Ganti area ini dengan kode embed Google Maps resmi.</small>
			</div>
		</article>

		<article class="info-panel">
			<p class="section-eyebrow">Jam Layanan</p>
			<h2>Jam Operasional</h2>
			<div class="info-schedule__items">
				<div><span>Senin-Jumat</span><strong>08.00-14.00 WIB</strong></div>
				<div><span>Sabtu</span><strong>08.00-10.30 WIB</strong></div>
				<div><span>Minggu dan Hari Libur Nasional</span><strong>Tutup</strong></div>
			</div>
			<p>Jadwal dapat berubah sewaktu-waktu menyesuaikan kebijakan pelayanan dan hari libur nasional.</p>
		</article>
	</section>

	<section class="info-section info-info-layout" aria-label="<?php esc_attr_e( 'Informasi pengaduan dan kanal layanan', 'satlantas-ponorogo' ); ?>">
		<article class="info-panel">
			<p class="section-eyebrow">Pengaduan</p>
			<h2>Informasi Pengaduan</h2>
			<p>Masyarakat dapat menyampaikan laporan, saran, atau keluhan terkait pelayanan lalu lintas melalui kanal resmi yang tersedia. Sertakan identitas, kronologi singkat, lokasi, waktu kejadian, dan bukti pendukung jika ada.</p>
			<ul class="info-list">
				<li>Pengaduan pelayanan administrasi lalu lintas.</li>
				<li>Informasi kejadian atau hambatan lalu lintas.</li>
				<li>Saran peningkatan kualitas pelayanan publik.</li>
			</ul>
		</article>

		<article class="info-panel">
			<p class="section-eyebrow">Respons Layanan</p>
			<h2>Alur Tindak Lanjut</h2>
			<ol class="pengaduan-flow-list">
				<li>Petugas menerima informasi atau pengaduan masyarakat.</li>
				<li>Informasi diverifikasi berdasarkan data dan bukti pendukung.</li>
				<li>Petugas memberikan arahan atau meneruskan laporan sesuai kewenangan.</li>
				<li>Masyarakat dapat memantau tindak lanjut melalui kanal kontak resmi.</li>
			</ol>
		</article>
	</section>
</main>

<?php

endwhile;

get_footer();
