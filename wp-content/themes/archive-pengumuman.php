<?php
/**
 * Archive template for Pengumuman.
 *
 * @package Satlantas_Ponorogo
 */

get_header();
?>

<main id="primary" class="site-main listing-page announcement-archive">
	<header class="archive-header">
		<p class="section-eyebrow"><?php esc_html_e( 'Informasi Resmi', 'satlantas-ponorogo' ); ?></p>
		<h1><?php esc_html_e( 'Pengumuman', 'satlantas-ponorogo' ); ?></h1>
		<p><?php esc_html_e( 'Daftar pengumuman aktif Satlantas Polres Ponorogo.', 'satlantas-ponorogo' ); ?></p>
	</header>

	<div class="announcement-list">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php
				$tanggal_mulai    = get_post_meta( get_the_ID(), 'tanggal_mulai', true );
				$tanggal_berakhir = get_post_meta( get_the_ID(), 'tanggal_berakhir', true );
				$prioritas        = get_post_meta( get_the_ID(), 'prioritas', true );
				?>
				<article <?php post_class( 'announcement-card announcement-card--list' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<a class="announcement-thumb" href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'medium_large' ); ?>
						</a>
					<?php endif; ?>
					<div class="announcement-card__content">
						<div class="announcement-card__meta">
							<time datetime="<?php echo esc_attr( $tanggal_mulai ? $tanggal_mulai : get_the_date( 'Y-m-d' ) ); ?>">
								<?php echo esc_html( $tanggal_mulai ? satlantas_format_pengumuman_date( $tanggal_mulai ) : get_the_date( 'd M Y' ) ); ?>
							</time>
							<?php if ( $tanggal_berakhir ) : ?>
								<span><?php echo esc_html( sprintf( __( 's.d. %s', 'satlantas-ponorogo' ), satlantas_format_pengumuman_date( $tanggal_berakhir ) ) ); ?></span>
							<?php endif; ?>
							<?php if ( 'tinggi' === $prioritas ) : ?>
								<span><?php esc_html_e( 'Prioritas', 'satlantas-ponorogo' ); ?></span>
							<?php endif; ?>
						</div>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p><?php echo satlantas_excerpt( 24 ); ?></p>
						<a class="read-more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Selengkapnya', 'satlantas-ponorogo' ); ?></a>
					</div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<article class="announcement-empty">
				<p><?php esc_html_e( 'Belum ada pengumuman aktif saat ini.', 'satlantas-ponorogo' ); ?></p>
			</article>
		<?php endif; ?>
	</div>

	<?php the_posts_pagination(); ?>
</main>

<?php
get_footer();
