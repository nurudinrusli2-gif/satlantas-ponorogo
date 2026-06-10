<?php
/**
 * Single template for Regulasi.
 *
 * @package Satlantas_Ponorogo
 */

get_header();
?>

<main id="primary" class="site-main content-page regulasi-single">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php
		$nomor_regulasi    = get_post_meta( get_the_ID(), 'nomor_regulasi', true );
		$tanggal_regulasi  = get_post_meta( get_the_ID(), 'tanggal_regulasi', true );
		$kategori_regulasi = get_post_meta( get_the_ID(), 'kategori_regulasi', true );
		$file_pdf          = get_post_meta( get_the_ID(), 'file_pdf', true );
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-card regulasi-entry' ); ?>>
			<header class="entry-header">
				<p class="section-eyebrow"><?php esc_html_e( 'Regulasi', 'satlantas-ponorogo' ); ?></p>
				<h1><?php the_title(); ?></h1>
				<div class="announcement-card__meta">
					<time datetime="<?php echo esc_attr( $tanggal_regulasi ? $tanggal_regulasi : get_the_date( 'Y-m-d' ) ); ?>">
						<?php echo esc_html( $tanggal_regulasi ? satlantas_format_regulasi_date( $tanggal_regulasi ) : get_the_date( 'd M Y' ) ); ?>
					</time>
					<?php if ( $nomor_regulasi ) : ?>
						<span><?php echo esc_html( $nomor_regulasi ); ?></span>
					<?php endif; ?>
					<?php if ( $kategori_regulasi ) : ?>
						<span><?php echo esc_html( $kategori_regulasi ); ?></span>
					<?php endif; ?>
				</div>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="entry-featured">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			<?php endif; ?>

			<div class="entry-content">
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</div>

			<div class="entry-footer location-actions">
				<?php if ( $file_pdf ) : ?>
					<a class="button-primary" href="<?php echo esc_url( $file_pdf ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Unduh PDF', 'satlantas-ponorogo' ); ?></a>
				<?php endif; ?>
				<a class="read-more" href="<?php echo esc_url( get_post_type_archive_link( 'regulasi' ) ); ?>"><?php esc_html_e( 'Kembali ke Daftar Regulasi', 'satlantas-ponorogo' ); ?></a>
			</div>
		</article>
	<?php endwhile; ?>
</main>

<?php
get_footer();
