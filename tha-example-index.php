<?php THA::html_before(); ?><html>
<head>
	<!-- Let WordPress manage the document title with: add_theme_support( 'title-tag' ) -->
	<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); 	?>" type="text/css" media="all" />

	<?php
    THA::head_top();    // before wp_head
    wp_head();          // wp_head
    THA::head_bottom(); // after wp_head
    ?>
</head>
<body <?php body_class(); ?>>
<?php THA::body_top(); ?>

	<!-- ... -->

	<?php THA::header_before(); ?>
	<div id="header">
		<?php THA::header_top(); ?>

		<h1><?php bloginfo( 'name' ); ?></h1>
		<p class="dscription"><?php bloginfo( 'description' ); ?></p>

		<?php THA::header_bottom(); ?>
	</div><!-- #header -->
	<?php THA::header_after(); ?>

	<!-- ... -->

	<?php THA::content_before(); ?>
	<div id="content">
		<?php THA::content_top(); ?>

		<!-- ... -->

        <?php THA::primary_before(); ?>
		<div id="primary">
            <?php THA::primary_top(); ?>

			<!-- ... -->

			<div id="main">

				<!-- This roughly encapsulates The Loop portion of the layout -->
				<?php if( have_posts() ) : ?>

					<?php THA::content_while_before(); ?>

					<?php while( have_posts() ) : the_post(); ?>

						<?php THA::entry_before(); ?>
						<!-- Post Entry Begin -->
						<div <?php post_class( 'entry' ); ?>>
							<?php THA::entry_top(); ?>
							<h2><?php the_title(); ?></h2>

							<?php THA::entry_content_before(); ?>
							<div class="itemtext">
								<?php THA::entry_content_top(); ?>

								<?php the_content(); ?>

								<?php THA::entry_content_bottom(); ?>
							</div><!-- .itemtext -->
							<?php THA::entry_content_after(); ?>

							<!-- ... -->

							<?php THA::entry_bottom(); ?>
						</div>
						<!-- Post Entry End -->
						<?php THA::entry_after(); ?>

						<!-- ... -->

                        <?php THA::comments_before(); ?>
						<!-- Post Comments Begin -->
                        <?php comments_template(); ?>
						<!-- post Comments End -->
                        <?php THA::comments_after(); ?>

					<?php endwhile; ?>

					<?php THA::content_while_after(); ?>

				<?php endif; ?>
				<!-- Close The Loop -->

			<!-- ... -->

			</div><!-- #main -->

			<!-- ... -->

			<?php THA::primary_bottom(); ?>
		</div><!-- #primary -->
		<?php THA::primary_after(); ?>

		<!-- ... -->

        <?php THA::main_sidebar_before(); ?>
		<div id="secondary">
            <?php THA::main_sidebar_top(); ?>
            <?php dynamic_sidebar( 'sidebar' ); ?>
            <?php THA::main_sidebar_bottom(); ?>
		</div><!-- #sidebar-->
        <?php THA::main_sidebar_after(); ?>

		<!-- ... -->

		<?php THA::content_bottom(); ?>
	</div><!-- #content -->
	<?php THA::content_after(); ?>

	<!-- ... -->

	<?php THA::footer_before(); ?>
	<div id="footer">
		<?php THA::footer_top(); ?>

		<h3>Footer</h3>
		<p>This is some sample footer text.</p>

		<?php THA::footer_bottom(); ?>
	</div><!-- #footer -->
	<?php THA::footer_after(); ?>

	<!-- ... -->

	<?php tha::body_bottom(); ?>

	<?php wp_footer(); ?>
</body>
</html>
