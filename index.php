
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
  $args = array( 
    'posts_per_page' => '-1',
    'orderby' => 'meta_value_num',
    'meta_key' => 'MM_homepageOrder_rank',
    'order' => 'ASC',
    'tax_query' => array(
        array(
            'taxonomy' => 'category',
            'field' => 'id',
            'terms' => array( MM_currentIssueID(), get_cat_id(prinz_get_option('prinz_featured') ) ),
            //'terms' => array( 601, 4 ),
            'operator' => 'AND',
        )
    ),
    'meta_query' => array(
      array(
        'key' => 'MM_homepageOrder_rank',
        'value' => '0',
        'compare' => '>'
      )
    )
  );
  $featured_query = new WP_Query( $args ); ?>
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
        if (have_posts()) : while (have_posts()) : the_post();
      ?>  
          <h3><a href="<?php the_permalink(); ?>" rel="bookmark" class="title">
            <?php the_title(); ?>
          </a></h3> 
          <?php the_excerpt(); ?>  
      <?php 
        //endforeach; 
        endwhile; endif;
        wp_reset_query();
      ?> 
    </div>

  </div>
</div>
<!--END CONTENT-->
<?php get_footer(); ?>
