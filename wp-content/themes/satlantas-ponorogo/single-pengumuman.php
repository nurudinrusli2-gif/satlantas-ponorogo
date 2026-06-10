<?php
/**
 * Single template for Pengumuman.
 *
 * @package Satlantas_Ponorogo
 */

get_header();
?>

<main id="primary" class="site-main content-page announcement-single">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php
		$tanggal_mulai    = get_post_meta( get_the_ID(), 'tanggal_mulai', true );
		$tanggal_berakhir = get_post_meta( get_the_ID(), 'tanggal_berakhir', true );
		$prioritas        = get_post_meta( get_the_ID(), 'prioritas', true );
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-card announcement-entry' ); ?>>
			<header class="entry-header">
				<p class="section-eyebrow"><?php esc_html_e( 'Pengumuman', 'satlantas-ponorogo' ); ?></p>
				<h1><?php the_title(); ?></h1>
				<div class="announcement-card__meta announcement-entry__meta cpt-meta">
					<time datetime="<?php echo esc_attr( $tanggal_mulai ? $tanggal_mulai : get_the_date( 'Y-m-d' ) ); ?>">
						<?php echo esc_html( $tanggal_mulai ? satlantas_format_pengumuman_date( $tanggal_mulai ) : get_the_date( 'd M Y' ) ); ?>
					</time>
					<?php if ( $tanggal_berakhir ) : ?>
						<span><?php echo esc_html( sprintf( __( 'Berlaku sampai %s', 'satlantas-ponorogo' ), satlantas_format_pengumuman_date( $tanggal_berakhir ) ) ); ?></span>
					<?php endif; ?>
					<?php if ( 'tinggi' === $prioritas ) : ?>
						<span class="cpt-badge cpt-badge--warning"><?php esc_html_e( 'Prioritas Tinggi', 'satlantas-ponorogo' ); ?></span>
					<?php endif; ?>
				</div>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="entry-featured">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			<?php endif; ?>

			<div class="cpt-single-layout">
				<aside class="cpt-meta-panel" aria-label="<?php esc_attr_e( 'Metadata pengumuman', 'satlantas-ponorogo' ); ?>">
					<h2><?php esc_html_e( 'Detail Pengumuman', 'satlantas-ponorogo' ); ?></h2>
					<div class="cpt-meta-panel__item">
						<span><?php esc_html_e( 'Tanggal Mulai', 'satlantas-ponorogo' ); ?></span>
						<strong><?php echo esc_html( $tanggal_mulai ? satlantas_format_pengumuman_date( $tanggal_mulai ) : get_the_date( 'd M Y' ) ); ?></strong>
					</div>
					<?php if ( $tanggal_berakhir ) : ?>
						<div class="cpt-meta-panel__item">
							<span><?php esc_html_e( 'Berlaku Sampai', 'satlantas-ponorogo' ); ?></span>
							<strong><?php echo esc_html( satlantas_format_pengumuman_date( $tanggal_berakhir ) ); ?></strong>
						</div>
					<?php endif; ?>
					<div class="cpt-meta-panel__item">
						<span><?php esc_html_e( 'Prioritas', 'satlantas-ponorogo' ); ?></span>
						<strong><?php echo esc_html( 'tinggi' === $prioritas ? __( 'Tinggi', 'satlantas-ponorogo' ) : __( 'Normal', 'satlantas-ponorogo' ) ); ?></strong>
					</div>
				</aside>

				<div class="entry-content cpt-main-content">
					<?php the_content(); ?>
					<?php wp_link_pages(); ?>
				</div>
			</div>
		</article>
	<?php endwhile; ?>
</main>

<?php
get_footer();
