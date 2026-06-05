<?php
/**
 * Single post template.
 *
 * @package Satlantas_Ponorogo
 */

get_header();
?>
<main id="primary" class="site-main content-page">
	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-card' ); ?>>
			<header class="entry-header">
				<p class="section-eyebrow"><?php echo esc_html( get_the_date( 'd M Y' ) ); ?></p>
				<h1><?php the_title(); ?></h1>
			</header>
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="entry-featured"><?php the_post_thumbnail( 'large' ); ?></div>
			<?php endif; ?>
			<div class="entry-content">
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</div>
			<footer class="entry-footer">
				<?php the_tags( '<span>', '</span><span>', '</span>' ); ?>
			</footer>
		</article>
	<?php endwhile; ?>
</main>
<?php
get_footer();
