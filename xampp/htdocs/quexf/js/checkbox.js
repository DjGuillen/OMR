 $('#test').live('change', function(){
      if ( $(this).is(':checked') ) {
         $('#subject').show();
     } else {
         $('#subject').hide();
     }
 });