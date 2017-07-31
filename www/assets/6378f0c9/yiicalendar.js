

!function($)
{
    $.fn.yiicalendar = function()
    {
        this.on('click', '.navigation-link', function()
        {
            $('table.yiicalendar').css('opacity', 0.1);

            $.ajax
            ({
                'url': $(this).attr('href'),
                'context': $(this).parents('.yiicalendar'),
                'cache': false,
                'success': function(data)
                {
                    var calendarData = $('#' + this.attr('id'), data);

                    this.html(calendarData.html());

                    $('table.yiicalendar').css('opacity', 1);
                }
            });

            return false;
        });
    }
}(window.jQuery);