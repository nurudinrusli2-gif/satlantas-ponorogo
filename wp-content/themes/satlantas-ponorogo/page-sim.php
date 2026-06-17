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

	$page_content = trim( (string) get_post_field( 'post_content', get_the_ID() ) );
	?>

<main id="primary" class="site-main sim-document-page">
	<article class="sim-document" aria-labelledby="sim-title">
		<header class="sim-document__header">
			<p><?php esc_html_e( 'Pelayanan', 'satlantas-ponorogo' ); ?></p>
			<h1 id="sim-title"><?php the_title(); ?></h1>
		</header>

		<div class="sim-document__body sim-document__content entry-content">
			<?php if ( '' !== $page_content ) : ?>
				<?php the_content(); ?>
			<?php else : ?>
				<section class="sim-document__section">
					<h2>PENGERTIAN SIM</h2>
					<p>Adalah bukti legitimasi kompetensi pengemudi sesuai jenis dan golongan SIM yang dimilikinya setelah memenuhi persyaratan administrasi, usia, kesehatan jasmani maupun rohani, serta dinyatakan lulus melalui proses pengujian.</p>
				</section>

				<section class="sim-document__section">
					<h2>Fungsi SIM:</h2>
					<ol>
						<li>Legitimasi kompetensi pengemudi</li>
						<li>Identitas pengemudi</li>
						<li>Kontrol kompetensi pengemudi</li>
						<li>Forensik Kepolisian</li>
					</ol>
				</section>

				<section class="sim-document__section">
					<h2>Persyaratan pendaftaran SIM:</h2>
					<ol>
						<li>USIA</li>
						<li>ADMINISTRASI</li>
						<li>KESEHATAN JASMANI DAN ROHANI</li>
						<li>PNBP SIM</li>
					</ol>
				</section>

				<section class="sim-document__section">
					<h2>Usia:</h2>
					<ul>
						<li>berusia 17 (tujuh belas) tahun untuk SIM A, SIM C, dan SIM D</li>
						<li>berusia 20 (dua puluh) tahun untuk SIM B I</li>
						<li>berusia 21 (dua puluh satu) tahun untuk SIM B II</li>
						<li>berusia 20 (dua puluh) tahun untuk SIM A Umum</li>
						<li>berusia 22 (dua puluh dua) tahun untuk SIM B I Umum</li>
						<li>berusia 23 (dua puluh tiga) tahun untuk SIM B II Umum</li>
					</ul>
				</section>

				<section class="sim-document__section">
					<h2>Administrasi:</h2>
					<ul>
						<li>Kartu Tanda Penduduk asli setempat yang masih berlaku bagi Warga Negara Indonesia atau dokumen keimigrasian bagi Warga Negara Asing</li>
						<li>surat keterangan Kesehatan Jasmani dari Dokter</li>
						<li>surat keterangan Kesehatan Rohani dari Biro Psikologi</li>
						<li>SIM lama untuk permohonan perpanjangan SIM</li>
						<li>Untuk pengalihan golongan SIM, harus disertai dengan Surat Lulus Uji Keterampilan Simulator</li>
					</ul>
				</section>

				<section class="sim-document__section">
					<h2>Dokumen Keimigrasian:</h2>
					<ul>
						<li>paspor dan kartu izin tinggal tetap (KITAP) bagi yang berdomisili tetap di Indonesia</li>
						<li>paspor, visa diplomatik, kartu anggota diplomatik, dan identitas dari lain bagi yang merupakan staf atau keluarga kedutaan</li>
						<li>paspor dan visa dinas atau kartu izin tinggal sementara (KITAS) bagi yang bekerja sebagai tenaga ahli atau pelajar yang bersekolah di Indonesia</li>
						<li>paspor dan kartu izin kunjungan atau singgah bagi yang tidak berdomisili di Indonesia</li>
					</ul>
				</section>

				<section class="sim-document__section">
					<h2>Ketentuan:</h2>
					<p>SIM yang telah lewat masa berlakunya, dinyatakan tidak berlaku dan harus membuat proses penerbitan SIM baru.</p>
				</section>

				<section class="sim-document__section">
					<h2>TARIF PNBP SIM PERPANJANGAN, SIM HILANG/RUSAK, MUTASI SIM DAN PERUBAHAN DATA PENGEMUDI</h2>
					<p class="sim-document__note">(SESUAI PP RI NO 76 TAHUN 2020).</p>
					<div class="sim-document__table-wrap">
						<table class="sim-document__table">
							<thead>
								<tr>
									<th>Jenis</th>
									<th>Tarif</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>SIM A dan A Umum</td>
									<td>Rp 80.000</td>
								</tr>
								<tr>
									<td>SIM B I dan B I Umum</td>
									<td>Rp 80.000</td>
								</tr>
								<tr>
									<td>SIM B II dan B II Umum</td>
									<td>Rp 80.000</td>
								</tr>
								<tr>
									<td>SIM C, C I, C II</td>
									<td>Rp 75.000</td>
								</tr>
								<tr>
									<td>SIM D, D I</td>
									<td>Rp 30.000</td>
								</tr>
								<tr>
									<td>SIM Internasional (SI)</td>
									<td>Rp 225.000</td>
								</tr>
								<tr>
									<td>SKUKP</td>
									<td>Rp 50.000</td>
								</tr>
							</tbody>
						</table>
					</div>
				</section>
			<?php endif; ?>
		</div>
	</article>
</main>

<?php

endwhile;

get_footer();