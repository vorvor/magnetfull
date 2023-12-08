(function ($, Drupal) {
  Drupal.behaviors.magnetMyworksBehavior = {

    attach: function(context, settings) {


      //$('#pickup a', context).once().click(function(e) {
      // $(document).on('click', '.pickup-from-list', function(e) {
      $('.pickup-from-list', context).once().click(function() {

        console.log('once?');

        $(this).parent().hide();
        let parentrow = $(this).parent().parent();
        let picked = parentrow.html();
        $('.view-display-id-page_2 tbody').prepend('<tr class="picked-up">' + picked + '</tr>');
        parentrow.remove();


        let nid = $(this).data('nid');

        console.log(nid);

        $('html, body').animate({
          scrollTop: $('.pickup-from-list[data-nid="' + nid +'"]').parent().parent().offset().top
        }, 2000);


        let url = '/magnet/setnextstate/' + nid;
        $.ajax
            ({
              url: url,
              type: 'post',
              success: function(result)  {
                console.log('success.' + url);
                //  location.reload(true);
              }
        });

      })
    },
    detach: function(context, settings, trigger) {
      $('.example', context).removeOnce('magnetMyworksBehavior').each(function() {
        // Undo stuff.
      });
    }

  };
}(jQuery, Drupal, drupalSettings));
