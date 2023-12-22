(function ($, Drupal) {
  Drupal.behaviors.magnetCalendarBehavior = {

    attach: function(context, settings) {

      //$('.calendar-buttons', context).once().click(function(e) {

        once('magnetCalendarBehavior','.calendar-buttons', context).forEach(function(e) {
          e.onclick = function (e) {

            if (!$(this).hasClass('active')) {
              $(this).addClass('active');
            } else {
              $(this).removeClass('active');
            }

            if ($(this).attr('id') == 'button-dreams') {
              $('.deadline-bars').slideToggle();
            }

            if ($(this).attr('id') == 'button-reality') {
              $('.revision-bars').slideToggle();
            }

            if ($('.calendar-buttons.active').length == 1) {

              $('.state-label').each(function () {
                height = parseFloat($(this).css('font-size')) / 1.5;
                $(this).css('font-size', height + 'px');
              })
            } else {
              $('.state-label').each(function () {
                height = parseFloat($(this).css('font-size')) * 1.5;
                $(this).css('font-size', height + 'px');
              })
            }
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
