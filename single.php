<?php get_header(); ?>
<?php // ignore post from related posts in sidebar
	prinz_ignorePost($post->ID); ?>

<div id="content" class="clearfloat">
  <div id="articleColumn">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <h2><?php the_title(); ?></h2>
      <small>
      <?php the_time(__('M jS, Y', PRiNZ_DOMAIN)); ?>
      |
      <?php _e('By', PRiNZ_DOMAIN);?>
      <?php the_author_posts_link(); ?>
      |
      <?php _e('Category:', PRiNZ_DOMAIN);?>
      <?php the_category(', ') ?>
      <?php edit_post_link('Edit', ' | ', ''); ?>
      </small>
      <div class="entry">
        <?php if ( is_active_sidebar( 'abovepost' ) ) : // Widgetized area between post title and post content ?>
        <?php dynamic_sidebar( 'abovepost' ); ?>
        <?php else : ?>
        <?php endif; ?>
        <?php the_content(); ?>
        <?php if ( is_active_sidebar( 'belowpost' ) ) :  // Widgetized area below post content ?>
        <?php dynamic_sidebar( 'belowpost' ); ?>
        <?php else : ?>
        <?php endif; ?>
        <?php wp_link_pages("<p><strong>" . __('Pages',  PRiNZ_DOMAIN) . ":</strong>", '</p>', __('number', PRiNZ_DOMAIN)); ?>
      </div>
      <?php if ( function_exists('the_tags') ) {
  			the_tags('<span class="tags"><strong>'.__('Tags:', PRiNZ_DOMAIN).'</strong> ', ', ', '</span>'); } ?>
    </div>
    <div style="clear:both;"></div>
    <?php comments_template(); ?>
    <?php endwhile; else: ?>
    <p><?php __('Sorry, no posts matched your criteria.', PRiNZ_DOMAIN);?></p>
    <?php endif; ?>
  </div>
  <div id="rightcolumn" class="column">
    <?php get_sidebar(); ?>
  </div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>