
<?php get_header(); ?>

<?php get_sidebar(); ?>

<div id="slider">
  <?php if ( function_exists( 'get_wp_parallax_content_slider' ) ) {
    get_wp_parallax_content_slider();
  } ?>
</div>

<div id="content" class="clearfloat">
  
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
      <h3><a href="<?php the_permalink() ?>" rel="bookmark" class="title">
        <?php the_title(); ?>
      </a></h3>
      <h4>By <?php the_author(); ?></h4>
      <?php if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) { // this is the default WordPress post thumbnail function
		    the_post_thumbnail(('featured-image'), array('class' =>  ""));
			} ?>
      <?php the_excerpt(); ?>
    </div>
    <?php endwhile; ?>
    <?php wp_reset_query(); ?>
  </div>
  <!--END LEFTCOL-->
  <div class="rightcon">
  <?php
  $display_categories = explode(",",prinz_get_option('prinz_homecats'));
  for ($x = 0; $x < sizeof($display_categories); ++$x) {
  ?>
      <?php $homecats_query = new WP_Query('showposts='.prinz_get_option('prinz_homecatsnumber').'&cat='.current($display_categories)); ?>
      <?php // Name and link of each category headline gets printed	?>
      <?php next($display_categories); ?>
      <?php while ($homecats_query->have_posts()) : $homecats_query->the_post(); ?>
        <div class="<?php echo ($x <= sizeof($display_categories)/2 ? 'centercol' : 'rightcol'); ?>">
          <h4>
            <?php wp_list_categories("include=".current($display_categories).";&title_li=&style=none"); ?>
          </h4>
          <h3><a href="<?php the_permalink() ?>" rel="bookmark" class="title">
            <?php the_title(); ?>
          </a></h3>
          <h4>By <?php the_author(); ?></h4>
          <?php if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) { // this is the default WordPress post thumbnail function
    		    the_post_thumbnail(('rightcol-image'), array('class' =>  "alignleft"));
    			} ?>
          <?php the_excerpt() ; ?>
        </div>
      <?php endwhile; ?>
      <?php wp_reset_query(); ?>
    <?php } ?>
  </div>
</div>
<!--END CONTENT-->
<?php get_footer(); ?>
