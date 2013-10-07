<?php get_header(); ?>

<div id="content" class="clearfloat">
  <div id="articleColumn" class="column">
    <?php if (have_posts()) : ?>
    <h2 class="pagetitle">
      <?php _e('Search Results', PRiNZ_DOMAIN);?>
    </h2>
    <?php while (have_posts()) : the_post(); ?>
    <div class="post">
      <h4 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php __('Permanent Link to', PRiNZ_DOMAIN);?> <?php the_title(); ?>">
        <?php the_title(); ?>
        </a></h4>
      <small>
      <?php the_time(__ ('F jS, Y',  PRiNZ_DOMAIN)) ?>
      </small>
      <div class="entry">
        <?php the_excerpt() ?>
      </div>
      <hr />
      <br />
    </div>
    <?php endwhile; ?>
    <div class="navigation">
      <div class="alignleft">
        <?php next_posts_link(__('Previous entries', PRiNZ_DOMAIN)) ?>
      </div>
      <div class="alignright">
        <?php previous_posts_link(__('Next entries', PRiNZ_DOMAIN)) ?>
      </div>
    </div>
    <?php else : ?>
    <h2 class="center">
      <?php _e('No posts found. Try a different search?', PRiNZ_DOMAIN);?>
    </h2>
    <?php get_search_form(); ?>
    <?php endif; ?>
  </div>
  <div id="rightcolumn" class="column">
    <?php get_sidebar(); ?>
  </div
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>