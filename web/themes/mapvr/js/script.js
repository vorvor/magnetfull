(function ($, Drupal, cookies) {
  Drupal.behaviors.magnetBehavior = {

    attach: function(context, settings) {

      const elements = once('magnet-behaviour', '#block-mapvr-content', context);
      $(elements).each(function () {
      //$(window).once('magnetBehavior').each(function() {
        if (document.referrer == '' && window.location.href.split('://')[1].split('/')[1].length == 0) {
          console.log('hey!');
          window.location.href = Cookies.get('currenturl');
        }

        Cookies.set('currenturl', window.location.href);

        $.expr[":"].contains = $.expr.createPseudo(function(arg) {
            return function( elem ) {
                return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
            };
        });

        let searchParams = new URLSearchParams(window.location.search);

        if (searchParams.has('search_api_fulltext')) {
          let param = searchParams.get('search_api_fulltext');
          found = $('td:contains("' + param + '")');

          found.each(function() {
            txt = $(this).html();
            pos = txt.toLowerCase().indexOf(param.toLowerCase());
            word = txt.substring(pos, pos + param.length);
            txt = txt.replace(new RegExp(param, 'ig'), '<span class="highlighted-search-result">' + word + '</span>');
            $(this).html(txt);
          })

        }

        $('#edit-search-api-fulltext').attr('placeholder', 'site wide search');

        // Show finished products on facet search.
        setTimeout(function() {
          if (Cookies.get('show-finished') == 0) {
            $('#state-exclude-packaging-finished').click().css('color', 'red');
          }
        }, 1500)


      })

      $(once('bind-click-event', '#show-finished-products', context)).each(function() {

        if (Cookies.get('show-finished') == 1) {
          $('#show-finished-products #finished-inside').html('Hide finished products');
          $('#show-finished-products').addClass('hider');
        }

        if (Cookies.get('show-finished') == 0) {
          $('#show-finished-products #finished-inside').html('Show finished products');
          $('#show-finished-products').removeClass('hider');
        }

        $(this).click(function() {

          if ($(this).hasClass('hider')) {
            $(this).removeClass('hider');
            $('#finished-inside', this).html('Show finished products');
            Cookies.set('show-finished', '0');
            location.reload();
          } else {
            $('#finished-inside', this).html('Hide finished products');
            $(this).addClass('hider');
            Cookies.set('show-finished', '1');
            location.reload();
          }
        })
      })



    },
    detach: function(context, settings, trigger) {
      const removedElements = once.remove('magnetBehavior', '.example', context);
      $(removedElements).each(function () {
      })
    }

  };
}(jQuery, Drupal, drupalSettings));
