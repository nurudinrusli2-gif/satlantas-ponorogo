<?php
/**
 * Template Name: STNK & BPKB
 * Template Post Type: page
 *
 * @package Satlantas_Ponorogo
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

<main id="primary" class="site-main stnk-page">
	<!-- Hero section. -->
	<section class="stnk-hero" aria-labelledby="stnk-title">
		<div class="stnk-hero__content">
			<p class="section-eyebrow">Layanan Satlantas</p>
			<h1 id="stnk-title">STNK &amp; BPKB</h1>
			<p>Informasi pengesahan STNK tahunan, perpanjangan STNK 5 tahunan, penggantian plat nomor, dan pengurusan BPKB.</p>
			<a class="button-primary stnk-cta" href="<?php echo esc_url( home_url( '/kontak/' ) ); ?>">Hubungi Petugas</a>
		</div>
	</section>

	<!-- Service cards. -->
	<section class="stnk-section" aria-labelledby="stnk-services-title">
		<div class="section-head">
			<div>
				<p class="section-eyebrow">Jenis Layanan</p>
				<h2 id="stnk-services-title">Layanan STNK &amp; BPKB</h2>
			</div>
		</div>
		<div class="stnk-card-grid">
			<article class="stnk-card">
				<span class="service-icon"><?php satlantas_icon( 'paper' ); ?></span>
				<h3>Pengesahan STNK Tahunan</h3>
				<p>Layanan pembayaran pajak kendaraan tahunan.</p>
			</article>
			<article class="stnk-card">
				<span class="service-icon"><?php satlantas_icon( 'plate' ); ?></span>
				<h3>Perpanjangan STNK 5 Tahunan</h3>
				<p>Layanan pergantian STNK dan TNKB.</p>
			</article>
			<article class="stnk-card">
				<span class="service-icon"><?php satlantas_icon( 'sim' ); ?></span>
				<h3>Pengurusan BPKB</h3>
				<p>Layanan penerbitan atau perubahan data BPKB.</p>
			</article>
		</div>
	</section>

	<!-- Requirements and fees. -->
	<section class="stnk-section stnk-info-layout" aria-label="<?php esc_attr_e( 'Informasi layanan STNK dan BPKB', 'satlantas-ponorogo' ); ?>">
		<article class="stnk-panel">
			<p class="section-eyebrow">Dokumen</p>
			<h2>Persyaratan</h2>
			<ul class="stnk-list">
				<li>KTP asli dan fotokopi.</li>
				<li>STNK asli dan fotokopi.</li>
				<li>BPKB asli (jika diperlukan).</li>
				<li>Kendaraan untuk cek fisik.</li>
				<li>Bukti pembayaran pajak sebelumnya.</li>
			</ul>
		</article>

		<article class="stnk-panel">
			<p class="section-eyebrow">Tarif Resmi</p>
			<h2>Biaya</h2>
			<div class="stnk-fee-list">
				<div><span>Pajak Tahunan</span><strong>Sesuai PKB</strong></div>
				<div><span>Ganti Plat 5 Tahunan</span><strong>Sesuai PNBP</strong></div>
				<div><span>STNK Baru</span><strong>Sesuai PNBP</strong></div>
				<div><span>BPKB</span><strong>Sesuai ketentuan Polri</strong></div>
			</div>
		</article>
	</section>

	<!-- Service schedule. -->
	<section class="stnk-section" aria-labelledby="stnk-schedule-title">
		<div class="stnk-schedule">
			<div>
				<p class="section-eyebrow">Jam Operasional</p>
				<h2 id="stnk-schedule-title">Jadwal</h2>
				<p>Datang sesuai jam layanan dan pastikan seluruh berkas sudah lengkap sebelum mengambil nomor antrean.</p>
			</div>
			<div class="stnk-schedule__items">
				<div><span>Senin&ndash;Jumat</span><strong>08.00&ndash;14.00 WIB</strong></div>
				<div><span>Sabtu</span><strong>08.00&ndash;10.30 WIB</strong></div>
				<div><span>Minggu</span><strong>Tutup</strong></div>
			</div>
		</div>
	</section>

	<!-- Contact CTA. -->
	<section class="stnk-section stnk-contact">
		<div>
			<p class="section-eyebrow">Butuh Bantuan?</p>
			<h2>Butuh Bantuan Administrasi Kendaraan?</h2>
		</div>
		<a class="button-primary stnk-cta" href="<?php echo esc_url( home_url( '/kontak/' ) ); ?>">Hubungi Petugas</a>
	</section>
</main>

<?php

endwhile;

get_footer();
