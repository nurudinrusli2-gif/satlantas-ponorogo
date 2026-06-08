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
				<div class="announcement-card__meta announcement-entry__meta">
					<time datetime="<?php echo esc_attr( $tanggal_mulai ? $tanggal_mulai : get_the_date( 'Y-m-d' ) ); ?>">
						<?php echo esc_html( $tanggal_mulai ? satlantas_format_pengumuman_date( $tanggal_mulai ) : get_the_date( 'd M Y' ) ); ?>
					</time>
					<?php if ( $tanggal_berakhir ) : ?>
						<span><?php echo esc_html( sprintf( __( 'Berlaku sampai %s', 'satlantas-ponorogo' ), satlantas_format_pengumuman_date( $tanggal_berakhir ) ) ); ?></span>
					<?php endif; ?>
					<?php if ( 'tinggi' === $prioritas ) : ?>
						<span><?php esc_html_e( 'Prioritas Tinggi', 'satlantas-ponorogo' ); ?></span>
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
		</article>
	<?php endwhile; ?>
</main>

<?php
get_footer();
