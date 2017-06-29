(function($) {

  $.fn.menumaker = function(options) {
      
      var drtheme = $(this), settings = $.extend({
        title: "Menu",
        format: "dropdown",
        breakpoint: 768,
        sticky: false
      }, options);

      return this.each(function() {
        drtheme.find('li ul').parent().addClass('has-sub');
        if (settings.format != 'select') {
          drtheme.prepend('<div id="menu-button">' + settings.title + '</div>');
          $(this).find("#menu-button").on('click', function(){
            $(this).toggleClass('menu-opened');
            console.log( $(this).parent().find('.menu'));
            var mainmenu = $(this).parent().find('.menu');
            if (mainmenu.hasClass('open')) { 
              mainmenu.hide().removeClass('open');
            }
            else {
              mainmenu.show().addClass('open');
              if (settings.format === "dropdown") {
                mainmenu.find('ul').show();
              }
            }
          });

          multiTg = function() {
            drtheme.find(".has-sub").prepend('<span class="submenu-button"></span>');
            drtheme.find('.submenu-button').on('click', function() {
              $(this).toggleClass('submenu-opened');
              if ($(this).siblings('ul').hasClass('open')) {
                $(this).siblings('ul').removeClass('open').hide();
              }
              else {
                $(this).siblings('ul').addClass('open').show();
              }
            });
          };

          if (settings.format === 'multitoggle') multiTg();
          else drtheme.addClass('dropdown');
        }

        else if (settings.format === 'select')
        {
          drtheme.append('<select style="width: 100%"/>').addClass('select-list');
          var selectList = drtheme.find('select');
          selectList.append('<option>' + settings.title + '</option>', {
                                                         "selected": "selected",
                                                         "value": ""});
          drtheme.find('a').each(function() {
            var element = $(this), indentation = "";
            for (i = 1; i < element.parents('ul').length; i++)
            {
              indentation += '-';
            }
            selectList.append('<option value="' + $(this).attr('href') + '">' + indentation + element.text() + '</option');
          });
          selectList.on('change', function() {
            window.location = $(this).find("option:selected").val();
          });
        }

        if (settings.sticky === true) drtheme.css('position', 'fixed');

        resizeFix = function() {
          if ($(window).width() > settings.breakpoint) {
            drtheme.find('ul').show();
            drtheme.removeClass('small-screen');
            if (settings.format === 'select') {
              drtheme.find('select').hide();
            }
            else {
              drtheme.find("#menu-button").removeClass("menu-opened");
            }
          }

          if ($(window).width() <= settings.breakpoint && !drtheme.hasClass("small-screen")) {
            drtheme.find('ul').hide().removeClass('open');
            drtheme.addClass('small-screen');
            if (settings.format === 'select') {
              drtheme.find('select').show();
            }
          }
        };
        resizeFix();
        return $(window).on('resize', resizeFix);

      });
  };
})(jQuery);