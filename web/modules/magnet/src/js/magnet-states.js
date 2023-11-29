(function ($, Drupal) {
  Drupal.behaviors.magnetStatesBehavior = {

    attach: function(context, settings) {


      //$('#pickup a', context).once().click(function(e) {
      $(document).once('magnetStatesBehavior').on('click', '#pickup a', function(e) {

        $(this).hide();
        $('.loader').show();
        e.preventDefault();

        url = $(this).attr('href');
        $.ajax
            ({ 
              url: url,
              type: 'post',
              success: function(result)  {
                $('.loader').hide();
                $('#states-wrapper').html(result);
              }
            });
      })


      $(document).once('magnetStatesBehaviorDrop').on('click', '#drop-state a', function(e) {

        $(this).hide();
        $('.drop-loader').show();
        e.preventDefault();

        url = $(this).attr('href');
        $.ajax
            ({ 
              url: url,
              type: 'post',
              success: function(result)  {
                $('.loader').hide();
                $('#states-wrapper').html(result);
              }
            });

      })


    },
    detach: function(context, settings, trigger) {
      $('.example', context).removeOnce('magnetStatesBehavior').each(function() {
        // Undo stuff.
      });
    }

  };
}(jQuery, Drupal, drupalSettings));
