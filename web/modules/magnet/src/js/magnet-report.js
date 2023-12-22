(function ($, Drupal) {
  Drupal.behaviors.magnetReport = {

    attach: function(context, settings) {

      const elements = once('magnetReport', '#magnet-report', context);
      elements.forEach(function (element) {
        console.log('report js appendded.');

        drawDiagram(drupalSettings.magnet.datasets.dataset);
        console.log(drupalSettings.magnet.datasets.dataset);
        function drawDiagram(dataSets) {

          const colorDefault = '54, 162, 235';
          const colorList = [
            '240,50,50',
            '255,180,50',
            '255,220,90',
            '100,210,80',
            '90,165,255',
            '170,90,240',
            '180,180,180',
            '110,110,110',
            '170,150,110',
            '130,50,20',
          ];

          let dataPattern = {
            data: [],
            label: 'label placeholder',
            fill: true,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgb(54, 162, 235)',
            pointBackgroundColor: 'rgb(54, 162, 235)',
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgb(54, 162, 235)',
          };

          let dataObject = [];
          let l = 0;
          let color = 0;
          for (let i in dataSets) {
            let copy = Object.assign({}, dataPattern);
            copy.data = Object.values(dataSets[i].count);
            copy.label = dataSets[i].name;
            (colorList[l] == undefined) ? color = colorDefault : color = colorList[l];
            copy.backgroundColor = 'rgba(' + color + ', 0.4)';
            copy.borderColor = 'rgba(' + color + ')';
            copy.pointBackgroundColor = 'rgba(' + color + ')';
            dataObject.push(copy);
            l++;
          }

          console.log(dataObject);

          const data = {
            labels: drupalSettings.magnet.datasets.chart_labels,
            datasets: dataObject,
            options: {
              responsive: true,
              maintainAspectRatio: false,
            }
          };

          const config = {
            type: 'line',
            data: data,

          };

          chartStatus = Chart.getChart('canvas2');

          if (chartStatus !== undefined) {
            chartStatus.destroy();
          }

          var ctx = $('#canvas2');
          var myChart = new Chart(
            ctx,
            config
          );

          // Hide all diagram as default.
          for (let i = 0; i < l; i++) {
            myChart.hide(i);
          }

        }

      })

      state-change-report-per-products

    },
    detach: function(context, settings, trigger) {
      const removedElements = once.remove('magnetReport', '.example', context);
      $(removedElements).each(function () {
      })
    }

  };
}(jQuery, Drupal, drupalSettings));
