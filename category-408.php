<?php get_header(); ?>
<?php include (TEMPLATEPATH.'/tools/get-theme-options.php'); ?>
<?php
global $childoptions;
foreach ($childoptions as $value) {
    if (get_option( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; }
    else { $$value['id'] = get_option( $value['id'] ); }
    }
?>

<div id="content">
	<?php
		$issue = get_query_var('cat');
		$departments= explode(",",$bmct_department_order);
		$verbose= explode(",",$bmct_verbose);
		foreach ($departments as $department) {
			echo '<div class="' . get_cat_name($department) . '" style="clear: both">';
			echo '<h2>' . get_cat_name($department) . '</h2>';
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
			if(in_array($department,$verbose)) {
				IssuesArchiveLoop(true);
			} else {
				IssuesArchiveLoop(false);
			}
			echo '</div>';
		}
	?>

</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
