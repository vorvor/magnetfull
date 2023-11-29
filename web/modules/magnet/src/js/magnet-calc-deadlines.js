(function ($, Drupal) {
  Drupal.behaviors.magnetCalcDeadlines = {

    attach: function(context, settings) {


      //$('#pickup a', context).once().click(function(e) {

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


        var d = newDate.getDate();
        var m =  newDate.getMonth();
        m += 1;
        var y = newDate.getFullYear();
        if (d < 10) {
            d = "0" + d;
        }
        if (m < 10) {
            m = "0" + m;
        }

        $('#edit-field-date-' + state + '-0-value input').val(y + '-' + m + '-' + d);
      }


      $(document).once('magnetCalcDeadlines').each(function() {
        $('.field--name-field-deadline').append('<div id="calc-deadlines">Calculate deadlines</div>');
      })
        
      $(document).once('magnetStatesBehavior').on('click', '#calc-deadlines', function(e) {

        let date = new Date($('#edit-field-deadline-0-value-date').val());
        if (date == 'Invalid Date') {
          $('#edit-field-deadline-0-value-date').css('border', '4px solid red');

          return false;
        }

        $('#edit-field-deadline-0-value-date').css('border', '1px solid #919297');
        let sumTime = 0;
         $.each(timeframes, function(state, time) {
          sumTime += time * 1;
          console.log(state + ':' + time);
          dateCalc(state, sumTime);
         })

      })



      


    },
    detach: function(context, settings, trigger) {
      $('.example', context).removeOnce('magnetStatesBehavior').each(function() {
        // Undo stuff.
      });
    }

  };
}(jQuery, Drupal, drupalSettings));
