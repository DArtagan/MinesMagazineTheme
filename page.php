<?php get_header(); ?>

<div id="content" class="clearfloat">
  <div id="articleColumn" class="column">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="post" id="post-<?php the_ID(); ?>">
      <h2>
        <?php the_title(); ?>
      </h2>
      <div class="entry">
        <?php the_content("<p class=\"serif\">" . __('Read the rest of this page',  PRiNZ_DOMAIN) ." &raquo;</p>"); ?>
        <?php wp_link_pages("<p><strong>" . __('Pages',  PRiNZ_DOMAIN) . ":</strong>", '</p>', __('number', PRiNZ_DOMAIN)); ?>
      </div>
    </div>
    <?php endwhile; endif; ?>
    <?php edit_post_link('Edit', '<p>', '</p>'); ?>
  </div>
  <div id="rightcolumn" class="column">
    <?php get_sidebar(); ?>
  </div>
</div>
<?php get_footer(); ?>