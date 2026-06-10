<?php
/**
 * Archive template for Regulasi.
 *
 * @package Satlantas_Ponorogo
 */

get_header();
?>

<main id="primary" class="site-main listing-page regulasi-archive">
	<header class="archive-header">
		<p class="section-eyebrow"><?php esc_html_e( 'Dokumen Resmi', 'satlantas-ponorogo' ); ?></p>
		<h1><?php esc_html_e( 'Regulasi', 'satlantas-ponorogo' ); ?></h1>
		<p><?php esc_html_e( 'Daftar regulasi aktif yang dapat diakses publik.', 'satlantas-ponorogo' ); ?></p>
	</header>

	<div class="regulasi-list cpt-card-list">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php
				$nomor_regulasi   = get_post_meta( get_the_ID(), 'nomor_regulasi', true );
				$tanggal_regulasi = get_post_meta( get_the_ID(), 'tanggal_regulasi', true );
				$kategori_regulasi = get_post_meta( get_the_ID(), 'kategori_regulasi', true );
				$file_pdf         = get_post_meta( get_the_ID(), 'file_pdf', true );
				?>
				<article <?php post_class( 'regulasi-card cpt-card' ); ?>>
					<div class="announcement-card__content">
						<div class="announcement-card__meta cpt-meta">
							<time datetime="<?php echo esc_attr( $tanggal_regulasi ? $tanggal_regulasi : get_the_date( 'Y-m-d' ) ); ?>">
								<?php echo esc_html( $tanggal_regulasi ? satlantas_format_regulasi_date( $tanggal_regulasi ) : get_the_date( 'd M Y' ) ); ?>
							</time>
							<?php if ( $nomor_regulasi ) : ?>
								<span><?php echo esc_html( $nomor_regulasi ); ?></span>
							<?php endif; ?>
							<?php if ( $kategori_regulasi ) : ?>
								<span class="cpt-badge"><?php echo esc_html( $kategori_regulasi ); ?></span>
							<?php endif; ?>
						</div>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p><?php echo satlantas_excerpt( 26 ); ?></p>
						<div class="location-actions cpt-actions">
							<a class="read-more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Detail', 'satlantas-ponorogo' ); ?></a>
							<?php if ( $file_pdf ) : ?>
								<a class="button-primary" href="<?php echo esc_url( $file_pdf ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Unduh PDF', 'satlantas-ponorogo' ); ?></a>
							<?php endif; ?>
						</div>
					</div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<article class="announcement-empty cpt-empty">
				<span class="cpt-empty__icon"><?php esc_html_e( 'PDF', 'satlantas-ponorogo' ); ?></span>
				<h2><?php esc_html_e( 'Belum ada regulasi aktif', 'satlantas-ponorogo' ); ?></h2>
				<p><?php esc_html_e( 'Belum ada regulasi aktif saat ini.', 'satlantas-ponorogo' ); ?></p>
			</article>
		<?php endif; ?>
	</div>

	<?php the_posts_pagination(); ?>
</main>

<?php
get_footer();
