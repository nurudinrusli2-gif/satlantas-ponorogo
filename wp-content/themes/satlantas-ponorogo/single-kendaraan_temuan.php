<?php
/**
 * Single template for Kendaraan Temuan.
 *
 * @package Satlantas_Ponorogo
 */

get_header();
?>

<main id="primary" class="site-main content-page vehicle-single">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php
		$nomor_polisi    = get_post_meta( get_the_ID(), 'nomor_polisi', true );
		$merk_kendaraan  = get_post_meta( get_the_ID(), 'merk_kendaraan', true );
		$jenis_kendaraan = get_post_meta( get_the_ID(), 'jenis_kendaraan', true );
		$warna           = get_post_meta( get_the_ID(), 'warna', true );
		$lokasi_temuan   = get_post_meta( get_the_ID(), 'lokasi_temuan', true );
		$tanggal_temuan  = get_post_meta( get_the_ID(), 'tanggal_temuan', true );
		$status          = get_post_meta( get_the_ID(), 'status', true ) ?: 'diamankan';
		$kontak_petugas  = get_post_meta( get_the_ID(), 'kontak_petugas', true );
		$nomor_telepon   = get_post_meta( get_the_ID(), 'nomor_telepon', true );
		$status_badge    = satlantas_get_kendaraan_temuan_status_badge( $status );
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-card vehicle-entry' ); ?>>
			<header class="entry-header">
				<p class="section-eyebrow"><?php esc_html_e( 'Kendaraan Temuan', 'satlantas-ponorogo' ); ?></p>
				<h1><?php echo esc_html( $nomor_polisi ? $nomor_polisi : get_the_title() ); ?></h1>
				<div class="cpt-meta">
					<span class="cpt-badge <?php echo esc_attr( $status_badge['class'] ); ?>"><?php echo esc_html( $status_badge['label'] ); ?></span>
					<?php if ( $tanggal_temuan ) : ?>
						<time datetime="<?php echo esc_attr( $tanggal_temuan ); ?>"><?php echo esc_html( satlantas_format_kendaraan_temuan_date( $tanggal_temuan ) ); ?></time>
					<?php endif; ?>
					<?php if ( $warna ) : ?>
						<span><?php echo esc_html( $warna ); ?></span>
					<?php endif; ?>
				</div>
			</header>

			<div class="cpt-single-layout">
				<aside class="cpt-meta-panel vehicle-meta-panel" aria-label="<?php esc_attr_e( 'Metadata kendaraan temuan', 'satlantas-ponorogo' ); ?>">
					<h2><?php esc_html_e( 'Detail Kendaraan', 'satlantas-ponorogo' ); ?></h2>
					<div class="cpt-meta-panel__item">
						<span><?php esc_html_e( 'Nomor Polisi', 'satlantas-ponorogo' ); ?></span>
						<strong><?php echo esc_html( $nomor_polisi ? $nomor_polisi : get_the_title() ); ?></strong>
					</div>
					<?php if ( $merk_kendaraan ) : ?>
						<div class="cpt-meta-panel__item">
							<span><?php esc_html_e( 'Merk', 'satlantas-ponorogo' ); ?></span>
							<strong><?php echo esc_html( $merk_kendaraan ); ?></strong>
						</div>
					<?php endif; ?>
					<?php if ( $jenis_kendaraan ) : ?>
						<div class="cpt-meta-panel__item">
							<span><?php esc_html_e( 'Jenis', 'satlantas-ponorogo' ); ?></span>
							<strong><?php echo esc_html( $jenis_kendaraan ); ?></strong>
						</div>
					<?php endif; ?>
					<?php if ( $warna ) : ?>
						<div class="cpt-meta-panel__item">
							<span><?php esc_html_e( 'Warna', 'satlantas-ponorogo' ); ?></span>
							<strong><?php echo esc_html( $warna ); ?></strong>
						</div>
					<?php endif; ?>
					<?php if ( $lokasi_temuan ) : ?>
						<div class="cpt-meta-panel__item">
							<span><?php esc_html_e( 'Lokasi Temuan', 'satlantas-ponorogo' ); ?></span>
							<strong><?php echo esc_html( $lokasi_temuan ); ?></strong>
						</div>
					<?php endif; ?>
					<?php if ( $kontak_petugas ) : ?>
						<div class="cpt-meta-panel__item">
							<span><?php esc_html_e( 'Kontak Petugas', 'satlantas-ponorogo' ); ?></span>
							<strong><?php echo esc_html( $kontak_petugas ); ?></strong>
						</div>
					<?php endif; ?>
					<?php if ( $nomor_telepon ) : ?>
						<div class="cpt-meta-panel__item">
							<span><?php esc_html_e( 'Nomor Telepon', 'satlantas-ponorogo' ); ?></span>
							<strong><?php echo esc_html( $nomor_telepon ); ?></strong>
						</div>
						<a class="button-primary" href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $nomor_telepon ) ); ?>"><?php esc_html_e( 'Hubungi Petugas', 'satlantas-ponorogo' ); ?></a>
					<?php endif; ?>
				</aside>

				<div class="entry-content cpt-main-content">
					<p><?php esc_html_e( 'Data kendaraan temuan berikut dipublikasikan untuk membantu proses identifikasi dan koordinasi pengambilan.', 'satlantas-ponorogo' ); ?></p>
					<?php if ( $tanggal_temuan ) : ?>
						<div class="vehicle-detail-callout">
							<strong><?php esc_html_e( 'Tanggal Temuan', 'satlantas-ponorogo' ); ?></strong>
							<span><?php echo esc_html( satlantas_format_kendaraan_temuan_date( $tanggal_temuan ) ); ?></span>
						</div>
					<?php endif; ?>
					<?php if ( $lokasi_temuan ) : ?>
						<div class="vehicle-detail-callout">
							<strong><?php esc_html_e( 'Lokasi Temuan', 'satlantas-ponorogo' ); ?></strong>
							<span><?php echo esc_html( $lokasi_temuan ); ?></span>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</article>
	<?php endwhile; ?>
</main>

<?php
get_footer();

