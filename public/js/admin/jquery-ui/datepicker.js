
$.datepicker._defaults.onAfterUpdate = null;

var datepicker__updateDatepicker = $.datepicker._updateDatepicker;
    $.datepicker._updateDatepicker = function( inst ) {
        datepicker__updateDatepicker.call( this, inst );

        var onAfterUpdate = this._get(inst, 'onAfterUpdate');
        if (onAfterUpdate)
            onAfterUpdate.apply((inst.input ? inst.input[0] : null),
            [(inst.input ? inst.input.val() : ''), inst]);
    }


$(function() {

    var cur = -1, prv = -1;
    $('.jq-date div').datepicker({
        //numberOfMonths: 3,
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy.mm.dd',

        beforeShowDay: function ( date ) {
            return [true, ( (date.getTime() >= Math.min(prv, cur) && date.getTime() <= Math.max(prv, cur)) ? 'date-range-selected' : '')];
        },
        onSelect: function ( dateText, inst ) {
            var d1, d2;

            prv = cur;
            cur = (new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay)).getTime();
            if ( prv == -1 || prv == cur ) {
               prv = cur;
               $('.jq-date input').val( dateText );
            } else {
               d1 = $.datepicker.formatDate( 'yy.mm.dd', new Date(Math.min(prv,cur)), {} );
               d2 = $.datepicker.formatDate( 'yy.mm.dd', new Date(Math.max(prv,cur)), {} );
               $('.jq-date input').val( d1+' — '+d2 );
            }
        },
        onChangeMonthYear: function ( year, month, inst ) {
            //prv = cur = -1;
        },
        onAfterUpdate: function ( inst ) {
            $('<button type="button" class="ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all" data-handler="hide" data-event="click">Done</button>')
                .appendTo($('.jq-date div .ui-datepicker-buttonpane'))
                .on('click', function () { $('.jq-date div').hide(); });
        }
    })
    .position({
        my: 'left top',
        at: 'left bottom',
        of: $('.jq-date input')
    })
    .hide();

    $('.jq-date input').on('focus', function (e) {
        var v = this.value,
            d;

        try {
            if ( v.indexOf(' - ') > -1 ) {
                d = v.split(' - ');
                prv = $.datepicker.parseDate( 'yy.mm.dd', d[0] ).getTime();
                cur = $.datepicker.parseDate( 'yy.mm.dd', d[1] ).getTime();
            } else if ( v.length > 0 ) {
               prv = cur = $.datepicker.parseDate( 'yy.mm.dd', v ).getTime();
            }
        } catch ( e ) {
            cur = prv = -1;
        }

        if ( cur > -1 )
            $('.jq-date div').datepicker('setDate', new Date(cur));
            $('.jq-date div').datepicker('refresh').show();
    });

});

