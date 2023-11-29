 (function ($, Drupal) {
  Drupal.behaviors.magnetInventoryBehavior = {

    attach: function(context, settings) {


      $('#inventory-add.active', context).once().click(function(e) {
      //$(document).on('click', '#inventory-add.active', function(e) {

        nid = $(this).data('nid');
        $('.loader').show();
        e.preventDefault();

        url = '/magnet/inventory-add/' + nid;
        $.ajax
            ({ 
              url: url,
              type: 'post',
              success: function(result)  {
                $('.loader').hide();
                $('#inventory-add').hide();
                $('#inventory-add-done').show();
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
