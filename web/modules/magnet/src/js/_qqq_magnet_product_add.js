(function ($, Drupal) {
  Drupal.behaviors.magnetAddProductBehavior = {

    attach: function(context, settings) {

      var scales = drupalSettings.magnet.scales;

      // Fill scale notes with default notes of scale.
      once('magnetAddProductBehavior','#edit-field-scale', context).forEach(function(e) {
        e.onchange = function (e) {
          let scale_notes = scales[$('option:selected', this).text()];
          $('#edit-field-scale-notes-wrapper textarea').val(scale_notes);
        }
      })

      once('magnetAddProductBehavior','#edit-field-custom-scale-notes-value', context).forEach(function(e) {
        e.onclick = function (e) {
          if ($(this).is(':checked')) {
            $('#edit-field-scale-notes-wrapper textarea').prop("disabled", false);
          } else {
            $('#edit-field-scale-notes-wrapper textarea').prop("disabled", true);
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
