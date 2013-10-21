<?php
/*
Template Name: Recent Issues
*/
?>

<?php get_header(); ?>

<div id="content" class="clearfloat">
  <div id="articleColumn" class="column">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="post" id="post-<?php the_ID(); ?>">
      <h2>
        <?php the_title(); ?>
      </h2>
      <div>
        <ul>
          <li><a href="#WebIssues">Issues on the Web</a></li>
          <li><a href="#PDFarchive">PDF Archive</a></li>
          <li><a href="#100YearArchive">100 Year Archive</a></li>
        </ul>
      </div>
      <div id="issueTiles">
        <a name="WebIssues"></a>
        <h3 style="padding-bottom: 5px;">Issues on the Web</h3>
        <ul>
        <?php 
          $arg = array('child_of'=>408, 'orderby'=>'id', 'order'=>'desc');
          $issues=  get_categories($arg);
          foreach($issues as $issue) {
            $thePost = get_posts(array('category__and' => array($issue->term_id, 200)));
            echo '<li><a href="http://minesmagazine.com/?cat=' . $issue->cat_ID . '">' . get_the_post_thumbnail($thePost[0]->ID, 'cover-thumbnail') . '<p>' . $issue->cat_name . '</p></a></li>'; 
          }
          // Load XML file of external mines magazines
          if (file_exists(STYLESHEETPATH."/archives.xml")) {
            $xml = simplexml_load_file(STYLESHEETPATH."/archives.xml");
            foreach ($xml->issue as $issue) {
              echo '<li><a href="' . $issue->link . '"><img alt="' . $issue->img_alt . '" src="' . $issue->img_src . '"><p>' . $issue->name . '</p></a></li>'; 
            }
          }
        ?>
        </ul>
      </div>
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