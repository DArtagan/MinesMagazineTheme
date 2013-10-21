<?php get_header(); ?>

<div id="content" class="clearfloat">
    <?php
      $category = get_category( get_query_var( 'cat' ) );
      $issue_ID = $category->cat_ID;
      $args = array( 
        'posts_per_page' => '-1',
        'orderby' => 'meta_value_num',
        'meta_key' => 'MM_homepageSetup_rank',
        'order' => 'ASC',
        'tax_query' => array(
          array(
            'taxonomy' => 'category',
            'field' => 'id',
            'terms' => array( $issue_ID ),
            'operator' => 'AND',
          )
        ),
        'meta_query' => array(
          array(
            'key' => 'MM_homepageSetup_rank',
            'value' => '0',
            'compare' => '>'
          )
        )
      );
      $meta_stories = new WP_Query( $args );
      if($meta_stories->have_posts()) { 
        wp_reset_query(); ?>
        <div id="twoColumn">
          <div id="feature" class="column">
            <?php MM_homepageBox(MM_homepageStyleQuery( $issue_ID, 'feature' )); ?>
          </div>

          <div>
            <?php if ( is_active_sidebar( 'belowtabbed' ) ) : // Widgetized area below the tabbed content
              dynamic_sidebar( 'belowtabbed' );
              else :
              endif; 
            ?>
          </div>

          <div id="leftColumn" class="column">
            <?php MM_homepageBox(MM_homepageStyleQuery( $issue_ID, 'left' )); ?>
          </div>

          <div id="centerColumn" class="column">
            <?php MM_homepageBox(MM_homepageStyleQuery( $issue_ID, 'center' )); ?>
          </div>
        </div>

        <div id="rightColumn" class="column">
          <?php get_sidebar(); ?>
          <?php MM_homepageBox(MM_homepageStyleQuery( $issue_ID, 'right' )); ?>
        </div><?php
      } else { ?>
        <div id="articleColumn" class="column"><?
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
          } ?>
        </div>
        <div id="rightcolumn" class="column">
          <?php get_sidebar(); ?>
        </div><?php
      }
  ?>
</div>
<?php get_footer(); ?>