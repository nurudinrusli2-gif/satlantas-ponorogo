<?php
/**
 * Search template.
 *
 * @package Satlantas_Ponorogo
 */

get_header();
?>
<main id="primary" class="site-main listing-page">
	<header class="archive-header">
		<p class="section-eyebrow">Pencarian</p>
		<h1><?php printf( esc_html__( 'Hasil pencarian: %s', 'satlantas-ponorogo' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
		<?php get_search_form(); ?>
	</header>
	<div class="news-grid archive-grid">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class( 'news-card' ); ?>>
					<a href="<?php the_permalink(); ?>" class="news-thumb">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'medium_large' ); ?>
						<?php else : ?>
							<img src="<?php echo satlantas_asset( 'assets/images/news-group.jpg' ); ?>" alt="">
						<?php endif; ?>
					</a>
					<div class="news-body">
						<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date( 'd M Y' ) ); ?></time>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p><?php echo satlantas_excerpt( 18 ); ?></p>
						<a class="read-more" href="<?php the_permalink(); ?>">Selengkapnya</a>
					</div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Tidak ada hasil yang cocok.', 'satlantas-ponorogo' ); ?></p>
		<?php endif; ?>
	</div>
	<?php the_posts_pagination(); ?>
</main>
<?php
get_footer();
