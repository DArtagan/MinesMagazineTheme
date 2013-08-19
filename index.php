
<?php get_header(); ?>

<div id="content" class="clearfloat">

  <div id="feature">

  </div>

  <div>
    <?php if ( is_active_sidebar( 'belowtabbed' ) ) : // Widgetized area below the tabbed content
      dynamic_sidebar( 'belowtabbed' );
      else :
      endif; 
    ?>
  </div>

  <div id="leftcol">
    <?php 
      $args = array( 
        'posts_per_page' => '-1',
        'orderby' => 'meta_value_num',
        'meta_key' => 'MM_homepageSetup_rank',
        'order' => 'ASC',
        'tax_query' => array(
          array(
            'taxonomy' => 'category',
            'field' => 'id',
            'terms' => array( MM_currentIssueID() ),
            'operator' => 'AND',
          )
        ),
        'meta_query' => array(
          array(
            'key' => 'MM_homepageSetup_rank',
            'value' => '0',
            'compare' => '>'
          ),
          array(
            'key' => 'MM_homepageSetup_column',
            'value' => 'left',
          )
        )
      );
      $article_query = new WP_Query( $args ); ?>
    <?php while ($article_query->have_posts()) : $article_query->the_post(); ?>
    <div class="post">
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

  <div id="centercol">
    
  </div>

  <div id="rightcol">
    <?php get_sidebar(); ?>  
  </div>

</div>

<?php get_footer(); ?>
