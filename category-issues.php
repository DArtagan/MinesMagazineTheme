<?php get_header(); ?>

<div id="content" class="clearfloat">
  <div id="articleColumn" class="column">
    <?php
		$issue = get_query_var('cat');
		$departments= explode(",",$MM_department_order);
		$verbose= explode(",",$MM_verbose);
		foreach ($departments as $department) {
			$stories['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'terms' => array($department),
					'field' => 'ID',
				),
				array(
					'taxonomy' => 'category',
					'terms' => array($issue),
					'field' => 'ID',
				),
			);
			query_posts($stories);
			if(have_posts()) {
				echo '<div class="' . get_cat_name($department) . '" style="clear: both">';
				echo '<h2>' . get_cat_name($department) . '</h2>';
				if(in_array($department,$verbose)) {
					IssuesArchiveLoop(true);
				} else {
					IssuesArchiveLoop(false);
				}
				echo '</div>';
			}
		}
	?>
  </div>
  <div id="rightcolumn" class="column">
    <?php get_sidebar(); ?>
  </div>
</div>
<?php get_footer(); ?>