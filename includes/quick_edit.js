(function($) {

   // we create a copy of the WP inline edit post function
   var $wp_inline_edit = inlineEditPost.edit;
   // and then we overwrite the function with our own code
   inlineEditPost.edit = function( id ) {

      // "call" the original WP edit function
      // we don't want to leave WordPress hanging
      $wp_inline_edit.apply( this, arguments );

      // now we take care of our business

      // get the post ID
      var $post_id = 0;
      if ( typeof( id ) == 'object' )
         $post_id = parseInt( this.getId( id ) );

      if ( $post_id > 0 ) {

         // define the edit row
         var $edit_row = $( '#edit-' + $post_id );

         // get the custom quick edit fields
         var $MM_homepageSetup_column = $( '#MM_column-' + $post_id ).text();
         var $MM_homepageSetup_rank = $( '#MM_rank-' + $post_id ).text();

         document.write($edit_row);
         document.write($MM_homepageSetup_column);

         // populate the custom quick edit fields
         $edit_row.find( 'input[name="MM_homepageSetup_column"]' ).val( $MM_homepageSetup_column );
         $edit_row.find( 'input[name="MM_homepageSetup_rank"]' ).val( $MM_homepageSetup_rank );

      }

   };

   $( '#bulk_edit' ).live( 'click', function() {

      // define the bulk edit row
      var $bulk_row = $( '#bulk-edit' );

      // get the selected post ids that are being edited
      var $post_ids = new Array();
      $bulk_row.find( '#bulk-titles' ).children().each( function() {
         $post_ids.push( $( this ).attr( 'id' ).replace( /^(ttle)/i, '' ) );
      });

      // get the release date
      var $MM_homepageSetup_column = $bulk_row.find( 'input[name="MM_homepageSetup_column"]' ).val();
      var $MM_homepageSetup_row = $bulk_row.find( 'input[name="MM_homepageSetup_row"]' ).val();

      // save the data
      $.ajax({
         url: ajaxurl, // this is a variable that WordPress has already defined for us
         type: 'POST',
         async: false,
         cache: false,
         data: {
            action: 'MM_save_bulk_edit', // this is the name of our WP AJAX function that we'll set up next
            post_ids: $post_ids, // and these are the 2 parameters we're passing to our function
            MM_homepageSetup_column: $MM_homepageSetup_column
            MM_homepageSetup_rank: $MM_homepageSetup_rank
         }
      });

   });

})(jQuery);