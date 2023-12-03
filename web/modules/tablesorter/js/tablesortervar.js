/**
 * @file
 * Plugin jQuery Tablesorter.
 */

(function ($, Drupal, drupalSettings) {
  'use strict';

  Drupal.behaviors.tablesorter = {
    attach: function (context, settings) {
      var widgets = [];
      var widgetsZebra = [];

      if (settings.tablesorter) {
        if (settings.tablesorter.zebra == 1) {
          widgets.push('zebra');
        }
        widgetsZebra.push(settings.tablesorter.odd);
        widgetsZebra.push(settings.tablesorter.even);
      }

      // Loop through each tablesorter and activate jQuery plugin.
      $('table.tablesorter').each(function (idx, table) {
        $(table).tablesorter({
          widgets: widgets,
          widgetsZebra: {
            css: widgetsZebra
          }
        });
        if ($("#tablesorter_pager").length != 0) {
          $(table).tablesorterPager({
            container: $("#tablesorter_pager")
          });
        }
      });
    }
  };
})(jQuery, Drupal);
