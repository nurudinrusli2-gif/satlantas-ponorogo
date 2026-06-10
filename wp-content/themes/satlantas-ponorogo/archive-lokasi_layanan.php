<?php
/**
 * Archive template for Lokasi Layanan.
 *
 * @package Satlantas_Ponorogo
 */

get_header();
?>

<main id="primary" class="site-main listing-page location-archive">
	<header class="archive-header">
		<p class="section-eyebrow"><?php esc_html_e( 'Peta Layanan', 'satlantas-ponorogo' ); ?></p>
		<h1><?php esc_html_e( 'Lokasi Layanan', 'satlantas-ponorogo' ); ?></h1>
		<p><?php esc_html_e( 'Daftar lokasi layanan aktif Satlantas Polres Ponorogo.', 'satlantas-ponorogo' ); ?></p>
	</header>

	<div class="location-grid cpt-card-list">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php
				$alamat          = get_post_meta( get_the_ID(), 'alamat', true );
				$maps_url        = get_post_meta( get_the_ID(), 'maps_url', true );
				$jam_operasional = get_post_meta( get_the_ID(), 'jam_operasional', true );
				$nomor_telepon   = get_post_meta( get_the_ID(), 'nomor_telepon', true );
				?>
				<article <?php post_class( 'location-card cpt-card' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<a class="location-thumb" href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'medium_large' ); ?>
						</a>
					<?php endif; ?>
					<div class="location-card__body">
						<div class="cpt-meta">
							<span class="cpt-badge cpt-badge--success"><?php esc_html_e( 'Aktif', 'satlantas-ponorogo' ); ?></span>
							<?php if ( $jam_operasional ) : ?>
								<span><?php echo esc_html( $jam_operasional ); ?></span>
							<?php endif; ?>
						</div>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<?php if ( $alamat ) : ?>
							<p><?php echo esc_html( $alamat ); ?></p>
						<?php endif; ?>
						<div class="location-meta">
							<?php if ( $nomor_telepon ) : ?>
								<span><strong><?php esc_html_e( 'Telepon', 'satlantas-ponorogo' ); ?></strong><?php echo esc_html( $nomor_telepon ); ?></span>
							<?php endif; ?>
						</div>
						<div class="location-actions cpt-actions">
							<a class="read-more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Detail', 'satlantas-ponorogo' ); ?></a>
							<?php if ( $maps_url ) : ?>
								<a class="button-primary" href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Lihat Peta', 'satlantas-ponorogo' ); ?></a>
							<?php endif; ?>
						</div>
					</div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<article class="location-empty cpt-empty">
				<span class="cpt-empty__icon"><?php esc_html_e( 'MAP', 'satlantas-ponorogo' ); ?></span>
				<h2><?php esc_html_e( 'Belum ada lokasi aktif', 'satlantas-ponorogo' ); ?></h2>
				<p><?php esc_html_e( 'Belum ada lokasi layanan aktif saat ini.', 'satlantas-ponorogo' ); ?></p>
			</article>
		<?php endif; ?>
	</div>

	<?php the_posts_pagination(); ?>
</main>

<?php
get_footer();
