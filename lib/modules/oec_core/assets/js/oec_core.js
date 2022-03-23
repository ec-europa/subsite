(function ($, window) {
  Drupal.behaviors.OecCore = {
    attach: function (context) {
      var $Window = $(window);

      $Window.on('load', function () {

        // Debounce function.
        function debounce(func, wait, immediate) {
          var timeout;
          return function () {
            var context = this, args = arguments;
            var later = function () {
              timeout = null;
              if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
          };
        }

        // Globan block.
        var $globanBlock = $('.globan', context);
        var globanContent = $globanBlock.find('a[aria-controls]');

        globanContent.on('click', function () {
          $globanBlock.attr('style', 'z-index: 1031 !important');
        });

        function globanBlockBehaviour() {
          var $globanBlockHeight = $globanBlock.height();
          var $navBarFixed = $('.navbar-fixed-top');
          var $headerTop = $('.header-top');
          var $mainContainer = $('.main-container');

          if ($globanBlock && $headerTop.length === 0) {
            $navBarFixed.css({'position': 'fixed', 'top': $globanBlockHeight});

            function contentBehaviour() {
              if ($Window.scrollTop() > $globanBlockHeight) {
                $navBarFixed.css({'position': 'fixed', 'top': '0'});
              } else {
                $navBarFixed.css({'position': 'absolute', 'top': $globanBlockHeight});
              }
            }

            if (!$globanBlock.hasClass('fixed')) {
              contentBehaviour();

              $Window.on("scroll", function () {
                contentBehaviour();
              });
            } else {
              $mainContainer.css('top', $globanBlockHeight);
            }
          }
          else {
            if ($globanBlock.hasClass('fixed')) {
              $('.dialog-off-canvas-main-canvas').css({'position': 'relative', 'top': $globanBlockHeight});
            }
          }
        }

        globanBlockBehaviour();

        // Use debounce function for checking current height of the Globan block.
        var checkCurrentHeight = debounce(function () {
          globanBlockBehaviour();
        }, 250);

        window.addEventListener('resize', checkCurrentHeight);
      });

      var $body = $('body');

      $body.once('OecCore').on('click', '.dropdown-toggle', function() {
        $('.navbar-collapse').collapse('hide');

        var headerDropDown = $('.header-top .dropdown');

        setTimeout(function () {
          if(headerDropDown.hasClass('open')) {
            $body.addClass('open-dropdown-menu');
          } else {
            $body.removeClass('open-dropdown-menu');
          }
        }, 0);
      });
    }
  };
})(jQuery, window);
