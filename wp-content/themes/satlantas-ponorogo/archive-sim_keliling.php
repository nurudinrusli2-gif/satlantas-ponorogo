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
		<h1><?php esc_html_e( 'Layanan Keliling', 'satlantas-ponorogo' ); ?></h1>
		<p><?php esc_html_e( 'Daftar jadwal aktif SIM Keliling dan Samsat Keliling Satlantas Polres Ponorogo.', 'satlantas-ponorogo' ); ?></p>
	</header>

	<div class="sim-keliling-list cpt-card-list">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php
				// Each schedule uses post title as the public location name.
				$tanggal  = get_post_meta( get_the_ID(), 'tanggal', true );
				$jam      = get_post_meta( get_the_ID(), 'jam', true );
				$alamat   = get_post_meta( get_the_ID(), 'alamat', true );
				$maps_url = get_post_meta( get_the_ID(), 'maps_url', true );
				$service_label = satlantas_get_keliling_service_label( get_the_ID() );
				?>
				<article <?php post_class( 'sim-keliling-card cpt-card cpt-card--schedule' ); ?>>
					<time datetime="<?php echo esc_attr( $tanggal ); ?>"><?php echo esc_html( satlantas_format_sim_keliling_date( $tanggal ) ); ?></time>
					<div class="sim-keliling-card__body">
						<div class="cpt-meta">
							<span class="cpt-badge"><?php echo esc_html( $service_label ); ?></span>
							<span class="cpt-badge cpt-badge--success"><?php esc_html_e( 'Aktif', 'satlantas-ponorogo' ); ?></span>
							<?php if ( $jam ) : ?>
								<span><?php echo esc_html( $jam ); ?></span>
							<?php endif; ?>
						</div>
						<h2><?php the_title(); ?></h2>
						<?php if ( $alamat ) : ?>
							<p><strong><?php esc_html_e( 'Alamat', 'satlantas-ponorogo' ); ?>:</strong> <?php echo esc_html( $alamat ); ?></p>
						<?php endif; ?>
					</div>
					<div class="cpt-actions">
						<?php if ( $maps_url ) : ?>
							<a class="button-primary sim-keliling-map" href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener">
								<?php esc_html_e( 'Lihat Maps', 'satlantas-ponorogo' ); ?>
							</a>
						<?php endif; ?>
					</div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<article class="sim-keliling-empty cpt-empty">
				<span class="cpt-empty__icon"><?php esc_html_e( 'SIM', 'satlantas-ponorogo' ); ?></span>
				<h2><?php esc_html_e( 'Belum ada jadwal aktif', 'satlantas-ponorogo' ); ?></h2>
				<p><?php esc_html_e( 'Jadwal SIM Keliling dan Samsat Keliling akan ditampilkan setelah diperbarui oleh administrator.', 'satlantas-ponorogo' ); ?></p>
			</article>
		<?php endif; ?>
	</div>

	<?php the_posts_pagination(); ?>
</main>

<?php
get_footer();
