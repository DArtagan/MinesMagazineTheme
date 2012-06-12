<?php get_header(); ?>

	<div id="content">
		<h1>Hello Test!</h1>
		<p><?php CurrentCategory() ?></p>
		<p><?php echo is_category() ?></p>
		<p><?php echo is_archive() ?></p>
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>