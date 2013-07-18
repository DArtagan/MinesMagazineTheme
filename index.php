
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
      global $childoptions;
      foreach ($childoptions as $value) {
        if (get_option( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; }
        else { $$value['id'] = get_option( $value['id'] ); }
      }
    ?>

    <div id="content">
      <?php
        $args = array( 'category' => CurrentIssueID(), 'post_type' =>  'post', 'posts_per_page' => -1 ); 
        $postslist = get_posts( $args );    
        foreach ($postslist as $post) :  setup_postdata($post); 
        ?>  
          <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2> 
          <?php the_excerpt(); ?>  
        <?php endforeach; ?> 
    </div>

  </div>
</div>
<!--END CONTENT-->
<?php get_footer(); ?>
