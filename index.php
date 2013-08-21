
<?php get_header(); ?>

<div id="content" class="clearfloat">

  <div id="twocol">
    <div id="feature" class="column">
      <?php MM_homepageBox(MM_homepageQuery( 'feature' )); ?>
    </div>

    <div>
      <?php if ( is_active_sidebar( 'belowtabbed' ) ) : // Widgetized area below the tabbed content
        dynamic_sidebar( 'belowtabbed' );
        else :
        endif; 
      ?>
    </div>

    <div id="leftcolumn" class="column">
      <?php MM_homepageBox(MM_homepageQuery( 'left' )); ?>
    </div>

    <div id="centercolumn" class="column">
      <?php MM_homepageBox(MM_homepageQuery( 'center' )); ?>
    </div>
  </div>

  <div id="rightcolumn" class="column">
    <div id="issueDate">
      <h1 style="text-align: center;"><?php echo MM_currentIssue() ?></h1>
    </div>
    <?php get_sidebar(); ?>
    <?php MM_homepageBox(MM_homepageQuery( 'right' )); ?>
  </div>

</div>

<?php get_footer(); ?>
