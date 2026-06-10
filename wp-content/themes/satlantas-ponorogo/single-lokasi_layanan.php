<?php
/**
 * Single template for Lokasi Layanan.
 *
 * @package Satlantas_Ponorogo
 */

get_header();
?>

<main id="primary" class="site-main content-page location-single">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php
		$alamat          = get_post_meta( get_the_ID(), 'alamat', true );
		$maps_url        = get_post_meta( get_the_ID(), 'maps_url', true );
		$jam_operasional = get_post_meta( get_the_ID(), 'jam_operasional', true );
		$nomor_telepon   = get_post_meta( get_the_ID(), 'nomor_telepon', true );
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-card location-entry' ); ?>>
			<header class="entry-header">
				<p class="section-eyebrow"><?php esc_html_e( 'Lokasi Layanan', 'satlantas-ponorogo' ); ?></p>
				<h1><?php the_title(); ?></h1>
				<div class="cpt-meta">
					<span class="cpt-badge cpt-badge--success"><?php esc_html_e( 'Aktif', 'satlantas-ponorogo' ); ?></span>
					<?php if ( $jam_operasional ) : ?>
						<span><?php echo esc_html( $jam_operasional ); ?></span>
					<?php endif; ?>
				</div>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="entry-featured location-featured">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			<?php endif; ?>

			<div class="cpt-single-layout">
				<aside class="cpt-meta-panel" aria-label="<?php esc_attr_e( 'Metadata lokasi layanan', 'satlantas-ponorogo' ); ?>">
					<h2><?php esc_html_e( 'Detail Lokasi', 'satlantas-ponorogo' ); ?></h2>
					<?php if ( $jam_operasional ) : ?>
						<div class="cpt-meta-panel__item">
							<span><?php esc_html_e( 'Jam Operasional', 'satlantas-ponorogo' ); ?></span>
							<strong><?php echo esc_html( $jam_operasional ); ?></strong>
						</div>
					<?php endif; ?>
					<?php if ( $nomor_telepon ) : ?>
						<div class="cpt-meta-panel__item">
							<span><?php esc_html_e( 'Nomor Telepon', 'satlantas-ponorogo' ); ?></span>
							<strong><?php echo esc_html( $nomor_telepon ); ?></strong>
						</div>
					<?php endif; ?>
					<?php if ( $maps_url ) : ?>
						<a class="button-primary location-map-button" href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener">
							<?php esc_html_e( 'Lihat Google Maps', 'satlantas-ponorogo' ); ?>
						</a>
					<?php endif; ?>
				</aside>

				<div class="location-detail cpt-main-content">
					<?php if ( $alamat ) : ?>
						<div class="location-detail__item">
							<strong><?php esc_html_e( 'Alamat', 'satlantas-ponorogo' ); ?></strong>
							<p><?php echo esc_html( $alamat ); ?></p>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</article>
	<?php endwhile; ?>
</main>

<?php
get_footer();
