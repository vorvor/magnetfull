(function ($, Drupal) {
  Drupal.behaviors.magnetAddProductBehavior = {

    attach: function(context, settings) {

      var scales = drupalSettings.magnet.scales;

      // Fill scale notes with default notes of scale.
      $('#edit-field-scale', context).once('magnetAddProductBehavior').change(function() {
        scale_notes = scales[$('option:selected', this).text()];
        $('#edit-field-scale-notes-wrapper textarea').val(scale_notes);
      })

      $('#edit-field-custom-scale-notes-value', context).once('magnetAddProductBehavior').click(function() {
        if ($(this).is(':checked')) {
          $('#edit-field-scale-notes-wrapper textarea').prop("disabled", false);
        } else {
          $('#edit-field-scale-notes-wrapper textarea').prop("disabled", true);
        }
        
      })

    },
    detach: function(context, settings, trigger) {
      $('.example', context).removeOnce('magnetAddProductBehavior').each(function() {
        // Undo stuff.
      });
    }

  };
}(jQuery, Drupal, drupalSettings));
