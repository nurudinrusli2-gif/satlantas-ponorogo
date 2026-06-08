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
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="entry-featured location-featured">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			<?php endif; ?>

			<div class="location-detail">
				<?php if ( $alamat ) : ?>
					<div class="location-detail__item">
						<strong><?php esc_html_e( 'Alamat', 'satlantas-ponorogo' ); ?></strong>
						<p><?php echo esc_html( $alamat ); ?></p>
					</div>
				<?php endif; ?>

				<?php if ( $jam_operasional ) : ?>
					<div class="location-detail__item">
						<strong><?php esc_html_e( 'Jam Operasional', 'satlantas-ponorogo' ); ?></strong>
						<p><?php echo esc_html( $jam_operasional ); ?></p>
					</div>
				<?php endif; ?>

				<?php if ( $nomor_telepon ) : ?>
					<div class="location-detail__item">
						<strong><?php esc_html_e( 'Nomor Telepon', 'satlantas-ponorogo' ); ?></strong>
						<p><?php echo esc_html( $nomor_telepon ); ?></p>
					</div>
				<?php endif; ?>

				<?php if ( $maps_url ) : ?>
					<a class="button-primary location-map-button" href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener">
						<?php esc_html_e( 'Lihat Google Maps', 'satlantas-ponorogo' ); ?>
					</a>
				<?php endif; ?>
			</div>
		</article>
	<?php endwhile; ?>
</main>

<?php
get_footer();
