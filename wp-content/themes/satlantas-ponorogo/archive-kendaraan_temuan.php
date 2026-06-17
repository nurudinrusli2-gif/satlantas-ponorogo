<?php
/**
 * Archive template for Kendaraan Temuan.
 *
 * @package Satlantas_Ponorogo
 */

get_header();
?>

<main id="primary" class="site-main listing-page vehicle-archive">
	<header class="archive-header">
		<p class="section-eyebrow"><?php esc_html_e( 'Kendaraan Temuan', 'satlantas-ponorogo' ); ?></p>
		<h1><?php esc_html_e( 'Kendaraan Temuan', 'satlantas-ponorogo' ); ?></h1>
		<p><?php esc_html_e( 'Daftar kendaraan temuan berstatus diamankan.', 'satlantas-ponorogo' ); ?></p>
	</header>

	<div class="kendaraan-archive__list cpt-card-list">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php
				$nomor_polisi    = get_post_meta( get_the_ID(), 'nomor_polisi', true );
				$merk_kendaraan  = get_post_meta( get_the_ID(), 'merk_kendaraan', true );
				$jenis_kendaraan = get_post_meta( get_the_ID(), 'jenis_kendaraan', true );
				$warna           = get_post_meta( get_the_ID(), 'warna', true );
				$lokasi_temuan   = get_post_meta( get_the_ID(), 'lokasi_temuan', true );
				$tanggal_temuan  = get_post_meta( get_the_ID(), 'tanggal_temuan', true );
				$status_badge    = satlantas_get_kendaraan_temuan_status_badge( get_post_meta( get_the_ID(), 'status', true ) ?: 'diamankan' );
				?>
				<article <?php post_class( 'kendaraan-card kendaraan-card--list cpt-card' ); ?>>
					<div class="kendaraan-card__rail">
						<span class="kendaraan-card__badge <?php echo esc_attr( $status_badge['class'] ); ?>"><?php echo esc_html( $status_badge['label'] ); ?></span>
						<strong><?php echo esc_html( $nomor_polisi ? $nomor_polisi : get_the_title() ); ?></strong>
						<small><?php echo esc_html( trim( $merk_kendaraan . ( $jenis_kendaraan ? ' - ' . $jenis_kendaraan : '' ) ) ); ?></small>
					</div>
					<div class="kendaraan-card__body">
						<div class="cpt-meta">
							<?php if ( $tanggal_temuan ) : ?>
								<time datetime="<?php echo esc_attr( $tanggal_temuan ); ?>"><?php echo esc_html( satlantas_format_kendaraan_temuan_date( $tanggal_temuan ) ); ?></time>
							<?php endif; ?>
							<?php if ( $warna ) : ?>
								<span><?php echo esc_html( $warna ); ?></span>
							<?php endif; ?>
						</div>
						<h2><a href="<?php the_permalink(); ?>"><?php echo esc_html( $nomor_polisi ? $nomor_polisi : get_the_title() ); ?></a></h2>
						<p><?php echo esc_html( wp_trim_words( $lokasi_temuan ? $lokasi_temuan : get_the_title(), 24, '...' ) ); ?></p>
					</div>
					<div class="cpt-actions">
						<a class="read-more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Detail', 'satlantas-ponorogo' ); ?></a>
					</div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<article class="kendaraan-empty cpt-empty">
				<span class="cpt-empty__icon"><?php esc_html_e( 'DATA', 'satlantas-ponorogo' ); ?></span>
				<h2><?php esc_html_e( 'Belum ada kendaraan temuan aktif', 'satlantas-ponorogo' ); ?></h2>
				<p><?php esc_html_e( 'Belum ada kendaraan temuan berstatus diamankan saat ini.', 'satlantas-ponorogo' ); ?></p>
			</article>
		<?php endif; ?>
	</div>

	<?php the_posts_pagination(); ?>
</main>

<?php
get_footer();
