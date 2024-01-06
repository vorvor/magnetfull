 (function ($, Drupal) {
  Drupal.behaviors.magnetNotificationBehavior = {

    attach: function(context, settings) {

      once('magnetNotificationBehavior','#notification-block-footer', context).forEach(function(e) {
        console.log('js loaded.');
        e.onclick = function (e) {
          if ($(this).parent().hasClass('notification-open')) {
            $(this).parent().removeClass('notification-open');
          } else {
            $(this).parent().addClass('notification-open');
          }
        }
      })

    },
    detach: function(context, settings, trigger) {
      const removedElements = once.remove('magnetNotificationBehavior', '.example', context);
      $(removedElements).each(function () {
      })
    }

  };
}(jQuery, Drupal, drupalSettings));
