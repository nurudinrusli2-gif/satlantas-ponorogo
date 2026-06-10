<?php
/**
 * Template for the Regulasi placeholder page.
 *
 * @package Satlantas_Ponorogo
 */

$archive_link = get_post_type_archive_link( 'regulasi' );

if ( $archive_link ) {
	wp_safe_redirect( $archive_link, 302 );
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	?>

<main id="primary" class="site-main info-page">
	<section class="info-hero" aria-labelledby="regulasi-title">
		<div class="info-hero__content">
			<p class="section-eyebrow">Dokumen Resmi</p>
			<h1 id="regulasi-title">Regulasi</h1>
			<p>Arsip regulasi sedang dipersiapkan. Silakan cek kembali setelah data regulasi ditambahkan di Dashboard WordPress.</p>
		</div>
	</section>

	<section class="info-section">
		<article class="info-panel">
			<p>Archive regulasi belum tersedia untuk ditampilkan.</p>
		</article>
	</section>
</main>

<?php
endwhile;

get_footer();
