'use strict';
(function ($) {

    $(function () {
        $('[data-codeeditor="true"]').each(function() {
            var element = $(this);
            var mode = element.data('mode');
            if (element.length) {
                var editorSettings = wp.codeEditor.defaultSettings ? _.clone(wp.codeEditor.defaultSettings) : {};
                editorSettings.codemirror = _.extend(
                    {},
                    editorSettings.codemirror,
                    {
                        indentUnit: 5,
                        tabSize: 5,
                        mode: mode
                    }
                );
                var editor = wp.codeEditor.initialize(element, editorSettings);
            }

        });


        var datepiker = $('#wpbody').find('input[data-datetime]');
        if (datepiker.length) {
            datepiker.persianDatepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
                initialValueType: 'persian',
                initialValue: false,
                minDate: new persianDate().unix(),
                toolbox: {
                    calendarSwitch: {
                        enabled: false
                    }
                },
                timePicker: {
                    enabled: true,
                    meridiem: {
                        enabled: true
                    }
                }
            });
        }
    });
})(jQuery);