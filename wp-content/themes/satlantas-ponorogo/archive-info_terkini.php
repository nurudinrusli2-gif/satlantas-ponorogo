<?php
/**
 * Archive template for Informasi Terkini.
 *
 * @package Satlantas_Ponorogo
 */

get_header();
?>

<main id="primary" class="site-main listing-page traffic-archive">
	<header class="archive-header">
		<p class="section-eyebrow"><?php esc_html_e( 'Informasi Lalu Lintas', 'satlantas-ponorogo' ); ?></p>
		<h1><?php esc_html_e( 'Informasi Terkini', 'satlantas-ponorogo' ); ?></h1>
		<p><?php esc_html_e( 'Daftar informasi lalu lintas aktif Satlantas Polres Ponorogo.', 'satlantas-ponorogo' ); ?></p>
	</header>

	<div class="traffic-archive__list cpt-card-list">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php
				$kategori      = get_post_meta( get_the_ID(), 'kategori', true );
				$urutan_tampil = get_post_meta( get_the_ID(), 'urutan_tampil', true );
				$badge         = satlantas_get_informasi_lalu_lintas_category_badge( $kategori );
				?>
				<article <?php post_class( 'traffic-card cpt-card' ); ?>>
					<div class="cpt-meta">
						<span class="traffic-status <?php echo esc_attr( $badge['class'] ); ?>"><?php echo esc_html( $badge['label'] ); ?></span>
						<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date( 'd M Y' ) ); ?></time>
						<?php if ( $urutan_tampil ) : ?>
							<span><?php echo esc_html( sprintf( __( 'Urutan %s', 'satlantas-ponorogo' ), $urutan_tampil ) ); ?></span>
						<?php endif; ?>
					</div>
					<div class="traffic-card__body">
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_content( null, false, get_the_ID() ) ), 28, '...' ) ); ?></p>
					</div>
					<div class="cpt-actions">
						<a class="read-more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Selengkapnya', 'satlantas-ponorogo' ); ?></a>
					</div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<article class="traffic-empty cpt-empty">
				<span class="cpt-empty__icon"><?php esc_html_e( 'INFO', 'satlantas-ponorogo' ); ?></span>
				<h2><?php esc_html_e( 'Belum ada informasi aktif', 'satlantas-ponorogo' ); ?></h2>
				<p><?php esc_html_e( 'Belum ada informasi lalu lintas aktif saat ini.', 'satlantas-ponorogo' ); ?></p>
			</article>
		<?php endif; ?>
	</div>

	<?php the_posts_pagination(); ?>
</main>

<?php
get_footer();
