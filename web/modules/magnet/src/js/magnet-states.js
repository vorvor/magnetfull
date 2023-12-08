(function ($, Drupal) {
  Drupal.behaviors.magnetStatesBehavior = {

    attach: function(context, settings) {


      //$('#pickup a', context).once().click(function(e) {
      //$(document).once('magnetStatesBehavior').on('click', '#pickup a', function(e) {

          once('magnetStatesBehavior','#pickup a', context).forEach(function(e) {
            e.onclick = function (e) {


              $(this).hide();
              $('.loader').show();
              e.preventDefault();

              let url = $(this).attr('href');
              $.ajax
              ({
                url: url,
                type: 'post',
                success: function (result) {
                  $('.loader').hide();
                  $('#states-wrapper').html(result);
                  Drupal.attachBehaviors();
                }
              });
            }
      })


      //$(document).once('magnetStatesBehaviorDrop').on('click', '#drop-state a', function(e) {
        once('magnetStatesBehaviorDrop','#drop-state a', context).forEach(function(e) {
          e.onclick = function (e) {

            $(this).hide();
            $('.drop-loader').show();
            e.preventDefault();

            let url = $(this).attr('href');
            $.ajax
            ({
              url: url,
              type: 'post',
              success: function (result) {
                $('.loader').hide();
                $('#states-wrapper').html(result);
                Drupal.attachBehaviors();
              }
            });
          }

      })


    },
    detach: function(context, settings, trigger) {
      const removedElements = once.remove('magnetBehavior', '.example', context);
      $(removedElements).each(function () {
      })
    }

  };
}(jQuery, Drupal, drupalSettings));
