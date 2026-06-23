<?php
/**
 * Theme footer.
 *
 * @package Satlantas_Ponorogo
 */
?>
	<?php $visitor_counts = function_exists( 'satlantas_get_visitor_counts' ) ? satlantas_get_visitor_counts() : array( 'today' => 0, 'month' => 0, 'total' => 0 ); ?>
	<footer class="site-footer">
		<div class="footer-grid">
			<div class="footer-brand">
				<div class="footer-logo">
					<img src="<?php echo satlantas_asset( 'assets/images/logo-satlantas.png' ); ?>" alt="<?php esc_attr_e( 'Satlantas Polres Ponorogo', 'satlantas-ponorogo' ); ?>">
					<strong>Satlantas<br>Polres Ponorogo</strong>
				</div>
				<ul class="footer-contact">
					<li><?php satlantas_icon( 'map' ); ?><span>Jl. Bhayangkara No. 60, Bangunsari, Kec. Ponorogo, Kabupaten Ponorogo, Jawa Timur 63413</span></li>
					<li><?php satlantas_icon( 'info' ); ?><span>satlantasponorogo@gmail.com</span></li>
					<li><?php satlantas_icon( 'call' ); ?><span>0352-000-000</span></li>
				</ul>
			</div>

			<nav class="footer-menu" aria-label="<?php esc_attr_e( 'Footer navigation', 'satlantas-ponorogo' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'fallback_cb'    => 'satlantas_fallback_menu',
					)
				);
				?>
			</nav>

			<div class="footer-map">
				<img src="<?php echo satlantas_asset( 'assets/images/footer-map.jpg' ); ?>" alt="<?php esc_attr_e( 'Peta lokasi Satlantas Ponorogo', 'satlantas-ponorogo' ); ?>">
				<div class="footer-hours">
					<strong>Jam Layanan:</strong>
					<span>Senin - Jumat: 08.00 - 14.00 WIB</span>
					<span>Sabtu: 08.00 - 10.30 WIB</span>
					<span>Minggu / Hari Libur: Tutup</span>
				</div>
			</div>
		</div>
		<div class="footer-bottom">
			<span><?php esc_html_e( 'Pengunjung', 'satlantas-ponorogo' ); ?></span>
			<span><?php esc_html_e( 'Hari ini:', 'satlantas-ponorogo' ); ?> <b data-visitor-count="today"><?php echo esc_html( number_format_i18n( $visitor_counts['today'] ) ); ?></b></span>
			<span><?php esc_html_e( 'Bulan ini:', 'satlantas-ponorogo' ); ?> <b data-visitor-count="month"><?php echo esc_html( number_format_i18n( $visitor_counts['month'] ) ); ?></b></span>
			<span><?php esc_html_e( 'Total:', 'satlantas-ponorogo' ); ?> <b data-visitor-count="total"><?php echo esc_html( number_format_i18n( $visitor_counts['total'] ) ); ?></b></span>
			<span class="copyright">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. All Rights Reserved.</span>
		</div>
	</footer>
<?php wp_footer(); ?>
</body>
</html>
