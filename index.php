<?php get_header(); ?>

<div id="content" class="clearfloat">
  <?php	//include(get_template_directory() . '/includes/ui.tabs.php');  // Include tabs with the lead story ?>
  <?php if ( function_exists( 'get_wp_parallax_content_slider' ) ) {
    get_wp_parallax_content_slider();
  } ?>
    
    <?php if ( is_active_sidebar( 'belowtabbed' ) ) : // Widgetized area below the tabbed content ?>
    <?php dynamic_sidebar( 'belowtabbed' ); ?>
    <?php else : ?>
    <?php endif; ?>
    
  <div id="leftcol" class="clearfloat">
    <?php 
// "Featured articles" module begins	  
	$featured_query = new WP_Query('cat='.get_cat_id(prinz_get_option('prinz_featured')).'&showposts='.prinz_get_option('prinz_featurednumber').'&offset='.prinz_get_option('prinz_featuredoffset')); ?>
    <h4>
      <?php 
	// name of the "featured articles" category gets printed	  
	wp_list_categories('include='.get_cat_id(prinz_get_option('prinz_featured')).'&title_li=&style=none'); ?>
    </h4>
    <?php while ($featured_query->have_posts()) : $featured_query->the_post(); ?>
    <div class="feature">
<?php if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) { // this is the default WordPress post thumbnail function
			the_post_thumbnail(('featured-image'), array('class' =>  ""));
			} ?>      
            <h3><a href="<?php the_permalink() ?>" rel="bookmark" class="title">
      <?php 
// title of the "featured articles"	  
	  the_title(); ?>
      </a></h3>
      <?php the_excerpt(); ?>
    </div>
    <?php endwhile; ?>
    <?php wp_reset_query(); ?>
  </div>
  <!--END LEFTCOL-->
  <div id="rightcol" class="clearfloat">
    <?php
$display_categories = explode(",",prinz_get_option('prinz_homecats'));
for ($x = 0; $x < sizeof($display_categories); ++$x) {
?>
    <div class="clearfloat">
      <?php $homecats_query = new WP_Query('showposts='.prinz_get_option('prinz_homecatsnumber').'&cat='.current($display_categories)); ?>
      <?php // Name and link of each category headline gets printed	?>
      <h4>
        <?php wp_list_categories("include=".current($display_categories).";&title_li=&style=none"); ?>
      </h4>
      <?php next($display_categories); ?>
      <?php while ($homecats_query->have_posts()) : $homecats_query->the_post(); ?>
      <?php if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) { // this is the default WordPress post thumbnail function
			the_post_thumbnail(('rightcol-image'), array('class' =>  "alignleft"));
			} ?>
      <h3><a href="<?php the_permalink() ?>" rel="bookmark" class="title">
      <?php // this is where title of the article gets printed 
	  the_title(); ?>
      </a></h3>
      <?php the_excerpt() ; ?>
      <?php endwhile; ?>
      <?php wp_reset_query(); ?>
    </div>
    <?php } ?>
  </div>
  <!--END RIGHTCOL-->
</div>
<!--END CONTENT-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
