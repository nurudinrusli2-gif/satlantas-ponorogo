<?php
/**
 * Template Name: Tilang & ETLE
 * Template Post Type: page
 *
 * @package Satlantas_Ponorogo
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

<main id="primary" class="site-main sim-document-page">
	<article class="sim-document" aria-labelledby="tilang-etle-title">
		<header class="sim-document__header">
			<p><?php esc_html_e( 'Pelayanan', 'satlantas-ponorogo' ); ?></p>
			<h1 id="tilang-etle-title"><?php the_title(); ?></h1>
		</header>

		<div class="sim-document__body sim-document__content entry-content">
			<?php the_content(); ?>
		</div>
	</article>
</main>

<?php

endwhile;

get_footer();