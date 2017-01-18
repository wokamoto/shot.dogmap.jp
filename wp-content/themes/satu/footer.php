		</div><!-- .container -->
	</div><!-- #main -->

	<footer id="footer" class="site-footer" itemscope itemtype="http://schema.org/WPFooter">

		<?php get_template_part( 'sidebar' ); // Loads sidebar.php template file. ?>

		<div class="copyright">
			<div class="container">

				<?php printf( esc_html__( 'Proudly powered by %s', 'satu' ), '<a href="https://wordpress.org/" rel="designer">WordPress</a>' ); ?>
				<span class="sep"> | </span>
				<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'satu' ), 'Satu', '<a href="http://satrya.me/" rel="designer">Satrya</a>' ); ?>

			</div>
		</div>

	</footer><!-- #footer -->

</div> <!-- #page .site -->

<?php wp_footer(); ?>
</body>
</html>
