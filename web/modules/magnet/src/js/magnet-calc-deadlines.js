(function ($, Drupal) {
  Drupal.behaviors.magnetCalcDeadlines = {

    attach: function(context, settings) {

      let timeframes = drupalSettings.magnet.timeframes;

      function dateCalc(state, time) {

        state = state.replace(/_/g, '-');
        console.log(state);
        if (state == 'tunings-and-heat-treatments') {
          state = 'tunings-and-heat';
        }

        let date = new Date($('#edit-field-deadline-0-value-date').val());
        let newDate = new Date(date);
        newDate.setDate(date.getDate() - time);


        let d = newDate.getDate();
        let m =  newDate.getMonth();
        m += 1;
        let y = newDate.getFullYear();
        if (d < 10) {
            d = "0" + d;
        }
        if (m < 10) {
            m = "0" + m;
        }

        $('#edit-field-date-' + state + '-0-value input').val(y + '-' + m + '-' + d);
      }

      const elements = once('magnetCalcDeadlines', '#block-claro-content', context);
      elements.forEach(function (element) {
        console.log('appendded.');
        $('.field--name-field-deadline').append('<div id="calc-deadlines">Calculate deadlines</div>');

      })

      once('magnetStatesBehavior','#calc-deadlines', context).forEach(function(e) {
        e.onclick = function (e) {

          let deadlineVal = $('#edit-field-deadline-0-value-date');
          let date = new Date(deadlineVal.val());
          if (date == 'Invalid Date') {
            deadlineVal.css('border', '4px solid red');

            return false;
          }

          deadlineVal.css('border', '1px solid #919297');
          let sumTime = 0;
          $.each(timeframes, function (state, time) {
            sumTime += time * 1;
            console.log(state + ':' + time);
            dateCalc(state, sumTime);
          })
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
