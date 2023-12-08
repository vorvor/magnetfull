 (function ($, Drupal) {
  Drupal.behaviors.magnetInventoryBehavior = {

    attach: function(context, settings) {


      //$('#inventory-add.active', context).once().click(function(e) {
      once('magnetInventoryBehavior','#inventory-add.active', context).forEach(function(e) {
        e.onclick = function (e) {

          let nid = $(this).data('nid');
          $('.loader').show();
          e.preventDefault();

          let url = '/magnet/inventory-add/' + nid;
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
