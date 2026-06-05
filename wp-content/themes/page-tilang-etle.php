<?php
/**
 * Template Name: Tilang & ETLE
 * Template Post Type: page
 *
 * @package Satlantas_Ponorogo
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

<main id="primary" class="site-main etle-page">
	<!-- Hero section. -->
	<section class="etle-hero" aria-labelledby="etle-title">
		<div class="etle-hero__content">
			<p class="section-eyebrow">Layanan Satlantas</p>
			<h1 id="etle-title">Tilang &amp; ETLE</h1>
			<p>Informasi pengecekan tilang elektronik (ETLE), pembayaran denda, konfirmasi pelanggaran, dan prosedur penyelesaian perkara tilang.</p>
			<a class="button-primary etle-cta" href="<?php echo esc_url( home_url( '/kontak/' ) ); ?>">Hubungi Petugas</a>
		</div>
	</section>

	<!-- Service cards. -->
	<section class="etle-section" aria-labelledby="etle-services-title">
		<div class="section-head">
			<div>
				<p class="section-eyebrow">Jenis Layanan</p>
				<h2 id="etle-services-title">Layanan Tilang Elektronik</h2>
			</div>
		</div>
		<div class="etle-card-grid">
			<article class="etle-card">
				<span class="service-icon"><?php satlantas_icon( 'plate' ); ?></span>
				<h3>Cek ETLE</h3>
				<p>Cek status pelanggaran kendaraan berdasarkan nomor registrasi.</p>
			</article>
			<article class="etle-card">
				<span class="service-icon"><?php satlantas_icon( 'paper' ); ?></span>
				<h3>Konfirmasi Pelanggaran</h3>
				<p>Proses verifikasi dan konfirmasi pelanggaran ETLE.</p>
			</article>
			<article class="etle-card">
				<span class="service-icon"><?php satlantas_icon( 'info' ); ?></span>
				<h3>Pembayaran Denda</h3>
				<p>Informasi pembayaran denda tilang sesuai ketentuan.</p>
			</article>
		</div>
	</section>

	<!-- Requirements and service flow. -->
	<section class="etle-section etle-info-layout" aria-label="<?php esc_attr_e( 'Informasi layanan tilang elektronik', 'satlantas-ponorogo' ); ?>">
		<article class="etle-panel">
			<p class="section-eyebrow">Dokumen</p>
			<h2>Persyaratan</h2>
			<ul class="etle-list">
				<li>Nomor kendaraan.</li>
				<li>KTP pemilik kendaraan.</li>
				<li>Surat konfirmasi ETLE (jika ada).</li>
				<li>STNK kendaraan.</li>
				<li>Bukti pembayaran (jika sudah melakukan pembayaran).</li>
			</ul>
		</article>

		<article class="etle-panel">
			<p class="section-eyebrow">Prosedur</p>
			<h2>Alur Layanan</h2>
			<ol class="etle-flow-list">
				<li>Cek status pelanggaran.</li>
				<li>Lakukan konfirmasi.</li>
				<li>Terima kode pembayaran.</li>
				<li>Bayar melalui kanal resmi.</li>
				<li>Simpan bukti pembayaran.</li>
			</ol>
		</article>
	</section>

	<!-- Service schedule. -->
	<section class="etle-section" aria-labelledby="etle-schedule-title">
		<div class="etle-schedule">
			<div>
				<p class="section-eyebrow">Jam Operasional</p>
				<h2 id="etle-schedule-title">Jadwal</h2>
				<p>Datang sesuai jam layanan dan pastikan seluruh berkas sudah lengkap sebelum mengambil nomor antrean.</p>
			</div>
			<div class="etle-schedule__items">
				<div><span>Senin&ndash;Jumat</span><strong>08.00&ndash;14.00 WIB</strong></div>
				<div><span>Sabtu</span><strong>08.00&ndash;10.30 WIB</strong></div>
				<div><span>Minggu</span><strong>Tutup</strong></div>
			</div>
		</div>
	</section>

	<!-- Contact CTA. -->
	<section class="etle-section etle-contact">
		<div>
			<p class="section-eyebrow">Butuh Bantuan?</p>
			<h2>Butuh Bantuan Tilang Elektronik?</h2>
		</div>
		<a class="button-primary etle-cta" href="<?php echo esc_url( home_url( '/kontak/' ) ); ?>">Hubungi Petugas</a>
	</section>
</main>

<?php

endwhile;

get_footer();
