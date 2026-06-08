<?php
/**
 * Template Name: Info & Layanan
 * Template Post Type: page
 *
 * @package Satlantas_Ponorogo
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

<main id="primary" class="site-main info-page">
	<!-- Hero section. -->
	<section class="info-hero" aria-labelledby="info-title">
		<div class="info-hero__content">
			<p class="section-eyebrow">Pusat Informasi</p>
			<h1 id="info-title">Info &amp; Layanan</h1>
			<p>Temukan informasi layanan, jadwal operasional, kontak penting, FAQ, dan panduan pelayanan Satlantas Polres Ponorogo.</p>
			<a class="button-primary info-cta" href="<?php echo esc_url( home_url( '/kontak/' ) ); ?>">Hubungi Petugas</a>
		</div>
	</section>

	<!-- Quick information cards. -->
	<section class="info-section" aria-labelledby="info-services-title">
		<div class="section-head">
			<div>
				<p class="section-eyebrow">Akses Cepat</p>
				<h2 id="info-services-title">Informasi Cepat</h2>
			</div>
		</div>
		<div class="info-card-grid">
			<article class="info-card">
				<span class="service-icon"><?php satlantas_icon( 'sim' ); ?></span>
				<h3>SIM</h3>
				<p>Informasi pembuatan dan perpanjangan SIM.</p>
			</article>
			<article class="info-card">
				<span class="service-icon"><?php satlantas_icon( 'plate' ); ?></span>
				<h3>STNK &amp; BPKB</h3>
				<p>Informasi administrasi kendaraan bermotor.</p>
			</article>
			<article class="info-card">
				<span class="service-icon"><?php satlantas_icon( 'paper' ); ?></span>
				<h3>Tilang &amp; ETLE</h3>
				<p>Informasi pelanggaran dan pembayaran tilang.</p>
			</article>
			<article class="info-card">
				<span class="service-icon"><?php satlantas_icon( 'phone' ); ?></span>
				<h3>Pengaduan</h3>
				<p>Informasi penyampaian laporan masyarakat.</p>
			</article>
		</div>
	</section>

	<!-- FAQ accordion and operational schedule. -->
	<section class="info-section info-info-layout" aria-label="<?php esc_attr_e( 'FAQ dan jam operasional layanan', 'satlantas-ponorogo' ); ?>">
		<article class="info-panel info-faq">
			<p class="section-eyebrow">FAQ</p>
			<h2>FAQ</h2>
			<div class="info-faq__items">
				<details>
					<summary>Apa syarat membuat SIM baru?</summary>
					<p>Siapkan KTP, surat keterangan sehat, surat keterangan psikologi, isi formulir permohonan, dan ikuti ujian sesuai ketentuan.</p>
				</details>
				<details>
					<summary>Bagaimana cara memperpanjang STNK?</summary>
					<p>Bawa KTP, STNK, BPKB jika diperlukan, kendaraan untuk cek fisik, dan bukti pembayaran pajak sebelumnya.</p>
				</details>
				<details>
					<summary>Bagaimana mengecek ETLE?</summary>
					<p>Cek status pelanggaran menggunakan nomor registrasi kendaraan dan ikuti instruksi konfirmasi jika ada pelanggaran.</p>
				</details>
				<details>
					<summary>Bagaimana menyampaikan pengaduan?</summary>
					<p>Siapkan informasi lengkap, lokasi kejadian, bukti pendukung jika tersedia, dan nomor kontak yang dapat dihubungi.</p>
				</details>
			</div>
		</article>

		<article class="info-panel">
			<p class="section-eyebrow">Jam Operasional</p>
			<h2>Jam Operasional</h2>
			<div class="info-schedule__items">
				<div><span>Senin&ndash;Jumat</span><strong>08.00&ndash;14.00 WIB</strong></div>
				<div><span>Sabtu</span><strong>08.00&ndash;10.30 WIB</strong></div>
				<div><span>Minggu dan Hari Libur Nasional</span><strong>Tutup</strong></div>
			</div>
		</article>
	</section>

	<!-- Contact and download information. -->
	<section class="info-section info-info-layout" aria-label="<?php esc_attr_e( 'Kontak penting dan unduhan layanan', 'satlantas-ponorogo' ); ?>">
		<article class="info-panel">
			<p class="section-eyebrow">Kontak</p>
			<h2>Kontak Penting</h2>
			<ul class="info-list">
				<li>Call Center.</li>
				<li>WhatsApp Pelayanan.</li>
				<li>Email Resmi.</li>
				<li>Alamat Kantor.</li>
			</ul>
		</article>

		<article class="info-panel">
			<p class="section-eyebrow">Download</p>
			<h2>Download</h2>
			<div class="info-download-list">
				<div><span>Formulir SIM</span><strong>Placeholder</strong></div>
				<div><span>Formulir STNK</span><strong>Placeholder</strong></div>
				<div><span>Panduan ETLE</span><strong>Placeholder</strong></div>
			</div>
		</article>
	</section>

	<!-- Contact CTA. -->
	<section class="info-section info-contact">
		<div>
			<p class="section-eyebrow">Bantuan Layanan</p>
			<h2>Masih Membutuhkan Bantuan?</h2>
		</div>
		<a class="button-primary info-cta" href="<?php echo esc_url( home_url( '/kontak/' ) ); ?>">Hubungi Petugas</a>
	</section>
</main>

<?php

endwhile;

get_footer();
