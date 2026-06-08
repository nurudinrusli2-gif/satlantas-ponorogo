<?php
/**
 * Archive template for SIM Keliling schedules.
 *
 * @package Satlantas_Ponorogo
 */

get_header();
?>

<main id="primary" class="site-main listing-page sim-keliling-archive">
	<header class="archive-header">
		<p class="section-eyebrow"><?php esc_html_e( 'Jadwal Layanan', 'satlantas-ponorogo' ); ?></p>
		<h1><?php esc_html_e( 'SIM Keliling', 'satlantas-ponorogo' ); ?></h1>
		<p><?php esc_html_e( 'Daftar jadwal aktif SIM Keliling Satlantas Polres Ponorogo yang akan datang.', 'satlantas-ponorogo' ); ?></p>
	</header>

	<div class="sim-keliling-list">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php
				// Each schedule uses post title as the public location name.
				$tanggal  = get_post_meta( get_the_ID(), 'tanggal', true );
				$jam      = get_post_meta( get_the_ID(), 'jam', true );
				$alamat   = get_post_meta( get_the_ID(), 'alamat', true );
				$maps_url = get_post_meta( get_the_ID(), 'maps_url', true );
				?>
				<article <?php post_class( 'sim-keliling-card' ); ?>>
					<time datetime="<?php echo esc_attr( $tanggal ); ?>"><?php echo esc_html( satlantas_format_sim_keliling_date( $tanggal ) ); ?></time>
					<div class="sim-keliling-card__body">
						<h2><?php the_title(); ?></h2>
						<?php if ( $jam ) : ?>
							<p><strong><?php esc_html_e( 'Jam', 'satlantas-ponorogo' ); ?>:</strong> <?php echo esc_html( $jam ); ?></p>
						<?php endif; ?>
						<?php if ( $alamat ) : ?>
							<p><strong><?php esc_html_e( 'Alamat', 'satlantas-ponorogo' ); ?>:</strong> <?php echo esc_html( $alamat ); ?></p>
						<?php endif; ?>
					</div>
					<?php if ( $maps_url ) : ?>
						<a class="button-primary sim-keliling-map" href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener">
							<?php esc_html_e( 'Lihat Maps', 'satlantas-ponorogo' ); ?>
						</a>
					<?php endif; ?>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Belum ada jadwal SIM Keliling aktif.', 'satlantas-ponorogo' ); ?></p>
		<?php endif; ?>
	</div>

	<?php the_posts_pagination(); ?>
</main>

<?php
get_footer();
