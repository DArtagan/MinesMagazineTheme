<?php
/*
Template Name: Recent Issues
*/
?>
<?php get_header(); ?>

	<div id="content">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2><?php the_title(); ?></h2>
		
      <div id="nav_inset">
        <ul>
          <li><a href="#PDFarchive">PDF Archive</a></li>
          <li><a href="#100YearArchive">100 Year Archive</a></li>
        </ul>
      </div>
    
			<div class="issue-images" style="padding-top: 15px;">
				<p style="padding-bottom: 5px;">Issues from the new website:</p>
				<ul>
				<?php 
					$arg = array('child_of'=>408, 'orderby'=>'id', 'order'=>'desc');
					$issues=  get_categories($arg);
                                        $issueCount = 0;
					foreach($issues as $issue) {
            $thePost = get_posts(array('category__and' => array($issue->term_id, 200)));
            $issueCount++;
            //var_dump($issue);
            //$leadPost = query_posts(array('category__and' => array($issue->term_id,200)));
            //$issueImage = get_the_post_thumbnail( $post_id, 'thumbnail', $attr );
                                                if($issueCount == 5) echo '<li style="height: 163px; width: 100px;">&nbsp;</li>';
						echo '<li><a href="http://minesmagazine.com/?cat=' . $issue->cat_ID . '">' . get_the_post_thumbnail($thePost[0]->ID) . '<div>' . $issue->cat_name . '</div></a></li>'; 
					} 
				?>
				</ul>
			</div>
			
			<div style="clear: both"></div>
			
			<div class="entry">
					 <?php the_content("<p class=\"serif\">" . __('Read the rest of this page', 'branfordmagazine') ." &raquo;</p>"); ?>

					<?php wp_link_pages("<p><strong>" . __('Pages', 'branfordmagazine') . ":</strong>", '</p>', __('number','branfordmagazine')); ?>

			</div>
		</div>
		<?php endwhile; endif; ?>
	<?php edit_post_link('Edit', '<p>', '</p>'); ?>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
