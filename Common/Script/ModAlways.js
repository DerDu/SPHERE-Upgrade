(function ($)
{
    'use strict';
    $.fn.ModAlways = function ()
    {
        $(document).ready(function ()
        {
            /**
             * Autocomplete Attribute OFF
             */
            $('form').attr('autocomplete', 'off');
            $('input[type="password"]').attr('autocomplete', 'off');
            $('input[type="text"]').attr('autocomplete', 'off');
            $('input[type="number"]').attr('autocomplete', 'off');

            //noinspection FunctionWithInconsistentReturnsJS
            /**
             * Page-Leave Confirmation-Handler
             * @file ModAlways.js, ModForm.js
             */
            $(window).on('beforeunload', function ()
            {
                var closingEvent = $.Event('browser:page:unload');
                // let other modules determine whether to prevent closing
                $(window).trigger(closingEvent);
                if (closingEvent.isDefaultPrevented()) {
                    // closingEvent.message is optional
                    return closingEvent.message || 'Warnung: Die Daten wurden noch nicht gespeichert.';
                }
            });

            /**
             * Activate: Tooltip
             */
            $('[data-toggle="tooltip"]').tooltip({
                container: 'body',
                placement: 'auto top'
            });
            /**
             * Activate: External Link
             */
            $('a[rel="external"]').attr('target', '_blank');
            /**
             * Activate: Source-Code Highlighter
             */
            hljs.initHighlighting();
            /**
             * Activate: iFrame-Styling
             */
            var iFrame = jQuery('iframe.sphere-iframe-style');
            var iStyle = jQuery('link');

            var iRun = function (iFrame)
            {
                iFrame.hide();
                var iContent = iFrame.contents();
                var iHead = iContent.find("head");
                var iBody = iContent.find("body");
                iStyle.each(function (Link)
                {
                    jQuery(iHead).append(jQuery(iStyle[Link]).clone());
                }).promise().done(function ()
                {
                    iFrame.show();
                    // Resize
                    var lastHeight = 0, curHeight = 0;
                    var iSize = setInterval(function ()
                    {
                        curHeight = iFrame.contents().find('body').height();
                        if (curHeight > lastHeight || !curHeight) {
                            iFrame.css('height', (lastHeight = curHeight) + 'px');
                        } else {
                            clearInterval(iSize);
                            iFrame.css('height', (curHeight + 12) + 'px');
                        }
                    }, 100);
                });
                iBody.css('background-color', 'transparent');
            };

            jQuery(iFrame).each(function (Frame)
            {
                jQuery(iFrame[Frame]).before(
                    '<div class="alert alert-danger" >Im folgenden Feld befinden sich externe Inhalte</div>');

                if (
                    jQuery('<a>').prop('href', window.location).prop('hostname')
                    ==
                    jQuery('<a>').prop('href', jQuery(iFrame[Frame]).attr('src')).prop('hostname')
                ) {
                    iRun(jQuery(iFrame[Frame]));
                    jQuery(iFrame[Frame]).on('load', function ()
                    {
                        iRun(jQuery(iFrame[Frame]));
                    });
                } else {
                    jQuery(iFrame[Frame]).show().css({height: '300px'});
                }
            });
        });
        return this;

    };

}(jQuery));
