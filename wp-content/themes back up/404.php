<?php
/**
 * 404 template.
 *
 * @package Satlantas_Ponorogo
 */

get_header();
?>
<main id="primary" class="site-main content-page not-found-page">
	<section class="entry-card">
		<p class="section-eyebrow">404</p>
		<h1><?php esc_html_e( 'Halaman tidak ditemukan', 'satlantas-ponorogo' ); ?></h1>
		<p><?php esc_html_e( 'Maaf, halaman yang Anda cari tidak tersedia. Gunakan pencarian atau kembali ke beranda.', 'satlantas-ponorogo' ); ?></p>
		<?php get_search_form(); ?>
		<a class="button-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Kembali ke Beranda', 'satlantas-ponorogo' ); ?></a>
	</section>
</main>
<?php
get_footer();
