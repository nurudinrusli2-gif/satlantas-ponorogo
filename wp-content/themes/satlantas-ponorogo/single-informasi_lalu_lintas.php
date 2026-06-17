<?php
/**
 * Single template for Informasi Lalu Lintas.
 *
 * @package Satlantas_Ponorogo
 */

get_header();
?>

<main id="primary" class="site-main content-page traffic-single">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php
		$kategori      = get_post_meta( get_the_ID(), 'kategori', true );
		$urutan_tampil = get_post_meta( get_the_ID(), 'urutan_tampil', true );
		$status        = get_post_meta( get_the_ID(), 'status', true ) ?: 'aktif';
		$badge         = satlantas_get_informasi_lalu_lintas_category_badge( $kategori );
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-card traffic-entry' ); ?>>
			<header class="entry-header">
				<p class="section-eyebrow"><?php esc_html_e( 'Informasi Lalu Lintas', 'satlantas-ponorogo' ); ?></p>
				<h1><?php the_title(); ?></h1>
				<div class="cpt-meta">
					<span class="traffic-status <?php echo esc_attr( $badge['class'] ); ?>"><?php echo esc_html( $badge['label'] ); ?></span>
					<span class="cpt-badge <?php echo 'aktif' === $status ? 'cpt-badge--success' : 'cpt-badge--warning'; ?>"><?php echo esc_html( 'aktif' === $status ? __( 'Aktif', 'satlantas-ponorogo' ) : __( 'Nonaktif', 'satlantas-ponorogo' ) ); ?></span>
					<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date( 'd M Y' ) ); ?></time>
					<?php if ( $urutan_tampil ) : ?>
						<span><?php echo esc_html( sprintf( __( 'Urutan tampil %s', 'satlantas-ponorogo' ), $urutan_tampil ) ); ?></span>
					<?php endif; ?>
				</div>
			</header>

			<div class="cpt-single-layout">
				<aside class="cpt-meta-panel" aria-label="<?php esc_attr_e( 'Metadata informasi lalu lintas', 'satlantas-ponorogo' ); ?>">
					<h2><?php esc_html_e( 'Detail Informasi', 'satlantas-ponorogo' ); ?></h2>
					<div class="cpt-meta-panel__item">
						<span><?php esc_html_e( 'Kategori', 'satlantas-ponorogo' ); ?></span>
						<strong><?php echo esc_html( $badge['label'] ); ?></strong>
					</div>
					<div class="cpt-meta-panel__item">
						<span><?php esc_html_e( 'Status', 'satlantas-ponorogo' ); ?></span>
						<strong><?php echo esc_html( 'aktif' === $status ? __( 'Aktif', 'satlantas-ponorogo' ) : __( 'Nonaktif', 'satlantas-ponorogo' ) ); ?></strong>
					</div>
					<div class="cpt-meta-panel__item">
						<span><?php esc_html_e( 'Urutan Tampil', 'satlantas-ponorogo' ); ?></span>
						<strong><?php echo esc_html( $urutan_tampil ? $urutan_tampil : '-' ); ?></strong>
					</div>
					<div class="cpt-meta-panel__item">
						<span><?php esc_html_e( 'Tanggal Publikasi', 'satlantas-ponorogo' ); ?></span>
						<strong><?php echo esc_html( get_the_date( 'd M Y' ) ); ?></strong>
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

