<?php
/**
 * Template Name: Profil
 * Template Post Type: page
 *
 * @package Satlantas_Ponorogo
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

<main id="primary" class="site-main profil-page info-page">
	<section class="info-hero" aria-labelledby="profil-title">
		<div class="info-hero__content">
			<p class="section-eyebrow">Profil Satuan</p>
			<h1 id="profil-title">Profil Satlantas Polres Ponorogo</h1>
			<p>Informasi umum mengenai peran, arah pelayanan, dan struktur Satlantas Polres Ponorogo dalam mendukung keselamatan berlalu lintas.</p>
		</div>
	</section>

	<section class="info-section" aria-labelledby="tentang-satlantas-title">
		<article class="info-panel">
			<p class="section-eyebrow">Tentang Satlantas</p>
			<h2 id="tentang-satlantas-title">Tentang Satlantas</h2>
			<p>Satlantas Polres Ponorogo merupakan unsur pelaksana tugas kepolisian di bidang lalu lintas yang berfokus pada pelayanan, pengaturan, penjagaan, pengawalan, patroli, penegakan hukum, serta edukasi keselamatan berlalu lintas bagi masyarakat.</p>
			<p>Konten ini bersifat placeholder profesional dan dapat disesuaikan oleh administrator sesuai profil resmi, kebijakan satuan, dan kebutuhan publikasi.</p>
		</article>
	</section>

	<section class="info-section info-info-layout" aria-label="<?php esc_attr_e( 'Visi dan misi Satlantas', 'satlantas-ponorogo' ); ?>">
		<article class="info-panel">
			<p class="section-eyebrow">Arah Pelayanan</p>
			<h2>Visi</h2>
			<p>Terwujudnya pelayanan lalu lintas yang profesional, transparan, responsif, dan humanis untuk mendukung keamanan, keselamatan, ketertiban, dan kelancaran lalu lintas di Kabupaten Ponorogo.</p>
		</article>

		<article class="info-panel">
			<p class="section-eyebrow">Komitmen</p>
			<h2>Misi</h2>
			<ul class="info-list">
				<li>Meningkatkan kualitas pelayanan administrasi lalu lintas yang mudah diakses masyarakat.</li>
				<li>Melaksanakan edukasi keselamatan berlalu lintas secara berkelanjutan.</li>
				<li>Mendukung penegakan hukum lalu lintas yang adil, terukur, dan akuntabel.</li>
				<li>Mengoptimalkan informasi publik melalui kanal digital resmi.</li>
			</ul>
		</article>
	</section>

	<section class="info-section info-info-layout" aria-label="<?php esc_attr_e( 'Tugas dan fungsi Satlantas', 'satlantas-ponorogo' ); ?>">
		<article class="info-panel">
			<p class="section-eyebrow">Pelaksanaan Tugas</p>
			<h2>Tugas</h2>
			<p>Satlantas bertugas menyelenggarakan fungsi lalu lintas pada tingkat Polres, meliputi pembinaan masyarakat, registrasi dan identifikasi kendaraan maupun pengemudi, pengaturan lalu lintas, serta penanganan kejadian lalu lintas sesuai ketentuan yang berlaku.</p>
		</article>

		<article class="info-panel">
			<p class="section-eyebrow">Ruang Lingkup</p>
			<h2>Fungsi</h2>
			<ul class="info-list">
				<li>Pelayanan SIM, STNK, BPKB, dan informasi administrasi lalu lintas.</li>
				<li>Pengaturan, penjagaan, pengawalan, dan patroli lalu lintas.</li>
				<li>Penanganan kecelakaan lalu lintas dan analisis keselamatan jalan.</li>
				<li>Pendidikan masyarakat lalu lintas dan kampanye keselamatan berkendara.</li>
			</ul>
		</article>
	</section>

	<section class="info-section" aria-labelledby="struktur-organisasi-title">
		<div class="section-head">
			<div>
				<p class="section-eyebrow">Organisasi</p>
				<h2 id="struktur-organisasi-title">Struktur Organisasi</h2>
			</div>
		</div>
		<?php
		$struktur_query = satlantas_get_active_struktur_organisasi();
		?>
		<?php if ( $struktur_query->have_posts() ) : ?>
			<div class="info-card-grid struktur-grid">
				<?php while ( $struktur_query->have_posts() ) : $struktur_query->the_post(); ?>
					<?php
					$nama_jabatan = get_post_meta( get_the_ID(), 'nama_jabatan', true );
					$nama_pejabat = get_post_meta( get_the_ID(), 'nama_pejabat', true );
					$urutan       = get_post_meta( get_the_ID(), 'urutan', true );
					$photo_url    = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
					$photo_style  = $photo_url ? 'background-image:url(' . esc_url( $photo_url ) . ');background-size:cover;background-position:center;background-color:#fff;' : '';
					?>
					<article <?php post_class( 'info-card struktur-card cpt-card' ); ?>>
						<span class="service-icon struktur-photo" style="<?php echo esc_attr( $photo_style ); ?>">
							<?php if ( ! $photo_url ) : ?>
								<?php satlantas_icon( 'info' ); ?>
							<?php endif; ?>
						</span>
						<span class="cpt-badge cpt-badge--success"><?php esc_html_e( 'Aktif', 'satlantas-ponorogo' ); ?></span>
						<h3><?php echo esc_html( $nama_jabatan ?: get_the_title() ); ?></h3>
						<p><?php echo esc_html( $nama_pejabat ? $nama_pejabat : __( 'Nama pejabat dapat diperbarui oleh administrator.', 'satlantas-ponorogo' ) ); ?></p>
						<small><?php echo esc_html( sprintf( __( 'Urutan struktur: %s', 'satlantas-ponorogo' ), $urutan ? $urutan : '-' ) ); ?></small>
					</article>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		<?php else : ?>
			<article class="info-panel cpt-empty">
				<span class="cpt-empty__icon"><?php esc_html_e( 'ORG', 'satlantas-ponorogo' ); ?></span>
				<p class="section-eyebrow">Organisasi</p>
				<h2>Struktur Organisasi</h2>
				<p>Belum ada data struktur organisasi aktif. Administrator dapat menambahkannya melalui menu Struktur Organisasi di Dashboard WordPress.</p>
			</article>
		<?php endif; ?>
	</section>
</main>

<?php

endwhile;

get_footer();
