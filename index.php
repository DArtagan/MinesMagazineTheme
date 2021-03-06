<?php get_header(); ?>

<div id="content" class="clearfloat">

  <div id="twoColumn">
    <div id="feature" class="column">
      <?php MM_homepageBox(MM_homepageStyleQuery( MM_currentIssueID(), 'feature' )); ?>
    </div>

    <div>
      <?php if ( is_active_sidebar( 'belowtabbed' ) ) : // Widgetized area below the tabbed content
        dynamic_sidebar( 'belowtabbed' );
        else :
        endif; 
      ?>
    </div>

    <div id="leftColumn" class="column">
      <?php MM_homepageBox(MM_homepageStyleQuery( MM_currentIssueID(), 'left' )); ?>
    </div>

    <div id="centerColumn" class="column">
      <?php MM_homepageBox(MM_homepageStyleQuery( MM_currentIssueID(), 'center' )); ?>
    </div>
  </div>

  <div id="rightColumn" class="column">
    <?php get_sidebar(); ?>
    <?php MM_homepageBox(MM_homepageStyleQuery( MM_currentIssueID(), 'right' )); ?>
  </div>

</div>

<?php get_footer(); ?>
